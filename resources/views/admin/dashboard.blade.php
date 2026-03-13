@extends('admin.layouts.app')

@section('title', 'Accueil')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <!-- Cartes Statistiques -->
    <div class="row">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ $totalMembers }}</div>
                <div class="stat-label">Total des membres</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-check-circle" style="color: #28a745;"></i>
                </div>
                <div class="stat-number">{{ $activeSubscriptions }}</div>
                <div class="stat-label">Abonnements actifs</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle" style="color: #ffc107;"></i>
                </div>
                <div class="stat-number">{{ $expiringSoon->count() }}</div>
                <div class="stat-label">Expirent bientôt</div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="stat-icon">
                    <i class="fas fa-user-plus" style="color: #17a2b8;"></i>
                </div>
                <div class="stat-number">{{ $newMembersThisMonth }}</div>
                <div class="stat-label">Nouveaux ce mois</div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Membres récents -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Derniers membres inscrits</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date d'inscription</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMembers as $member)
                            <tr>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($member->activeSubscription)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Abonnements qui expirent bientôt -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Abonnements expirant bientôt</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Membre</th>
                                <th>Type d'abonnement</th>
                                <th>Date d'expiration</th>
                                <th>Jours restants</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringSoon as $subscription)
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
                                <td>{{ $subscription->end_date->format('Y-m-d') }}</td>
                                <td>
                                    <span class="badge bg-warning">
                                        {{ now()->diffInDays($subscription->end_date) }} jours
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Graphique des abonnements -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Répartition des abonnements</h5>
                </div>
                <div class="card-body">
                    <canvas id="subscriptionChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('subscriptionChart').getContext('2d');
    const subscriptionChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
                @foreach($subscriptionsByType as $type)
                    '{{ $type->plan_type == "monthly" ? "Mensuel" : ($type->plan_type == "quarterly" ? "Trimestriel" : "Annuel") }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($subscriptionsByType as $type)
                        {{ $type->count }},
                    @endforeach
                ],
                backgroundColor: [
                    '#667eea',
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection