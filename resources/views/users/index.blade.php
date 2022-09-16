@extends('layouts.master')
@section('pagetitle') {{ $pagetitle }} @endsection
@section('css')
@include('layouts.datatable_css')
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                @component('components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'pagetitle' => $pagetitle, 'urls' => $urls])
                @endcomponent
            </div>
            <div class="card-body">
                <div class="row">
                    <?php
                    
                    $arr = Session::get('arr');
                    if($arr){
                    ?>
                        <div class="alert alert-success" role="alert">
                                {{$arr['insert']}} rows Inserted.
                        </div>
                        @if($arr['errors'] > 0)
                            <div class="alert alert-danger" role="alert">
                                {{$arr['errors']}} rows failed.
                            </div>
                        @endif
                        @if($arr['errors'] > 0)
                            <div class="alert alert-danger" role="alert">
                                {!! $arr['errors_html'] !!}
                            </div>
                        @endif
                    <?php } ?>
                </div>
                <form action="{{route('import-data')}}" method="POST" id="upload_data_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4 mb-3">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div>
                                <label for="file" class="form-label text-white">User Data File</label>
                                <input type="file" class="form-control text-white file" name="file" id="file">
                                <span class="text-info fs-10">File Size less than : 2MB , File Type : .csv , .xlsx </span>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-end p-2">
                            <button type="submit" class="btn btn-success mt-27 w-sm">Upload File</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users_table" class="table table-flush table-hover table-striped align-middle table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@include('layouts.datatable_js')
    <script>
        $(document).ready(function() {
            get_usersData();
        });
        let table = $('#users_table');
        function get_usersData() 
        {
            var columns = [ 0,1,2,3 ];
            // Distroying Datatable is already initiated
            if ($.fn.DataTable.isDataTable('#users_table') ) {
                $('#users_table').dataTable().fnDestroy();
            }
            table.DataTable({
                ordering: true,
                processing: true,
                serverSide: true,
                stateSave: false,
                responsive: true,
                autoWidth:false,
                lengthMenu: [[25, 50, 75, 100], [25, 50, 75, 100]],
                aaSorting : [],
                pageLength : 25,
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'colvis'
                    }
                ],
                exportOptions: {
                    modifer: {
                            page: 'all'
                            }
                },
                ajax: {
                    url:"{!! url('/users/ajax_data_request') !!}",
                    type:'get',
                    data:function (d){
                        d.action= "get_users";            
                    }, 
                },
                columns: [
                    { data: 'id', name: 'id', searchable: false, orderable:true, width:'5%'},
                    { data: 'name', name: 'name', searchable: true,orderable:false , width:'25%'},
                    { data: 'email', name: 'email', searchable: true, orderable:false , width:'20%'},
                    { data: 'phone', name: 'phone', searchable: true, orderable:false , width:'10%'},
                    { data: 'address', name: 'address', orderable:false, width:'30%'},
                    { data: 'created_at', name: 'created_at', orderable:false, width:'10%'},
                ],
            });
            $('#uusers_table_length').addClass('float-end');
        }

        //Get Updated record after every 30 minuts if needed
        // setInterval(function () {
        //     get_usersData();
        // }, 18000);
    </script>
@endsection