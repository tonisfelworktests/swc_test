<?php

namespace App\Providers;

use App\Models\Event as EventModel;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('', [
                'key' => 'events',
                'text' => 'Event',
                'id' => 'event_list'
            ]);
            $event->menu->add('', [
                'key' => 'my_events',
                'text' => 'My events',
                'id' => 'my_event_list'
            ]);

            $allEvents = EventModel::get(['id', 'title']);
            $myEvents = User::with(['events'])->where("id", Auth::user()->id)->first()->events;

            $allEvents->map(function ($item, $index) use ($event) {
                $event->menu->addIn('events', [
                    'key' => $index,
                    'text' => $item->title,
                    'url' => route('events-watch', $item->id),
                    'shift' => 'ml-2'
                ]);
            });
            $myEvents->map(function ($item, $index) use ($event) {
                $event->menu->addIn('my_events', [
                    "key" => $index,
                    "text" => $item->title,
                    "url" => route('events-watch', $item->id),
                    'shift' => 'ml-2'
                ]);
            });
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
