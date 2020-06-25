@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader" style="background-color: #cdc8c6;">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla" style="color: #6f2412;">@lang('msg.miei_ordini')</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @include('layouts.website_flash-message')

    <div class="container">
        <div class="row" style="margin-top:10px;">
            <div class="pull-right">
                <a href="/" class="fjalla btn btn-default" style="padding:10px 20px;">@lang('msg.torna_allo_shop')</a>
            </div>
        </div>
        <div class="row" style="padding-top:40px;padding-bottom:60px;">
            @if(!$orders)
                <div class="col-md-12">
                    <p style="padding:40px 0;font-size:140%;">@lang('msg.non_hai_effettuato_nessun_ordine')</p>
                </div>
            @else
                <div class="col-md-12">
                    @foreach($orders as $order)
                        <div class="row order-list-item">
                            <div class="col-sm-3">
                                @lang('msg.ordine') n° {{$order->id}}
                            </div>
                            <div class="col-sm-3">
                                @lang('msg.data') {{ $order->created_at->format('d-m-Y') }}
                            </div>
                            <div class="col-sm-3">
                                @money($order->importo)
                            </div>
                            <div class="col-sm-3 text-right">
                                <a class="btn btn-default" style="padding:6px 12px;" href="{{ url(app()->getLocale().'/order/print',['id'=>encrypt($order->id)])}}">
                                    <i class="fa fa-print"></i> @lang('msg.stampa')
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
@section('js_script')

@stop
