<h2>Paiement abonnement</h2>

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<form action="{{ route('payer') }}" method="POST">
@csrf

<label>Nom</label>
<input type="text" name="name">

<br><br>

<label>Montant</label>
<input type="number" name="amount">

<br><br>

<button type="submit">Payer</button>

</form>