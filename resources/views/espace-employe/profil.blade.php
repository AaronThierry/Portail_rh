@extends('layouts.espace-employe')

@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')
@section('breadcrumb')
    <a href="{{ route('espace-employe.dashboard') }}">Accueil</a>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
    <span>Mon Profil</span>
@endsection

@section('styles')
<style>
/* ============================================
   PROFIL PAGE — Indigo × Teal Charter
   ============================================ */

.profil-page {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    max-width: 1200px;
    margin: 0 auto;
    animation: profil-pageLoad 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes profil-pageLoad {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ============================================
   TOAST NOTIFICATIONS
   ============================================ */
.profil-toast {
    position: fixed;
    top: 1.25rem;
    right: 1.25rem;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.125rem;
    background: var(--surface);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-lg);
    animation: toastSlide 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    max-width: 360px;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
}

@keyframes toastSlide {
    from { opacity: 0; transform: translateX(100px); }
    to   { opacity: 1; transform: translateX(0); }
}

.profil-toast.hiding {
    animation: toastHide 0.3s ease-in forwards;
}

@keyframes toastHide {
    to { opacity: 0; transform: translateX(100px); }
}

.profil-toast-icon {
    width: 34px;
    height: 34px;
    border-radius: var(--r-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profil-toast.success .profil-toast-icon { background: var(--teal-100); color: var(--teal-700); }
.profil-toast.error .profil-toast-icon   { background: #ffe4e6; color: #be123c; }
.profil-toast-icon svg { width: 16px; height: 16px; }

.profil-toast-content { flex: 1; }

.profil-toast-title {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.125rem;
}

.profil-toast-message {
    font-size: 0.75rem;
    color: var(--text-2);
}

.profil-toast-close {
    width: 28px;
    height: 28px;
    border: none;
    background: var(--bg);
    border-radius: var(--r-sm);
    color: var(--text-2);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.profil-toast-close:hover { background: var(--border); color: var(--text); }
.profil-toast-close svg { width: 14px; height: 14px; }

.profil-toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: var(--teal-500);
    border-radius: 0 0 var(--r-lg) var(--r-lg);
    animation: progressShrink 5s linear forwards;
}

.profil-toast.error .profil-toast-progress { background: #be123c; }

@keyframes progressShrink {
    from { width: 100%; }
    to   { width: 0%; }
}

/* ============================================
   PROFILE HERO — INDIGO × TEAL
   ============================================ */
.profil-hero {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    position: relative;
    box-shadow: var(--shadow-lg);
}

.profil-hero-cover {
    height: 160px;
    background: linear-gradient(135deg, var(--ind-900) 0%, var(--ind-700) 100%);
    position: relative;
    overflow: hidden;
}

/* Teal 3px top accent bar */
.profil-hero-cover::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500));
    z-index: 3;
}

/* Teal radial glow */
.profil-hero-shape {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.profil-hero-shape:nth-child(1) {
    width: 280px;
    height: 280px;
    top: -80px;
    right: -60px;
    background: radial-gradient(circle, rgba(20, 184, 166, 0.15) 0%, transparent 70%);
}

.profil-hero-shape:nth-child(2) {
    width: 180px;
    height: 180px;
    bottom: -60px;
    left: 8%;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
}

.profil-hero-shape:nth-child(3) {
    width: 100px;
    height: 100px;
    top: 30px;
    left: 38%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.04) 0%, transparent 70%);
}

/* Grid texture */
.profil-hero-grid {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 32px 32px;
}

.profil-hero-fade {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 80px;
    background: linear-gradient(to top, var(--surface), transparent);
    z-index: 2;
}

/* Profile body */
.profil-hero-body {
    display: flex;
    align-items: flex-end;
    gap: 1.5rem;
    padding: 0 2rem 1.5rem;
    margin-top: -60px;
    position: relative;
    z-index: 3;
}

/* Avatar — Teal Ring */
.profil-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.profil-avatar-container {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, var(--teal-400), var(--teal-600), var(--ind-500));
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}

.profil-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--surface);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.profil-avatar-wrapper:hover .profil-avatar { transform: scale(1.03); }

