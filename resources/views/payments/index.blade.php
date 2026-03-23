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