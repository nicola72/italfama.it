@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader"	style="background-color: #cdc8c6;">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="playfair" style="color: #6f2412;">LOGIN</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- PAGINA -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-header">
                                <h3  class="fjalla" style="color:#840025;">@lang('msg.sei_gia_iscritto')</h3>
                            </div>
                            @include('website.form.form_login')
                            <br />
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