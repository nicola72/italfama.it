<form id="{{$form_name}}" method="post" action="{{ route('riepilogo_ordine',app()->getLocale()) }}">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $importo_carrello }}" name="importo_carrello">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="regalo" id="regalo"/>
                        <span class="conf-reg" style="font-size:130%;font-weight:bold">@lang('msg.confezione_regalo')</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label for="nome" >@lang('msg.nome')*</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{($user) ? $user->name : old('nome')}}" />
            </div>
            <div class="col-md-6">
                <label for="cognome" >@lang('msg.cognome')*</label>
                <input type="text" class="form-control" id="cognome" name="cognome" value="{{($user) ? $user->surname : old('cognome')}}"  />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label for="email" >Email*</label>
                <input type="text" class="form-control" id="email" name="email" value="{{($user) ? $user->email : old('email')}}"/>
            </div>
            <div class="col-md-6">
                <label for="tel" >@lang('msg.telefono')*</label>
                <input type="text" class="form-control" id="tel" name="tel" value="{{old('tel')}}"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <label for="indirizzo" >@lang('msg.indirizzo_di_consegna')*</label>
                <input type="text" class="form-control" name="indirizzo" value="{{old('indirizzo')}}">
            </div>
            <div class="col-md-6">
                <label for="cap">@lang('msg.cap')*</label>
                <input type="text" class="form-control" name="cap" value="{{old('cap')}}" maxlength="7">
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label for="citta">@lang('msg.citta')*</label>
                <input type="text" class="form-control" name="citta" value="{{old('citta')}}">
            </div>
            @if(app()->getLocale() == 'it')
            <div class="col-md-4">
                <div id="prov-camp">
                    <label for="prov">Provincia*</label>
                    <select id="prov" name="prov" class="form-control">
                        <option value="">&nbsp;</option>
                        @foreach($province as $prov)
                            <option value="{{$prov->sigla}}" {{ ($prov->sigla == old('prov')) ? 'selected' : '' }}>
                                {{$prov->provincia}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <label for="nazione">@lang('nazione')*</label>
                <select id="nazione" name="nazione" class="form-control" onchange="dropProvincia();">
                    <option value="">&nbsp;</option>
                    @foreach($countries as $country)
                        @if(app()->getLocale() == 'it')
                            <option value="{{$country->id}}" {{($country->nome_it == 'Italia') ? 'selected' : ''}}>
                                {{$country->nome_it}}
                            </option>
                        @else
                            <option value="{{$country->id}}" {{ ($country->id == old('nazione')) ? 'selected' : '' }}>
                                {{$country->nome_en}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <label for="data_nascita">@lang('msg.data_nascita')*</label>
                <input type="text" class="form-control datepicker" id="data_nascita" name="data_nascita" value="{{($user_details) ? $user_details->data_nascita->format('d/m/Y'): old('data_nascita')}}">
            </div>
            <div class="col-md-4">
                <label for="citta_nascita">@lang('msg.luogo_nascita')*</label>
                <input type="text" class="form-control" id="citta_nascita" name="citta_nascita" value="{{old('citta_nascita')}}">
            </div>
            <div class="col-md-4">
                <label for="pagamento">@lang('msg.pagamento')*</label>
                <select class="form-control" id="pagamento" name="pagamento">
                    <option value="">&nbsp;</option>
                    <option value="bonifico">@lang('msg.bonifico')</option>
                    @if($importo_carrello > 1000 && app()->getLocale() == 'it')
                    <option value="contrassegno" id="contrassegno">Contrassegno (solo Italia)</option>
                    @endif
                    <option value="paypal">@lang('msg.carta_di_credito')</option>
                </select>
            </div>

            <!-- privacy -->
            <div class="col-sm-12" style="margin-bottom:0px;margin-top:20px;">
                <p style="width: 100%;font-size: 12px;text-align:left;">
                    Privacy* @lang('msg.consenso')
                    <input name="privacy" type="checkbox" id="privacy" value="Privacy" />&nbsp;&nbsp; <br>
                    <a href="{{$pages->where('nome','modalita_pagamento')->first()->url()}}" style="color:#000">
                        @lang('msg.leggi_informativa')
                    </a>
                </p>
            </div>
            <!-- fine privacy -->
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <button id="submit_btn" type="submit" class="btn btn-default" style="color:#fff; background-color:#840025;">
                    @lang('continua')
                </button>
                <span style="padding-top: 10px;font-size: 12px;color:#000; display: block;">* @lang('obbligatorio')</span>
            </div>
        </div>
    </div>

</form>
@section('js_script_form')
<script>
    $(document).ready(function() {
        $("#{{$form_name}}").validate({
            rules: {
                nome:{ required: true },
                cognome:{ required: true},
                email:{ required: true,email:true},
                tel:{ required: true},
                indirizzo:{ required: true},
                cap:{ required: true},
                citta:{ required: true},
                @if(app()->getLocale() == 'it')
                prov:{ required: true},
                @endif
                nazione:{ required: true},
                data_nascita:{ required: true, dateITA : true},
                pagamento:{ required: true},
                privacy:{ required: true},
            },
            messages: {
                nome:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                cognome:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                email:{ required: "@lang('msg.questo_campo_obbligatorio')",email:"@lang('msg.inserisci_email_valida')" },
                tel:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                indirizzo:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                cap:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                citta:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                @if(app()->getLocale() == 'it')
                prov:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                @endif
                nazione:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                data_nascita:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                pagamento:{ required: "@lang('msg.questo_campo_obbligatorio')" },
                privacy:{ required: "@lang('msg.questo_campo_obbligatorio')" },
            },
            submitHandler: function (form) {
                ga("send", "event", "formacquisto", "submit");
                form.submit();
            }
        });

    });
</script>
@stop
