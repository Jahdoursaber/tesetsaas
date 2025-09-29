<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>{{ config('app.name') }} - @yield('title','Accueil')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
@php
  // Si l'URL est /t/{tenant}/..., on récupère l'identifiant du tenant courant
  $currentTenant = request()->route('tenant');
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        @if (!$currentTenant)
          {{-- NAV CENTRALE (publique, pas d'auth centrale) --}}
          <li class="nav-item"><a class="nav-link" href="{{ route('tenants.index') }}">Tenants</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('tenants.create') }}">Créer un tenant</a></li>
        @else
          {{-- NAV TENANT (chemin /t/{tenant}/...) --}}
          @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('tenant.dashboard', ['tenant'=>$currentTenant]) }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('users.index', ['tenant'=>$currentTenant]) }}">Utilisateurs</a></li>
          @endauth
        @endif
      </ul>

      <ul class="navbar-nav">
        @if ($currentTenant)
          {{-- Auth TENANT uniquement --}}
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('tenant.login', ['tenant'=>$currentTenant]) }}">Connexion</a>
            </li>
            {{-- si tu autorises l'inscription du 1er owner côté tenant --}}
            <li class="nav-item">
              <a class="nav-link" href="{{ route('tenant.register', ['tenant'=>$currentTenant]) }}">Inscription</a>
            </li>
          @else
            <li class="nav-item">
              <form action="{{ route('tenant.logout', ['tenant'=>$currentTenant]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">Déconnexion</button>
              </form>
            </li>
          @endguest
        @else
          {{-- Pas d'auth centrale : propose juste la navigation centrale --}}
          <li class="nav-item">
            <a class="nav-link" href="{{ route('tenants.index') }}">Choisir un espace</a>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @yield('content')
</main>

<footer class="bg-light py-4 mt-5">
  <div class="container text-center">
    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
