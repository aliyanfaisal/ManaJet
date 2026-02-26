@extends('layouts.superadmin_app', ['use_bootstrap_js' => true])


@section('content')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/chat-style.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">


    <section class="message-area pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="chat-area">
                        <!-- chatlist -->
                        <div class="chatlist">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="chat-header">
                                        <div class="msg-search">
                                            <input type="text" class="form-control" id="inlineFormInputGroup"
                                                placeholder="Search" aria-label="search">
                                            <a class="add" href="#"><img class="img-fluid"
                                                    src="https://mehedihtml.com/chatbox/assets/img/add.svg"
                                                    alt="add"></a>
                                        </div>

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="Open-tab" data-bs-toggle="tab"
                                                    data-bs-target="#Open" type="button" role="tab"
                                                    aria-controls="Open" aria-selected="true">Chats</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="Closed-tab" data-bs-toggle="tab"
                                                    data-bs-target="#Closed" type="button" role="tab"
                                                    aria-controls="Closed" aria-selected="false">New</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal-body">
                                        <!-- chat-list -->
                                        <div class="chat-lists">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="Open" role="tabpanel"
                                                    aria-labelledby="Open-tab">
                                                    <!-- chat-list -->
                                                    <div class="chat-list">

                                                        @foreach ($chats as $chat)
                                                            @php
                                                                $id = $chat->sender_id == Auth::user()->id ? $chat->receiver_id : $chat->sender_id;
                                                                $chat_user = \App\Models\User::findOrFail($id); 
                                                            @endphp

                                                            <a href="{{ route('chat.show', ['id' => $chat_user->id]) }}"
                                                                data-userid="{{ $chat_user->id }}"
                                                                class="d-flex align-items-center mem-avatar">
                                                                <div class="flex-shrink-0">
                                                                    <img width="60" class="img-fluid"
                                                                        src="{{ $chat_user->profileImageUrl() }}" alt="chat_user img">
                                                                    <span class="active"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>{{ $chat_user->name }}</h3>
                                                                    <p>{{ $chat_user->role->role_name }}</p>
                                                                </div>
                                                            </a>
                                                        @endforeach

                                                        @if($chats==null)
                                                        <span>
                                                            No Chats Found
                                                        </span>

                                                        @endif

                                                    </div>
                                                    <!-- chat-list -->
                                                </div>

                                                <div class="tab-pane fade" id="Closed" role="tabpanel"
                                                    aria-labelledby="Closed-tab">

                                                    <!-- chat-list -->
                                                    <div class="chat-list">

                                                        <h6>{{ Auth::user()->role_id == 1 ? 'All Members' : 'All Teams Members' }}
                                                        </h6>
                                                        <div class="divider"></div>
                                                
                                                        @foreach ($team_members as $mem)

                                                            <a href="{{ route('chat.show', ['id' => $mem->id]) }}"
                                                                data-userid="{{ $mem->id }}"
                                                                class="d-flex align-items-center mem-avatar">
                                                                <div class="flex-shrink-0">
                                                                    <img width="60" class="img-fluid"
                                                                        src="{{ $mem->profileImageUrl() }}" alt="user img">
                                                                    <span class="active"></span>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h3>{{ $mem->name }}</h3>
                                                                    <p>{{ $mem->role->role_name }}</p>
                                                                </div>
                                                            </a>
                                                        @endforeach


                                                    </div>
                                                    <!-- chat-list -->
                                                </div>
                                            </div>

                                        </div>
                                        <!-- chat-list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- chatlist -->



                        <!-- chatbox -->
                        <div class="chatbox">
                            <div class="modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="msg-head">
                                        <div class="row">
                                            <div class="col-8">
                                                <div id="curr_chat" class="d-flex align-items-center">
                                                    @if (isset($curr_user))
                                                        <span class="chat-icon">
                                                            <img class="img-fluid"
                                                                src="{{ $curr_user->profileImageUrl() }}" width="45"
                                                                alt="image title">
                                                        </span>

                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid"
                                                                src="{{ $curr_user->profileImageUrl() }}" width="45"
                                                                alt="user img">
                                                        </div>
                                                        <div id="curr_chat_user" class="flex-grow-1 ms-3">
                                                            <h3>{{ Str::title($curr_user->name) }}</h3>
                                                            <p>{{ $curr_user->role->role_name }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <ul class="moreoption">
                                                    <li class="navbar nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Action</a></li>
                                                            <li><a class="dropdown-item" href="#">Another action</a>
                                                            </li>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li><a class="dropdown-item" href="#">Something else
                                                                    here</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="modal-body " @if (!isset($curr_user)) style="display: flex; align-items: center; justify-content: center;"  @endif> 
                                        @php
                                            $messages = [];
                                        @endphp
                                        @if (isset($curr_user))
                                                    @php
                                                        $messages = Auth::user()->messagesWith($curr_user->id);
                                                    @endphp

                                        @if ($messages)
                                        <div class="msg-body">
                                            <ul>

                                               
                                                        @foreach ($messages as $msg)
                                                            <li
                                                                class="@if ($msg->sender_id == Auth::user()->id) {{ 'repaly' }} @else {{ 'sender' }} @endif">
                                                                @if ($msg->has_attachments)
                                                                    <img width="350"
                                                                        src="{{ $msg->getAttachmentUrl() }}"
                                                                        alt=""><br>
                                                                @endif
                                                                <p> {{ $msg->message }} </p>
                                                                <span class="time">{{ $msg->time }}</span>
                                                            </li>
                                                        @endforeach
                                       

                                            </ul>
                                        </div>

                                        
                                        @endif

                                         @else
                                                        <div style="display: flex;flex: 1; justify-content: center;align-items: center;">
                                                            <h3>Select a Chat first!</h3> 
                                                        </div>
                                        @endif
                                    </div>


                                    <form action="{{ route('chat.send') }}" method="post" class="send-box"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex">
                                            <input hidden type="text" name="send_to_id"
                                                value="{{ isset($curr_user->id) ? $curr_user->id : '' }}" id="">
                                            <input @if (!isset($curr_user)) readonly disabled @endif required
                                                type="text" name="message" class="form-control" aria-label="message…"
                                                placeholder="Write message…">

                                            <button @if (!isset($curr_user)) disabled @endif type="submit"><i
                                                    class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>

                                        </div>

                                        <div class="send-btns">
                                            <div class="attach">
                                                <div class="button-wrapper">
                                                    <span class="label">
                                                        <img class="img-fluid"
                                                            src="https://mehedihtml.com/chatbox/assets/img/upload.svg"
                                                            alt="image title"> attached file
                                                    </span><input type="file" name="upload" id="upload"
                                                        class="upload-box" placeholder="Upload File"
                                                        aria-label="Upload File">
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatbox -->


                </div>
            </div>
        </div>

    </section>

@endsection


@section('js')
    <script>
        // Video tutorial/codealong here: https://youtu.be/fCpw5i_2IYU

        $('.friend-drawer--onhover').on('click', function() {

            $('.chat-bubble').hide('slow').show('slow');


        });

        // Video tutorial/codealong here: https://youtu.be/fCpw5i_2IYU
    </script>
@endsection
