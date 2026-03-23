@extends('admin.layouts.app')

@section('title', 'Paiements - Ghita')
@section('content')
<div class="card">
    <div class="card-header">
        <h5>Gestion des paiements </h5>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Page des paiements - fonctionne!
        </div>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                
                    <th>ID</th>
                    <th>Facture</th>
                    <th>Membre</th>
                    <th>Montant</th>
                    <th>Méthode</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                 </thead>
            <tbody>
                 <tr>
                    <td colspan="8" class="text-center text-muted">
                        ⚡ Aucun paiement pour le moment
                     </td>
                 </tr>
            </tbody>
         </table>
    </div>
</div>
@endsection