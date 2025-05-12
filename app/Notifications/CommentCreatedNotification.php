<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CommentCreatedNotification extends Notification
{
    protected Comment $comment;
    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'message' => 'Novo comentário recebido!',
            'text_comment' => $this->comment->text_comment,
            'user_id' => $this->comment->user_id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'message' => 'Novo comentário no seu conteúdo!',
            'comment_id' => $this->comment->id,
        ];
    }
}
