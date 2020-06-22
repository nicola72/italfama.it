@extends('layouts.website')
@section('content')
    <section class="lightSection clearfix pageHeader">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="page-title">
                        <h2 class="fjalla" style="color: #6f2412;">@lang('msg.azienda')</h2>
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
                        <div class="col-md-8">
                            <div style="font-size: 160%; line-height: 1.6">
                                <div style="padding: 0 10px;">
                                    @if(app()->getLocale() == 'it')
                                        <strong>Italfama</strong> nasce nel 1976 in provincia di Firenze, grazie ad Aldo
                                        Marsili ed alla sua passione per il gioco degli scacchi, ma
                                        soprattutto grazie alle sue capacità manuali nelle lavorazioni
                                        artigianali ed alla sua passione artistica. Le prime scacchiere
                                        realizzate per gli amici ebbero talmente successo che ben
                                        presto, quel che era nato come un semplice hobby, divenne a
                                        tutti gli effetti il lavoro di una vita, facendo di <strong>Italfama</strong>
                                        azienda di riferimento a livello mondiale per la produzione di
                                        scacchi e scacchiere artistiche di alta qualità.<br><br> <strong>Italfama</strong>
                                        propone scacchiere sia in stile classico che contemporaneo,
                                        oltre a scacchi a tema storico come la riproduzione di famose
                                        battaglie e personaggi della storia antica e recente. Per la
                                        realizzazione delle scacchiere <strong>Italfama</strong> vengono scelti con cura
                                        materiali di pregio quali la radica di olmo e di noce, pietre
                                        semipreziose come l’ onice, il marmo di Carrara e la malachite,
                                        mentre gli scacchi sono realizzati con l’utilizzo di vari
                                        metalli fra i quali l’ottone massiccio ed il bronzo, con
                                        svariate finiture che spaziano dal classico satinato al
                                        raffinato oro ed argento. <br><br>Il 1999 è stato un anno importante
                                        per <strong>Italfama</strong>, la quale acquisisce l’azienda “Piero Benzoni” di
                                        Milano, famosa per la produzione di scacchi e scacchiere
                                        esclusive in edizione limitata, realizzate in bronzo
                                        artigianalmente usando il procedimento di fusione in cera
                                        persa, antico metodo tramandato negli anni dal famoso scultore
                                        Benvenuto Cellini nel 1550 e tutt’ora utilizzato nel settore
                                        della gioielleria.<br> Queste opere esclusive vengono rifinite con
                                        oro 24 carati e argento.<br> Con il loro ingresso in società, i
                                        figli Tommaso e Marco apportano numerose idee moderne ed
                                        innovative, che si traducono nel lancio di nuove linee di
                                        prodotto, nuove finiture e nuove strategie aziendali. <strong>Italfama</strong>
                                        apre nel 2002 il proprio punto vendita ufficiale a Firenze in
                                        Borgo San Jacopo vicino al Ponte Vecchio, diventato oramai meta
                                        obbligata per molti clienti affezionati provenienti da tutto il
                                        mondo in visita a Firenze.<br><br> Nel 2005 <strong>Italfama</strong> debutta sul
                                        mercato online con un elegante sito web riservato ai
                                        rivenditori www.italfama.it ed un sito riservato alla vendita.
                                        Il 2017 è un altro anno fondamentale. <strong>Italfama</strong> acquisisce
                                        l’azienda milanese “La Bottega dal Vasari”, specializzata
                                        anch’essa nella produzione di scacchi e scacchiere artistiche
                                        in bronzo, rimarcando ancora di più a livello mondiale
                                        l’unicità delle proprie scacchiere prodotte completamente a
                                        mano. Da oltre 40 anni <strong>Italfama</strong> partecipa alle più importanti
                                        fiere internazionali del complemento di arredo, decorazione
                                        della casa e del regalo, in Italia a Milano ed all’estero in
                                        Germania, Inghilterra, Russia, e presto anche in Usa e nei
                                        paesi asiatici. Recentemente <strong>Italfama</strong> ha festeggiato i suoi 40
                                        anni di attività, e prosegue il proprio lavoro artigianale,
                                        sempre attenta alle esigenze dei propri clienti e con gli
                                        stessi valori di sempre: grande passione, impegno e massima
                                        cura nei minimi dettagli. <br>
                                        <br>
                                    @else
                                        <strong>Italfama</strong> was founded in 1976 near Florence, thanks to Aldo
                                        Marsili and his passion for chess, but especially thanks to his
                                        abilities in craft work and his artistic passion.<br> The first
                                        chessboards made for his friends were so successful that very
                                        soon, what started as a simple hobby, became a fully-fledged
                                        life’s work, making <strong>Italfama</strong> a world class factory in the
                                        production of high quality chess pieces and chessboards.
                                        <strong>Italfama</strong> offers chessboards in both classic and contemporary
                                        style, as well as historically themed chess pieces such as
                                        those from famous battles and characters from ancient and
                                        modern history.<br><br> To create the <strong>Italfama</strong> chessboards, precious
                                        materials are carefully chosen, like elm and walnut briar wood,
                                        semiprecious stones like onyx, Carrara marble and malachite,
                                        while the chess pieces were fashioned with the use of many
                                        metals, including solid brass and bronze, in various finishes
                                        that span from classic satin to refined gold and silver.<br><br> 1999
                                        was an important year for <strong>Italfama</strong>, they acquired the “Piero
                                        Benzoni” factory in Milan, famous for the production of
                                        exclusive chess pieces and chessboards in limited editions,
                                        hand made in bronze using the lost wax casting process, an
                                        ancient method handed down by the famous sculptor Benvenuto
                                        Cellini in 1550 and still ongoing in the jewellery sector.
                                        These exclusive masterpieces are refined with 24k gold and
                                        silver.<br> With their entry in the company, the sons Tommaso and
                                        Marco contribute with several modern and innovative ideas,
                                        which results in the launch of new products lines, new finishes
                                        and new company strategies.<br> <strong>Italfama</strong> opened it’s own official
                                        point of sale in Florence in 2002, in Borgo San Jacopo near
                                        Ponte Vecchio, and has already become a classic destination for
                                        many dedicated customers from all over the world to visit
                                        Florence. In 2005 <strong>Italfama</strong> made it’s debut in the online market
                                        with an elegant website reserved for retailers www.italfama.it
                                        and a website reserved for sales. <br><br>The year 2017 was another
                                        fundamental one. <strong>Italfama</strong> acquired the factory “La Bottega del
                                        Vasari” in Milan, which itself specialized in the production of
                                        artistic chess pieces and chessboards made in bronze, to point
                                        out the worldwide uniqueness of its chessboards completely hand
                                        made. <br>Since 40 years <strong>Italfama</strong> exhibit at the most important
                                        international fairs of home décor, gift and furniture, in Italy
                                        in Milan and abroad in Germany, England, Russia and soon in USA
                                        and Asian countries. Recenty <strong>Italfama</strong> celebrated its 40 years
                                        of business, and continues its own hand made work, still paying
                                        a great deal of attention to its customers needs and always
                                        with the same values: great passion, commitment and highest
                                        care down to the last detail. <br />
                                        <br />
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <img src="/img/foto_1.png" alt="" class="img-responsive" />
                            </div>
                            <br />

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