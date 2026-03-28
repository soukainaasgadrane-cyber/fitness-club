@extends('admin.layouts.app')

@section('title', 'Ajouter membre')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Ajouter un membre</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection