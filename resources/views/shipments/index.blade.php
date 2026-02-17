@extends('layouts.app')

@section('title', 'Shipment List')

@section('content')

    <h2 class="mb-4">Shipment List</h2>

    <table class="table table-bordered" id="shipmentTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Tracking Number</th>
                <th>Receiver Name</th>
                <th>Destination City</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

@endsection

@push('scripts')
    <script>
        $(function() {
            $('#shipmentTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: "{{ route('shipments.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tracking_number',
                        name: 'tracking_number'
                    },
                    {
                        data: 'receiver_name',
                        name: 'receiver_name'
                    },
                    {
                        data: 'receiver_address',
                        name: 'receiver_address'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',

                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
