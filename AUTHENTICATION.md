# Documentation d'Authentification - Portail RH

## Vue d'ensemble

Le système d'authentification de Portail RH utilise **Laravel Sanctum** pour gérer à la fois :
- L'authentification par **session** (pour les routes web)
- L'authentification par **token API** (pour les requêtes AJAX et API)

## Architecture

### 1. Middleware d'authentification

#### `SanctumAuth` (app/Http/Middleware/SanctumAuth.php)
Middleware personnalisé qui vérifie l'authentification via :
- **Guard 'web'** : Authentification par session (cookies)
- **Guard 'sanctum'** : Authentification par token API

```php
// Utilisation dans les routes
Route::middleware(['auth.sanctum'])->group(function () {
    Route::get('/dashboard', ...);
});
```

#### Comportement
- **Requête web** : Redirige vers `/login` si non authentifié
- **Requête JSON** : Retourne une erreur 401 avec message JSON

### 2. Configuration Kernel (app/Http/Kernel.php)

#### Middleware API activé
```php
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ...
],
```

#### Middleware alias ajouté
```php
'auth.sanctum' => \App\Http\Middleware\SanctumAuth::class,
```

### 3. Routes d'authentification (routes/web.php)

#### Routes publiques (guest)
```php
GET  /connexion  → Formulaire de connexion
GET  /login      → Alias pour connexion
POST /login      → Traitement de la connexion
```

#### Routes protégées (auth.sanctum)
```php
GET  /dashboard  → Tableau de bord
GET  /profile    → Profil utilisateur
POST /logout     → Déconnexion
GET  /logout     → Déconnexion alternative
```

### 4. UserController (app/Http/Controllers/UserController.php)

#### Méthodes disponibles

##### `loginform()`
Affiche le formulaire de connexion

##### `login(Request $request)`
Traite la connexion avec support web ET API :
- **Validation** des données (email + password)
- **Authentification** via `Auth::attempt()`
- **Session** : Redirection vers dashboard
- **API** : Retourne token + données utilisateur

```php
// Réponse API
{
    "message": "Connexion réussie",
    "user": {...},
    "token": "1|...",
    "redirect": "/dashboard"
}
```

##### `logout(Request $request)`
Déconnecte l'utilisateur :
- Supprime tous les tokens Sanctum
- Invalide la session
- Régénère le token CSRF

##### `profile(Request $request)`
Retourne les informations de l'utilisateur connecté

## Utilisation

### Authentification Web (Session)

#### 1. Connexion
L'utilisateur remplit le formulaire de login, le JavaScript envoie une requête AJAX :

```javascript
// login.js
const response = await fetch('/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({
        courrier: 'user@example.com',
        password: 'password123'
    })
});
```

#### 2. Accès aux routes protégées
Une fois connecté, l'utilisateur peut accéder aux routes protégées :
- La session est maintenue automatiquement via cookies
- Le middleware `auth.sanctum` vérifie l'authentification

#### 3. Déconnexion
```html
<form method="POST" action="/logout">
    @csrf
    <button type="submit">Déconnexion</button>
</form>
```

### Authentification API (Token)

#### 1. Obtenir un token
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "courrier": "user@example.com",
    "password": "password123"
  }'
```

Réponse :
```json
{
    "message": "connexion successful",
    "usertoken": "1|abcdef123456..."
}
```

#### 2. Utiliser le token
```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer 1|abcdef123456..."
```

#### 3. Routes API disponibles (routes/api.php)
```php
POST /api/register         → Inscription
POST /api/login            → Connexion (retourne token)
POST /api/forgot-password  → Demande réinitialisation
POST /api/reset-password   → Réinitialiser mot de passe
GET  /api/user             → Infos utilisateur (protégé)
```

## Sécurité

### CSRF Protection
- Toutes les routes web POST/PUT/DELETE nécessitent un token CSRF
- Token disponible via `<meta name="csrf-token">`

### Session Security
- Régénération de session après login (`$request->session()->regenerate()`)
- Invalidation de session au logout
- Régénération du token CSRF au logout

### Token Security
- Tokens hashés en base de données
- Suppression de tous les tokens au logout
- Expiration configurable dans `config/sanctum.php`

### Password Hashing
- Utilisation de `bcrypt()` pour hasher les mots de passe
- Vérification via `Hash::check()`

## Configuration

### Sanctum (config/sanctum.php)

#### Domaines stateful
```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1'
)),
```

#### Guards
```php
'guard' => ['web'],
```

#### Expiration des tokens
```php
'expiration' => null, // Jamais (par défaut)
```

### Variables d'environnement (.env)

```env
# Domaines autorisés pour les requêtes stateful
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1

# Session
SESSION_DRIVER=cookie
SESSION_LIFETIME=120

# Cookie
SESSION_DOMAIN=localhost
```

## Tests

### Test de connexion web
1. Accéder à `/connexion`
2. Remplir email et mot de passe
3. Valider → Redirection vers `/dashboard`

### Test de connexion API
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"courrier":"user@example.com","password":"password123"}'

# Utiliser le token
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer TOKEN_ICI"
```

### Test du middleware
```bash
# Sans authentification → Redirection ou 401
curl -X GET http://localhost:8000/dashboard

# Avec session → 200 OK
curl -X GET http://localhost:8000/dashboard \
  -H "Cookie: laravel_session=SESSION_ID"
```

## Dépannage

### Erreur "CSRF token mismatch"
- Vérifier que le token CSRF est inclus dans les requêtes
- Vérifier la configuration de session dans `.env`

### Erreur "Unauthenticated"
- Vérifier que l'utilisateur est bien connecté
- Vérifier que le token API est valide
- Vérifier que le middleware est bien appliqué

### Session ne persiste pas
- Vérifier `SESSION_DRIVER` dans `.env`
- Vérifier que les cookies sont activés
- Vérifier `SESSION_DOMAIN` correspond au domaine

## Ressources

- [Documentation Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)
- [Documentation Authentication Laravel](https://laravel.com/docs/10.x/authentication)
- [Sécurité Laravel](https://laravel.com/docs/10.x/security)
