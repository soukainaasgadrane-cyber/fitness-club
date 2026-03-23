<!-- Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
        Accueil
    </x-nav-link>
    
    <x-nav-link :href="route('programs.index')" :active="request()->routeIs('programs.*')">
        Programmes
    </x-nav-link>
    
    <x-nav-link :href="route('exercises.index')" :active="request()->routeIs('exercises.*')">
        Exercices
    </x-nav-link>
    
    <x-nav-link :href="route('bmi')" :active="request()->routeIs('bmi')">
        Calcul IMC
    </x-nav-link>
    
    @auth
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-nav-link>
        
        @if(Auth::user() && Auth::user()->is_admin)
    <div class="dropdown-divider"></div>
    <h6 class="dropdown-header">Administration</h6>
    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
    </a>
    <a class="dropdown-item" href="{{ route('admin.members.index') }}">
        <i class="fas fa-users me-2"></i> Membres
    </a>
    <a class="dropdown-item" href="{{ route('admin.subscriptions.index') }}">
        <i class="fas fa-calendar-alt me-2"></i> Abonnements
    </a>
    <a class="dropdown-item" href="{{ route('admin.payments.index') }}">
        <i class="fas fa-credit-card me-2"></i> Paiements
    </a>
    <a class="dropdown-item" href="{{ route('admin.finance.index') }}">
        <i class="fas fa-chart-line me-2"></i> Finance
    </a>
@endif
    @endauth
</div>