@extends('layouts.app')

@section('title', 'Bulletins de Paie')
@section('page-title', 'Bulletins de paie')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
    <polyline points="14 2 14 8 20 8"/>
    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
</svg>
@endsection

@section('styles')
<style>
    /* ── Calendrier annuel ── */
    .bp-tl { background: var(--surface); border-radius: var(--radius-lg); box-shadow: 0 0 0 1px var(--line-soft); padding: 16px 18px; }
    .bp-tl-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 10px; }
    .bp-tl-head .rh-select { width: auto; min-height: 38px; padding: 6px 30px 6px 12px; font-size: 13px; }
    .bp-month-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 6px; }
    .bp-month {
        display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 10px 4px 8px;
        border-radius: 10px; border: 1px solid transparent; text-decoration: none; transition: all .15s;
    }
    .bp-month:hover { background: var(--page); border-color: var(--line-soft); }
    .bp-month.active { background: var(--brand); border-color: var(--brand); }
    .bp-month.is-future { opacity: .4; pointer-events: none; }
    .bp-month-name { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: var(--muted); }
    .bp-month.active .bp-month-name { color: #fff; }
    .bp-month-count { font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 5px; background: var(--brand-bg); color: var(--brand-dk); min-width: 16px; text-align: center; }
    .bp-month.active .bp-month-count { background: rgba(255,255,255,.25); color: #fff; }
    .bp-month-dot { width: 4px; height: 4px; border-radius: 50%; background: var(--line-soft); }
    @media (max-width: 1024px) { .bp-month-grid { grid-template-columns: repeat(6, 1fr); } }
    @media (max-width: 560px) { .bp-month-grid { grid-template-columns: repeat(4, 1fr); } }

    /* ── Filtres ── */
    .bp-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .bp-toolbar .rh-input { max-width: 300px; min-height: 44px; }

    /* ── Tableau ── */
    .bp-table-wrap { overflow-x: auto; }
    .bp-table { width: 100%; border-collapse: collapse; font-size: 14px; }
    .bp-table thead th {
        padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--faint);
        text-transform: uppercase; letter-spacing: .06em; white-space: nowrap; border-bottom: 1px solid var(--line-soft);
    }
    .bp-table tbody tr { border-top: 1px solid var(--line-soft); }
    .bp-table tbody tr:first-child { border-top: 0; }
    .bp-table tbody tr:hover { background: var(--page); }
    .bp-table tbody td { padding: 11px 16px; color: var(--ink); vertical-align: middle; white-space: nowrap; }
    .bp-person { display: flex; align-items: center; gap: 12px; }
    .bp-av { width: 36px; height: 36px; border-radius: 999px; flex-shrink: 0; background: var(--ink); color: #fff; display: flex; align-items: center; justify-content: center; font-family: var(--display); font-weight: 700; font-size: 12px; }
    .dark .bp-av { color: var(--page); }
    .bp-pname { font-weight: 600; display: block; line-height: 1.3; }
    .bp-pmat { font-size: 12px; color: var(--faint); display: block; }
    .bp-act { width: 34px; height: 34px; border-radius: 10px; border: 0; background: transparent; color: var(--muted); display: inline-flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; }
    .bp-act svg { width: 16px; height: 16px; }
    .bp-act:hover { background: var(--subtle); color: var(--ink); }
    .bp-act.del:hover { background: var(--no-bg); color: var(--no); }

    /* ── Sélecteur employé (recherche) ── */
    .bp-ss { position: relative; }
    .bp-ss-dd {
        position: absolute; top: calc(100% + 6px); left: 0; right: 0; z-index: 60;
        background: var(--surface); border: 1px solid var(--line-soft); border-radius: var(--radius);
        box-shadow: 0 16px 48px rgba(15,23,42,.16); max-height: 220px; overflow-y: auto; display: none;
    }
    .bp-ss-dd.open { display: block; }
    .bp-ss-opt { padding: 10px 14px; cursor: pointer; font-size: 14px; }
    .bp-ss-opt:hover, .bp-ss-opt.selected { background: var(--subtle); }
    .bp-ss-opt.hidden { display: none; }
    .bp-ss-empty { padding: 14px; text-align: center; font-size: 13px; color: var(--muted); }

    .bp-upload-zone { border: 2px dashed var(--line); border-radius: var(--radius); padding: 24px 16px; text-align: center; cursor: pointer; position: relative; }
    .bp-upload-zone.dragover { border-color: var(--brand); background: var(--brand-bg); }
    .bp-upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .bp-file-preview { display: none; align-items: center; gap: 12px; padding: 10px 14px; background: var(--brand-bg); border: 1px solid var(--brand-soft); border-radius: var(--radius); margin-top: 10px; }
    .bp-file-preview.show { display: flex; }
    .bp-file-info { flex: 1; min-width: 0; }
    .bp-file-name { font-size: 14px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .bp-file-size { font-size: 12px; color: var(--muted); }
</style>
@endsection

@section('content')
<div class="rh-page">
    @if(session('success'))
        <div class="rh-alert ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg><span>{{ session('success') }}</span></div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5M12 16h.01"/></svg><span>{{ session('error') }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Bulletins de paie · {{ $anneeSelectionnee }}</h1>
            <p class="rh-lead">{{ $stats['total_employes'] }} employé{{ $stats['total_employes'] > 1 ? 's' : '' }} couvert{{ $stats['total_employes'] > 1 ? 's' : '' }} — {{ $stats['total_bulletins'] }} bulletin{{ $stats['total_bulletins'] > 1 ? 's' : '' }}.</p>
        </div>
        <div class="rh-actions">
            <a href="{{ route('admin.bulletins-paie.export', ['annee' => $anneeSelectionnee]) }}" class="rh-btn soft">Exporter</a>
            <a href="{{ route('admin.bulletins-paie.import.index') }}" class="rh-btn soft">Import ZIP</a>
            <button type="button" class="rh-btn" onclick="openUploadModal()">Nouveau bulletin</button>
        </div>
    </section>

    <div class="rh-figures">
        <div class="rh-figure"><strong>{{ $stats['total_bulletins'] }}</strong><span>bulletins {{ $anneeSelectionnee }}</span></div>
        <div class="rh-figure"><strong>{{ $stats['total_employes'] }}</strong><span>employés couverts</span></div>
        <div class="rh-figure"><strong>{{ $stats['total_bulletins'] > 0 ? (int) ceil($stats['total_bulletins'] / max($stats['total_employes'], 1)) : 0 }}</strong><span>bulletins / employé en moyenne</span></div>
    </div>

    <div class="bp-tl">
        <div class="bp-tl-head">
            <h2 class="rh-h2">Calendrier {{ $anneeSelectionnee }}</h2>
            <div style="display:flex; align-items:center; gap:10px">
                @if($moisSelectionne)
                    <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee]) }}" class="rh-link">Tous les mois</a>
                @endif
                <form method="GET" action="{{ route('admin.bulletins-paie.index') }}">
                    @if($search)<input type="hidden" name="search" value="{{ $search }}">@endif
                    <select name="annee" class="rh-select" onchange="this.form.submit()">
                        @foreach($anneesDisponibles as $annee)
                            <option value="{{ $annee }}" {{ $annee == $anneeSelectionnee ? 'selected' : '' }}>{{ $annee }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
        <div class="bp-month-grid">
            @foreach($timeline as $num => $data)
                @php
                    $isFuture = $anneeSelectionnee == date('Y') && $num > date('n');
                    $hasData = $data['total'] > 0;
                    $isActive = $moisSelectionne == $num;
                    $url = route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee, 'mois' => $num, 'search' => $search]);
                    $classes = 'bp-month' . ($isActive ? ' active' : '') . ($isFuture ? ' is-future' : '');
                @endphp
                <a href="{{ $isFuture ? '#' : $url }}" class="{{ $classes }}">
                    <span class="bp-month-name">{{ $data['mois_court'] }}</span>
                    @if($hasData)
                        <span class="bp-month-count">{{ $data['total'] }}</span>
                    @else
                        <span class="bp-month-dot"></span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <form method="GET" action="{{ route('admin.bulletins-paie.index') }}">
        @if($anneeSelectionnee)<input type="hidden" name="annee" value="{{ $anneeSelectionnee }}">@endif
        @if($moisSelectionne)<input type="hidden" name="mois" value="{{ $moisSelectionne }}">@endif
        <div class="bp-toolbar">
            <input type="text" name="search" class="rh-input" placeholder="Rechercher par employé, matricule…" value="{{ $search }}">
            <button type="submit" class="rh-btn sm">Rechercher</button>
            @if($moisSelectionne || $search)
                <a href="{{ route('admin.bulletins-paie.index', ['annee' => $anneeSelectionnee]) }}" class="rh-link">Réinitialiser</a>
            @endif
        </div>
    </form>

    <section class="rh-section">
        <div class="rh-section-head">
            <h2 class="rh-h2">Bulletins</h2>
            @if($bulletins->total() > 0)<span class="rh-badge off">{{ $bulletins->total() }}</span>@endif
        </div>

        <div class="rh-card-flat">
            @if($bulletins->count() > 0)
            <div class="bp-table-wrap">
                <table class="bp-table">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Période</th>
                            <th>Taille</th>
                            <th>Salaire net</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bulletins as $bulletin)
                            @php
                                $initials = collect(explode(' ', $bulletin->personnel->nom_complet))->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
                            @endphp
                            <tr>
                                <td>
                                    <div class="bp-person">
                                        <span class="bp-av" aria-hidden="true">{{ $initials }}</span>
                                        <div>
                                            <span class="bp-pname">{{ $bulletin->personnel->nom_complet }}</span>
                                            <span class="bp-pmat">{{ $bulletin->personnel->matricule }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="rh-badge info">{{ $bulletin->mois_court }} {{ $bulletin->annee }}</span></td>
                                <td>{{ $bulletin->fichier_taille_formatee }}</td>
                                <td>{{ $bulletin->salaire_net ? number_format($bulletin->salaire_net, 0, ',', ' ') . ' FCFA' : '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.bulletins-paie.preview', $bulletin) }}" target="_blank" class="bp-act" title="Aperçu">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.bulletins-paie.download', $bulletin) }}" class="bp-act" title="Télécharger">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.bulletins-paie.destroy', $bulletin) }}" data-confirm="Supprimer ce bulletin ?" style="display:inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bp-act del" title="Supprimer">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <div class="rh-empty">
                    <strong>Aucun bulletin trouvé</strong>
                    <p>
                        @if($search || $moisSelectionne)
                            Aucun résultat pour ces filtres. Modifiez votre recherche ou sélectionnez un autre mois.
                        @else
                            Commencez par ajouter un premier bulletin de paie.
                        @endif
                    </p>
                    <button type="button" class="rh-btn" onclick="openUploadModal()">Ajouter un bulletin</button>
                </div>
            @endif
        </div>

        @if($bulletins->hasPages())
            <div style="display:flex; justify-content:center">
                {{ $bulletins->appends(request()->query())->links() }}
            </div>
        @endif
    </section>
