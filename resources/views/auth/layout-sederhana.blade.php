<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SCP | School Class Progress</title>

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
            --canvas: #f3f5f8;
            --font: "Plus Jakarta Sans", "Segoe UI", "Helvetica Neue", Roboto, Arial, sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: var(--font);
            font-size: 13px;
            line-height: 1.5;
            color: var(--ink);
            background: var(--canvas);
        }

        .topbar {
            background: var(--navy);
            color: #fff;
        }

        .topbar-inner {
            max-width: 960px;
            margin: 0 auto;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar img {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .topbar strong {
            display: block;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .8px;
            line-height: 1.2;
        }

        .topbar span {
            display: block;
            font-size: 11px;
            color: #c5d3e2;
        }

        .page {
            flex: 1;
            width: 100%;
            padding: 40px 20px 24px;
        }

        .panel {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 24px 26px 26px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
        }

        .step {
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
        }

        .desc {
            margin: 0 0 18px;
            color: var(--muted);
        }

        .alert {
            margin-bottom: 16px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 12px;
        }

        .alert-error {
            background: #fff4f3;
            border: 1px solid #f2d0cc;
            color: #a33b34;
        }

        .alert-ok {
            background: #effaf3;
            border: 1px solid #c9ead4;
            color: #1f7a3f;
        }

        .field { margin-bottom: 14px; }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #3b4b60;
        }

        input {
            width: 100%;
            height: 40px;
            padding: 0 12px;
            border: 1px solid #d4dce6;
            border-radius: 8px;
            background: #fff;
            color: var(--ink);
            font: 13px var(--font);
            outline: none;
        }

        input::placeholder { color: #a3adba; }

        input:focus {
            border-color: #56799d;
            box-shadow: 0 0 0 3px rgba(40, 98, 143, .10);
        }

        input.kode {
            max-width: 170px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 6px;
        }

        .btn {
            height: 40px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            background: var(--navy);
            color: #fff;
            font: 600 13px var(--font);
            cursor: pointer;
        }

        .btn:hover { background: var(--navy2); }

        .btn-block { width: 100%; }

        .links {
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #eef1f5;
            font-size: 12px;
            color: var(--muted);
        }

        .links a,
        .links .link {
            color: var(--navy);
            font-weight: 600;
            text-decoration: none;
        }

        .links a:hover,
        .links .link:hover { text-decoration: underline; }

        .links .link {
            padding: 0;
            border: 0;
            background: none;
            font: 600 12px var(--font);
            cursor: pointer;
        }

        .links form { display: inline; }

        .foot {
            padding: 0 20px 20px;
            text-align: center;
            font-size: 11px;
            color: var(--muted);
        }

        @media (max-width: 480px) {
            .page { padding: 24px 14px 16px; }
            .panel { padding: 20px 18px 22px; }
        }
    </style>
</head>

<body>

    <header class="topbar">
        <div class="topbar-inner">
            <img src="{{ asset('SMK_Negeri_1_Bantul_logo.png') }}" alt="Logo SMK Negeri 1 Bantul">
            <div>
                <strong>SCP</strong>
                <span>SMK Negeri 1 Bantul</span>
            </div>
        </div>
    </header>

    <main class="page">
        <section class="panel">

            @hasSection('step')
                <div class="step">@yield('step')</div>
            @endif

            <h1>@yield('heading')</h1>
            <p class="desc">@yield('subheading')</p>

            @if (session('status'))
                <div class="alert alert-ok" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error" role="alert">{{ $errors->first() }}</div>
            @endif

            @yield('content')

        </section>
    </main>

    <div class="foot">School Class Progress &nbsp;·&nbsp; SMK Negeri 1 Bantul</div>

</body>
</html>
