<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $settings = $page['props']['settings']['site'];
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset($settings['favicon']) }}" type="image/x-icon" />

    <!-- SEO Meta Tags -->
    @if (isset($page['props']['seo']))
        @php $seo = $page['props']['seo']; @endphp

        <title inertia>{{ $seo['title'] ?? config('app.name') }}</title>
        <meta name="description" content="{{ $seo['description'] ?? '' }}">
        <meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
        <meta name="author" content="{{ $seo['author'] ?? '' }}">
        <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}">

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="{{ $seo['og:title'] ?? config('app.name') }}">
        <meta property="og:description" content="{{ $seo['og:description'] ?? '' }}">
        <meta property="og:image" content="{{ $seo['og:image'] ?? '' }}">
        <meta property="og:url" content="{{ $seo['og:url'] ?? url()->current() }}">
        <meta property="og:type" content="{{ $seo['og:type'] ?? 'website' }}">
        <meta property="og:site_name" content="{{ $seo['og:site_name'] ?? config('app.name') }}">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="{{ $seo['twitter:card'] ?? 'summary_large_image' }}">
        <meta name="twitter:title" content="{{ $seo['twitter:title'] ?? config('app.name') }}">
        <meta name="twitter:description" content="{{ $seo['twitter:description'] ?? '' }}">
        <meta name="twitter:image" content="{{ $seo['twitter:image'] ?? '' }}">

        @if (isset($seo['twitter:site']))
            <meta name="twitter:site" content="{{ $seo['twitter:site'] }}">
        @endif
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <meta name="google-site-verification" content="{{ env('GOOGLE_SITE_VERIFICATION') }}" />
    <!-- Favicon -->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    {{-- JSON-LD Structured Data --}}
    @php
        $component = $page['component'] ?? '';
    @endphp
    @if ($component === 'Website/Home')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "{{ $settings['site_name'] ?? config('app.name') }}",
            "url": "{{ url('/') }}",
            "description": "{{ $seo['description'] ?? '' }}"
        }
        </script>
    @elseif ($component === 'Website/Services')
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Service",
            "serviceType": "{{ $settings['site_name'] ?? config('app.name') }} Services",
            "provider": {
                "@type": "Organization",
                "name": "{{ $settings['site_name'] ?? config('app.name') }}",
                "url": "{{ url('/') }}"
            },
            "areaServed": "Rwanda"
        }
        </script>
    @endif
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
