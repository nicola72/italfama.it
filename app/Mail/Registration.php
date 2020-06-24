<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Registration extends Mailable
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

    public function build()
    {
        $config = \Config::get('website_config');
        $sito = 'italfama.it';

        $params = [
            'nome' => $this->data['nome'],
            'cognome' => $this->data['cognome'],
            'email'=> $this->data['email'],
            'telefono' => $this->data['telefono'],
            'indirizzo' => $this->data['indirizzo'],
            'citta' => $this->data['citta'],
            'cap' => $this->data['cap'],
            'nazione' => $this->data['nazione'],
            'messaggio' => $this->data['messaggio'],
            'sito' => $sito,
        ];
        return $this->from($config['email'])
            ->subject('Richiesta registrazione dal sito web '.$sito )
            ->view('website.email.registration',$params);
    }
}
