@extends('layouts.app')


@section('title', 'Shipment List')

@section('content')

    <h2 class="mb-4">Shipment List</h2>


    <table class="table table-bordered">
        <thead>
            <tr class="table-secondary text-center fw-bold text-uppercase">
                <td colspan="6">
                    <form method="GET" action="{{ route('shipments.custom') }}" class="row g-3 mb-3">

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by Tracking Number"
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>

                            <a href="{{ route('shipments.custom') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </form>
                <td>
            </tr>
                <tr>
                    <th>#</th>
                    <th>Tracking Number</th>
                    <th>Receiver Name</th>
                    <th>Destination City</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
        <tbody>
            @forelse ($shipments as $index => $shipment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $shipment->tracking_number }}</td>
                    <td>{{ $shipment->receiver_name }}</td>
                    <td>{{ $shipment->receiver_address }}</td>
                    <td>{!! $shipment->status_badge !!}</td>
                    <td>{{ $shipment->created_at->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('shipments.show', $shipment->id) }}">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No Shipments Found</td>
                </tr>
            @endforelse
        </tbody>

    </table>
    <div class="d-flex mt-3">
        {{ $shipments->appends(request()->query())->links() }}
    </div>

@endsection
