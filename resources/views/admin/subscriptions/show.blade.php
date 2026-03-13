{{-- resources/views/admin/subscriptions/show.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Détails de l\'abonnement')
@section('page-title', 'Détails de l\'abonnement #' . $subscription->id)

@section('content')
<div class="container-fluid">
    {{-- En-tête avec actions --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Abonnement de : <strong>{{ $subscription->member->full_name }}</strong></h5>
                        <small class="text-muted">Créé le {{ $subscription->created_at->format('d/m/Y') }}</small>
                    </div>
                    <div>
                        <a href="{{ route('admin.subscriptions.edit', $subscription) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-money-bill"></i> Ajouter paiement
                        </button>
                        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Colonne de gauche : Infos abonnement --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Membre :</th>
                            <td>
                                <strong>{{ $subscription->member->full_name }}</strong><br>
                                <small>{{ $subscription->member->email }} | {{ $subscription->member->phone ?? 'Tél non disponible' }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Plan :</th>
                            <td>
                                <strong>{{ $subscription->plan->name ?? $subscription->plan_type }}</strong><br>
                                <small>{{ $subscription->plan->duration_text ?? '' }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Période :</th>
                            <td>
                                Du <strong>{{ $subscription->start_date->format('d/m/Y') }}</strong> 
                                au <strong>{{ $subscription->end_date->format('d/m/Y') }}</strong>
                                @if($subscription->end_date < now())
                                    <span class="badge bg-danger ms-2">Expiré</span>
                                @else
                                    <span class="badge bg-success ms-2">Actif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Statut :</th>
                            <td>
                                @if($subscription->is_active)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if($subscription->notes)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Notes</h5>
                </div>
                <div class="card-body">
                    {{ $subscription->notes }}
                </div>
            </div>
            @endif
        </div>

        {{-- Colonne de droite : Informations financières --}}
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Résumé financier</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Prix total :</th>
                            <td class="text-end"><strong>{{ number_format($subscription->price, 2) }} MAD</strong></td>
                        </tr>
                        <tr>
                            <th>Montant payé :</th>
                            <td class="text-end text-success">{{ number_format($subscription->amount_paid, 2) }} MAD</td>
                        </tr>
                        <tr>
                            <th>Reste à payer :</th>
                            <td class="text-end text-danger">{{ number_format($subscription->remaining_amount, 2) }} MAD</td>
                        </tr>
                        <tr>
                            <th>Statut paiement :</th>
                            <td class="text-end">
                                @if($subscription->payment_status == 'paid')
                                    <span class="badge bg-success">Payé</span>
                                @elseif($subscription->payment_status == 'partial')
                                    <span class="badge bg-warning">Paiement partiel</span>
                                @else
                                    <span class="badge bg-danger">Impayé</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Historique des paiements --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Historique des paiements</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Facture</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    <th>Enregistré par</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscription->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_number }}</td>
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
                                    <td>{{ $payment->user->name }}</td>
                                    <td>
                                        @if($payment->status == 'completed')
                                            <span class="badge bg-success">Complété</span>
                                        @elseif($payment->status == 'refunded')
                                            <span class="badge bg-dark">Remboursé</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.payments.show', $payment) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun paiement enregistré</td>
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

{{-- Modal pour ajouter un paiement --}}
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.subscriptions.payment', $subscription) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un paiement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Montant (max: {{ number_format($subscription->remaining_amount, 2) }} MAD)</label>
                        <input type="number" step="0.01" name="amount" class="form-control" 
                               max="{{ $subscription->remaining_amount }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Méthode de paiement</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="cash">Espèces</option>
                            <option value="card">Carte bancaire</option>
                            <option value="bank_transfer">Virement</option>
                            <option value="check">Chèque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection