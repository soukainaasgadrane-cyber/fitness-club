@extends('admin.layouts.app')

@section('title', 'Paiements - GHITA')
@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fas fa-credit-card me-2"></i>
            Gestion des paiements 
        </h5>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Page des paiements fonctionne!
        </div>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h3>0 DH</h3>
                        <small>Total encaissé</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h3>0 DH</h3>
                        <small>Aujourd'hui</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h3>0</h3>
                        <small>En attente</small>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                    <th>Facture</th>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Date</th>
                    <th>Statut</th>
                 </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Aucun paiement pour le moment
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection