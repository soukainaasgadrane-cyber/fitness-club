@extends('layouts.app')

@section('title', 'Programmes')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 80px 0;">
    <div class="container text-center">
        <h1 class="display-3 fw-bold mb-3">
            <i class="fas fa-dumbbell me-2"></i>
            Nos Programmes
        </h1>
        <p class="lead mb-0">
            Découvrez nos programmes d'entraînement adaptés à tous les niveaux
        </p>
    </div>
</section>

<!-- Programmes Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Programme Musculation -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500" 
                             class="card-img-top" 
                             alt="Musculation" 
                             style="height: 250px; object-fit: cover;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                <i class="fas fa-fire me-1"></i> Populaire
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">
                            <i class="fas fa-dumbbell text-primary me-2"></i>
                            Musculation
                        </h3>
                        <p class="card-text text-muted mb-4">
                            Programme complet pour développer votre force et votre masse musculaire. 
                            Exercices ciblés pour chaque groupe musculaire.
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock me-2 text-primary"></i> Durée</span>
                                <span class="fw-bold">45-60 min</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-chart-line me-2 text-primary"></i> Niveau</span>
                                <span class="fw-bold">Intermédiaire</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-calendar-week me-2 text-primary"></i> Fréquence</span>
                                <span class="fw-bold">3-4x/semaine</span>
                            </div>
                        </div>
                        <a href="{{ route('programs.show', 1) }}" class="btn btn-primary w-100">
                            Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Programme Cardio -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=500" 
                         class="card-img-top" 
                         alt="Cardio" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">
                            <i class="fas fa-heart text-danger me-2"></i>
                            Cardio & Endurance
                        </h3>
                        <p class="card-text text-muted mb-4">
                            Améliorez votre endurance et brûlez des calories avec nos programmes cardio.
                            Idéal pour perdre du poids.
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock me-2 text-primary"></i> Durée</span>
                                <span class="fw-bold">30-45 min</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-chart-line me-2 text-primary"></i> Niveau</span>
                                <span class="fw-bold">Débutant</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-calendar-week me-2 text-primary"></i> Fréquence</span>
                                <span class="fw-bold">5x/semaine</span>
                            </div>
                        </div>
                        <a href="{{ route('programs.show', 2) }}" class="btn btn-outline-primary w-100">
                            Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Programme Yoga -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1599058917765-a780eda07a3e?w=500" 
                         class="card-img-top" 
                         alt="Yoga" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">
                            <i class="fas fa-spa text-success me-2"></i>
                            Yoga & Bien-être
                        </h3>
                        <p class="card-text text-muted mb-4">
                            Retrouvez équilibre et sérénité avec nos séances de yoga.
                            Améliorez votre flexibilité et réduisez le stress.
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock me-2 text-primary"></i> Durée</span>
                                <span class="fw-bold">60-75 min</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-chart-line me-2 text-primary"></i> Niveau</span>
                                <span class="fw-bold">Tous niveaux</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-calendar-week me-2 text-primary"></i> Fréquence</span>
                                <span class="fw-bold">2-3x/semaine</span>
                            </div>
                        </div>
                        <a href="{{ route('programs.show', 3) }}" class="btn btn-outline-primary w-100">
                            Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programme HIIT -->
        <div class="row mt-4 g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=500" 
                         class="card-img-top" 
                         alt="HIIT" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            HIIT
                        </h3>
                        <p class="card-text text-muted mb-4">
                            Entraînement fractionné à haute intensité pour maximiser la combustion des graisses.
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock me-2 text-primary"></i> Durée</span>
                                <span class="fw-bold">20-30 min</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-chart-line me-2 text-primary"></i> Niveau</span>
                                <span class="fw-bold">Avancé</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-calendar-week me-2 text-primary"></i> Fréquence</span>
                                <span class="fw-bold">3x/semaine</span>
                            </div>
                        </div>
                        <a href="{{ route('programs.show', 4) }}" class="btn btn-outline-primary w-100">
                            Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Programme CrossFit -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=500" 
                         class="card-img-top" 
                         alt="CrossFit" 
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h3 class="card-title fw-bold mb-3">
                            <i class="fas fa-fist-raised text-primary me-2"></i>
                            CrossFit
                        </h3>
                        <p class="card-text text-muted mb-4">
                            Entraînement fonctionnel pour développer force, endurance et agilité.
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock me-2 text-primary"></i> Durée</span>
                                <span class="fw-bold">45-60 min</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-chart-line me-2 text-primary"></i> Niveau</span>
                                <span class="fw-bold">Intermédiaire</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-calendar-week me-2 text-primary"></i> Fréquence</span>
                                <span class="fw-bold">4x/semaine</span>
                            </div>
                        </div>
                        <a href="{{ route('programs.show', 5) }}" class="btn btn-outline-primary w-100">
                            Voir le programme <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Programme Personnalisé -->
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-center text-white">
                        <i class="fas fa-user-check fa-4x mb-3"></i>
                        <h3 class="card-title fw-bold mb-3">Programme Personnalisé</h3>
                        <p class="card-text mb-4">
                            Besoin d'un programme sur mesure ? Nos coachs créent un programme adapté à vos objectifs.
                        </p>
                        <a href="{{ route('contact') }}" class="btn btn-light fw-bold px-4">
                            Contactez-nous <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="display-4 fw-bold mb-3">Prêt à commencer ?</h2>
        <p class="lead mb-4">Rejoignez notre communauté et transformez votre vie</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-user-plus me-2"></i> S'inscrire maintenant
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5">
                <i class="fas fa-chart-line me-2"></i> Voir mon tableau de bord
            </a>
        @endguest
    </div>
</section>

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
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
    }
    .badge {
        font-size: 0.9rem;
    }
</style>
@endsection