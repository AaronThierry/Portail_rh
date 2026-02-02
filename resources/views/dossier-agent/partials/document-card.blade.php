<div class="ds-doc-card">
    <div class="ds-doc-card-header">
        <div class="ds-doc-icon {{ $document->extension === 'pdf' ? 'pdf' : (in_array($document->extension, ['doc', 'docx']) ? 'doc' : (in_array($document->extension, ['xls', 'xlsx']) ? 'xls' : (in_array($document->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) ? 'img' : 'default'))) }}">
            @if($document->extension === 'pdf')
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                <path d="M14 2v6h6M9 13h2m-2 4h6m-6-8h6"/>
            </svg>
            @elseif(in_array($document->extension, ['doc', 'docx']))
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                <path d="M14 2v6h6M16 13H8m8 4H8"/>
            </svg>
            @elseif(in_array($document->extension, ['xls', 'xlsx']))
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                <path d="M8 13h8M8 17h8M8 9h8"/>
            </svg>
            @elseif(in_array($document->extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                <circle cx="8.5" cy="8.5" r="1.5"/>
                <polyline points="21 15 16 10 5 21"/>
            </svg>
            @else
            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                <path d="M14 2v6h6"/>
            </svg>
            @endif
        </div>
        <div class="ds-doc-info">
            <h4 class="ds-doc-title" title="{{ $document->titre }}">{{ $document->titre }}</h4>
            <div class="ds-doc-filename" title="{{ $document->nom_original }}">{{ $document->nom_original }}</div>
            <div class="ds-doc-badges">
                @if($document->est_expire)
                <span class="ds-badge ds-badge-danger">Expiré</span>
                @elseif($document->date_expiration && $document->date_expiration->diffInDays(now()) <= 30)
                <span class="ds-badge ds-badge-warning">Expire bientôt</span>
                @endif
                @if($document->confidentiel)
                <span class="ds-badge ds-badge-confidential">Confidentiel</span>
                @endif
            </div>
        </div>
    </div>
    <div class="ds-doc-card-body">
        <div class="ds-doc-meta">
            <div class="ds-doc-meta-item">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ $document->taille_formatee }}
            </div>
            <div class="ds-doc-meta-item">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $document->created_at->format('d/m/Y') }}
            </div>
            @if($document->date_expiration)
            <div class="ds-doc-meta-item {{ $document->est_expire ? 'ds-meta-expired' : '' }}">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Exp: {{ $document->date_expiration->format('d/m/Y') }}
            </div>
            @endif
            @if($document->reference)
            <div class="ds-doc-meta-item">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                </svg>
                {{ Str::limit($document->reference, 15) }}
            </div>
            @endif
        </div>
        <div class="ds-doc-actions">
            <a href="{{ route('admin.dossier-agent.download', $document) }}" class="ds-doc-btn ds-doc-btn-download">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Télécharger
            </a>
            @if($document->estPdf() || $document->estImage())
            <a href="{{ route('admin.dossier-agent.preview', $document) }}" target="_blank" class="ds-doc-btn ds-doc-btn-preview" title="Prévisualiser">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
            @endif
            <button type="button" onclick="deleteDocument({{ $document->id }})" class="ds-doc-btn ds-doc-btn-delete" title="Supprimer">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>
</div>
