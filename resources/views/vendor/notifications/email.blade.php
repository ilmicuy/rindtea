<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Rind Tea!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ !empty($greeting) ? $greeting : ($level === 'error' ? 'Whoops!' : 'Halo!') }}</h1>
        </div>
        <div class="content">
            {{-- Intro Lines --}}
            @foreach ($introLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Action Button --}}
            @isset($actionText)
                <p>
                    <a href="{{ $actionUrl }}" class="button" style="background-color: #4CAF50;">
                        {{ $actionText }}
                    </a>
                </p>
            @endisset

            {{-- Outro Lines --}}
            @foreach ($outroLines as $line)
                <p>{{ $line }}</p>
            @endforeach

            {{-- Salutation --}}
            <p>
                {{ !empty($salutation) ? $salutation : 'Salam Hormat,' }}<br>
                {{ config('app.name') }}
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Rind Tea. All rights reserved.
        </div>
    </div>

    {{-- Subcopy --}}
    @isset($actionText)
    <div class="container">
        <div class="footer">
            <p>
                Jika Anda mengalami kesulitan dalam mengklik tombol "{{ $actionText }}", salin dan tempel URL di bawah ke dalam browser web Anda:<br>
                <a href="{{ $actionUrl }}">{{ $displayableActionUrl }}</a>
            </p>
        </div>
    </div>
    @endisset
</body>
</html>
