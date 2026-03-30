@extends('layouts.app')


@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{__('app.model_chat')}}</h4>
                </div>
                <div class="card-body">
                    @if(session('msg'))
                        <div class="alert alert-success">{{ session('msg') }}</div>
                    @endif

                    <div class="chat">


                        
                        @forelse ($msgs as $msg) 

                        <div class="msg {{ $msg->user == 'ai' ? 'ai' : '' }}">
                            <div class="head">
                                <img src="{{ asset('img/clients/default.png') }}" alt="Defualt User Image">
                            </div>
                            <div class="body">
                                <p> {{ $msg->message }} </p>
                                <span><small class="text-muted">{{ $msg->created_at }}</small></span>
                            </div>
                        </div>


                        @empty
                            <p style="font-size: 3em; text-align: center; color: #555;">
                                No Messages Yet :( <br> Start New Message?
                            </p>
                        @endforelse



                    </div>

                    <style>
                        .chat {
                            height: 300px;
                            overflow-y: scroll;
                            border-bottom: 4px solid #999; 
                            .msg {
                                margin: 10px 0;
                                padding: 10px;
                                border: 1px solid #ccc;
                                border-radius: 5px;
                                background-color: #f5f5f5;
                                color: #333;
                                display :flex;
                                flex-direction: column;
                                &.ai {
                                    align-items: flex-end;
                                }
                                .head {
                                    img {
                                        max-width: 8%;
                                    }
                                }
                                .body {
                                    margin : 5px 5px 0;
                                    p {
                                        margin-bottom: 0;
                                        font-size: 14px;
                                        line-height: 1.7;
                                        color: #333 ;
                                    }
                                }
                            }
                        }
                    </style>

                    

                    <form action="{{ route('ai.chat') }}" id="ai_chat_form" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="3" placeholder="Type your question or prompt here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{__('app.send')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelector('#ai_chat_form').addEventListener('submit', function(event) {


        event.preventDefault();
        const message = document.querySelector('textarea[name="message"]').value;
        document.querySelector('textarea[name="message"]').value = '';
        const chat = document.querySelector('.chat');



        // Send Using Fetch
        fetch('{{ route('ai.chat') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message
            })
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 500) {
                    return response.text().then(text => {
                        document.write(text);
                    });
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            
            // Add user message to chat
            const userMsg = document.createElement('div');
            userMsg.classList.add('msg');
            userMsg.innerHTML = `
                <div class="head">
                    <img src="{{ asset('img/clients/default.png') }}" alt="Defualt User Image">
                </div>
                <div class="body">
                    <p>${message}</p>
                    <span><small class="text-muted">{{ Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</small></span>
                </div>
            `;
            chat.appendChild(userMsg);
            
            // Add AI response to chat
            const aiMsg = document.createElement('div');
            aiMsg.classList.add('msg', 'ai');
            aiMsg.innerHTML = `
                <div class="head">
                    <img src="{{ asset('img/clients/default.png') }}" alt="Defualt User Image">
                </div>
                <div class="body">
                    <p>${data.response}</p>
                    <span><small class="text-muted">{{ Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</small></span>
                </div>
            `;
            chat.appendChild(aiMsg);
            
            chat.scrollTop = chat.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
        });

        
    });
</script>
@endsection