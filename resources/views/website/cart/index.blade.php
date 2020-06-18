@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">@lang('msg.carrello')</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if(!$carts)
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p style="padding:40px 0;font-size:140%;">@lang('msg.nessun_prodotto_nel_carrello')</p>
            </div>
        </div>
    </div>
    @else
    <div class="container">
        <div class="row" style="margin-top:10px;">
            <div class="pull-right">
                <a href="/" class="fjalla btn btn-default" style="padding:10px 20px;">@lang('msg.torna_allo_shop')</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <br />
                <table id="carrello_tbl" class="table">
                    <tr>
                        <th>&nbsp;</th>
                        <th>@lang('msg.codice')</th>
                        <th class="hidden-xs">@lang('msg.prodotto')</th>
                        <th>@lang('msg.qta')</th>
                        <th>@lang('msg.totale')</th>
                        <th>@lang('msg.elimina')</th>
                    </tr>
                    @foreach($carts as $cart)

                    <tr>
                        <td>
                            <a href="{{ $chess_domain.$website_config['ital_big_dir'].$cart->product->cover() }}" class="item-img galleria-item">
                                <img src="{{ $chess_domain.$website_config['ital_small_dir'].$cart->product->cover() }}" alt="" class="img-carrello" />
                            </a>
                        </td>
                        <td>
                            <a href="{{url(app()->getLocale().'/prodotto',['id'=>encrypt($cart->product->id)])}}">
                                {{ $cart->product->codice }}
                            </a>
                        </td>
                        <td class="hidden-xs">
                            <a href="{{url(app()->getLocale().'/prodotto',['id'=>encrypt($cart->product->id)])}}">
                                {{ $cart->product->{'nome_'.app()->getLocale()} }}
                            </a>
                        </td>
                        <td>
                            <input type="text" name="qta" value="{{ $cart->qta }}" class="center" data-idrow="{{ $cart->id }}" style="width:30px;">
                            <a href="javascript:void(0);" onclick="cartUpdateQta( '{{ url(app()->getLocale().'/cart/update') }}' , {{$cart->id}} );">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        </td>
                        <td>
                            @money($cart->product->prezzo_netto(Auth::user()) * $cart->qta)
                        </td>
                        <td>
                            <a href="{{ url(app()->getLocale().'/cart/destroy',$cart->id) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-md-12 text-right">
                <span class="text-uppercase" style="font-size:20px;font-weight: bold">@lang('msg.totale') @money($importo_carrello)</span>
            </div>
        </div>
        <br />

        <div class="row" style="padding-top:30px;padding-bottom:50px;">
            <div class="col-md-12 text-right">
                <a href="{{url(app()->getLocale(),'/cart/checkout')}}" class="btn btn-default" style="padding:20px 30px">Evadi Ordine</a>
            </div>
        </div>
    </div>
    @endif

@endsection
@section('js_script')

@stop