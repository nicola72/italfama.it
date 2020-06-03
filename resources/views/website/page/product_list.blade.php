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

    <!-- sezione LISTA PRODOTTI -->
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 sideBar ">

                    <!-- ORDINAMENTO -->
                    <div class="panel panel-default" style="padding-bottom:20px;">
                        <div class="panel-heading fjalla" style="font-weight:100; background-color:#eee; color:#666;">@lang('msg.ordina_per'):</div>
                        @include('website.form.form_ordinamento')
                    </div>
                    <!-- -->

                    <!-- FILTRI -->
                    @if($pairings)
                        <div class="panel panel-default" style="padding-bottom:20px;">
                            <div class="panel-heading fjalla" style="font-weight:100; background-color:#eee; color:#666;">@lang('msg.filtra_per'):</div>
                            @include('website.form.form_filtro')
                        </div>
                    @endif
                    <!-- -->

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
                <div class="col-md-9 col-sm-12 sideBar ">

                    <div class="categoria-description">{{ $descrizione_categoria }}</div>

                    <div class="fjalla" style="text-align:left; font-size:130%;padding-bottom:20px;">
                        @lang('msg.ci_sono_n_prodotti_in_questa_categoria',['number'=>$totali])
                    </div>

                    <div id="product_list">

                    <!-- ABBINAMENTI -->
                    @if($pairings)
                        <!-- PAGINATORE -->
                        {{$pairings->links('website.pagination.default')}}
                        <!-- -->

                        @foreach($pairings as $pairing)
                            @include('website.page.partials.box_abbinamento')
                        @endforeach

                        <!-- PAGINATORE -->
                        {{$pairings->links('website.pagination.default')}}
                        <!-- -->
                    @endif
                    <!-- -->

                    <!-- PRODOTTI SINGOLI -->
                    @if($products)
                        <!-- PAGINATORE -->
                        {{$products->links('website.pagination.default')}}
                        <!-- -->

                        @foreach($products as $product)
                            @include('website.page.partials.box_prodotto')
                        @endforeach

                        <!-- PAGINATORE -->
                        {{$products->links('website.pagination.default')}}
                        <!-- -->
                    @endif
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
    <script type="text/javascript">
        var $name_category = $('#name_category');
        if ( $name_category.length && !$name_category.text().trim() ){
            var name_category  = $('a.categoria', $('.nav.fjalla .collapseItem:not(.collapse)').parent()).text().trim();
            $name_category.text(name_category);
        }

    </script>
@stop