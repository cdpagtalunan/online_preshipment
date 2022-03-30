<!-- Navbar -->
<nav class="navbar navbar-expand navbar-dark border-bottom fixed-top py-1" >
    <!-- Left navbar links -->
    <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item">
            <h3 class="nav-link"><img src="{{ asset('public/image/pricon_logo2.png') }}" style="height: 40px;"><b>ISS Reminder </b></h3>
        </li>
        <span style="margin-top: -8px" class="text-white">|</span>
        
       <!--  <li class="nav-item d-none d-lg-inline-block">
            <a class="nav-link text-muted txtWorkInstruction"><h6 style="margin-top: 2px" class="text-white" disabled> Dashboard</h6></a>
        </li> -->

        
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto ">
        <span id="aLogout" data-toggle="modal" data-target="#modalLogout" style="cursor: pointer; color: white;">
            <i class="fas fa-sign-out-alt fa-lg mr-2 nav-link"></i>Logout
        </span>
        
        {{-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                @auth
                    {{ Auth::user()->name }}
                @endauth
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <span href="#" class="dropdown-item" id="aLogout" data-toggle="modal" data-target="#modalLogout">
                    <i class="fas fa-user mr-2"></i>Logout
                </span>
            </div>
        </li> --}}
    </ul>
</nav>

<div class="modal fade" id="modalLogout">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
                <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSignOut">
                @csrf
                <div class="modal-body">
                    <label id="lblSignOut" class="text-secondary mt-2">Are you sure to logout your account?</label>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" id="btnSignOut" class="btn btn-dark"><i id="iBtnSignOutIcon" class="fa fa-check"></i> Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>