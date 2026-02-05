<?php

namespace App\Http\Controllers\Admin;

use App\Events\SupportMessageSent;
use App\Http\Controllers\Controller;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SupportChatController extends Controller
{
    public function index(Request $request)
    {
        $conversations = SupportConversation::query()
            ->with(['user'])
            ->latest('updated_at')
            ->get();

        $conversationId = $request->query('conversation_id') ?: $conversations->first()?->id;
        $conversation = $conversationId
            ? SupportConversation::with(['user', 'messages.user'])->find($conversationId)
            : null;

        $messages = $conversation
            ? $conversation->messages()->with('user')->orderBy('created_at')->get()
            : collect();

        return view('admin.support.chat', [
            'conversations' => $conversations,
            'conversation' => $conversation,
            'messages' => $this->formatMessages($messages),
            'currentUserId' => $request->user()->id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'conversation_id' => ['required', 'exists:support_conversations,id'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $user = $request->user();

        $conversation = SupportConversation::findOrFail($validated['conversation_id']);

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
