@php
    $iconClass = 'default';
    $iconSvg = '<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>';

    if (in_array($document->extension, ['pdf'])) {
        $iconClass = 'pdf';
        $iconSvg = '<path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/><path d="M9 13h2v4H9zm4-2h2v6h-2z"/>';
    } elseif (in_array($document->extension, ['doc', 'docx'])) {
        $iconClass = 'doc';
        $iconSvg = '<path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>';
    } elseif (in_array($document->extension, ['xls', 'xlsx'])) {
        $iconClass = 'xls';
        $iconSvg = '<path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>';
    } elseif (in_array($document->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        $iconClass = 'img';
        $iconSvg = '<path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>';
    }

    $isExpired = $document->date_expiration && $document->date_expiration < now();
    $isExpiring = $document->date_expiration && $document->date_expiration > now() && $document->date_expiration < now()->addDays(30);
@endphp

<div class="doc-card">
    <div class="doc-card-header">
        <div class="doc-icon {{ $iconClass }}">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                {!! $iconSvg !!}
            </svg>
        </div>
        <div class="doc-info">
            <h4 class="doc-title">{{ $document->titre ?? $document->nom_original }}</h4>
            <p class="doc-filename">{{ $document->nom_original }}</p>
            <div class="doc-badges">
                @if($isExpired)
                    <span class="doc-badge expire">Expiré</span>
                @elseif($isExpiring)
                    <span class="doc-badge expiring">Expire bientôt</span>
                @endif
            </div>
        </div>
    </div>
    <div class="doc-card-body">
        <div class="doc-meta">
            <div class="doc-meta-item">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $document->created_at->format('d/m/Y') }}
            </div>
            <div class="doc-meta-item">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                </svg>
                {{ $document->taille_formatee }}
            </div>
            @if($document->date_expiration)
            <div class="doc-meta-item" style="grid-column: span 2; {{ $isExpired ? 'color: #dc2626;' : '' }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Expire le {{ \Carbon\Carbon::parse($document->date_expiration)->format('d/m/Y') }}
            </div>
            @endif
        </div>
        <div class="doc-actions">
            @if(in_array($document->extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']))
            <a href="{{ route('admin.dossier-agent.preview', $document) }}" target="_blank" class="doc-btn preview">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Voir
            </a>
            @endif
            <a href="{{ route('admin.dossier-agent.download', $document) }}" class="doc-btn download">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Télécharger
            </a>
        </div>
    </div>
</div>
