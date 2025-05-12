<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use App\Notifications\CommentCreatedNotification;
use Illuminate\Support\Facades\Log;

class SendCommentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    
    }

    /**
     * Handle the event.
     */
    public function handle(CommentCreated $event): void
    {
        $comment = $event->comment;
        
        $userToNotify = $comment->commentable->user ?? null;

        if ($userToNotify) {
            $userToNotify->notify(new CommentCreatedNotification($comment));
        } else {
            Log::warning('Nenhum usuário encontrado para notificar!');
        }
    }
}
