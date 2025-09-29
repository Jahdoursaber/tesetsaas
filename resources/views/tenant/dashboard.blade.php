@extends('layouts.tenant')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Bienvenue sur votre Dashboard, {{ $user->name }}</h2>
                <p class="card-text">Vous êtes connecté à l'espace de {{ $tenant->name ?? $tenant->id }}.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h3 class="card-title">Gestion des utilisateurs</h3>
                <p class="card-text">Gérez les utilisateurs de votre espace.</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Voir les utilisateurs</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h3 class="card-title">Votre profil</h3>
                <p class="card-text">Informations sur votre compte.</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Nom :</strong> {{ $user->name }}</li>
                    <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>
                    <li class="list-group-item"><strong>Membre depuis :</strong> {{ $user->created_at->format('d/m/Y') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
