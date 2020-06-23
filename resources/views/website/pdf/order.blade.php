<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Ordine n° {{$order->id}}</title>
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 12px;
        }

        /*img {
            max-width: 100%;
        }*/

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            font-family: Arial;
            width: 100% !important;
            height: 100%;
            line-height: 1.1;
        }

        /* Let's make sure all tables have defaults */
        table td {
            vertical-align: top;
        }

        /* -------------------------------------
            BODY & CONTAINER
        ------------------------------------- */
        body {
            background-color: #f6f6f6;
            color:#2b2b2b;
        }

        /* -------------------------------------
            TYPOGRAPHY
        ------------------------------------- */
        h1, h2, h3 {
            font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
            color: #252525;
            margin: 10px 0 0;
            line-height: 1.2;
            font-weight: bold;
        }

        h1 {
            font-size: 32px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 14px;
        }

        h4 {
            font-size: 12px;
            font-weight: bold;
        }

        p, ul, ol {
            margin-bottom: 10px;
            font-weight: normal;
        }
        p li, ul li, ol li {
            margin-left: 5px;
            list-style-position: inside;
        }

        /* -------------------------------------
            LINKS & BUTTONS
        ------------------------------------- */
        a {
            color: #1ab394;
            text-decoration: underline;
        }

    </style>
</head>

<body>
<table style="margin-left:auto;margin-right:auto;border:1px solid #ddd;margin-top:20px;padding:20px;margin-bottom:20px" cellpadding="2" cellspacing="2">
    <tr>
        <td style="text-align: center">
            <img src="https://www.italfama.it/img/logo.png" alt="" />
        </td>
    </tr>
    <tr>
        <th>
            <h3 style="margin-bottom: 30px">Ordine n° {{$order->id}} del {{$order->created_at->format('d/m/Y')}}</h3>
        </th>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="0" style="font-size: 12px;">
                <tr>
                    <th>Codice</th>
                    <th>Nome</th>
                    <th>Q.tà</th>
                    <th>Prezzo</th>
                    <th>Totale</th>
                </tr>
                @foreach($order->orderDetails as $item)
                    <tr>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            {{$item->codice}}
                        </td>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            {{$item->nome_prodotto}}
                        </td>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            {{$item->qta}}
                        </td>
                        <td style="border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            @money($item->prezzo)
                        </td>
                        <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                            @money($item->totale)
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align:right">
            <table style="margin-bottom:20px" cellpadding="2" cellspacing="2">
                <tr>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@lang('msg.sconto'):</h4>
                    </td>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@money($order->sconto)</h4>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@lang('msg.imponibile'):</h4>
                    </td>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@money($order->imponibile)</h4>
                    </td>
                </tr>

                <tr>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@lang('msg.iva'):</h4>
                    </td>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h4>@money($order->iva)</h4>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h3>@lang('msg.totale'):</h3>
                    </td>
                    <td style="text-align: right;border-bottom:1px solid #ddd;padding-bottom: 6px;padding-top: 6px;">
                        <h3>@money($order->importo)</h3>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="2">
                <tr>
                    <td>
                        <h4>DETTAGLI CLIENTE:</h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="2" cellspacing="2">
                            <tr>
                                <td>Nome:</td>
                                <td>{{$order->user->name}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{$order->user->email}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>



</body>
</html>
