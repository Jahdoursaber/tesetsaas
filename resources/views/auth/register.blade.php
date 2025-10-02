@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
@php
    $tenantKey = tenant('id') ?? ($tenant ?? request()->route('tenant'));
    $tenantName = tenant('name') ?? $tenant ?? 'Espace';
@endphp

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Inscription - {{ $tenantName }}</div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tenant.register.post', ['tenant' => $tenantKey]) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('tenant.login', ['tenant' => $tenantKey]) }}">Deja un compte ? Se connecter</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
