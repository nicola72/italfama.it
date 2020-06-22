@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">Checkout</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.website_flash-message')

    <div class="container" style="min-height: 300px;">
        <div class="row">
            <div class="col-md-12">
                <div style="padding:40px 0;font-size:140%;line-height: 1.3">
                    @lang('msg.checkout_successo');
                    <br>
                    <a class="btn btn-default" style="padding:14px 30px;margin-top:20px;" href="{{ url(app()->getLocale().'/order/print',['id'=>encrypt($order->id)])}}">
                        <i class="fa fa-print"></i> @lang('msg.stampa')
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js_script')

@stop