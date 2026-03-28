@extends('admin.layouts.app')

@section('title', 'Membres')
@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between">
        <h5 class="mb-0">Gestion des membres</h5>
        <a href="{{ route('admin.members.create') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i> Ajouter
        </a>
    </div>
    <div class="card-body">
        @if($members->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($members as $member)
                            <tr>
                                <td>#{{ $member->id }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone ?? '-' }}</td>
                                <td>
                                    @if($member->is_active)
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.members.show', $member->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $members->links() }}
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5>Aucun membre</h5>
                    <a href="{{ route('admin.members.create') }}" class="btn btn-primary mt-2">
                        Ajouter un membre
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endsection