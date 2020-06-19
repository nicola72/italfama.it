<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $config = \Config::get('website_config');
        $sito = 'italfama.it';

        $params = [

            'order' => $this->order,
            'sito' => $sito,
        ];
        return $this->from($config['email_ital_ordini'])
            ->subject('Nuovo Ordine dal sito web '.$sito )
            ->view('website.email.order',$params);
    }
}