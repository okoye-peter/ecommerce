<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\NewUserHasRegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeNewUserListener
{
    /**
     * Handle the event.
     *
     * @param  NewUserHasRegisteredEvent  $event
     * @return void
     */
    public function handle(NewUserHasRegisteredEvent $event)
    {   
        // $to_email = $event->user->email;
        // $data = array('name'=> "Okoye Peter", "body"=>new WelcomeNewUserMail($event->user));

        // Mail::send( 'emails\new_user_welcome', $data, function($message) use ($to_email){
        //     $message->to($to_email)
        //     ->subject("Laravel Mail Subject");
        // });
        Mail::to($event->user->email)->send(new WelcomeNewUserMail($event->user));
    }
}
