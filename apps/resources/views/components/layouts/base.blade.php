<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? config('app.name') }}</title>
    {{ $head ?? '' }}
    @if (session('toast'))
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.dispatch('showToast', @json(session('toast')));
        });
    </script>
@endif
</head>
<body class="bg-gray-50 dark:bg-gray-900">

    @livewire('toast')
    {{ $slot }}
    @livewireScripts

    <!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>