</div>

{{-- ── Nouveau bulletin ── --}}
<div class="rh-sheet" id="uploadModal" role="dialog" aria-modal="true" aria-labelledby="uploadTitre">
    <div class="rh-sheet-box">
        <div class="rh-sheet-grip"></div>
        <div class="rh-sheet-head">
            <div>
                <h2 id="uploadTitre">Ajouter un bulletin de paie</h2>
                <p>Fiche de paie au format PDF.</p>
            </div>
            <button type="button" class="rh-iconbtn" onclick="closeUploadModal()" aria-label="Fermer">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.bulletins-paie.store') }}" enctype="multipart/form-data" class="rh-form">
            @csrf
            @if($errors->any())
                <div class="rh-alert err" role="alert">{{ $errors->first() }}</div>
            @endif

            <div class="rh-field">
                <label>Employé</label>
                <div class="bp-ss" id="personnelSelectWrap">
                    <input type="hidden" name="personnel_id" id="personnelId" value="{{ old('personnel_id') }}">
                    <input type="text" class="rh-input" id="personnelSearch" placeholder="Rechercher un employé…" autocomplete="off">
                    <div class="bp-ss-dd" id="personnelDropdown">
                        @foreach($personnels as $p)
                            <div class="bp-ss-opt" data-value="{{ $p->id }}" data-label="{{ $p->matricule }} — {{ $p->nom_complet }}">{{ $p->matricule }} — {{ $p->nom_complet }}</div>
                        @endforeach
                        <div class="bp-ss-empty" id="ssNoResults" style="display:none">Aucun résultat</div>
                    </div>
                </div>
                @error('personnel_id')<p class="rh-err">{{ $message }}</p>@enderror
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label>Mois</label>
                    <select name="mois" class="rh-select">
                        <option value="">Sélectionner…</option>
                        @foreach(\App\Models\BulletinPaie::MOIS_NOMS as $num => $nom)
                            <option value="{{ $num }}" {{ old('mois', $moisSelectionne) == $num ? 'selected' : '' }}>{{ $nom }}</option>
                        @endforeach
                    </select>
                    @error('mois')<p class="rh-err">{{ $message }}</p>@enderror
                </div>
                <div class="rh-field">
                    <label>Année</label>
                    <select name="annee" class="rh-select">
                        <option value="">Sélectionner…</option>
                        @foreach(range(date('Y'), date('Y') - 5) as $a)
                            <option value="{{ $a }}" {{ old('annee', $anneeSelectionnee) == $a ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                    @error('annee')<p class="rh-err">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="rh-grid2">
                <div class="rh-field">
                    <label>Salaire brut <span class="rh-opt">(FCFA)</span></label>
                    <input type="number" name="salaire_brut" class="rh-input" placeholder="0" value="{{ old('salaire_brut') }}" min="0" step="500">
                </div>
                <div class="rh-field">
                    <label>Salaire net <span class="rh-opt">(FCFA)</span></label>
                    <input type="number" name="salaire_net" class="rh-input" placeholder="0" value="{{ old('salaire_net') }}" min="0" step="500">
                </div>
            </div>

            <div class="rh-field">
                <label>Fichier PDF</label>
                <div class="bp-upload-zone" id="uploadZone">
                    <input type="file" name="fichier" id="fileInput" accept=".pdf">
                    <strong style="display:block; margin-bottom:4px">Glissez votre PDF ici</strong>
                    <span class="rh-hint">ou cliquez pour parcourir · PDF uniquement · max 10 Mo</span>
                </div>
                <div class="bp-file-preview" id="filePreview">
                    <div class="bp-file-info">
                        <div class="bp-file-name" id="fileName"></div>
                        <div class="bp-file-size" id="fileSize"></div>
                    </div>
                    <button type="button" class="rh-iconbtn" id="removeFile" aria-label="Retirer le fichier" style="width:32px; height:32px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
                    </button>
                </div>
                @error('fichier')<p class="rh-err">{{ $message }}</p>@enderror
            </div>

            <div class="rh-field">
                <label style="display:flex; align-items:flex-start; gap:10px; font-weight: 400; cursor: pointer">
                    <input type="checkbox" name="visible_employe" value="1" {{ old('visible_employe', '1') == '1' ? 'checked' : '' }} style="margin-top:3px">
                    <span><strong>Rendre visible à l'employé</strong> — il pourra consulter ce bulletin depuis son espace.</span>
                </label>
            </div>

            <div class="rh-field">
                <label>Commentaire <span class="rh-opt">(facultatif)</span></label>
                <textarea name="commentaire" class="rh-textarea" placeholder="Note interne ou message pour l'employé…">{{ old('commentaire') }}</textarea>
            </div>

            <div class="rh-sheet-foot">
                <button type="button" class="rh-btn soft" onclick="closeUploadModal()">Annuler</button>
                <button type="submit" class="rh-btn">Enregistrer le bulletin</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
/* ── Modal ── */
function openUploadModal() {
    document.getElementById('uploadModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeUploadModal() {
    document.getElementById('uploadModal').classList.remove('open');
    document.body.style.overflow = '';
}
document.getElementById('uploadModal').addEventListener('click', function (e) {
    if (e.target === this) closeUploadModal();
});
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeUploadModal();
});

/* ── File upload drag-drop ── */
const zone = document.getElementById('uploadZone');
const input = document.getElementById('fileInput');
const prev = document.getElementById('filePreview');
const fname = document.getElementById('fileName');
const fsize = document.getElementById('fileSize');
const rmBtn = document.getElementById('removeFile');

zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault(); zone.classList.remove('dragover');
    if (e.dataTransfer.files[0]) displayFile(e.dataTransfer.files[0]);
});
input.addEventListener('change', () => { if (input.files[0]) displayFile(input.files[0]); });

