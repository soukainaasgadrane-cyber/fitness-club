{{-- resources/views/admin/subscriptions/edit.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Modifier abonnement')
@section('page-title', 'Modifier l\'abonnement #' . $subscription->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Modifier les informations</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Membre (lecture seule) --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Membre</label>
                                <input type="text" class="form-control" value="{{ $subscription->member->full_name }}" readonly>
                            </div>
                            
                            {{-- Plan (lecture seule) --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Plan</label>
                                <input type="text" class="form-control" 
                                       value="{{ $subscription->plan->name ?? $subscription->plan_type }} - {{ $subscription->plan->duration_text ?? '' }}" readonly>
                            </div>
                            
                            {{-- Date de début --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date de début</label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date', $subscription->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Date de fin --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date de fin</label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date', $subscription->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Statut actif --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Statut</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="is_active" class="form-check-input" 
                                           value="1" {{ $subscription->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Abonnement actif</label>
                                </div>
                            </div>
                            
                            {{-- Prix total --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Prix total</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price" class="form-control @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $subscription->price) }}" required>
                                    <span class="input-group-text">MAD</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{-- Montant payé (lecture seule car géré par paiements) --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Montant payé</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ number_format($subscription->amount_paid, 2) }}" readonly>
                                    <span class="input-group-text">MAD</span>
                                </div>
                            </div>
                            
                            {{-- Reste à payer --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Reste à payer</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ number_format($subscription->remaining_amount, 2) }}" readonly>
                                    <span class="input-group-text">MAD</span>
                                </div>
                            </div>
                            
                            {{-- Notes --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3">{{ old('notes', $subscription->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-secondary">
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