@extends('admin.layouts.app')

@section('title', 'Détails abonnement')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fas fa-eye me-2"></i>
            Détails de l'abonnement #{{ $subscription->id }}
        </h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Membre:</label>
                    <p class="fs-5">{{ $subscription->member->full_name ?? 'N/A' }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Email:</label>
                    <p>{{ $subscription->member->email ?? 'N/A' }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Téléphone:</label>
                    <p>{{ $subscription->member->phone ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Plan:</label>
                    <p class="fs-5">{{ $subscription->plan->name ?? $subscription->plan_type }}</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Prix:</label>
                    <p>{{ number_format($subscription->price, 2) }} DH</p>
                </div>
                <div class="info-box">
                    <label class="fw-bold text-muted">Méthode de paiement:</label>
                    <p>{{ $subscription->payment_method ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
        
        <hr>
        
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Date de début:</label>
                    <p>{{ \Carbon\Carbon::parse($subscription->start_date)->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Date de fin:</label>
                    <p>{{ \Carbon\Carbon::parse($subscription->end_date)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Statut paiement:</label>
                    <p>
                        @if($subscription->payment_status == 'paid')
                            <span class="badge bg-success">Payé</span>
                        @else
                            <span class="badge bg-warning">En attente</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <label class="fw-bold text-muted">Statut abonnement:</label>
                    <p>
                        @if($subscription->is_active && $subscription->end_date >= now())
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-secondary">Expiré</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        @if($subscription->notes)
        <div class="info-box">
            <label class="fw-bold text-muted">Notes:</label>
            <p>{{ $subscription->notes }}</p>
        </div>
        @endif
        
        <hr>
        
        <div class="mt-3">
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
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