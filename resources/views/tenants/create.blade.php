@extends('layouts.app')

@section('title', 'Créer un Tenant')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Créer un nouveau Tenant</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tenants.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'organisation</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subdomain" class="form-label">Sous-domaine</label>
                        <div class="input-group">
                            <input id="subdomain" type="text" class="form-control @error('subdomain') is-invalid @enderror" name="subdomain" value="{{ old('subdomain') }}" required>
                            <span class="input-group-text">.app.test</span>
                        </div>
                        <div class="form-text">Le sous-domaine doit être unique et ne contenir que des lettres minuscules, des chiffres et des tirets.</div>
                        @error('subdomain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Créer le Tenant</button>
                        <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
