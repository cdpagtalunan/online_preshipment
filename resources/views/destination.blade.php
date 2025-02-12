@php $layout = 'layouts.admin_layout'; @endphp

@extends($layout)


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
                            <li class="breadcrumb-item active">Destinations</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-end">
                                <button class="btn btn-primary" id="btnAddCategory">Add Category</button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-sm dt-responsive table-hover nowrap w-100" id="tableDestination">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Destination</th>
                                                    <th>Warehouse Section</th>
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
        </section>

        {{-- SCANNING CHECKING OF PRESHIPMENT --}}
        <div class="modal fade" id="modalCategory" data-formid="" tabindex="-1" role="dialog"
            aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCategoryTitle"></h4>
                        <button id="close" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formCategory" method="POST">
                        @csrf
                        <input type="text" name="id" id="catId" hidden>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="category">Destination</label>
                                <input type="text" class="form-control" id="destinationName" name="destination_name" required>
                            </div>
                            <div class="form-group">
                                <label for="category">Section</label>
                                {{-- <input type="text" class="form-control" id="destinationSection" name="destination_whse_section" required> --}}
                                <select name="destination_whse_section" id="destinationSection" class="form-control">
                                    <option value='ts'>TS</option>
                                    <option value='cn'>CN</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_content')
<script>
    let dtDestination;
    $(document).ready(function() {
        /*
            * DataTables
        */
        dtDestination = $('#tableDestination').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dt_destination') }}",
            columns: [
                { data: 'action', orderable: false, searchable: false },
                { data: 'destination_name',},
                { 
                    data: 'destination_whse_section', 
                    render: function(data){
                        return `<strong class='text-uppercase'>${data}</strong>`;
                    }
                },
            ],
            columnDefs: [
                {"className": "text-center", "targets": "_all"},
            ]
        });

        /*
            * Add Category
        */
        $('#btnAddCategory').click(function() {
            $('#modalCategoryTitle').text('Add Category');
            $('#modalCategory').modal('show');
        });

        /*
            * Save Category
        */
        $('#formCategory').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('store_destination') }}",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function(){
                },
                success: function (response) {
                    
                    if(response.result == true){
                        $('#modalCategory').modal('hide');
                        $('#formCategory').trigger('reset');
                        dtDestination.ajax.reload();
                        toastr.success(response.msg);
                    }
                    else{
                        toastr.error('Something went wrong');
                    }
                },
                error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });
    });

    /*
        * Edit Category
    */
    $(document).on('click', '.btnEditCategory', function(e){
        let id = $(this).data('id');
        let destination = $(this).data('destinationName');
        let destinationSection = $(this).data('destinationWhseSection');

        $('#catId').val(id);
        $('#destinationName').val(destination);
        $('#destinationSection').val(destinationSection).trigger('change');
        $('#modalCategoryTitle').text('Edit Category');
        $('#modalCategory').modal('show');
    });

    /*
        * Delete Category
    */
    $(document).on('click', '.btnDeleteCategory', function(){
        let id = $(this).data('id');
      
        var answer = window.confirm("Delete category?");
        if (answer) {
            $.ajax({
            type: "post",
            url: "{{ route('delete_destination') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (response) {
                if(response.result == true){
                    dtDestination.ajax.reload();
                    toastr.success(response.msg);
                }
                else{
                    toastr.error('Something went wrong');
                }
            },
            error: function(data, xhr, status){
                console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            }
        });
        }
       
    });
</script>
@endsection
