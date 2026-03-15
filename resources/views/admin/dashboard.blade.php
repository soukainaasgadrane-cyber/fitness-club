@extends('admin.layouts.app')

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
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers ?? [] as $member)
                            <tr>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>
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
@endsection