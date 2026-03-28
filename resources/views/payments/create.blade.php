<!DOCTYPE html>
<html>
<head>
<title>Ajouter Payment</title>
</head>
<body>

<h2>Ajouter Payment</h2>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

<form action="{{ route('payments.store') }}" method="POST">
@csrf

<!-- Member -->
<label>Membre</label>
<select name="member_id" required>
@foreach($members as $member)
<option value="{{ $member->id }}">{{ $member->name }}</option>
@endforeach
</select>

<br><br>

<!-- Plan -->
<label>Plan</label>
<select name="plan_id" required>
<option value=""></option>
@foreach($plans as $plan)
<option value="{{ $plan->id }}">
{{ $plan->name }} - {{ $plan->price }} DH
</option>
@endforeach
</select>

<br><br>

<!-- Status -->
<label>Status</label>
<select name="status" required>
<option value="payé">Payé</option>
<option value="non payé">Non payé</option>
</select>

<br><br>

<button type="submit">Enregistrer</button>

</form>

</body>
</html>