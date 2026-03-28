@extends('layouts.app')

@section('title', 'Calculateur IMC')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-calculator text-primary me-2"></i>
                    Calculateur IMC
                </h1>
                <p class="lead text-muted">
                    Calculez votre Indice de Masse Corporelle et découvrez votre situation
                </p>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Calculer votre IMC
                    </h4>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('bmi') }}" id="bmiForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-weight-hanging text-primary me-2"></i>
                                    Poids (kg)
                                </label>
                                <input type="number" 
                                       name="weight" 
                                       id="weight"
                                       class="form-control form-control-lg" 
                                       placeholder="Entrez votre poids"
                                       step="0.1"
                                       min="20"
                                       max="300"
                                       required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-arrows-alt text-primary me-2"></i>
                                    Taille (cm)
                                </label>
                                <input type="number" 
                                       name="height" 
                                       id="height"
                                       class="form-control form-control-lg" 
                                       placeholder="Entrez votre taille"
                                       step="1"
                                       min="100"
                                       max="250"
                                       required>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                <i class="fas fa-chart-line me-2"></i>
                                Calculer mon IMC
                            </button>
                        </div>
                    </form>

                    @if(isset($bmi) && isset($category) && isset($advice))
                    <div class="mt-5 pt-4 border-top">
                        <div class="text-center mb-4">
                            <h3 class="mb-3">Votre Résultat</h3>
                            <div class="display-1 fw-bold text-primary mb-2">
                                {{ number_format($bmi, 1) }}
                            </div>
                            <div class="badge bg-{{ $color ?? 'info' }} fs-5 px-4 py-2">
                                {{ $category }}
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-{{ $alert ?? 'info' }} border-0 shadow-sm">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    <strong>Recommandation:</strong> {{ $advice }}
                                </div>
                            </div>
                        </div>

                        <!-- Barre de progression IMC -->
                        <div class="mt-4">
                            <label class="form-label fw-bold">Échelle IMC</label>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-info" style="width: 15%;" title="Insuffisance pondérale">
                                    <small>Insuffisant</small>
                                </div>
                                <div class="progress-bar bg-success" style="width: 30%;" title="Poids normal">
                                    <small>Normal</small>
                                </div>
                                <div class="progress-bar bg-warning" style="width: 25%;" title="Surpoids">
                                    <small>Surpoids</small>
                                </div>
                                <div class="progress-bar bg-danger" style="width: 30%;" title="Obésité">
                                    <small>Obésité</small>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 small text-muted">
                                <span>≤ 18.5</span>
                                <span>18.5 - 25</span>
                                <span>25 - 30</span>
                                <span>≥ 30</span>
                            </div>
                            
                            <!-- Indicateur -->
                            <div class="mt-3 position-relative" style="height: 20px;">
                                <div class="position-absolute" style="left: {{ $bmiPercentage ?? 0 }}%; transform: translateX(-50%);">
                                    <i class="fas fa-caret-down fa-2x text-primary"></i>
                                    <div class="small fw-bold">{{ number_format($bmi, 1) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tableau des catégories IMC -->
            <div class="card mt-5 shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Classification IMC
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Catégorie</th>
                                    <th>IMC</th>
                                    <th>Risques pour la santé</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-info">
                                    <td><strong>Insuffisance pondérale</strong></td>
                                    <td>&lt; 18,5</td>
                                    <td>Risque accru de carences et d'ostéoporose</td>
                                </tr>
                                <tr class="table-success">
                                    <td><strong>Poids normal</strong></td>
                                    <td>18,5 - 24,9</td>
                                    <td>Risque moyen, état de santé optimal</td>
                                </tr>
                                <tr class="table-warning">
                                    <td><strong>Surpoids</strong></td>
                                    <td>25 - 29,9</td>
                                    <td>Risque modéré de maladies cardiovasculaires</td>
                                </tr>
                                <tr class="table-danger">
                                    <td><strong>Obésité modérée</strong></td>
                                    <td>30 - 34,9</td>
                                    <td>Risque élevé de maladies chroniques</td>
                                </tr>
                                <tr class="table-danger">
                                    <td><strong>Obésité sévère</strong></td>
                                    <td>35 - 39,9</td>
                                    <td>Risque très élevé</td>
                                </tr>
                                <tr class="table-danger">
                                    <td><strong>Obésité morbide</strong></td>
                                    <td>≥ 40</td>
                                    <td>Risque extrême, consultation médicale nécessaire</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .progress-bar {
        transition: width 0.6s ease;
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>

<script>
    // Animation pour le curseur
    @if(isset($bmi))
    const bmiValue = {{ $bmi }};
    let percentage = 0;
    if (bmiValue <= 18.5) {
        percentage = (bmiValue / 18.5) * 15;
    } else if (bmiValue <= 25) {
        percentage = 15 + ((bmiValue - 18.5) / 6.5) * 30;
    } else if (bmiValue <= 30) {
        percentage = 45 + ((bmiValue - 25) / 5) * 25;
    } else if (bmiValue <= 40) {
        percentage = 70 + ((bmiValue - 30) / 10) * 30;
    } else {
        percentage = 100;
    }
    document.querySelector('.position-absolute').style.left = percentage + '%';
    @endif
</script>
@endsection