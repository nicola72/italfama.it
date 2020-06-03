<div class="col-sm-4">
    <div class="productBox">
        <div class="productImage clearfix">
            <a href="{{ $product->url() }}">
                <img src="{{ $website_config['cs_small_dir'].$product->cover() }}" alt="{{$seo->alt ?? ''}}">
            </a>
        </div>
        <div class="productCaption clearfix">
            <a href="{{ $product->url() }}">
                <div class="titolo_prodotto">
                    @if(strlen($product->{'nome_'.app()->getLocale()}) > 50))
                        {{ substr($product->{'nome_'.app()->getLocale()},0,50) }}...
                    @else
                        {{ $product->{'nome_'.app()->getLocale()} }}
                    @endif

                </div>
            </a>
            <div class="fjalla prezzo" >
                @if($product->availability_id == 4)
                    @lang('msg.su_ordinazione')
                @else
                    @if($product->is_scontato())
                        <span class="FullProdPrice">@money($product->prezzo)</span>
                        &nbsp;&nbsp;
                        <span>@money($product->prezzo_scontato)</span>
                    @else
                        <span>@money($product->prezzo)</span>
                    @endif
                @endif
            </div>
            <div class="prodDescrizione">
                <strong>{{ $product->{'desc_'.app()->getLocale()} }}</strong>
            </div>

            <i>@lang('msg.codice_prodotto'): {{ $product->codice }}</i>
            <a href="{{ $product->url() }}" class="dettagli" >
                <i class="fa fa-search"></i> @lang('msg.dettagli_prodotto')
            </a>
        </div>
    </div>
</div>