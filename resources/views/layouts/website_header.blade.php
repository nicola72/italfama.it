<!-- HEADER -->
<div class="header clearfix">

    <!-- TOPBAR -->
    <div class="topBar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 hidden-sm hidden-xs"></div>
                <div class="col-md-6 col-xs-12">
                    <ul class="list-inline pull-right">
                        @if(app()->getLocale() == 'it')
                            <li><span><a href="javascript:void(0)" style="background-color: #cdc8c6;">IT</a><small>
						    | </small><a href="https://www.italfama.it/en/index" style="background-color: #666;">EN</a></span></li>
                        @else
                            <li><span><a href="https://www.italfama.it" style="background-color: #666;">IT</a><small>
						    | </small><a href="javascript:void(0)" style="background-color: #cdc8c6;">EN</a></span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- NAVBAR -->
    <nav class="navbar navbar-main navbar-default" role="navigation" style="background-color: #6f2412; border-radius: 0;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://www.italfama.it" style="min-height: 50px; display: block; float: none;">
                    <img src="/img/logo.png" alt="" style="margin-bottom: 2px;">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <li class="{{(Route::getCurrentRoute()->getActionMethod() == 'index') ? 'active':''}}">
                        @if(app()->getLocale() == 'it')
                            <a href="https://www.italfama.it" style="font-size: 95%">home</a>
                        @else
                            <a href="https://www.italfama.it/en/home" style="font-size: 95%">home</a>
                        @endif
                    </li>
                    <li class="{{(Route::getCurrentRoute()->getActionMethod() == 'azienda') ? 'active':''}}">
                        <a href="{{url(app()->getLocale().'/azienda')}}" style="font-size: 95%">@lang('msg.label_azienda')</a>
                    </li>
                    <li class="{{(Route::getCurrentRoute()->getActionMethod() == 'dove_siamo') ? 'active':''}}">
                        <a href="{{url(app()->getLocale().'/dove_siamo')}}" style="font-size: 95%">@lang('msg.label_dove_siamo')</a>
                    </li>
                    <li class="{{(Route::getCurrentRoute()->getActionMethod() == 'contatti') ? 'active':''}}">
                        <a href="{{url(app()->getLocale().'/contatti')}}" style="font-size: 95%">@lang('msg.label_contatti')</a>
                    </li>
                    <li class="{{(Route::getCurrentRoute()->getActionMethod() == 'area_riservata') ? 'active':''}}">
                        <a href="{{url(app()->getLocale().'/area_riservata')}}" style="font-size: 95%">@lang('msg.label_area_riservata')</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>

        <h4 class="text-center" style="color: #fff; padding-top: 10px; text-transform: none;">
            @lang('msg.info_acquisti')
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <a href="mailto:info@italfama.it?subject=Richiesta inviata da www.italfama.it">
                <i class="fa fa-envelope"></i>
                info@italfama.it
            </a>
        </h4>
    </nav>

</div>