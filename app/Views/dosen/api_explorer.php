<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .api-page {
        max-width: 1500px;
    }

    .api-intro {
        margin-bottom: 22px;
    }

    .api-intro h2 {
        color: #17365e;
        font-size: 25px;
        font-weight: 800;
    }

    .api-intro p {
        color: #8796aa;
        font-size: 13px;
    }

    .api-card {
        background: #fff;
        border: 1px solid #e9eef6;
        border-radius: 17px;
        padding: 23px;
        box-shadow: 0 5px 22px rgba(25,45,75,.05);
        margin-bottom: 20px;
    }

    .api-card-title {
        display: flex;
        align-items: center;
        gap: 11px;
        font-size: 17px;
        font-weight: 800;
        color: #17365e;
        margin-bottom: 20px;
    }

    .api-icon {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #eaf1ff;
        color: #2864e8;
        font-size: 18px;
    }

    .request-row {
        display: grid;
        grid-template-columns: 125px minmax(0, 1fr) 110px;
        gap: 10px;
    }

    .request-row .form-select,
    .request-row .form-control {
        min-height: 48px;
        border-radius: 10px;
        font-weight: 600;
    }

    .method-select {
        font-weight: 800 !important;
        color: #16834c;
    }

    .btn-send {
        background: #2864e8;
        border: none;
        color: #fff;
        font-weight: 700;
        border-radius: 10px;
    }

    .btn-send:hover {
        background: #174fc9;
        color: #fff;
    }

    .quick-label {
        font-size: 12px;
        font-weight: 700;
        color: #8796aa;
        margin: 20px 0 10px;
    }

    .quick-btn {
        border: 1px solid #e0e9f8;
        background: #f5f8ff;
        color: #2458b8;
        border-radius: 9px;
        padding: 10px 13px;
        font-size: 12px;
        font-weight: 700;
        margin: 0 7px 7px 0;
    }

    .quick-btn:hover {
        background: #e8efff;
    }

    .response-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 17px;
    }

    .response-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .response-status {
        background: #e2f8ec;
        color: #16834c;
        padding: 7px 13px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
    }

    .response-status.error {
        background: #fff0f0;
        color: #d13b3b;
    }

    .response-info {
        color: #71819a;
        font-size: 12px;
        font-weight: 600;
    }

    .response-tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid #e9eef6;
        margin-bottom: 15px;
    }

    .response-tab {
        border: 0;
        background: transparent;
        color: #70819a;
        padding: 11px 17px;
        font-weight: 700;
        font-size: 12px;
        border-radius: 9px 9px 0 0;
    }

    .response-tab.active {
        background: #2864e8;
        color: #fff;
    }

    .response-code {
        background: #172337;
        color: #d8e5f5;
        border-radius: 12px;
        padding: 20px;
        min-height: 220px;
        max-height: 520px;
        overflow: auto;
        font-size: 12px;
        line-height: 1.8;
        white-space: pre-wrap;
        overflow-wrap: anywhere;
        font-family: Consolas, monospace;
    }

    .response-table-wrap {
        overflow-x: auto;
    }

    .response-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .response-table th,
    .response-table td {
        border: 1px solid #e9eef6;
        padding: 10px;
        text-align: left;
    }

    .response-table th {
        background: #f3f6fc;
        color: #52627a;
    }

    .empty-response {
        text-align: center;
        color: #8796aa;
        padding: 60px 15px;
    }

    .empty-response .empty-icon {
        font-size: 35px;
        margin-bottom: 12px;
    }

    .request-body {
        display: none;
        margin-top: 18px;
    }

    .request-body.show {
        display: block;
    }

    .request-body textarea {
        min-height: 160px;
        font-family: Consolas, monospace;
        font-size: 12px;
    }

    .response-copy {
        border: 1px solid #dce4ef;
        background: #fff;
        color: #52627a;
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .api-key-box {
        margin-top: 18px;
        padding: 16px;
        border: 1px solid #e0e9f8;
        border-radius: 12px;
        background: #f8faff;
    }

    .api-key-box label {
        font-weight: 800;
        color: #17365e;
    }

    .api-key-box input {
        min-height: 45px;
        border-radius: 9px;
    }

    @media(max-width: 700px) {
        .request-row {
            grid-template-columns: 1fr;
        }

        .api-card {
            padding: 16px;
        }

        .api-intro h2 {
            font-size: 21px;
        }
    }
</style>

<div class="api-page">

    <div class="api-intro">
        <h2>🔌 <?= esc($heading ?? 'API Explorer') ?></h2>
        <p><?= esc($pageDescription ?? 'Uji dan panggil endpoint API.') ?></p>
    </div>

    <!-- REQUEST CARD -->
    <div class="api-card">

        <div class="api-card-title">
            <div class="api-icon">➤</div>
            API Request
        </div>

        <form id="apiRequestForm"
              action="<?= site_url('api-explorer/send') ?>"
              method="post">

            <?= csrf_field() ?>

            <!-- METHOD DAN URL -->
            <div class="request-row">

                <select
                    name="method"
                    id="method"
                    class="form-select method-select">

                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                    <option value="PUT">PUT</option>
                    <option value="PATCH">PATCH</option>
                    <option value="DELETE">DELETE</option>
                    <option value="HEAD">HEAD</option>
                    <option value="OPTIONS">OPTIONS</option>

                </select>

                <input
                    type="url"
                    name="url"
                    id="endpointUrl"
                    class="form-control"
                    placeholder="Masukkan URL endpoint API..."
                    value="<?= esc($defaultUrl ?? $group4Url) ?>"
                    required>

                <button
                    type="submit"
                    class="btn btn-send"
                    id="sendButton">

                    <span id="sendText">➤ Send</span>

                </button>

            </div>

            <!-- API KEY -->
            <div class="api-key-box">

                <label for="api_key" class="form-label">
                    🔐 API Key Kelompok 4
                </label>

                <input
                    type="password"
                    name="api_key"
                    id="api_key"
                    class="form-control"
                    placeholder="Masukkan API Key..."
                    autocomplete="off">

                <small class="text-muted d-block mt-2">
                    Kosongkan untuk akses publik terbatas.
                    API Key yang benar diperlukan untuk akses lengkap,
                    POST, PUT, dan DELETE.
                </small>

            </div>

            <!-- REQUEST BODY -->
            <div class="request-body" id="requestBody">

                <label class="form-label fw-bold mt-3">
                    Request Body (JSON)
                </label>

                <textarea
                    name="body"
                    id="bodyInput"
                    class="form-control"
                    placeholder='{
    "kode_dosen": "D033",
    "nip": "123456789",
    "nama": "Nama Dosen"
}'></textarea>

                <small class="text-muted">
                    Gunakan format JSON yang sesuai dengan endpoint tujuan.
                </small>

            </div>

        </form>

        <!-- ENDPOINT CEPAT -->
        <div class="quick-label">
            ENDPOINT CEPAT
        </div>

        <button
            type="button"
            class="quick-btn"
            data-url="<?= esc($group4Url) ?>">

            👨‍🏫 GET Dosen - Kelompok 4

        </button>

        <?php if (!empty($group3Url)): ?>

            <button
                type="button"
                class="quick-btn"
                data-url="<?= esc($group3Url) ?>">

                📚 GET Mata Kuliah - Kelompok 3

            </button>

        <?php else: ?>

            <span class="text-muted small">
                URL Kelompok 3 belum dikonfigurasi.
            </span>

        <?php endif; ?>

    </div>

    <!-- RESPONSE CARD -->
    <div class="api-card">

        <div class="response-top">

            <div class="api-card-title mb-0">
                <div class="api-icon">{ }</div>
                Response
            </div>

            <div class="response-meta">

                <span
                    class="response-status"
                    id="responseStatus">
                    Belum ada request
                </span>

                <span class="response-info" id="responseDuration">
                    Waktu: -
                </span>

                <span class="response-info" id="responseSize">
                    Ukuran: -
                </span>

            </div>

        </div>

        <!-- TAB RESPONSE -->
        <div class="response-tabs">

            <button
                type="button"
                class="response-tab active"
                data-tab="json">
                JSON
            </button>

            <button
                type="button"
                class="response-tab"
                data-tab="table">
                Tabel
            </button>

            <button
                type="button"
                class="response-tab"
                data-tab="raw">
                Raw
            </button>

        </div>

        <div id="responseContent">

            <div class="empty-response">
                <div class="empty-icon">📡</div>
                <strong>Belum ada response</strong>
                <p class="small mb-0">
                    Masukkan URL endpoint lalu klik Send.
                </p>
            </div>

        </div>

        <div class="d-flex justify-content-end mt-3">

            <button
                type="button"
                class="response-copy"
                id="copyResponse"
                disabled>
                📋 Salin Response
            </button>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('apiRequestForm');
    const method = document.getElementById('method');
    const urlInput = document.getElementById('endpointUrl');
    const bodyInput = document.getElementById('bodyInput');

    const requestBody = document.getElementById('requestBody');
    const sendButton = document.getElementById('sendButton');
    const sendText = document.getElementById('sendText');

    const responseStatus = document.getElementById('responseStatus');
    const responseDuration = document.getElementById('responseDuration');
    const responseSize = document.getElementById('responseSize');
    const responseContent = document.getElementById('responseContent');

    const copyButton = document.getElementById('copyResponse');

    let currentResponse = '';
    let parsedResponse = null;
    let currentTab = 'json';

    // =====================================
    // TAMPILKAN REQUEST BODY
    // =====================================

    function updateBodyVisibility() {

        const selected = method.value;

        requestBody.classList.toggle(
            'show',
            selected === 'POST' ||
            selected === 'PUT' ||
            selected === 'PATCH'
        );
    }

    method.addEventListener('change', updateBodyVisibility);
    updateBodyVisibility();

    // =====================================
    // ENDPOINT CEPAT
    // =====================================

    document.querySelectorAll('.quick-btn').forEach(function (button) {

        button.addEventListener('click', function () {

            urlInput.value = this.dataset.url;
            method.value = 'GET';
            bodyInput.value = '';

            updateBodyVisibility();

        });

    });

    // =====================================
    // RENDER JSON
    // =====================================

    function renderJson(data) {

        const pre = document.createElement('pre');

        pre.className = 'response-code';

        pre.textContent = typeof data === 'string'
            ? data
            : JSON.stringify(data, null, 4);

        responseContent.replaceChildren(pre);
    }

    // =====================================
    // RENDER RAW
    // =====================================

    function renderRaw(data) {

        const pre = document.createElement('pre');

        pre.className = 'response-code';
        pre.textContent = currentResponse;

        responseContent.replaceChildren(pre);
    }

    // =====================================
    // RENDER TABEL
    // =====================================

    function renderTable(data) {

        let rows = [];

        if (Array.isArray(data)) {
            rows = data;

        } else if (data && Array.isArray(data.data)) {
            rows = data.data;

        } else if (data && typeof data === 'object') {
            rows = [data];
        }

        if (rows.length === 0 || typeof rows[0] !== 'object') {

            responseContent.textContent =
                'Data tidak tersedia dalam format tabel.';

            return;
        }

        const columns = [
            ...new Set(rows.flatMap(row => Object.keys(row)))
        ];

        const wrapper = document.createElement('div');
        wrapper.className = 'response-table-wrap';

        const table = document.createElement('table');
        table.className = 'response-table';

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');

        columns.forEach(function (column) {

            const th = document.createElement('th');

            th.textContent = column;

            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');

        rows.forEach(function (row) {

            const tr = document.createElement('tr');

            columns.forEach(function (column) {

                const td = document.createElement('td');
                const value = row[column];

                td.textContent =
                    value !== null && typeof value === 'object'
                        ? JSON.stringify(value)
                        : String(value ?? '');

                tr.appendChild(td);
            });

            tbody.appendChild(tr);
        });

        table.appendChild(tbody);
        wrapper.appendChild(table);

        responseContent.replaceChildren(wrapper);
    }

    // =====================================
    // RENDER TAB
    // =====================================

    function renderCurrentTab() {

        if (currentTab === 'raw') {

            renderRaw(parsedResponse);

        } else if (currentTab === 'table') {

            renderTable(parsedResponse);

        } else {

            renderJson(parsedResponse);
        }
    }

    // =====================================
    // PILIHAN TAB RESPONSE
    // =====================================

    document.querySelectorAll('.response-tab').forEach(function (tab) {

        tab.addEventListener('click', function () {

            document.querySelectorAll('.response-tab').forEach(
                item => item.classList.remove('active')
            );

            this.classList.add('active');

            currentTab = this.dataset.tab;

            if (currentResponse !== '') {
                renderCurrentTab();
            }

        });

    });

    // =====================================
    // KIRIM REQUEST
    // =====================================

    form.addEventListener('submit', async function (event) {

        event.preventDefault();

        if (!urlInput.value.trim()) {
            alert('Masukkan URL endpoint terlebih dahulu.');
            return;
        }

        sendButton.disabled = true;
        sendText.textContent = 'Mengirim...';

        responseStatus.textContent = 'Loading...';
        responseStatus.className = 'response-status';

        responseContent.innerHTML = `
            <div class="empty-response">
                <div class="empty-icon">⏳</div>
                Sedang memanggil endpoint API...
            </div>
        `;

        copyButton.disabled = true;

        try {

            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            currentResponse = result.body ?? '';
            parsedResponse = currentResponse;

            try {

                parsedResponse = JSON.parse(currentResponse);

            } catch (error) {

                // Respons bukan JSON, tetap tampilkan sebagai teks.

            }

            const status = Number(result.status || 0);

            responseStatus.textContent = status
                ? `${status} ${result.reason || ''}`
                : (result.reason || 'Request Error');

            responseStatus.className =
                status >= 200 && status < 300
                    ? 'response-status'
                    : 'response-status error';

            responseDuration.textContent =
                `Waktu: ${result.duration ?? 0} ms`;

            responseSize.textContent =
                `Ukuran: ${result.size ?? 0} bytes`;

            renderCurrentTab();

            copyButton.disabled = currentResponse === '';

        } catch (error) {

            currentResponse = error.message;
            parsedResponse = error.message;

            responseStatus.textContent = 'Connection Error';
            responseStatus.className = 'response-status error';

            responseContent.textContent = error.message;

        } finally {

            sendButton.disabled = false;
            sendText.textContent = '➤ Send';

        }

    });

    // =====================================
    // SALIN RESPONSE
    // =====================================

    copyButton.addEventListener('click', async function () {

        if (!currentResponse) return;

        try {

            await navigator.clipboard.writeText(currentResponse);

            copyButton.textContent = '✓ Tersalin';

            setTimeout(() => {

                copyButton.textContent = '📋 Salin Response';

            }, 1500);

        } catch (error) {

            alert('Tidak dapat menyalin response.');

        }

    });

});
</script>

<?= $this->endSection() ?>