.profil-avatar-edit {
    position: absolute;
    bottom: 4px; right: 4px;
    width: 32px; height: 32px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.35);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 4;
}

.profil-avatar-edit:hover {
    transform: scale(1.12) rotate(10deg);
    box-shadow: 0 6px 16px rgba(20, 184, 166, 0.45);
}

.profil-avatar-edit svg { width: 14px; height: 14px; }

/* Identity */
.profil-identity {
    flex: 1;
    padding-bottom: 0.375rem;
}

.profil-name {
    font-family: var(--font-d);
    font-size: 1.625rem;
    font-weight: 400;
    color: var(--text);
    margin: 0 0 0.375rem;
    letter-spacing: 0.01em;
    line-height: 1.2;
}

.profil-role {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-2);
    margin-bottom: 0.75rem;
}

.profil-role svg { width: 14px; height: 14px; color: var(--teal-500); }

.profil-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.profil-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    background: var(--bg);
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
    font-family: var(--font-m);
}

.profil-badge:hover {
    border-color: var(--ind-400);
    background: var(--ind-50);
    color: var(--ind-700);
    transform: translateY(-1px);
}

.profil-badge svg { width: 12px; height: 12px; color: var(--ind-500); }

.profil-badge.active {
    background: var(--teal-50);
    border-color: var(--teal-300);
    color: var(--teal-700);
}

.profil-badge.active svg { color: var(--teal-600); }

/* Hero Actions */
.profil-hero-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

.profil-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.5625rem 1.125rem;
    border-radius: var(--r-md);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
    text-decoration: none;
    letter-spacing: 0.01em;
}

.profil-btn svg { width: 14px; height: 14px; transition: transform 0.2s ease; }
.profil-btn:hover svg { transform: scale(1.08); }

.profil-btn.primary {
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white;
    box-shadow: 0 4px 16px rgba(20, 184, 166, 0.3);
}

.profil-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(20, 184, 166, 0.4);
}

.profil-btn.secondary {
    background: var(--surface);
    color: var(--text);
    border: 1px solid var(--border);
}

.profil-btn.secondary:hover {
    border-color: var(--ind-400);
    color: var(--ind-700);
    background: var(--ind-50);
}

/* ============================================
   STATS ROW — KPI CARDS
   ============================================ */
.profil-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.profil-stat {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem 1.125rem;
    background: var(--surface);
    border-radius: var(--r-lg);
    border: 1px solid var(--border);
    transition: all 0.25s ease;
    overflow: hidden;
}

.profil-stat::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--stat-color, var(--ind-500));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.profil-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
.profil-stat:hover::before { transform: scaleX(1); }

.profil-stat-icon {
    width: 48px; height: 48px;
    border-radius: var(--r-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: transform 0.25s ease;
}

.profil-stat:hover .profil-stat-icon { transform: scale(1.06); }

.profil-stat-icon svg { width: 22px; height: 22px; }

.profil-stat-icon.violet {
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    color: white;
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
}

.profil-stat-icon.teal {
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.25);
}

.profil-stat-icon.indigo {
    background: linear-gradient(135deg, var(--ind-500), var(--ind-600));
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}

.profil-stat-icon.amber {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
}

