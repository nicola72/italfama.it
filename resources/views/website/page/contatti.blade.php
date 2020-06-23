@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader" style="background-color: #cdc8c6;">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla" style="color: #6f2412;">@lang('msg.contatti')</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.website_flash-message')

    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row" style="padding-top:40px;">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 col-xs-12 sideBar ">

                <!-- menu prodotti -->
                @include('layouts.website_menu_prodotti')
                <!-- fine menu prodotti -->


                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- PAGINA -->
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-content">
                                @if(app()->getLocale() == 'it')
                                    <strong>ITALFAMA</strong><br><br>
                                    via Guglielmo Marconi, 16<br>
                                    50041 Calenzano<br>
                                    Firenze (FI) - Toscana - Italia<br>
                                    Tel:	+390558878031<br>
                                    Fax:	+390558825453<br>
                                    E-mail: <a style="color:#840025;" href="mailto:info@italfama.it">info@italfama.it</a><br><br>
                                @else
                                    <strong>ITALFAMA</strong><br><br>
                                    via Guglielmo Marconi, 16<br>
                                    50041 Calenzano<br>
                                    Florence (FI) - Tuscany - Italy<br>
                                    Phone:	+390558878031<br>
                                    Fax:	+390558825453<br>
                                    E-mail: <a style="color:#840025;" href="mailto:info@italfama.it">info@italfama.it</a><br><br>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            @include('website.form.form_contatti')
                        </div>
                    </div>

                </div>
                <!-- -->
            </div>
        </div>
    </section>

@endsection
@section('js_script')
@stop