<!-- PRELOADER -->
<div class="form-preloader" style="text-align: center; display: none">
    <img src="/img/loading.gif">
</div>
<!-- -->
<div id="form_registrazione_container">
    <form class="" action="#" id="{{$form_reg}}" method="post" data-type="contact">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="nome" >@lang('msg.nome')*</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" />
        </div>

        <div class="form-group">
            <label for="cognome" >@lang('msg.cognome')</label>
            <input type="text" class="form-control" id="cognome" name="cognome" value="{{old('cognome')}}"  />
        </div>

        <div class="form-group">
            <label for="email" >Email*</label>
            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}"/>
        </div>

        <div class="form-group">
            <label for="indirizzo">@lang('msg.indirizzo')</label>
            <input type="text" class="form-control" id="indirizzo" name="indirizzo" value="{{old('indirizzo')}}"/>
        </div>

        <div class="form-group">
            <label for="cap" >@lang('msg.cap')</label>
            <input type="text" class="form-control" id="cap" name="cap" value="{{old('cap')}}"/>
        </div>

        <div class="form-group">
            <label for="cap" >@lang('msg.citta')</label>
            <input type="text" class="form-control" id="citta" name="citta" value="{{old('citta')}}"/>
        </div>

        <div class="form-group">
            <label for="cap" >@lang('msg.nazione')</label>
            <input type="text" class="form-control" id="nazione" name="nazione" value="{{old('nazione')}}"/>
        </div>

        <div class="form-group">
            <label for="cap" >@lang('msg.telefono')</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{old('telefono')}}"/>
        </div>

        <div class="form-group">
            <label for="messaggio" >@lang('msg.messaggio')</label>
            <textarea class="form-control" id="messaggio" name="messaggio"></textarea>
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
            <div id="{{$form_reg}}-errore" class="error" style="display: none"></div>
        </div>

        <div class="form-group col-sm-12">
            <button id="submit_btn" type="submit" class="btn btn-default" style="padding:8px 20px;">@lang('msg.invia')</button>
            <span style="padding-top: 10px;font-size: 12px;display: block;">* @lang('msg.obbligatorio')</span>
        </div>
    </form>
    <div id="{{$form_reg}}-risposta" style="display: block;font-size:20px;text-align: center;padding-top: 40px;"></div>
</div>
@section('js_script_form2')
    <script src='https://www.google.com/recaptcha/api.js?hl={{app()->getLocale()}}'></script>

    <script>
        $("#{{$form_reg}}").validate({
            ignore: [],
            event: 'blur',
            rules: {
                nome:{ required: false },
                email:{ required: true,email:true},
                privacy:{required: true},
                captcha_code:{ required: true}
            },
            messages: {
                nome: {required: "@lang('msg.obbligatorio')"},
                email: {required: "@lang('msg.obbligatorio')", email: "@lang('msg.inserisci_email_valida')"},
                messaggio: {required: "@lang('msg.obbligatorio')"},
                captcha_code: {required: "@lang('msg.obbligatorio')"},
                privacy: {required: "@lang('msg.obbligatorio')"}
            },
            submitHandler: function(form)
            {
                $.ajax({
                    type: "POST",
                    url: "{{url(app()->getLocale().'/register')}}",
                    data: $('#{{ $form_reg }}').serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $("#{{ $form_reg }}").hide();
                        $(".form-preloader").show();
                    },
                    success: function(data)
                    {
                        if (data.result === 1)
                        {
                            $(".form-preloader").hide();
                            $("#{{ $form_reg }}-risposta").html(data.msg);
                            $("#{{ $form_reg }}-risposta").show();
                        } else
                        {
                            $(".form-preloader").hide();
                            $("#{{ $form_reg }}-errore").html(data.msg);
                            $("#{{ $form_reg }}-errore").fadeIn();
                            $("#{{ $form_reg }}").fadeIn();
                        }
                    },
                    error: function()
                    {
                        $(".form-preloader").hide();
                        $("#{{ $form_reg }}-errore").html("@lang('msg.errore')");
                        $("#{{ $form_reg }}-errore").fadeIn();
                        $("#{{ $form_reg }}").fadeIn();
                    },
                });
            },
            invalidHandler: function(form)
            {
                //alert("errore");
                //$(".messaggioerr").empty();
                //$(".messaggioerr").html("<div style='border:2px solid red;padding:5px;margin-bottom:10px;color:red;'><i>Ricorda:</i> E' obbligatorio compilare i campi nelle lingue presenti</div>");
            }
        });
    </script>
@stop
