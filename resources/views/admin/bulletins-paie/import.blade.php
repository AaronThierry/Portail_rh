@extends('layouts.app')

@section('title', 'Import automatique — Bulletins de paie')
@section('page-title', 'Import automatique')
@section('page-subtitle', 'Chargement des bulletins par archive ZIP')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
    <polyline points="17 8 12 3 7 8"/>
    <line x1="12" y1="3" x2="12" y2="15"/>
</svg>
@endsection

@section('styles')
<style>
:root {
    --imp-primary: #4A90D9;
    --imp-primary-dark: #2E6BB3;
    --imp-primary-light: #E8F4FD;
    --imp-success: #22C55E;
    --imp-success-light: #F0FDF4;
    --imp-warning: #F59E0B;
    --imp-warning-light: #FFFBEB;
    --imp-danger: #EF4444;
    --imp-danger-light: #FEF2F2;
    --imp-bg: #f8fafc;
    --imp-card-bg: #ffffff;
    --imp-card-border: #e2e8f0;
    --imp-text: #1e293b;
    --imp-text-muted: #64748b;
}
.dark {
    --imp-bg: #0f172a;
    --imp-card-bg: #1e293b;
    --imp-card-border: #334155;
    --imp-text: #f1f5f9;
    --imp-text-muted: #94a3b8;
    --imp-primary-light: rgba(74,144,217,.15);
    --imp-success-light: rgba(34,197,94,.15);
    --imp-warning-light: rgba(245,158,11,.15);
    --imp-danger-light: rgba(239,68,68,.15);
}

.import-page { padding: 1.5rem; max-width: 900px; margin: 0 auto; }

/* Breadcrumb */
.imp-breadcrumb {
    display: flex; align-items: center; gap: .5rem;
    margin-bottom: 1.5rem; font-size: .875rem; color: var(--imp-text-muted);
}
.imp-breadcrumb a { color: var(--imp-primary); text-decoration: none; }
.imp-breadcrumb a:hover { text-decoration: underline; }

/* Cards */
.imp-card {
    background: var(--imp-card-bg);
    border: 1px solid var(--imp-card-border);
    border-radius: 12px;
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.04);
}
.imp-card-title {
    font-size: 1.1rem; font-weight: 600; color: var(--imp-text);
    margin: 0 0 1.25rem; display: flex; align-items: center; gap: .6rem;
}
.imp-card-title svg { width: 20px; height: 20px; color: var(--imp-primary); }

/* Convention de nommage */
.naming-box {
    background: var(--imp-primary-light);
    border: 1px solid rgba(74,144,217,.25);
    border-radius: 8px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.25rem;
}
.naming-box code {
    display: block; font-family: monospace; font-size: .875rem;
    color: var(--imp-primary-dark); margin: .25rem 0;
}
.naming-box p { margin: 0 0 .5rem; font-size: .8rem; color: var(--imp-text-muted); }
.naming-example { font-size: .8rem; color: var(--imp-text-muted); margin-top: .75rem; }
.naming-example span { display: block; font-family: monospace; padding: .1rem 0; }

/* Form */
.imp-form-group { margin-bottom: 1.25rem; }
.imp-label {
    display: block; margin-bottom: .4rem;
    font-size: .875rem; font-weight: 500; color: var(--imp-text);
}
.imp-label span { color: #ef4444; }
.imp-select, .imp-input {
    width: 100%; padding: .6rem .9rem;
    border: 1px solid var(--imp-card-border); border-radius: 8px;
    background: var(--imp-card-bg); color: var(--imp-text);
    font-size: .9rem; outline: none;
    transition: border-color .2s;
}
.imp-select:focus, .imp-input:focus { border-color: var(--imp-primary); }

/* Drop zone */
.drop-zone {
    border: 2px dashed var(--imp-card-border);
    border-radius: 10px; padding: 2.5rem 1.5rem;
    text-align: center; cursor: pointer;
    transition: all .2s; position: relative;
}
.drop-zone:hover, .drop-zone.drag-over {
    border-color: var(--imp-primary);
    background: var(--imp-primary-light);
}
.drop-zone svg { width: 40px; height: 40px; color: var(--imp-text-muted); margin-bottom: .75rem; }
.drop-zone p { margin: 0; color: var(--imp-text-muted); font-size: .9rem; }
.drop-zone p strong { color: var(--imp-primary); }
.drop-zone small { color: var(--imp-text-muted); font-size: .8rem; }
.drop-zone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
}
.drop-zone.has-file { border-color: var(--imp-success); background: var(--imp-success-light); }
.drop-zone.has-file svg { color: var(--imp-success); }

/* Checkbox */
.imp-check-row {
    display: flex; align-items: center; gap: .6rem;
    font-size: .9rem; color: var(--imp-text); cursor: pointer;
}
.imp-check-row input { width: 16px; height: 16px; accent-color: var(--imp-primary); }

