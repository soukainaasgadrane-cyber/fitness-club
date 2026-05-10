@extends('admin.layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Total membres</h6>
                <h3 class="mb-0">{{ $totalMembers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Membres actifs</h6>
                <h3 class="mb-0">{{ $activeMembers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Abonnements actifs</h6>
                <h3 class="mb-0">{{ $activeSubscriptions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white shadow">
            <div class="card-body">
                <h6 class="text-white-50 mb-1">Nouveaux ce mois</h6>
                <h3 class="mb-0">{{ $newMembersThisMonth }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">Derniers membres</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers as $member)
                                <tr>
                                    <td>{{ $member->full_name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->phone ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">Aucun membre recent</td>
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
                <h5 class="mb-0">Derniers paiements</h5>
            </div>
            <div class="card-body p-0">
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
                            @forelse($recentPayments as $payment)
                                <tr>
                                    <td>#{{ $payment->invoice_number ?? $payment->id }}</td>
                                    <td>{{ $payment->subscription->member->full_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($payment->total_paid, 2) }} DH</td>
                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Aucun paiement recent</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">Abonnements expirant bientot (7 jours)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Membre</th>
                                <th>Plan</th>
                                <th>Date fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiringSoon as $sub)
                                <tr>
                                    <td>{{ $sub->member->full_name ?? 'N/A' }}</td>
                                    <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                                    <td>{{ $sub->end_date->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">Aucun abonnement proche expiration</td>
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
                <h5 class="mb-0">Actions rapides</h5>
            </div>
            <div class="card-body d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.members.index') }}" class="btn btn-primary">Membres</a>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-info">Abonnements</a>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-success">Paiements</a>
                <a href="{{ route('admin.finance.index') }}" class="btn btn-warning">Finance</a>
            </div>
        </div>
    </div>
</div>
@endsection
