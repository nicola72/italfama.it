<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Information extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $config = \Config::get('website_config');
        $sito = 'italfama.it';

        $params = [
            'nome' => $this->data['nome'],
            'cognome' => $this->data['cognome'],
            'email'=> $this->data['email'],
            'telefono'=> $this->data['telefono'],
            'codice_prodotto' => $this->data['codice_prodotto'],
            'messaggio' => $this->data['messaggio'],
            'sito' => $sito,
        ];
        return $this->from($config['email'])
            ->subject('Richiesta Informazioni inviata dal sito www.italfama.it' )
            ->view('website.email.informazioni',$params);
    }
}
