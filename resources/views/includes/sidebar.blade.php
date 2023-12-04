<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto" >
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{route('dashboard')}}"  class="@if( request()->route()->named('dashboard') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        Dashboard
                    </a>
                </li>

                @if($authUser->userCan("can_view_project"))
                <li class="app-sidebar__heading">Projects</li>
                
                <li>
                    <a href="{{route('project.index')}}" class="@if( request()->route()->named('project.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-portfolio"></i>
                        All Projects
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                </li>
                @endif

                @if($authUser->userCan("can_add_project"))
                <li>
                    <a href="{{route('project.create')}}"  class="@if( request()->route()->named('project.create') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-portfolio"></i>
                        Add a Project
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                </li>

                @endif 

                
                @if($authUser->userCan("can_add_project_category"))
                <li>
                    <a href="{{route("project-categories.index")}}"  class="@if( request()->route()->named('project-categories.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-note2"></i>
                        Project Categories
                    </a>
                </li>
                @endif


                
                <li class="app-sidebar__heading">Tasks & Tickets</li>
                
                <li>
                    @if($authUser->userCan("can_view_task"))

                    @if($authUser->leadOfTeams()->isNotEmpty())
                    <a href="{{route("tasks.index", ['status'=>'under-review'])}}"  class="@if( request()->route()->named('tasks.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-note"></i>
                        Submitted Tasks
                    </a>
                    @endif 
                    <a href="{{route("tasks.index", ['status'=>'pending'])}}"  class="@if( request()->route()->named('tasks.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-note"></i>
                        On Going Tasks
                    </a>
                    <a href="{{route("tasks.index", ['status'=>'complete'])}}"  class="@if( request()->route()->named('tasks.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-note"></i>
                        Completed Tasks
                    </a>
                    @endif 

                    @if($authUser->userCan("can_view_ticket") || $authUser->isATeamLead())
                    <a href="{{route("tickets.index")}}"  class="@if( request()->route()->named('tickets.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-help1"></i>
                        Recent Tickets
                    </a>
                    @endif

{{-- 
                    <a href="dashboard-boxes.html">
                        <i class="metismenu-icon pe-7s-display2"></i>
                        Details Board
                    </a> --}}

                </li>

                @if($authUser->userCan("can_view_team") || $authUser->isATeamLead())
                <li class="app-sidebar__heading">Teams</li>
                @endif
                <li>
                    @if($authUser->userCan("can_view_team") || $authUser->isATeamLead())
                    <a href="{{route('teams.index')}}"  class="@if( request()->route()->named('teams.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-id">
                        </i>All Teams
                    </a>
                    @endif 

                    @if($authUser->userCan("can_add_team"))
                    <a href="{{route('teams.create')}}"  class="@if( request()->route()->named('teams.create') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-id">
                        </i>Add a Team
                    </a>
                    @endif
                </li>
                @if($authUser->userCan("can_view_team") || $authUser->isATeamLead())
                {{-- <li>
                    <a href="">
                        <i class="metismenu-icon pe-7s-eyedropper">
                        </i>Team Stats
                    </a>
                </li> --}}
                @endif 

                @if($authUser->userCan("can_add_user") || $authUser->userCan("can_add_permission"))
                <li class="app-sidebar__heading">Users</li> 
                @endif
                <li>
                    @if($authUser->userCan("can_add_user"))
                    <a href="{{route('users.index')}}"  class="@if( request()->route()->named('users.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-user">
                        </i>
                        All Users
                    </a>
                    @endif

                    @if($authUser->userCan("can_add_role"))
                    <a href="{{route('user-roles.index')}}"  class="@if( request()->route()->named('user-roles.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-add-user">
                        </i>
                        User Roles
                    </a>
                    @endif

                    @if($authUser->userCan("can_add_permission"))
                    <a href="{{route('permissions.index')}}"  class="@if( request()->route()->named('permissions.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-key">
                        </i>
                        Permissions
                    </a>
                    @endif
                </li>

                @if($authUser->userCan("can_chat"))
                <li class="app-sidebar__heading">Chat</li>
                <li>
                    <a href='{{route("chat.index")}}'  class="@if( request()->route()->named('chat.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-chat">
                        </i>Messenger
                    </a>
                </li>
                @endif

                @if($authUser->userCan("can_manage_options"))
                <li class="app-sidebar__heading">Settings</li>
                <li>
                    <a href='{{route("settings.index")}}'  class="@if( request()->route()->named('settings.index') ) mm-active @endif">
                        <i class="metismenu-icon pe-7s-settings">
                        </i>Settings
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>