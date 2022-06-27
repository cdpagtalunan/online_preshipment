@php $layout = 'layouts.admin_layout'; @endphp

@extends($layout)

{{-- @section('title', 'Dashboard') --}}

@section('content_page')
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Online Pre-shipment</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Home</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                
                    <div class="card-header">
                    <h3 class="card-title">ONLINE PRE-SHIPMENT MODULE</h3>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6" style="display: none;" id="h-material-handler">
                            <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="h3TotalNoOfUsers"></h3>
                                <p>Material Handler</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-file-alt"></i>
                            </div>
                            <a href="materialhandler" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="display: none;" id="h-inspector">
                            <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="h3TotalNoOfUsers"></h3>
                                <p>Inspector</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-microscope"></i>
                            </div>
                            <a href="inspector" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6" style="display: none;" id="h-pps-whse">
                            <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="h3TotalNoOfUsers"></h3>
                                <p>PPS Warehouse</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-pallet"></i>
                            </div>
                            <a href="warehouse" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6" style="display: none;" id="h-tscn-whse">
                            <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 id="h3TotalNoOfUsers"></h3>
                                <p>TS/CN Warehouse</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fas fa-pallet"></i>
                            </div>
                            <a href="receiver-warehouse" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>
@endsection

@section('js_content')
  {{-- <script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
      // CountUserByStatForDashboard(1);
    });
  </script> --}}
@endsection
