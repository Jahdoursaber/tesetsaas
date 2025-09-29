@extends('layouts.app')

@section('title', 'Gestion des Tenants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestion des Tenants</h1>
    <a href="{{ route('tenants.create') }}" class="btn btn-primary">Créer un Tenant</a>
</div>

@if($tenants->isEmpty())
    <div class="alert alert-info">
        Aucun tenant n'a été créé pour le moment.
    </div>
@else
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Domaines</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>{{ $tenant->name ?? $tenant->id }}</td>
                            <td>
                                <a href="{{ url('/t/'.$tenant->id) }}" class="text-decoration-none" target="_blank">
                                    {{ url('/t/'.$tenant->id) }}
                                </a>
                            </td>
                            <td>{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ url('/t/'.$tenant->id.'/login') }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">Visiter</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection
