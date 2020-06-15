<div class="footer clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12" style="margin-bottom: 20px;">
                <div class="footerLink" style="color: #fff; line-height: 1.8em;">

                    Italfama<br /> via Guglielmo Marconi, 16<br /> 50041 Calenzano
                    @lang('msg.firenze')<br /> (FI) -  @lang('msg.toscana') -  @lang('msg.italia')<br /> tel:+390558878031<br />fax:+390558825453<br />
                    E-mail: - <a href="mailto:info@italfama.it?subject=Richiesta inviata da www.italfama.it">info@italfama.it</a><br />
                    <span style="font-size: 80%;">@lang('msg.piva') 01222380485 - Rea 260243</span><br>
                    Italfama è parte del Consorzio<br>ITALY BY ITALY<br>
                    <img src="/img/logo_footer2.jpg" width="60" alt="italfama">
                    <img src="/img/logo_footer.jpg" width="160" alt="italfama" style="margin-left: 10px;">
                </div>
            </div>
            <div class="col-md-5 col-xs-12" style="margin-bottom: 20px;">
                <div class="col-md-10 col-md-offset-1">
                    <img src="/img/foto_13.png" alt="" class="img-responsive" />
                    <p style="text-align:center;color:#fff">ITALFAMA NON SOLO SCACCHI</p>
                </div>
            </div>
            <div class="col-md-4 col-xs-12" style="margin-bottom: 20px;">
                <div class="footerLink" style="color: #fff; line-height: 1.8em;">
                    <?php $pages = array('home','azienda','dove_siamo','contatti','area_riservata');?>
                    <ul>
                        <li>
                            @if(app()->getLocale() == 'it')
                                - <a href="https://www.italfama.it" class="text-uppercase" style="font-size: 95%">home</a><br /><br />
                            @else
                                - <a href="https://www.italfama.it/en/home" class="text-uppercase" style="font-size: 95%">home</a><br /><br />
                            @endif
                        </li>
                        <li>
                            - <a href="{{url(app()->getLocale().'/azienda')}}" class="text-uppercase" style="font-size: 95%">@lang('msg.label_azienda')</a><br /><br />
                        </li>
                        <li>
                            - <a href="{{url(app()->getLocale().'/dove_siamo')}}" class="text-uppercase" style="font-size: 95%">@lang('msg.label_dove_siamo')</a><br /><br />
                        </li>
                        <li>
                            - <a href="{{url(app()->getLocale().'/contatti')}}" class="text-uppercase" style="font-size: 95%">@lang('msg.label_contatti')</a><br /><br />
                        </li>
                        <li>
                            - <a href="{{url(app()->getLocale().'/area_riservata')}}" class="text-uppercase" style="font-size: 95%">@lang('msg.label_area_riservata')</a><br /><br />
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- COPY RIGHT -->
<div class="copyRight clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-7 col-xs-12">
                <p>Copyright <?php echo date("Y",time());?> - @lang('msg.tutti_i_diritti_riservati') - <a
                            href="http://www.inyourlife.info" target="_blank">@lang('msg.siti_internet')</a>
                    by <a href="http://www.inyourlife.it" target="_blank">InYourLife</a>
                </p>
            </div>
            <div class="col-sm-5 col-xs-12">
                <ul class="list-inline">
                    <li><a id="scroll-top" href="#top" title="Top">Top<i class="fa fa-arrow-up"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
