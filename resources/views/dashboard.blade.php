@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success">
                <h4 class="alert-heading">Bonjour {{ Auth::user()->name }}! 👋</h4>
                <p>Vous êtes connecté avec succès</p>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Mes entraînements</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Calories</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Jours</h5>
                    <h2>0</h2>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Poids</h5>
                    <h2>-- kg</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Actions rapides</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('programs.index') }}" class="btn btn-outline-primary mb-2 w-100">
                        Voir les programmes
                    </a>
                    <a href="{{ route('exercises.index') }}" class="btn btn-outline-success mb-2 w-100">
                        Exercices
                    </a>
                    <a href="{{ route('bmi') }}" class="btn btn-outline-info mb-2 w-100">
                        Calculer l’IMC
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection