@php $layout = 'layouts.admin_layout'; @endphp


@extends($layout)


@section('content_page')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
               
                <li class="breadcrumb-item active">Dashboard</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card card-primary m-2" style="min-width: 700px;">
                    <div class="card-body">
                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top:-13px;">
                          
                                <li class="nav-item">
                                <a class="nav-link active" id="reminder-tab" data-toggle="tab" href="#reminder" role="tab" aria-controls="reminder" aria-selected="true">Unpaid Billing/License Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reminder-archive-tab" data-toggle="tab" href="#reminderArchive" role="tab" aria-controls="archive" aria-selected="false">Paid Tab</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="workloads-person-tab" data-toggle="tab" href="#workloadsPerson" role="tab" aria-controls="person" aria-selected="false">Person in Charge Tab</a>
                                </li>
                               
                        
                          
                            
                        </ul> --}}
                        <div class="tab-content" id="myTabContent">
    
                            {{-- REMINDER TAB --}}
                            <div class="tab-pane fade show active" id="reminder" role="tabpanel" aria-labelledby="reminder-tab">

                                <div class="table responsive mt-2">
                                    <table id="tblWorkloads" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Due Date</th>
                                                <th>Person In Charge</th>
                                                <th style="width: 170px;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
    
                            {{-- ARCHIVE TAB --}}
                            <div class="tab-pane fade" id="reminderArchive" role="tabpanel" aria-labelledby="reminder-archive-tab">
                                <div class="table responsive mt-5">
                                    <table id="tblWorkloadsArchive" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Billing/License Name</th>
                                                <th>Due Date</th>
                                                <th>Person In Charge</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
    
                            {{-- PERSON INCHARGE TAB --}}
                            <div class="tab-pane fade" id="workloadsPerson" role="tabpanel" aria-labelledby="workloads-person-tab">
                                <div class="text-right mt-3">                   
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddPerson" id="btnShowPersonModal"><i class="fa fa-plus fa-md"></i> Add Person-In-Charge</button>
                                </div>
                                <div class="table responsive mt-2">
                                    <table id="tblWorkloadsPerson" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
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
<!--     {{-- JS CONTENT --}} -->
    @section('js_content')

   @endsection

@endsection