rmBtn.addEventListener('click', e => {
    e.preventDefault();
    input.value = '';
    prev.classList.remove('show');
    zone.style.display = '';
});

function displayFile(file) {
    if (file.type !== 'application/pdf') {
        alert('Veuillez sélectionner un fichier PDF uniquement.');
        input.value = '';
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        alert('Le fichier dépasse la limite de 10 Mo.');
        input.value = '';
        return;
    }
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    fname.textContent = file.name;
    fsize.textContent = formatFileSize(file.size);
    prev.classList.add('show');
    zone.style.display = 'none';
}

function formatFileSize(b) {
    if (b < 1024) return b + ' o';
    if (b < 1024 * 1024) return (b / 1024).toFixed(1) + ' Ko';
    return (b / (1024 * 1024)).toFixed(1) + ' Mo';
}

/* ── Sélecteur employé (recherche) ── */
const searchInput = document.getElementById('personnelSearch');
const hiddenInput = document.getElementById('personnelId');
const dropdown = document.getElementById('personnelDropdown');
const noResults = document.getElementById('ssNoResults');
const opts = dropdown.querySelectorAll('.bp-ss-opt');
let selectedLabel = '';

function openDropdown() { dropdown.classList.add('open'); }
function closeDropdown() { dropdown.classList.remove('open'); }

