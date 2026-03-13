{{-- resources/views/admin/subscriptions/create.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Nouvel abonnement')
@section('page-title', 'Créer un nouvel abonnement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informations de l'abonnement</h5>
                </div>
                <div class="card-body">
                    {{-- Formulaire --}}
                    <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            {{-- Sélection du membre --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Membre <span class="text-danger">*</span></label>
                                <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner un membre</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                            {{ $member->full_name }} ({{ $member->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Sélection du plan --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plan d'abonnement <span class="text-danger">*</span></label>
                                <select name="plan_id" id="plan_id" class="form-select @error('plan_id') is-invalid @enderror" required>
                                    <option value="">Sélectionner un plan</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" 
                                            data-price="{{ $plan->price }}"
                                            data-duration="{{ $plan->duration_months }}"
                                            {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - {{ $plan->duration_text }} ({{ number_format($plan->price, 2) }} MAD)
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Date de début --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date de début <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date', date('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Date de fin (calculée automatiquement) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date de fin</label>
                                <input type="date" id="end_date" class="form-control" readonly>
                                <small class="text-muted">Calculée automatiquement</small>
                            </div>
                            
                            {{-- Prix total --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Prix total</label>
                                <input type="text" id="total_price" class="form-control" readonly>
                                <small class="text-muted">Basé sur le plan choisi</small>
                            </div>
                            
                            {{-- Montant payé --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Montant payé <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="amount_paid" 
                                           id="amount_paid" class="form-control @error('amount_paid') is-invalid @enderror" 
                                           value="{{ old('amount_paid', 0) }}" required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Méthode de paiement --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Méthode de paiement <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                    <option value="">Sélectionner</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement</option>
                                    <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Chèque</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Reste à payer --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Reste à payer</label>
                                <div class="input-group">
                                    <input type="text" id="remaining_amount" class="form-control" readonly>
                                    <span class="input-group-text">MAD</span>
                                </div>
                            </div>
                            
                            {{-- Notes --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        {{-- Boutons --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer
                            </button>
                            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const planSelect = document.getElementById('plan_id');
        const startDateInput = document.querySelector('input[name="start_date"]');
        const endDateInput = document.getElementById('end_date');
        const totalPriceInput = document.getElementById('total_price');
        const amountPaidInput = document.getElementById('amount_paid');
        const remainingAmountInput = document.getElementById('remaining_amount');
        
        // Fonction pour calculer la date de fin
        function calculateEndDate() {
            const selectedOption = planSelect.options[planSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const duration = parseInt(selectedOption.dataset.duration) || 0;
                const startDate = new Date(startDateInput.value);
                
                if (startDate && duration) {
                    const endDate = new Date(startDate);
                    endDate.setMonth(endDate.getMonth() + duration);
                    
                    // Format YYYY-MM-DD
                    const year = endDate.getFullYear();
                    const month = String(endDate.getMonth() + 1).padStart(2, '0');
                    const day = String(endDate.getDate()).padStart(2, '0');
                    endDateInput.value = `${year}-${month}-${day}`;
                }
            }
        }
        
        // Fonction pour mettre à jour les prix
        function updatePrices() {
            const selectedOption = planSelect.options[planSelect.selectedIndex];
            if (selectedOption && selectedOption.value) {
                const price = parseFloat(selectedOption.dataset.price) || 0;
                totalPriceInput.value = price.toFixed(2) + ' MAD';
                
                const amountPaid = parseFloat(amountPaidInput.value) || 0;
                const remaining = price - amountPaid;
                remainingAmountInput.value = remaining.toFixed(2);
            }
        }
        
        // Événements
        planSelect.addEventListener('change', function() {
            calculateEndDate();
            updatePrices();
        });
        
        startDateInput.addEventListener('change', calculateEndDate);
        amountPaidInput.addEventListener('input', updatePrices);
        
        // Calcul initial si des valeurs sont pré-sélectionnées
        if (planSelect.value) {
            calculateEndDate();
            updatePrices();
        }
    });
</script>
@endsection