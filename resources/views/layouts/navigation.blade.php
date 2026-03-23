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
        
        <!-- LIENS ADMIN (SANS CONDITION) -->
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            Admin
        </x-nav-link>
        <x-nav-link :href="route('admin.subscriptions.index')" :active="request()->routeIs('admin.subscriptions.*')">
            Abonnements
        </x-nav-link>
        <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
            Paiements
        </x-nav-link>
        <x-nav-link :href="route('admin.finance.index')" :active="request()->routeIs('admin.finance.*')">
            Finance
        </x-nav-link>
    @endauth
</div>