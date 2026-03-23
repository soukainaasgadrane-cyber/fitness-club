@extends('admin.layouts.app')

@section('title', 'Paiements - Ghita')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Gestion des paiements - soukaina ✅</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Page des paiements - soukaina fonctionne!
        </div>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Facture</th>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        ⚡ Aucun paiement pour le moment
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection