@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">{{ $titolo }}</h2>
                    </div>
                </div>

                <div class="col-xs-6">
                    <ol class="breadcrumb pull-right">
                        <li><a href="/">Home</a></li>
                        <li><a href="#" id="name_category">{{ $titolo }}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.website_flash-message')

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


                    </div>
                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- MAIN PAGE -->
                <div class="col-md-9 col-sm-12 sideBar ">

                    <div class="categoria-description">{{ $descrizione_categoria }}</div>

                    <div class="fjalla" style="text-align:left; font-size:130%;padding-bottom:20px;">
                        @lang('msg.ci_sono_n_prodotti_in_questa_categoria',['number'=>$totali])
                    </div>

                    <div id="product_list">
                        <!-- PAGINATORE -->
                        {{$list->links('website.pagination.no_ajax')}}
                        <!-- -->
                        @foreach($list as $item)
                            @if($item['type'] == 'product')
                                @include('website.page.partials.box_prodotto',['product'=>$item['object']])
                            @elseif($item['type'] == 'pairing')
                                @include('website.page.partials.box_abbinamento',['pairing'=>$item['object']])
                            @endif
                        @endforeach
                        <!-- PAGINATORE -->
                        {{$list->links('website.pagination.no_ajax')}}
                        <!-- -->

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