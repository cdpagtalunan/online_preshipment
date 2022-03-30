<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-danger elevation-4" style="height: 100vh;">
    <!-- Brand Logo -->
    <a href="" class="brand-link text-center">
       <!--  <img src="{{ asset('public/images/pricon_logo2.png') }}"
            alt="OITL"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
            {{-- <i class="brand-image elevation-3 mt-2 fas fa-book-reader"></i> --}} -->
        <span class="brand-text font-weight-light">Online Pre-Shipment</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="../RapidX/" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Go to Rapidx</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                        {{-- <i class="nav-icon fa fa-users"></i> --}}
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

            
                {{-- <li class="nav-header font-weight-bold" style="font-size: 1rem"></li> --}}
            
                <div class="nav-item has-treeview" id="ppc-id"  >
                    <a href="materialhandler" class="nav-link">
                    <li>
                        
                        <i class="nav-icon fas fa-pallet"></i>
                            <p>Material Handler</p>
                    </li>
                    </a>

                </div>

                
                <div class="nav-item has-treeview" id="grinding-id" >
                    <a href="inspector" class="nav-link">
                    <li>
                        <i class="nav-icon fas fa-file-download"></i>
                            <p>Inspector</p>
                    </li>
                    </a>

                   
                </div>

                <div class="nav-item has-treeview" id="grinding-id1" >
                    <a href="warehouse" class="nav-link">
                        <li>
                            
                            <i class="nav-icon fas fa-folder"></i>
                                <p>PPS Warehouse</p>
                        </li>
                    </a>
                </div>
                <div class="nav-item has-treeview" id="grinding-id3" >
                    <a href="receiver-warehouse" class="nav-link">
                        <li>
                            
                            <i class="nav-icon fas fa-folder"></i>
                                <p>TS/CN Warehouse</p>
                        </li>
                    </a>
                </div>

               
                <div class="nav-item has-treeview" id="grinding-id2" >
                    <a href="" class="nav-link">
                    <li>
                        
                            <i class="fas fa-history"></i>
                            <p>Transaction History</p>
                    </li>
                    </a>

                </div>

                <div class="nav-item has-treeview" id="admin-id" >
                    <a href="" class="nav-link">
                    <li>
                        
                            <i class="nav-icon fa fa-users"></i>
                            <p>User Management</p>
                    </li>
                    </a>

                </div>

                <!-- <li class="nav-header">ADMINISTRATOR</li>
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>User Management</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>List of  Workloads</p>
                    </a>
                </li> -->
            </ul>
        </nav>
    </div>
</aside>