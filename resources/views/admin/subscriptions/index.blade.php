{{-- 
    Vue : admin/subscriptions/index.blade.php
    Description : Page de gestion des abonnements
    Utilise le layout : admin/layouts/finance.blade.php
--}}

@extends('admin.layouts.finance')

@section('title', 'Abonnements')
@section('page-title', 'Gestion des abonnements')

@section('content')
<div class="container-fluid">
    
    {{-- ======================================== --}}
    {{==  CARTES DE STATISTIQUES (4 au total)   ==}}
    {{-- ======================================== --}}
    <div class="row">
        {{-- Carte 1: Abonnements actifs --}}
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['active'] }}</div>
                        <div class="stat-label">Abonnements actifs</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 2: Abonnements expirés --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ $stats['expired'] }}</div>
                        <div class="stat-label">Expirés</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Carte 3: Revenu total --}}
        <div class="col-md-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-number">{{ number_format($stats['total_revenue'], 2) }} MAD</div>
                        <div class="stat-label">Revenu total</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-coins"></i>
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

    {{-- ======================================== --}}
    {{==        FILTRES DE RECHERCHE            ==}}
    {{-- ======================================== --}}
    <div class="filter-card">
        <form method="GET" class="row">
            {{-- Filtre par statut --}}
            <div class="col-md-3">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expiré</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                </select>
            </div>
            
            {{-- Filtre par type d'abonnement --}}
            <div class="col-md-3">
                <label class="form-label">Type d'abonnement</label>
                <select name="plan_type" class="form-select">
                    <option value="all">Tous</option>
                    <option value="monthly" {{ request('plan_type') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                    <option value="quarterly" {{ request('plan_type') == 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                    <option value="yearly" {{ request('plan_type') == 'yearly' ? 'selected' : '' }}>Annuel</option>
                </select>
            </div>
            
            {{-- Bouton de filtrage --}}
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
            </div>
            
            {{-- Bouton pour nouvel abonnement --}}
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-success d-block w-100">
                    <i class="fas fa-plus"></i> Nouvel abonnement
                </a>
            </div>
        </form>
    </div>

    {{-- ======================================== --}}
    {{==     TABLEAU DES ABONNEMENTS            ==}}
    {{-- ======================================== --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    {{-- En-têtes du tableau --}}
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Membre</th>
                            <th>Plan</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Montant</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Statut paiement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    {{-- Corps du tableau --}}
                    <tbody>
                        {{-- @forelse : boucle avec cas "vide" --}}
                        @forelse($subscriptions as $sub)
                        <tr>
                            {{-- ID --}}
                            <td>{{ $sub->id }}</td>
                            
                            {{-- Nom du membre (relation) --}}
                            <td>{{ $sub->member->full_name }}</td>
                            
                            {{-- Plan d'abonnement --}}
                            <td>
                                {{ $sub->plan->name ?? $sub->plan_type }}
                                <small class="text-muted d-block">{{ $sub->plan->duration_text ?? '' }}</small>
                            </td>
                            
                            {{-- Date de début --}}
                            <td>{{ $sub->start_date->format('Y-m-d') }}</td>
                            
                            {{-- Date de fin + badge si expiré --}}
                            <td>
                                {{ $sub->end_date->format('Y-m-d') }}
                                @if($sub->end_date < now())
                                    <span class="badge bg-danger">Expiré</span>
                                @endif
                            </td>
                            
                            {{-- Montant total --}}
                            <td>{{ number_format($sub->price, 2) }} MAD</td>
                            
                            {{-- Montant payé --}}
                            <td>{{ number_format($sub->amount_paid, 2) }} MAD</td>
                            
                            {{-- Reste à payer --}}
                            <td>{{ number_format($sub->remaining_amount, 2) }} MAD</td>
                            
                            {{-- Statut du paiement avec badge coloré --}}
                            <td>
                                @if($sub->payment_status == 'paid')
                                    <span class="badge bg-success">Payé</span>
                                @elseif($sub->payment_status == 'partial')
                                    <span class="badge bg-warning">Partiel</span>
                                @else
                                    <span class="badge bg-danger">Impayé</span>
                                @endif
                            </td>
                            
                            {{-- Boutons d'action --}}
                            <td>
                                <div class="btn-group" role="group">
                                    {{-- Voir détails --}}
                                    <a href="{{ route('admin.subscriptions.show', $sub) }}" 
                                       class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.subscriptions.edit', $sub) }}" 
                                       class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    {{-- Ajouter paiement --}}
                                    <button type="button" 
                                            class="btn btn-sm btn-success" 
                                            title="Ajouter paiement"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#paymentModal{{ $sub->id }}">
                                        <i class="fas fa-money-bill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        {{-- Si la liste est vide --}}
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                Aucun abonnement trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ======================================== --}}
            {{==        PAGINATION                       ==}}
            {{-- ======================================== --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $subscriptions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection