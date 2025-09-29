@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="text-center">
    <h1 class="display-4 mb-4">Bienvenue sur notre Application SaaS</h1>
    <p class="lead mb-5">Une plateforme multi-tenant simple et pédagogique basée sur Laravel.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h2 class="card-title mb-4">Commencez dès maintenant</h2>
                    <p class="card-text mb-4">Connectez-vous pour gérer vos tenants ou créez un compte pour commencer.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('tenant.login', ['tenant' => $tenantId]) }}" class="btn btn-primary btn-lg px-4 me-md-2">Connexion</a>
                        <a href="{{ route('tenant.register', ['tenant' => $tenantId]) }}" class="btn btn-outline-primary btn-lg px-4">Inscription</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
