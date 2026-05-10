@extends('admin.layouts.app')

@section('title', 'Modifier membre')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white">
        <h5 class="mb-0">Modifier membre</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.members.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prenom</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $member->first_name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $member->last_name) }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telephone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', optional($member->birth_date)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Genre</label>
                    <select name="gender" class="form-control">
                        <option value="">Selectionner</option>
                        <option value="male" @selected(old('gender', $member->gender) === 'male')>Homme</option>
                        <option value="female" @selected(old('gender', $member->gender) === 'female')>Femme</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $member->address) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contact d'urgence</label>
                    <input type="text" name="emergency_contact" class="form-control" value="{{ old('emergency_contact', $member->emergency_contact) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Notes medicales</label>
                <textarea name="medical_notes" class="form-control" rows="2">{{ old('medical_notes', $member->medical_notes) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Mettre a jour</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
