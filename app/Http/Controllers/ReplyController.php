<?php

namespace App\Http\Controllers;

use App\Reply;
use Exception;
use App\Thread;
use Illuminate\Http\Request;
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
         if ($thread->locked) {
             return response('Thread is locked', 422);
         }

         return $thread->addReply([
             'body' => request('body'),
             'user_id' => auth()->id()
         ])->load('owner');
     }


    /**
     * Update the given reply.
     *
     * @param  Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
     public function update(Reply $reply)
     {
         $this->authorize('update', $reply);

         request()->validate(['body' => 'required|spamfree']);

         $reply->update(request(['body']));
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
