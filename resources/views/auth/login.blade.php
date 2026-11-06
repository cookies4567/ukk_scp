
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SCP | School Class Progress</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #102b4e;
            --navy2: #1d456e;
            --ink: #243449;
            --muted: #748195;
            --line: #dce3eb;
            --paper: #fff;
            --canvas: #f3f5f8;
            --font: "Plus Jakarta Sans", "Segoe UI", "Helvetica Neue", Roboto, Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: var(--font);
            background: var(--canvas);
            color: var(--ink);
            display: grid;
            place-items: center;
            padding: 28px;
        }

        .login-shell {
            width: min(1040px, 100%);
            min-height: 520px;
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            background: #fff;
            border: 1px solid #e1e6ed;
            border-radius: 8px;
            overflow: hidden;
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            background: #102b4e;
            color: #fff;
            overflow: hidden;
        }


        .brand-mark {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        /* LOGO SEKOLAH */
        .brand-symbol {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .brand-symbol img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .brand-name {
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 1.3px;
        }

        .brand-sub {
            font-size: 10px;
            color: #c5d3e2;
            letter-spacing: 1.4px;
            margin-top: 4px;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
            max-width: 390px;
            margin: 40px 0;
        }

        .eyebrow {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #b8cbe0;
            font-weight: 700;
        }

        .brand-copy h1 {
            font-size: 26px;
            line-height: 1.3;
            letter-spacing: -.2px;
            margin: 18px 0 14px;
        }

        .brand-copy p {
            font-size: 14px;
            line-height: 1.8;
            color: #d1dce8;
            margin: 0;
            max-width: 350px;
        }

        .brand-foot {
            position: relative;
            z-index: 1;
            color: #b8c8d9;
            font-size: 11px;
            letter-spacing: .3px;
        }

        .form-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 54px 56px;
        }

        .form-inner {
            width: 100%;
            max-width: 350px;
        }

        .form-heading {
            margin-bottom: 34px;
        }

        .form-heading h2 {
            font-size: 20px;
            letter-spacing: 0;
            color: var(--navy);
            margin: 0 0 9px;
        }

        .form-heading p {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
            line-height: 1.6;
        }

        .error {
            padding: 12px 14px;
            margin-bottom: 20px;
            background: #fff4f3;
            border: 1px solid #f2d0cc;
            border-radius: 8px;
            color: #a33b34;
            font-size: 12px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #3b4b60;
            margin-bottom: 9px;
        }

        .form-group input {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1px solid #d4dce6;
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
            font: 13px var(--font);
            outline: none;
            transition: .18s;
        }

        .form-group input::placeholder {
            color: #a3adba;
        }

        .form-group input:focus {
            border-color: #56799d;
            box-shadow: 0 0 0 3px rgba(40,98,143,.11);
        }

        .btn-login {
            width: 100%;
            height: 47px;
            margin-top: 7px;
            border: 0;
            border-radius: 8px;
            background: var(--navy);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .2px;
            cursor: pointer;
            transition: background .18s, transform .18s;
        }

        .btn-login:hover {
            background: #1c426a;
        }

        .btn-login:active {
            transform: scale(.99);
        }

        @media(max-width:760px) {
            body {
                padding: 16px;
            }

            .login-shell {
                grid-template-columns: 1fr;
                max-width: 480px;
                min-height: 0;
            }

            .brand-panel {
                min-height: 250px;
                padding: 28px;
            }

            .brand-copy {
                margin: 28px 0 20px;
            }

            .brand-copy h1 {
                font-size: 22px;
            }

            .brand-foot {
                font-size: 10px;
            }

            .form-panel {
                padding: 36px 28px 40px;
            }
        }
    </style>
</head>

<body>

    <main class="login-shell">

        <section class="brand-panel" aria-label="Identitas SCP">

            <div class="brand-mark">

                {{-- LOGO SMK NEGERI 1 BANTUL --}}
                <div class="brand-symbol">
                    <img
                        src="{{ asset('SMK_Negeri_1_Bantul_logo.png') }}"
                        alt="Logo SMK Negeri 1 Bantul"
                    >
                </div>

                <div>
                    <div class="brand-name">SCP</div>
                    <div class="brand-sub">SMK Negeri 1 Bantul</div>
                </div>

            </div>

            <div class="brand-copy">
                <div class="eyebrow">Sistem Informasi Sekolah</div>

                <h1>
                    Kelola aktivitas sekolah dengan lebih terarah.
                </h1>

                <p>
                    Platform terpadu untuk mendukung pengelolaan kegiatan belajar,
                    administrasi, dan pemantauan sekolah.
                </p>
            </div>

            <div class="brand-foot">
                School Class Progress &nbsp;·&nbsp; Portal resmi sistem sekolah
            </div>

        </section>

        <section class="form-panel">

            <div class="form-inner">

                <div class="form-heading">
                    <h2>Selamat datang</h2>

                    <p>
                        Masuk menggunakan akun yang telah terdaftar untuk melanjutkan.
                    </p>
                </div>

                @if (session('success'))
                    <div class="error" style="background:#effaf3;border-color:#c9ead4;color:#1f7a3f" role="status">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">

                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <div style="text-align:right;margin:-8px 0 14px">
                        <a href="{{ route('password.forgot') }}"
                           style="font-size:12px;color:#102b4e;font-weight:600;text-decoration:none">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
                        Masuk ke SCP
                    </button>

                </form>

            </div>

        </section>

    </main>

</body>
</html>
