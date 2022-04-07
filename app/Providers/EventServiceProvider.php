<?php

namespace App\Providers;

use App\Events\{AttachImages,
    DeleteConfirmSms,
    DestroyImages,
    PhoneConfirmed,
    SmsConfirmCheck,
    SmsConfirmSend,
    UpdateImage
};
use App\Listeners\{AttachImagesListener,
    CheckConfirmationCode,
    DeleteConfirmationCode,
    DestroyImagesListener,
    SendConfirmationCode,
    SetPhoneConfirmed,
    UpdateImagesListener
};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = array(
        UpdateImage::class => array(
            UpdateImagesListener::class
        ),
        AttachImages::class => array(
            AttachImagesListener::class
        ),
        DestroyImages::class => array(
            DestroyImagesListener::class
        ),
        SmsConfirmCheck::class => array(
            CheckConfirmationCode::class
        ),
        DeleteConfirmSms::class => array(
            DeleteConfirmationCode::class
        ),
        SmsConfirmSend::class => array(
            SendConfirmationCode::class
        ),
        PhoneConfirmed::class => array(
            SetPhoneConfirmed::class
        ),
    );

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
