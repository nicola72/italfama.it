<?php
namespace App\Http\Controllers\Website\Auth;

use App\Mail\Registration;
use App\Model\Domain;
use App\Model\Macrocategory;
use App\Model\Page;
use App\Service\GoogleRecaptcha;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Lang;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->post();
        $config = \Config::get('website_config');
        $secret = $config['recaptcha_secret'];

        if(!GoogleRecaptcha::verifyGoogleRecaptcha($data,$secret))
        {
            return ['result' => 0, 'msg' => trans('msg.il_codice_di_controllo_errato')];
        }

        $to = ($config['in_sviluppo']) ? $config['email_debug'] : $config['email'];

        $mail = new Registration($data);

        try{
            \Mail::to($to)->send($mail);
        }
        catch(\Exception $e)
        {
            \Log::error($e->getMessage());
            return ['result' => 0,'msg'=> trans('msg.impossibile_inviare_la_richiesta_registrazione')];
        }
        return ['result' => 1,'msg'=> trans('msg.grazie_per_la_richiesta_registrazione')];
    }
}
