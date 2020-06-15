<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <title>{{$seo->title ?? 'Chess Store'}}</title>
    <meta charset="utf-8">
    <meta name="Keywords" content="{{$seo->keywords ?? ''}}" />
    <meta name="Description" content="{{$seo->description ?? ''}}" />
    <meta name="language" content="{{App::getLocale()}}" />
    <meta http-equiv="Cache-control" content="public">
    <meta name="author" content="Designed by InYourLife- https://www.inyourlife.info" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="function" content="{{ $function ?? '' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    @section('styles')

        link href="/assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet">
        <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/assets/plugins/selectbox/select_option1.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/assets/plugins/rs-plugin/css/settings.css" media="screen">
        <link rel="stylesheet" type="text/css" href="/assets/plugins/owl-carousel/owl.carousel.css" media="screen">
        <link rel="stylesheet" type="text/css" href="/assets/css/magnific-popup.css" media="screen">
        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css" media="screen">

        <!-- GOOGLE FONT -->
        <link href='https://fonts.googleapis.com/css?family=Oxygen:400,300,700' rel='stylesheet' type='text/css'>

        <!-- CUSTOM CSS -->
        <link href="/assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/colors/default.css" id="option_color">

    @show
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    @stack('head')
</head>
<body>
<div class="main-wrapper">

    @yield('content')
    <div class="h2-wrapper">
        <h2 class="h2 hidden-xs">
            {{$seo->h2 ?? ''}}
        </h2>
    </div>
</div>

<!-- MODALE -->
<div id="myModal" class="modal fade" role="dialog"></div>
<!-- FINE MODALE -->

@section('scripts')
    <script src="/assets/js/jquery-ui/jquery-ui.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="/assets/js/rs-plugin/js/jquery.themepunch.revolution.js"></script>
    <script src="/assets/js/owl-carousel/owl.carousel.js"></script>
    <script src="/assets/js/selectbox/jquery.selectbox-0.1.3.min.js"></script>
    <script src="/assets/js/countdown/jquery.syotimer.js"></script>
    <script src="/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/assets/js/lightbox.js"></script>
    <script src="/assets/js/jquery.validate.js"></script>
    <script src="/assets/js/additional-methods.js"></script>
    <script src="/assets/js/custom.js"></script>
    <script src="/assets/js/website.js"></script>

@show
@stack('body')
</body>
</html>