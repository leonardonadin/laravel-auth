<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Auth</title>

    @vite(['resources/js/app.js', 'resources/scss/app.scss'])
</head>

<body>
    <div id="app">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @session('success')
                showToastNotification('success', @js(session('success')));
            @endsession
            @session('error')
                showToastNotification('error', @js(session('error')));
            @endsession
            @session('warning')
                showToastNotification('warning', @js(session('warning')));
            @endsession
            @session('info')
                showToastNotification('info', @js(session('info')));
            @endsession
            @session('message')
                showToastNotification('info', @js(session('message')));
            @endsession
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    showToastNotification('error', @js($error));
                @endforeach
            @endif
        });
    </script>
</body>

</html>