.profil-stat:has(.profil-stat-icon.violet) { --stat-color: #7c3aed; }
.profil-stat:has(.profil-stat-icon.teal)   { --stat-color: var(--teal-500); }
.profil-stat:has(.profil-stat-icon.indigo) { --stat-color: var(--ind-500); }
.profil-stat:has(.profil-stat-icon.amber)  { --stat-color: #f59e0b; }

.profil-stat-info { flex: 1; min-width: 0; }

.profil-stat-value {
    font-family: var(--font-d);
    font-size: 1.625rem;
    font-weight: 400;
    color: var(--text);
    line-height: 1.1;
}

.profil-stat-label {
    font-size: 0.6875rem;
    font-weight: 600;
    color: var(--text-2);
    margin-top: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ============================================
   CONTENT GRID
   ============================================ */
.profil-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

.profil-grid-full { grid-column: 1 / -1; }

/* ============================================
   INFO CARDS
   ============================================ */
.profil-card {
    background: var(--surface);
    border-radius: var(--r-xl);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: var(--shadow-sm);
}

.profil-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--card-accent, var(--ind-500));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.profil-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.profil-card:hover::before { transform: scaleX(1); }

.profil-card:has(.profil-card-icon.primary) { --card-accent: var(--ind-500); }
.profil-card:has(.profil-card-icon.success) { --card-accent: var(--teal-500); }
.profil-card:has(.profil-card-icon.accent)  { --card-accent: #f59e0b; }
.profil-card:has(.profil-card-icon.purple)  { --card-accent: #7c3aed; }

.profil-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.125rem 1.375rem;
    border-bottom: 1px solid var(--border);
}

.profil-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: var(--font-d);
    font-size: 0.9375rem;
    font-weight: 400;
    color: var(--text);
    margin: 0;
}

.profil-card-icon {
    width: 38px; height: 38px;
    border-radius: var(--r-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profil-card-icon.primary {
    background: linear-gradient(135deg, var(--ind-500), var(--ind-600));
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
}

.profil-card-icon.success {
    background: linear-gradient(135deg, var(--teal-500), var(--teal-600));
    color: white;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
}

.profil-card-icon.accent {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
}

.profil-card-icon.purple {
    background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    color: white;
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.profil-card-icon svg { width: 18px; height: 18px; }

.profil-card-body { padding: 1.375rem; }

/* ============================================
   INFO FIELDS
   ============================================ */
.profil-fields {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.875rem;
}

.profil-field { display: flex; flex-direction: column; gap: 0.375rem; }
.profil-field.full { grid-column: span 2; }

.profil-field-label {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.625rem;
    font-weight: 700;
    color: var(--text-3);
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.profil-field-value {
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text);
    padding: 0.6875rem 1rem;
    background: var(--bg);
    border-radius: var(--r-md);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
}

.profil-field-value::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--card-accent, var(--ind-500));
    opacity: 0;
    transition: opacity 0.2s ease;
    border-radius: 0 2px 2px 0;
}

.profil-field-value:hover { border-color: var(--border-2); box-shadow: var(--shadow-sm); }
.profil-field-value:hover::before { opacity: 1; }

.profil-field-value.highlight {
    background: var(--ind-50);
    color: var(--ind-700);
    font-weight: 600;
    border-color: var(--ind-200);
    font-family: var(--font-m);
    font-size: 0.8125rem;
}

.profil-field-value.highlight::before { opacity: 1; }

.profil-field-value.empty {
    color: var(--text-3);
    font-style: italic;
}

/* ============================================
   SECTIONS WITHIN CARDS
   ============================================ */
.profil-section {
    padding-bottom: 1.25rem;
    margin-bottom: 1.25rem;
    border-bottom: 1px solid var(--border);
}

.profil-section:last-child { padding-bottom: 0; margin-bottom: 0; border-bottom: none; }

.profil-section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--text-2);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 1rem;
}

.profil-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
    margin-left: 0.5rem;
}

.profil-section-title svg {
    width: 16px; height: 16px;
    padding: 3px;
    background: var(--ind-50);
    border-radius: 4px;
    color: var(--ind-600);
}

/* ============================================
   QUICK ACTIONS GRID
   ============================================ */
.profil-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.875rem;
}

.profil-action-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.875rem;
    padding: 1.5rem 1rem;
    background: var(--bg);
    border-radius: var(--r-lg);
    border: 1.5px solid var(--border);
    text-decoration: none;
    color: var(--text);
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    text-align: center;
}

.profil-action-link:hover {
    border-color: var(--ind-300);
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    background: var(--surface);
}

.profil-action-icon {
    width: 48px; height: 48px;
    border-radius: var(--r-md);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.25s ease;
}

.profil-action-link:hover .profil-action-icon { transform: scale(1.08); }
.profil-action-icon svg { width: 20px; height: 20px; }

.profil-action-content { text-align: center; }

.profil-action-title {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.125rem;
}

