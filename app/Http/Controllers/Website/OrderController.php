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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if(!\Auth::check())
        {
            return redirect('/');
        }

        $orders = ItalOrder::where('user_id',\Auth::user()->id)->get();
        $user = \Auth::user();
        $carts = ItalCart::where('user_id',$user->id)->get();

        $params = [
            'carts' => $carts,
            'user' => $user,
            'orders' => $orders
        ];

        return view('website.order.index',$params);
    }

    public function print(Request $request)
    {
        if(!\Auth::check())
        {
            return redirect('/');
        }

        $order_id = decrypt($request->id);
        $order = ItalOrder::find($order_id);

        if(!$order)
        {
            return back()->with('error',trans('msg.impossibile_effettuare_la_stampa'));
        }

        $params = [
            'order' => $order
        ];

        $pdf = \PDF::loadView('website.pdf.order', $params);
        return $pdf->download('ordine_'.$order->id.'.pdf');

    }
}
