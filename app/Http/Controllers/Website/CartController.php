<?php
namespace App\Http\Controllers\Website;

use App\Mail\Contact;
use App\Mail\Order;
use App\Model\ItalCart;
use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\ItalOrder;
use App\Model\ItalOrderDetail;
use App\Model\Macrocategory;
use App\Model\Material;
use App\Model\Newsitem;
use App\Model\Page;
use App\Model\Pairing;
use App\Model\Product;
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
        if(!\Auth::check())
        {
            return redirect('/');
        }

        $user = \Auth::user();
        $carts = ItalCart::where('user_id',$user->id)->get();

        $importo_carrello = 0;
        foreach($carts as $cart)
        {
            $importo_carrello+= ($cart->product->prezzo_netto($user) * $cart->qta);
        }

        $sconto_importo = $this->sconto_importo($importo_carrello);

        $importo_totale = $importo_carrello - $sconto_importo;

        $sconto_bonifico = 0;
        if(\Auth::user()->vede_sconto_bonifico)
        {
            $sconto_bonifico = ($importo_totale/100) * 3;
            $importo_totale = $importo_totale - $sconto_bonifico;
        }

        $params = [
            'carts' => $carts,
            'form_name' => 'form_carrello',
            'user' => $user,
            'importo_carrello' => $importo_carrello,
            'sconto_importo' => $sconto_importo,
            'importo_totale' => $importo_totale,
            'sconto_bonifico' => $sconto_bonifico,
        ];

        return view('website.cart.index',$params);
    }

    public function update(Request $request)
    {
        $cart_id = $request->query('id');
        $qta = $request->query('qta');

        $cart = ItalCart::find($cart_id);
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
        $cart = ItalCart::find($request->id);
        $cart->delete();

        return back()->with('success',trans('msg.prodotto_eliminato_con_successo'));
    }

    public function addpairing(Request $request)
    {
        if(!\Auth::check())
        {
            return ['result' => 0,'msg' => trans('msg.devi_effetture_il_login_prima')];
        }

        $id = $request->id;

        $pairing = Pairing::find($id);


        $product1 = $pairing->product1;
        $product2 = $pairing->product2;

        if(!is_object($product1) || !is_object($product2))
        {
            return ['result' => 0,'msg' => trans('msg.errore')];
        }

        $qta = 1; //la quantità è sempre 1

        $prodotti_da_inserire = [$product1,$product2];

        foreach($prodotti_da_inserire as $product)
        {
            //controllo che il prodotto non sia già nel carrello
            $cart = ItalCart::where('product_id',$product->id)->where('user_id',\Auth::user()->id)->first();

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

                    $cart = new ItalCart();
                    $cart->product_id = $product->id;
                    $cart->session_id = session()->getId();
                    $cart->qta = $qta;
                    $cart->user_id = \Auth::user()->id;
                    $cart->save();
                }
                catch(\Exception $e){

                    return ['result' => 0,'msg' => $e->getMessage()];
                }

            }
        }

        return ['result' => 1,'msg' => trans('msg.prodotto_aggiunto_al_carrello')];
    }

    public function addproduct(Request $request)
    {
        if(!\Auth::check())
        {
            return ['result' => 0,'msg' => trans('msg.devi_effetture_il_login_prima')];
        }
        $id = $request->id;

        $product = Product::find($id);

        //se il prodotto non esiste esco
        if(!$product)
        {
            return ['result' => 0,'msg' => trans('msg.prodotto_non_trovato')];
        }

        $qta = 1; //la quantità è sempre 1

        //controllo che il prodotto non sia già nel carrello
        $cart = ItalCart::where('product_id',$product->id)->where('user_id',\Auth::user()->id)->first();

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

                $cart = new ItalCart();
                $cart->product_id = $product->id;
                $cart->session_id = session()->getId();
                $cart->qta = $qta;
                $cart->user_id = \Auth::user()->id;
                $cart->save();
            }
            catch(\Exception $e){

                return ['result' => 0,'msg' => $e->getMessage()];
            }

        }

        return ['result' => 1,'msg' => trans('msg.prodotto_aggiunto_al_carrello')];
    }

    public function checkout()
    {
        if(!\Auth::check())
        {
            return redirect()->route('website.home');
        }

        $user = \Auth::user();
        $carts = ItalCart::where('user_id',$user->id)->get();

        $importo_carrello = 0;
        foreach($carts as $cart)
        {
            $importo_carrello+= ($cart->product->prezzo_netto($user) * $cart->qta);
        }

        $sconto_importo = $this->sconto_importo($importo_carrello);

        $importo_totale = $importo_carrello - $sconto_importo;

        $sconto_bonifico = 0;
        if(\Auth::user()->vede_sconto_bonifico)
        {
            $sconto_bonifico = ($importo_totale/100) * 3;
        }
        $importo_totale = $importo_totale - $sconto_bonifico;

        $config = \Config::get('website_config');
        $iva = ($importo_totale / 100)* $config['iva'];

        try{

            $order = new ItalOrder();
            $order->user_id = \Auth::user()->id;
            $order->sconto = $sconto_importo;
            $order->imponibile = $importo_totale;
            $order->iva = $iva;
            $order->importo = $importo_totale + $iva;

            $order->save();

            foreach($carts as $cart)
            {
                $orderDetail = new ItalOrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $cart->product_id;
                $orderDetail->codice = $cart->product->codice;
                $orderDetail->nome_prodotto = $cart->product->{'nome_'.\App::getLocale()};
                $orderDetail->qta = $cart->qta;
                $orderDetail->prezzo = $cart->product->prezzo_netto(\Auth::user());
                $orderDetail->totale = $cart->product->prezzo_netto(\Auth::user()) * $cart->qta;
                $orderDetail->save();
            }
        }
        catch(\Exception $e){

            if($config['in_sviluppo'])
            {
                return back()->with('error',$e->getMessage());
            }
            return back()->with('error',trans('msg.errore_evasione_ordine'));
        }

        $to = ($config['in_sviluppo']) ? $config['email_debug'] : $config['email_ital_ordini'];

        $mail = new Order($order);

        try{
            \Mail::to($to)->send($mail);
        }
        catch(\Exception $e)
        {
            \Log::error($e->getMessage());
            Session::flash('error',trans('msg.impossibile_inviare_email_evasione'));
        }

        Session::flash('success',trans('msg.evasione_avvenuta_con_successo'));
        return redirect()->route('website.risposta_checkout',['locale'=>\App::getLocale(),'id'=>encrypt($order->id)]);
    }

    public function risposta_checkout(Request $request)
    {
        if(!\Auth::check())
        {
            return redirect()->route('website.home');
        }

        $order_id = decrypt($request->id);
        $order = ItalOrder::find($order_id);

        $user = \Auth::user();
        $carts = ItalCart::where('user_id',$user->id)->get();

        $params = [
            'order' => $order,
            'user' => $user,
            'carts' => $carts,
        ];

        return view('website.cart.risposta_checkout',$params);
    }

    private function sconto_importo($importo)
    {
        $fasce_sconto = [
            '0' => [
                0 => 0
            ],
            '1' => [
                4000 => 4,
                8000 => 8
            ],
            '2' => [
                1500 => 3,
                3000 => 5,
                5000 => 8
            ],
            '3' => [
                2500 => 10,
                5000 => 15,
                7500 => 20,
                10000 => 22,
                15000 => 25,
            ],
        ];

        $tipo = \Auth::user()->sconto_importo;
        $sconti = $fasce_sconto[$tipo];

        $sconto_da_applicare = 0;

        foreach($sconti as $key=>$sconto)
        {
            if($key <= $importo)
            {
                $sconto_da_applicare = ($importo/100) * $sconto;
            }
            else
            {
                break;
            }
        }
        return $sconto_da_applicare;
    }

}
