<x-layouts.admin.app>
    <div class="h-[calc(100vh-6rem)] grid grid-cols-1 lg:grid-cols-3 gap-6">
        <aside
            class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Conversations</h2>
                <span class="text-xs text-gray-500">{{ $conversations->count() }}</span>
            </div>
            <div class="space-y-2">
                @forelse ($conversations as $item)
                    <a href="{{ route('admin.support.chat', ['conversation_id' => $item->id]) }}"
                        class="block rounded-xl border px-4 py-3 transition
                            {{ $conversation && $conversation->id === $item->id ? 'border-primary bg-primary/5' : 'border-gray-200 dark:border-gray-700 hover:border-primary/60' }}">
                        <div class="flex items-center justify-between">
                            <div class="font-medium text-gray-900 dark:text-white">{{ $item->user?->name ?? 'User' }}
                            </div>
                            <span class="text-xs text-gray-400">#{{ $item->id }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Status: {{ ucfirst($item->status) }}</div>
                    </a>
                @empty
                    <div class="text-sm text-gray-500">No conversations yet.</div>
                @endforelse
            </div>
        </aside>

        <section class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700"
            x-data="supportChat({
                conversationId: {{ $conversation?->id ?? 'null' }},
                currentUserId: {{ $currentUserId }},
                messages: @js($messages),
                postUrl: '{{ route('admin.support.chat.message') }}',
                csrf: '{{ csrf_token() }}'
            })">
            <div class="border-b border-gray-200 dark:border-gray-700 p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Support Chat</h1>
                @if ($conversation)
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Chatting with
                        {{ $conversation->user?->name ?? 'User' }}</p>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select a conversation to start.</p>
                @endif
            </div>

            <div class="p-6">
                <div class="h-[420px] overflow-y-auto space-y-4 pr-2" x-ref="messages">
                    <template x-for="message in messages" :key="message.id">
                        <div class="flex"
                            :class="message.user.id === currentUserId ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[75%] rounded-2xl px-4 py-3"
                                :class="message.user.id === currentUserId ? 'bg-primary text-white' :
                                    'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100'">
                                <div class="text-xs opacity-80 mb-1" x-text="message.user.name"></div>
                                <div class="text-sm whitespace-pre-line" x-text="message.body"></div>
                            </div>
                        </div>
                    </template>

                    @if (!$conversation)
                        <div class="text-sm text-gray-500">No conversation selected.</div>
                    @endif
                </div>

                <form class="mt-6" @submit.prevent="send" x-show="conversationId">
                    <div class="flex items-center gap-3">
                        <textarea x-model="newMessage" rows="2" placeholder="Type your reply..."
                            class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900 focus:ring-primary focus:border-primary"></textarea>
                        <button type="submit"
                            class="bg-primary hover:bg-teal-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow"
                            :disabled="sending || newMessage.trim().length === 0">
                            <span x-show="!sending">Send</span>
                            <span x-show="sending">Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('supportChat', (config) => ({
                conversationId: config.conversationId,
                currentUserId: config.currentUserId,
                messages: config.messages ?? [],
                postUrl: config.postUrl,
                csrf: config.csrf,
                newMessage: '',
                sending: false,
                init() {
                    if (this.conversationId && window.Echo) {
                        window.Echo.private(`support.chat.${this.conversationId}`)
                            .listen('.support.message', (payload) => {
                                if (payload?.message) {
                                    this.messages.push(payload.message);
                                    this.$nextTick(() => this.scrollToBottom());
                                }
                            });
                    }

                    this.$nextTick(() => this.scrollToBottom());
                },
                async send() {
                    const body = this.newMessage.trim();
                    if (!body || this.sending || !this.conversationId) return;

                    this.sending = true;

                    try {
                        const response = await fetch(this.postUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                body,
                                conversation_id: this.conversationId,
                            }),
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (data?.message) {
                                this.messages.push(data.message);
                                this.newMessage = '';
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        }
                    } finally {
                        this.sending = false;
                    }
                },
                scrollToBottom() {
                    if (this.$refs.messages) {
                        this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight;
                    }
                },
            }));
        });
    </script>
</x-layouts.admin.app>
