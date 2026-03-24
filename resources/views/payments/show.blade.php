@extends('admin.layouts.app')

@section('title', 'Détails paiement')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-eye me-2"></i>
            Détails du paiement #{{ $payment->invoice_number ?? $payment->id }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Facture N°:</label>
                    <p class="fs-5">{{ $payment->invoice_number ?? $payment->id }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Membre:</label>
                    <p>{{ $payment->subscription->member->full_name ?? 'N/A' }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Email:</label>
                    <p>{{ $payment->subscription->member->email ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Montant:</label>
                    <p class="fs-5">{{ number_format($payment->amount, 2) }} DH</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Méthode de paiement:</label>
                    <p>{{ ucfirst($payment->payment_method) }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Date de paiement:</label>
                    <p>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Statut:</label>
                    <p>
                        @if($payment->status == 'completed')
                            <span class="badge bg-success">Payé</span>
                        @elseif($payment->status == 'pending')
                            <span class="badge bg-warning">En attente</span>
                        @else
                            <span class="badge bg-danger">{{ $payment->status }}</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Transaction ID:</label>
                    <p>{{ $payment->transaction_id ?? '-' }}</p>
                </div>
            </div>
        </div>
        
        @if($payment->notes)
        <div class="info-box">
            <label class="fw-bold text-muted">Notes:</label>
            <p>{{ $payment->notes }}</p>
        </div>
        @endif
        
        <hr>
        
        <div class="mt-3">
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>
    </div>
</div>

<style>
    .info-box {
        margin-bottom: 20px;
    }
    .info-box label {
        font-size: 0.85rem;
        margin-bottom: 5px;
    }
    .info-box p {
        margin-bottom: 0;
        font-weight: 500;
    }
</style>
@endsection