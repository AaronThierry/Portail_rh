@extends('layouts.app')

@section('title', 'Import en lot — Bulletins de paie')
@section('page-title', 'Import en lot')

@section('styles')
<style>
    .bi-steps { display: flex; gap: 8px; margin-bottom: 18px; }
    .bi-steps li { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--faint); }
    .bi-steps .bi-num { width: 24px; height: 24px; border-radius: 999px; background: var(--subtle); color: var(--muted); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .bi-steps li.active { color: var(--ink); }
    .bi-steps li.active .bi-num { background: var(--brand); color: #fff; }
    .bi-steps li.done .bi-num { background: var(--ok); color: #fff; }
    .bi-steps li:not(:last-child)::after { content: ''; width: 24px; height: 1px; background: var(--line-soft); margin-left: 4px; }

    .bi-grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); margin-bottom: 18px; }

    .bi-drop {
        border: 2px dashed var(--line); border-radius: var(--radius); padding: 28px 16px; text-align: center;
        cursor: pointer; position: relative; grid-column: 1 / -1;
    }
    .bi-drop.dragover, .bi-drop.has-file { border-color: var(--brand); background: var(--brand-bg); }
    .bi-drop input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .bi-drop-count { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: var(--muted); margin-top: 6px; }

    .bi-stats-bar { display: flex; flex-wrap: wrap; gap: 8px; margin: 16px 0; }

    .bi-table-wrap { overflow-x: auto; border-radius: var(--radius-lg); box-shadow: 0 0 0 1px var(--line-soft); }
    .bi-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .bi-table thead th {
        padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 700; color: var(--faint);
        text-transform: uppercase; letter-spacing: .05em; white-space: nowrap; border-bottom: 1px solid var(--line-soft); background: var(--page);
    }
    .bi-table tbody tr { border-top: 1px solid var(--line-soft); }
    .bi-table tbody tr:first-child { border-top: 0; }
    .bi-table tbody td { padding: 9px 14px; vertical-align: middle; color: var(--ink); }
    .bi-table tbody tr.row-nf { background: var(--no-bg); }
    .bi-table tbody tr.row-nf.row-resolved { background: transparent; }
    .bi-file-mono { font-family: var(--font); font-size: 12.5px; color: var(--ink-2); max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .bi-assign { display: flex; align-items: center; gap: 6px; }
    .bi-assign input.rh-input { min-height: 38px; padding: 0 10px; font-size: 13px; max-width: 220px; }
    .bi-assign .rh-link { white-space: nowrap; }

    .bi-convention { background: var(--brand-bg); border: 1px solid var(--brand-soft); border-radius: var(--radius); padding: 16px 18px; margin-bottom: 18px; font-size: 13.5px; line-height: 1.6; color: var(--ink-2); }
    .bi-convention code { background: var(--surface); border: 1px solid var(--line-soft); border-radius: 6px; padding: 1px 6px; font-family: var(--font); font-size: 12.5px; }
    .bi-convention-pattern { font-family: var(--font); font-weight: 700; color: var(--brand-dk); margin: 8px 0; }
    .bi-convention-ex { font-family: var(--font); font-size: 12px; color: var(--muted); margin: 2px 0; }

    .bi-hist-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .bi-hist-table thead th { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 700; color: var(--faint); text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--line-soft); }
    .bi-hist-table tbody tr { border-top: 1px solid var(--line-soft); }
    .bi-hist-table tbody td { padding: 10px 14px; }
</style>
@endsection

@section('content')
<div class="rh-page">
    @if(session('import_result'))
        @php $res = session('import_result'); $statut = session('import_statut'); @endphp
        <div class="rh-alert {{ $statut === 'echec' ? 'err' : ($statut === 'partiel' ? 'warn' : 'ok') }}" role="status">
            <span>
                <strong>{{ $res['total'] }}</strong> fichier{{ $res['total'] > 1 ? 's' : '' }} traité{{ $res['total'] > 1 ? 's' : '' }} —
                {{ $res['succes'] }} créé{{ $res['succes'] > 1 ? 's' : '' }}, {{ $res['doublons'] }} doublon{{ $res['doublons'] > 1 ? 's' : '' }}
                @if(count($res['erreurs']) > 0), {{ count($res['erreurs']) }} erreur{{ count($res['erreurs']) > 1 ? 's' : '' }}@endif.
                @if(!empty($res['erreurs']))
                    <details style="margin-top:6px">
                        <summary style="cursor:pointer; font-weight:600">Voir les erreurs</summary>
                        <ul style="margin:6px 0 0; padding-left:18px">
                            @foreach($res['erreurs'] as $err)
                                <li>{{ $err['fichier'] }} — {{ $err['raison'] }}</li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </span>
        </div>
    @endif
    @if(session('error'))
        <div class="rh-alert err" role="alert"><span>{{ session('error') }}</span></div>
    @endif

    <section class="rh-head">
        <div class="rh-head-txt">
            <h1 class="rh-h1">Import en lot de bulletins</h1>
            <p class="rh-lead">Chargez un ZIP contenant vos PDF — le système identifie chaque bulletin par numéro de police (ou matricule) et vous demande de confirmer manuellement ceux qu'il ne reconnaît pas.</p>
        </div>
        <div class="rh-actions">
            <a href="{{ route('admin.bulletins-paie.index') }}" class="rh-link">Retour aux bulletins</a>
        </div>
    </section>

    <section class="rh-card">
        <ul class="bi-steps" id="biSteps">
            <li class="active" id="step1"><span class="bi-num">1</span> Configuration</li>
            <li id="step2"><span class="bi-num">2</span> Prévisualisation</li>
            <li id="step3"><span class="bi-num">3</span> Import</li>
        </ul>

        <div class="bi-convention">
            <strong>Convention de nommage des PDF dans le ZIP</strong>
            <div class="bi-convention-pattern">Bulletin_{Police}_{NOM_PRENOM}_{YYYY-MM-DD}_au_{YYYY-MM-DD}.pdf</div>
            <div class="bi-convention-ex">Bulletin_580U224_TAMINI_THIERRY_2026-04-01_au_2026-04-30.pdf</div>
            <p style="margin:10px 0 0">
                Le premier segment après <code>Bulletin_</code> est le <strong>numéro de police</strong> (ou le matricule) — identifiant principal pour retrouver l'employé.
                Si un fichier n'est reconnu ni par police ni par matricule, vous devrez l'affecter manuellement à l'étape de prévisualisation — aucune association automatique par simple ressemblance de nom.
                Optionnel : un <code>salaires.csv</code> (<code>matricule, salaire_brut, salaire_net</code>) dans le ZIP pour importer les montants.
            </p>
        </div>

        {{-- ═══ Étape 1 — Configuration ═══ --}}
        <div id="phaseConfig">
            <div class="bi-grid">
                <div class="rh-field">
                    <label for="entreprise_id">Entreprise</label>
                    <select name="entreprise_id" id="entreprise_id" class="rh-select">
                        <option value="">— Sélectionner une entreprise —</option>
                        @foreach($entreprises as $ent)
                            <option value="{{ $ent->id }}">{{ $ent->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="rh-field" style="justify-content:flex-end">
                    <label style="display:flex; align-items:center; gap:10px; font-weight:400; cursor:pointer">
                        <input type="checkbox" id="notifierCheck">
                        <span><strong>Notifier les employés</strong> après import (WhatsApp)</span>
                    </label>
                </div>
                <div class="bi-drop" id="dropZone">
                    <input type="file" id="fichierZip" accept=".zip">
                    <strong id="fileName" style="display:block; margin-bottom:4px">Glissez votre ZIP ici ou cliquez pour choisir</strong>
                    <span class="rh-hint" id="fileSize">Format .zip · max 100 Mo</span>
                    <div class="bi-drop-count" id="pdfCountBadge" style="display:none"></div>
                </div>
            </div>

            <div class="rh-actions">
                <button type="button" class="rh-btn" id="analyserBtn" disabled>Analyser les fichiers</button>
                <span class="rh-hint" id="analyseMsg" style="display:none">Analyse en cours…</span>
            </div>
        </div>

        {{-- ═══ Étape 2 — Prévisualisation ═══ --}}
        <div id="phasePreview" style="display:none; margin-top:24px">
            <div class="bi-stats-bar">
                <span class="rh-badge off"><span id="chipTotal">0</span> fichiers</span>
                <span class="rh-badge ok"><span id="chipOk">0</span> prêts</span>
                <span class="rh-badge no"><span id="chipNf">0</span> à affecter</span>
                <span class="rh-badge wait"><span id="chipDup">0</span> doublons</span>
                <span class="rh-badge off"><span id="chipErr">0</span> format invalide</span>
            </div>

            <div class="rh-alert warn" id="nfAlert" style="display:none">
                <span id="nfAlertText"></span>
            </div>

            <div class="bi-table-wrap">
                <table class="bi-table">
                    <thead>
                        <tr>
                            <th>Fichier</th>
                            <th>Police</th>
                            <th>Période</th>
                            <th>Employé</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody id="previewTbody"></tbody>
                </table>
            </div>

            <div class="rh-actions" style="margin-top:16px">
                <button type="button" class="rh-btn" id="lancerImportBtn" disabled>Lancer l'import</button>
                <button type="button" class="rh-btn soft" id="resetBtn">Recommencer</button>
                <span class="rh-hint" id="importMsg" style="display:none">Import en cours, veuillez patienter…</span>
            </div>
        </div>
    </section>

    <section class="rh-card">
        <h2 class="rh-h2" style="margin-bottom:14px">Historique des imports</h2>
        @if($historique->isEmpty())
            <div class="rh-empty">
                <strong>Aucun import effectué</strong>
                <p>Les imports apparaîtront ici une fois lancés.</p>
            </div>
        @else
            <div class="bi-table-wrap">
                <table class="bi-hist-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Entreprise</th>
                            <th>Effectué par</th>
                            <th>Total</th>
                            <th>Créés</th>
                            <th>Doublons</th>
                            <th>Erreurs</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historique as $log)
                        <tr>
                            <td class="pp-muted" style="white-space:nowrap">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>{{ $log->entreprise?->nom ?? '—' }}</strong></td>
                            <td style="color:var(--muted)">{{ $log->uploadedBy?->name ?? '—' }}</td>
                            <td>{{ $log->total }}</td>
                            <td>{{ $log->succes }}</td>
                            <td>{{ $log->doublons }}</td>
                            <td>{{ $log->erreurs_count }}</td>
                            <td>
                                @php
                                    $bc = match($log->statut) { 'termine' => 'ok', 'partiel' => 'wait', 'echec' => 'no', default => 'off' };
                                @endphp
                                <span class="rh-badge {{ $bc }}">{{ $log->statut_label }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>

<form action="{{ url('/admin/bulletins-paie/import') }}" method="POST" enctype="multipart/form-data" id="importForm" style="display:none">
    @csrf
    <input type="file" name="fichier_zip" id="hiddenZipInput">
    <input type="hidden" name="entreprise_id" id="hiddenEntrepriseId">
    <input type="hidden" name="notifier" id="hiddenNotifier" value="0">
    <input type="hidden" name="overrides" id="hiddenOverrides" value="{}">
</form>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jszip.min.js') }}"></script>
<script>
const CSRF        = '{{ csrf_token() }}';
const PREVIEW_URL = '{{ url("/admin/bulletins-paie/import-preview") }}';
const PERSONNELS  = @json($personnelsParEntreprise);

const dropZone      = document.getElementById('dropZone');
const fileInput     = document.getElementById('fichierZip');
const fileNameEl    = document.getElementById('fileName');
const fileSizeEl    = document.getElementById('fileSize');
const pdfCountBadge = document.getElementById('pdfCountBadge');
const entrepriseEl  = document.getElementById('entreprise_id');
const notifierEl    = document.getElementById('notifierCheck');
const analyserBtn   = document.getElementById('analyserBtn');
const analyseMsg    = document.getElementById('analyseMsg');
const phasePreview  = document.getElementById('phasePreview');
const previewTbody  = document.getElementById('previewTbody');
const lancerBtn     = document.getElementById('lancerImportBtn');
const importMsg     = document.getElementById('importMsg');
const resetBtn      = document.getElementById('resetBtn');
const nfAlert       = document.getElementById('nfAlert');
const nfAlertText   = document.getElementById('nfAlertText');
const importForm    = document.getElementById('importForm');
const hiddenZipInput= document.getElementById('hiddenZipInput');
const hiddenEnt     = document.getElementById('hiddenEntrepriseId');
const hiddenNotif   = document.getElementById('hiddenNotifier');
const hiddenOverrides = document.getElementById('hiddenOverrides');
const stepEls       = [document.getElementById('step1'), document.getElementById('step2'), document.getElementById('step3')];

let currentFile = null;
let parsedFiles = [];
let analysed    = false;
let overrides   = {}; // filename => personnel_id | 'skip'

function setStep(active) {
    stepEls.forEach((el, i) => {
        el.classList.remove('active', 'done');
        if (i + 1 < active) el.classList.add('done');
        else if (i + 1 === active) el.classList.add('active');
    });
}

function parseFilename(filename) {
    const base = filename.replace(/\.pdf$/i, '');
    const m = base.match(/^Bulletin_(.+)_(\d{4}-\d{2}-\d{2})_au_(\d{4}-\d{2}-\d{2})$/i);
    if (!m) return null;
    const parts = m[1].split('_');
    const police = parts[0];
    const nom = parts.slice(1).join(' ');
    const annee = parseInt(m[2].substring(0, 4));
    const mois = parseInt(m[2].substring(5, 7));
    if (annee < 2000 || annee > 2100 || mois < 1 || mois > 12) return null;
    return { police, nom, annee, mois, periode: String(mois).padStart(2, '0') + '/' + annee };
}

async function readZipPdfs(file) {
    const zip = new JSZip();
    const loaded = await zip.loadAsync(file);
    const pdfs = [];
    zip.forEach((relativePath, entry) => {
        if (!entry.dir && relativePath.toLowerCase().endsWith('.pdf')) pdfs.push(relativePath.split('/').pop());
    });
    return pdfs;
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop', e => {
    e.preventDefault(); dropZone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file && file.name.toLowerCase().endsWith('.zip')) {
        const dt = new DataTransfer(); dt.items.add(file);
        fileInput.files = dt.files;
        onFileChosen(file);
    }
});
dropZone.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', () => { if (fileInput.files[0]) onFileChosen(fileInput.files[0]); });
entrepriseEl.addEventListener('change', () => { updateAnalyserBtn(); resetState(false); });

function onFileChosen(file) {
    currentFile = file;
    fileNameEl.textContent = file.name;
    fileSizeEl.textContent = (file.size / 1024 / 1024).toFixed(2) + ' Mo';
    dropZone.classList.add('has-file');
    analysed = false;
    phasePreview.style.display = 'none';
    setStep(1);
    updateAnalyserBtn();
    parseZipContents(file);
}

function updateAnalyserBtn() { analyserBtn.disabled = !(currentFile && entrepriseEl.value); }

async function parseZipContents(file) {
    pdfCountBadge.style.display = 'inline-flex';
    pdfCountBadge.textContent = '…';
    try {
        const names = await readZipPdfs(file);
        pdfCountBadge.textContent = names.length + ' PDF' + (names.length > 1 ? 's' : '');
        overrides = {};
        parsedFiles = names.map(name => {
            const p = parseFilename(name);
            if (!p) return { filename: name, police: null, nom: null, periode: null, statut: 'parse', personnel: null };
            return { filename: name, ...p, statut: 'pend', personnel: null };
        });
        updateChips(); renderPreviewTable();
        phasePreview.style.display = 'block'; setStep(2);
    } catch (err) {
        pdfCountBadge.textContent = 'Erreur ZIP'; console.error(err);
    }
}

function personnelOptionsFor(entrepriseId) {
    return PERSONNELS[entrepriseId] || [];
}

function renderPreviewTable() {
    previewTbody.innerHTML = '';
    parsedFiles.forEach((row) => {
        const tr = document.createElement('tr');
        const override = overrides[row.filename];
        const resolved = row.statut === 'ok' || (row.statut === 'nf' && override);
        if (row.statut === 'nf') tr.classList.add('row-nf');
        if (resolved) tr.classList.add('row-resolved');

        const policeHtml = row.police ? `<span class="rh-badge info">${esc(row.police)}</span>` : '<span class="pp-muted">—</span>';
        const periodeHtml = row.periode ? esc(row.periode) : '<span class="pp-muted">—</span>';

        let empHtml = '<span class="pp-muted">—</span>';
        if (row.statut === 'pend') {
            empHtml = '<span class="pp-muted">en attente…</span>';
        } else if (row.personnel) {
            empHtml = `<strong>${esc(row.personnel.nom_complet)}</strong>`;
        } else if (row.statut === 'nf') {
            if (override === 'skip') {
                empHtml = '<span class="pp-muted">Ignoré</span>';
            } else if (override) {
                const opt = personnelOptionsFor(entrepriseEl.value).find(p => p.id == override);
                empHtml = opt ? `<strong>${esc(opt.label)}</strong>` : '<span class="pp-muted">—</span>';
            } else {
                empHtml = `
                    <div class="bi-assign">
                        <input type="text" class="rh-input" list="personnelList" placeholder="Rechercher un employé…" data-filename="${esc(row.filename)}">
                        <a href="#" class="rh-link" data-skip="${esc(row.filename)}">Ignorer</a>
                    </div>`;
            }
        }

        const pill = { ok: 'ok', nf: override ? 'ok' : 'no', dup: 'wait', parse: 'off' }[row.statut] || 'off';
        const pillLabel = { ok: 'Prêt', nf: override === 'skip' ? 'Ignoré' : (override ? 'Affecté' : 'À affecter'), dup: 'Doublon', parse: 'Format invalide' }[row.statut] || 'En attente';

        tr.innerHTML = `
            <td><div class="bi-file-mono" title="${esc(row.filename)}">${esc(row.filename)}</div></td>
            <td>${policeHtml}</td>
            <td>${periodeHtml}</td>
            <td>${empHtml}</td>
            <td><span class="rh-badge ${pill}">${pillLabel}</span></td>
        `;
        previewTbody.appendChild(tr);
    });

    // Attache le datalist une seule fois, rempli selon l'entreprise sélectionnée
    let dl = document.getElementById('personnelList');
    if (!dl) { dl = document.createElement('datalist'); dl.id = 'personnelList'; document.body.appendChild(dl); }
    dl.innerHTML = personnelOptionsFor(entrepriseEl.value).map(p => `<option value="${esc(p.label)}" data-id="${p.id}">`).join('');

    previewTbody.querySelectorAll('input[data-filename]').forEach(input => {
        input.addEventListener('change', function () {
            const opts = personnelOptionsFor(entrepriseEl.value);
            const match = opts.find(p => p.label === this.value);
            if (match) {
                overrides[this.dataset.filename] = match.id;
                const row = parsedFiles.find(r => r.filename === this.dataset.filename);
                if (row) row.personnel = { nom_complet: match.label };
                updateChips(); renderPreviewTable();
            }
        });
    });
    previewTbody.querySelectorAll('a[data-skip]').forEach(a => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            overrides[this.dataset.skip] = 'skip';
            updateChips(); renderPreviewTable();
        });
    });
}

