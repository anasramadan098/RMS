<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon - RMS</title>
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    {{-- favIcon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}">
    <style>
        body {
            background-color: #0e6030;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo {
            max-width: 200px;
            margin-bottom: 2rem;
        }

        .countdown {
            font-size: 3rem;
            font-weight: bold;
            margin: 2rem 0;
        }

        .coming-soon-text {
            font-size: 4rem;
            font-weight: bold;
            text-transform: uppercase;
            margin: 1rem 0;
        }
    </style>
</head>

<body>
    <div class="container text-center"> <img src="{{ asset('img/logo.png') }}" alt="RMS Logo" class="logo">
        <div class="coming-soon-text">Coming Soon</div>
        <p class="lead">We're working hard to bring you something amazing!</p>
        <p class="lead">
            <a href="/menu" style="color:#fff;">
                Go To The Menu
            </a>
        </p>

        <p>Stay tuned for updates!</p>
    </div>

</body>

</html>