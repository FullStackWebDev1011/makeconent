<?php

namespace App\Providers;

use App\Events\AddFoundsEvent;
use App\Events\CopywriterAcceptEvent;
use App\Events\MarketplaceTextOrderEvent;
use App\Events\ProjectNewTextEvent;
use App\Events\ProjectNotReservedEvent;
use App\Events\ProjectTextAcceptedEvent;
use App\Events\WithdrawMoneyEvent;
use App\Listeners\SendEmailAddFoundsInvoiceListener;
use App\Listeners\SendEmailCopywriterAcceptListener;
use App\Listeners\SendEmailMarketplaceTextOrderListener;
use App\Listeners\SendEmailProjectNewTextListener;
use App\Listeners\SendEmailProjectNotReservedListener;
use App\Listeners\SendEmailProjectTextAcceptedListener;
use App\Listeners\SendEmailWithdrawMoneyListener;
use App\Listeners\SendMailConfirmListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
//            SendEmailVerificationNotification::class,
            SendMailConfirmListener::class,
        ],
        AddFoundsEvent::class => [
            SendEmailAddFoundsInvoiceListener::class,
        ],
        ProjectNewTextEvent::class => [
            SendEmailProjectNewTextListener::class,
        ],
        CopywriterAcceptEvent::class => [
            SendEmailCopywriterAcceptListener::class,
        ],
        ProjectTextAcceptedEvent::class => [
            SendEmailProjectTextAcceptedListener::class,
        ],
        MarketplaceTextOrderEvent::class => [
            SendEmailMarketplaceTextOrderListener::class,
        ],
        WithdrawMoneyEvent::class => [
            SendEmailWithdrawMoneyListener::class,
        ],
        ProjectNotReservedEvent::class => [
            SendEmailProjectNotReservedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
