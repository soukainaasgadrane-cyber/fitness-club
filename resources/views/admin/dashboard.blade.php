@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Bienvenue {{ Auth::user()->name }} ! 👋</h1>
            
            <div class="row">
                <!-- Cartes des statistiques -->
                <div class="col-md-4 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Entraînements d'aujourd'hui</h6>
                                    <h2 class="mt-2 mb-0">0</h2>
                                </div>
                                <i class="fas fa-dumbbell fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Calories brûlées</h6>
                                    <h2 class="mt-2 mb-0">0</h2>
                                </div>
                                <i class="fas fa-fire fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">Jours consécutifs</h6>
                                    <h2 class="mt-2 mb-0">0</h2>
                                </div>
                                <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('programs.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list"></i> Voir les programmes
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('exercises.index') }}" class="btn btn-outline-success w-100">
                                <i class="fas fa-dumbbell"></i> Exercices
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('bmi') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-calculator"></i> Calculer le BMI
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('progress.index') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-chart-line"></i> Mon progrès
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Activité récente (sera activée plus tard) -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Activités récentes</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center py-3">
                        Aucune activité récente. Commence ton premier entraînement !
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection