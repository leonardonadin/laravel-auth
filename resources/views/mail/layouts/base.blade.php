<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        @yield('content')
    </div>
</body>
</html>
