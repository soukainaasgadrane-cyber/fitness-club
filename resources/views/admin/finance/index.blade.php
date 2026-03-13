{{-- resources/views/admin/finance/index.blade.php --}}
@extends('admin.layouts.finance')

@section('title', 'Dashboard Finance')
@section('page-title', 'Tableau de bord financier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques financières</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3>{{ number_format($stats['today_revenue'], 2) }} MAD</h3>
                                <p>Revenus aujourd'hui</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3>{{ number_format($stats['month_revenue'], 2) }} MAD</h3>
                                <p>Revenus ce mois</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3>{{ number_format($stats['year_revenue'], 2) }} MAD</h3>
                                <p>Revenus cette année</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3>{{ $stats['active_subscriptions'] }}</h3>
                                <p>Abonnements actifs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }
    .stat-card h3 {
        font-size: 28px;
        margin-bottom: 5px;
    }
    .stat-card p {
        margin: 0;
        opacity: 0.9;
    }
</style>
@endsection