.profil-action-desc { font-size: 0.6875rem; color: var(--text-2); }
.profil-action-arrow { display: none; }

/* ============================================
   MODALS — INDIGO × TEAL
   ============================================ */
.profil-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(10px);
    z-index: 500;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

.profil-modal-overlay.show { display: flex; }

.profil-modal {
    background: var(--surface);
    border-radius: var(--r-xl);
    width: 100%;
    max-width: 420px;
    max-height: 90vh;
    overflow: hidden;
    animation: modalAppear 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    box-shadow: 0 32px 64px -16px rgba(0,0,0,0.22);
    display: flex;
    flex-direction: column;
    border: 1px solid var(--border);
}

.profil-modal form {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    flex: 1;
    min-height: 0;
}

@keyframes modalAppear {
    from { opacity: 0; transform: scale(0.96) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

.profil-modal-header {
    background: linear-gradient(135deg, var(--ind-900), var(--ind-700));
    padding: 1.25rem 1.375rem;
    color: white;
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}

/* Teal bottom line */
.profil-modal-header::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--teal-400), var(--teal-500));
}

/* Grid texture */
.profil-modal-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 20px 20px;
}

.profil-modal-title {
    font-family: var(--font-d);
    font-size: 1.0625rem;
    font-weight: 400;
    margin: 0 0 0.25rem;
    position: relative;
    z-index: 1;
}

.profil-modal-subtitle {
    font-size: 0.75rem;
    opacity: 0.7;
    position: relative;
    z-index: 1;
}

.profil-modal-close {
    position: absolute;
    top: 0.875rem; right: 0.875rem;
    width: 30px; height: 30px;
    border: none;
    border-radius: var(--r-sm);
    background: rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.7);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    z-index: 2;
}

.profil-modal-close:hover { background: rgba(255,255,255,0.2); color: white; transform: rotate(90deg); }
.profil-modal-close svg { width: 14px; height: 14px; }

.profil-modal-body {
    padding: 1.375rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: var(--border) transparent;
}

.profil-modal-body::-webkit-scrollbar { width: 5px; }
.profil-modal-body::-webkit-scrollbar-track { background: transparent; }
.profil-modal-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

.profil-form-group { margin-bottom: 1.125rem; }
.profil-form-group:last-child { margin-bottom: 0; }

.profil-form-label {
    display: block;
    font-size: 0.6875rem;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.profil-form-input {
    width: 100%;
    padding: 0.6875rem 1rem;
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    font-size: 0.8125rem;
    color: var(--text);
    background: var(--bg);
    transition: all 0.2s ease;
    font-family: inherit;
}

.profil-form-input:focus {
    outline: none;
    border-color: var(--teal-400);
    box-shadow: 0 0 0 3px var(--teal-50);
    background: var(--surface);
}

.profil-form-input::placeholder { color: var(--text-3); }

.profil-modal-footer {
    padding: 1rem 1.375rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    background: var(--bg);
    flex-shrink: 0;
}

/* Upload Zone */
.profil-upload {
    border: 2px dashed var(--border);
    border-radius: var(--r-lg);
    padding: 1.75rem 1.25rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.25s ease;
    background: var(--bg);
    position: relative;
}

.profil-upload:hover { border-color: var(--teal-400); background: var(--teal-50); }

.profil-upload.dragover {
    border-color: var(--teal-500);
    background: var(--teal-50);
    transform: scale(1.01);
}

.profil-upload input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

.profil-upload-icon {
    width: 52px; height: 52px;
    margin: 0 auto 0.75rem;
    background: var(--teal-50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--teal-600);
    transition: all 0.25s ease;
}

.profil-upload:hover .profil-upload-icon {
    transform: scale(1.08);
    background: var(--teal-500);
    color: white;
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
}

.profil-upload-icon svg { width: 22px; height: 22px; }

.profil-upload-text { font-size: 0.8125rem; font-weight: 600; color: var(--text); margin-bottom: 0.25rem; }
.profil-upload-hint { font-size: 0.6875rem; color: var(--text-2); }

.profil-upload-preview { display: none; margin-top: 1rem; }
.profil-upload-preview.show { display: block; animation: fadeIn 0.3s ease; }

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to   { opacity: 1; transform: scale(1); }
}

