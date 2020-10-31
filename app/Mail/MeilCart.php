<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MeilCart extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $phone;
    protected $adres;
    protected $maney;
    protected $manyback;
    protected $back;

    protected $products;
    protected $tottal_price;
    protected $tottal_count;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $phone, $adres, $maney, $manyback, $back, $products, $tottal_price, $tottal_count)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->adres = $adres;
        $this->maney = $maney;
        $this->manyback = $manyback;
        $this->back = $back;
        $this->products = $products;
        $this->tottal_price = $tottal_price;
        $this->tottal_count = $tottal_count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')
            ->with([
                'id' => rand(50, 500),
                'name' => $this->name,
                'phone' => $this->phone,
                'adres' => $this->adres,
                'maney' => $this->maney,
                'manyback' => $this->manyback,
                'back' => $this->back,
                'products' => $this->products,
                'tottal_price' => $this->tottal_price,
                'tottal_count' => $this->tottal_count
            ]);
    }
}
