@extends('admin.layouts.app')


@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')

@section('content')
<!-- ========== SECTION SOUKAINA ========== -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white shadow">
            <div class="card-body">
                <h4 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Gestion des membres 
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total membres</h6>
                        <h3 class="mb-0">{{ $totalMembers }}</h3>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>

@section('title', 'Tableau de bord Admin')
@section('page-title', 'Tableau de bord Administration')

@section('content')
<div class="container-fluid">
    <!-- Cartes des statistiques -->
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalMembers ?? 0 }}</div>
                <div class="stat-label">Total des membres</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                </div>
                <div class="stat-number">{{ $activeSubscriptions ?? 0 }}</div>
                <div class="stat-label">Abonnements actifs</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
                </div>
                <div class="stat-number">{{ $expiringSoon->count() ?? 0 }}</div>
                <div class="stat-label">Expire bientôt</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-user-plus" style="color: #17a2b8;"></i>
                </div>
                <div class="stat-number">{{ $newMembersThisMonth ?? 0 }}</div>
                <div class="stat-label">Nouveaux ce mois</div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <!-- Derniers membres -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Derniers membres inscrits</h5>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Membres actifs</h6>
                        <h3 class="mb-0">{{ $activeMembers }}</h3>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Nouveaux ce mois</h6>
                        <h3 class="mb-0">{{ $newMembersThisMonth }}</h3>
                    </div>
                    <i class="fas fa-user-plus fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-clock text-primary me-2"></i>
                    Derniers membres inscrits
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>

                                <th>Téléphone</th>
                                <th>Date</th>

                                <th>Statut</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers ?? [] as $member)
                            <tr>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>

                                <td>{{ $member->phone ?? '-' }}</td>
                                <td>{{ $member->created_at->format('d/m/Y') }}</td>

                                <td>
                                    @if($member->activeSubscription)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucun membre</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Abonnements qui expirent bientôt -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Abonnements expirant bientôt</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Membre</th>
                                <th>Type</th>
                                <th>Date d'expiration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiringSoon ?? [] as $subscription)
                            <tr>
                                <td>{{ $subscription->member->full_name }}</td>
                                <td>
                                    @if($subscription->plan_type == 'monthly')
                                        Mensuel
                                    @elseif($subscription->plan_type == 'quarterly')
                                        Trimestriel
                                    @else
                                        Annuel
                                    @endif
                                </td>
                                <td>{{ $subscription->end_date->format('d/m/Y') }}</td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucun abonnement expirant</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line text-primary me-2"></i>
                    Actions rapides - Soukaina
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.members.index') }}" class="btn btn-primary">
                        <i class="fas fa-users me-2"></i> Gérer les membres
                    </a>
                    <a href="{{ route('admin.members.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-2"></i> Ajouter un membre
    <!-- Actions rapides -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Ajouter un membre
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="btn btn-info">
                        <i class="fas fa-list"></i> Voir tous les membres

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ========== SECTION GHITA ========== -->
<div class="row mb-4 mt-4">
    <div class="col-12">
        <div class="card bg-gradient-success text-white shadow">
            <div class="card-body">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Finance & Ventes 
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Abonnements actifs</h6>
                        <h3 class="mb-0">{{ $activeSubscriptions }}</h3>
                    </div>
                    <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">En attente</h6>
                        <h3 class="mb-0">{{ $pendingSubscriptions }}</h3>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Expirés</h6>
                        <h3 class="mb-0">{{ $expiredSubscriptions }}</h3>
                    </div>
                    <i class="fas fa-calendar-times fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total abonnements</h6>
                        <h3 class="mb-0">{{ $totalSubscriptions }}</h3>
                    </div>
                    <i class="fas fa-list fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Revenu total</h6>
                        <h3 class="mb-0">{{ number_format($totalRevenue, 2) }} DH</h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Ce mois</h6>
                        <h3 class="mb-0">{{ number_format($monthRevenue, 2) }} DH</h3>
                    </div>
                    <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Aujourd'hui</h6>
                        <h3 class="mb-0">{{ number_format($todayRevenue, 2) }} DH</h3>
                    </div>
                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Abonnements expirant bientôt (7 jours)
                </h5>
            </div>
            <div class="card-body p-0">
                @if($expiringSoon->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Membre</th>
                                    <th>Plan</th>
                                    <th>Date fin</th>
                                    <th>Jours restants</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiringSoon as $sub)
                                <tr>
                                    <td>{{ $sub->member->full_name ?? 'N/A' }}</td>
                                    <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-warning">
                                            {{ now()->diffInDays($sub->end_date) }} jours
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Aucun abonnement expirant bientôt</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-credit-card text-primary me-2"></i>
                    Derniers paiements
                </h5>
            </div>
            <div class="card-body p-0">
                @if($recentPayments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Facture</th>
                                    <th>Membre</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                <tr>
                                    <td>#{{ $payment->invoice_number ?? $payment->id }}</td>
                                    <td>{{ $payment->subscription->member->full_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} DH</td>
                                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Aucun paiement récent</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Actions rapides - Ghita
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Nouvel abonnement
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-info">
                        <i class="fas fa-list me-2"></i> Voir abonnements
                    </a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-success">
                        <i class="fas fa-credit-card me-2"></i> Voir paiements
                    </a>
                    <a href="{{ route('admin.payments.export') }}" class="btn btn-secondary">
                        <i class="fas fa-download me-2"></i> Exporter CSV
                    </a>
                    <a href="{{ route('admin.finance.index') }}" class="btn btn-warning">
                        <i class="fas fa-chart-line me-2"></i> Dashboard Finance
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .opacity-50 {
        opacity: 0.5;
    }
</style>


@endsection