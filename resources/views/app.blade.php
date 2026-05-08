<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head>
            <title>{{ config('app.name', 'Laravel') }}</title>
        </x-inertia::head>
    </head>
    <body class="font-sans antialiased">
        <!-- Initial Cinema Curtain Placeholder (Prevents Flash of Content) -->
        <div id="curtain-placeholder" style="position: fixed; inset: 0; z-index: 99999; background: #000; pointer-events: none; overflow: hidden;">
            <div style="position: absolute; left: 0; width: 50.5%; height: 100%; background: #6b0000; background-image: repeating-linear-gradient(to right, #3a0000 0%, #6b0000 3%, #aa0000 6%, #e60000 8%, #aa0000 10%, #6b0000 13%, #3a0000 16%); box-shadow: 20px 0 50px rgba(0,0,0,0.5);"></div>
            <div style="position: absolute; right: 0; width: 50.5%; height: 100%; background: #6b0000; background-image: repeating-linear-gradient(to right, #3a0000 0%, #6b0000 3%, #aa0000 6%, #e60000 8%, #aa0000 10%, #6b0000 13%, #3a0000 16%); box-shadow: -20px 0 50px rgba(0,0,0,0.5);"></div>
        </div>
        <script>
            if (sessionStorage.getItem('curtainShown')) {
                document.getElementById('curtain-placeholder').style.display = 'none';
            }
        </script>

        <x-inertia::app />
    </body>
</html>
