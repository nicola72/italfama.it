@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla" style="color: #6f2412;">@lang('msg.dove_siamo')</h2>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="mainContent clearfix productsContent">
        <div class="container">
            <div class="row">

                <!-- COLONNA A SINISTRA -->
                <div class="col-md-3 col-sm-12 col-xs-12 sideBar ">

                    <!-- menu prodotti -->
                @include('layouts.website_menu_prodotti')
                <!-- fine menu prodotti -->


                </div>
                <!-- FINE COLONNA SINISTRA -->

                <!-- PAGINA -->
                <div class="col-md-9 col-sm-12 col-xs-12 sideBar ">
                    <div class="row">
                        <div class="col-md-4">
                            @if(app()->getLocale() == 'en')
                                <div style="padding:0 10px;">
                                    <div class="" style="font-size:120%;line-height:1.5">
                                        <strong>ITALFAMA</strong><br>
                                        via Guglielmo Marconi, 16<br>
                                        50041 Calenzano<br>
                                        Florence (FI) - Tuscany - Italy<br><br><br>

                                    </div>
                                    From the A1 highway exit at Sesto Fiorentino - Calenzano
                                    (our company is only 1,6 km far from the exit).<br/><br/>
                                    After the exit, turn right and then go straight on.<br/>
                                    <br/>After driving through 3 roundabouts, you will see a little bridge on the river Marina: continue going straight on and you will get to another roundabout.
                                    Go on, take the first turn to the right
                                    (via Meucci) and than the first turn on the left (via Guglielmo Marconi).<br/>
                                    <br/>Italfama is at the end of the street, last building on the right.<br><br>
                                </div>
                            @else
                                <div style="padding:0 10px;">
                                    <div class="" style="font-size:120%;line-height:1.5">
                                        <strong>ITALFAMA</strong><br>
                                        via Guglielmo Marconi, 16<br>
                                        50041 Calenzano<br>
                                        Firenze (FI) - Toscana - Italia<br><br><br>

                                    </div>
                                    Uscita autostrada A1 - Sesto Fiorentino - Calenzano (dall’uscita dell’autostrada all’azienda  ci sono 1,6 km).<br/><br/>
                                    Dopo l’uscita svoltare a destra e proseguire a diritto.<br/><br/>
                                    Oltrepassare tre rotonde e poi il ponticino del fiume Marina proseguendo sempre a diritto,
                                    oltrepassare un’altra rotonda e svoltare alla prima a destra (via Meucci)
                                    e di seguito alla prima a sinistra (via Guglielmo Marconi).<br/><br/>
                                    Italfama si trova in fondo alla via, ultimo stabilimento sulla destra.<br><br>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2876.7760630266257!2d11.148391315504485!3d43.860469979114804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf314c7fa9c9b8904!2sItalfama!5e0!3m2!1sit!2sit!4v1482934198296" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </section>

@endsection
@section('js_script')

@stop