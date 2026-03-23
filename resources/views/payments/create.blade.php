<form action="{{ route('payments.store') }}" method="POST">
@csrf

<label>Membre</label>
<br>
<select name="member_id">
@foreach($members as $member)
<option value="{{ $member->id }}">{{ $member->name }}</option>
@endforeach
</select>

<br><br>

<label>Plan</label>
<br>
<select name="plan_id">
@foreach($plans as $plan)
<option value="{{ $plan->id }}">
{{ $plan->name }} - {{ $plan->price }} DH
</option>
@endforeach
</select>

<br><br>

<button type="submit">Ajouter Payment</button>

</form>