<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\SupportConversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('support.chat.{conversationId}', function ($user, $conversationId) {
    $conversation = SupportConversation::query()->whereKey($conversationId)->first();

    if (! $conversation) {
        return false;
    }

    return $user->hasRole('admin') || (int) $conversation->user_id === (int) $user->id;
});
