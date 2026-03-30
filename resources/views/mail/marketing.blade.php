<!DOCTYPE html><html>
<head>    <meta charset="utf-8">
    <title>Super Sales Marketing</title>    <style>
        body {            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;            color: #333;
            margin: 0;
            padding: 0;            background-color: #f5f5f5;        }
        .container {            max-width: 600px;
            margin: 0 auto;            padding: 20px;
            background-color: #ffffff;            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);        }
        .header {            text-align: center;
            padding: 20px 0;            border-bottom: 2px solid #007bff;
        }        .logo {
            max-width: 150px;            height: auto;
        }
        .content {            padding: 30px 20px;        }
        .footer {            text-align: center;
            padding: 20px;            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;            border-radius: 0 0 8px 8px;
        }        .btn {
            display: inline-block;            padding: 12px 24px;
            background-color: #007bff;            color: #ffffff;
            text-decoration: none;            border-radius: 4px;
            margin-top: 20px;            transition: background-color 0.3s;
        }        .btn:hover {
            background-color: #0056b3;        }
    </style></head>
<body>

    <div class="container">
        <div class="header">
            <img src="{{ asset('img/dash.ico') }}" alt="{{ config('app.name') }} Logo" class="logo">
            <h1 style="color: #007bff;">{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <h2>{{ __('mail.welcome_message') }}</h2>
            <p>{!! $response !!}</p>
            @if ($project && $project->link)
                <a href="{{ $project->link }}" class="btn" style="color :#fff !important;">{{ __('mail.visit_link') }}</a>
                <p>{{ __('mail.scan_qr') }}</p>
                <img src="{{asset($project->qr_code)}}" alt="{{ __('mail.qr_code') }}">
            @endif
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('mail.all_rights_reserved') }}</p>
            <p>
                <small>{{ __('mail.email_disclaimer') }}</small>
            </p>
        </div>
    </div>
</body>
</html>






































