<form id="{{ $form_login }}" action="" method="post" data-type="contact">
    {{ csrf_field() }}
    <div class="form-group">
        <label>username/email</label>
        <input class="form-control" name="email" id="email" />
    </div>
    <div class="form-group">
        <label>password</label>
        <input class="form-control" type="password" name="password" id="password" />

    </div>
    <div class="form-group">
        <button id="submit_btn" type="submit" class="btn btn-default" style="color:#fff; background-color:#000">Login</button>
    </div>
    <div class="form-group">
        <div id="login_msg" style="color:red">

        </div>
    </div>
</form>
@section('js_script_form')
    <script>
        $(document).ready(function() {

            $("#{{ $form_login }}").validate({
                ignore: [],
                event: 'blur',
                rules: {
                username:{ required: true },
                pass:{ required: true},
            },
                messages: {
                username:{ required: "@lang('msg.obbligatorio')" },
                pass:{ required: "@lang('msg.obbligatorio')" },

            },
            submitHandler: function(form)
            {
                $('#login_msg').html( '' );

                $.ajax({
                type: "POST",
                url: "{{route('website.login',['locale'=>app()->getLocale()])}}",
                data : $('#{{ $form_login }}').serialize(),
                dataType: "json",

                    success: function(data)
                    {
                        if (data.result === 1)
                        {
                            location.assign(data.url);
                        }

                        $('#login_msg').html(data.msg);

                    },
                    error: function(data)
                    {

                        if(data.status === 422)
                        {
                            $('#login_msg').html(data.responseJSON.message);
                        }
                        else
                        {
                            $('#login_msg').html('Errore');
                        }
                    },
                });
            },

        });
        });
    </script>
@stop