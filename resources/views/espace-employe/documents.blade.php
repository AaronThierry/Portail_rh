@extends('layouts.espace-employe')

@section('title', $currentCategory ? $currentCategory->nom : 'Mon dossier')

@section('styles')
<style>
    .doc-folders { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px; }
    .doc-folder {
        position: relative; display: flex; align-items: center; gap: 14px; padding: 16px; min-height: 76px;
        background: var(--surface, #fff); border-radius: var(--radius); box-shadow: 0 0 0 1px var(--line-soft);
        text-decoration: none; color: inherit;
    }
    .doc-folder:hover { box-shadow: 0 0 0 1.5px var(--brand); }
    .doc-folder-ico { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #fff; }
    .doc-folder-ico svg { width: 22px; height: 22px; }
    .doc-ext { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; flex-shrink: 0; background: var(--subtle); color: var(--ink-2); }
    .doc-ext.pdf { background: var(--no-bg); color: var(--no); }
    .doc-ext.img { background: var(--info-bg); color: var(--info); }
    .doc-ext.doc { background: var(--brand-soft); color: var(--brand-dk); }
    .doc-ext.xls { background: var(--ok-bg); color: var(--ok); }
    .doc-search { position: relative; max-width: 360px; width: 100%; }
    .doc-search svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--faint); pointer-events: none; }
    .doc-search .rh-input { padding-left: 44px; min-height: 44px; }
</style>
@endsection

@section('content')
<div class="rh-page">
    @include('espace-employe.partials.tabs', ['section' => 'documents'])

    <section class="rh-head">
        <div class="rh-head-txt">
            @if($currentCategory || $selectedCategory === '0')
                <a href="{{ route('espace-employe.documents') }}" class="rh-link" style="padding: 0">‹ Tous les dossiers</a>
                <h1 class="rh-h1">{{ $currentCategory ? $currentCategory->nom : 'Autres documents' }}</h1>
                @if($currentCategory && $currentCategory->description)
                    <p class="rh-lead">{{ $currentCategory->description }}</p>
                @endif
            @else
                <h1 class="rh-h1">Mon dossier</h1>
                <p class="rh-lead">
                    @if($stats['total'] > 0)
                        {{ $stats['total'] }} document{{ $stats['total'] > 1 ? 's' : '' }} partagé{{ $stats['total'] > 1 ? 's' : '' }} par le service RH@if($stats['recent'] > 0), dont {{ $stats['recent'] }} ce mois-ci@endif.
                    @else
                        Les documents que le service RH partage avec vous apparaîtront ici.
                    @endif
                </p>
            @endif
        </div>
        @if($stats['total'] > 0)
            <div class="doc-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <label for="searchInput" class="rh-sr">Rechercher un document</label>
                <input type="search" id="searchInput" class="rh-input" placeholder="Rechercher…">
            </div>
        @endif
    </section>

    @if(!$currentCategory && $selectedCategory !== '0')
        {{-- ── Dossiers ── --}}
        @if($categoriesWithDocs->count() > 0 || $uncategorizedDocs->count() > 0)
            <div class="doc-folders">
                @foreach($categoriesWithDocs as $category)
                    @php
                        $docs  = $documentsByCategory->get($category->id, collect([]));
                        $isNew = $docs->where('created_at', '>=', now()->subDays(7))->count() > 0;
                    @endphp
                    <a href="{{ route('espace-employe.documents', ['categorie' => $category->id]) }}" class="doc-folder" data-name="{{ mb_strtolower($category->nom) }}">
                        <span class="doc-folder-ico" style="background: {{ $category->couleur ?? 'var(--brand)' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </span>
                        <span class="rh-row-main">
                            <span class="rh-row-title">{{ $category->nom }}</span>
                            <span class="rh-row-sub">{{ $docs->count() }} document{{ $docs->count() > 1 ? 's' : '' }}</span>
                        </span>
                        @if($isNew)<span class="rh-badge new">Nouveau</span>@endif
                    </a>
                @endforeach
                @if($uncategorizedDocs->count() > 0)
                    <a href="{{ route('espace-employe.documents', ['categorie' => '0']) }}" class="doc-folder" data-name="autres documents">
                        <span class="doc-folder-ico" style="background: var(--faint)">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                        </span>
                        <span class="rh-row-main">
                            <span class="rh-row-title">Autres documents</span>
                            <span class="rh-row-sub">{{ $uncategorizedDocs->count() }} document{{ $uncategorizedDocs->count() > 1 ? 's' : '' }}</span>
                        </span>
                    </a>
                @endif
            </div>
        @else
            <div class="rh-card rh-empty">
                <strong>Votre dossier est vide</strong>
                <p>Contrat, attestations, pièces administratives : tout ce que le service RH partage avec vous sera rangé ici.</p>
            </div>
        @endif
    @else
        {{-- ── Fichiers d'un dossier ── --}}
        @php $filesToShow = $selectedCategory === '0' ? $uncategorizedDocs : $documents; @endphp
        @if($filesToShow->count() > 0)
            <ul class="rh-list rh-card-flat">
                @foreach($filesToShow as $document)
                    @php
                        $ext = strtolower($document->extension ?? pathinfo($document->chemin ?? '', PATHINFO_EXTENSION));
                        $cls = match (true) {
                            $ext === 'pdf'                                            => 'pdf',
                            in_array($ext, ['doc', 'docx'])                           => 'doc',
                            in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])     => 'img',
                            in_array($ext, ['xls', 'xlsx', 'csv'])                    => 'xls',
                            default                                                   => '',
                        };
                        $nom = $document->titre ?? $document->nom_original ?? 'Document';
                    @endphp
                    <li data-name="{{ mb_strtolower($nom) }}">
                        <div class="rh-row" style="flex-wrap: wrap">
                            <span class="doc-ext {{ $cls }}" aria-hidden="true">{{ $ext ?: 'fic' }}</span>
                            <span class="rh-row-main" style="min-width: 160px">
                                <span class="rh-row-title">{{ $nom }}</span>
                                <span class="rh-row-sub">
                                    Ajouté le {{ $document->created_at->format('d/m/Y') }}
                                    @if($document->taille) · {{ $document->taille_formatee }} @endif
                                    @if($document->date_expiration) · expire le {{ $document->date_expiration->format('d/m/Y') }} @endif
                                </span>
                            </span>
                            <span class="rh-row-end">
                                <a href="{{ route('espace-employe.documents.preview', $document->id) }}" target="_blank" rel="noopener" class="rh-btn soft sm">Voir</a>
                                <a href="{{ route('espace-employe.documents.download', $document->id) }}" class="rh-btn sm">Télécharger</a>
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="rh-card rh-empty">
                <strong>Ce dossier est vide</strong>
                <p>Aucun document n'y a encore été ajouté.</p>
            </div>
        @endif
    @endif
    <p class="rh-lead" id="aucunResultat" hidden>Aucun document ne correspond à votre recherche.</p>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var input = document.getElementById('searchInput');
    if (!input) return;
    var items = document.querySelectorAll('.doc-folder, .rh-list > li[data-name]');
    var none = document.getElementById('aucunResultat');
    input.addEventListener('input', function () {
        var q = input.value.trim().toLowerCase(), shown = 0;
        items.forEach(function (el) {
            var ok = !q || (el.dataset.name || '').indexOf(q) !== -1;
            el.hidden = !ok;
            if (ok) shown++;
        });
        none.hidden = shown > 0;
    });
})();
</script>
@endsection
