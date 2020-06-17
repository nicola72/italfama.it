<div class="col-sm-4">
    <div class="productBox">
        <div class="productImage clearfix">
            <a href="{{$pairing->url()}}">
                <img src="{{ $chess_domain.$website_config['ital_small_dir'].$pairing->cover() }}" alt="{{$seo->alt ?? ''}}">
            </a>
        </div>
        <div class="productCaption clearfix">
            <a href="{{$pairing->url()}}">
                <div class="titolo_prodotto">
                    {{$pairing->{'nome_'.app()->getLocale()} }}
                </div>
            </a>
            <div class="fjalla prezzo" >
                @if(Auth::guard('website')->check())
                    @if(Auth::user()->vede_p_fabbrica)
                        <span class="p_ital p_fabbrica" >
                            Prezzo Fabbrica:
                            @money($pairing->product1->prezzo_fabbrica + $pairing->product2->prezzo_fabbrica)
                        </span>
                    @endif
                    @if(Auth::user()->vede_p_vendita)
                        <span class="p_ital p_vendita" >
                            Prezzo Vendita:
                            @money($pairing->product1->prezzo + $pairing->product2->prezzo)
                        </span>
                    @endif
                    @if(Auth::user()->vede_p_netto)
                        <span class="p_ital p_netto" >
                            Prezzo Netto:
                            @money($pairing->product1->prezzo_netto(Auth::user()) + $pairing->product2->prezzo_netto(Auth::user()))
                        </span>
                    @endif
                @endif
            </div>

            <div class="prodDescrizione">
                <strong>{{ $pairing->{'desc_'.app()->getLocale()} }}</strong>
            </div>

            <i>
                @lang('msg.codice_prodotto'): <br>
                {{$pairing->product1->codice}} + {{$pairing->product2->codice}}
            </i>
            <a href="{{url(app()->getLocale().'/pairing',['id'=>encrypt($pairing->id)])}}" class="dettagli" >
                <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
            </a>
        </div>
    </div>
</div>