@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 120px 0;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold mb-4">
                    Transformez Votre Corps<br>
                    <span style="color: #ffd700;">Transformez Votre Vie</span>
                </h1>
                <p class="lead mb-4">
                    Rejoignez la meilleure salle de sport et atteignez vos objectifs avec nos coachs professionnels.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold me-3">
                        <i class="fas fa-user-plus me-2"></i> Commencer Maintenant
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3">
                        <i class="fas fa-sign-in-alt me-2"></i> Se Connecter
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold">
                        <i class="fas fa-chart-line me-2"></i> Tableau de Bord
                    </a>
                @endguest
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/2964/2964516.png" alt="Fitness" class="img-fluid" style="max-width: 80%;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Pourquoi Nous Choisir?</h2>
            <p class="lead text-muted">Découvrez nos avantages exclusifs</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-dumbbell fa-4x text-primary mb-3"></i>
                        <h4>Équipements Modernes</h4>
                        <p class="text-muted">Des machines dernier cri pour tous vos entraînements</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-chalkboard-user fa-4x text-success mb-3"></i>
                        <h4>Coachs Experts</h4>
                        <p class="text-muted">Encadrement personnalisé par des professionnels</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center p-4 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-4x text-info mb-3"></i>
                        <h4>Horaires Flexibles</h4>
                        <p class="text-muted">Ouvert 7j/7 de 6h à 23h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Programmes Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Nos Programmes</h2>
            <p class="lead text-muted">Des programmes adaptés à tous les niveaux</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500" class="card-img-top" alt="Musculation" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Musculation</h5>
                        <p class="card-text text-muted">Développez votre force et votre masse musculaire</p>
                        <a href="{{ route('programs.index') }}" class="btn btn-outline-primary">En savoir plus →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=500" class="card-img-top" alt="Cardio" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Cardio</h5>
                        <p class="card-text text-muted">Améliorez votre endurance et brûlez des calories</p>
                        <a href="{{ route('programs.index') }}" class="btn btn-outline-primary">En savoir plus →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://images.unsplash.com/photo-1599058917765-a780eda07a3e?w=500" class="card-img-top" alt="Yoga" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Yoga & Bien-être</h5>
                        <p class="card-text text-muted">Retrouvez équilibre et sérénité</p>
                        <a href="{{ route('programs.index') }}" class="btn btn-outline-primary">En savoir plus →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tarifs Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Nos Tarifs</h2>
            <p class="lead text-muted">Choisissez le forfait qui vous convient</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="text-primary">Mensuel</h3>
                        <div class="display-4 fw-bold text-dark">300 DH</div>
                        <p class="text-muted">/mois</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li class="mb-2">✓ Accès illimité</li>
                            <li class="mb-2">✓ Vestiaires</li>
                            <li class="mb-2">✓ Application mobile</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mt-3">S'abonner</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center shadow border-0" style="border-top: 4px solid #667eea !important;">
                    <div class="card-body">
                        <span class="badge bg-warning text-dark mb-2">POPULAIRE</span>
                        <h3 class="text-primary">Trimestriel</h3>
                        <div class="display-4 fw-bold text-dark">750 DH</div>
                        <p class="text-muted">/3 mois</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li class="mb-2">✓ Accès illimité</li>
                            <li class="mb-2">✓ Vestiaires</li>
                            <li class="mb-2">✓ Application mobile</li>
                            <li class="mb-2">✓ Cours collectifs</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mt-3">S'abonner</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center shadow-sm border-0">
                    <div class="card-body">
                        <h3 class="text-primary">Annuel</h3>
                        <div class="display-4 fw-bold text-dark">2500 DH</div>
                        <p class="text-muted">/an</p>
                        <hr>
                        <ul class="list-unstyled">
                            <li class="mb-2">✓ Tout inclus</li>
                            <li class="mb-2">✓ Coaching personnalisé</li>
                            <li class="mb-2">✓ Programme nutrition</li>
                            <li class="mb-2">✓ Parking gratuit</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 mt-3">S'abonner</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-4 fw-bold">Ce que disent nos membres</h2>
            <p class="lead text-muted">Ils ont transformé leur vie avec nous</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <div class="text-center">
                        <img src="https://randomuser.me/api/portraits/women/1.jpg" class="rounded-circle mb-3" width="80" height="80">
                        <h5>Sophie Martin</h5>
                        <div class="text-warning mb-3">★★★★★</div>
                        <p class="text-muted">"Super salle ! Les coachs sont à l'écoute et les équipements sont de qualité."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <div class="text-center">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" class="rounded-circle mb-3" width="80" height="80">
                        <h5>Thomas Dubois</h5>
                        <div class="text-warning mb-3">★★★★★</div>
                        <p class="text-muted">"J'ai perdu 15kg en 3 mois grâce aux programmes personnalisés. Je recommande!"</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 p-4">
                    <div class="text-center">
                        <img src="https://randomuser.me/api/portraits/women/2.jpg" class="rounded-circle mb-3" width="80" height="80">
                        <h5>Marie Lambert</h5>
                        <div class="text-warning mb-3">★★★★★</div>
                        <p class="text-muted">"Ambiance familiale et très propre. Les cours de yoga sont excellents!"</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container text-center text-white">
        <h2 class="display-4 fw-bold mb-4">Prêt à commencer votre transformation?</h2>
        <p class="lead mb-4">Rejoignez-nous aujourd'hui et obtenez votre première semaine gratuite!</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold">
                <i class="fas fa-rocket me-2"></i> Commencer Maintenant
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold">
                <i class="fas fa-chart-line me-2"></i> Voir Mon Dashboard
            </a>
        @endguest
    </div>
</section>

<style>
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
</style>
@endsection