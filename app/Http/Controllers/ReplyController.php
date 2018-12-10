<?php

namespace App\Http\Controllers;

use App\Reply;
use Exception;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use App\Notifications\YouWereMentioned;
use App\Http\Requests\CreatePostRequest;

class ReplyController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store($channelId, Thread $thread, CreatePostRequest $form)
     {
         $reply = $thread->addReply([
             'body' => request('body'),
             'user_id' => auth()->id()
         ]);

         preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

         foreach ($matches[1] as $name) {
             $user = User::whereName($name)->first();

             if ($user) {
                 $user->notify(new YouWereMentioned($reply));
             }
         }

         return $reply->load('owner');
     }


    /**
     * Update the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
     public function update(Reply $reply, Request $request)
     {
         $this->authorize('update', $reply);

         try {
            $this->validate(request(), ['body' => 'required|spamfree']);
            $reply->update(request(['body']));
        } catch (Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }
     }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
