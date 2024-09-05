@extends('layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <table id="datatables" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>
                                Nama
                            </th>
                            <th>
                                Tanggal Izin Kerja
                            </th>
                            <th>
                                Status
                            </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            try {
                $('#datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('work-permit') }}",
                    order: [
                        [3, 'desc']
                    ],
                    columns: [{
                            data: 'no',
                            name: 'no',
                            searchable: false,
                            orderable: false,
                            width: '5%'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'date',
                            name: 'date',
                            className: 'text-center'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'text-center',
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    ],
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    scrollX: true,
                    fixedHeader: true,
                    scrollY: '50vh',


                });
            } catch (error) {
                error = error.responseJSON;

                alert(error.message);
            }

           

        });
    </script>
@endpush