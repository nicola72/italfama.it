<?php

namespace App\Http\Controllers\Website;

use App\Mail\Contact;
use App\Mail\Information;
use App\Model\Catalog;
use App\Model\ItalCart;
use App\Model\Category;
use App\Model\Domain;
use App\Model\File;
use App\Model\Macrocategory;
use App\Model\Material;
use App\Model\Newsitem;
use App\Model\Page;
use App\Model\Pairing;
use App\Model\Product;
use App\Model\Review;
use App\Model\Style;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\GoogleRecaptcha;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();
        $prodotti_novita = Product::where('visibile',1)->where('availability_id','!=',2)->where('novita',1)->get();
        $abbinamenti_novita = Pairing::where('visibile',1)->where('novita',1)->get();
        $prodotti_offerta = Product::where('visibile',1)->where('availability_id','!=',2)->where('offerta',1)->get();
        $abbinamenti_offerta = Pairing::where('visibile',1)->where('offerta',1)->get();
        $news = Newsitem::where('visibile',1)->get();

        $canonical = (\App::getLocale() == 'it') ? 'https://www.chess-store.it' : 'https://www.chess-store.org';

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $canonical,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'prodotti_novita' => $prodotti_novita,
            'abbinamenti_novita' => $abbinamenti_novita,
            'prodotti_offerta' => $prodotti_offerta,
            'abbinamenti_offerta' => $abbinamenti_offerta,
            'news'=> $news
        ];
        return view('website.page.index',$params);
    }

    protected function macrocategoryPage(Request $request)
    {
        //in questa pagina i prodotti verranno visualizzati tutti i prodotti/abbinamenti di una categoria principale

        $macrocategory = Macrocategory::find($request->id);

        return $this->catalogo($request,$macrocategory,$macrocategory);
    }

    protected function categoryPage(Request $request)
    {
        //in questa pagina i prodotti verranno visualizzati tutti i prodotti/abbinamenti di una categoria

        $category = Category::find($request->id);
        $macrocategory = Macrocategory::find($category->macrocategory_id);

        return $this->catalogo($request,$macrocategory,$category);
    }

    protected function productPage(Request $request)
    {
        $product = Product::find(decrypt($request->id));

        //le macrocategorie per il menu nella colonna a sinistra
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $product->url(),
            'macrocategory' => false,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null,
            'form_name' => 'form_informazioni',
            'form_action' => route('invia_forminformazioni',app()->getLocale()),
            'product' => $product,
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];

        return view('website.page.product',$params);
    }

    protected function pairingPage(Request $request)
    {
        $pairing = Pairing::find(decrypt($request->id));

        //le macrocategorie per il menu nella colonna a sinistra
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $pairing_correlati = Pairing::where('product1_id',$pairing->product1_id)->orWhere('product2_id',$pairing->product2_id)->get();
        $pairing_correlati = $pairing_correlati->where('id','!=',$pairing->id);

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $pairing->url(),
            'macrocategory' => false,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null,
            'form_name' => 'form_informazioni',
            'form_action' => route('invia_forminformazioni',app()->getLocale()),
            'pairing' => $pairing,
            'pairing_correlati' => $pairing_correlati,
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];

        return view('website.page.pairing',$params);
    }

    /**
     * @param Request $request
     * @param $macrocategory
     * @param $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Funzione per visualizzare le pagine Categorie e Macrocategorie
     * Può essere una lista di Prodotti Singoli o Abbinamenti
     * Può essere chiamata normalmente oppure tramite ajax cliccando sul paginatore
     */
    protected function catalogo(Request $request,$macrocategory,$model)
    {
        //il parametro $model può essere o un App\Model|Macrocategory o un App\Model\Category
        //se il model è di tipo App\Model\Category allora vuol dire che siamo in una pagina categoria
        $category = ($model instanceof Category) ? $model : false;

        $canonical = $model->url();

        //le configurazioni varie del sito web
        $website_config = \Config::get('website_config');

        //quanti prodotti per pagina
        $per_page = $website_config['num_prod_per_page'];

        //le macrocategorie per il menu nella colonna a sinistra
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        //il template della vista in base a se è Ajax o no
        $view = ($request->ajax()) ? 'website.page.partials.other_products' : 'website.page.product_list';

        //parametro per ORDINAMENTO prodotti  (dalla url o dalla sessione se ajax)
        //false se non settato
        $ordinamento = $this->getOrdinamentoParam($request);

        //parametro FILTRO prodotti (solo per gli abbinamenti sono: x Stile, x Materiale Scacchi, x Materiale Scacchiera)
        //false se non settato
        $filtro = $this->getFiltroParam($request);

        //parametro PAGE del paginatore dalla url se AJAX altrimenti dalla sessione
        //false se non settato
        $page = $this->getPageParam($request, $model);

        //inserisco i vari parametri nella sessione: Page se Ajax, Ordinamento e Filtro se chiamata normale
        $this->setParamsInSession($request, $ordinamento, $filtro, $page, $model);

        //se settata nella sessione la page la inseriamo nel paginatore (SERVE per il torna indietro del browser)
        $this->updatePaginator($request,$page);

        $styles = Style::all();
        $chess_materials = Material::where('per','scacchi')->get();
        $board_materials = Material::where('per','scacchiera')->get();


        //se la macro id è 22 allora siamo su una categoria ABBINAMENTI
        if($macrocategory->id == 22)
        {
            //nessun prodotto singolo
            $products = false;
            //il totale degli abbinamenti presenti in questa categoria o macrocategoria
            $totali = $this->getTotalPairings($model,$filtro);
            //gli abbinamenti in base alla pagina ai filtri e all'ordinamento
            $pairings = $this->getPairings($model,$filtro,$ordinamento,$per_page);
        }
        //PRODOTTI SINGOLI
        else
        {
            //nessun abbinamento
            $pairings = false;
            //il totale prodotti presenti in questa categoria o macrocategoria
            $totali = $this->getTotalProducts($model);
            //i prodotti in base alla pagina e all'ordinamento
            $products = $this->getProducts($model,$ordinamento,$per_page);
        }

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $canonical,
            'macrocategory' => $macrocategory,
            'macrocategorie' => $macrocategorie,
            'macro_request' => $macrocategory->id,
            'category' => $category,
            'totali' => $totali,
            'titolo' => $model->{'nome_'.\App::getLocale()},
            'products' => $products,
            'pairings' => $pairings,
            'ordinamento' => $ordinamento,
            'descrizione_categoria' => $model->{'desc_'.\App::getLocale()},
            'styles' => $styles,
            'chess_materials' => $chess_materials,
            'board_materials' => $board_materials,
            'filtro' => $filtro,
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];

        return view($view,$params);
    }

    protected function ricerca(Request $request,$url)
    {
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        $search_code = $request->get('codice');
        $search_material = $request->get('materiale');
        $search_word = $request->get('parola');

        //stabilisco quale parola usare per la ricerca
        $search = $search_code;
        if($search_material != '') $search = $search_material;
        if($search_word != '') $search = $search_word;


        if(strlen($search) < 4)
        {
            return back()->with('error',trans('msg.inserire_almeno_4_caratteri'));
        }

        $products = Product::where('visibile',1)
            ->where('availability_id','!=',2)
            ->where(function ($query) use($search){
                $query->where('products.nome_it','LIKE','%' . $search . '%')
                    ->orWhere('products.desc_it','LIKE','%' . $search . '%')
                    ->orWhere('products.codice','LIKE','%' . $search . '%');
            })
            ->where('italfama',1)
            ->get();

        $totali = $products->count();

        $params = [
            'carts' => $this->getCarts(),
            'macrocategory' => false,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null,
            'category' => false,
            'totali' => $totali,
            'titolo' => 'Ricerca per '.$search,
            'products' => $products,
            'pairings' => false,
            'ordinamento' => false,
            'styles' => false,
            'chess_materials' => false,
            'board_materials' => false,
            'filtro' => false,
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];

        return view('website.page.ricerca',$params);
    }

    protected function tutti_prodotti(Request $request,$url)
    {
        $macrocategorie = Macrocategory::where('stato',1)->whereNotIn('id', [18,19,20,21,30])->orderBy('order')->get();

        //le configurazioni varie del sito web
        $website_config = \Config::get('website_config');

        //quanti prodotti per pagina
        $per_page = $website_config['num_prod_per_page'];

        $catalogo = collect();

        foreach ($macrocategorie as $macro)
        {
            $products = $macro->products()->where('visibile',1)->where('italfama',1)->where('availability_id','!=',2)->get();
            if($products)
            {
                foreach ($products as $product)
                {
                    $product = Product::find($product->id_product);
                    $prezzo = (\Auth::check()) ? $product->prezzo : false;
                    $prezzo_netto = (\Auth::check()) ? $product->prezzo_netto(\Auth::user()) : false;
                    $prezzo_fabbrica = (\Auth::check()) ? $product->prezzo_fabbrica : false;
                    $elem = [
                        'id'=> $product->id,
                        'type'=> 'product',
                        'prezzo'=> $prezzo,
                        'prezzo_netto' => $prezzo_netto,
                        'prezzo_fabbrica' => $prezzo_fabbrica,
                        'nome' => $product->{'nome_'.\App::getLocale()},
                        'object'=>$product
                    ];
                    $catalogo->push($elem);
                }
            }

            //NO ABBiNAMENTI
            /*$pairings = $macro->pairings()->where('visibile',1)->where('italfama',1)->get();
            if($pairings)
            {
                foreach ($pairings as $pairing)
                {
                    $product1 = Product::find($pairing->product1_id);
                    $product2 = Product::find($pairing->product1_id);
                    $prezzo = (\Auth::check()) ? ($product1->prezzo + $product2->prezzo) : false;
                    $prezzo_netto = (\Auth::check()) ? ($product1->prezzo_netto(\Auth::user()) + $product2->prezzo_netto(\Auth::user())) : false;
                    $prezzo_fabbrica = (\Auth::check()) ? ($product1->prezzo_fabbrica + $product2->prezzo_fabbrica) : false;
                    $elem = [
                        'id'=> $pairing->id,
                        'type'=> 'pairing',
                        'prezzo'=> $prezzo,
                        'prezzo_netto' => $prezzo_netto,
                        'prezzo_fabbrica' => $prezzo_fabbrica,
                        'nome' => $pairing->{'nome_'.\App::getLocale()},
                        'object'=>$pairing
                    ];
                    $catalogo->push($elem);
                }
            }*/
        }

        $totali = $catalogo->count();

        //parametro per ORDINAMENTO prodotti  (dalla url o dalla sessione se ajax)
        //false se non settato
        $ordinamento = $request->query('order', false);

        if($ordinamento)
        {
            //inserisco l'ordinamento nella sessione per eventuali chiamate ajax tramite paginatore
            $request->session()->put('order',$ordinamento);
        }
        //se non arriva dalla query string provo dalla sessione
        else
        {
            $ordinamento = $request->session()->get('order',false);
        }


        switch ($ordinamento)
        {
            //per prezzo crescente
            case 'prezzo|ASC':
                $list = $catalogo->sortBy('prezzo')
                    ->paginate($per_page);
                break;
            //per prezzo decrescente
            case 'prezzo|DESC':
                $list = $catalogo->sortByDesc('prezzo')
                    ->paginate($per_page);
                break;
            //per nome
            case 'nome|ASC':
                $nome = 'nome_'.\App::getLocale();
                $list = $catalogo->sortBy('nome')
                    ->paginate($per_page);
                break;
            default:
                $list = $catalogo->sortBy('prezzo')
                    ->paginate($per_page);
        }

        $params = [
            'carts' => $this->getCarts(),
            'macrocategory' => false,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null,
            'category' => false,
            'totali' => $totali,
            'titolo' => 'Tutti i prodotti',
            'products' => false,
            'pairings' => false,
            'ordinamento' => $ordinamento,
            'descrizione_categoria' => '',
            'styles' => false,
            'chess_materials' => false,
            'board_materials' => false,
            'filtro' => false,
            'list' => $list,
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];

        return view('website.page.tutti_prodotti',$params);
    }

    protected function azienda(Request $request,$url)
    {
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        //prendo la pagina di Chessstore per il canonical
        $page = Page::where('nome','azienda')->first();
        $canonical = $page->url();

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $canonical,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];
        return view('website.page.azienda',$params);
    }

    protected function dove_siamo(Request $request,$url)
    {
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        //prendo la pagina di Chessstore per il canonical
        $page = Page::where('nome','dove_siamo')->first();
        $canonical = $page->url();

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $canonical,
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];
        return view('website.page.dove_siamo',$params);
    }

    protected function contatti(Request $request,$url)
    {
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();

        //prendo la pagina di Chessstore per il canonical
        $page = Page::where('nome','contatti')->first();
        $canonical = $page->url();

        $params = [
            'carts' => $this->getCarts(),
            'canonical' => $canonical,
            'macrocategorie' => $macrocategorie,
            'form_action' => route('invia_formcontatti',app()->getLocale()),
            'form_name' => 'form_contatti',
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];
        return view('website.page.contatti',$params);
    }

    public function cataloghi()
    {
        if(!\Auth::check())
        {
            return redirect()->route('website.home');
        }
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();
        $cataloghi = Catalog::where('visibile',1)->get();

        $params = [
            'cataloghi' => $cataloghi,
            'carts' => $this->getCarts(),
            'macrocategorie' => $macrocategorie,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];
        return view('website.page.cataloghi',$params);


    }

    protected function recensioni(Request $request,$url)
    {
        $seo = $url->seo;
        $macrocategorie = Macrocategory::where('stato',1)->orderBy('order')->get();
        $reviews = Review::where('visibile',1)->orderBy('id','DESC')->get();

        $params = [
            'carts' => $this->getCarts(),
            'seo' => $seo,
            'macrocategorie' => $macrocategorie,
            'reviews' => $reviews,
            'macro_request' => null, //paramtero necessario per stabilire il collapse del menu a sinistra
            'function' => __FUNCTION__ //visualizzato nei meta tag della header
        ];
        return view('website.page.recensioni',$params);
    }

    public function invia_formcontatti(Request $request)
    {
        $data = $request->post();
        $config = \Config::get('website_config');
        $secret = $config['recaptcha_secret'];

        if(!GoogleRecaptcha::verifyGoogleRecaptcha($data,$secret))
        {
            return ['result' => 0, 'msg' => trans('msg.il_codice_di_controllo_errato')];
        }

        $to = ($config['in_sviluppo']) ? $config['email_debug'] : $config['email'];

        $mail = new Contact($data);

        try{
            \Mail::to($to)->send($mail);
        }
        catch(\Exception $e)
        {
            return ['result' => 0, 'msg' => $e->getMessage()];
        }

        return ['result' => 1, 'msg' => trans('msg.grazie_per_averci_contattato')];

    }

    public function invia_forminformazioni(Request $request)
    {
        $data = $request->post();
        $config = \Config::get('website_config');
        $secret = $config['recaptcha_secret'];

        if(!GoogleRecaptcha::verifyGoogleRecaptcha($data,$secret))
        {
            return ['result' => 0, 'msg' => trans('msg.il_codice_di_controllo_errato')];
        }

        $to = ($config['in_sviluppo']) ? $config['email_debug'] : $config['email'];

        $mail = new Information($data);

        try{
            \Mail::to($to)->send($mail);
        }
        catch(\Exception $e)
        {
            return ['result' => 0, 'msg' => $e->getMessage()];
        }

        return ['result' => 1, 'msg' => trans('msg.grazie_per_averci_contattato')];

    }

    private function getOrdinamentoParam(Request $request)
    {
        if(!$request->ajax())
        {
            //se NO AJAX lo prendo dalla query string dell url
            $ordinamento = $request->query('order', false);
        }
        else
        {
            //se AJAX il parametro dell'ordinamento lo prendo dalla sessione
            $ordinamento = $request->session()->get('order',false);
        }
        return $ordinamento;
    }

    private function getFiltroParam(Request $request)
    {
        if(!$request->ajax())
        {
            //se NO AJAX lo prendo dalla query string dell url
            $filtro = $request->query('filter',false);
        }
        else
        {
            //se AJAX il parametro del filtro lo prendo dalla sessione
            $filtro = $request->session()->get('filter',false);
        }
        return $filtro;
    }

    private function getPageParam(Request $request, $model=null)
    {
        if(!$request->ajax())
        {
            //se NO AJAX lo prendo dalla query string dell url
            if($model instanceof Category)
            {
                $page = $request->session()->get('page_cat_'.$model->id,false);
            }
            elseif($model instanceof Macrocategory)
            {
                $page = $request->session()->get('page_mac_'.$model->id,false);
            }
            else
            {
                $page = $request->session()->get('page',false);
            }
        }
        else
        {
            //se AJAX il parametro PAGE lo prendo dalla url
            $page = $request->get('page');
        }
        return $page;
    }

    private function setParamsInSession(Request $request,$ordinamento,$filtro,$page,$model=null)
    {
        if(!$request->ajax())
        {
            //inserisco l'ordinamento nella sessione per eventuali chiamate ajax tramite paginatore
            $request->session()->put('order',$ordinamento);

            //inserisco il filtro nella sessione per eventuali chiamate ajax tramite paginatore
            $request->session()->put('filter',$filtro);
        }
        else
        {
            //inserisco il parametro page nella sessione
            if($model instanceof Category)
            {
                $request->session()->put('page_cat_'.$model->id,$page);
            }
            elseif($model instanceof Macrocategory)
            {
                $request->session()->put('page_mac_'.$model->id,$page);
            }
            else
            {
                $request->session()->put('page',$page);
            }
        }
    }

    /**
     * @param Request $request
     * @param $page
     * setta il Paginatore ad una determita pagina (utile per il torna indietro del browser)
     */
    private function updatePaginator(Request $request,$page)
    {
        if(session()->previousUrl() == $request->fullUrl())
        {
            if($page)
            {
                Paginator::currentPageResolver(function () use ($page) {
                    return $page;
                });
            }
        }
    }

    /**
     * @param $model
     * @param $filtro
     * @return mixed
     * Funzione per sapere il numero totale dei prodotti di una categoria o macrocategoria
     */
    private function getTotalPairings($model,$filtro)
    {
        if($filtro)
        {
            $filtro_arr = explode("|",$filtro);
            $tipo_filtro = $filtro_arr[0];
            $parametro_filtro = $filtro_arr[1];

            switch($tipo_filtro)
            {
                case 'style':
                    $totali = $model->pairings()->where('visibile',1)->where('italfama',1)->where('style_id',$parametro_filtro)->count();
                    break;
                case 'material_chess':
                    $totali = $model->pairings_for_list($tipo_filtro,$parametro_filtro)->count();
                    break;
                case 'material_board':
                    $totali = $model->pairings_for_list($tipo_filtro,$parametro_filtro)->count();
                    break;
                default:
                    $totali = $model->pairings_for_list()->count();
            }
        }
        else
        {
            $totali = $model->pairings()->where('visibile',1)->count();
        }

        return $totali;
    }

    /**
     * @param $model
     * @param $filtro
     * @param $ordinamento
     * @param $per_page
     * @return mixed
     * Funzione per ottenere tutti gli abbinamenti in base ai filtri e all'ordinamento stabiliti e per paginatore
     */
    private function getPairings($model, $filtro, $ordinamento, $per_page)
    {
        //Se Presente il parametro filtro allora prendo gli abbinamenti in base al filtro
        if($filtro)
        {
            $filtro_arr = explode("|",$filtro);
            $tipo_filtro = $filtro_arr[0];
            $parametro_filtro = $filtro_arr[1];

            switch($tipo_filtro)
            {
                //per stile
                case 'style':
                    $nome = 'nome_'.\App::getLocale();
                    $pairings = $model->pairings_for_list()
                        ->sortBy($nome)
                        ->where('style_id',$parametro_filtro)
                        ->paginate($per_page);
                    break;
                //per materiale scacchi
                case 'material_chess':
                    $nome = 'nome_'.\App::getLocale();
                    $pairings = $model->pairings_for_list($tipo_filtro,$parametro_filtro)
                        ->sortBy($nome)
                        ->paginate($per_page);
                    break;
                //per materiale scacchiera
                case 'material_board':
                    $nome = 'nome_'.\App::getLocale();
                    $pairings = $model->pairings_for_list($tipo_filtro,$parametro_filtro)
                        ->sortBy($nome)
                        ->paginate($per_page);
                    break;
                default:
                    $pairings = $model->pairings_for_list()
                        ->sortBy('prezzo')
                        ->paginate($per_page);
            }
        }
        //altrimenti prendo i prodotti in base all'ordinamento
        else
        {
            //ATTENZIONE!! in questo caso usiamo sortBy perchè il risultato è una collection e non un eloquent array
            switch ($ordinamento)
            {
                //per prezzo crescente
                case 'prezzo|ASC':
                    $pairings = $model->pairings_for_list()
                        ->sortBy('prezzo')
                        ->paginate($per_page);
                    break;
                //per prezzo decrescente
                case 'prezzo|DESC':
                    $pairings = $model->pairings_for_list()
                        ->sortByDesc('prezzo')
                        ->paginate($per_page);
                    break;
                //per codice
                case 'codice|ASC':
                    $nome = 'nome_'.\App::getLocale();
                    $pairings = $model->pairings_for_list()
                        ->sortBy($nome)
                        ->paginate($per_page);
                    break;
                default:
                    $nome = 'nome_'.\App::getLocale();
                    $pairings = $model->pairings_for_list()
                        ->sortBy($nome)
                        ->paginate($per_page);
            }
        }
        return $pairings;
    }

    /**
     * @param $model
     * @return mixed
     * Funzione per sapere il numero totale di una categoria o macrocategoria
     */
    private function getTotalProducts($model)
    {
        return $model->products()->where('visibile',1)->where('italfama',1)->where('availability_id','!=',2)->count();
    }

    private function getProducts($model,$ordinamento,$per_page)
    {
        switch ($ordinamento)
        {
            case 'prezzo|ASC':
                $products = $model->products()
                    ->where('visibile',1)
                    ->where('italfama',1)
                    ->where('availability_id','!=',2)
                    ->orderBy('minimal','ASC')
                    ->paginate($per_page);
                break;
            case 'prezzo|DESC':
                $products = $model->products()
                    ->where('visibile',1)
                    ->where('italfama',1)
                    ->where('availability_id','!=',2)
                    ->orderBy('minimal','DESC')
                    ->paginate($per_page);
                break;
            case 'nome|ASC':
                $nome = 'nome_'.\App::getLocale();
                $products = $model->products()
                    ->where('visibile',1)
                    ->where('italfama',1)
                    ->where('availability_id','!=',2)
                    ->orderBy($nome,'ASC')
                    ->paginate($per_page);
                break;
            default:
                $products = $model->products()
                    ->where('visibile',1)
                    ->where('italfama',1)
                    ->where('availability_id','!=',2)
                    ->orderBy('minimal')
                    ->paginate($per_page);
        }

        return $products;
    }

    private function getCarts()
    {
        if(\Auth::check())
        {
            $user = \Auth::user();
            $carts = ItalCart::where('user_id',$user->id)->get();
            return $carts;
        }

        return [];
    }
}
