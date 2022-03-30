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
            
            <li class="breadcrumb-item active">Admin</li>
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
                {{-- <div class="tab-content" id="myTabContent" > --}}
                    {{-- <div class="tab-pane fade show active" id="MH-checking" role="tabpanel" aria-labelledby="MH-checking-tab"> --}}
                        <div style="float: right"> 
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddUser" id="btnAddUser">Add User</button>
                        </div><br><br>
                        <div class="table responsive mt-2">
                            <table id="tblPreshipment" class="table table-sm table-bordered table-striped table-hover dt-responsive nowrap" style="width: 100%; min-width: 10%">
                                <thead>
                                    <tr>
                                        <th>Action</th>                                 
                                        <th>Status</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>User Level</th>                                 
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    {{-- </div> --}}
                {{-- </div> --}}
                
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>

  <div class="modal fade" id="modalAddUser" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog"> 
      <div class="modal-content">
          <form action="post" id="add_user_form">
            @csrf
          <div class="modal-header">
            <h4 class="modal-title"><i class="fa fa-user"></i>User Access</h4>
            <button id="close" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            
            <input type="hidden" id="txtEditUserId" name="edit_user_id">

            <div class="row">
                <div class="col-sm-12">
                  <label>RapidX User</label>
                  <select class="form-control select-rapidx-user" id="rapidx_user" name="rapidx_user" required>
                    <option selected disabled>-- Select One --</option>
                  </select>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <label>Email</label>
                <input type="text" class="form-control" name="rapidx_email" id="rapid_email" readonly>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                  <label>Access Level</label>
                  <select class="form-control" id="access_level" name="access_level" required>
                    <option selected disabled>-- Select One --</option>
                    <option value="admin">Administrator</option>
                    <option value="user">User</option>
                  </select>
                </div>
            </div>
            
    
            <div class="row">
                <div class="col-sm-12">
                  <label>Department</label>
                  <select class="form-control" id="user_department" name="user_department" required>
                    <option selected disabled>-- Select One --</option>
                    {{-- <option value="ISS">ESS</option> --}}
                    {{-- <option value="HRD">HRD</option> --}}
                    {{-- <option value="Logistics">Logistics</option> --}}
                    {{-- <option value="Facility">Facility</option> --}}
                    {{-- <option value="EMS">EMS</option> --}}
                    {{-- <option value="Finance">Finance</option> --}}
                    {{-- <option value="IAS">IAS</option> --}}
                    {{-- <option value="QAD">QAD</option> --}}
                    {{-- <option value="Secretariat">Secretariat</option> --}}
                    <option value="ISS">ISS</option>                
                    {{-- <option value="FAS">FAS</option> --}}
                    {{-- <option value="TS Eng">TS Eng</option> --}}
                    <option value="TS Prod">TS Prod</option>
                    <option value="TS QC">TS QC</option>
                    <option value="TS WHSE">TS WHSE</option>
                    <option value="PPC">PPC</option>
                    {{-- <option value="CN 2A">CN 2A</option> --}}
                    {{-- <option value="CN 2B">CN 2B</option> --}}
                    <option value="CN WHSE">CN WHSE</option>
                    <option value="PPS">PPS</option>
                    <option value="PPS CN">PPS CN</option>
                    {{-- <option value="YF">YF</option> --}}
                  </select>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
            <button type="submit" class="btn btn-success">Yes</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  
  <div class="modal fade" id="modalUserDelete" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-user-slash"></i> Delete User </h4>
          <button id="close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          
          <div class="modal-body">
            <input type="text" id="txtUserDeleteId" name="delete_user">
            <h4>Are you sure you want to delete this user?</h4>

          </div>
          <div class="modal-footer">
            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="btn-delete" class="btn btn-success">Yes</button>
          </div>

        
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalUserRestore" data-backdrop="static" style="overflow: auto;">
    <div class="modal-dialog"> 
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-redo"></i> Enable User </h4>
          <button id="close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
          
          <div class="modal-body">
            <input type="text" id="txtUserEnableId" name="enable_user">
            <h4>Are you sure you want to enable this user?</h4>

          </div>
          <div class="modal-footer">
            <button id="close" data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="btn-enable" class="btn btn-success">Yes</button>
          </div>

        
      </div>
    </div>
  </div>



</div>

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
<script>
  var dataTablePreshipment,dataTablePreshipmentList,dataTableForWhse,dataTableForWhseList;
    
  $(document).ready(function () {
    


    //PACKING LIST DATA TABLE
    dataTableUser = $("#tblPreshipment").DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
          url: "get_user", 
      },
      "columns":[    
          { "data" : "action"},
          { "data" : "status"},
          { "data" : "rapidx_user_details.username"},
          { "data" : "rapidx_user_details.name"},
          { "data" : "email"},
          { "data" : "department"},
          { "data" : "user_level"},
        //   { "data" : "action"},
          
      ],
    }); 

    
    GetUserDropdown($(".select-rapidx-user"));

    $('.select-rapidx-user').select2({
        theme: "bootstrap4"
    });

    
    $('#add_user_form').submit(function(e){
        e.preventDefault();
        addUser();
    });

    $('#rapidx_user').on('change', function(){
      var rapidxId = $(this).val();

      getUserEmail(rapidxId);
    });
    $('#btnAddUser').on('click',function(){
      $('#add_user_form')[0].reset();
      $('#rapidx_user').val('0').trigger('change');
    });

    $(document).on('click', '.btn-user-edit', function(){
      let userId = $(this).attr('btn-user-id');
      $('#txtEditUserId').val(userId);
      getUserDetailsForEdit(userId);
    });

    $(document).on('click', '.btn-user-delete', function(){
      let userId = $(this).attr('btn-user-id');
      $('#txtUserDeleteId').val(userId);
      
    });

    $('#btn-delete').on('click', function(){
      let userId = $('#txtUserDeleteId').val();
      // console.log(userId);
      userDelete(userId);
    });
    
    $(document).on('click', '.btn-user-enable', function(){
      let userId = $(this).attr('btn-user-id');
      $('#txtUserEnableId').val(userId);
      
    });
    
    $('#btn-enable').on('click', function(){
      let userId = $('#txtUserEnableId').val();
      // console.log(userId);
      userEnable(userId);
    });
  

  });

</script>

@endsection

@endsection
