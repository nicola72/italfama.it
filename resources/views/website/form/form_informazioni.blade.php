<div class="row">
    <!-- PRELOADER -->
    <div class="form-preloader" style="text-align: center; display: none">
        <img src="/img/loading.gif">
    </div>
    <!-- -->
    <div class="col-md-12">
        <h6 style="text-transform: uppercase;font-weight:bold;margin-bottom:20px;font-size:140%;margin-top:0">
            @lang('msg.contattaci_per_informazioni')
        </h6>
        <form action="" id="{{$form_name}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <input id="lang" name="lang" type="hidden"	value="{{app()->getLocale()}}" />
                @if(isset($pairing))
                <input id="codice_prodotto" name="codice_prodotto" type="hidden" value="{{ $pairing->{'nome_'.app()->getLocale()} }}" />
                @else
                <input id="codice_prodotto" name="codice_prodotto" type="hidden" value="{{ $product->codice }}" />
                @endif

                <div class="col-xs-12">
                    <div class="page-header">
                        @lang('msg.richiedi_informazioni')
                    </div>
                </div>
                <div class="form-group col-sm-4 col-xs-12">
                    <label for="">@lang('msg.nome')</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="" placeholder="@lang('msg.nome')" >

                </div>

                <div class="form-group col-sm-4 col-xs-12">
                    <label for="">@lang('msg.cognome')</label>
                    <input type="text" name="cognome" class="form-control" value="" placeholder="@lang('msg.cognome')"/>
                </div>

                <div class="form-group col-sm-4 col-xs-12">
                    <label for="">@lang('msg.telefono')</label>
                    <input type="text" name="telefono" class="form-control" value="" placeholder="@lang('msg.telefono')"/>
                </div>

                <div class="form-group col-sm-4 col-xs-12">
                    <label for="">Email *</label>
                    <input type="text" class="form-control" id="email" name="email" value="" placeholder="E-mail*" />

                </div>

                <div class="form-group col-sm-8 col-xs-12">
                    <label for="">@lang('msg.messaggio')</label>
                    @if(isset($pairing))
                    <textarea class="form-control" id="messaggio" name="messaggio"	rows="1">{{ $pairing->{'nome_'.app()->getLocale()} }}</textarea>
                    @else
                    <textarea class="form-control" id="messaggio" name="messaggio"	rows="1">Cod. {{ $product->codice }}</textarea>
                    @endif
                </div>


                <!-- per il CAPTCHA -->
                <div class="form-group col-sm-12">
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{$website_config['recaptcha_key']}}"></div>
                    </div>
                </div>
                <!-- fine CAPTCHA -->

                <!-- privacy -->
                <div class="form-group col-sm-12" style="margin-bottom:0px;">
                    <p style="width: 100%;font-size: 12px;text-align:left;">
                        Privacy* @lang('msg.consenso')
                        <input name="privacy" type="checkbox" id="privacy" value="Privacy" required />&nbsp;&nbsp; <br>
                        <a style="color:#000" href="{{$pages->where('nome','informativa')->first()->url()}}" >
                            @lang('msg.leggi_informativa')
                        </a>
                    </p>
                </div>
                <!-- fine privacy -->

                <div class="form-group col-sm-12">
                    <div id="{{$form_name}}-errore" class="error" style="display: none"></div>
                </div>

                <div class="form-group col-sm-12">
                    <button id="submit_btn" type="submit" class="btn btn-default" style="padding:8px 20px;">@lang('msg.invia')</button>
                    <span style="padding-top: 10px;font-size: 12px;display: block;">* @lang('msg.obbligatorio')</span>
                </div>
            </div>
        </form>
        <div id="{{$form_name}}-risposta" style="display: block;font-size:20px;text-align: center;padding-top: 40px;"></div>
    </div>
</div>
@section('js_script_form')
    <script src='https://www.google.com/recaptcha/api.js?hl={{app()->getLocale()}}'></script>

    <script>
        $("#{{ $form_name }}").validate({
            ignore: [],
            event: 'blur',
            rules: {
                nome: {required: false},
                email: {required: true, email: true},
                messaggio: {required: false},
                captcha_code: {required: true},
                privacy: {required: true},
            },
            messages: {
                nome: {required: "@lang('msg.obbligatorio')"},
                email: {required: "@lang('msg.obbligatorio')", email: "@lang('msg.inserisci_email_valida')"},
                messaggio: {required: "@lang('msg.obbligatorio')"},
                captcha_code: {required: "@lang('msg.obbligatorio')"},
                privacy: {required: "@lang('msg.obbligatorio')"}
            },
            submitHandler: function (form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{$form_action}}",
                    data: $('#{{ $form_name }}').serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $("#{{ $form_name }}").hide();
                        $(".form-preloader").show();
                    },
                    success: function (data)
                    {
                        if (data.result === 1)
                        {
                            $(".form-preloader").hide();
                            $("#{{ $form_name }}-risposta").html(data.msg);
                            $("#{{ $form_name }}-risposta").show();
                        } else
                        {
                            $(".form-preloader").hide();
                            $("#{{ $form_name }}-errore").html(data.msg);
                            $("#{{ $form_name }}-errore").fadeIn();
                            $("#{{ $form_name }}").fadeIn();
                        }

                    },
                    error: function ()
                    {
                        $(".form-preloader").hide();
                        $("#{{ $form_name }}-errore").html("@lang('msg.errore')");
                        $("#{{ $form_name }}-errore").fadeIn();
                        $("#{{ $form_name }}").fadeIn();
                    }
                });
            },
        });
    </script>
@stop