.profil-upload-preview img {
    max-width: 100px;
    border-radius: 50%;
    border: 3px solid var(--teal-400);
    box-shadow: 0 4px 12px rgba(20, 184, 166, 0.2);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 1100px) {
    .profil-grid { grid-template-columns: 1fr; }
    .profil-grid-full { grid-column: 1; }
    .profil-stats-row { grid-template-columns: repeat(4, 1fr); gap: 0.75rem; }
}

@media (max-width: 768px) {
    .profil-hero-body { flex-direction: column; align-items: center; text-align: center; gap: 1rem; padding: 0 1.25rem 1.25rem; }
    .profil-avatar-container { width: 96px; height: 96px; }
    .profil-badges { justify-content: center; }
    .profil-hero-actions { width: 100%; justify-content: center; }
    .profil-name { font-size: 1.375rem; }
    .profil-stats-row { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .profil-stat { padding: 1rem; }
    .profil-stat-icon { width: 42px; height: 42px; }
    .profil-stat-value { font-size: 1.25rem; }
    .profil-card-header { padding: 1rem 1.125rem; }
    .profil-card-body { padding: 1.125rem; }
    .profil-actions-grid { grid-template-columns: repeat(3, 1fr); gap: 0.625rem; }
}

@media (max-width: 576px) {
    .profil-hero-cover { height: 120px; }
    .profil-hero-body { margin-top: -48px; padding: 0 1rem 1rem; }
    .profil-avatar-container { width: 84px; height: 84px; }
    .profil-avatar-edit { width: 28px; height: 28px; }
    .profil-avatar-edit svg { width: 12px; height: 12px; }
    .profil-fields { grid-template-columns: 1fr; gap: 0.625rem; }
    .profil-field.full { grid-column: span 1; }
    .profil-hero-actions { flex-direction: column; }
    .profil-btn { width: 100%; }
    .profil-card-body { padding: 1rem; }
    .profil-card-header { padding: 0.875rem 1rem; }
    .profil-stats-row { grid-template-columns: 1fr 1fr; gap: 0.5rem; }
    .profil-stat { padding: 0.875rem; gap: 0.75rem; }
    .profil-stat-icon { width: 38px; height: 38px; }
    .profil-stat-icon svg { width: 18px; height: 18px; }
    .profil-stat-value { font-size: 1.125rem; }

    .profil-actions-grid { grid-template-columns: 1fr; gap: 0.5rem; }
    .profil-action-link { flex-direction: row; text-align: left; padding: 0.875rem 1rem; gap: 0.875rem; }
    .profil-action-link .profil-action-content { text-align: left; }
    .profil-action-link .profil-action-arrow { display: flex; }
    .profil-action-arrow {
        width: 28px; height: 28px;
        display: flex; align-items: center; justify-content: center;
        background: var(--ind-50); border-radius: var(--r-sm);
        color: var(--text-2); transition: all 0.2s ease; flex-shrink: 0;
    }
    .profil-action-link:hover .profil-action-arrow { background: var(--ind-500); color: white; }
    .profil-action-arrow svg { width: 14px; height: 14px; }
    .profil-action-icon { width: 40px; height: 40px; }
}
</style>
@endsection

@section('content')
<div class="profil-page">
    <!-- Toast Notifications -->
    @if(session('success'))
        <div class="profil-toast success" id="successToast" style="position:fixed;top:1.25rem;right:1.25rem;z-index:1000;">
            <div class="profil-toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="profil-toast-content">
                <div class="profil-toast-title">Modifications enregistrees</div>
                <div class="profil-toast-message">{{ session('success') }}</div>
            </div>
            <button class="profil-toast-close" onclick="closeToast('successToast')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="profil-toast-progress"></div>
        </div>
    @endif

    @if(session('error'))
        <div class="profil-toast error" id="errorToast" style="position:fixed;top:1.25rem;right:1.25rem;z-index:1000;">
            <div class="profil-toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            <div class="profil-toast-content">
                <div class="profil-toast-title">Erreur</div>
                <div class="profil-toast-message">{{ session('error') }}</div>
            </div>
            <button class="profil-toast-close" onclick="closeToast('errorToast')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            <div class="profil-toast-progress"></div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="profil-hero">
        <div class="profil-hero-cover">
            <div class="profil-hero-shape"></div>
            <div class="profil-hero-shape"></div>
            <div class="profil-hero-shape"></div>
            <div class="profil-hero-grid"></div>
            <div class="profil-hero-fade"></div>
        </div>
        <div class="profil-hero-body">
            <!-- Avatar -->
            <div class="profil-avatar-wrapper">
                <div class="profil-avatar-container">
                    <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="profil-avatar">
                </div>
                <button class="profil-avatar-edit" onclick="openModal('photoModal')" title="Changer la photo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </button>
            </div>

            <!-- Identity -->
            <div class="profil-identity">
                <h1 class="profil-name">{{ $personnel->nom_complet }}</h1>
                <p class="profil-role">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                    {{ $personnel->poste ?? 'Poste non defini' }}
                </p>
                <div class="profil-badges">
                    <span class="profil-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                        </svg>
                        {{ $personnel->matricule }}
                    </span>
                    <span class="profil-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        {{ $personnel->type_contrat }}
                    </span>
                    @if($personnel->is_active)
                        <span class="profil-badge active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Actif
                        </span>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="profil-hero-actions">
                <button class="profil-btn primary" onclick="openModal('editModal')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Modifier</span>
                </button>
                <a href="{{ route('espace-employe.parametres') }}" class="profil-btn secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Parametres
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Row -->
    <div class="profil-stats-row">
        <div class="profil-stat">
            <div class="profil-stat-icon violet">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="profil-stat-info">
                <div class="profil-stat-value">{{ $personnel->anciennete ?? 0 }}</div>
                <div class="profil-stat-label">Annees d'anciennete</div>
            </div>
        </div>
        <div class="profil-stat">
            <div class="profil-stat-icon teal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="profil-stat-info">
                <div class="profil-stat-value">25</div>
                <div class="profil-stat-label">Jours de conges</div>
            </div>
        </div>
        <div class="profil-stat">
            <div class="profil-stat-icon indigo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="profil-stat-info">
                <div class="profil-stat-value">{{ $personnel->documents()->count() }}</div>
                <div class="profil-stat-label">Documents</div>
            </div>
        </div>
        <div class="profil-stat">
            <div class="profil-stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="profil-stat-info">
                <div class="profil-stat-value">{{ $personnel->age ?? '-' }}</div>
                <div class="profil-stat-label">Ans</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="profil-grid">
        <!-- Left — Informations personnelles -->
        <article class="profil-card">
            <header class="profil-card-header">
                <h2 class="profil-card-title">
                    <span class="profil-card-icon primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    Informations personnelles
                </h2>
            </header>
            <div class="profil-card-body">
                <!-- Identite -->
                <div class="profil-section">
                    <h4 class="profil-section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <circle cx="9" cy="10" r="2"></circle>
                            <path d="M15 8h2"></path><path d="M15 12h2"></path><path d="M7 16h10"></path>
                        </svg>
                        Identite
                    </h4>
                    <div class="profil-fields">
                        <div class="profil-field">
                            <span class="profil-field-label">Nom</span>
                            <span class="profil-field-value">{{ $personnel->nom }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Prenoms</span>
                            <span class="profil-field-value">{{ $personnel->prenoms }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Civilite</span>
                            <span class="profil-field-value {{ !$personnel->civilite ? 'empty' : '' }}">{{ $personnel->civilite ?? 'Non renseigne' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Sexe</span>
                            <span class="profil-field-value">{{ $personnel->sexe === 'M' ? 'Masculin' : ($personnel->sexe === 'F' ? 'Feminin' : 'Non renseigne') }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Date de naissance</span>
                            <span class="profil-field-value {{ !$personnel->date_naissance ? 'empty' : '' }}">{{ $personnel->date_naissance ? $personnel->date_naissance->format('d/m/Y') : 'Non renseignee' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">N. Identification</span>
                            <span class="profil-field-value {{ !$personnel->numero_identification ? 'empty' : '' }}">{{ $personnel->numero_identification ?? 'Non renseigne' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Coordonnees -->
                <div class="profil-section">
                    <h4 class="profil-section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Coordonnees
                    </h4>
                    <div class="profil-fields">
                        <div class="profil-field full">
                            <span class="profil-field-label">Email professionnel</span>
                            <span class="profil-field-value highlight">{{ $personnel->email }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Telephone</span>
                            <span class="profil-field-value {{ !$personnel->telephone ? 'empty' : '' }}">{{ $personnel->telephone_complet ?? 'Non renseigne' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Telephone secondaire</span>
                            <span class="profil-field-value empty">Non renseigne</span>
                        </div>
                        <div class="profil-field full">
                            <span class="profil-field-label">Adresse</span>
                            <span class="profil-field-value {{ !$personnel->adresse ? 'empty' : '' }}">{{ $personnel->adresse ?? 'Non renseignee' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Right — Informations professionnelles -->
        <article class="profil-card">
            <header class="profil-card-header">
                <h2 class="profil-card-title">
                    <span class="profil-card-icon success">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                    </span>
                    Informations professionnelles
                </h2>
            </header>
            <div class="profil-card-body">
                <!-- Organisation -->
                <div class="profil-section">
                    <h4 class="profil-section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Organisation
                    </h4>
                    <div class="profil-fields">
                        <div class="profil-field full">
                            <span class="profil-field-label">Entreprise</span>
                            <span class="profil-field-value highlight">{{ $personnel->entreprise->nom ?? 'Non assigne' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Departement</span>
                            <span class="profil-field-value">{{ $personnel->departement->nom ?? 'Non assigne' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Service</span>
                            <span class="profil-field-value">{{ $personnel->service->nom ?? 'Non assigne' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Contrat -->
                <div class="profil-section">
                    <h4 class="profil-section-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                        Contrat
                    </h4>
                    <div class="profil-fields">
                        <div class="profil-field full">
                            <span class="profil-field-label">Poste occupe</span>
                            <span class="profil-field-value highlight">{{ $personnel->poste ?? 'Non defini' }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Type de contrat</span>
                            <span class="profil-field-value">{{ $personnel->statut_contrat }}</span>
                        </div>
                        <div class="profil-field">
                            <span class="profil-field-label">Date d'embauche</span>
                            <span class="profil-field-value {{ !$personnel->date_embauche ? 'empty' : '' }}">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignee' }}</span>
                        </div>
                        @if($personnel->date_fin_contrat)
                            <div class="profil-field full">
                                <span class="profil-field-label">Date de fin de contrat</span>
                                <span class="profil-field-value">{{ $personnel->date_fin_contrat->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </article>

        <!-- Quick Actions — Full Width -->
        <article class="profil-card profil-grid-full">
            <header class="profil-card-header">
                <h2 class="profil-card-title">
                    <span class="profil-card-icon accent">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                    </span>
                    Acces rapide
                </h2>
            </header>
            <div class="profil-card-body">
                <div class="profil-actions-grid">
                    <a href="{{ route('espace-employe.documents') }}" class="profil-action-link">
                        <div class="profil-action-icon" style="background: linear-gradient(135deg, var(--ind-500), var(--ind-600)); color: white; box-shadow: 0 4px 12px rgba(99,102,241,.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="profil-action-content">
                            <div class="profil-action-title">Mon dossier</div>
                            <div class="profil-action-desc">Consulter mes documents</div>
                        </div>
                        <span class="profil-action-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <a href="{{ route('espace-employe.bulletins') }}" class="profil-action-link">
                        <div class="profil-action-icon" style="background: linear-gradient(135deg, var(--teal-500), var(--teal-600)); color: white; box-shadow: 0 4px 12px rgba(20,184,166,.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                            </svg>
                        </div>
                        <div class="profil-action-content">
                            <div class="profil-action-title">Bulletins de paie</div>
                            <div class="profil-action-desc">Consulter mes bulletins</div>
                        </div>
                        <span class="profil-action-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <a href="{{ route('espace-employe.parametres') }}" class="profil-action-link">
                        <div class="profil-action-icon" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6); color: white; box-shadow: 0 4px 12px rgba(124,58,237,.25);">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <div class="profil-action-content">
                            <div class="profil-action-title">Securite du compte</div>
                            <div class="profil-action-desc">Mot de passe et 2FA</div>
                        </div>
                        <span class="profil-action-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>

<!-- Edit Modal -->
<div class="profil-modal-overlay" id="editModal">
    <div class="profil-modal">
        <div class="profil-modal-header">
            <h3 class="profil-modal-title">Modifier mes informations</h3>
            <p class="profil-modal-subtitle">Mettez a jour vos coordonnees personnelles</p>
            <button class="profil-modal-close" onclick="closeModal('editModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="profil-modal-body">
                <div class="profil-form-group">
                    <label class="profil-form-label">Numero de telephone</label>
                    <input type="text" name="telephone" class="profil-form-input" value="{{ $personnel->telephone }}" placeholder="Ex: 07 08 09 10 11">
                </div>
                <div class="profil-form-group">
                    <label class="profil-form-label">Adresse de residence</label>
                    <input type="text" name="adresse" class="profil-form-input" value="{{ $personnel->adresse }}" placeholder="Ex: Cocody, Abidjan">
                </div>
            </div>
            <div class="profil-modal-footer">
                <button type="button" class="profil-btn secondary" onclick="closeModal('editModal')">Annuler</button>
                <button type="submit" class="profil-btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Photo Modal -->
<div class="profil-modal-overlay" id="photoModal">
    <div class="profil-modal">
        <div class="profil-modal-header">
            <h3 class="profil-modal-title">Modifier ma photo</h3>
            <p class="profil-modal-subtitle">Choisissez une nouvelle photo de profil</p>
            <button class="profil-modal-close" onclick="closeModal('photoModal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form action="{{ route('espace-employe.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="profil-modal-body">
                <label class="profil-upload" id="uploadZone">
                    <input type="file" name="photo" accept="image/*" onchange="previewPhoto(this)">
                    <div class="profil-upload-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                    </div>
                    <div class="profil-upload-text">Cliquez ou glissez-deposez votre photo</div>
                    <div class="profil-upload-hint">JPG, PNG — Max 2 Mo</div>
                </label>
                <div class="profil-upload-preview" id="photoPreview">
                    <img id="previewImage" src="" alt="Apercu">
                </div>
            </div>
            <div class="profil-modal-footer">
                <button type="button" class="profil-btn secondary" onclick="closeModal('photoModal')">Annuler</button>
                <button type="submit" class="profil-btn primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                    Changer la photo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) { modal.classList.add('show'); document.body.style.overflow = 'hidden'; }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) { modal.classList.remove('show'); document.body.style.overflow = ''; }
}

function closeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) { toast.classList.add('hiding'); setTimeout(() => toast.remove(), 300); }
}

document.querySelectorAll('.profil-toast').forEach(toast => {
    setTimeout(() => { toast.classList.add('hiding'); setTimeout(() => toast.remove(), 300); }, 5000);
});

function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('photoPreview').classList.add('show');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

const uploadZone = document.getElementById('uploadZone');
if (uploadZone) {
    ['dragover', 'dragenter'].forEach(t => uploadZone.addEventListener(t, e => { e.preventDefault(); uploadZone.classList.add('dragover'); }));
    ['dragleave', 'dragend', 'drop'].forEach(t => uploadZone.addEventListener(t, e => { e.preventDefault(); uploadZone.classList.remove('dragover'); }));
    uploadZone.addEventListener('drop', e => {
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const input = uploadZone.querySelector('input[type="file"]');
            const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files;
            previewPhoto(input);
        }
    });
}

document.querySelectorAll('.profil-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) { this.classList.remove('show'); document.body.style.overflow = ''; }
    });
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.profil-modal-overlay.show').forEach(m => m.classList.remove('show'));
        document.body.style.overflow = '';
    }
});
</script>
@endsection
