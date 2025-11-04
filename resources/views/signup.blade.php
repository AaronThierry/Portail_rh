<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    :root{
      --bg:#0f172a;        /* ardoise foncé */
      --card:#111827;      /* gris très foncé */
      --text:#e5e7eb;      /* gris clair */
      --muted:#9ca3af;     /* gris moyen */
      --primary:#3b82f6;   /* bleu */
      --ring:#60a5fa;
      --danger:#ef4444;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,"Helvetica Neue",Arial,"Noto Sans","Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
      background:
        radial-gradient(1200px 800px at 10% 10%, #1f2937 0%, transparent 60%),
        radial-gradient(1000px 600px at 90% 90%, #1f2937 0%, transparent 60%),
        var(--bg);
      color:var(--text);
      display:grid;
      place-items:center;
      padding:24px;
    }
    .card{
      width:100%;
      max-width:420px;
      background:var(--card);
      border:1px solid #1f2937;
      border-radius:20px;
      padding:28px;
      box-shadow:0 10px 30px rgba(0,0,0,.35);
    }
    h1{
      margin:0 0 6px;
      font-size:1.5rem;
      letter-spacing:.2px;
    }
    .sub{color:var(--muted); margin:0 0 22px; font-size:.95rem}
    .field{margin-bottom:14px}
    label{display:block; font-size:.9rem; margin-bottom:6px; color:#cbd5e1}
    input[type="text"],
    input[type="email"],
    input[type="password"]{
      width:100%;
      padding:12px 14px;
      border-radius:12px;
      border:1px solid #273042;
      background:#0b1220;
      color:var(--text);
      outline:none;
      transition:border .15s, box-shadow .15s, transform .02s;
    }
    input:focus{
      border-color:var(--ring);
      box-shadow:0 0 0 3px rgba(96,165,250,.25);
    }
    .pw-wrap{
      position:relative;
    }
    .toggle{
      position:absolute; right:10px; top:50%; transform:translateY(-50%);
      border:none; background:transparent; color:var(--muted);
      font-size:.85rem; cursor:pointer; padding:6px; border-radius:8px;
    }
    .toggle:focus{outline:2px solid var(--ring)}
    .actions{margin-top:16px}
    .btn{
      width:100%;
      padding:12px 14px;
      background:linear-gradient(180deg, var(--primary), #2563eb);
      color:white;
      border:none; border-radius:12px; cursor:pointer; font-weight:600;
      box-shadow:0 6px 18px rgba(37,99,235,.35);
      transition:transform .05s ease, box-shadow .15s ease;
    }
    .btn:active{transform:translateY(1px); box-shadow:0 4px 12px rgba(37,99,235,.35)}
    .helper{
      margin-top:12px; text-align:center; color:var(--muted); font-size:.9rem
    }
    .error{color:var(--danger); font-size:.85rem; margin-top:6px; display:none}
  </style>
</head>
<body>
  <main class="card" role="main">
    <header>
      <h1>Connexion</h1>
      <p class="sub">Accédez à votre espace sécurisé.</p>
    </header>

    <form id="loginForm" action="#" method="post" >
      <div class="field">
        <label for="name">Nom complet</label>
        <input id="name" name="name" type="text" placeholder="Ex. Raïssa Ouédraogo" autocomplete="name" required value=""/>
        <div class="error" id="err-name">Veuillez entrer votre nom.</div>
      </div>
      
       @csrf

      <div class="field">
        <label for="email">Adresse e-mail</label>
        <input id="email" name="email" type="email" placeholder="vous@exemple.com" autocomplete="email" required value=""/>
        <div class="error" id="err-email">Veuillez entrer un e-mail valide.</div>
      </div>

      <div class="field pw-wrap">
        <label for="password">Mot de passe</label>
        <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" minlength="6" required />
        <button class="toggle" type="button" aria-controls="password" aria-label="Afficher le mot de passe">Afficher</button>
        <div class="error" id="err-password">Au moins 6 caractères.</div>
      </div>

      <div class="actions">
        <button type="submit">S'inscrire</button>
      </div>

      <p class="helper">Pas de compte ? <a href="#" style="color:#93c5fd">Créer un compte</a></p>
    </form>
  </main>

</body>
</html>
