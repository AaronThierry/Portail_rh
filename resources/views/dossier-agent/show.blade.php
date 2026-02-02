@extends('layouts.app')

@section('title', 'Dossier de ' . $personnel->nom . ' ' . $personnel->prenoms)

@section('styles')
<style>
/* ============================================================
   DOSSIER SHOW — Swiss Corporate Editorial Design System
   Geometric precision · Warm accents · Editorial typography
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap');

:root {
    --e-slate-50: #f8fafc;
    --e-slate-100: #f1f5f9;
    --e-slate-200: #e2e8f0;
    --e-slate-300: #cbd5e1;
    --e-slate-400: #94a3b8;
    --e-slate-500: #64748b;
    --e-slate-600: #475569;
    --e-slate-700: #334155;
    --e-slate-800: #1e293b;
    --e-slate-900: #0f172a;
    --e-slate-950: #020617;
    --e-blue: #3b7dd8;
    --e-blue-deep: #2563a0;
    --e-blue-pale: #dbeafe;
    --e-blue-wash: #eff6ff;
    --e-amber: #e8850c;
    --e-amber-bright: #f59e0b;
    --e-amber-pale: #fef3c7;
    --e-amber-wash: #fffbeb;
    --e-emerald: #059669;
    --e-emerald-pale: #d1fae5;
    --e-red: #dc2626;
    --e-red-pale: #fee2e2;
    --e-surface: #ffffff;
    --e-bg: var(--e-slate-50);
    --e-text: var(--e-slate-900);
    --e-text-secondary: var(--e-slate-500);
    --e-text-tertiary: var(--e-slate-400);
    --e-border: var(--e-slate-200);
    --e-border-light: var(--e-slate-100);
    --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
    --e-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --e-shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
    --e-shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
    --e-shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
    --e-radius: 12px;
    --e-radius-lg: 16px;
    --e-radius-xl: 20px;
    --e-font-body: 'DM Sans', 'Plus Jakarta Sans', system-ui, sans-serif;
    --e-font-display: 'DM Serif Display', Georgia, serif;
}

.dark {
    --e-surface: var(--e-slate-800);
    --e-bg: var(--e-slate-900);
    --e-text: var(--e-slate-100);
    --e-text-secondary: var(--e-slate-400);
    --e-text-tertiary: var(--e-slate-500);
    --e-border: var(--e-slate-700);
    --e-border-light: var(--e-slate-800);
    --e-blue-pale: rgba(59, 125, 216, 0.15);
    --e-blue-wash: rgba(59, 125, 216, 0.08);
    --e-amber-pale: rgba(232, 133, 12, 0.15);
    --e-amber-wash: rgba(232, 133, 12, 0.08);
    --e-emerald-pale: rgba(5, 150, 105, 0.15);
    --e-red-pale: rgba(220, 38, 38, 0.15);
    --e-shadow-sm: 0 1px 2px rgba(0,0,0,0.2);
    --e-shadow: 0 1px 3px rgba(0,0,0,0.3);
    --e-shadow-md: 0 4px 6px rgba(0,0,0,0.25);
    --e-shadow-lg: 0 10px 15px rgba(0,0,0,0.3);
    --e-shadow-xl: 0 20px 25px rgba(0,0,0,0.35);
}

/* ==================== ANIMATIONS ==================== */
@keyframes ds-fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes ds-scaleIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes ds-countUp {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes ds-slideDown {
    from { opacity: 0; transform: translateY(-10px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

/* ==================== PAGE ==================== */
.ds-page {
    font-family: var(--e-font-body);
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 1.5rem 3rem;
    color: var(--e-text);
}

/* ==================== BREADCRUMB ==================== */
.ds-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-size: 0.8125rem;
    font-weight: 500;
    animation: ds-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.ds-breadcrumb a {
    color: var(--e-text-secondary);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: color 0.2s;
}

.ds-breadcrumb a:hover {
    color: var(--e-blue);
}

.ds-breadcrumb .ds-breadcrumb-sep {
    color: var(--e-text-tertiary);
    font-size: 0.75rem;
}

.ds-breadcrumb .ds-breadcrumb-current {
    color: var(--e-text);
    font-weight: 600;
}

/* ==================== AGENT HEADER ==================== */
.ds-agent-header {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--e-shadow);
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    align-items: center;
    animation: ds-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.05s both;
}

.ds-agent-profile {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
    min-width: 300px;
}

.ds-agent-avatar {
    width: 96px;
    height: 96px;
    border-radius: var(--e-radius-xl);
    background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.25rem;
    font-weight: 700;
    font-family: var(--e-font-display);
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(59, 125, 216, 0.3);
    position: relative;
}

.ds-agent-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: var(--e-radius-xl);
}

.ds-agent-details h1 {
    font-family: var(--e-font-display);
    font-size: 1.625rem;
    font-weight: 400;
    color: var(--e-text);
    margin: 0 0 0.5rem 0;
    letter-spacing: -0.01em;
}

.ds-agent-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: var(--e-text-secondary);
    font-size: 0.8125rem;
}

.ds-agent-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.ds-agent-meta svg {
    color: var(--e-text-tertiary);
}

/* ==================== STATS ==================== */
.ds-stats-row {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    align-items: center;
}

.ds-stat-box {
    background: var(--e-bg);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius);
    padding: 0.875rem 1.25rem;
    text-align: center;
    min-width: 90px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-stat-box::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-stat-box:hover {
    border-color: var(--e-border);
    box-shadow: var(--e-shadow-md);
    transform: translateY(-2px);
}

.ds-stat-box:hover::after {
    opacity: 1;
}

.ds-stat-box.ds-stat-primary::after { background: linear-gradient(90deg, var(--e-blue), var(--e-blue-deep)); }
.ds-stat-box.ds-stat-success::after { background: linear-gradient(90deg, var(--e-emerald), #047857); }
.ds-stat-box.ds-stat-danger::after { background: linear-gradient(90deg, var(--e-red), #b91c1c); }
.ds-stat-box.ds-stat-warning::after { background: linear-gradient(90deg, var(--e-amber), #d97706); }

.ds-stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    font-family: var(--e-font-display);
    line-height: 1;
    animation: ds-countUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.ds-stat-value.ds-primary { color: var(--e-blue); }
.ds-stat-value.ds-success { color: var(--e-emerald); }
.ds-stat-value.ds-danger { color: var(--e-red); }
.ds-stat-value.ds-warning { color: var(--e-amber); }

.ds-stat-label {
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    margin-top: 0.25rem;
}

/* ==================== ACTION BUTTONS ==================== */
.ds-agent-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.ds-btn {
    padding: 0.75rem 1.25rem;
    border-radius: var(--e-radius);
    border: 1px solid transparent;
    font-weight: 600;
    font-size: 0.8125rem;
    font-family: var(--e-font-body);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    line-height: 1;
}

.ds-btn-primary {
    background: var(--e-blue);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.3);
}

.ds-btn-primary:hover {
    background: var(--e-blue-deep);
    box-shadow: 0 6px 16px rgba(59, 125, 216, 0.4);
    transform: translateY(-1px);
    color: white;
}

.ds-btn-outline {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}

.ds-btn-outline:hover {
    border-color: var(--e-slate-300);
    color: var(--e-text);
    background: var(--e-bg);
}

/* ==================== FLASH MESSAGES ==================== */
.ds-flash {
    padding: 1rem 1.25rem;
    border-radius: var(--e-radius);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    animation: ds-slideDown 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.ds-flash-success {
    background: var(--e-emerald-pale);
    color: #065f46;
    border: 1px solid rgba(5, 150, 105, 0.2);
}

.ds-flash-error {
    background: var(--e-red-pale);
    color: #991b1b;
    border: 1px solid rgba(220, 38, 38, 0.2);
}

/* ==================== DOCUMENTS SECTION ==================== */
.ds-docs-section {
    margin-bottom: 2rem;
    animation: ds-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.ds-docs-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 0 0.25rem;
}

.ds-docs-section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--e-text);
}

.ds-docs-section-title .ds-cat-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.ds-docs-section-title .ds-cat-count {
    color: var(--e-text-tertiary);
    font-weight: 400;
    font-size: 0.875rem;
}

/* ==================== DOCUMENTS GRID ==================== */
.ds-docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 1rem;
}

/* ==================== DOCUMENT CARD (from partial) ==================== */
.ds-doc-card {
    background: var(--e-surface);
    border: 1px solid var(--e-border);
    border-radius: var(--e-radius-lg);
    overflow: hidden;
    box-shadow: var(--e-shadow-sm);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    animation: ds-scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
}

.ds-doc-card:hover {
    box-shadow: var(--e-shadow-lg);
    border-color: var(--e-blue);
    transform: translateY(-3px);
}

.ds-doc-card-header {
    padding: 1rem 1rem 0.75rem;
    display: flex;
    align-items: flex-start;
    gap: 0.875rem;
}

.ds-doc-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ds-doc-icon.pdf { background: var(--e-red-pale); color: var(--e-red); }
.ds-doc-icon.doc { background: var(--e-blue-pale); color: var(--e-blue); }
.ds-doc-icon.xls { background: var(--e-emerald-pale); color: var(--e-emerald); }
.ds-doc-icon.img { background: var(--e-amber-pale); color: var(--e-amber); }
.ds-doc-icon.default { background: var(--e-slate-100); color: var(--e-text-secondary); }

.ds-doc-info {
    flex: 1;
    min-width: 0;
}

.ds-doc-title {
    font-weight: 600;
    color: var(--e-text);
    font-size: 0.875rem;
    margin: 0 0 0.125rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

.ds-doc-filename {
    font-size: 0.6875rem;
    color: var(--e-text-tertiary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ds-doc-badges {
    display: flex;
    gap: 0.375rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.ds-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 100px;
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.ds-badge-danger { background: var(--e-red-pale); color: var(--e-red); }
.ds-badge-warning { background: var(--e-amber-pale); color: var(--e-amber); }
.ds-badge-confidential { background: var(--e-amber-wash); color: #92400e; }

.ds-doc-card-body {
    padding: 0.75rem 1rem 1rem;
}

.ds-doc-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.375rem;
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    margin-bottom: 0.875rem;
}

.ds-doc-meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.ds-doc-meta-item svg {
    flex-shrink: 0;
    color: var(--e-text-tertiary);
}

.ds-meta-expired {
    color: var(--e-red) !important;
}

.ds-meta-expired svg {
    color: var(--e-red) !important;
}

.ds-doc-actions {
    display: flex;
    gap: 0.5rem;
}

.ds-doc-btn {
    flex: 1;
    padding: 0.5rem;
    border-radius: 8px;
    border: 1px solid transparent;
    cursor: pointer;
    font-size: 0.75rem;
    font-weight: 600;
    font-family: var(--e-font-body);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    text-decoration: none;
    line-height: 1;
}

.ds-doc-btn-download {
    background: var(--e-blue);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 125, 216, 0.25);
}

.ds-doc-btn-download:hover {
    background: var(--e-blue-deep);
    box-shadow: 0 4px 12px rgba(59, 125, 216, 0.35);
    transform: translateY(-1px);
    color: white;
}

.ds-doc-btn-preview {
    background: var(--e-bg);
    color: var(--e-text-secondary);
    border-color: var(--e-border);
}

.ds-doc-btn-preview:hover {
    border-color: var(--e-slate-300);
    color: var(--e-text);
}

.ds-doc-btn-delete {
    background: var(--e-red-pale);
    color: var(--e-red);
    padding: 0.5rem 0.625rem;
    flex: 0;
}

.ds-doc-btn-delete:hover {
    background: #fecaca;
    transform: translateY(-1px);
}

/* ==================== EMPTY CATEGORY ==================== */
.ds-empty-category {
    text-align: center;
    padding: 2.5rem;
    background: var(--e-surface);
    border: 2px dashed var(--e-border);
    border-radius: var(--e-radius-lg);
}

.ds-empty-category-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 0.75rem;
    background: var(--e-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--e-text-tertiary);
}

.ds-empty-category p {
    color: var(--e-text-secondary);
    margin: 0;
    font-size: 0.8125rem;
}

/* ==================== UPLOAD MODAL ==================== */
.ds-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-modal-overlay.show {
    display: flex;
    opacity: 1;
}

.ds-modal-content {
    background: var(--e-surface);
    border-radius: var(--e-radius-xl);
    width: 100%;
    max-width: 660px;
    max-height: 92vh;
    overflow: hidden;
    box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.05);
    transform: scale(0.92) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-modal-overlay.show .ds-modal-content {
    transform: scale(1) translateY(0);
}

/* Modal Header — dark gradient slate */
.ds-modal-header {
    background: linear-gradient(135deg, var(--e-slate-800) 0%, var(--e-slate-900) 100%);
    color: white;
    padding: 1.75rem 2rem 1.5rem;
    position: relative;
    overflow: hidden;
}

.ds-modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 280px;
    height: 280px;
    background: radial-gradient(circle, rgba(59, 125, 216, 0.25) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.ds-modal-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.ds-modal-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.ds-modal-icon {
    width: 50px;
    height: 50px;
    background: rgba(59, 125, 216, 0.2);
    backdrop-filter: blur(8px);
    border-radius: var(--e-radius);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(59, 125, 216, 0.3);
    flex-shrink: 0;
}

.ds-modal-icon svg {
    width: 24px;
    height: 24px;
}

.ds-modal-title-group h3 {
    margin: 0 0 0.25rem;
    font-family: var(--e-font-display);
    font-size: 1.25rem;
    font-weight: 400;
    letter-spacing: -0.01em;
}

.ds-modal-subtitle {
    margin: 0;
    font-size: 0.8125rem;
    color: rgba(255, 255, 255, 0.65);
}

.ds-modal-close {
    position: absolute;
    right: 1.25rem;
    top: 1.25rem;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.125rem;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
}

.ds-modal-close:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: rotate(90deg);
}

.ds-modal-body {
    padding: 1.75rem 2rem;
    max-height: calc(92vh - 200px);
    overflow-y: auto;
}

.ds-modal-body::-webkit-scrollbar {
    width: 5px;
}

.ds-modal-body::-webkit-scrollbar-track {
    background: var(--e-slate-100);
    border-radius: 3px;
}

.ds-modal-body::-webkit-scrollbar-thumb {
    background: var(--e-slate-300);
    border-radius: 3px;
}

.ds-modal-body::-webkit-scrollbar-thumb:hover {
    background: var(--e-slate-400);
}

/* ==================== FORM STYLES ==================== */
.ds-form-group {
    margin-bottom: 1.25rem;
}

.ds-form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--e-text);
    margin-bottom: 0.5rem;
    font-size: 0.8125rem;
}

.ds-form-label svg {
    width: 15px;
    height: 15px;
    color: var(--e-blue);
}

.ds-form-label .ds-required {
    color: var(--e-red);
    font-weight: 700;
}

.ds-form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--e-border);
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-family: var(--e-font-body);
    color: var(--e-text);
    background: var(--e-surface);
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-form-control:hover {
    border-color: var(--e-slate-300);
}

.ds-form-control:focus {
    outline: none;
    border-color: var(--e-blue);
    box-shadow: 0 0 0 3px rgba(59, 125, 216, 0.12);
}

.ds-form-control::placeholder {
    color: var(--e-text-tertiary);
}

/* ==================== FILE UPLOAD ZONE ==================== */
.ds-file-upload-zone {
    border: 2px dashed var(--e-border);
    border-radius: var(--e-radius-lg);
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    overflow: hidden;
    background: var(--e-bg);
}

.ds-file-upload-zone:hover {
    border-color: var(--e-blue);
    background: var(--e-blue-wash);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(59, 125, 216, 0.1);
}

.ds-file-upload-zone.dragover {
    border-color: var(--e-blue);
    border-style: solid;
    background: var(--e-blue-pale);
    transform: scale(1.01);
}

.ds-file-upload-zone.has-file {
    border-color: var(--e-emerald);
    border-style: solid;
    background: var(--e-emerald-pale);
}

.ds-file-upload-icon {
    width: 68px;
    height: 68px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    position: relative;
    z-index: 1;
    box-shadow: 0 8px 24px rgba(59, 125, 216, 0.3);
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.ds-file-upload-zone:hover .ds-file-upload-icon {
    transform: scale(1.05) rotate(-2deg);
}

.ds-file-upload-icon svg {
    width: 30px;
    height: 30px;
}

.ds-file-upload-icon.success {
    background: linear-gradient(135deg, var(--e-emerald) 0%, #047857 100%);
    box-shadow: 0 8px 24px rgba(5, 150, 105, 0.3);
}

.ds-file-upload-text {
    position: relative;
    z-index: 1;
}

.ds-file-upload-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--e-text);
    margin: 0 0 0.25rem;
}

.ds-file-upload-subtitle {
    font-size: 0.75rem;
    color: var(--e-text-secondary);
    margin: 0 0 0.75rem;
}

.ds-file-upload-formats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.375rem;
}

.ds-file-format-badge {
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border: 1px solid var(--e-border);
}

.ds-file-selected-info {
    display: none;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.875rem;
    background: var(--e-surface);
    border-radius: var(--e-radius);
    margin-top: 1rem;
    border: 1px solid rgba(5, 150, 105, 0.2);
}

.ds-file-upload-zone.has-file .ds-file-selected-info {
    display: flex;
}

.ds-file-selected-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ds-file-selected-icon.pdf { background: linear-gradient(135deg, var(--e-red) 0%, #b91c1c 100%); color: white; }
.ds-file-selected-icon.doc { background: linear-gradient(135deg, var(--e-blue) 0%, var(--e-blue-deep) 100%); color: white; }
.ds-file-selected-icon.xls { background: linear-gradient(135deg, var(--e-emerald) 0%, #047857 100%); color: white; }
.ds-file-selected-icon.img { background: linear-gradient(135deg, var(--e-amber) 0%, #d97706 100%); color: white; }
.ds-file-selected-icon.default { background: linear-gradient(135deg, var(--e-slate-500) 0%, var(--e-slate-600) 100%); color: white; }

.ds-file-selected-icon svg {
    width: 18px;
    height: 18px;
}

.ds-file-selected-name {
    flex: 1;
    font-weight: 600;
    color: var(--e-text);
    font-size: 0.8125rem;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.ds-file-selected-size {
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    font-weight: 500;
}

.ds-file-remove-btn {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: none;
    background: var(--e-red-pale);
    color: var(--e-red);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.ds-file-remove-btn:hover {
    background: #fecaca;
}

.ds-file-remove-btn svg {
    width: 14px;
    height: 14px;
}

/* Form Row */
.ds-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

/* Checkbox */
.ds-form-check-group {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.ds-form-check {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    background: var(--e-bg);
    border-radius: var(--e-radius);
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    flex: 1;
    min-width: 180px;
}

.ds-form-check:hover {
    background: var(--e-slate-100);
    border-color: var(--e-border);
}

.ds-form-check.checked {
    background: var(--e-blue-wash);
    border-color: var(--e-blue);
}

.ds-form-check input[type="checkbox"] {
    display: none;
}

.ds-form-check-box {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid var(--e-slate-300);
    background: var(--e-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.ds-form-check.checked .ds-form-check-box {
    background: var(--e-blue);
    border-color: transparent;
}

.ds-form-check-box svg {
    width: 12px;
    height: 12px;
    color: white;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s;
}

.ds-form-check.checked .ds-form-check-box svg {
    opacity: 1;
    transform: scale(1);
}

.ds-form-check-content {
    flex: 1;
}

.ds-form-check-label {
    font-weight: 600;
    font-size: 0.8125rem;
    color: var(--e-text);
    display: block;
}

.ds-form-check-desc {
    font-size: 0.6875rem;
    color: var(--e-text-secondary);
    margin-top: 0.125rem;
}

.ds-form-check-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ds-form-check-icon.confidential {
    background: var(--e-red-pale);
    color: var(--e-red);
}

.ds-form-check-icon.visible {
    background: var(--e-emerald-pale);
    color: var(--e-emerald);
}

.ds-form-check-icon svg {
    width: 16px;
    height: 16px;
}

/* Modal Footer */
.ds-modal-footer {
    padding: 1.25rem 2rem;
    background: var(--e-bg);
    border-top: 1px solid var(--e-border);
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.ds-btn-modal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--e-radius);
    font-size: 0.875rem;
    font-weight: 600;
    font-family: var(--e-font-body);
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border: none;
    line-height: 1;
}

.ds-btn-modal svg {
    width: 16px;
    height: 16px;
}

.ds-btn-modal-cancel {
    background: var(--e-surface);
    color: var(--e-text-secondary);
    border: 1.5px solid var(--e-border);
}

.ds-btn-modal-cancel:hover {
    border-color: var(--e-slate-300);
    color: var(--e-text);
}

.ds-btn-modal-submit {
    background: var(--e-blue);
    color: white;
    box-shadow: 0 4px 14px rgba(59, 125, 216, 0.3);
}

.ds-btn-modal-submit:hover {
    background: var(--e-blue-deep);
    box-shadow: 0 6px 18px rgba(59, 125, 216, 0.4);
    transform: translateY(-1px);
}

.ds-btn-modal-submit:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Form Section Dividers */
.ds-form-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--e-border-light);
}

.ds-form-section-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--e-text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
}

.ds-form-section-title svg {
    width: 14px;
    height: 14px;
    color: var(--e-text-tertiary);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .ds-agent-header {
        flex-direction: column;
        padding: 1.5rem;
    }

    .ds-agent-profile {
        flex-direction: column;
        text-align: center;
        min-width: auto;
    }

    .ds-agent-meta {
        justify-content: center;
    }

    .ds-stats-row {
        justify-content: center;
    }

    .ds-agent-actions {
        justify-content: center;
    }

    .ds-form-row {
        grid-template-columns: 1fr;
    }

    .ds-docs-grid {
        grid-template-columns: 1fr;
    }

    .ds-form-check-group {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="ds-page">
    <!-- Breadcrumb -->
    <div class="ds-breadcrumb">
        <a href="{{ route('admin.dossiers-agents.index') }}">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span class="ds-breadcrumb-sep">/</span>
        <span class="ds-breadcrumb-current">{{ $personnel->nom }} {{ $personnel->prenoms }}</span>
    </div>

    <!-- Header Agent -->
    <div class="ds-agent-header">
        <div class="ds-agent-profile">
            <div class="ds-agent-avatar">
                @if($personnel->photo)
                    <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                @else
                    {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms, 0, 1)) }}
                @endif
            </div>
            <div class="ds-agent-details">
                <h1>{{ $personnel->nom }} {{ $personnel->prenoms }}</h1>
                <div class="ds-agent-meta">
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        {{ $personnel->matricule ?? 'Sans matricule' }}
                    </span>
                    @if($personnel->departement)
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $personnel->departement->nom }}
                    </span>
                    @endif
                    @if($personnel->poste)
                    <span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $personnel->poste }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="ds-stats-row">
            <div class="ds-stat-box ds-stat-primary">
                <div class="ds-stat-value ds-primary">{{ $stats['total'] }}</div>
                <div class="ds-stat-label">Documents</div>
            </div>
            <div class="ds-stat-box ds-stat-success">
                <div class="ds-stat-value ds-success">{{ $stats['actifs'] }}</div>
                <div class="ds-stat-label">Actifs</div>
            </div>
            @if($stats['expires'] > 0)
            <div class="ds-stat-box ds-stat-danger">
                <div class="ds-stat-value ds-danger">{{ $stats['expires'] }}</div>
                <div class="ds-stat-label">Expirés</div>
            </div>
            @endif
            @if($stats['expirent_bientot'] > 0)
            <div class="ds-stat-box ds-stat-warning">
                <div class="ds-stat-value ds-warning">{{ $stats['expirent_bientot'] }}</div>
                <div class="ds-stat-label">Expirent bientôt</div>
            </div>
            @endif
        </div>

        <div class="ds-agent-actions">
            <button onclick="openUploadModal()" class="ds-btn ds-btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Ajouter un document
            </button>
            <a href="{{ route('admin.personnels.show', $personnel) }}" class="ds-btn ds-btn-outline">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Fiche employé
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="ds-flash ds-flash-success">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="ds-flash ds-flash-error">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Documents par catégorie -->
    @foreach($categories as $categorie)
    <div class="ds-docs-section" id="category-{{ $categorie->id }}" style="animation-delay: {{ $loop->index * 0.06 }}s">
        <div class="ds-docs-section-header">
            <div class="ds-docs-section-title">
                <div class="ds-cat-icon" style="background: {{ $categorie->couleur }};">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                {{ $categorie->nom }}
                <span class="ds-cat-count">({{ $categorie->documents_count ?? count($documentsByCategory[$categorie->id] ?? []) }})</span>
            </div>
        </div>

        @if(isset($documentsByCategory[$categorie->id]) && count($documentsByCategory[$categorie->id]) > 0)
        <div class="ds-docs-grid">
            @foreach($documentsByCategory[$categorie->id] as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
        @else
        <div class="ds-empty-category">
            <div class="ds-empty-category-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p>Aucun document dans cette catégorie</p>
        </div>
        @endif
    </div>
    @endforeach

    <!-- Documents sans catégorie -->
    @if(count($documentsSansCategorie) > 0)
    <div class="ds-docs-section">
        <div class="ds-docs-section-header">
            <div class="ds-docs-section-title">
                <div class="ds-cat-icon" style="background: var(--e-slate-400);">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Non classés
                <span class="ds-cat-count">({{ count($documentsSansCategorie) }})</span>
            </div>
        </div>
        <div class="ds-docs-grid">
            @foreach($documentsSansCategorie as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal Upload -->
<div class="ds-modal-overlay" id="uploadModal">
    <div class="ds-modal-content">
        <div class="ds-modal-header">
            <div class="ds-modal-header-content">
                <div class="ds-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div class="ds-modal-title-group">
                    <h3>Ajouter un document</h3>
                    <p class="ds-modal-subtitle">Ajoutez un nouveau document au dossier de {{ $personnel->prenoms }}</p>
                </div>
            </div>
            <button class="ds-modal-close" onclick="closeUploadModal()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.dossier-agent.store', $personnel) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="ds-modal-body">
                <!-- Zone d'upload -->
                <div class="ds-form-group">
                    <label class="ds-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Fichier <span class="ds-required">*</span>
                    </label>
                    <div class="ds-file-upload-zone" id="dropZone">
                        <input type="file" name="document" id="fileInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp" required style="display: none;">
                        <div class="ds-file-upload-icon" id="uploadIcon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div class="ds-file-upload-text">
                            <p class="ds-file-upload-title" id="fileLabel">Cliquez ou glissez votre fichier ici</p>
                            <p class="ds-file-upload-subtitle">Selectionnez un document depuis votre ordinateur</p>
                            <div class="ds-file-upload-formats">
                                <span class="ds-file-format-badge">PDF</span>
                                <span class="ds-file-format-badge">DOC</span>
                                <span class="ds-file-format-badge">XLS</span>
                                <span class="ds-file-format-badge">JPG</span>
                                <span class="ds-file-format-badge">PNG</span>
                            </div>
                        </div>
                        <div class="ds-file-selected-info" id="fileSelectedInfo">
                            <div class="ds-file-selected-icon" id="fileTypeIcon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="ds-file-selected-name" id="fileName">document.pdf</div>
                                <div class="ds-file-selected-size" id="fileSize">2.4 Mo</div>
                            </div>
                            <button type="button" class="ds-file-remove-btn" id="removeFileBtn" onclick="removeFile(event)">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Categorie -->
                <div class="ds-form-group">
                    <label class="ds-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                        Categorie
                    </label>
                    <select name="categorie_id" class="ds-form-control">
                        <option value="">Selectionner une categorie...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Titre -->
                <div class="ds-form-group">
                    <label class="ds-form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Titre du document
                    </label>
                    <input type="text" name="titre" class="ds-form-control" placeholder="Ex: Contrat de travail, CNI recto-verso...">
                </div>

                <!-- Section Dates -->
                <div class="ds-form-section">
                    <div class="ds-form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Informations de date
                    </div>
                    <div class="ds-form-row">
                        <div class="ds-form-group">
                            <label class="ds-form-label">Date du document</label>
                            <input type="date" name="date_document" class="ds-form-control">
                        </div>
                        <div class="ds-form-group">
                            <label class="ds-form-label">Date d'expiration</label>
                            <input type="date" name="date_expiration" class="ds-form-control">
                        </div>
                    </div>
                </div>

                <!-- Section Details -->
                <div class="ds-form-section">
                    <div class="ds-form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Details supplementaires
                    </div>

                    <div class="ds-form-group">
                        <label class="ds-form-label">Reference</label>
                        <input type="text" name="reference" class="ds-form-control" placeholder="Ex: N° de contrat, N° CNI, N° permis...">
                    </div>

                    <div class="ds-form-group">
                        <label class="ds-form-label">Description</label>
                        <textarea name="description" class="ds-form-control" rows="3" placeholder="Ajoutez des notes ou commentaires sur ce document..."></textarea>
                    </div>
                </div>

                <!-- Options -->
                <div class="ds-form-section">
                    <div class="ds-form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                        </svg>
                        Options de visibilite
                    </div>

                    <div class="ds-form-check-group">
                        <label class="ds-form-check" id="confidentielCheck">
                            <input type="checkbox" name="confidentiel" id="confidentiel" value="1">
                            <div class="ds-form-check-icon confidential">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <div class="ds-form-check-content">
                                <span class="ds-form-check-label">Document confidentiel</span>
                                <span class="ds-form-check-desc">Acces restreint aux admins</span>
                            </div>
                            <div class="ds-form-check-box">
                                <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </label>

                        <label class="ds-form-check checked" id="visibleCheck">
                            <input type="checkbox" name="visible_employe" id="visible_employe" value="1" checked>
                            <div class="ds-form-check-icon visible">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                            <div class="ds-form-check-content">
                                <span class="ds-form-check-label">Visible par l'employe</span>
                                <span class="ds-form-check-desc">L'employe peut voir ce document</span>
                            </div>
                            <div class="ds-form-check-box">
                                <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="ds-modal-footer">
                <button type="button" class="ds-btn-modal ds-btn-modal-cancel" onclick="closeUploadModal()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="ds-btn-modal ds-btn-modal-submit" id="submitBtn">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Uploader le document
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Éléments du modal
const uploadModal = document.getElementById('uploadModal');
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const fileSelectedInfo = document.getElementById('fileSelectedInfo');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const fileTypeIcon = document.getElementById('fileTypeIcon');
const uploadForm = document.getElementById('uploadForm');

// Ouvrir le modal
function openUploadModal() {
    uploadModal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

// Fermer le modal
function closeUploadModal() {
    uploadModal.classList.remove('show');
    document.body.style.overflow = '';
    resetUploadForm();
}

// Réinitialiser le formulaire
function resetUploadForm() {
    if (uploadForm) uploadForm.reset();
    dropZone.classList.remove('has-file');
    fileSelectedInfo.style.display = 'none';
    fileInput.value = '';

    // Réinitialiser les checkboxes
    const checkboxes = document.querySelectorAll('.ds-form-check input[type="checkbox"]');
    checkboxes.forEach(cb => {
        cb.checked = false;
        cb.closest('.ds-form-check').classList.remove('checked');
    });
}

// Formater la taille du fichier
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Octets';
    const k = 1024;
    const sizes = ['Octets', 'Ko', 'Mo', 'Go'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Obtenir l'icône selon le type de fichier
function getFileIcon(mimeType, fileName) {
    const ext = fileName.split('.').pop().toLowerCase();

    // PDF
    if (mimeType === 'application/pdf' || ext === 'pdf') {
        return `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <path d="M10 12h4M10 16h4M8 12h.01M8 16h.01"/>
        </svg>`;
    }

    // Images
    if (mimeType.startsWith('image/') || ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
        return `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#e8850c" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21,15 16,10 5,21"/>
        </svg>`;
    }

    // Documents Word
    if (['doc', 'docx'].includes(ext) || mimeType.includes('word')) {
        return `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#3b7dd8" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10,9 9,9 8,9"/>
        </svg>`;
    }

    // Excel
    if (['xls', 'xlsx', 'csv'].includes(ext) || mimeType.includes('spreadsheet') || mimeType.includes('excel')) {
        return `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <rect x="8" y="12" width="8" height="6"/>
            <line x1="12" y1="12" x2="12" y2="18"/>
            <line x1="8" y1="15" x2="16" y2="15"/>
        </svg>`;
    }

    // Fichier générique
    return `<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
        <polyline points="14,2 14,8 20,8"/>
    </svg>`;
}

// Afficher les infos du fichier sélectionné
function displayFileInfo(file) {
    if (!file) return;

    dropZone.classList.add('has-file');
    fileSelectedInfo.style.display = 'flex';
    fileName.textContent = file.name;
    fileSize.textContent = formatFileSize(file.size);
    fileTypeIcon.innerHTML = getFileIcon(file.type, file.name);
}

// Supprimer le fichier sélectionné
function removeFile(e) {
    e.stopPropagation();
    fileInput.value = '';
    dropZone.classList.remove('has-file');
    fileSelectedInfo.style.display = 'none';
}

// Fermer modal en cliquant à l'extérieur
uploadModal.addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

// Click sur la zone de drop
dropZone.addEventListener('click', (e) => {
    if (!e.target.closest('.remove-file')) {
        fileInput.click();
    }
});

// Drag & Drop
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        displayFileInfo(e.dataTransfer.files[0]);
    }
});

// Changement de fichier
fileInput.addEventListener('change', () => {
    if (fileInput.files.length) {
        displayFileInfo(fileInput.files[0]);
    }
});

// Gestion des checkboxes
document.querySelectorAll('.ds-form-check input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.closest('.ds-form-check').classList.add('checked');
        } else {
            this.closest('.ds-form-check').classList.remove('checked');
        }
    });
});

// Supprimer document existant
function deleteDocument(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        fetch(`{{ url('admin/dossier-agent/document') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression');
            }
        })
        .catch(() => alert('Erreur lors de la suppression'));
    }
}

// Escape pour fermer
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeUploadModal();
});

// Animation d'entrée du modal
uploadModal.addEventListener('transitionend', function(e) {
    if (e.propertyName === 'opacity' && this.classList.contains('show')) {
        this.querySelector('.ds-modal-content').focus();
    }
});
</script>
@endsection
