<?php

namespace App\Http\Controllers;

use App\Events\SupportMessageSent;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SupportChatController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $conversation = SupportConversation::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'open']
        );

        $messages = $conversation
            ->messages()
            ->with('user')
            ->orderBy('created_at')
            ->get();

        $payload = [
            'conversation' => [
                'id' => $conversation->id,
                'status' => $conversation->status,
            ],
            'messages' => $this->formatMessages($messages),
            'currentUserId' => $user->id,
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('support.chat', [
            'conversation' => $conversation,
            'messages' => $payload['messages'],
            'currentUserId' => $user->id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $user = $request->user();

        $conversation = SupportConversation::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 'open']
        );

        $message = SupportMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->touch();

        $message->load('user');

        broadcast(new SupportMessageSent($message))->toOthers();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->formatMessage($message),
            ]);
        }

        return back();
    }

    private function formatMessages(Collection $messages): array
    {
        return $messages->map(fn(SupportMessage $message) => $this->formatMessage($message))->all();
    }

    private function formatMessage(SupportMessage $message): array
    {
        return [
            'id' => $message->id,
            'body' => $message->body,
            'created_at' => $message->created_at?->toIso8601String(),
            'user' => [
                'id' => $message->user?->id,
                'name' => $message->user?->name,
                'is_admin' => $message->user?->hasRole('admin') ?? false,
            ],
        ];
    }
}
