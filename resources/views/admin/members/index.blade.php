@extends('admin.layouts.app')

@section('title', 'Membres')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Liste des membres</h5>
        <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $member->full_name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? '-' }}</td>
                    <td>
                        @if($member->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.members.show', $member) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $members->links() }}
    </div>
</div>
@endsection