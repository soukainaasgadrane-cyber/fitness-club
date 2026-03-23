<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Payment</title>
</head>
<body>

<h2>Ajouter Payment</h2>

@if($errors->any())
<div style="color:red;">
    @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<form action="{{ route('payments.store') }}" method="POST">
@csrf

<label>Membre</label>
<select name="member_id">
@foreach($members as $member)
<option value="{{ $member->id }}">
    {{ $member->name }}
</option>
@endforeach
</select>

<br><br>

<label>Plan</label>
<select name="plan_id">
@foreach($plans as $plan)
<option value="{{ $plan->id }}">
    {{ $plan->name }} - {{ $plan->price }} DH
</option>
@endforeach
</select>

<br><br>

<label>Status</label>
<select name="status">
<option value="payé">Payé</option>
<option value="non payé">Non payé</option>
</select>

<br><br>

<button type="submit">Ajouter Payment</button>

</form>

</body>
</html>