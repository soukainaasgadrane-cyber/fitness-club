@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <h1>Bienvenue à Fitness Club 💪</h1>
        <p class="lead">Le premier club de fitness pour atteindre vos objectifs sportifs</p>
        
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary">Rejoignez-nous</a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-success">Aller au tableau de bord</a>
        @endguest
    </div>
</div>
@endsection