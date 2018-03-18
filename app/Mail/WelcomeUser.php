<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeUser extends Mailable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $name)
    {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('register.welcome', ['name' => $this->name])
            ->to($this->email);
    }
}
