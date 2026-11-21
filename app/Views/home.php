
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TRPL Polmed | Sistem Informasi Data Dosen</title>
    <meta name="description" content="Sistem Informasi Data Dosen Program Studi Teknologi Rekayasa Perangkat Lunak Politeknik Negeri Medan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #10254b;
            --navy-light: #193d70;
            --blue: #2563eb;
            --blue-light: #60a5fa;
            --light-blue: #eaf2ff;
            --text: #172b4d;
            --muted: #64748b;
            --white: #ffffff;
            --bg: #f8faff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            color: var(--text);
            background: white;
            overflow-x: hidden;
            font-size: 16px;
            line-height: 1.8;
        }

        a {
            text-decoration: none;
        }

        button {
            font-family: inherit;
        }

        .container {
            width: min(1160px, 90%);
            margin: auto;
        }

        /* =========================
           LOADING SCREEN
        ========================= */

        .page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 18px;
            transition: opacity .6s ease, visibility .6s ease;
        }

        .page-loader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .loader-logo {
            width: 70px;
            height: 70px;
            display: grid;
            place-items: center;
            background: white;
            color: var(--blue);
            font-size: 32px;
            font-weight: 800;
            border-radius: 20px;
            animation: loaderPulse 1.2s infinite;
        }

        .loader-text {
            color: white;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .loader-line {
            width: 140px;
            height: 4px;
            background: rgba(255,255,255,.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-line::after {
            content: "";
            display: block;
            width: 45%;
            height: 100%;
            background: #60a5fa;
            animation: loading 1s infinite ease-in-out;
        }

        @keyframes loading {
            from { transform: translateX(-100%); }
            to { transform: translateX(230%); }
        }

        @keyframes loaderPulse {
            50% { transform: scale(1.1) rotate(5deg); }
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 85px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid #edf1f7;
            transition: .3s;
        }

        .navbar.scrolled {
            box-shadow: 0 8px 25px rgba(15,23,42,.09);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand-logo {
            width: 49px;
            height: 49px;
            background: linear-gradient(135deg, #10254b, #2563eb);
            color: white;
            display: grid;
            place-items: center;
            border-radius: 14px;
            font-size: 23px;
            font-weight: 800;
            box-shadow: 0 7px 18px rgba(37,99,235,.2);
            transition: .3s;
        }

        .brand:hover .brand-logo {
            transform: rotate(-8deg) scale(1.08);
        }

        .brand-name strong {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 19px;
            color: var(--navy);
            line-height: 1.4;
        }

        .brand-name span {
            font-size: 12px;
            color: var(--muted);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-links a {
            font-size: 15px;
            font-weight: 700;
            color: #475569;
            transition: .25s;
        }

        .nav-links a:hover {
            color: var(--blue);
        }

        .nav-links .nav-login {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 13px 23px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(37,99,235,.2);
        }

        .nav-links .nav-login:hover {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 9px 20px rgba(37,99,235,.3);
        }

        .menu-toggle {
            display: none;
            border: none;
            background: none;
            font-size: 28px;
            color: var(--navy);
            cursor: pointer;
        }

        /* =========================
           HERO SECTION
        ========================= */

        .hero {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            padding: 125px 0 140px;
            background:
                radial-gradient(circle at 85% 20%, rgba(59,130,246,.22), transparent 30%),
                linear-gradient(120deg, #f8fbff, #eaf2ff);
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 460px;
            height: 460px;
            border: 1px solid rgba(37,99,235,.13);
            border-radius: 50%;
            right: -110px;
            top: -160px;
            animation: rotateCircle 25s linear infinite;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 310px;
            height: 310px;
            border-radius: 50%;
            background: rgba(96,165,250,.2);
            filter: blur(60px);
            left: -100px;
            bottom: -100px;
            animation: glowMove 8s ease-in-out infinite alternate;
            z-index: -1;
        }

        @keyframes rotateCircle {
            to { transform: rotate(360deg); }
        }

        @keyframes glowMove {
            to { transform: translate(100px,-60px); }
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            align-items: center;
            gap: 55px;
            position: relative;
            z-index: 1;
        }

        .hero-content {
            animation: slideLeft 1s ease both;
        }

        @keyframes slideLeft {
            from {
                opacity: 0;
                transform: translateX(-45px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #dceaff;
            color: #1d4ed8;
            border-radius: 30px;
            padding: 12px 19px;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 27px;
        }

        .eyebrow span {
            width: 9px;
            height: 9px;
            background: #2563eb;
            border-radius: 50%;
            animation: pulse 1.8s infinite;
        }

        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(37,99,235,.4); }
            50% { box-shadow: 0 0 0 8px rgba(37,99,235,0); }
        }

        .hero h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--navy);
            font-size: clamp(44px, 5.5vw, 68px);
            line-height: 1.2;
            letter-spacing: -2px;
            margin-bottom: 25px;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--blue);
        }

        .hero-description {
            font-size: 17px;
            line-height: 2;
            color: var(--muted);
            max-width: 620px;
            margin-bottom: 35px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 17px 27px;
            border-radius: 11px;
            font-size: 15px;
            font-weight: 800;
            transition: .3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 8px 20px rgba(37,99,235,.2);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 13px 25px rgba(37,99,235,.3);
        }

        .btn-outline {
            border: 1px solid #cbd5e1;
            color: var(--navy);
            background: white;
        }

        .btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            transform: translateY(-5px);
        }

        /* =========================
           HERO VISUAL
        ========================= */

        .hero-visual {
            position: relative;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: slideRight 1s ease .2s both;
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .visual-card {
            width: 100%;
            max-width: 460px;
            background: linear-gradient(145deg, #10254b, #1e4b91);
            border-radius: 28px;
            padding: 42px;
            color: white;
            box-shadow: 0 25px 55px rgba(16,37,75,.25);
            position: relative;
            overflow: hidden;
            animation: floatCard 5s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-13px); }
        }

        .visual-card::before,
        .visual-card::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
        }

        .visual-card::before {
            width: 280px;
            height: 280px;
            right: -120px;
            top: -100px;
        }

        .visual-card::after {
            width: 180px;
            height: 180px;
            left: -100px;
            bottom: -100px;
        }

        .visual-icon {
            width: 72px;
            height: 72px;
            background: rgba(255,255,255,.13);
            border-radius: 19px;
            display: grid;
            place-items: center;
            font-size: 34px;
            margin-bottom: 32px;
            animation: iconFloat 3s ease-in-out infinite;
        }

        @keyframes iconFloat {
            50% { transform: translateY(-8px) rotate(5deg); }
        }

        .visual-card small {
            color: #bfdbfe;
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 13px;
        }

        .visual-card h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 39px;
            line-height: 1.3;
            margin: 15px 0;
            position: relative;
            z-index: 1;
        }

        .visual-card p {
            color: #dbeafe;
            font-size: 16px;
            line-height: 1.9;
            position: relative;
            z-index: 1;
        }

        .visual-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 35px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,.18);
            font-size: 14px;
            color: #bfdbfe;
            position: relative;
            z-index: 1;
        }

        .floating-bubble {
            position: absolute;
            width: 58px;
            height: 58px;
            border-radius: 17px;
            background: white;
            display: grid;
            place-items: center;
            font-size: 27px;
            box-shadow: 0 12px 30px rgba(37,99,235,.15);
            animation: bubbleFloat 4s ease-in-out infinite;
            z-index: 2;
        }

        .bubble-one {
            top: 10px;
            right: 5px;
        }

        .bubble-two {
            bottom: 20px;
            left: 0;
            animation-delay: 1s;
        }

        @keyframes bubbleFloat {
            50% { transform: translateY(-15px) rotate(8deg); }
        }

        /* =========================
           STATISTIK
        ========================= */

        .stats {
            margin-top: -40px;
            position: relative;
            z-index: 5;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            background: white;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(15,23,42,.09);
            padding: 35px 20px;
        }

        .stat-item {
            text-align: center;
            padding: 12px;
            border-right: 1px solid #edf1f7;
            transition: .3s;
        }

        .stat-item:hover {
            transform: translateY(-6px);
            background: #f8fbff;
            border-radius: 13px;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-item h3 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--blue);
            font-size: 34px;
            margin-bottom: 7px;
        }

        .stat-item p {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        /* =========================
           SECTION UMUM
        ========================= */

        section {
            scroll-margin-top: 95px;
        }

        .section {
            padding: 110px 0;
        }

        .section-heading {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 55px;
        }

        .section-label {
            color: var(--blue);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .section-heading h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(30px, 4vw, 42px);
            color: var(--navy);
            line-height: 1.4;
            margin-bottom: 16px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 16px;
            line-height: 1.9;
        }

        /* =========================
           TENTANG PRODI
        ========================= */

        .about {
            background: white;
        }

        .about-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 65px;
            align-items: center;
        }

        .about-art {
            min-height: 390px;
            background: linear-gradient(145deg, #dceaff, #f2f7ff);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .about-art::before,
        .about-art::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(37,99,235,.18);
            border-radius: 50%;
            animation: rotateCircle 20s linear infinite;
        }

        .about-art::before {
            width: 320px;
            height: 320px;
        }

        .about-art::after {
            width: 230px;
            height: 230px;
            animation-direction: reverse;
        }

        .about-symbol {
            position: relative;
            z-index: 1;
            background: white;
            color: var(--blue);
            width: 150px;
            height: 150px;
            border-radius: 38px;
            display: grid;
            place-items: center;
            font-size: 70px;
            box-shadow: 0 15px 35px rgba(37,99,235,.15);
            animation: floatCard 4s ease-in-out infinite;
        }

        .about-content .section-label {
            text-align: left;
        }

        .about-content h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--navy);
            font-size: 35px;
            line-height: 1.45;
            margin-bottom: 22px;
        }

        .about-content p {
            color: var(--muted);
            font-size: 16px;
            line-height: 2;
            margin-bottom: 18px;
            text-align: justify;
        }

        .about-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 28px;
        }

        .info-item {
            background: #f5f8ff;
            border-left: 4px solid var(--blue);
            padding: 17px;
            border-radius: 8px;
            transition: .3s;
        }

        .info-item:hover {
            transform: translateX(6px);
            box-shadow: 0 7px 18px rgba(37,99,235,.1);
        }

        .info-item span {
            display: block;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .info-item strong {
            font-size: 15px;
            color: var(--navy);
        }

        /* =========================
           SEJARAH
        ========================= */

        .history {
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }

        .history-card {
            max-width: 850px;
            margin: auto;
            display: grid;
            grid-template-columns: 170px 1fr;
            background: white;
            border-radius: 20px;
            padding: 38px;
            box-shadow: 0 8px 30px rgba(15,23,42,.05);
            gap: 30px;
            align-items: center;
            transition: .35s;
        }

        .history-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 40px rgba(15,23,42,.1);
        }

        .history-year {
            background: linear-gradient(145deg,#10254b,#2563eb);
            color: white;
            min-height: 140px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .history-year strong {
            font-size: 40px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .history-year span {
            font-size: 13px;
            color: #bfdbfe;
        }

        .history-content h3 {
            color: var(--navy);
            font-size: 21px;
            margin-bottom: 12px;
        }

        .history-content p {
            font-size: 15px;
            color: var(--muted);
            line-height: 2;
        }

        /* =========================
           KOMPETENSI
        ========================= */

        .competencies {
            background: white;
        }

        .competency-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 25px;
        }

        .competency-card {
            padding: 32px;
            border: 1px solid #e7edf6;
            border-radius: 17px;
            transition: .35s;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .competency-card::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 4px;
            left: -100%;
            top: 0;
            background: linear-gradient(90deg,#60a5fa,#2563eb);
            transition: .4s;
        }

        .competency-card:hover::before {
            left: 0;
        }

        .competency-card:hover {
            transform: translateY(-8px);
            border-color: #b8d0ff;
            box-shadow: 0 15px 35px rgba(37,99,235,.1);
        }

        .competency-icon {
            width: 62px;
            height: 62px;
            display: grid;
            place-items: center;
            background: var(--light-blue);
            color: var(--blue);
            border-radius: 15px;
            font-size: 29px;
            margin-bottom: 24px;
            transition: .35s;
        }

        .competency-card:hover .competency-icon {
            transform: rotate(-8deg) scale(1.1);
            background: var(--blue);
            color: white;
        }

        .competency-card h3 {
            color: var(--navy);
            font-size: 19px;
            margin-bottom: 13px;
        }

        .competency-card p {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.9;
        }

        /* =========================
           CTA
        ========================= */

        .cta {
            padding: 95px 0;
            background: linear-gradient(120deg,#10254b,#1e4b91);
            position: relative;
            overflow: hidden;
        }

        .cta::before,
        .cta::after {
            content: "";
            position: absolute;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            animation: rotateCircle 25s linear infinite;
            pointer-events: none;
        }

        .cta::before {
            width: 350px;
            height: 350px;
            right: -80px;
            top: -180px;
        }

        .cta::after {
            width: 250px;
            height: 250px;
            left: -100px;
            bottom: -130px;
        }

        .cta-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            position: relative;
            z-index: 1;
        }

        .cta h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 36px;
            color: white;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .cta p {
            color: #cbdcf6;
            font-size: 16px;
            line-height: 2;
            max-width: 650px;
        }

        .cta .btn {
            background: white;
            color: var(--navy);
            white-space: nowrap;
        }

        .cta .btn:hover {
            transform: translateY(-5px);
            background: #eaf2ff;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #0b1933;
            color: white;
            padding: 55px 0 25px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 45px;
            padding-bottom: 40px;
        }

        .footer-brand h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        .footer-brand p,
        .footer-links a {
            font-size: 14px;
            line-height: 2.1;
            color: #a8bad4;
        }

        .footer-links h4 {
            margin-bottom: 16px;
            font-size: 17px;
        }

        .footer-links a {
            display: block;
            margin-bottom: 7px;
            transition: .25s;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 6px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,.12);
            padding-top: 22px;
            text-align: center;
            color: #91a4c0;
            font-size: 13px;
        }

        /* =========================
           SCROLL ANIMATION
        ========================= */

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity .8s ease, transform .8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* =========================
           BACK TO TOP
        ========================= */

        .back-top {
            position: fixed;
            right: 25px;
            bottom: 25px;
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 15px;
            background: var(--blue);
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(37,99,235,.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(15px);
            transition: .3s;
            z-index: 900;
        }

        .back-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-top:hover {
            transform: translateY(-5px);
            background: var(--navy);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 1000px) {
            .hero-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            .hero h1 {
                font-size: 46px;
            }

            .visual-card {
                padding: 30px;
            }

            .about-grid {
                gap: 35px;
            }

            .competency-grid {
                grid-template-columns: repeat(2,1fr);
            }
        }

        @media(max-width: 760px) {
            .navbar {
                height: 75px;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 75px;
                left: 0;
                width: 100%;
                background: white;
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 15px 5% 25px;
                box-shadow: 0 10px 20px rgba(0,0,0,.07);
            }

            .nav-links.active {
                display: flex;
                animation: menuDown .3s ease;
            }

            @keyframes menuDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .nav-links a {
                padding: 13px 0;
            }

            .nav-links .nav-login {
                text-align: center;
                margin-top: 8px;
            }

            .hero {
                padding: 85px 0 100px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 43px;
            }

            .hero-description {
                font-size: 16px;
            }

            .hero-visual {
                min-height: 340px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid #edf1f7;
            }

            .stat-item:last-child {
                border-bottom: none;
            }

            .section {
                padding: 80px 0;
            }

            .section-heading h2 {
                font-size: 30px;
            }

            .about-grid {
                grid-template-columns: 1fr;
            }

            .about-art {
                min-height: 290px;
            }

            .about-content h2 {
                font-size: 29px;
            }

            .about-info {
                grid-template-columns: 1fr;
            }

            .history-card {
                grid-template-columns: 1fr;
            }

            .history-year {
                min-height: 100px;
            }

            .competency-grid {
                grid-template-columns: 1fr;
            }

            .cta-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .cta h2 {
                font-size: 29px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media(max-width: 420px) {
            .hero h1 {
                font-size: 37px;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .visual-card h2 {
                font-size: 32px;
            }

            .brand-name strong {
                font-size: 16px;
            }

            .brand-name span {
                font-size: 10px;
            }

            .section-heading h2 {
                font-size: 27px;
            }
        }

        @media(prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body>

<!-- LOADING SCREEN -->
<div class="page-loader" id="pageLoader">
    <div class="loader-logo">T</div>
    <div class="loader-text">TRPL POLMED</div>
    <div class="loader-line"></div>
</div>

<!-- NAVBAR -->
<header class="navbar" id="navbar">
    <div class="container nav-content">

        <a href="<?= site_url('/') ?>" class="brand">
            <div class="brand-logo">T</div>

            <div class="brand-name">
                <strong>TRPL POLMED</strong>
                <span>Data Dosen & Informasi Prodi</span>
            </div>
        </a>

        <button class="menu-toggle"
                onclick="toggleMenu()"
                aria-label="Buka menu"
                aria-expanded="false"
                id="menuToggle">
            ☰
        </button>

        <nav class="nav-links" id="navLinks">
            <a href="#beranda" onclick="closeMenu()">Beranda</a>
            <a href="#tentang" onclick="closeMenu()">Tentang Prodi</a>
            <a href="#sejarah" onclick="closeMenu()">Sejarah</a>
            <a href="#kompetensi" onclick="closeMenu()">Kompetensi</a>

            <a href="<?= site_url('direktori-dosen') ?>" onclick="closeMenu()">
                Data Dosen
            </a>

            <a href="<?= site_url('login') ?>" class="nav-login">
                Login Admin ↗
            </a>
        </nav>

    </div>
</header>

<!-- HERO -->
<section class="hero" id="beranda">
    <div class="container hero-grid">

        <div class="hero-content">

            <div class="eyebrow">
                <span></span>
                POLITEKNIK NEGERI MEDAN
            </div>

            <h1>
                Mengenal Lebih Dekat
                <em>TRPL Polmed.</em>
            </h1>

            <p class="hero-description">
                Selamat datang di Sistem Informasi Data Dosen Program
                Studi Teknologi Rekayasa Perangkat Lunak Politeknik
                Negeri Medan. Temukan informasi program studi dan
                direktori dosen dalam satu platform.
            </p>

            <div class="hero-buttons">

                <a href="<?= site_url('direktori-dosen') ?>" class="btn btn-primary">
                    Jelajahi Data Dosen →
                </a>

                <a href="#tentang" class="btn btn-outline">
                    Tentang Program Studi
                </a>

            </div>

        </div>

        <div class="hero-visual">

            <div class="floating-bubble bubble-one">💻</div>
            <div class="floating-bubble bubble-two">⚙️</div>

            <div class="visual-card">

                <div class="visual-icon">⌘</div>

                <small>PROGRAM STUDI SARJANA TERAPAN</small>

                <h2>Software<br>Engineering</h2>

                <p>
                    Teknologi Rekayasa Perangkat Lunak
                    <br>
                    Jurusan Teknik Komputer dan Informatika
                </p>

                <div class="visual-bottom">
                    <span>Politeknik Negeri Medan</span>
                    <strong>D4 TRPL</strong>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- STATISTIK -->
<div class="container stats reveal">

    <div class="stats-grid">

        <div class="stat-item">
            <h3>D4</h3>
            <p>Jenjang Sarjana Terapan</p>
        </div>

        <div class="stat-item">
            <h3>TRPL</h3>
            <p>Teknologi Rekayasa Perangkat Lunak</p>
        </div>

        <div class="stat-item">
            <h3>POLMED</h3>
            <p>Politeknik Negeri Medan</p>
        </div>

    </div>

</div>

<!-- TENTANG PROGRAM STUDI -->
<section class="section about" id="tentang">

    <div class="container about-grid">

        <div class="about-art reveal">
            <div class="about-symbol">⌘</div>
        </div>

        <div class="about-content reveal">

            <div class="section-label">Tentang Program Studi</div>

            <h2>
                Membangun Kompetensi di Bidang Rekayasa Perangkat Lunak
            </h2>

            <p>
                Program Studi Teknologi Rekayasa Perangkat Lunak (TRPL)
                merupakan program pendidikan Sarjana Terapan (Diploma IV)
                di Politeknik Negeri Medan yang berada di bawah naungan
                Jurusan Teknik Komputer dan Informatika.
            </p>

            <p>
                Program studi ini berfokus pada bidang rekayasa perangkat
                lunak, mulai dari analisis kebutuhan, perancangan sistem,
                pengembangan aplikasi, pengujian kualitas, hingga
                pemeliharaan perangkat lunak. Pembelajaran diarahkan untuk
                membangun kemampuan teknis dan pemecahan masalah dalam
                pengembangan solusi teknologi.
            </p>

            <div class="about-info">

                <div class="info-item">
                    <span>Jenjang Pendidikan</span>
                    <strong>Diploma IV (D4)</strong>
                </div>

                <div class="info-item">
                    <span>Bidang Keilmuan</span>
                    <strong>Software Engineering</strong>
                </div>

                <div class="info-item">
                    <span>Jurusan</span>
                    <strong>Teknik Komputer dan Informatika</strong>
                </div>

                <div class="info-item">
                    <span>Perguruan Tinggi</span>
                    <strong>Politeknik Negeri Medan</strong>
                </div>

            </div>

        </div>

    </div>

</section>

<!-- SEJARAH -->
<section class="section history" id="sejarah">

    <div class="container">

        <div class="section-heading reveal">

            <div class="section-label">Sejarah Program Studi</div>

            <h2>Perjalanan TRPL Politeknik Negeri Medan</h2>

            <p>
                Mengenal perkembangan Program Studi Teknologi
                Rekayasa Perangkat Lunak di Politeknik Negeri Medan.
            </p>

        </div>

        <div class="history-card reveal">

            <div class="history-year">
                <strong>TRPL</strong>
                <span>Politeknik Negeri Medan</span>
            </div>

            <div class="history-content">

                <h3>Program Studi Teknologi Rekayasa Perangkat Lunak</h3>

                <p>
                    Program Studi Teknologi Rekayasa Perangkat Lunak
                    merupakan bagian dari pengembangan pendidikan vokasi
                    di bidang teknologi informasi. Program studi ini
                    berfokus pada pengembangan kompetensi dalam analisis,
                    perancangan, pembangunan, pengujian, dan pemeliharaan
                    perangkat lunak untuk menjawab kebutuhan dunia kerja
                    dan perkembangan teknologi.
                </p>

            </div>

        </div>

    </div>

</section>

<!-- KOMPETENSI -->
<section class="section competencies" id="kompetensi">

    <div class="container">

        <div class="section-heading reveal">

            <div class="section-label">Bidang Keahlian</div>

            <h2>Mengenal Dunia Rekayasa Perangkat Lunak</h2>

            <p>
                Rekayasa perangkat lunak mencakup berbagai tahapan
                dan bidang keahlian dalam membangun solusi digital
                yang berkualitas.
            </p>

        </div>

        <div class="competency-grid">

            <div class="competency-card reveal">
                <div class="competency-icon">⌕</div>
                <h3>Analisis Kebutuhan</h3>
                <p>
                    Mengidentifikasi kebutuhan pengguna dan
                    menentukan spesifikasi sistem yang akan
                    dikembangkan.
                </p>
            </div>

            <div class="competency-card reveal">
                <div class="competency-icon">⌘</div>
                <h3>Perancangan Sistem</h3>
                <p>
                    Menyusun arsitektur, desain, alur proses,
                    serta rancangan antarmuka perangkat lunak.
                </p>
            </div>

            <div class="competency-card reveal">
                <div class="competency-icon">⌨</div>
                <h3>Pengembangan Aplikasi</h3>
                <p>
                    Menerapkan pemrograman untuk membangun
                    aplikasi berbasis web, mobile, dan sistem lainnya.
                </p>
            </div>

            <div class="competency-card reveal">
                <div class="competency-icon">✓</div>
                <h3>Pengujian Perangkat Lunak</h3>
                <p>
                    Melakukan pengujian untuk memastikan fungsi
                    dan kualitas perangkat lunak sesuai kebutuhan.
                </p>
            </div>

            <div class="competency-card reveal">
                <div class="competency-icon">▤</div>
                <h3>Manajemen Basis Data</h3>
                <p>
                    Mengelola penyimpanan, pengolahan, dan
                    pemeliharaan data secara terstruktur.
                </p>
            </div>

            <div class="competency-card reveal">
                <div class="competency-icon">↻</div>
                <h3>Pemeliharaan Sistem</h3>
                <p>
                    Memperbaiki, memperbarui, dan meningkatkan
                    kualitas perangkat lunak secara berkelanjutan.
                </p>
            </div>

        </div>

    </div>

</section>

<!-- CTA -->
<section class="cta">

    <div class="container cta-content reveal">

        <div>

            <h2>Kenali Tenaga Pendidik TRPL</h2>

            <p>
                Temukan informasi dosen Program Studi Teknologi
                Rekayasa Perangkat Lunak Politeknik Negeri Medan
                melalui direktori data dosen.
            </p>

        </div>

        <a href="<?= site_url('direktori-dosen') ?>" class="btn">
            Lihat Data Dosen →
        </a>

    </div>

</section>

<!-- FOOTER -->
<footer>

    <div class="container">

        <div class="footer-grid">

            <div class="footer-brand">

                <h3>TRPL POLMED</h3>

                <p>
                    Sistem Informasi Data Dosen Program Studi
                    Teknologi Rekayasa Perangkat Lunak,
                    Politeknik Negeri Medan.
                </p>

            </div>

            <div class="footer-links">

                <h4>Navigasi</h4>

                <a href="#beranda">Beranda</a>
                <a href="#tentang">Tentang Prodi</a>
                <a href="#sejarah">Sejarah</a>
                <a href="#kompetensi">Kompetensi</a>
                <a href="<?= site_url('direktori-dosen') ?>">Data Dosen</a>

            </div>

            <div class="footer-links">

                <h4>Informasi</h4>

                <a href="<?= site_url('login') ?>">Login Admin</a>

                <a href="https://polmed.ac.id/" target="_blank" rel="noopener">
                    Website Resmi Polmed ↗
                </a>

            </div>

        </div>

        <div class="footer-bottom">
            © <?= date('Y') ?> Sistem Informasi Data Dosen TRPL Polmed.
            Dikembangkan oleh Kelompok 4.
        </div>

    </div>

</footer>

<!-- BACK TO TOP -->
<button class="back-top"
        id="backTop"
        onclick="goToTop()"
        aria-label="Kembali ke atas">
    ↑
</button>

<!-- JAVASCRIPT -->
<script>

    // LOADING SCREEN
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.getElementById('pageLoader').classList.add('hide');
        }, 500);
    });

    // NAVBAR DAN BACK TO TOP
    const navbar = document.getElementById('navbar');
    const backTop = document.getElementById('backTop');

    window.addEventListener('scroll', function() {

        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        if (window.scrollY > 400) {
            backTop.classList.add('show');
        } else {
            backTop.classList.remove('show');
        }

    });

    // MENU MOBILE
    function toggleMenu() {

        const nav = document.getElementById('navLinks');
        const toggle = document.getElementById('menuToggle');

        nav.classList.toggle('active');

        toggle.setAttribute(
            'aria-expanded',
            nav.classList.contains('active') ? 'true' : 'false'
        );

    }

    function closeMenu() {

        document.getElementById('navLinks').classList.remove('active');

        document.getElementById('menuToggle')
            .setAttribute('aria-expanded', 'false');

    }

    // KEMBALI KE ATAS
    function goToTop() {

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    }

    // ANIMASI SAAT SCROLL
    const revealElements = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(function(entries) {

            entries.forEach(function(entry) {

                if (entry.isIntersecting) {

                    entry.target.classList.add('active');

                    observer.unobserve(entry.target);

                }

            });

        }, {
            threshold: 0.12
        });

        revealElements.forEach(function(element) {
            observer.observe(element);
        });

    } else {

        revealElements.forEach(function(element) {
            element.classList.add('active');
        });

    }

</script>

</body>
</html>
