<?php

// Add this to app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Registers "brevo" as a mail transport that sends over Brevo's HTTPS API
        // (port 443) instead of SMTP — avoids the outbound SMTP port blocks common
        // on shared/cPanel hosting.
        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory())->create(
                new Dsn(
                    'brevo+api',
                    'default',
                    config('services.brevo.api_key'),
                )
            );
        });
    }
}