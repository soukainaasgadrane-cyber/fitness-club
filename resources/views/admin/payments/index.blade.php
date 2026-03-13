{{-- resources/views/admin/payments/index.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Paiements')
@section('page-title', 'Gestion des paiements')

@section('content')
<div class="container-fluid">
    {{-- Filtres --}}
    <div class="filter-card">
        <form method="GET" class="row">
            <div class="col-md-2">
                <label class="form-label">Date début</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date fin</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Méthode</label>
                <select name="method" class="form-select">
                    <option value="all">Toutes</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                    <option value="card" {{ request('method') == 'card' ? 'selected' : '' }}>Carte</option>
                    <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>Virement</option>
                    <option value="check" {{ request('method') == 'check' ? 'selected' : '' }}>Chèque</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="all">Tous</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Complété</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Échoué</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" class="form-control" placeholder="Facture, nom..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block w-100">
                    <i class="fas fa-search"></i> Rechercher
                </button>
            </div>
        </form>
        
        {{-- Bouton export --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <a href="{{ route('admin.payments.export') }}?{{ http_build_query(request()->all()) }}" 
                   class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Exporter en CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Tableau des paiements --}}
    <div class="card">
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
                            <th>Enregistré par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
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
                                @elseif($payment->status == 'failed')
                                    <span class="badge bg-danger">Échoué</span>
                                @else
                                    <span class="badge bg-dark">Remboursé</span>
                                @endif
                            </td>
                            <td>{{ $payment->user->name }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}" 
                                   class="btn btn-sm btn-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($payment->status == 'completed')
                                <button type="button" class="btn btn-sm btn-danger" 
                                        title="Rembourser"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#refundModal{{ $payment->id }}">
                                    <i class="fas fa-undo"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        
                        {{-- Modal de remboursement --}}
                        <div class="modal fade" id="refundModal{{ $payment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.payments.refund', $payment) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rembourser le paiement</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Raison du remboursement</label>
                                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Confirmer le remboursement</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun paiement trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection