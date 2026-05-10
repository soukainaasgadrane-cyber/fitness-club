@extends('admin.layouts.app')

@section('title', 'Detail paiement')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Paiement #{{ $payment->invoice_number ?? $payment->id }}</h5>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <h6 class="mb-3">Membre</h6>
                    <p class="mb-1"><strong>Nom:</strong> {{ $payment->subscription->member->full_name ?? 'N/A' }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $payment->subscription->member->email ?? 'N/A' }}</p>
                    <p class="mb-0"><strong>Telephone:</strong> {{ $payment->subscription->member->phone ?? '-' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border rounded p-3 h-100">
                    <h6 class="mb-3">Paiement</h6>
                    <p class="mb-1"><strong>Montant facture:</strong> {{ number_format($payment->amount, 2) }} DH</p>
                    <p class="mb-1"><strong>Montant paye:</strong> {{ number_format($payment->total_paid, 2) }} DH</p>
                    <p class="mb-1"><strong>Methode:</strong> {{ $payment->payment_method_name }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</p>
                    <p class="mb-0"><strong>Statut:</strong> {{ $payment->status_name }}</p>
                </div>
            </div>
        </div>

        @if($payment->notes)
            <div class="border rounded p-3 mt-3">
                <h6 class="mb-2">Notes</h6>
                <p class="mb-0">{{ $payment->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
