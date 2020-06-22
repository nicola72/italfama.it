@extends('layouts.website')
@section('content')

    @include('layouts.website_flash-message')

    <!-- form di RICERCA -->
    @include('website.page.partials.search_bar')
    <!-- -->

    <!-- MENU prodotti -->
    <div class="col-md-3 col-sm-12 col-xs-12 sideBar" style="margin: 0; margin-top: 20px;">
        @include('layouts.website_menu_prodotti')
    </div>
    <!-- -->

    <!-- SLIDER -->
    <div class="col-md-9 col-sm-12 col-xs-12 hidden-sm hidden-xs" style="margin: 0;">
        @include('website.page.partials.slider')
    </div>
    <!-- -->

    <div style="clear: both;"></div>
    <section class="mainContent clearfix hidden-md hidden-lg text-center" style="background-color: #cdc8c6; background-image: url(/img/foto_1.jpg); background-position: center top; background-repeat: no-repeat; min-height: 400px; background-size: cover;">
        <p class="playfair_titolo" style="padding-top: 20px; color: #fff; text-align: center; text-shadow: 1px 1px 5px #000;">
            @lang('msg.fabbrica_di_scacchi')
        </p>
    </section>
    <section class="mainContent clearfix" style="background-image: url(/img/fondo_5.jpg); background-position: center center; background-repeat: no-repeat; background-size: cover;">

        <div class="container">
            <div class="row">
                <div class="col-md-7 text-left">
                    <img src="/img/foto_12.png" alt="" class="img-responsive" style="margin: 0 auto; display: block;" />
                </div>
                <div class="col-md-5 playfair_titolo_white marchio">
				    <span style="font-size: 120%;">
                        @lang('msg.il_marchio_italfama')
				    </span>
                    <br />
                    <img src="/img/foto_18.png" alt="" class="img-responsive" />
                </div>
            </div>
        </div>
    </section>
    <section class="mainContent clearfix" style="background-image: url(/img/fondo_1.jpg); background-repeat: no-repeat; background-size: cover; background-position: top center;">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 playfair_large">
                    @lang('msg.gli_scacchi_di_italfama_sono_molto_apprezzati')
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS -->
    <section>
        <div class="container">
            <div class="row featuredProducts">
                <div class="col-xs-12">
                    <div class="page-header">
                        <h4 class="playfair_titolo">NEWS</h4>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="owl-carousel featuredProductsSlider">
                        @foreach($news as $item)
                        <div class="slide">
                            <div class="clearfix">
                                <div class="img-news-cont">
                                    <img src="https://www.chess-store.it/file/news/small/{{$item->cover()}}" alt="" class="img_news">
                                </div>
                            </div>
                            <div class="productCaption clearfix">
                                <h5 class="no_uppercase">{!! $item->{'desc_'.app()->getLocale()} !!}</h5>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
@section('js_script')

@stop