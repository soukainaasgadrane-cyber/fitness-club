@extends('admin.layouts.app')

@section('title', 'Detail membre')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Membre #{{ $member->id }}</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>Nom:</strong> {{ $member->full_name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $member->email }}</p>
                <p class="mb-1"><strong>Telephone:</strong> {{ $member->phone ?? '-' }}</p>
                <p class="mb-1"><strong>Date naissance:</strong> {{ $member->birth_date ? $member->birth_date->format('d/m/Y') : '-' }}</p>
                <p class="mb-0"><strong>Genre:</strong> {{ $member->gender ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>Adresse:</strong> {{ $member->address ?? '-' }}</p>
                <p class="mb-1"><strong>Contact urgence:</strong> {{ $member->emergency_contact ?? '-' }}</p>
                <p class="mb-1"><strong>Statut:</strong>
                    @if($member->is_active)
                        <span class="badge bg-success">Actif</span>
                    @else
                        <span class="badge bg-secondary">Inactif</span>
                    @endif
                </p>
                <p class="mb-0"><strong>Notes medicales:</strong> {{ $member->medical_notes ?? '-' }}</p>
            </div>
        </div>

        <hr>

        <h6>Abonnements</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Plan</th>
                        <th>Debut</th>
                        <th>Fin</th>
                        <th>Statut paiement</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($member->subscriptions as $sub)
                        <tr>
                            <td>{{ $sub->plan->name ?? $sub->plan_type }}</td>
                            <td>{{ $sub->start_date ? $sub->start_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $sub->end_date ? $sub->end_date->format('d/m/Y') : '-' }}</td>
                            <td>{{ $sub->payment_status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Aucun abonnement</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
