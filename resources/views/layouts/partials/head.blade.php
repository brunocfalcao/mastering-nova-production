<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'Mastering Nova - Laravel Nova Tutorial' }}</title>
<meta name="description" content= "Laravel Nova Tutorial - Learn Laravel Nova from scratch, how to create advanced UI components, multi-tenancy, making Tools, and much more" />
<meta name="robots" content= "index, follow">

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>

<!-- SEO metadata -->
<meta property="og:title" content="Mastering Laravel Nova - A Laravel Nova tutorial"/>
<meta property="og:description" content="Laravel Nova Tutorial - Learn Laravel Nova from scratch, how to create advanced UI components, multi-tenancy, making Tools, and much more"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="https://www.masteringnova.com/images/seo-image.jpg"/>
<meta property="og:url" content="https://www.masteringnova.com"/>
<meta property="twitter:card" content="summary_large_image" />
<meta property="twitter:site" content="@brunocfalcao" />
<meta property="twitter:title" content="Mastering Nova - A Laravel Nova tutorial" />
<meta property="twitter:description" content="Laravel Nova Tutorial - Learn Laravel Nova from scratch, how to create advanced UI components, multi-tenancy, making Tools, and much more" />
<meta property="twitter:image" content="https://www.masteringnova.com/images/seo-image-v2.jpg" />

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,400,500,600,700,800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Fira+Code&display=swap" rel="stylesheet">

<!-- Tailwind + Website styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<!-- Extra styles / meta data -->
@stack('head')