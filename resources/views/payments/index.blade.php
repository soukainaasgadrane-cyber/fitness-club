<!DOCTYPE html>
<html>
<head>
    <title>Historique des paiements</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .alert { padding:10px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        a { text-decoration: none; color: #007BFF; }
    </style>
</head>
<body>

<h2>Historique des paiements</h2>

<!-- Message success -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('payments.create') }}">Ajouter Payment</a>

<table>
<tr>
<th>Membre</th>
<th>Plan</th>
<th>Montant</th>
<th>Status</th>
<th>Date</th>
</tr>

@foreach($payments as $payment)
<tr>
<td>{{ $payment->member->name }}</td>
<td>{{ $payment->plan->name }}</td>
<td>{{ $payment->amount }}</td>
<td>{{ $payment->status }}</td>
<td>{{ $payment->payment_date }}</td>
</tr>
@endforeach

</table>

</body>
</html>