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
                <div class="table-responsive">
                    <table id="blogs_table" class="table table-flush table-hover table-striped align-middle table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>API</th>
                                <th>Description</th>
                                <th>Auth</th>
                                <th>HTTPS</th>
                                <th>Cors</th>
                                <th>Link</th>
                                <th>Category</th>
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
            get_blogsData();
        });
        let table = $('#blogs_table');
        function get_blogsData() {
            var columns = [ 0,1,2,3 ];
            // Distroying Datatable is already initiated
            if ($.fn.DataTable.isDataTable('#blogs_table') ) {
                $('#blogs_table').dataTable().fnDestroy();
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
                    url:"{!! url('/blogs/ajax_data_request') !!}",
                    type:'get',
                    data:function (d){
                        d.action= "get_blogs";            
                    }, 
                },
                columns: [
                    { data: 'api', name: 'api', searchable: true, orderable:true, width:'10%'},
                    { data: 'description', name: 'description', searchable: true, orderable:false , width:'25%'},
                    { data: 'auth', name: 'auth', searchable: true, orderable:false , width:'10%'},
                    { data: 'https', name: 'https', searchable: true, orderable:false , width:'10%'},
                    { data: 'cors', name: 'cors', searchable: true, orderable:false , width:'10%'},
                    { data: 'link', name: 'link', searchable: true, orderable:true, width:'25%'},
                    { data: 'category', name: 'category', searchable: true, orderable:false, width:'10%'},
                    { data: 'created_at', name: 'created_at', searchable: true, orderable:false, width:'10%'},
                ],
            });
            $('#blogs_tablelength').addClass('float-end');
        }

        //Get Updated record after every 30 minuts if needed
        // setInterval(function () {
        //     get_blogsData();
        // }, 18000);
    </script>
@endsection