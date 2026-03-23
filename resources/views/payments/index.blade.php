@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Flash message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Liste des paiements</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->member->name }}</td>
                <td>{{ $payment->plan->name }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection