<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            padding-top: 20px;
        }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            display: block;
            padding: 12px 25px;
            transition: all 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 35px;
        }
        .sidebar a i {
            margin-right: 10px;
            width: 25px;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            border-radius: 15px 15px 0 0 !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <i class="fas fa-dumbbell fa-3x mb-2"></i>
            <h5>Fitness Club</h5>
            <small>Administration</small>
        </div>
        
        <a href="/admin/dashboard">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="/admin/members">
            <i class="fas fa-users"></i> Membres
        </a>
        <a href="/admin/subscriptions">
            <i class="fas fa-calendar-alt"></i> Abonnements
        </a>
        <a href="/admin/payments">
            <i class="fas fa-credit-card"></i> Paiements
        </a>
        <a href="/admin/finance">
            <i class="fas fa-chart-line"></i> Finance
        </a>
        <hr>
        <a href="/">
            <i class="fas fa-home"></i> Retour site
        </a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
        <form id="logout-form" action="/logout" method="POST" class="d-none">@csrf</form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>