@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-envelope fa-4x text-primary mb-3"></i>
                        <h1 class="display-4 fw-bold">Contactez-nous</h1>
                        <p class="lead text-muted">Nous sommes là pour répondre à vos questions</p>
                    </div>
                    
                    <form>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" class="form-control" placeholder="Votre nom">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="votre@email.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sujet</label>
                            <input type="text" class="form-control" placeholder="Sujet de votre message">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="5" placeholder="Votre message..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-paper-plane me-2"></i> Envoyer
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                            <h6>Téléphone</h6>
                            <p class="text-muted">+212 5XX-XXXXXX</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                            <h6>Email</h6>
                            <p class="text-muted">contact@fitnessclub.com</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                            <h6>Adresse</h6>
                            <p class="text-muted">Casablanca, Maroc</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection