<?php

namespace App\Mail;

use App\DevelopmentStudio;
use App\JobOffer;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;

class JobOfferSent extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $studio;
    public $offer;
    public $file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, DevelopmentStudio $studio, JobOffer $offer, $file)
    {
        $this->user = $user;
        $this->studio = $studio;
        $this->offer = $offer;
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.job-offer',
            ['user' => $this->user, 'studio' => $this->studio, 'offer' => $this->offer])
            ->subject($this->offer->title . ' - new offer')
            ->attach($this->file->getRealPath(), [
                    'as' => $this->file->getClientOriginalName(),
                    'mime' => $this->file->getClientMimeType()
                ]);
    }
}
