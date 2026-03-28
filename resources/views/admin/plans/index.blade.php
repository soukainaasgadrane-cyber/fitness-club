@extends('admin.layouts.app')

@section('title', 'Plans d\'abonnement')
@section('page-title', 'Gestion des plans')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Liste des plans d'abonnement</h5>
        <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau plan
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($plans as $plan)
            <div class="col-md-4 mb-4">
                <div class="card h-100 {{ $plan->is_active ? 'border-primary' : 'border-secondary' }}">
                    <div class="card-header text-center">
                        <h4>{{ $plan->name }}</h4>
                        <div class="price">
                            <span class="h2">{{ number_format($plan->current_price, 2) }} DH</span>
                            @if($plan->discount_price)
                                <small class="text-muted"><del>{{ number_format($plan->price, 2) }} DH</del></small>
                            @endif
                        </div>
                        <small>{{ $plan->duration_months }} mois</small>
                    </div>
                    <div class="card-body">
                        <p>{{ $plan->description }}</p>
                        <ul class="list-unstyled">
                            @foreach($plan->features ?? [] as $feature)
                                <li><i class="fas fa-check text-success"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <div class="btn-group">
                            <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button onclick="togglePlan({{ $plan->id }})" class="btn btn-sm {{ $plan->is_active ? 'btn-secondary' : 'btn-success' }}">
                                <i class="fas {{ $plan->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                {{ $plan->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce plan ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePlan(id) {
    fetch(`/admin/plans/${id}/toggle`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
        .then(() => location.reload());
}
</script>
@endpush
@endsection