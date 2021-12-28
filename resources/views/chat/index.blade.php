@extends('layouts.main')
@section('style')
<style>
    .text-muted {
        color: #6e7da2 !important;
        padding: 5px 10px;
        display: initial;
        border-radius: 10px;
        background: lightgreen;
    }
    .my-chat-item {
        padding: 15px 0;
        transition: all ease .2s;
        text-align: right;
    }
</style>
@endsection
@section('content')
    @php $me = Auth()->user(); @endphp
    <section class="admin-content">
        <div class="container-fluid ">
            <div class="row bg-white">
                <div class="col d-none d-lg-block p-all-0 text-white  chat-sidebar">
                    <div class="usable-height panel">
                        <div class="panel-header p-all-15 chat-sidebar-header">
                            <div class="media">
                                <div class="d-inline-block m-r-10 align-middle">

                                    <div class="avatar avatar avatar-online">
                                        @if($me->avatar)
                                            <img class="rounded-circle" src="{{ asset($me->avatar) }}" alt="{{$me->name}}">
                                        @else
                                            <span class="avatar-title rounded-circle bg-white-translucent"> {{ substr($me->fullname ?? $me->name, 0, 1) }} </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="media-body my-auto">

                                    <p class="font-secondary m-b-0">{{ $me->fullname ?? $me->name }}</p>
                                    <p class="text-overline m-b-0 text-truncate">
                                        makeContent INC
                                    </p>
                                </div>

                                <!--                                close button for mobile-->
                                <button type="button" class="d-inline-block d-lg-none light">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>

                        </div>
                        <div class=".panel-body p-t-10  border-white">
                            <a href="#" class=" chat-sidebar-item btn-ghost">
                                <div class="w-100 text-truncate">
                                    All Chats
                                </div>
                            </a>
                            <div class="clearfix border-bottom border-white">
                               
                            </div>
                            @foreach($users as $key=>$user)
                            <a href="javascript: chooseUser('{{ $key }}')" class=" chat-sidebar-item btn-ghost">
                                <div class="w-100 text-truncate">
                                    {{ $user->fullname ?? $user->name }}
                                    {{--<span class="badge badge-info">6</span>--}}
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col p-all-0">
                    <div class="usable-height panel chat-window">
                        <div class="row chat-window-header no-gutters">
                            <div class="col-8 col-lg-6 ">
                                <!--                                Toggle for chat options in sidebar-->
                                <div class="d-inline-block d-lg-none align-middle">
                                    <a  data-target=".chat-sidebar" data-toggleclass="d-none" href="#" class="m-r-10">
                                        <i class="mdi mdi-menu mdi-24px"></i>
                                    </a>
                                </div>
                                <div class="d-inline-block align-middle">
                                    <p class="font-secondary m-b-0" id="selected_user"></p>

                                    <a href="#" class="m-r-5">Last Seen 1 hour ago</a>
                                    <span class="d-none d-lg-inline"><span class="m-r-5">|</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4 col-lg-6  text-right">
                                <div class="d-inline-block  m-r-10">
                                    <form class="form-inline">
                                        <input type="search" name="search" id="search" class="form-control " placeholder="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body chat-window-body" id="chatbody">

                        </div>
                        <div class="panel-footer chat-window-footer">
                            <div class="row full-height">
                                <div class="col-12 my-auto">
                                    <div class="input-group input-group-flush ">
                                        <input type="text" id="messageText"
                                               class="form-control" style="height: auto"
                                               placeholder="Message for @kimberly">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="mdi mdi-plus "></i>
                                            </div>
                                        </div>
                                        <input type="file" style="display: none" name="file" id="file">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                {{--<a href="javascript: attachFile()" class="btn btn-outline-dark btn-rounded-circle mr-1">--}}
                                                    {{--<span class="mdi mdi-file"></span>--}}
                                                {{--</a>--}}
                                                <a href="javascript: sendMsg()" class="btn btn-dark btn-sm">Send</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!--Additional Page includes-->
    {{--<script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>--}}
    <!--chart data for current dashboard-->
    <script>
        var _token = '{{ csrf_token() }}';
        var selectedUser;
        var chatBodyObj = document.getElementById('chatbody');
        var users = @json($users);
        console.log(users);

        $(function () {
            chooseUser(0);

            $('#search').on('keydown', function () {
                var searchText = $(this).val();
                updateChatBlock(searchText);
            });
            $('#search').on('search', function () {
                var searchText = $(this).val();
                updateChatBlock(searchText);
            });
        });

        function updateChatBlock(searchText) {
            var chatItems = $('.chat-item');
            for(var i = 0; i<chatItems.length; i++) {
                var text = $(chatItems[i]).text().trim().replace(/\n/g, '').replace(/ /g, '');
                console.log(text);
                if(text.indexOf(searchText)>-1) {
                    $(chatItems[i]).show();
                }else{
                    $(chatItems[i]).hide();
                }
            }
        }

        function displayUser() {
            if(selectedUser) {
                $('#selected_user').html(selectedUser.fullname || selectedUser.name)
            }
        }

        function chooseUser(uid) {
            selectedUser = users[uid];
            displayUser();
            getLatestMsgs();
        }

        function getLatestMsgs() {
            if(selectedUser) {
                $.ajax({
                    url: '{{ route('chat.get_latest') }}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        uid: selectedUser.id
                    },
                    success: function (res) {
                        $('#chatbody').html(res);
                        scrollToBottom();
                    }
                })
            }
        }

        function sendMsg() {
            var msgText = $('#messageText').val();
            $.ajax({
                url: '{{ route('chat.send') }}',
                method: 'POST',
                data: {
                    _token: _token,
                    text: msgText,
                    uid: selectedUser.id
                },
                success: function (res) {
                    var chatHtml = $('#chatbody').html();
                    $('#chatbody').html(chatHtml + res);
                    scrollToBottom();
                }
            })
            $('#messageText').val('');
        }

        function scrollToBottom() {
            chatBodyObj.scrollTop = chatBodyObj.scrollHeight;
        }

        function attachFile() {
            $('#file').trigger('click');
        }
    </script>
@endsection

