<?php
namespace App\Http\Controllers\Website;

use App\Mail\Contact;
use App\Model\ItalCart;
use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Macrocategory;
use App\Model\Material;
use App\Model\Newsitem;
use App\Model\Page;
use App\Model\Pairing;
use App\Model\Review;
use App\Model\Style;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\GoogleRecaptcha;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $carts = $this->getCarts();

        if(!\Auth::check())
        {
            return redirect('/');
        }

        $user = \Auth::user();

        $importo_carrello = 0;
        foreach($carts as $cart)
        {
            $importo_carrello+= ($cart->product->prezzo_netto($user) * $cart->qta);
        }


        $params = [
            'carts' => $carts,
            'form_name' => 'form_carrello',
            'user' => $user,
            'importo_carrello' => $importo_carrello,
        ];

        return view('website.cart.index',$params);
    }

    public function resume(Request $request)
    {
        //inserisco i dati nella sessione
        $request->flash();

        $request->validate([
            'nome'         => 'required',
            'cognome'      => 'required',
            'nazione'      => 'required',
            'email'        => 'required',
            'citta'        => 'required',
            'indirizzo'    => 'required',
            'tel'          => 'required',
            'cap'          => 'required',
            'data_nascita' => 'required',
            'citta_nascita'=> 'required',
            'pagamento'    => 'required'
        ]);

        $spedizione = [];

        $spedizione['nome']          = $request->post('nome');
        $spedizione['cognome']       = $request->post('cognome');
        $spedizione['email']         = $request->post('email');
        $spedizione['indirizzo']     = $request->post('indirizzo');
        $spedizione['citta']         = $request->post('citta');
        $spedizione['prov']          = $request->post('prov',null);
        $spedizione['cap']           = $request->post('cap');
        $spedizione['tel']           = $request->post('tel');
        $spedizione['data_nascita']  = $request->post('data_nascita');
        $spedizione['citta_nascita'] = $request->post('citta_nascita');


        $country_id = $request->post('nazione');
        $spedizione['nazione'] = $country_id;

        $country = Country::find($country_id);

        $pagamento = $request->post('pagamento');
        $spedizione['pagamento'] = $pagamento;

        $peso_carrello = \Session::get('preso_carrello');

        $esenzione_iva = EsenzioneIva::get($country);
        $spedizione['esenzione_iva'] = $esenzione_iva;

        $spese_pagamento = ($pagamento == 'contrassegno') ? 9 : 0;
        $spedizione['spese_pagamento'] = $spese_pagamento;

        $confezione_regalo = array_key_exists('regalo', $request->all()) ? 1 : 0;
        $spedizione['confezione_regalo'] = $confezione_regalo;

        $carts = $this->getCarts();

        $importo_carrello = 0;
        $importo_prodotti = 0;
        $tot_qta = 0;
        foreach($carts as $cart)
        {
            $importo_carrello+= ($cart->product->prezzo_vendita() * $cart->qta);
            $importo_prodotti+= ($cart->product->prezzo_vendita() * $cart->qta);
            $tot_qta+= $cart->qta;
        }

        if(\Auth::check())
        {
            $user = \Auth::getUser();
            $user_details = UserDetail::where('user_id', $user->id)->first();
        }
        else
        {
            $user = false;
            $user_details = false;
        }

        // SPESE SPEDIZIONE
        $spese_spedizione = SpeseSpedizione::get($country, $peso_carrello,$importo_carrello);
        $spedizione['spese_spedizione'] = $spese_spedizione;

        // IMPONIBILE E IMPONIBILE PIù IVA
        $imponibile_carrello = round(($importo_carrello / 1.22), 2);
        $spedizione['imponibile'] = $imponibile_carrello;
        $spedizione['imponibile_piu_iva'] = $importo_carrello;

        // IVA DEL CARRELLO
        $iva_carrello = $importo_carrello - $imponibile_carrello;
        $spedizione['iva_carrello'] = $iva_carrello;

        //SPESA PER CONF.REGALO
        $spesa_conf_regalo = 0;
        if($confezione_regalo)
        {
            $spesa_conf_regalo = 5;
        }
        $spedizione['spesa_conf_regalo'] = $spesa_conf_regalo;

        //SE ESENTE IVA LA TOLGO DALL'IMPORTO DEL CARRELLO
        $tax_refund = 0;
        if($esenzione_iva == "1")
        {
            $tax_refund = $iva_carrello;
        }
        $importo_carrello = $importo_carrello - $tax_refund;
        $spedizione ['tax_refund'] = $tax_refund;

        $spedizione ['importo_carrello'] = $importo_carrello;

        //COUPON
        $sconto_coupon = 0;
        if(Session::get('coupon'))
        {
            $coupon = Session::get('coupon');
            if($coupon['tipo_sconto'] == 'fisso')
            {
                $sconto_coupon = $coupon['ammontare_sconto'];
            }
            else
            {
                $sconto_coupon = ($importo_carrello * $coupon['ammontare_sconto']) / 100;
            }
        }
        $spedizione['sconto_coupon'] = $sconto_coupon;

        $totale_carrello = $importo_carrello - $sconto_coupon + $spese_spedizione + $spese_pagamento + $spesa_conf_regalo;
        $totale_carrello = ($totale_carrello < 0) ? 0 : $totale_carrello;

        //inserisco tutti i dati nella sessione
        \Session::put('spedizione',$spedizione);

        $params = [
            'carts' => $carts,
            'user' => $user,
            'country' => $country,
            'user_details' => $user_details,
            'importo_carrello' => $importo_carrello,
            'importo_prodotti' => $importo_prodotti,
            'spese_spedizione' => $spese_spedizione,
            'sconto_coupon' => $sconto_coupon,
            'pagamento' => $pagamento,
            'spese_conf_regalo' => $spesa_conf_regalo,
            'spese_pagamento' => $spese_pagamento,
            'esente_iva' => $esenzione_iva,
            'tax_refund' => $tax_refund,
            'imponibile' => $imponibile_carrello,
            'totale_carrello' => $totale_carrello,
            'iva_carrello' => $iva_carrello,
            'tot_qta' => $tot_qta
        ];

        return view('website.cart.riepilogo_ordine',$params);
    }

    public function submit()
    {
        $carts = $this->getCarts();

        $sconto_coupon = Session::get('spedizione')['sconto_coupon'];
        $spesa_conf_regalo = Session::get('spedizione')['spesa_conf_regalo'];

        $importo_carrello = 0;
        $importo_prodotti = 0;
        $tot_qta = 0;
        foreach($carts as $cart)
        {
            $importo_carrello+= ($cart->product->prezzo_vendita() * $cart->qta);
            $importo_prodotti+= ($cart->product->prezzo_vendita() * $cart->qta);
            $tot_qta+= $cart->qta;
        }

        $imponibile_carrello = round(($importo_carrello / 1.22), 2);
        $iva_carrello = $importo_carrello - $imponibile_carrello;

        if(Session::get('spedizione')['esenzione_iva'] == 1)
        {
            $importo_carrello = $importo_carrello - $iva_carrello;
            $iva_carrello = 0;
        }

        //Pagamento PAYPAL
        if(Session::get('spedizione')['pagamento'] == 'paypal')
        {

        }
        else
        {

        }
    }

    public function update(Request $request)
    {
        $cart_id = $request->query('id');
        $qta = $request->query('qta');

        $cart = Cart::find($cart_id);
        if(!$cart)
        {
            return ['result' => 0, 'msg'=> trans('msg.errore')];
        }

        try{
            $product = Product::find($cart->product_id);
            if($product->stock < $qta)
            {
                return ['result' => 0,'msg' => trans('msg.prodotto_non_piu_disponibile')];
            }
            $cart->qta = $qta;
            $cart->save();
        }
        catch(\Exception $e)
        {
            return ['result' => 0, 'msg'=> trans('msg.errore')];
        }
        return ['result' => 1,'msg' => trans('msg.quantita_aggiornata')];

    }

    public function destroy(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->delete();

        return back()->with('success',trans('msg.prodotto_eliminato_con_successo'));
    }

    public function addproduct(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);

        //se il prodotto non esiste esco
        if(!$product)
        {
            return ['result' => 0,'msg' => trans('msg.prodotto_non_trovato')];
        }

        $qta = 1; //la quantità è sempre 1

        //controllo che il prodotto non sia già nel carrello
        $cart = Cart::where('product_id',$product->id)->where('session_id',session()->getId())->first();

        //se già nel carrello
        if($cart)
        {
            //se il prodotto non è disponibile
            if($product->stock < ($qta + $cart->qta))
            {
                return ['result' => 0,'msg' => trans('msg.prodotto_non_piu_disponibile')];
            }

            try{

                $cart->qta = $cart->qta + 1;
                if(\Auth::user())
                {
                    $cart->user_id = \Auth::user()->id;
                }
                $cart->save();
            }
            catch(\Exception $e){

                return ['result' => 0,'msg' => $e->getMessage()];
            }

        }
        else
        {
            //se il prodotto non è disponibile
            if($product->stock < $qta)
            {
                return ['result' => 0,'msg' => trans('msg.prodotto_non_piu_disponibile')];
            }

            try{

                $cart = new Cart();
                $cart->product_id = $product->id;
                $cart->session_id = session()->getId();
                $cart->qta = $qta;
                if(\Auth::user())
                {
                    $cart->user_id = \Auth::user()->id;
                }
                $cart->save();
            }
            catch(\Exception $e){

                return ['result' => 0,'msg' => $e->getMessage()];
            }

        }

        return ['result' => 1,'msg' => trans('msg.prodotto_aggiunto_al_carrello')];
    }

    private function getCarts()
    {
        if(\Auth::check())
        {
            $user = \Auth::getUser();
            $carts = Cart::where('user_id',$user->id)->get();
        }
        else
        {
            $carts = Cart::where('session_id',session()->getId())->get();
        }
        return $carts;
    }
}