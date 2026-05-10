@extends('admin.layouts.app')

@section('title', 'Paiements')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Total encaisse</h6>
                <h3 class="mb-0">{{ number_format($totalReceived, 2) }} DH</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Aujourd'hui</h6>
                <h3 class="mb-0">{{ number_format($todayPayments, 2) }} DH</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">En attente</h6>
                <h3 class="mb-0">{{ $pendingCount }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Historique des paiements</h5>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Nouveau paiement
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Facture</th>
                        <th>Membre</th>
                        <th>Montant</th>
                        <th>Methode</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>#{{ $payment->invoice_number ?? $payment->id }}</td>
                            <td>{{ $payment->subscription->member->full_name ?? 'N/A' }}</td>
                            <td>{{ number_format($payment->total_paid, 2) }} DH</td>
                            <td>{{ $payment->payment_method_name }}</td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($payment->status === 'completed')
                                    <span class="badge bg-success">Paye</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge bg-warning">En attente</span>
                                @else
                                    <span class="badge bg-secondary">{{ $payment->status_name }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Aucun paiement</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $payments->links() }}
    </div>
</div>
@endsection
