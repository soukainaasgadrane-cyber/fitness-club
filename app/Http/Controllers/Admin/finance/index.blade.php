{{-- resources/views/admin/finance/index.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Dashboard financier')
@section('page-title', 'Tableau de bord financier')

@section('content')
<div class="container-fluid">
    
    {{-- ======================================== --}}
    {{==    1. CARTES DE STATISTIQUES (8)       ==}}
    {{-- ======================================== --}}
    <div class="row">
        {{-- Carte 1: Revenus aujourd'hui --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($stats['today_revenue'], 2) }} MAD</div>
                        <div class="stat-label">Revenus aujourd'hui</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 2: Revenus ce mois --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($stats['month_revenue'], 2) }} MAD</div>
                        <div class="stat-label">Revenus ce mois</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 3: Revenus cette année --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($stats['year_revenue'], 2) }} MAD</div>
                        <div class="stat-label">Revenus cette année</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 4: Paiements en attente --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['pending_payments'] }}</div>
                        <div class="stat-label">Paiements en attente</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Deuxième ligne de statistiques --}}
    <div class="row mt-4">
        {{-- Carte 5: Abonnements actifs --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['active_subscriptions'] }}</div>
                        <div class="stat-label">Abonnements actifs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 6: Abonnements expirés --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['expired_subscriptions'] }}</div>
                        <div class="stat-label">Abonnements expirés</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 7: Paiements aujourd'hui --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['payments_today'] }}</div>
                        <div class="stat-label">Paiements aujourd'hui</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 8: Moyenne par abonnement --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($stats['avg_subscription'], 2) }} MAD</div>
                        <div class="stat-label">Moyenne/abonnement</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================== --}}
    {{==    2. GRAPHIQUES ET ANALYSES           ==}}
    {{-- ======================================== --}}
    <div class="row mt-4">
        {{-- Graphique des revenus mensuels --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Évolution des revenus mensuels</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        
        {{-- Répartition des méthodes de paiement --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Méthodes de paiement</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentMethodsChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================== --}}
    {{==    3. TOP MEMBRES                       ==}}
    {{-- ======================================== --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Top 5 membres (par montant payé)</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($topMembers as $member)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $member->full_name }}</strong><br>
                                <small>{{ $member->email }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                {{ number_format($member->total_paid, 2) }} MAD
                            </span>
                        </div>
                        @empty
                        <p class="text-center">Aucune donnée</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================== --}}
        {{==    4. DERNIERS PAIEMENTS               ==}}
        {{-- ======================================== --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Derniers paiements</h5>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-primary">
                        Voir tout <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Facture</th>
                                    <th>Membre</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPayments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_number }}</td>
                                    <td>{{ $payment->member->full_name }}</td>
                                    <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} MAD</td>
                                    <td>
                                        @if($payment->payment_method == 'cash')
                                            <span class="badge bg-info">Espèces</span>
                                        @elseif($payment->payment_method == 'card')
                                            <span class="badge bg-primary">Carte</span>
                                        @elseif($payment->payment_method == 'bank_transfer')
                                            <span class="badge bg-secondary">Virement</span>
                                        @else
                                            <span class="badge bg-warning">Chèque</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->status == 'completed')
                                            <span class="badge bg-success">Complété</span>
                                        @elseif($payment->status == 'pending')
                                            <span class="badge bg-warning">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucun paiement récent</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================== --}}
    {{==    5. ABONNEMENTS QUI VONT EXPIRE       ==}}
    {{-- ======================================== --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Abonnements expirant dans 7 jours</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Plan</th>
                                    <th>Date fin</th>
                                    <th>Jours restants</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expiringSoon as $sub)
                                <tr>
                                    <td>{{ $sub->member->full_name }}</td>
                                    <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                                    <td>{{ $sub->end_date->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $daysLeft = now()->diffInDays($sub->end_date);
                                        @endphp
                                        <span class="badge bg-warning">{{ $daysLeft }} jours</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.subscriptions.show', $sub) }}" 
                                           class="btn btn-sm btn-primary">
                                            Renouveler
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Aucun abonnement proche d'expirer</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique des revenus mensuels
    const ctx1 = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Revenus (MAD)',
                data: {!! json_encode($monthlyRevenue) !!},
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Graphique des méthodes de paiement
    const ctx2 = document.getElementById('paymentMethodsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Espèces', 'Carte', 'Virement', 'Chèque'],
            datasets: [{
                data: [
                    {{ $paymentMethods['cash'] }},
                    {{ $paymentMethods['card'] }},
                    {{ $paymentMethods['bank_transfer'] }},
                    {{ $paymentMethods['check'] }}
                ],
                backgroundColor: ['#43e97b', '#4facfe', '#fa709a', '#ff9a9e']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection