@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">@lang('msg.azienda')</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 col-xs-12 sideBar ">

                    <!-- menu prodotti -->
                @include('layouts.website_menu_prodotti')
                <!-- fine menu prodotti -->

                    <!-- box facebook -->
                @include('layouts.website_box_facebook')
                <!-- -->

                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- PAGINA -->
                <div class="col-md-9 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-header">
                                <h3  class="fjalla" style="color:#840025;">@lang('msg.sei_gia_iscritto')</h3>
                            </div>
                            @include('website.form.form_login')
                            <br />
                            <p>
                                <a style="font-size:120%; font-weight:bold; color:#840025" href="{{route('website.password.request',['locale'=>app()->getLocale()])}}">
                                    @lang('msg.recupera_password')
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="page-header">
                                <h3  class="fjalla" style="color:#840025;">@lang('msg.crea_un_account')</h3>
                            </div>
                            @include('website.form.form_registrazione')
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