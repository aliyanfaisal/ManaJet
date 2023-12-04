<div class="app-header header-shadow">
    <div class="app-header__logo">
        {{-- <div class="logo-src"></div> --}}
        <img src="{{asset('assets/images/logo.png')}}" width="90">
        <div class="header__pane ml-auto" id="afb-sidebar">
            <div>
                <button type="button" class="hamburger afb-hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button"
                class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            
            <ul class="header-menu nav">
                @if($authUser->userCan("can_manage_options"))
                <li class="btn-group nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-edit"></i>
                        Reports
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa fa-cog"></i>
                        Settings
                    </a>
                </li>
                @endif



                @php
                    $notifications=[];

                    if(Auth::check()){

                        $notifications= Auth::user()->notifications()->limit(10)->get();

                        $unseen = $notifications->filter(function($noti){
                            return $noti->seen==0;
                        });
                    }  

                @endphp


                <li class="dropdown nav-item">
 
                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="nav-link"> 
                                        <i class="nav-link-icon fa fa-bell"></i>
                                        @if($notifications->isNotEmpty())
                                        <span class="btn__badge pulse-button ">{{count($unseen)}}</span> 
                                        @endif
                                        Notifications 
                                      
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>

                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right" style="min-width:30rem">

                                    @if($notifications->isEmpty())
                                    <div class="text-center">No Notifications</div>
                                    @endif
                                    @foreach($notifications as $noti)

                                        <a type="button" href="{{$noti->link}}" style="@if($noti->seen==0) background: #E0F3FF; @endif color: #5f5f5f; padding-left: 30px;" class="dropdown-item nav-link" >
                                            <span style="display: flex; align-items: center;">
                                                <i class="nav-link-icon fa fa-bell mr-2" style="color:#262626"></i> 
                                                
                                                <span style=" align-items: flex-start;display: inline-flex; flex-direction: column;">
                                                    <span class="font-weight-bold">
                                                        {{$noti->notification_title}}
                                                    </span> 
                                                        <p style="margin: 0px">{{Str::limit( $noti->notification_content , 20)}}</p>
                                                    
                                                </span>
                                            </span>
                                            

                                        </a>

                                        <div tabindex="-1" class="dropdown-divider"></div>

                                    @endforeach
 
                                        
                                </div>
                            </div>
                        
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">

                            <div class="btn-group">
                                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="p-0 btn">
                                    <img width="42" class="rounded-circle" src="{{ Auth::user()->profileImageUrl()}}"
                                        alt="">
                                    <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">
                                    <button type="button" tabindex="0" class="dropdown-item">User
                                        Account</button>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                   
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"  
                                            class="dropdown-item">Logout</button>
                                        </form>
                                        
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                               {{ strtoupper(\Auth::user()->name)}}
                            </div>
                            <div class="widget-subheading">
                                @php
                                   $user_role= \Auth::user()->role;
                                
                                @endphp
                                @if (($user_role)) 
                                
                                    {{$user_role->role_name}}
                                
                                @endif
                            </div>
                        </div>
                        <div class="widget-content-right header-user-info ml-3">
                            <button type="button"
                                class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 