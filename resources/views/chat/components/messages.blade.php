@for($i = count($messages) - 1; $i>=0; $i--)
    @php $message = $messages[$i] @endphp
    @if($myId !== $message->send_user->id)
    <div class="chat-item row">
        <div class="col-12">
            <div class="media">
                <div class="d-inline-block m-r-10 align-middle">
                    <div class="avatar avatar">
                        @if($message->send_user->avatar)
                            <img class="avatar-title rounded-circle" src="{{ asset($message->send_user->avatar) }}" alt="{{ $message->send_user->name }}" />
                        @else
                            <span class="avatar-title rounded-circle  bg-dark text-capitalize"> {{ substr($message->send_user->fullname ?? $message->send_user->name, 0, 1) }} </span>
                        @endif
                    </div>
                </div>
                <div class="media-body my-auto">
                    <p class="font-secondary m-b-0 m-b-5">
                        {{ $message->send_user->getFullName() }}<span class="font-primary m-l-10">{{ $message->created_at }}</span></p>
                    <div></div>
                    <div class="text-muted">
                        {{ $message->text }}
                    </div>
                    @if($message->attach)
                        <div class="d-block">
                            <div class="card w-25">
                                <img class="card-img-top" src="/assets/img/social/s15.jpg"
                                     alt="Card image cap">
                                <div class="text-white card-controls">
                                    <a href="{{ asset($message->attach) }}" class="badge" target="_blank">
                                        <i class="mdi mdi-18px mdi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="my-chat-item row">
            <div class="col-12">
                <div class="media">
                    <div class="media-body my-auto">
                        <p class="font-secondary m-b-0 m-b-5">
                            <span class="font-primary m-l-10">{{ $message->created_at }}</span></p>
                        <div></div>
                        <div class="text-muted">
                            {{ $message->text }}
                        </div>
                        @if($message->attach)
                            <div class="d-block">
                                <div class="card w-25">
                                    <img class="card-img-top" src="/assets/img/social/s15.jpg"
                                         alt="Card image cap">
                                    <div class="text-white card-controls">
                                        <a href="{{ asset($message->attach) }}" class="badge" target="_blank">
                                            <i class="mdi mdi-18px mdi-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endfor
