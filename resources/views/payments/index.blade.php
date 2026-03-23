@extends('admin.layouts.app')

@section('title', 'Paiements')
@section('page-title', 'Historique des paiements')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card text-center bg-success text-white">
            <div class="stat-number">{{ number_format($totalReceived, 2) }} DH</div>
            <div class="stat-label">Total encaissé</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center bg-info text-white">
            <div class="stat-number">{{ number_format($todayPayments, 2) }} DH</div>
            <div class="stat-label">Aujourd'hui</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center bg-warning text-white">
            <div class="stat-number">{{ $pendingCount }}</div>
            <div class="stat-label">En attente</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Tous les paiements</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                #####
                    <th>Facture N°</th>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->invoice_number }}</td>
                    <td>{{ $payment->subscription->member->full_name }}</td>
                    <td>{{ number_format($payment->total_paid, 2) }} DH</td>
                    <td>{{ $payment->payment_method_name }}</td>
                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                            {{ $payment->status_name }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.payments.download', $payment) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
@endsection