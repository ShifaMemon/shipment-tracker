@extends('layouts.app')

@section('title', 'Shipment Details')

@section('content')

<h2>Shipment Details</h2>

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Tracking Number:</strong> {{ $shipment->tracking_number }}</p>

        <h5>Sender Information</h5>
        <p>Name: {{ $shipment->sender_name }}</p>
        <p>Address: {{ $shipment->sender_address }}</p>

        <h5>Receiver Information</h5>
        <p>Name: {{ $shipment->receiver_name }}</p>
        <p>Address: {{ $shipment->receiver_address }}</p>

        <p><strong>Current Status:</strong> {{ $shipment->status }}</p>
    </div>
</div>

<h4>Status Timeline</h4>

<ul class="list-group">
@foreach($shipment->statusLogs as $log)
    <li class="list-group-item">
        <strong>{{ $log->status }}</strong> - {{ $log->location }}
        <br>
        <small>{{ $log->created_at->format('d-m-Y H:i') }}</small>
    </li>
@endforeach
</ul>

<a href="{{ route('shipments.index') }}" class="btn btn-secondary mt-3">Back</a>

@endsection
