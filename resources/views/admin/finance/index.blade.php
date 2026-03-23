@extends('admin.layouts.app')

@section('title', 'Finance ')
@section('content')
<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fas fa-chart-line me-2"></i>
            Dashboard Finance 
        </h5>
    </div>
    <div class="card-body">
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> Page finance fonctionne!
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h3>0 DH</h3>
                        <small>Total encaissé</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h3>0</h3>
                        <small>Abonnements actifs</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h3>0</h3>
                        <small>En attente</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection