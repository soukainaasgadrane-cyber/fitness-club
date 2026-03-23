@extends('admin.layouts.app')

@section('title', 'Abonnements - Ghita')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Gestion des abonnements - soukaina ✅</h5>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
            + Nouvel abonnement
        </a>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Page des abonnements - soukaina fonctionne!
        </div>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Membre</th>
                    <th>Plan</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Prix</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        ⚡ Aucun abonnement pour le moment
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection