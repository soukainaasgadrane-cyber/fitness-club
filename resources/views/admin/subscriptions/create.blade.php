@extends('admin.layouts.app')

@section('title', 'Nouvel abonnement')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Nouvel abonnement</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.subscriptions.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Membre</label>
                    <select name="member_id" class="form-control" required>
                        <option value="">Sélectionner un membre</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                                {{ $member->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Plan</label>
                    <select name="plan_id" class="form-control" required>
                        <option value="">Sélectionner un plan</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                                {{ $plan->name }} - {{ number_format($plan->current_price, 2) }} DH
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de début</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de fin</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prix (DH)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Méthode de paiement</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash" @selected(old('payment_method') === 'cash')>Espèces</option>
                        <option value="card" @selected(old('payment_method') === 'card')>Carte bancaire</option>
                        <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Virement</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection