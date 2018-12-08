<?php

namespace App\Http\Controllers;

use Gate;
use App\Reply;
use Exception;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;

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
    public function store($channelId, Thread $thread, Spam $spam)
    {
        // $this->authorize('create', new Reply);
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently', 422
            );
        }


        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
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
