<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(function ($name) {
                return User::where('name', $name)->first();
            })
            ->filter()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });

        // preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);
        //
        // foreach ($matches[1] as $name) {
        //     $user = User::whereName($name)->first();
        //
        //     if ($user) {
        //         $user->notify(new YouWereMentioned($event->reply));
        //     }
        // }
    }
}