function updateChips() {
    const c = { ok: 0, nf: 0, dup: 0, parse: 0 };
    parsedFiles.forEach(r => { if (r.statut in c) c[r.statut]++; });
    const resolvedNf = parsedFiles.filter(r => r.statut === 'nf' && overrides[r.filename]).length;
    document.getElementById('chipTotal').textContent = parsedFiles.length;
    document.getElementById('chipOk').textContent = c.ok + resolvedNf;
    document.getElementById('chipNf').textContent = c.nf - resolvedNf;
    document.getElementById('chipDup').textContent = c.dup;
    document.getElementById('chipErr').textContent = c.parse;

    const remaining = c.nf - resolvedNf;
    if (remaining > 0) {
        nfAlertText.textContent = `${remaining} fichier(s) n'ont pas pu être associés automatiquement — affectez-les manuellement à un employé ci-dessous, ou ignorez-les.`;
        nfAlert.style.display = 'flex';
    } else {
        nfAlert.style.display = 'none';
    }
    lancerBtn.disabled = (c.ok + resolvedNf) === 0;
}

analyserBtn.addEventListener('click', async () => {
    if (!entrepriseEl.value || !currentFile) return;
    const validFilenames = parsedFiles.filter(r => r.statut !== 'parse').map(r => r.filename);
    if (!validFilenames.length) return;

    analyserBtn.disabled = true;
    analyseMsg.style.display = 'inline';
    try {
        const resp = await fetch(PREVIEW_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: JSON.stringify({ filenames: validFilenames, entreprise_id: entrepriseEl.value }),
        });
        if (!resp.ok) throw new Error('HTTP ' + resp.status);
        const data = await resp.json();
        const resultMap = {};
        data.rows.forEach(row => { resultMap[row.fichier] = row; });

        parsedFiles = parsedFiles.map(local => {
            if (local.statut === 'parse') return local;
            const srv = resultMap[local.filename];
            if (!srv) return local;
            const statut = srv.statut === 'ok' ? 'ok' : srv.statut === 'doublon' ? 'dup' : srv.statut === 'not_found' ? 'nf' : 'parse';
            return { ...local, statut, personnel: srv.personnel ?? null };
        });

        analysed = true; updateChips(); renderPreviewTable(); setStep(2);
    } catch (err) {
        nfAlertText.textContent = 'Erreur lors de l\'analyse : ' + err.message;
        nfAlert.style.display = 'flex';
    } finally {
        analyserBtn.disabled = false;
        analyseMsg.style.display = 'none';
    }
});

lancerBtn.addEventListener('click', () => {
    if (!currentFile || !entrepriseEl.value || !analysed) return;
    lancerBtn.disabled = true;
    importMsg.style.display = 'inline';
    setStep(3);

    const dt = new DataTransfer(); dt.items.add(currentFile);
    hiddenZipInput.files = dt.files;
    hiddenEnt.value = entrepriseEl.value;
    hiddenNotif.value = notifierEl.checked ? '1' : '0';
    hiddenOverrides.value = JSON.stringify(overrides);
    importForm.submit();
});

resetBtn.addEventListener('click', () => { resetState(true); fileInput.value = ''; });
function resetState(clearFile) {
    if (clearFile) { currentFile = null; dropZone.classList.remove('has-file'); fileNameEl.textContent = 'Glissez votre ZIP ici ou cliquez pour choisir'; fileSizeEl.textContent = 'Format .zip · max 100 Mo'; }
    parsedFiles = []; overrides = {}; analysed = false;
    pdfCountBadge.style.display = 'none';
    phasePreview.style.display = 'none';
    setStep(1);
    updateAnalyserBtn();
}
</script>
@endsection
