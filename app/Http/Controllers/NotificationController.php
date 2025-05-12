<?php

namespace App\Http\Controllers;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return auth()->user()->notifications;
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['mensagem' => 'Todas as notificações foram marcadas como lidas']);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if (!$notification) {
            return response()->json(['erro' => 'Notificação não encontrada'], 404);
        }

        $notification->markAsRead();

        return response()->json(['mensagem' => 'Notificação marcada como lida']);
    }
}
