<!-- Meta padrão -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Identidade -->
<title>{{ config('app.name', 'IPoop') }}</title>
<meta name="description" content="iPoop - Facilitando a busca por banheiros públicos e promovendo acessibilidade para todos.">
<meta name="keywords" content="banheiros, públicos, acessibilidade, iPoop, localização, mapa">
<meta name="author" content="Alesson Marques da Silva">

<!-- Cores do navegador / tema -->
<meta name="theme-color" content="#9333ea"> <!-- Android/Chrome -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"> <!-- iOS Safari -->
<meta name="msapplication-navbutton-color" content="#9333ea"> <!-- Windows Phone / Edge -->

<!-- Manifest PWA -->
<link rel="manifest" href="/manifest.json">

<!-- Favicons -->
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<!-- Open Graph (para redes sociais) -->
<meta property="og:title" content="iPoop - Facilitando a busca por banheiros públicos e promovendo acessibilidade para todos." />
<meta property="og:description" content="iPoop - Facilitando a busca por banheiros públicos e promovendo acessibilidade para todos." />
<meta property="og:image" content="{{ asset('images/icon-512.png') }}" />
<meta property="og:image:secure_url" content="{{ asset('images/icon-512.png') }}" />
<meta property="og:image:alt" content="iPoop - Facilitando a busca por banheiros públicos e promovendo acessibilidade para todos." />
<meta property="og:image:width" content="512" />
<meta property="og:image:height" content="512" />
<meta property="og:image:type" content="image/png" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="iPoop" />
<meta property="og:locale" content="pt_BR" />
<meta property="og:locale:alternate" content="en_US" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<!-- Vite -->
@vite(['resources/css/app.css', 'resources/js/app.js'])
