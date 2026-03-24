@extends('layouts.app')

@section('title', 'Détails du programme')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <div class="card-body p-5 text-center">
            <i class="fas fa-dumbbell fa-5x text-primary mb-4"></i>
            <h1 class="display-4 mb-4">Programme en construction</h1>
            <p class="lead text-muted mb-4">
                Cette page sera bientôt disponible avec tous les détails du programme.
            </p>
            <a href="{{ route('programs.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-left me-2"></i> Retour aux programmes
            </a>
        </div>
    </div>
</div>
@endsection