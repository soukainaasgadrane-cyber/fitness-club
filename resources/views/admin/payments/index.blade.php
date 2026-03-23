@extends('admin.layouts.app')

@section('title', 'Paiements')

@section('content')

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">Total encaissé</h5>
                <h2 class="mt-2 mb-0">{{ number_format($totalReceived ?? 0, 2) }} DH</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">Aujourd'hui</h5>
                <h2 class="mt-2 mb-0">{{ number_format($todayPayments ?? 0, 2) }} DH</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">En attente</h5>
                <h2 class="mt-2 mb-0">{{ $pendingCount ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Table summary -->
<div class="card shadow mb-4">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Facture</th>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Aucun paiement pour le moment
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Historique -->
<div class="card shadow">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-credit-card text-primary me-2"></i>
                Historique des paiements
            </h5>

            <a href="{{ route('admin.payments.export') }}" class="btn btn-success btn-sm">
                <i class="fas fa-download me-1"></i> Exporter CSV
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Facture</th>
                        <th>Membre</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments ?? [] as $payment)
                    <tr>
                        <td class="fw-bold text-primary">
                            #{{ $payment->invoice_number ?? $payment->id }}
                        </td>

                        <td>
                            <div class="fw-bold">
                                {{ $payment->subscription->member->full_name ?? 'N/A' }}
                            </div>
                            <small class="text-muted">
                                {{ $payment->subscription->member->email ?? '' }}
                            </small>
                        </td>

                        <td class="fw-bold">
                            {{ number_format($payment->amount ?? 0, 2) }} DH
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ ucfirst($payment->payment_method ?? 'N/A') }}
                            </span>
                        </td>

                        <td>
                            {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}
                        </td>

                        <td>
                            @if($payment->status == 'completed')
                                <span class="badge bg-success">Payé</span>
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
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-credit-card fa-3x text-muted mb-3 d-block"></i>
                            <h5>Aucun paiement</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection