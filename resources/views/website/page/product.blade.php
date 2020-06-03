@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">{{ $product->{'nome_'.app()->getLocale()} }}</h2>
                    </div>
                </div>

                <div class="col-xs-6">
                    <ol class="breadcrumb pull-right">
                        <li><a href="/">Home</a></li>
                        <li><a href="#" id="name_category">{{ $product->{'nome_'.app()->getLocale()} }}</a></li>
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
                                        @if($product->images)
                                            @foreach($product->images as $img)
                                                <div class="item {{ ($count == 1) ? 'active' : '' }}" data-thumb="0">
                                                    <a href="{{ $website_config['cs_big_dir'].$img->path }}"  class="galleria-item" data-lightbox="image-1">
                                                        <img src="{{ $website_config['cs_big_dir'].$img->path }}" class="img-responsive" alt="{{$seo->alt ?? ''}}"/>
                                                    </a>
                                                </div>
                                                @php $count++ @endphp
                                            @endforeach
                                        @endif
                                    </div>
                                    @if($product->images->count() > 1)
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

                                <h2 style="margin-top: 10px;">{{ $product->{'nome_'.app()->getLocale()} }}</h2>

                                @if($product->prezzo != '0.00' && $product->prezzo != '100000.00')

                                    @if($product->is_scontato())
                                        <h3 style="margin-bottom:6px;">
                                            <span class="prezzo_pieno">@money($product->prezzo)</span>
                                            <br>
                                            <span style="color:#840025;">@money($product->prezzo_scontato)</span>
                                        </h3>
                                    @else
                                        <h3 style="margin-bottom:6px;">
                                            <span>@money($product->prezzo)</span>
                                        </h3>
                                    @endif

                                @else
                                    <h3>@lang('msg.su_ordinazione')</h3>
                                @endif


                                <p style="margin-bottom:16px;line-height:1.4">
                                    @lang('msg.codice_prodotto'): <strong>{{ $product->codice }}</strong>
                                    <br /><br />
                                    {{ $product->{'desc_'.app()->getLocale()} }}
                                    <br /><br />
                                    {{ $product->{'misure_'.app()->getLocale()} }}
                                    <br />
                                    <span class="text-capitalize">
                                        {{ $product->availability->{'nome_'.app()->getLocale()} }}
                                    </span>
                                </p>

                                @if($product->prezzo != '0.00' && $product->prezzo != '100000.00')
                                    <div class="btn-area">
                                        <a href="javascript:void(0)" onclick="addToCart('{{ url(app()->getLocale().'/cart/addproduct',$product->id) }}')" class="btn btn-primary btn-block">
                                            + carrello <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                @endif
                                <a href="javascript:void(0)" onclick="addToWishList('{{ url(app()->getLocale().'/wishlist/addproduct',$product->id) }}')" style="background-color: #840025; padding: 10px;">
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