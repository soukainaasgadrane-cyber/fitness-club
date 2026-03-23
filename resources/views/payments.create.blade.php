<form action="{{ route('payments.store') }}" method="POST">
    @csrf

    <!-- Member -->
    <label for="member_id">Membre</label>
    <select name="member_id" id="member_id" required>
        <option value="">-- Sélectionner un membre --</option>
        @foreach($members as $member)
            <option value="{{ $member->id }}">{{ $member->name }}</option>
        @endforeach
    </select>

    <!-- Plan -->
    <label for="plan_id">Plan</label>
    <select name="plan_id" id="plan_id" required>
        <option value="">-- Sélectionner un plan --</option>
        @foreach($plans as $plan)
            <option value="{{ $plan->id }}">{{ $plan->name }}</option>
        @endforeach
    </select>

    <!-- Status -->
    <label for="status">Status</label>
    <input type="text" name="status" id="status" value="Payé" required>

    <!-- Submit -->
    <button type="submit">Ajouter Payment</button>
</form>

<!-- Errors -->
@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif