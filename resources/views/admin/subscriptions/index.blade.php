@extends('admin.layouts.app')

@section('title', 'Abonnements')
@section('page-title', 'Gestion des abonnements')

@section('content')
<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card text-center bg-primary text-white">
            <div class="stat-number">{{ $stats['active'] }}</div>
            <div class="stat-label">Actifs</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center bg-warning text-white">
            <div class="stat-number">{{ $stats['expired'] }}</div>
            <div class="stat-label">Expirés</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center bg-danger text-white">
            <div class="stat-number">{{ $stats['overdue'] }}</div>
            <div class="stat-label">En retard</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center bg-success text-white">
            <div class="stat-number">{{ number_format($stats['total_revenue'], 2) }} DH</div>
            <div class="stat-label">Chiffre d'affaires</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Liste des abonnements</h5>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouvel abonnement
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                #####
                    <th>Membre</th>
                    <th>Plan</th>
                    <th>Période</th>
                    <th>Montant</th>
                    <th>Statut paiement</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $sub->member->full_name }}</td>
                    <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                    <td>{{ $sub->start_date->format('d/m/Y') }} - {{ $sub->end_date->format('d/m/Y') }}</td>
                    <td>{{ number_format($sub->total_amount, 2) }} DH</td>
                    <td>
                        @if($sub->payment_status == 'paid')
                            <span class="badge bg-success">Payé</span>
                        @else
                            <span class="badge bg-danger">Non payé</span>
                        @endif
                    </td>
                    <td>
                        @if($sub->status == 'active')
                            <span class="badge bg-success">Actif</span>
                        @elseif($sub->status == 'expired')
                            <span class="badge bg-secondary">Expiré</span>
                        @else
                            <span class="badge bg-warning">En retard</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.subscriptions.show', $sub) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection