@extends('admin.layouts.app')

@section('title', 'Abonnements - GHITA')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-calendar-alt me-2"></i>
            Gestion des abonnements
        </h5>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i> Nouvel abonnement
        </a>
    </div>
    <div class="card-body">
        @if($subscriptions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Membre</th>
                            <th>Plan</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $sub)
                        <tr>
                            <td>#{{ $sub->id }}</td>
                            <td>
                                <strong>{{ $sub->member->full_name ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $sub->member->email ?? '' }}</small>
                            </td>
                            <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                            <td>{{ \Carbon\Carbon::parse($sub->start_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($sub->end_date)->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ number_format($sub->price, 2) }} DH</td>
                            <td>
                                @if($sub->payment_status == 'paid')
                                    <span class="badge bg-success">Payé</span>
                                @else
                                    <span class="badge bg-warning">En attente</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.subscriptions.show', $sub->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                <h5>Aucun abonnement trouvé</h5>
                <p class="text-muted">Commencez par créer votre premier abonnement.</p>
                <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Créer un abonnement
                </a>
            </div>
        @endif
    </div>
</div>
@endsection