/* Button */
.imp-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .7rem 1.5rem; border: none; border-radius: 8px;
    font-size: .9rem; font-weight: 600; cursor: pointer;
    transition: all .2s;
}
.imp-btn-primary {
    background: var(--imp-primary); color: #fff;
}
.imp-btn-primary:hover { background: var(--imp-primary-dark); }
.imp-btn-primary:disabled { opacity: .6; cursor: not-allowed; }
.imp-btn-secondary {
    background: transparent; color: var(--imp-text-muted);
    border: 1px solid var(--imp-card-border);
}
.imp-btn-secondary:hover { background: var(--imp-bg); }
.imp-btn svg { width: 18px; height: 18px; }

/* Result banner */
.imp-result {
    border-radius: 10px; padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex; flex-direction: column; gap: .5rem;
}
.imp-result.success { background: var(--imp-success-light); border: 1px solid rgba(34,197,94,.3); }
.imp-result.warning { background: var(--imp-warning-light); border: 1px solid rgba(245,158,11,.3); }
.imp-result.danger  { background: var(--imp-danger-light);  border: 1px solid rgba(239,68,68,.3); }
.imp-result-title {
    font-weight: 600; font-size: 1rem; display: flex; align-items: center; gap: .5rem;
}
.imp-result.success .imp-result-title { color: #15803d; }
.imp-result.warning .imp-result-title { color: #b45309; }
.imp-result.danger  .imp-result-title { color: #b91c1c; }
.imp-result-stats { display: flex; gap: 1.5rem; font-size: .875rem; flex-wrap: wrap; }
.imp-result-stat { display: flex; align-items: center; gap: .35rem; }
.imp-result-errors { margin-top: .5rem; }
.imp-result-errors ul { margin: .25rem 0 0; padding-left: 1.25rem; font-size: .8rem; }
.imp-result-errors li { margin-bottom: .2rem; }

/* Historique */
.imp-hist-table { width: 100%; border-collapse: collapse; font-size: .875rem; }
.imp-hist-table th {
    text-align: left; padding: .6rem .9rem;
    color: var(--imp-text-muted); font-weight: 500; font-size: .8rem;
    border-bottom: 1px solid var(--imp-card-border);
}
.imp-hist-table td {
    padding: .75rem .9rem; border-bottom: 1px solid var(--imp-card-border);
    color: var(--imp-text);
}
.imp-hist-table tr:last-child td { border-bottom: none; }
.badge {
    display: inline-block; padding: .2rem .6rem; border-radius: 20px;
    font-size: .75rem; font-weight: 600;
}
.badge-success { background: var(--imp-success-light); color: #15803d; }
.badge-warning  { background: var(--imp-warning-light); color: #b45309; }
.badge-danger   { background: var(--imp-danger-light);  color: #b91c1c; }
.badge-secondary { background: #f1f5f9; color: #64748b; }
</style>
@endsection

@section('content')
<div class="import-page">

    {{-- Breadcrumb --}}
    <nav class="imp-breadcrumb">
        <a href="{{ route('admin.bulletins-paie.index') }}">Bulletins de paie</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
        <span>Import automatique</span>
    </nav>

    {{-- Résultat de l'import précédent --}}
    @if(session('import_result'))
        @php
            $res    = session('import_result');
            $statut = session('import_statut', 'termine');
            $cls    = $statut === 'echec' ? 'danger' : ($statut === 'partiel' ? 'warning' : 'success');
            $icon   = $statut === 'echec' ? '❌' : ($statut === 'partiel' ? '⚠️' : '✅');
            $label  = $statut === 'echec' ? 'Import échoué' : ($statut === 'partiel' ? 'Import partiel' : 'Import terminé');
        @endphp
        <div class="imp-result {{ $cls }}">
            <div class="imp-result-title">{{ $icon }} {{ $label }}</div>
            <div class="imp-result-stats">
                <div class="imp-result-stat">📄 <strong>{{ $res['total'] }}</strong> fichiers traités</div>
                <div class="imp-result-stat">✅ <strong>{{ $res['succes'] }}</strong> bulletins créés</div>
                <div class="imp-result-stat">⏭️ <strong>{{ $res['doublons'] }}</strong> doublons ignorés</div>
                <div class="imp-result-stat">❌ <strong>{{ count($res['erreurs']) }}</strong> erreurs</div>
            </div>
            @if(!empty($res['erreurs']))
                <div class="imp-result-errors">
                    <strong>Détail des erreurs :</strong>
                    <ul>
                        @foreach($res['erreurs'] as $err)
                            <li><strong>{{ $err['fichier'] }}</strong> — {{ $err['raison'] }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="imp-result danger">
            <div class="imp-result-title">❌ Erreur</div>
            <p style="margin:0;font-size:.9rem;">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Formulaire d'import --}}
    <div class="imp-card">
        <h2 class="imp-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <polyline points="17 8 12 3 7 8"/>
                <line x1="12" y1="3" x2="12" y2="15"/>
            </svg>
            Importer une archive ZIP de bulletins
        </h2>

        {{-- Convention de nommage --}}
        <div class="naming-box">
            <p>Convention de nommage requise pour les PDFs dans le ZIP :</p>
            <code>Bulletin_{Matricule}_{NomPrenom}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf</code>
            <div class="naming-example">
                <span>Bulletin_EMP001_Jean_Dupont_2024-01-01_au_2024-01-31.pdf</span>
                <span>Bulletin_MAT123_Marie_Martin_2024-02-01_au_2024-02-29.pdf</span>
                <span>Bulletin_SANS_MATRICULE_Pierre_Bernard_2024-03-01_au_2024-03-31.pdf</span>
            </div>
            <p style="margin-top:.75rem;">Optionnel : ajouter un fichier <code style="background:none;display:inline;padding:0;color:inherit;">salaires.csv</code> dans le ZIP pour les montants (matricule,salaire_brut,salaire_net).</p>
        </div>

        <form action="{{ route('admin.bulletins-paie.import.store') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf

            <div class="imp-form-group">
                <label class="imp-label" for="entreprise_id">Entreprise <span>*</span></label>
                <select name="entreprise_id" id="entreprise_id" class="imp-select" required>
                    <option value="">— Choisir une entreprise —</option>
                    @foreach($entreprises as $ent)
                        <option value="{{ $ent->id }}" {{ old('entreprise_id') == $ent->id ? 'selected' : '' }}>
                            {{ $ent->nom }}
                        </option>
                    @endforeach
                </select>
                @error('entreprise_id')
                    <small style="color:var(--imp-danger);">{{ $message }}</small>
                @enderror
            </div>

            <div class="imp-form-group">
                <label class="imp-label">Archive ZIP <span>*</span></label>
                <div class="drop-zone" id="dropZone">
                    <input type="file" name="fichier_zip" id="fichierZip" accept=".zip" required>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <p id="dropLabel">Glissez votre ZIP ici ou <strong>cliquez pour choisir</strong></p>
                    <small>Format accepté : .zip — Taille max : 100 Mo</small>
                </div>
                @error('fichier_zip')
                    <small style="color:var(--imp-danger);">{{ $message }}</small>
                @enderror
            </div>

            <div class="imp-form-group">
                <label class="imp-check-row">
                    <input type="checkbox" name="notifier" value="1" {{ old('notifier') ? 'checked' : '' }}>
                    Notifier les employés après import (WhatsApp + notification)
                </label>
            </div>

            <div style="display:flex;gap:.75rem;align-items:center;">
                <button type="submit" class="imp-btn imp-btn-primary" id="submitBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    Lancer l'import
                </button>
                <a href="{{ route('admin.bulletins-paie.index') }}" class="imp-btn imp-btn-secondary">
                    Annuler
                </a>
                <span id="progressMsg" style="display:none;color:var(--imp-text-muted);font-size:.875rem;">
                    Traitement en cours, veuillez patienter...
                </span>
            </div>
        </form>
    </div>

    {{-- Historique --}}
    @if($historique->isNotEmpty())
    <div class="imp-card">
        <h2 class="imp-card-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="12 8 12 12 14 14"/>
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5"/>
            </svg>
            Historique des imports récents
        </h2>
        <table class="imp-hist-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Entreprise</th>
                    <th>Par</th>
                    <th>Total</th>
                    <th>Succès</th>
                    <th>Doublons</th>
                    <th>Erreurs</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historique as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->entreprise?->nom ?? '—' }}</td>
                    <td>{{ $log->uploadedBy?->name ?? '—' }}</td>
                    <td>{{ $log->total }}</td>
                    <td style="color:var(--imp-success);font-weight:600;">{{ $log->succes }}</td>
                    <td style="color:var(--imp-warning);">{{ $log->doublons }}</td>
                    <td style="color:var(--imp-danger);">{{ $log->erreurs_count }}</td>
                    <td>
                        @php
                            $bcolor = match($log->statut) {
                                'termine'  => 'success',
                                'partiel'  => 'warning',
                                'echec'    => 'danger',
                                default    => 'secondary',
                            };
                        @endphp
                        <span class="badge badge-{{ $bcolor }}">{{ $log->statut_label }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
const dropZone  = document.getElementById('dropZone');
const fileInput = document.getElementById('fichierZip');
const dropLabel = document.getElementById('dropLabel');
const form      = document.getElementById('importForm');
const submitBtn = document.getElementById('submitBtn');
const progressMsg = document.getElementById('progressMsg');

// Drag & drop
dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('drag-over'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
dropZone.addEventListener('drop', e => {
    e.preventDefault();
    dropZone.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
        updateDropLabel(file);
    }
});

fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) updateDropLabel(fileInput.files[0]);
});

function updateDropLabel(file) {
    const size = (file.size / 1024 / 1024).toFixed(2);
    dropLabel.innerHTML = `<strong>${file.name}</strong> (${size} Mo)`;
    dropZone.classList.add('has-file');
}

// Désactiver le bouton pendant l'upload
form.addEventListener('submit', () => {
    submitBtn.disabled = true;
    progressMsg.style.display = 'inline';
    submitBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite;width:18px;height:18px;">
            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
        </svg>
        Traitement...
    `;
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection
