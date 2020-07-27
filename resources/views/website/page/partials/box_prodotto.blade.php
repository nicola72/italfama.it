<div class="col-sm-4">
    <div class="productBox">
        <div class="productImage clearfix">
            <a href="{{ url(app()->getLocale().'/prodotto',['id'=> encrypt($product->id)]) }}">
                <img src="{{ $chess_domain.$website_config['ital_small_dir'].$product->cover() }}" alt="{{$seo->alt ?? ''}}">
            </a>
        </div>
        <div class="productCaption clearfix">
            <a href="{{ url(app()->getLocale().'/prodotto',['id'=> encrypt($product->id)]) }}">
                <div class="titolo_prodotto">
                    @if(strlen($product->{'nome_'.app()->getLocale()}) > 50))
                        {{ substr($product->{'nome_'.app()->getLocale()},0,50) }}...
                    @else
                        {{ $product->{'nome_'.app()->getLocale()} }}
                    @endif

                </div>
            </a>
            <div class="fjalla prezzo" >
                @if(Auth::guard('website')->check())
                    @if($product->availability_id == 4)
                        @lang('msg.su_ordinazione')
                    @else
                        @if(Auth::user()->vede_p_fabbrica)
                            <span class="p_ital p_fabbrica" >
                                Prezzo Fabbrica: @money($product->prezzo_fabbrica)
                            </span>
                        @endif
                        @if(Auth::user()->vede_p_vendita)
                            <span class="p_ital p_vendita" >
                                Prezzo Vendita: @money($product->prezzo)
                            </span>
                        @endif
                        @if(Auth::user()->vede_p_netto)
                            <span class="p_ital p_netto" >
                                Prezzo Netto: @money($product->prezzo_netto(Auth::user()))
                            </span>
                        @endif
                    @endif
                @endif

            </div>
            <div class="prodDescrizione">
                <strong>{{ $product->{'desc_'.app()->getLocale()} }}</strong>
            </div>

            <i>@lang('msg.codice_prodotto'): {{ $product->codice }}</i>
            <a href="{{ url(app()->getLocale().'/prodotto',['id'=> encrypt($product->id)]) }}" class="dettagli" >
                <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
            </a>
        </div>
    </div>
</div>