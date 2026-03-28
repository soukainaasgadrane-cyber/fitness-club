<<<<<<< HEAD
<!DOCTYPE html>
<html>
<head>
    <title>Historique des paiements</title>
</head>
<body>

<h2>Historique des paiements</h2>

<a href="{{ route('payments.create') }}">Ajouter Payment</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
<th>Membre</th>
<th>Plan</th>
<th>Montant</th>
<th>Date</th>
<th>Status</th>
</tr>

@foreach($payments as $payment)

<tr>

<td>{{ $payment->member->name }}</td>

<td>{{ $payment->plan->name }}</td>

<td>{{ $payment->amount }} DH</td>

<td>{{ $payment->payment_date }}</td>

<td>

@if($payment->status == 'payé')

<span style="color:green;">Payé</span>

@else

<span style="color:red;">Non payé</span>

@endif

</td>

</tr>

@endforeach

</table>

</body>
</html>
=======
@extends('admin.layouts.app')

@section('title', 'Paiements - GHITA')
@section('content')
<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total encaissé</h6>
                        <h3 class="mb-0">{{ number_format($totalReceived, 2) }} DH</h3>
                    </div>
                    <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Aujourd'hui</h6>
                        <h3 class="mb-0">{{ number_format($todayPayments, 2) }} DH</h3>
                    </div>
                    <i class="fas fa-calendar-day fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-warning text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">En attente</h6>
                        <h3 class="mb-0">{{ $pendingCount }}</h3>
                    </div>
                    <i class="fas fa-clock fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des paiements -->
<div class="card shadow">
    <div class="card-header bg-white d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-credit-card text-primary me-2"></i>
            Historique des paiements
        </h5>
        <a href="{{ route('admin.payments.export') }}" class="btn btn-success btn-sm">
            <i class="fas fa-download me-1"></i> Exporter CSV
        </a>
    </div>
    <div class="card-body p-0">
        @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        #####
                            <th>Facture</th>
                            <th>Membre</th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            #####
                                <td>
                                    <span class="fw-bold text-primary">#{{ $payment->invoice_number ?? $payment->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $payment->subscription->member->full_name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $payment->subscription->member->email ?? '' }}</small>
                                </td>
                                <td class="fw-bold">{{ number_format($payment->amount, 2) }} DH</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-{{ $payment->payment_method == 'cash' ? 'money-bill-wave' : ($payment->payment_method == 'card' ? 'credit-card' : 'university') }} me-1"></i>
                                        {{ ucfirst($payment->payment_method) }}
                                    </span>
                                </td>
                                <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($payment->status == 'completed')
                                        <span class="badge bg-success">Payé</span>
                                    @elseif($payment->status == 'pending')
                                        <span class="badge bg-warning">En attente</span>
                                    @else
                                        <span class="badge bg-danger">{{ $payment->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-credit-card fa-4x text-muted mb-3"></i>
                    <h5>Aucun paiement enregistré</h5>
                    <p class="text-muted">Les paiements apparaîtront ici une fois enregistrés.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .opacity-50 {
        opacity: 0.5;
    }
</style>
@endsection
>>>>>>> 0e44b56045a22769115ad940b15d089cbf337c30
