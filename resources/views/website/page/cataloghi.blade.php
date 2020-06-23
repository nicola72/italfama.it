@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla" style="color: #6f2412;">@lang('msg.cataloghi')</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.website_flash-message')

    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 col-xs-12 sideBar ">

                <!-- menu prodotti -->
                @include('layouts.website_menu_prodotti')
                <!-- fine menu prodotti -->


                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- PAGINA -->
                <div class="col-md-9 col-xs-12 col-sm-12">
                    @if(count($cataloghi) > 0)
                        <div class="row">
                        @foreach($cataloghi as $key=>$catalogo)
                            @if($key%3 == 0 && $key != 0)
                                <div class="clearfix"></div>
                            @endif
                            <div class="col-md-4">
                                <div class="catalogo-box">
                                    <div class="catalogo-img">
                                        <a href="{{ $chess_domain.'/file/catalog/'.$catalogo->pdf() }}" target="_blank">
                                            <img src="{{ $chess_domain.'/file/catalog/crop/'.$catalogo->cover() }}" alt="" class="img-responsive" />
                                        </a>
                                    </div>
                                    <div class="catalogo-title">
                                        <a href="{{ $chess_domain.'/file/catalog/'.$catalogo->pdf() }}" target="_blank">
                                            {{ $catalogo->{'nome_'.app()->getLocale()} }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
                <!-- -->
            </div>
        </div>
    </section>

@endsection
@section('js_script')
@stop
