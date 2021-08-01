@props(['preview'=>false, 'previewText'=>'Select a user to start chatting','user'=>[]])


<div class="flex flex-col justify-between w-96 bg-gray-50">
    @if($preview)
        <div class="flex items-center justify-center bg-green-100 h-12">
            <div>{{ $previewText }}</div>
        </div>

        @if(!auth()->check())
            <div class="flex flex-col items-center justify-center">
                @if($errors->any())
                    <div class="bg-green-50 w-full text-center mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li style="::marker">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>

                    <form action="{{ route('messenger.auth') }}" method="POST"
                          class="flex flex-col gap-2 w-32 items-center">
                        @csrf
                        <label>
                            <span>Username: </span><input type="text" name="name" class="border-2">
                        </label>
                        <label>
                            <span>Password: </span><input type="password" name="password" class="border-2">
                        </label>
                        <button type="submit" class="rounded-xl p-2 border-1 shadow-sm bg-green-100">Sign in</button>
                    </form>
                </div>
            </div>
        @endif

        <div class="flex flex-col gap-y-2 bg-gray-50">
            <div class="w-full bg-gray-50">
                <div class="flex">
                    <label for="messageInput"></label>
                    <textarea disabled
                              class="w-full px-3 py-2 text-gray-700 border rounded-lg resize-none focus:outline-none"
                              id="messageInput" name="message"
                              placeholder="{{ $previewText }}"></textarea>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="sticky top-0 bottom-0 flex items-center justify-center bg-green-100 h-12">
            <div>
                <span class="font-bold">{{$user->name}}</span>
            </div>
        </div>
        <div class="flex flex-col gap-y-2 justify-end bg-gray-50 h-full">
            <div id="messages" class="mx-4 flex flex-col-reverse gap-4 overflow-y-auto">
                <div id="companionCloneableMessage" class="hidden flex flex-col">
                    <p class="text-sm text-blue-400"></p>
                    <p></p>
                </div>
                <div id="selfCloneableMessage" class="hidden flex flex-col ml-auto">
                    <p class="text-sm text-blue-400"></p>
                    <p></p>
                </div>
            </div>
            <div class="w-full sticky bottom-0 top-0 bg-gray-50">
                <form id="messageForm" onsubmit="sendMessage()">
                    <div class="flex">
                        <label for="messageInput"></label>
                        <textarea
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg resize-none focus:outline-none"
                            id="messageInput" name="message"
                            placeholder="Write your message."></textarea>
                        <button id="messageButton" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @push('scripts')
            <script>
                window.scrollTo(0, document.body.scrollHeight);

                const currentUserId = {{auth()->user()->id}};
                const companionName = '{{ $user->name }}';

                let wrapper = document.querySelector('#messages');

                document.querySelector('#messageForm').addEventListener('submit', e => e.preventDefault());
                document.getElementById('messageInput').addEventListener('keyup', function (e) {
                    if (e.code === 'Enter') {
                        e.preventDefault()
                        document.getElementById('messageButton').click();
                    }
                });

                axios.post('{{route('messages.get')}}', {
                    'receiver_id': '{{ $user->id }}'
                }).then((msg) => renderMessages(msg.data.messages));

                function renderMessages(messages) {
                    messages[0].forEach((message) => {
                        if (message.sender_id === currentUserId) {
                            wrapper.append(createMessage(message, true));
                            return;
                        }
                        wrapper.append(createMessage(message));
                    });

                    window.scrollTo(0, document.body.scrollHeight);
                }

                function createMessage(message, self = false) {
                    if (self) {
                        let messageElement = document.querySelector('#selfCloneableMessage').cloneNode(true);

                        messageElement.classList.toggle('hidden');
                        messageElement.id = '';
                        messageElement.firstElementChild.append('You');
                        messageElement.lastElementChild.append(message.body);

                        return messageElement;
                    } else {
                        let messageElement = document.querySelector('#companionCloneableMessage').cloneNode(true);

                        messageElement.classList.toggle('hidden');
                        messageElement.id = '';
                        messageElement.firstElementChild.append(companionName);
                        messageElement.lastElementChild.append(message.body);

                        return messageElement;
                    }
                }

                function sendMessage() {
                    let message = document.querySelector('#messageInput');
                    axios.post('{{ route('messages.send') }}', {
                        'receiver_id': {{ $user->id }},
                        'body': message.value,
                    });

                    let m = {
                        body: message.value,
                    }
                    wrapper.prepend(createMessage(m, true));

                    message.value = '';

                    window.scrollTo(0, document.body.scrollHeight);
                }

                let cf = new centrifugo('ws://localhost:6060/connection/websocket', '{{route('messenger.gentoken')}}', {
                    'subscribeEndpoint': '/broadcasting/auth'
                });

                cf.subscribe('dialogs:dialog#' + currentUserId + ',' + {{$user->id}}, (msg) => {
                    wrapper.prepend(createMessage(msg.data.message));
                    window.scrollTo(0, document.body.scrollHeight);
                });

                cf.connect();

            </script>
        @endpush
    @endif
</div>


