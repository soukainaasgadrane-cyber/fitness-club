@extends('admin.layouts.app')

@section('title', 'Nouveau paiement')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white">
        <h5 class="mb-0">Enregistrer un paiement</h5>
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

        <form action="{{ route('admin.payments.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Abonnement</label>
                <select name="subscription_id" class="form-control" required>
                    <option value="">Selectionner</option>
                    @foreach($subscriptions as $sub)
                        <option value="{{ $sub->id }}" @selected(old('subscription_id') == $sub->id)>
                            #{{ $sub->id }} - {{ $sub->member->full_name ?? 'N/A' }} - {{ number_format($sub->total_amount ?? $sub->price, 2) }} DH
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Montant paye</label>
                    <input type="number" step="0.01" min="0" name="amount" class="form-control" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date paiement</label>
                    <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Methode de paiement</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash" @selected(old('payment_method') === 'cash')>Especes</option>
                        <option value="card" @selected(old('payment_method') === 'card')>Carte</option>
                        <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Virement</option>
                        <option value="check" @selected(old('payment_method') === 'check')>Cheque</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control" value="{{ old('notes') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
