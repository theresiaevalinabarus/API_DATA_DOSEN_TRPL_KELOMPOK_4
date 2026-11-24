<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $db;

    // Koneksi database
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Menampilkan halaman login Admin
    public function index()
    {
        // Selalu tampilkan halaman login terlebih dahulu
        return view('auth/login');
    }

    // Proses login Admin
    public function login()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username dan password wajib diisi.');
        }

        $admin = $this->db->table('admin')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$admin || !$admin['is_active']) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username atau password tidak sesuai.');
        }

        if (!password_verify($password, $admin['password'])) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Username atau password tidak sesuai.');
        }

        session()->regenerate(true);

        session()->set([
            'isLoggedIn' => true,
            'id_admin' => $admin['id_admin'],
            'nama_admin' => $admin['nama_admin'],
            'username' => $admin['username'],
            'email_admin' => $admin['email']
        ]);

        return redirect()->to(site_url('dashboard'))
            ->with('success', 'Login berhasil. Selamat datang, ' . $admin['nama_admin'] . '!');
    }

    // Logout Admin
    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'))
            ->with('success', 'Anda berhasil logout.');
    }

    // Menampilkan halaman lupa password
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    // Mengirim tautan reset password ke email
    public function sendResetLink()
    {
        $emailAddress = trim((string) $this->request->getPost('email'));

        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Format alamat email tidak valid.');
        }

        $admin = $this->db->table('admin')
            ->where('email', $emailAddress)
            ->where('is_active', true)
            ->get()
            ->getRowArray();

        if (!$admin) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Gmail tidak ditemukan atau akun tidak aktif.');
        }

        // Membuat token acak yang aman
        $token = bin2hex(random_bytes(32));

        // Menyimpan hash token
        $tokenHash = hash('sha256', $token);

        // Token berlaku selama 15 menit
        $expiredAt = date('Y-m-d H:i:s', time() + (15 * 60));

        $updated = $this->db->table('admin')
            ->where('id_admin', $admin['id_admin'])
            ->update([
                'reset_token_hash' => $tokenHash,
                'token_expired_at' => $expiredAt
            ]);

        if (!$updated) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Gagal membuat permintaan reset password.');
        }

        // Membuat tautan reset password
        $resetLink = site_url('reset-password/' . $token);

        // Menyiapkan email
        $email = service('email');
        $email->clear(true);

        $email->setFrom(
            'theresiaevalina@students.polmed.ac.id',
            'Admin Data Dosen TRPL'
        );

        $email->setTo($admin['email']);
        $email->setSubject('Pemulihan Akun Admin Data Dosen TRPL');

        $message = '
            <div style="font-family:Arial,sans-serif;max-width:600px;margin:auto;padding:25px;color:#334155;">

                <h2 style="color:#1d4ed8;">Pemulihan Akun Admin</h2>

                <p>Halo, ' . esc($admin['nama_admin']) . '.</p>

                <p>Kami menerima permintaan pemulihan akun Admin
                Sistem Informasi Data Dosen TRPL.</p>

                <div style="background:#eff6ff;padding:18px;border-radius:10px;">
                    <p><strong>Username Admin:</strong> '
                    . esc($admin['username']) . '</p>

                    <p><strong>Alamat Gmail:</strong> '
                    . esc($admin['email']) . '</p>
                </div>

                <p>Klik tombol berikut untuk membuat password baru:</p>

                <p style="text-align:center;margin:30px 0;">
                    <a href="' . esc($resetLink) . '"
                       style="background:#2563eb;color:white;padding:14px 24px;
                       text-decoration:none;border-radius:8px;font-weight:bold;">
                        Reset Password
                    </a>
                </p>

                <p>Tautan ini hanya berlaku selama <strong>15 menit</strong>.</p>

                <p>Jika kamu tidak meminta pemulihan akun, abaikan email ini.</p>

                <hr>

                <p style="font-size:12px;color:#64748b;">
                    Sistem Informasi Data Dosen TRPL<br>
                    © 2026 Kelompok 4
                </p>
            </div>
        ';

        $email->setMessage($message);

        if (!$email->send()) {
            log_message(
                'error',
                'Pengiriman email reset password gagal: ' .
                $email->printDebugger(['headers'])
            );

            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Email gagal dikirim. Periksa konfigurasi SMTP Gmail.');
        }

        return redirect()->to(site_url('forgot-password'))
            ->with('success', 'Email pemulihan akun berhasil dikirim. Silakan periksa Gmail Admin kamu.');
    }

    // Menampilkan halaman pembuatan password baru
    public function resetPassword($token = null)
    {
        if (empty($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Tautan reset password tidak valid.');
        }

        $tokenHash = hash('sha256', $token);

        $admin = $this->db->table('admin')
            ->where('reset_token_hash', $tokenHash)
            ->where('token_expired_at >', date('Y-m-d H:i:s'))
            ->where('is_active', true)
            ->get()
            ->getRowArray();

        if (!$admin) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Tautan sudah kedaluwarsa atau tidak valid. Silakan minta tautan baru.');
        }

        return view('auth/reset_password', [
            'token' => $token
        ]);
    }

    // Menyimpan password baru
    public function updatePassword($token = null)
    {
        if (empty($token) || !preg_match('/^[a-f0-9]{64}$/', $token)) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Token reset tidak valid.');
        }

        $password = (string) $this->request->getPost('password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if (strlen($password) < 8) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password minimal 8 karakter.');
        }

        if ($password !== $confirmPassword) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Konfirmasi password tidak cocok.');
        }

        $tokenHash = hash('sha256', $token);

        $admin = $this->db->table('admin')
            ->where('reset_token_hash', $tokenHash)
            ->where('token_expired_at >', date('Y-m-d H:i:s'))
            ->where('is_active', true)
            ->get()
            ->getRowArray();

        if (!$admin) {
            return redirect()->to(site_url('forgot-password'))
                ->with('error', 'Tautan reset sudah kedaluwarsa atau tidak valid.');
        }

        $updated = $this->db->table('admin')
            ->where('id_admin', $admin['id_admin'])
            ->update([
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'reset_token_hash' => null,
                'token_expired_at' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Password gagal diperbarui. Silakan coba lagi.');
        }

        return redirect()->to(site_url('login'))
            ->with('success', 'Password berhasil diperbarui. Silakan login menggunakan password baru.');
    }
}
