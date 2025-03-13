<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div style="background: #212529; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
            <h1 style="color: #f9ca7a; margin: 0;">{{ config('app.name') }}</h1>
        </div>

        <div style="padding: 20px;">
            @yield('content')
        </div>

        <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 0 0 8px 8px;">
            <p style="margin: 0; color: #6c757d;">
                {{ config('app.name') }} © {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