searchInput.addEventListener('focus', openDropdown);
searchInput.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    let visible = 0;
    opts.forEach(o => {
        const match = o.dataset.label.toLowerCase().includes(q);
        o.classList.toggle('hidden', !match);
        if (match) visible++;
    });
    noResults.style.display = visible === 0 ? '' : 'none';
    if (!q) { hiddenInput.value = ''; selectedLabel = ''; }
    openDropdown();
});

opts.forEach(o => {
    o.addEventListener('mousedown', e => {
        e.preventDefault();
        opts.forEach(x => x.classList.remove('selected'));
        o.classList.add('selected');
        hiddenInput.value = o.dataset.value;
        searchInput.value = o.dataset.label;
        selectedLabel = o.dataset.label;
        closeDropdown();
    });
});

document.addEventListener('click', e => {
    if (!document.getElementById('personnelSelectWrap').contains(e.target)) {
        searchInput.value = hiddenInput.value ? selectedLabel : '';
        closeDropdown();
    }
});

@if(old('personnel_id'))
(function () {
    const oldId = "{{ old('personnel_id') }}";
    const opt = dropdown.querySelector(`.bp-ss-opt[data-value="${oldId}"]`);
    if (opt) {
        hiddenInput.value = oldId;
        searchInput.value = opt.dataset.label;
        selectedLabel = opt.dataset.label;
        opt.classList.add('selected');
    }
})();
@endif

document.querySelector('#uploadModal form').addEventListener('submit', function (e) {
    if (!hiddenInput.value) {
        e.preventDefault();
        searchInput.focus();
    }
});

@if($errors->any())
openUploadModal();
@endif
</script>
@endsection
