<x-layouts.app>
    <section class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700"
                x-data="supportChat({
                    conversationId: {{ $conversation->id }},
                    currentUserId: {{ $currentUserId }},
                    messages: @js($messages),
                    postUrl: '{{ route('support.chat.message') }}',
                    csrf: '{{ csrf_token() }}'
                })">
                <div class="border-b border-gray-200 dark:border-gray-700 p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Support Chat</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">We usually reply within a few minutes.</p>
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
                    </div>

                    <form class="mt-6" @submit.prevent="send">
                        <div class="flex items-center gap-3">
                            <textarea x-model="newMessage" rows="2" placeholder="Type your message..."
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
            </div>
        </div>
    </section>

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
                    if (window.Echo) {
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
                    if (!body || this.sending) return;

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
                                body
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
</x-layouts.app>
