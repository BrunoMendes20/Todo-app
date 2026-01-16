<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @props(['pageTitle' => null])

    <title>{{ $pageTitle ?? config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <script src="https://kit.fontawesome.com/0ed6f7bf05.js" crossorigin="anonymous"></script>

</head>

<body class="bg-auth">
    {{ $slot ?? '' }}

    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/messages.js') }}"></script>
    <script src="{{ asset('assets/js/tasks.js') }}"></script>
</body>

</html>
