<div class="sidebar sidebar-right sidebar-animate">
    <div class="tab-menu-heading siderbar-tabs border-0">
        <div class="tabs-menu ">
            <!-- Tabs -->
            <ul class="nav panel-tabs">
                <li class=""><a href="#tab"  class="active" data-toggle="tab">Profile</a></li>
                {{-- <li class=""><a href="#tab1" data-toggle="tab">Chat</a></li>
                <li><a href="#tab2" data-toggle="tab">Activity</a></li>
                <li><a href="#tab3" data-toggle="tab">Todo</a></li> --}}
            </ul>
        </div>
    </div>
    <div class="panel-body tabs-menu-body side-tab-body p-0 border-0 ">
        <div class="tab-content border-top">
            <div class="tab-pane active " id="tab">
                <div class="card-body p-0">
                    <div class="header-user text-center mt-4 pb-4">
                        <span class="avatar avatar-xxl brround"><img src="{{ asset('sparic/images/users/avatars/19.png')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
                        <div class="dropdown-item text-center font-weight-semibold user h3 mb-0">{{ Auth::user()->name }}</div>
                        <small>{{ Auth::user()->role->name }}</small>
                    </div>
                    <a class="dropdown-item  border-top" href="#">
                        <i class="dropdown-icon mdi mdi-account-outline "></i> Pengaturan Akun
                    </a>
                    <div class="card-body border-top">
                        <div class="row">
                            {{-- <div class="col-4 text-center">
                                <a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
                                <div>Inbox</div>
                            </div>
                            <div class="col-4 text-center">
                                <a class="" href=""><i class="dropdown-icon mdi mdi-tune fs-30 m-0 leading-tight"></i></a>
                                <div>Settings</div>
                            </div> --}}
                            <a class="col-4 text-center cursor-pointer" style="cursor: pointer"
                                onclick="document.getElementById('form_logout').submit();">
                                <span><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></span>
                                <div>Sign out</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{route('logout')}}" method="POST" id="form_logout">
    @csrf
</form>