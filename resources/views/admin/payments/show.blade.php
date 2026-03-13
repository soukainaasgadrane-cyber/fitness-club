{{-- resources/views/admin/payments/show.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Détails du paiement')
@section('page-title', 'Paiement #' . $payment->payment_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reçu de paiement</h5>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
                <div class="card-body">
                    {{-- En-tête du reçu --}}
                    <div class="text-center mb-4">
                        <h2>FITNESS CLUB</h2>
                        <p class="text-muted">Reçu de paiement</p>
                    </div>
                    
                    {{-- Informations du reçu --}}
                    <div class="row mb-4">
                        <div class="col-6">
                            <strong>Numéro facture :</strong><br>
                            <h4>{{ $payment->payment_number }}</h4>
                        </div>
                        <div class="col-6 text-end">
                            <strong>Date :</strong><br>
                            {{ $payment->payment_date->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    
                    {{-- Informations membre --}}
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6>Informations membre</h6>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Nom :</strong> {{ $payment->member->full_name }}<br>
                                    <strong>Email :</strong> {{ $payment->member->email }}
                                </div>
                                <div class="col-6">
                                    <strong>Téléphone :</strong> {{ $payment->member->phone ?? '-' }}<br>
                                    <strong>Membre depuis :</strong> {{ $payment->member->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Détails paiement --}}
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Paiement pour abonnement<br>
                                    <small class="text-muted">
                                        {{ $payment->subscription->plan->name ?? $payment->subscription->plan_type }} - 
                                        Du {{ $payment->subscription->start_date->format('d/m/Y') }} au {{ $payment->subscription->end_date->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td class="text-end">{{ number_format($payment->amount, 2) }} MAD</td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-end">
                                    Total : <strong>{{ number_format($payment->amount, 2) }} MAD</strong>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    
                    {{-- Méthode de paiement --}}
                    <div class="row mt-4">
                        <div class="col-6">
                            <strong>Méthode de paiement :</strong><br>
                            <span class="badge bg-info">{{ $payment->payment_method_text }}</span>
                        </div>
                        <div class="col-6">
                            <strong>Statut :</strong><br>
                            @if($payment->status == 'completed')
                                <span class="badge bg-success">{{ $payment->status_text }}</span>
                            @elseif($payment->status == 'refunded')
                                <span class="badge bg-dark">{{ $payment->status_text }}</span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Notes --}}
                    @if($payment->notes)
                    <div class="mt-4">
                        <strong>Notes :</strong>
                        <p class="text-muted">{{ $payment->notes }}</p>
                    </div>
                    @endif
                    
                    {{-- Enregistré par --}}
                    <div class="mt-4 text-muted small">
                        Enregistré par : {{ $payment->user->name }} ({{ $payment->created_at->format('d/m/Y H:i') }})
                    </div>
                    
                    {{-- Boutons d'action --}}
                    <div class="text-center mt-4">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print"></i> Imprimer
                        </button>
                        @if($payment->status == 'completed')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#refundModal">
                            <i class="fas fa-undo"></i> Rembourser
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal de remboursement --}}
@if($payment->status == 'completed')
<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.payments.refund', $payment) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Rembourser le paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        Attention ! Cette action est irréversible.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Raison du remboursement</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le remboursement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@section('styles')
<style>
    @media print {
        .btn, .modal, .card-header, footer, nav {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection