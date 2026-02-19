@extends('layouts.app')

@section('title', 'Nouvelle requête — Portail RH+')
@section('page-title', 'Nouvelle requête')
@section('page-subtitle', 'Envoyer un message au support')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
</svg>
@endsection

@section('styles')
<style>
.req-page { padding: 8px 0 40px; max-width: 780px; }

.req-card {
  background: var(--card-bg);
  border: 1px solid var(--card-border);
  border-radius: var(--border-radius);
  overflow: hidden;
}
.req-top-bar {
  height: 3px;
  background: linear-gradient(90deg, #3b82f6, #818cf8, #f59e0b);
}
.req-body { padding: 28px 32px 32px; }
.req-form-title {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 24px;
  letter-spacing: -0.02em;
}

.form-group { margin-bottom: 22px; }
.form-label {
  display: block;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: var(--text-muted);
  margin-bottom: 8px;
}
.form-label .req-star { color: #ef4444; margin-left: 2px; }
.form-input, .form-textarea, .form-select {
  width: 100%;
  padding: 11px 14px;
  border: 1px solid var(--card-border);
  border-radius: 8px;
  background: var(--bg-tertiary);
  color: var(--text-primary);
  font-size: 0.9rem;
  transition: border-color 0.15s, box-shadow 0.15s;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
  background: var(--card-bg);
}
.form-textarea { resize: vertical; min-height: 160px; line-height: 1.6; }
.form-error { color: #dc2626; font-size: 0.78rem; margin-top: 5px; }

/* Categorie pills */
.cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
.cat-pill input { display: none; }
.cat-pill label {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  padding: 12px 8px;
  border: 1.5px solid var(--card-border);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.15s;
  text-align: center;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--text-muted);
}
.cat-pill label:hover { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.05); }
.cat-pill input:checked + label {
  border-color: #3b82f6;
  background: rgba(59,130,246,0.08);
  color: #3b82f6;
}
.cat-icon { width: 28px; height: 28px; }

/* Priorite toggle */
.prio-toggle { display: flex; gap: 10px; }
.prio-toggle input { display: none; }
.prio-toggle label {
  flex: 1;
  padding: 10px 16px;
  border: 1.5px solid var(--card-border);
  border-radius: 8px;
  cursor: pointer;
  text-align: center;
  font-size: 0.83rem;
  font-weight: 700;
  transition: all 0.15s;
}
.prio-normale input:checked + label {
  border-color: #10b981;
  background: rgba(16,185,129,0.08);
  color: #059669;
}
.prio-urgente input:checked + label {
  border-color: #ef4444;
  background: rgba(239,68,68,0.08);
  color: #dc2626;
}
.prio-toggle label:hover { border-color: var(--text-muted); }

.char-count { font-size: 0.72rem; color: var(--text-muted); text-align: right; margin-top: 4px; }

.btn-submit {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 12px 28px;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.15s, transform 0.15s;
}
.btn-submit:hover { background: #2563eb; transform: translateY(-1px); }
.btn-cancel {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 12px 20px;
  color: var(--text-muted);
  text-decoration: none;
  font-size: 0.88rem;
  font-weight: 500;
  border-radius: 8px;
  transition: color 0.15s, background 0.15s;
}
.btn-cancel:hover { background: var(--bg-tertiary); color: var(--text-primary); }

.info-box {
  background: rgba(59,130,246,0.05);
  border: 1px solid rgba(59,130,246,0.15);
  border-radius: 8px;
  padding: 12px 16px;
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: 0.8rem;
  color: var(--text-muted);
  margin-bottom: 24px;
}

@media (max-width: 640px) { .cat-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endsection

@section('content')
<div class="req-page">

    <div class="req-card">
        <div class="req-top-bar"></div>
        <div class="req-body">

            <div class="info-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                Votre message sera transmis à l'équipe support. Vous recevrez une réponse directement sur cette plateforme.
            </div>

            <form action="{{ route('admin.requetes.store') }}" method="POST">
                @csrf

                {{-- Sujet --}}
                <div class="form-group">
                    <label class="form-label">Sujet <span class="req-star">*</span></label>
                    <input type="text" name="sujet" class="form-input" value="{{ old('sujet') }}"
                           placeholder="Résumez votre demande en quelques mots…" maxlength="150" required>
                    @error('sujet')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                {{-- Catégorie --}}
                <div class="form-group">
                    <label class="form-label">Catégorie <span class="req-star">*</span></label>
                    <div class="cat-grid">
                        <div class="cat-pill">
                            <input type="radio" name="categorie" id="cat_question" value="question" {{ old('categorie','question')==='question' ? 'checked' : '' }}>
                            <label for="cat_question">
                                <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                Question
                            </label>
                        </div>
                        <div class="cat-pill">
                            <input type="radio" name="categorie" id="cat_facturation" value="facturation" {{ old('categorie')==='facturation' ? 'checked' : '' }}>
                            <label for="cat_facturation">
                                <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                Facturation
                            </label>
                        </div>
                        <div class="cat-pill">
                            <input type="radio" name="categorie" id="cat_support" value="support" {{ old('categorie')==='support' ? 'checked' : '' }}>
                            <label for="cat_support">
                                <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                                Support technique
                            </label>
                        </div>
                        <div class="cat-pill">
                            <input type="radio" name="categorie" id="cat_autre" value="autre" {{ old('categorie')==='autre' ? 'checked' : '' }}>
                            <label for="cat_autre">
                                <svg class="cat-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                Autre
                            </label>
                        </div>
                    </div>
                    @error('categorie')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                {{-- Priorité --}}
                <div class="form-group">
                    <label class="form-label">Priorité <span class="req-star">*</span></label>
                    <div class="prio-toggle">
                        <div class="prio-normale">
                            <input type="radio" name="priorite" id="prio_normale" value="normale" {{ old('priorite','normale')==='normale' ? 'checked' : '' }}>
                            <label for="prio_normale">Normale</label>
                        </div>
                        <div class="prio-urgente">
                            <input type="radio" name="priorite" id="prio_urgente" value="urgente" {{ old('priorite')==='urgente' ? 'checked' : '' }}>
                            <label for="prio_urgente">🔴 Urgente</label>
                        </div>
                    </div>
                    @error('priorite')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                {{-- Message --}}
                <div class="form-group">
                    <label class="form-label">Message <span class="req-star">*</span></label>
                    <textarea name="message" id="messageField" class="form-textarea" maxlength="3000"
                              placeholder="Décrivez votre demande en détail…" required>{{ old('message') }}</textarea>
                    <div class="char-count"><span id="charCount">0</span> / 3000</div>
                    @error('message')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                {{-- Actions --}}
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        Envoyer la requête
                    </button>
                    <a href="{{ route('admin.requetes.index') }}" class="btn-cancel">Annuler</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
const area  = document.getElementById('messageField');
const count = document.getElementById('charCount');
function updateCount() { count.textContent = area.value.length; }
area.addEventListener('input', updateCount);
updateCount();
</script>
@endsection
