<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{

    public const HOME = '/home';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable) {

            $url = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addHour(),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return (new MailMessage)
                ->subject('Verify Your Email - VetCare')
                ->view('emails.verify-email', [
                    'user' => $notifiable,
                    'url' => $url,
                ]);
        });
    }
}


