@extends('admin.layouts.app')

@section('title', 'Nouvel abonnement')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Nouvel abonnement</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.subscriptions.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Membre</label>
                    <select name="member_id" class="form-control" required>
                        <option value="">Sélectionner un membre</option>
                        <option value="1">Ahmed El Mansouri</option>
                        <option value="2">Fatima Alaoui</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Plan</label>
                    <select name="plan_id" class="form-control" required>
                        <option value="">Sélectionner un plan</option>
                        <option value="1">Basic - 300 DH</option>
                        <option value="2">Premium - 750 DH</option>
                        <option value="3">VIP - 2500 DH</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de début</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de fin</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prix (DH)</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Méthode de paiement</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash">Espèces</option>
                        <option value="card">Carte bancaire</option>
                        <option value="bank_transfer">Virement</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection