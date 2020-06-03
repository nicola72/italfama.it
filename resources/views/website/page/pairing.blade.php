@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">{{ $pairing->{'nome_'.app()->getLocale()} }}</h2>
                    </div>
                </div>

                <div class="col-xs-6">
                    <ol class="breadcrumb pull-right">
                        <li><a href="/">Home</a></li>
                        <li><a href="#" id="name_category">{{ $pairing->{'nome_'.app()->getLocale()} }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- sezione LISTA PRODOTTI -->
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 sideBar ">

                    <div class="panel panel-default hidden-xs hidden-sm">
                        <!-- menu prodotti -->
                    @include('layouts.website_menu_prodotti')
                    <!-- fine menu prodotti -->

                        <!-- box facebook -->
                    @include('layouts.website_box_facebook')
                    <!-- -->

                        <!-- box spedizione -->
                    @if(app()->getLocale() == 'it')
                        @include('layouts.website_box_spedizione')
                    @endif
                    <!-- -->

                    </div>
                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- MAIN PAGE -->
                <div class="col-md-9 col-sm-12 singleProduct ">

                    <div class="media">
                        <div class="col-sm-8">
                            <div class="media productSlider">

                                <div id="carousel" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php $count=1 @endphp
                                        @if($pairing->images)
                                            @foreach($pairing->images as $img)
                                                <div class="item {{ ($count == 1) ? 'active' : '' }}" data-thumb="0">
                                                    <a href="{{ $website_config['cs_big_dir'].$img->path }}"  class="galleria-item" data-lightbox="image-1">
                                                        <img src="{{ $website_config['cs_big_dir'].$img->path }}" class="img-responsive" alt="{{$seo->alt ?? ''}}"/>
                                                    </a>
                                                </div>
                                                @php $count++ @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                    @if($pairing->images->count() > 1)
                                        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    @endif
                                </div>

                                <div class="clearfix">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="media-body">

                                <h2 style="margin-top: 10px;">{{ $pairing->{'nome_'.app()->getLocale()} }}</h2>

                                @if($pairing->product1->prezzo_scontato != '0.00' || $pairing->product2->prezzo_scontato != '0.00')
                                    <h3 style="margin-bottom:6px;">
                                        <span class="prezzo_pieno">@money($pairing->product1->prezzo + $pairing->product2->prezzo)</span>
                                        <br>
                                        <span style="color:#840025;">@money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita())</span>
                                    </h3>
                                @else
                                    <h3 style="margin-bottom:6px;">
                                        <span>@money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita())</span>
                                    </h3>
                                @endif

                                <p style="margin-bottom:16px;line-height:1.4">
                                    @lang('msg.codice_prodotto'): <strong>{{ $pairing->product1->codice }} + {{ $pairing->product2->codice }}</strong>
                                    <br /><br />
                                    {{ $pairing->{'desc_'.app()->getLocale()} }}
                                </p>

                                <div class="btn-area">
                                    <a href="javascript:void(0)" onclick="addToCart('{{ url(app()->getLocale().'/cart/addpairing',$pairing->id) }}')" class="btn btn-primary btn-block">
                                        + carrello <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <a href="javascript:void(0)" onclick="addToWishList('{{ url(app()->getLocale().'/wishlist/addpairing',$pairing->id) }}')" style="background-color: #840025; padding: 10px;">
                                    <i class="fa fa-heart" aria-hidden="true" style="font-size: 130%;"></i>
                                </a>
                                <br />


                                <div style="height: 30px;"></div>

                                <iframe
                                        src="//www.facebook.com/plugins/share_button.php?href={{request()->fullUrl()}}&amp;layout=button_count&amp;appId=552773188215847"
                                        scrolling="no" frameborder="0" allowtransparency="true"
                                        style="height: 30px;">

                                </iframe>
                                </iframe>
                                <div class="clearfix"></div>
                                <div class="g-plus" data-action="share" style="margin:0px 0 5px 0;"></div>
                                <div class="clearfix"></div>
                                <a class="twitter-share-button"  href="https://twitter.com/intent/tweet">Tweet</a>

                                <script>
                                    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- i Prodotti singoli -->
                <div class="col-md-6 col-md-offset-2" style="border-top:1px dotted #666; padding:20px 0px"></div>

                <div class="col-md-9 col-xs-12 col-sm-12" style="background-color: #fff;">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="productBox">
                            <div class="productImage clearfix">
                                <a href="{{$pairing->product1->url()}}">
                                    <img src="{{ $website_config['cs_small_dir'].$pairing->product1->cover() }}" alt="{{$seo->alt ?? ''}}">
                                </a>
                            </div>
                            <div class="productCaption clearfix">
                                <a href="{{$pairing->product1->url()}}">
                                    <div class="titolo_prodotto">
                                        {{$pairing->product1->{'nome_'.app()->getLocale()} }}
                                    </div>
                                </a>
                                <div class="fjalla prezzo">
                                    @if($pairing->product1->is_scontato())
                                        <span class="FullProdPrice">@money($pairing->product1->prezzo)</span>
                                        &nbsp;&nbsp;
                                        <span>@money($pairing->product1->prezzo_scontato)</span>
                                    @else
                                        <span>@money($pairing->product1->prezzo)</span>
                                    @endif
                                </div>
                                <div class="prodDescrizione">
                                    <strong>{{ $pairing->product1->{'desc_'.app()->getLocale()} }}</strong>
                                </div>
                                <div class="prodDimensioni">
                                    {{ $pairing->product1->{'misure_'.app()->getLocale()} }}
                                </div>
                                <div class="prodDisp">
                                    {{ $pairing->product1->availability->{'nome_'.app()->getLocale()} }}
                                </div>
                                <br />
                                <i>@lang('msg.codice_prodotto'): {{ $pairing->product1->codice }}</i>
                                <a href="{{ $pairing->product1->url() }}" class="dettagli">
                                    <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="productBox">
                            <div class="productImage clearfix">
                                <a href="{{ $pairing->product2->url() }}">
                                    <img src="{{ $website_config['cs_small_dir'].$pairing->product2->cover() }}" alt="{{$seo->alt ?? ''}}">
                                </a>

                            </div>
                            <div class="productCaption clearfix">
                                <a href="{{ $pairing->product2->url() }}">
                                    <div class="titolo_prodotto">
                                        {{$pairing->product2->{'nome_'.app()->getLocale()} }}
                                    </div>
                                </a>
                                <div class="fjalla prezzo">
                                    @if($pairing->product2->is_scontato())
                                        <span class="FullProdPrice">@money($pairing->product2->prezzo)</span>
                                        &nbsp;&nbsp;
                                        <span>@money($pairing->product2->prezzo_scontato)</span>
                                    @else
                                        <span>@money($pairing->product2->prezzo)</span>
                                    @endif
                                </div>
                                <div class="prodDescrizione">
                                    <strong>{{ $pairing->product2->{'desc_'.app()->getLocale()} }}</strong>
                                </div>
                                <div class="prodDimensioni">
                                    {{ $pairing->product2->{'misure_'.app()->getLocale()} }}
                                </div>
                                <div class="prodDisp">
                                    {{ $pairing->product2->availability->{'nome_'.app()->getLocale()} }}
                                </div>
                                <br />
                                <i>@lang('msg.codice_prodotto'): {{ $pairing->product2->codice }}</i>
                                <a href="{{ $pairing->product2->url() }}" class="dettagli">
                                    <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fine singoli prodotti -->

                <div class="hidden-md hidden-lg" style="clear:both;"></div>

                <!-- abbinamenti correlati -->
                @if($pairing_correlati->count() > 0)
                <div class="col-md-9 col-xs-12 col-sm-12" style="background-color: #fff;">
                    <div class="page-header" style="padding-top: 50px;">
                        <h4>
                            <span style="font-size: 130%; font-family: 'Fjalla One', sans-serif; color: #840025">@lang('msg.set_correlati')</span>
                        </h4>
                    </div>
                    @foreach($pairing_correlati as $pairing)
                        <div class="col-md-4 col-sm-6 col-xs-12" style="background-color: #fff;">
                            <div class="productBox">
                                <div class="productImage clearfix">
                                    <a href="{{$pairing->url()}}">
                                        <img src="{{ $website_config['cs_small_dir'].$pairing->cover() }}" alt="{{$seo->alt ?? ''}}">
                                    </a>
                                </div>
                                <div class="productCaption clearfix">
                                    <a href="{{$pairing->url()}}">
                                        <div class="titolo_prodotto">
                                            {{$pairing->{'nome_'.app()->getLocale()} }}
                                        </div>
                                    </a>
                                    <div class="fjalla prezzo" >
                                        @if($pairing->product1->prezzo_scontato != '0.00' || $pairing->product2->prezzo_scontato != '0.00')
                                            <span class="FullProdPrice">
                                                @money($pairing->product1->prezzo + $pairing->product2->prezzo)
                                            </span>
                                            @money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita())
                                        @else
                                            @money($pairing->product1->prezzo_vendita() + $pairing->product2->prezzo_vendita())
                                        @endif
                                    </div>
                                    <div class="prodDescrizione">
                                        <strong>{{ $pairing->{'desc_'.app()->getLocale()} }}</strong>
                                    </div>

                                    <i>@lang('msg.codice_prodotto'): {{$pairing->product1->codice}} + {{$pairing->product2->codice}}</i>
                                    <a href="{{$pairing->url()}}" class="dettagli" >
                                        <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
                <!-- fine abbinamenti correlati -->
                <!-- FINE MAIN PAGE -->

            </div>

            <!-- MENU prodotti per MOBILE -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <br />
                        <br />
                        <div class="panel panel-default hidden-md hidden-lg">
                            @include('layouts.website_menu_prodotti_mobile')
                        </div>
                    </div>
                </div>
            </div>
            <!-- fine MENU prodotti per MOBILE -->

        </div>
    </section>
    <!-- -->

@endsection
@section('js_script')

@stop