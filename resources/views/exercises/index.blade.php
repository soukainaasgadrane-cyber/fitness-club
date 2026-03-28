@extends('layouts.app')

@section('title', 'Exercices')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 0;">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-3">
            <i class="fas fa-dumbbell me-2"></i>
            Bibliothèque d'Exercices
        </h1>
        <p class="lead mb-0">
            Découvrez notre collection complète d'exercices avec instructions détaillées
        </p>
    </div>
</section>

<!-- Filtres -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-search me-1"></i> Recherche
                                </label>
                                <input type="text" id="search" class="form-control" placeholder="Nom de l'exercice...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-muscle me-1"></i> Groupe musculaire
                                </label>
                                <select id="muscleGroup" class="form-select">
                                    <option value="all">Tous</option>
                                    <option value="poitrine">Poitrine</option>
                                    <option value="dos">Dos</option>
                                    <option value="jambes">Jambes</option>
                                    <option value="epaules">Épaules</option>
                                    <option value="bras">Bras</option>
                                    <option value="abdos">Abdominaux</option>
                                    <option value="cardio">Cardio</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-chart-line me-1"></i> Niveau
                                </label>
                                <select id="level" class="form-select">
                                    <option value="all">Tous</option>
                                    <option value="debutant">Débutant</option>
                                    <option value="intermediaire">Intermédiaire</option>
                                    <option value="avance">Avancé</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Exercices Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4" id="exercisesGrid">
            <!-- Exercise 1 - Push-ups -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="poitrine" data-level="debutant">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1598971639058-fab3c3109a00?w=500" 
                             class="card-img-top" 
                             alt="Push-ups" 
                             style="height: 220px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                <i class="fas fa-star me-1"></i> Populaire
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Push-ups</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Poitrine</span>
                            <span class="badge bg-secondary">Débutant</span>
                        </div>
                        <p class="card-text text-muted">
                            Exercice de base pour renforcer la poitrine, les épaules et les triceps.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">3</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-chart-line me-1 text-primary"></i> Répétitions</small>
                                <small class="fw-bold">10-15</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">60 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4" data-bs-toggle="modal" data-bs-target="#exerciseModal1">
                            Voir les détails <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Exercise 2 - Squats -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="jambes" data-level="debutant">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1566241440091-ec10e8b2b8c6?w=500" 
                         class="card-img-top" 
                         alt="Squats" 
                         style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Squats</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Jambes</span>
                            <span class="badge bg-secondary">Débutant</span>
                        </div>
                        <p class="card-text text-muted">
                            Exercice fondamental pour renforcer les cuisses, les fessiers et les mollets.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">4</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-chart-line me-1 text-primary"></i> Répétitions</small>
                                <small class="fw-bold">12-15</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">90 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4">Voir les détails <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Exercise 3 - Plank -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="abdos" data-level="debutant">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1566241142559-40e1dab266c6?w=500" 
                         class="card-img-top" 
                         alt="Plank" 
                         style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Plank</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Abdominaux</span>
                            <span class="badge bg-secondary">Débutant</span>
                        </div>
                        <p class="card-text text-muted">
                            Exercice isométrique pour renforcer la sangle abdominale et le dos.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">3</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Durée</small>
                                <small class="fw-bold">30-60 sec</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">45 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4">Voir les détails <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Exercise 4 - Pull-ups -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="dos" data-level="avance">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1598266663439-2056e6900339?w=500" 
                         class="card-img-top" 
                         alt="Pull-ups" 
                         style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Pull-ups</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Dos</span>
                            <span class="badge bg-danger">Avancé</span>
                        </div>
                        <p class="card-text text-muted">
                            Exercice de traction pour développer le dos et les biceps.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">3-4</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-chart-line me-1 text-primary"></i> Répétitions</small>
                                <small class="fw-bold">8-12</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">90 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4">Voir les détails <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Exercise 5 - Jumping Jacks -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="cardio" data-level="debutant">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1599058917212-d750089bc07e?w=500" 
                         class="card-img-top" 
                         alt="Jumping Jacks" 
                         style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Jumping Jacks</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Cardio</span>
                            <span class="badge bg-secondary">Débutant</span>
                        </div>
                        <p class="card-text text-muted">
                            Excellent exercice cardio pour échauffer le corps et brûler des calories.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">3</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Durée</small>
                                <small class="fw-bold">45 sec</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">30 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4">Voir les détails <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Exercise 6 - Dumbbell Curl -->
            <div class="col-md-6 col-lg-4 exercise-item" data-muscle="bras" data-level="intermediaire">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=500" 
                         class="card-img-top" 
                         alt="Dumbbell Curl" 
                         style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-2">Dumbbell Curl</h3>
                        <div class="mb-2">
                            <span class="badge bg-info me-1">Bras</span>
                            <span class="badge bg-warning">Intermédiaire</span>
                        </div>
                        <p class="card-text text-muted">
                            Exercice ciblé pour développer les biceps et la force des bras.
                        </p>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-redo-alt me-1 text-primary"></i> Séries</small>
                                <small class="fw-bold">3-4</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small><i class="fas fa-chart-line me-1 text-primary"></i> Répétitions</small>
                                <small class="fw-bold">10-12</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small><i class="fas fa-clock me-1 text-primary"></i> Repos</small>
                                <small class="fw-bold">60 sec</small>
                            </div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 mt-4">Voir les détails <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Example (pour afficher les détails) -->
<div class="modal fade" id="exerciseModal1" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Push-ups - Détails de l'exercice</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1598971639058-fab3c3109a00?w=500" class="img-fluid rounded" alt="Push-ups">
                    </div>
                    <div class="col-md-6">
                        <h4>Instructions</h4>
                        <ol>
                            <li>Positionnez-vous en planche, mains à largeur d'épaules</li>
                            <li>Descendez votre corps jusqu'à ce que votre poitrine touche presque le sol</li>
                            <li>Remontez en poussant avec vos bras</li>
                            <li>Gardez le dos droit et les abdominaux contractés</li>
                        </ol>
                        <h4 class="mt-3">Conseils</h4>
                        <ul>
                            <li>Respirez en descendant, expirez en montant</li>
                            <li>Ne cambrez pas le dos</li>
                            <li>Commencez avec des séries de 10 répétitions</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Filtre JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const muscleSelect = document.getElementById('muscleGroup');
        const levelSelect = document.getElementById('level');
        const exercises = document.querySelectorAll('.exercise-item');

        function filterExercises() {
            const searchTerm = searchInput.value.toLowerCase();
            const muscle = muscleSelect.value;
            const level = levelSelect.value;

            exercises.forEach(exercise => {
                const title = exercise.querySelector('.card-title').textContent.toLowerCase();
                const exerciseMuscle = exercise.dataset.muscle;
                const exerciseLevel = exercise.dataset.level;
                
                const matchesSearch = title.includes(searchTerm);
                const matchesMuscle = muscle === 'all' || exerciseMuscle === muscle;
                const matchesLevel = level === 'all' || exerciseLevel === level;
                
                if (matchesSearch && matchesMuscle && matchesLevel) {
                    exercise.style.display = 'block';
                } else {
                    exercise.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterExercises);
        muscleSelect.addEventListener('change', filterExercises);
        levelSelect.addEventListener('change', filterExercises);
    });
</script>

<style>
    .hero-section {
        margin-top: -1rem;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 30px rgba(0,0,0,0.1) !important;
    }
    .badge {
        font-size: 0.85rem;
    }
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
</style>
@endsection