@extends('layouts.tenant')

@section('title', "Détails de l'utilisateur")

@section('content')
@php
    $tenantKey = tenant('id') ?? request()->route('tenant');
@endphp

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span>Détails de l'utilisateur</span>
                <div>
                    <a href="{{ route('users.edit', ['tenant' => $tenantKey, 'user' => $user->id]) }}" class="btn btn-sm btn-light me-2">Modifier</a>
                    <a href="{{ route('users.index', ['tenant' => $tenantKey]) }}" class="btn btn-sm btn-outline-light">Retour</a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold">ID :</div>
                    <div class="col-md-8">{{ $user->id }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold">Nom :</div>
                    <div class="col-md-8">{{ $user->name }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold">Email :</div>
                    <div class="col-md-8">{{ $user->email }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold">Créé le :</div>
                    <div class="col-md-8">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 fw-bold">Dernière mise à jour :</div>
                    <div class="col-md-8">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection