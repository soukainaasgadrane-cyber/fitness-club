@extends('admin.layouts.app')

@section('title', 'Abonnements - GHITA')
@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">Total Abonnements</h5>
                <h2 class="mt-2 mb-0">{{ $totalSubscriptions ?? 0 }}</h2>
                <small>Actifs: {{ $activeSubscriptions ?? 0 }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">Revenu Total</h5>
                <h2 class="mt-2 mb-0">{{ number_format($totalRevenue ?? 0, 2) }} DH</h2>
                <small>Ce mois: {{ number_format($monthRevenue ?? 0, 2) }} DH</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">En attente</h5>
                <h2 class="mt-2 mb-0">{{ $pendingPayments ?? 0 }}</h2>
                <small>Paiements non réglés</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h5 class="mb-0">Expirés</h5>
                <h2 class="mt-2 mb-0">{{ $expiredSubscriptions ?? 0 }}</h2>
                <small>Abonnements terminés</small>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt text-primary me-2"></i>
                Liste des abonnements
            </h5>
            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i> Nouvel abonnement
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Membre</th>
                        <th>Plan</th>
                        <th>Période</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions ?? [] as $sub)
                    <tr>
                        <td>#{{ $sub->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $sub->member->full_name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $sub->member->email ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $sub->plan->name ?? $sub->plan_type ?? 'Basic' }}</span>
                        </td>
                        <td>
                            <small>{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</small><br>
                            <small class="text-muted">→ {{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</small>
                        </td>
                        <td class="fw-bold">{{ number_format($sub->total_amount ?? $sub->price, 2) }} DH</td>
                        <td>
                            @if($sub->payment_status == 'paid')
                                <span class="badge bg-success">Payé</span>
                            @else
                                <span class="badge bg-warning">En attente</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.subscriptions.show', $sub) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3 d-block"></i>
                            <h5>Aucun abonnement</h5>
                            <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary mt-2">
                                Créer le premier abonnement
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection