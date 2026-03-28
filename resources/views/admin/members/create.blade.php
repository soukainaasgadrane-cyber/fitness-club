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


@section('content')
<div class="card">
    <div class="card-header">
        <h5>Ajouter un nouveau membre</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Prénom</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nom</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Téléphone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Date de naissance</label>
                    <input type="date" name="birth_date" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Genre</label>
                    <select name="gender" class="form-control">
                        <option value="">Sélectionner</option>
                        <option value="male">Homme</option>
                        <option value="female">Femme</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label>Adresse</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>
            
            <div class="mb-3">
                <label>Contact d'urgence</label>
                <input type="text" name="emergency_contact" class="form-control">
            </div>
            
            <div class="mb-3">
                <label>Notes médicales</label>
                <textarea name="medical_notes" class="form-control" rows="2"></textarea>
            </div>
            
            <div class="mb-3">
                <label>Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>
            

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection