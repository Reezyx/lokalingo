@extends('layouts.app')
@section('title', 'Manajemen User')

{{-- @push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css" />
@endpush --}}

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="table-responsive mt-xl-7 mt-lg-7">
                    <p class=" text-black-50 text-center font-weight-bold font-weight-900">Manajemen User</p>
                    <table class="table w-100" id="table-user">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Daerah Asal</th>
                                <th>Exp</th>
                                <th>#Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        var table;
        var isUpdate = false;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $.fn.dataTable.ext.errMode = 'none';

        var KTDatatablesDataSourceAjaxServer = function() {
            var initTable1 = function() {
                table = $('#table-user');
                let i = 1;

                // begin first table
                table = table.DataTable({
                    "oLanguage": {
                        "sSearch": "Cari"
                    },
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('user.datatable') }}',
                        type: "GET",
                        data: function(data) {}
                    },
                    order: [
                        [1, 'asc']
                    ],
                    language: {
                        "processing": '<div class="blockui" style="margin: 0 auto;"><span>Please wait...</span><span><div class="kt-spinner kt-spinner--v2 kt-spinner--info "></div></span></div>',
                    },
                    columns: [{
                            data: "DT_RowIndex",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'full_name',
                            name: 'full_name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'asal',
                            name: 'asal'
                        },
                        {
                            data: 'exp',
                            name: 'exp'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                table.on('draw', function() {});
            };

            return {
                //main function to initiate the module
                init: function() {
                    initTable1();
                },
            };
        }();

        $(document).ready(function() {
            KTDatatablesDataSourceAjaxServer.init();
        });
    </script>
@endpush
