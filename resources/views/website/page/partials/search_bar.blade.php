<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5 class="playfair_titolo" style="text-align: left;">
                    <span style="font-size: 80%;">@lang('msg.ricerca_avanzata')</span>
                </h5>
                <form style="margin-top: -40px;" action="{{ url(app()->getLocale().'/ricerca') }}" method="post">
                    <div class="form-group col-sm-3 col-xs-12">
                        <label for="">@lang('msg.codice')</label>
                        <input type="text" name="codice" class="form-control" placeholder="" />
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label for="">@lang('msg.materiale')</label>
                        <input type="text" name="materiale" class="form-control" />
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <label for="">@lang('msg.parola_chiave')</label>
                        <input type="text"	name="parola" class="form-control" />
                    </div>
                    <div class="form-group col-sm-3 col-xs-12">
                        <input type="submit" value="@lang('msg.cerca')" class="form-control"  style="background-color: #6f2412; color: #fff; margin-top: 23px;" />
                    </div>

                </form>
            </div>
            <div style="clear: both; height: 30px;"></div>
        </div>
    </div>
</section>