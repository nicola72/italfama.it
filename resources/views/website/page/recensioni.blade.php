@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla">@lang('msg.recensioni')</h2>
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
                    @if($reviews)
                        @foreach($reviews as $review)
                            <div class="recensione-item">
                                <div class="recensione-data">{{ $review->created_at->format('d/m/Y') }}</div>
                                <div class="recensione-nome">{{ $review->nome }}</div>
                                <div class="recensione-messaggio">{!! $review->messaggio !!}</div>
                            </div>
                        @endforeach
                    @endif
                    <p></p>
                </div>
                <!-- -->
            </div>
        </div>
    </section>

@endsection
@section('js_script')

@stop