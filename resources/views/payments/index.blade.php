@extends('admin.layouts.app')

@section('title', 'Paiements')
@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-2">Total encaisse</h6>
                <h3 class="mb-0">{{ number_format($totalReceived, 2) }} DH</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-2">Aujourd'hui</h6>
                <h3 class="mb-0">{{ number_format($todayPayments, 2) }} DH</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-2">En attente</h6>
                <h3 class="mb-0">{{ $pendingCount }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-credit-card text-primary me-2"></i>
            Historique des paiements
        </h5>
    </div>
    <div class="card-body p-0">
        @if($payments->count() > 0)
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
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ $payment->invoice_number ?? $payment->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $payment->subscription->member->full_name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $payment->subscription->member->email ?? '' }}</small>
                                </td>
                                <td class="fw-bold">{{ number_format($payment->amount, 2) }} DH</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($payment->status == 'completed')
                                        <span class="badge bg-success">Paye</span>
                                    @elseif($payment->status == 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">{{ $payment->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                <h5>Aucun paiement enregistre</h5>
                <p class="text-muted">Les paiements apparaitront ici une fois enregistres.</p>
            </div>
        @endif
    </div>
</div>
@endsection
