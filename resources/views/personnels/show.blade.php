@extends('layouts.app')

@section('title', 'Détails du Personnel')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
<style>
/* Similar base styles as index but optimized for show page */
.personnel-show {
    padding: 24px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 24px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.back-button:hover {
    color: #667eea;
    transform: translateX(-4px);
}

.personnel-header {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: start;
    gap: 24px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.personnel-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.personnel-header:hover {
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    transform: translateY(-2px);
}

.personnel-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #667eea;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}

.personnel-header-content {
    flex: 1;
}

.personnel-name-header {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
}

.personnel-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-top: 12px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9375rem;
    color: var(--text-muted);
}

.personnel-actions {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(239, 68, 68, 0.5);
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
}

.detail-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.detail-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.detail-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
    border-color: rgba(102, 126, 234, 0.3);
}

.detail-card:hover::before {
    opacity: 1;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--card-border);
}

.card-title svg {
    width: 24px;
    height: 24px;
    padding: 6px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 8px;
    color: #667eea;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid var(--card-border);
    transition: all 0.2s ease;
}

.detail-row:hover {
    padding-left: 8px;
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.03) 0%, transparent 100%);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: var(--text-muted);
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 6px;
}

.detail-value {
    font-weight: 500;
    color: var(--text-primary);
    text-align: right;
    font-size: 0.9375rem;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.badge:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.badge-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
}

.badge-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: #ffffff;
}

.badge-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #ffffff;
}

.badge-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
}

/* User Assignment Card */
.user-assignment-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
}

.no-user-alert {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    border: 2px dashed #f59e0b;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 20px;
}

.no-user-alert p {
    color: #d97706;
    font-weight: 600;
    margin-bottom: 12px;
}

.user-info-display {
    background: var(--bg-secondary);
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.user-info-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
    width: 100%;
    max-width: 500px;
    transform: scale(0.95);
    transition: transform 0.3s ease;
}

.dark .modal {
    background: #1e293b;
}

.modal-overlay.show .modal {
    transform: scale(1);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 24px;
    border-radius: 20px 20px 0 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    flex-shrink: 0;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: scale(1.1) rotate(90deg);
}

.modal-close:active {
    transform: scale(0.95) rotate(90deg);
}

.modal-close svg {
    color: #ffffff;
    stroke-width: 2.5;
}

.modal-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 8px;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 4px;
}

.form-input, .form-select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: all 0.2s ease;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.form-row {
    display: flex;
    gap: 16px;
    margin-bottom: 0;
}

.form-row .form-group {
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px;
    background: var(--bg-secondary);
    border-radius: 8px;
    cursor: pointer;
}

.checkbox-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #667eea;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px;
    border-top: 1px solid var(--card-border);
}

@media (max-width: 768px) {
    .personnel-header {
        flex-direction: column;
        text-align: center;
    }

    .personnel-actions {
        width: 100%;
        flex-direction: column;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }
}

/* ========================================
   STYLES ÉLÉGANTS POUR LES DATES
   ======================================== */

.date-display {
    font-weight: 600 !important;
    color: #10b981 !important;
    font-size: 0.9375rem !important;
    letter-spacing: 0.3px;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
    border-radius: 8px;
    border: 1px solid rgba(16, 185, 129, 0.15);
    transition: all 0.3s ease;
}

.date-display:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(5, 150, 105, 0.12) 100%);
    border-color: rgba(16, 185, 129, 0.25);
    transform: translateX(4px);
}

.date-display::before {
    content: '📅';
    font-size: 1rem;
}

.date-warning {
    color: #f59e0b !important;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.08) 100%) !important;
    border-color: rgba(245, 158, 11, 0.15) !important;
}

.date-warning:hover {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(217, 119, 6, 0.12) 100%) !important;
    border-color: rgba(245, 158, 11, 0.25) !important;
}

.date-warning::before {
    content: '⚠️';
}

.text-muted {
    color: #94a3b8 !important;
    font-style: italic;
    font-weight: 500 !important;
}

/* Dark mode pour les dates */
.dark .date-display {
    color: #34d399 !important;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    border-color: rgba(16, 185, 129, 0.25);
}

.dark .date-display:hover {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
    border-color: rgba(16, 185, 129, 0.35);
}

.dark .date-warning {
    color: #fbbf24 !important;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%) !important;
    border-color: rgba(245, 158, 11, 0.25) !important;
}

.dark .date-warning:hover {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%) !important;
    border-color: rgba(245, 158, 11, 0.35) !important;
}

.dark .text-muted {
    color: #64748b !important;
}

/* ========================================
   STYLES FORMULAIRE AMÉLIORATION
   ======================================== */

.form-section {
    margin-bottom: 24px;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--card-border);
}

.section-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 10px;
    color: #667eea;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 0;
    }
}

.form-hint {
    display: block;
    font-size: 0.8125rem;
    color: var(--text-muted);
    margin-top: 6px;
    font-style: italic;
}

.form-error {
    display: block;
    font-size: 0.8125rem;
    color: #ef4444;
    margin-top: 6px;
    font-weight: 500;
}

.form-input:invalid:not(:placeholder-shown) {
    border-color: #ef4444;
}

.form-input:valid:not(:placeholder-shown) {
    border-color: #10b981;
}

textarea.form-input {
    resize: vertical;
    min-height: 60px;
    font-family: inherit;
    line-height: 1.5;
}

/* Toggle Switch Moderne */
.status-toggle {
    background: var(--bg-secondary);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    padding: 16px;
    transition: all 0.3s ease;
}

.status-toggle:hover {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
}

.toggle-input {
    display: none;
}

.toggle-label {
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
    user-select: none;
}

.toggle-switch {
    position: relative;
    width: 56px;
    height: 28px;
    background: #cbd5e1;
    border-radius: 28px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.toggle-switch::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 22px;
    height: 22px;
    background: #ffffff;
    border-radius: 50%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-input:checked + .toggle-label .toggle-switch {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.toggle-input:checked + .toggle-label .toggle-switch::after {
    left: 31px;
}

.toggle-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
}

.toggle-title {
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--text-primary);
}

.toggle-desc {
    font-size: 0.8125rem;
    color: var(--text-muted);
}

/* Animation pour l'ouverture modale */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-overlay.show .modal {
    animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Amélioration des boutons dans le footer */
.btn-secondary {
    background: #6b7280;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
}

/* Dark mode pour le formulaire */
.dark .section-icon {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
    color: #818cf8;
}

.dark .status-toggle {
    background: rgba(30, 41, 59, 0.5);
    border-color: rgba(148, 163, 184, 0.2);
}

.dark .status-toggle:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-color: rgba(102, 126, 234, 0.3);
}

.dark .toggle-switch {
    background: #475569;
}

.dark .toggle-switch::after {
    background: #1e293b;
}

.dark .toggle-input:checked + .toggle-label .toggle-switch::after {
    background: #ffffff;
}

/* ========================================
   STYLES MODALE COMPACTE
   ======================================== */

.modal-compact {
    max-height: 85vh;
}

.modal-body-compact {
    padding: 20px 24px;
    max-height: calc(85vh - 140px);
    overflow-y: auto;
}

.modal-body-compact::-webkit-scrollbar {
    width: 5px;
}

.modal-body-compact::-webkit-scrollbar-track {
    background: var(--bg-secondary);
}

.modal-body-compact::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.form-section-compact {
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--card-border);
}

.form-section-compact:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title-compact {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 14px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title-compact svg {
    color: #667eea;
    flex-shrink: 0;
}

.form-grid-compact {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 14px;
}

.form-grid-compact:last-child {
    margin-bottom: 0;
}

.form-group-compact {
    margin-bottom: 0;
}

.form-group-compact.full-width {
    grid-column: 1 / -1;
}

.form-label-compact {
    display: block;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 6px;
}

.form-label-compact.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 3px;
}

.form-input-compact {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid var(--card-border);
    border-radius: 8px;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

/* Dropdown arrow for select elements */
select.form-input-compact {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    padding-right: 36px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
    cursor: pointer;
}

/* Select hover effect */
select.form-input-compact:hover {
    border-color: #667eea;
    background-color: var(--bg-secondary);
}

/* Dark mode dropdown arrow */
:root.dark select.form-input-compact {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%238b9dc3' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
}

.form-input-compact:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-hint-compact {
    display: block;
    font-size: 0.75rem;
    color: var(--text-muted);
    margin-top: 4px;
    font-style: italic;
}

.checkbox-compact {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 0.875rem;
    color: var(--text-primary);
}

.checkbox-compact input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #667eea;
}

.status-toggle-compact {
    background: var(--bg-secondary);
    border: 1px solid var(--card-border);
    border-radius: 10px;
    padding: 12px;
    transition: all 0.2s ease;
}

.status-toggle-compact:hover {
    border-color: #667eea;
}

.toggle-input-compact {
    display: none;
}

.toggle-label-compact {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    user-select: none;
}

.toggle-switch-compact {
    position: relative;
    width: 48px;
    height: 24px;
    background: #cbd5e1;
    border-radius: 24px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.toggle-switch-compact::after {
    content: '';
    position: absolute;
    top: 2px;
    left: 2px;
    width: 20px;
    height: 20px;
    background: #ffffff;
    border-radius: 50%;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.toggle-input-compact:checked + .toggle-label-compact .toggle-switch-compact {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.toggle-input-compact:checked + .toggle-label-compact .toggle-switch-compact::after {
    left: 26px;
}

.toggle-text-compact {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

/* ═══════════════════════════════════════════════════════════════
   MODAL HEADER PREMIUM - Design Moderne et Élégant
   ═══════════════════════════════════════════════════════════════ */
.modal-header-premium {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px 16px 0 0;
    position: relative;
    overflow: hidden;
}

.modal-header-premium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.modal-header-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    backdrop-filter: blur(10px);
    flex-shrink: 0;
    z-index: 1;
    transition: all 0.3s ease;
}

.modal-header-icon:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.05);
}

.modal-header-icon svg {
    color: #ffffff;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.modal-header-content {
    flex: 1;
    z-index: 1;
}

.modal-title-premium {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.01em;
}

.modal-subtitle-premium {
    font-size: 0.8125rem;
    color: rgba(255, 255, 255, 0.9);
    margin: 4px 0 0 0;
    font-weight: 400;
}

.modal-close-premium {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 1;
    backdrop-filter: blur(10px);
}

.modal-close-premium:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg);
}

.modal-close-premium svg {
    color: #ffffff;
}

/* Dark mode adjustments */
:root.dark .modal-header-premium {
    background: linear-gradient(135deg, #4c51bf 0%, #553c9a 100%);
}

/* ═══════════════════════════════════════════════════════════════
   SUCCESS NOTIFICATION - Message de Succès Moderne avec Animation
   ═══════════════════════════════════════════════════════════════ */
.success-notification {
    position: fixed;
    top: 24px;
    right: 24px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 20px;
    min-width: 380px;
    max-width: 450px;
    z-index: 10000;
    opacity: 0;
    transform: translateX(120%) scale(0.95);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.success-notification.show {
    opacity: 1;
    transform: translateX(0) scale(1);
}

.success-notification-content {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.success-icon-wrapper {
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: successPulse 0.6s ease-out;
}

@keyframes successPulse {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.success-icon {
    color: #ffffff;
    animation: checkmark 0.5s ease-out 0.2s both;
}

@keyframes checkmark {
    0% {
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

.success-text {
    flex: 1;
}

.success-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
}

.success-details {
    font-size: 0.9375rem;
    color: #4b5563;
    margin: 0 0 8px 0;
    line-height: 1.5;
}

.success-details strong {
    color: #1f2937;
    font-weight: 600;
}

.success-meta {
    font-size: 0.8125rem;
    color: #6b7280;
}

.success-reload {
    font-size: 0.8125rem;
    color: #10b981;
    margin: 0;
    font-weight: 500;
}

.success-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    width: 100%;
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    transition: width 2s linear;
    border-radius: 0 0 16px 16px;
}

/* Dark mode pour la notification */
:root.dark .success-notification {
    background: #1f2937;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 4px 12px rgba(0, 0, 0, 0.3);
}

:root.dark .success-title {
    color: #f9fafb;
}

:root.dark .success-details {
    color: #d1d5db;
}

:root.dark .success-details strong {
    color: #f9fafb;
}

:root.dark .success-meta {
    color: #9ca3af;
}

/* Responsive */
@media (max-width: 640px) {
    .success-notification {
        top: 16px;
        right: 16px;
        left: 16px;
        min-width: auto;
        max-width: none;
    }
}

.modal-footer-compact {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 14px 24px;
    border-top: 1px solid var(--card-border);
    background: var(--bg-secondary);
}

.btn-compact {
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary-compact {
    background: #6b7280;
    color: #ffffff;
}

.btn-secondary-compact:hover {
    background: #4b5563;
    transform: translateY(-1px);
}

.btn-primary-compact {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #ffffff;
}

.btn-primary-compact:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

@media (max-width: 768px) {
    .form-grid-compact {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .form-group-compact[style*="grid-column: span 2"] {
        grid-column: 1 !important;
    }

    .modal-compact {
        max-width: 95%;
    }
}

/* Dark mode pour modale compacte */
.dark .section-title-compact svg {
    color: #818cf8;
}

.dark .status-toggle-compact {
    background: rgba(30, 41, 59, 0.5);
    border-color: rgba(148, 163, 184, 0.2);
}

.dark .status-toggle-compact:hover {
    border-color: rgba(102, 126, 234, 0.3);
}

.dark .toggle-switch-compact {
    background: #475569;
}

.dark .toggle-switch-compact::after {
    background: #1e293b;
}

.dark .toggle-input-compact:checked + .toggle-label-compact .toggle-switch-compact::after {
    background: #ffffff;
}

/* ========================================
   DARK MODE - AMÉLIORATIONS VISUELLES
   ======================================== */

/* Header personnel en dark mode */
.dark .personnel-header {
    background: rgba(30, 41, 59, 0.6);
    border-color: rgba(148, 163, 184, 0.2);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.dark .personnel-header:hover {
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.4);
}

/* Cartes de détails en dark mode */
.dark .detail-card {
    background: rgba(30, 41, 59, 0.5);
    border-color: rgba(148, 163, 184, 0.2);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.dark .detail-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    border-color: rgba(102, 126, 234, 0.4);
}

.dark .detail-card::before {
    background: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
}

/* Titres de cartes en dark mode */
.dark .card-title {
    color: #f1f5f9;
    border-bottom-color: rgba(148, 163, 184, 0.2);
}

.dark .card-title svg {
    background: linear-gradient(135deg, rgba(129, 140, 248, 0.15) 0%, rgba(167, 139, 250, 0.15) 100%);
    color: #818cf8;
}

/* Lignes de détails en dark mode */
.dark .detail-row:hover {
    background: linear-gradient(90deg, rgba(129, 140, 248, 0.05) 0%, transparent 100%);
}

.dark .detail-label {
    color: #94a3b8;
}

.dark .detail-value {
    color: #e2e8f0;
}

/* Badges en dark mode */
.dark .badge {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.dark .badge:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

/* Boutons en dark mode */
.dark .btn-primary {
    background: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
    box-shadow: 0 6px 20px rgba(129, 140, 248, 0.3);
}

.dark .btn-primary:hover {
    box-shadow: 0 10px 30px rgba(129, 140, 248, 0.4);
}

.dark .btn-success {
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
}

.dark .btn-success:hover {
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4);
}

.dark .btn-danger {
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
}

.dark .btn-danger:hover {
    box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4);
}

/* Photo du personnel en dark mode */
.dark .personnel-photo {
    border-color: #818cf8;
    box-shadow: 0 8px 16px rgba(129, 140, 248, 0.3);
}

/* Meta items en dark mode */
.dark .meta-item {
    color: #94a3b8;
}

/* Nom du header en dark mode */
.dark .personnel-name-header {
    color: #f1f5f9;
}

/* ==================== MODERN LAYOUT STYLES ==================== */

/* Container principal moderne */
.personnel-show-modern {
    padding: 20px;
    max-width: 1300px;
    margin: 0 auto;
    animation: fadeIn 0.5s ease;
}

/* ==================== BREADCRUMB NAVIGATION ==================== */
.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 16px;
    font-size: 0.8125rem;
}

.breadcrumb-link {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    padding: 5px 10px;
    border-radius: 6px;
}

.breadcrumb-link:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(-2px);
}

.breadcrumb-link svg {
    flex-shrink: 0;
    width: 16px;
    height: 16px;
}

.breadcrumb-separator {
    color: var(--text-muted);
    opacity: 0.5;
    width: 14px;
    height: 14px;
}

.breadcrumb-current {
    color: var(--text-primary);
    font-weight: 600;
}

/* ==================== HERO SECTION ==================== */
.hero-section {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 28px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-content {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 24px;
    align-items: start;
}

/* Photo Container avec badge */
.photo-container {
    position: relative;
    display: inline-block;
}

.hero-photo {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #667eea;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.25);
    transition: all 0.3s ease;
}

.hero-photo:hover {
    transform: scale(1.03);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.photo-badge {
    position: absolute;
    bottom: 3px;
    right: 3px;
    padding: 4px 10px;
    border-radius: 16px;
    font-size: 0.6875rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    border: 2px solid var(--card-bg);
}

.badge-active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.badge-inactive {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}

/* Hero Middle - Nom et Meta */
.hero-middle {
    flex: 1;
    min-width: 0;
}

.hero-name {
    font-size: 1.625rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 6px 0;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 0.9375rem;
    color: #667eea;
    font-weight: 600;
    margin: 0 0 14px 0;
}

.hero-meta-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.meta-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 7px 12px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 1px solid rgba(102, 126, 234, 0.2);
    border-radius: 10px;
    font-size: 0.8125rem;
    color: var(--text-primary);
    font-weight: 600;
    transition: all 0.2s ease;
}

.meta-badge:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
}

.meta-badge svg {
    color: #667eea;
    flex-shrink: 0;
    width: 14px;
    height: 14px;
}

/* Bouton Modifier Moderne */
.btn-edit-modern {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.btn-edit-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.btn-edit-modern:active {
    transform: translateY(-1px);
}

.btn-edit-modern svg {
    flex-shrink: 0;
    width: 16px;
    height: 16px;
}

/* ==================== GRILLE DE CARTES MODERNE ==================== */
.info-grid-modern {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}

/* Cartes Modernes */
.info-card-modern {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
}

.info-card-modern:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

/* En-têtes de cartes avec icônes colorées */
.card-header-modern {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    position: relative;
}

.card-icon-modern {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    flex-shrink: 0;
}

.card-icon-modern svg {
    width: 20px;
    height: 20px;
}

.card-title-modern {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

/* Couleurs des icônes par type de carte */
.card-personal .card-icon-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.card-contact .card-icon-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.card-work .card-icon-modern {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.card-contract .card-icon-modern {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Corps de carte */
.card-body-modern {
    padding: 0 20px 18px 20px;
}

/* Items d'information */
.info-item-modern {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 12px;
    padding: 11px 0;
    border-bottom: 1px solid var(--card-border);
    transition: all 0.2s ease;
}

.info-item-modern:last-child {
    border-bottom: none;
}

.info-item-modern:hover {
    background: linear-gradient(90deg, rgba(102, 126, 234, 0.03) 0%, transparent 100%);
    padding-left: 6px;
    margin-left: -6px;
    border-radius: 6px;
}

.info-label-modern {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--text-muted);
    display: flex;
    align-items: center;
}

.info-value-modern {
    font-size: 0.8125rem;
    color: var(--text-primary);
    font-weight: 500;
    display: flex;
    align-items: center;
    word-break: break-word;
}

/* Badges dans les infos */
.info-badge-modern {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 11px;
    border-radius: 7px;
    font-size: 0.75rem;
    font-weight: 700;
}

.contract-badge {
    padding: 6px 13px;
    border-radius: 8px;
    font-weight: 700;
    display: inline-block;
    font-size: 0.75rem;
}

.badge-cdi {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.badge-cdd {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.badge-whatsapp {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    padding: 5px 11px;
    border-radius: 7px;
    font-weight: 700;
    font-size: 0.75rem;
    box-shadow: 0 2px 8px rgba(37, 211, 102, 0.25);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1024px) {
    .info-grid-modern {
        grid-template-columns: 1fr;
    }

    .hero-content {
        grid-template-columns: 1fr;
        gap: 20px;
        text-align: center;
    }

    .hero-left {
        display: flex;
        justify-content: center;
    }

    .hero-right {
        display: flex;
        justify-content: center;
    }

    .hero-meta-grid {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .personnel-show-modern {
        padding: 14px;
    }

    .hero-section {
        padding: 20px;
    }

    .hero-photo {
        width: 90px;
        height: 90px;
    }

    .hero-name {
        font-size: 1.375rem;
    }

    .hero-subtitle {
        font-size: 0.875rem;
    }

    .info-item-modern {
        grid-template-columns: 1fr;
        gap: 6px;
    }

    .meta-badge {
        font-size: 0.75rem;
        padding: 6px 10px;
    }

    .btn-edit-modern {
        width: 100%;
        justify-content: center;
        font-size: 0.8125rem;
        padding: 9px 16px;
    }

    .card-header-modern {
        padding: 14px 16px;
    }

    .card-body-modern {
        padding: 0 16px 14px 16px;
    }
}

/* ==================== DARK MODE ==================== */
.dark .breadcrumb-link {
    color: #818cf8;
}

.dark .breadcrumb-link:hover {
    background: rgba(129, 140, 248, 0.15);
}

.dark .breadcrumb-current {
    color: #e2e8f0;
}

.dark .hero-photo {
    border-color: #818cf8;
    box-shadow: 0 12px 24px rgba(129, 140, 248, 0.3);
}

.dark .hero-name {
    color: #f1f5f9;
}

.dark .hero-subtitle {
    color: #818cf8;
}

.dark .meta-badge {
    background: linear-gradient(135deg, rgba(129, 140, 248, 0.12) 0%, rgba(167, 139, 250, 0.12) 100%);
    border-color: rgba(129, 140, 248, 0.25);
    color: #e2e8f0;
}

.dark .meta-badge:hover {
    background: linear-gradient(135deg, rgba(129, 140, 248, 0.2) 0%, rgba(167, 139, 250, 0.2) 100%);
}

.dark .meta-badge svg {
    color: #818cf8;
}

.dark .btn-edit-modern {
    background: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
    box-shadow: 0 8px 20px rgba(129, 140, 248, 0.3);
}

.dark .btn-edit-modern:hover {
    box-shadow: 0 12px 28px rgba(129, 140, 248, 0.4);
}

.dark .info-card-modern:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.dark .card-title-modern {
    color: #f1f5f9;
}

.dark .card-personal .card-icon-modern {
    background: linear-gradient(135deg, #818cf8 0%, #a78bfa 100%);
}

.dark .card-contact .card-icon-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.dark .card-work .card-icon-modern {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.dark .card-contract .card-icon-modern {
    background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
}

.dark .info-item-modern:hover {
    background: linear-gradient(90deg, rgba(129, 140, 248, 0.05) 0%, transparent 100%);
}

.dark .info-label-modern {
    color: #94a3b8;
}

.dark .info-value-modern {
    color: #e2e8f0;
}
</style>
@endsection

@section('content')
<div class="personnel-show-modern">
    <!-- Navigation avec Breadcrumb -->
    <div class="breadcrumb-nav">
        <a href="{{ route('personnels.index') }}" class="breadcrumb-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            Personnel
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="breadcrumb-separator">
            <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
        <span class="breadcrumb-current">{{ $personnel->nom_complet }}</span>
    </div>

    <!-- Hero Section avec Photo et Infos Principales -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-left">
                <div class="photo-container">
                    <img src="{{ $personnel->photo_url }}" alt="{{ $personnel->nom_complet }}" class="hero-photo">
                    <div class="photo-badge {{ $personnel->is_active ? 'badge-active' : 'badge-inactive' }}">
                        {{ $personnel->is_active ? '✓ Actif' : '✗ Inactif' }}
                    </div>
                </div>
            </div>

            <div class="hero-middle">
                <h1 class="hero-name">{{ $personnel->nom_complet }}</h1>
                <p class="hero-subtitle">{{ $personnel->poste ?? 'Poste non défini' }}</p>

                <div class="hero-meta-grid">
                    <div class="meta-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        <span>{{ $personnel->matricule }}</span>
                    </div>
                    <div class="meta-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ $personnel->anciennete ?? 0 }} ans d'ancienneté</span>
                    </div>
                    <div class="meta-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        <span>{{ $personnel->type_contrat ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <button class="btn-edit-modern" onclick="editPersonnel()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier
                </button>
            </div>
        </div>
    </div>

    <!-- Grille de Cartes Moderne - 2 colonnes -->
    <div class="info-grid-modern">
        <!-- Carte : Informations Personnelles -->
        <div class="info-card-modern card-personal">
            <div class="card-header-modern">
                <div class="card-icon-modern icon-personal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3 class="card-title-modern">Informations Personnelles</h3>
            </div>
            <div class="card-body-modern">
                <div class="info-item-modern">
                    <span class="info-label-modern">Civilité</span>
                    <span class="info-value-modern">{{ $personnel->civilite ?? '—' }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Sexe</span>
                    <span class="info-value-modern">{{ $personnel->sexe === 'M' ? 'Masculin' : ($personnel->sexe === 'F' ? 'Féminin' : '—') }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Date de Naissance</span>
                    <span class="info-value-modern">
                        @if($personnel->date_naissance)
                            {{ \Carbon\Carbon::parse($personnel->date_naissance)->locale('fr')->isoFormat('D MMMM YYYY') }}
                            <span class="info-badge-modern">{{ $personnel->age }} ans</span>
                        @else
                            —
                        @endif
                    </span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">N° Identification</span>
                    <span class="info-value-modern">{{ $personnel->numero_identification ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Carte : Coordonnées -->
        <div class="info-card-modern card-contact">
            <div class="card-header-modern">
                <div class="card-icon-modern icon-contact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <h3 class="card-title-modern">Coordonnées</h3>
            </div>
            <div class="card-body-modern">
                <div class="info-item-modern">
                    <span class="info-label-modern">Email</span>
                    <span class="info-value-modern">{{ $personnel->email ?? '—' }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Téléphone</span>
                    <span class="info-value-modern">
                        {{ $personnel->telephone_complet ?? '—' }}
                        @if($personnel->telephone_whatsapp)
                        <span class="info-badge-modern badge-whatsapp">WhatsApp</span>
                        @endif
                    </span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Adresse</span>
                    <span class="info-value-modern">{{ $personnel->adresse ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Carte : Entreprise & Poste -->
        <div class="info-card-modern card-work">
            <div class="card-header-modern">
                <div class="card-icon-modern icon-work">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                    </svg>
                </div>
                <h3 class="card-title-modern">Entreprise & Poste</h3>
            </div>
            <div class="card-body-modern">
                <div class="info-item-modern">
                    <span class="info-label-modern">Entreprise</span>
                    <span class="info-value-modern">{{ $personnel->entreprise->nom }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Département</span>
                    <span class="info-value-modern">{{ $personnel->departement->nom ?? '—' }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Service</span>
                    <span class="info-value-modern">{{ $personnel->service->nom ?? '—' }}</span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Poste Occupé</span>
                    <span class="info-value-modern">{{ $personnel->poste ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- Carte : Contrat -->
        <div class="info-card-modern card-contract">
            <div class="card-header-modern">
                <div class="card-icon-modern icon-contract">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <h3 class="card-title-modern">Contrat de Travail</h3>
            </div>
            <div class="card-body-modern">
                <div class="info-item-modern">
                    <span class="info-label-modern">Type de Contrat</span>
                    <span class="info-value-modern">
                        <span class="contract-badge {{ $personnel->type_contrat === 'CDI' ? 'badge-cdi' : 'badge-cdd' }}">
                            {{ $personnel->type_contrat ?? '—' }}
                        </span>
                    </span>
                </div>
                <div class="info-item-modern">
                    <span class="info-label-modern">Date d'Embauche</span>
                    <span class="info-value-modern">
                        @if($personnel->date_embauche)
                            {{ \Carbon\Carbon::parse($personnel->date_embauche)->locale('fr')->isoFormat('D MMMM YYYY') }}
                        @else
                            —
                        @endif
                    </span>
                </div>
                @if($personnel->type_contrat === 'CDD' && $personnel->date_fin_contrat)
                <div class="info-item-modern">
                    <span class="info-label-modern">Date de Fin (CDD)</span>
                    <span class="info-value-modern">
                        {{ \Carbon\Carbon::parse($personnel->date_fin_contrat)->locale('fr')->isoFormat('D MMMM YYYY') }}
                    </span>
                </div>
                @endif
                <div class="info-item-modern">
                    <span class="info-label-modern">Ancienneté</span>
                    <span class="info-value-modern">{{ $personnel->anciennete ?? 0 }} année(s)</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign User Modal -->
<div class="modal-overlay" id="assignUserModal">
    <div class="modal" id="assignUserModalContent">
        <div class="modal-header">
            <h2 class="modal-title">Créer un Compte Utilisateur</h2>
            <button type="button" class="modal-close" onclick="closeAssignUserModal()" aria-label="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="assignUserForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Laisser vide pour mot de passe par défaut">
                    <small style="color: var(--text-muted); font-size: 0.8125rem;">Par défaut: password123</small>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label required">Rôle</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Statut du Compte</label>
                    <label class="checkbox-wrapper">
                        <input type="checkbox" name="status" value="active" class="checkbox-input" checked>
                        <span class="checkbox-label">Activer le compte immédiatement</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAssignUserModal()" style="background: #6b7280; color: #fff;">Annuler</button>
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Créer le Compte
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Personnel Modal - Formulaire Complet Optimisé -->
<div class="modal-overlay" id="editPersonnelModal">
    <div class="modal modal-compact" id="editPersonnelModalContent" style="max-width: 750px;">
        <div class="modal-header-premium">
            <div class="modal-header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <div class="modal-header-content">
                <h2 class="modal-title-premium">Modifier le Personnel</h2>
                <p class="modal-subtitle-premium">Mettez à jour les informations du collaborateur</p>
            </div>
            <button type="button" class="modal-close-premium" onclick="closeEditPersonnelModal()" aria-label="Fermer">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <form id="editPersonnelForm" novalidate>
            @csrf
            @method('PUT')
            <div class="modal-body modal-body-compact">

                <!-- Section: Informations Personnelles -->
                <div class="form-section-compact">
                    <h4 class="section-title-compact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Informations Personnelles
                    </h4>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_civilite" class="form-label-compact">Civilité</label>
                            <select id="edit_civilite" name="civilite" class="form-input-compact">
                                <option value="">--</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Dr">Dr</option>
                            </select>
                        </div>

                        <div class="form-group-compact">
                            <label for="edit_nom" class="form-label-compact required">Nom</label>
                            <input type="text" id="edit_nom" name="nom" class="form-input-compact" required>
                            <span class="form-error" id="error_nom"></span>
                        </div>

                        <div class="form-group-compact">
                            <label for="edit_prenoms" class="form-label-compact required">Prénom(s)</label>
                            <input type="text" id="edit_prenoms" name="prenoms" class="form-input-compact" required>
                            <span class="form-error" id="error_prenoms"></span>
                        </div>
                    </div>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_sexe" class="form-label-compact">Sexe</label>
                            <select id="edit_sexe" name="sexe" class="form-input-compact">
                                <option value="">--</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div class="form-group-compact">
                            <label for="edit_date_naissance" class="form-label-compact">Date de Naissance</label>
                            <input type="date" id="edit_date_naissance" name="date_naissance" class="form-input-compact" max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group-compact">
                            <label for="edit_numero_identification" class="form-label-compact">N° Identification</label>
                            <input type="text" id="edit_numero_identification" name="numero_identification" class="form-input-compact" placeholder="CNI, Passeport...">
                        </div>
                    </div>
                </div>

                <!-- Section: Coordonnées -->
                <div class="form-section-compact">
                    <h4 class="section-title-compact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Coordonnées
                    </h4>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_telephone_code_pays" class="form-label-compact">Code Pays</label>
                            <input type="text" id="edit_telephone_code_pays" name="telephone_code_pays" class="form-input-compact" placeholder="+225">
                        </div>

                        <div class="form-group-compact" style="grid-column: span 2;">
                            <label for="edit_telephone" class="form-label-compact">Téléphone</label>
                            <input type="tel" id="edit_telephone" name="telephone" class="form-input-compact" placeholder="01 02 03 04 05">
                        </div>
                    </div>

                    <div class="form-group-compact full-width">
                        <label class="checkbox-compact">
                            <input type="checkbox" id="edit_telephone_whatsapp" name="telephone_whatsapp" value="1">
                            <span>Ce numéro est sur WhatsApp</span>
                        </label>
                    </div>

                    <div class="form-group-compact full-width">
                        <label for="edit_adresse" class="form-label-compact">Adresse</label>
                        <textarea id="edit_adresse" name="adresse" class="form-input-compact" rows="2" placeholder="Adresse résidentielle"></textarea>
                    </div>
                </div>

                <!-- Section: Informations Professionnelles -->
                <div class="form-section-compact">
                    <h4 class="section-title-compact">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        Informations Professionnelles
                    </h4>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_matricule" class="form-label-compact">Matricule</label>
                            <input type="text" id="edit_matricule" name="matricule" class="form-input-compact" readonly style="background: #f3f4f6; cursor: not-allowed; color: #6b7280;">
                            <span class="form-hint-compact">🔒 Non modifiable</span>
                        </div>

                        <div class="form-group-compact" style="grid-column: span 2;">
                            <label for="edit_poste" class="form-label-compact">Poste</label>
                            <input type="text" id="edit_poste" name="poste" class="form-input-compact" placeholder="Titre du poste">
                        </div>
                    </div>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_departement_id" class="form-label-compact">Département</label>
                            <select id="edit_departement_id" name="departement_id" class="form-input-compact">
                                <option value="">-- Sélectionner --</option>
                                @foreach($departements as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group-compact" style="grid-column: span 2;">
                            <label for="edit_service_id" class="form-label-compact">Service</label>
                            <select id="edit_service_id" name="service_id" class="form-input-compact">
                                <option value="">-- Sélectionner --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-compact">
                        <div class="form-group-compact">
                            <label for="edit_type_contrat" class="form-label-compact">Type Contrat</label>
                            <select id="edit_type_contrat" name="type_contrat" class="form-input-compact">
                                <option value="">--</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="Stage">Stage</option>
                                <option value="Prestation">Prestation</option>
                            </select>
                        </div>

                        <div class="form-group-compact">
                            <label for="edit_date_embauche" class="form-label-compact">Date Embauche</label>
                            <input type="date" id="edit_date_embauche" name="date_embauche" class="form-input-compact" max="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group-compact" id="edit_date_fin_contrat_group">
                            <label for="edit_date_fin_contrat" class="form-label-compact">Date Fin (CDD)</label>
                            <input type="date" id="edit_date_fin_contrat" name="date_fin_contrat" class="form-input-compact">
                        </div>
                    </div>

                    <div class="form-group-compact full-width">
                        <div class="status-toggle-compact">
                            <input type="checkbox" id="edit_is_active" name="is_active" class="toggle-input-compact" checked>
                            <label for="edit_is_active" class="toggle-label-compact">
                                <span class="toggle-switch-compact"></span>
                                <span class="toggle-text-compact">Statut: Personnel Actif</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer-compact">
                <button type="button" class="btn-compact btn-secondary-compact" onclick="closeEditPersonnelModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="btn-compact btn-primary-compact">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
/**
 * Ouvrir la modale de création de compte utilisateur
 */
function openAssignUserModal() {
    console.log('🔓 Ouverture de la modale...');
    const modal = document.getElementById('assignUserModal');

    if (modal) {
        modal.classList.add('show');
        // Focus sur le premier champ
        setTimeout(() => {
            document.getElementById('password')?.focus();
        }, 100);
        console.log('✅ Modale ouverte');
    } else {
        console.error('❌ Modale non trouvée');
    }
}

/**
 * Fermer la modale de création de compte utilisateur
 */
function closeAssignUserModal() {
    console.log('🔒 Fermeture de la modale...');
    const modal = document.getElementById('assignUserModal');
    const form = document.getElementById('assignUserForm');

    if (modal) {
        modal.classList.remove('show');
        console.log('✅ Modale fermée');
    }

    // Reset du formulaire après animation
    if (form) {
        setTimeout(() => {
            form.reset();
            console.log('✅ Formulaire réinitialisé');
        }, 300);
    }
}

// Assign user
document.getElementById('assignUserForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Préparer les données - L'email sera pris automatiquement depuis le personnel
    const data = {
        role: formData.get('role'),
        status: formData.get('status') === 'active' ? 'active' : 'inactive'
    };

    // Ajouter le password seulement s'il est renseigné
    const password = formData.get('password')?.trim();
    if (password && password.length > 0) {
        data.password = password;
    }

    console.log('🚀 Envoi des données:', data);
    console.log('👤 Rôle:', data.role);
    console.log('✅ Statut:', data.status);
    console.log('🔑 Password fourni:', password ? 'Oui (' + password.length + ' chars)' : 'Non (défaut sera utilisé)');
    console.log('📧 Email sera pris depuis le personnel: {{ $personnel->email ?? "Non défini" }}');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span>Création en cours...</span>';

    try {
        const url = '/personnels/{{ $personnel->id }}/assign-user';
        console.log('🌐 URL:', url);

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        console.log('📊 Response status:', response.status);
        console.log('📊 Response ok:', response.ok);

        const result = await response.json();
        console.log('📦 Response data:', result);

        // Gestion des différents codes de réponse
        if (response.status === 403) {
            alert('❌ ERREUR DE PERMISSION\n\nVous n\'avez pas la permission "assign-user-accounts".\n\nContactez votre administrateur système.');
            return;
        }

        if (response.status === 422) {
            // Erreur de validation
            if (result.errors) {
                const errorMessages = Object.entries(result.errors)
                    .map(([field, messages]) => `• ${field}: ${messages.join(', ')}`)
                    .join('\n');
                alert('❌ ERREURS DE VALIDATION\n\n' + errorMessages);
            } else {
                alert('❌ ERREUR\n\n' + (result.message || 'Ce personnel possède peut-être déjà un compte utilisateur'));
            }
            return;
        }

        if (response.status === 500) {
            alert('❌ ERREUR SERVEUR\n\n' + (result.message || 'Une erreur est survenue côté serveur') + '\n\nDétails: ' + (result.error || 'Aucun détail'));
            return;
        }

        if (response.ok && result.success) {
            console.log('═══════════════════════════════════════');
            console.log('✅ CRÉATION COMPTE RÉUSSIE');
            console.log('═══════════════════════════════════════');
            console.log('📦 Réponse complète:', JSON.stringify(result, null, 2));
            console.log('───────────────────────────────────────');

            // Extraire les informations du compte créé
            const user = result.user || result.personnel?.user;

            if (!user) {
                console.error('❌ ERREUR CRITIQUE: Aucun objet user dans la réponse');
                console.log('📦 Contenu result:', result);
                alert('❌ ERREUR TECHNIQUE\n\nLes données du compte créé n\'ont pas été retournées correctement par le serveur.\n\nℹ️ Le compte peut avoir été créé mais l\'affichage a échoué.\n\nAction recommandée: Rechargez la page pour vérifier.');
                setTimeout(() => window.location.reload(), 2000);
                return;
            }

            const email = user.email || 'Non défini';
            const status = user.status || 'active';
            const roles = user.roles || [];

            console.log('👤 Utilisateur créé:');
            console.log('   • ID:', user.id);
            console.log('   • Nom:', user.name);
            console.log('   • Email:', email);
            console.log('   • Statut:', status);
            console.log('🎭 Rôles:', roles);
            console.log('   • Type:', typeof roles);
            console.log('   • Est tableau:', Array.isArray(roles));
            console.log('   • Longueur:', roles.length);

            // Générer HTML des rôles avec validation stricte
            let rolesHtml = '';
            let rolesCount = 0;
            const roleNames = [];

            if (roles && Array.isArray(roles) && roles.length > 0) {
                console.log('📋 Traitement des rôles (format tableau):');
                roles.forEach((role, index) => {
                    const roleName = role.name || role;
                    roleNames.push(roleName);
                    console.log(`   ${index + 1}. "${roleName}"`);
                    rolesHtml += `<span class="badge badge-primary" style="margin-right: 5px; padding: 5px 12px; font-size: 13px;">${roleName}</span>`;
                    rolesCount++;
                });
                console.log(`✅ ${rolesCount} rôle(s) traité(s) avec succès`);
            } else if (roles && typeof roles === 'object' && !Array.isArray(roles)) {
                console.log('📋 Traitement des rôles (format objet):');
                Object.values(roles).forEach((role, index) => {
                    const roleName = role.name || role;
                    roleNames.push(roleName);
                    console.log(`   ${index + 1}. "${roleName}"`);
                    rolesHtml += `<span class="badge badge-primary" style="margin-right: 5px; padding: 5px 12px; font-size: 13px;">${roleName}</span>`;
                    rolesCount++;
                });
                console.log(`✅ ${rolesCount} rôle(s) traité(s) depuis objet`);
            } else {
                console.warn('⚠️ Aucun rôle assigné ou format invalide');
                rolesHtml = '<span class="text-muted" style="font-style: italic; color: #999;">Aucun rôle assigné</span>';
                roleNames.push('Aucun');
            }

            console.log('🎨 HTML des rôles final:', rolesHtml);

            // Badge de statut
            const statusBadgeClass = status === 'active' ? 'badge-success' : 'badge-danger';
            const statusText = status === 'active' ? 'Actif' : 'Inactif';
            console.log(`📊 Statut: ${statusText} (classe: ${statusBadgeClass})`);

            // Mettre à jour la section Compte Utilisateur
            console.log('🔄 Mise à jour DOM en cours...');
            updateUserDisplay(email, rolesHtml, statusBadgeClass, statusText);
            console.log('✅ DOM mis à jour avec succès');
            console.log('═══════════════════════════════════════');

            // Message de succès professionnel et détaillé
            const successLines = [
                '╔═══════════════════════════════════════════╗',
                '║   ✅ COMPTE UTILISATEUR CRÉÉ AVEC SUCCÈS   ║',
                '╚═══════════════════════════════════════════╝',
                '',
                '📋 INFORMATIONS DU COMPTE:',
                '─────────────────────────────────────────────',
                `  👤 Nom complet : ${user.name || 'Non défini'}`,
                `  📧 Adresse email : ${email}`,
                `  🎭 Rôle(s) : ${roleNames.join(', ')}`,
                `  📊 Statut : ${statusText}`,
                '',
                '🔐 SÉCURITÉ ET ACCÈS:',
                '─────────────────────────────────────────────',
                '  • Mot de passe temporaire généré automatiquement',
                '  • Email de notification envoyé à l\'utilisateur',
                '  • Changement de mot de passe obligatoire à la 1ère connexion',
                '',
                '✔️ Le compte est désormais opérationnel',
                '',
                '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
            ];

            alert(successLines.join('\n'));

            // Fermer la modale
            closeAssignUserModal();
        } else {
            alert('❌ ERREUR\n\n' + (result.message || 'Une erreur inconnue est survenue'));
        }
    } catch (error) {
        console.error('💥 Erreur catch:', error);
        alert('❌ ERREUR RÉSEAU\n\n' + error.message + '\n\nVérifiez votre connexion internet et réessayez.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Créer le Compte';
    }
});

/**
 * Fonction utilitaire pour mettre à jour l'affichage des informations utilisateur
 */
function updateUserDisplay(email, rolesHtml, statusBadgeClass, statusText, showDetachButton = true) {
    const userAssignmentCard = document.querySelector('.user-assignment-card');

    if (!userAssignmentCard) {
        console.error('❌ Carte user-assignment-card non trouvée');
        return;
    }

    // Vérifier si l'utilisateur a la permission delete-users
    const canDeleteUsers = {{ auth()->user()->can('delete-users') ? 'true' : 'false' }};

    const detachButtonHtml = (showDetachButton && canDeleteUsers) ? `
        <button class="btn btn-danger" onclick="detachUser()" style="width: 100%; margin-top: 15px;" id="btnDetachUser">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            Dissocier le Compte
        </button>
    ` : '';

    userAssignmentCard.innerHTML = `
        <h3 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Compte Utilisateur
        </h3>

        <div class="user-info-display" id="userInfoDisplay">
            <div class="user-info-row">
                <span class="detail-label">Email</span>
                <span class="detail-value" id="userEmail">${email}</span>
            </div>
            <div class="user-info-row">
                <span class="detail-label">Rôle(s)</span>
                <span class="detail-value" id="userRoles">${rolesHtml}</span>
            </div>
            <div class="user-info-row">
                <span class="detail-label">Statut</span>
                <span class="detail-value" id="userStatus">
                    <span class="badge ${statusBadgeClass}">${statusText}</span>
                </span>
            </div>
        </div>

        ${detachButtonHtml}
    `;

    console.log('✅ Affichage utilisateur mis à jour');
}

/**
 * Fonction pour afficher l'état "Aucun compte"
 */
function showNoUserState() {
    const userAssignmentCard = document.querySelector('.user-assignment-card');

    if (!userAssignmentCard) {
        console.error('❌ Carte user-assignment-card non trouvée');
        return;
    }

    // Vérifier si l'utilisateur a la permission create-users
    const canCreateUsers = {{ auth()->user()->can('create-users') ? 'true' : 'false' }};

    const createButtonHtml = canCreateUsers ? `
        <button class="btn btn-primary" onclick="openAssignUserModal()" style="width: 100%; margin-top: 15px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            Créer un Compte
        </button>
    ` : '';

    userAssignmentCard.innerHTML = `
        <h3 class="card-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Compte Utilisateur
        </h3>

        <div class="no-user-alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" style="margin: 0 auto 12px; display: block;">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            <p>Ce personnel n'a pas encore de compte utilisateur</p>
        </div>

        ${createButtonHtml}
    `;

    console.log('✅ État "Aucun compte" affiché');
}

/**
 * Fonction de dissociation du compte utilisateur
 */
async function detachUser() {
    // Confirmation détaillée et professionnelle
    const confirmLines = [
        '╔══════════════════════════════════════╗',
        '║   ⚠️ CONFIRMATION DE DISSOCIATION   ║',
        '╚══════════════════════════════════════╝',
        '',
        'Êtes-vous sûr de vouloir dissocier ce compte utilisateur?',
        '',
        '📋 ACTIONS QUI SERONT EFFECTUÉES:',
        '──────────────────────────────────────',
        '  ❌ Le lien entre le personnel et le compte sera supprimé',
        '  🔒 Le compte utilisateur sera désactivé',
        '  💾 Le compte restera dans la base de données',
        '  📧 L\'utilisateur ne pourra plus se connecter',
        '',
        '⚠️ ATTENTION: Cette action peut être réversible en',
        '   recréant manuellement l\'association.',
        '',
        '──────────────────────────────────────',
        '        Continuer la dissociation ?'
    ].join('\n');

    if (!confirm(confirmLines)) {
        console.log('ℹ️ Dissociation annulée par l\'utilisateur');
        return;
    }

    console.log('═══════════════════════════════════════');
    console.log('🔄 DÉBUT DISSOCIATION');
    console.log('═══════════════════════════════════════');

    const btnDetach = document.getElementById('btnDetachUser');

    // Désactiver et afficher le loader
    if (btnDetach) {
        btnDetach.disabled = true;
        btnDetach.style.cursor = 'not-allowed';
        btnDetach.style.opacity = '0.6';
        btnDetach.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;">
                <circle cx="12" cy="12" r="10"></circle>
            </svg>
            <style>
                @keyframes spin {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
            </style>
            Dissociation en cours...
        `;
        console.log('🔄 Bouton désactivé, loader affiché');
    }

    try {
        console.log('📡 Envoi de la requête de dissociation...');

        const response = await fetch('/personnels/{{ $personnel->id }}/detach-user', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        console.log('📡 Réponse reçue:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok
        });

        const result = await response.json();
        console.log('📦 Données de la réponse:', result);

        if (response.ok && result.success) {
            console.log('✅ Dissociation réussie côté serveur');
            console.log('🔄 Mise à jour de l\'affichage...');

            // Afficher l'état "Aucun compte"
            showNoUserState();

            console.log('✅ Affichage mis à jour avec succès');
            console.log('═══════════════════════════════════════');

            // Message de succès professionnel
            const successLines = [
                '╔═══════════════════════════════════════╗',
                '║   ✅ DISSOCIATION RÉUSSIE             ║',
                '╚═══════════════════════════════════════╝',
                '',
                '✔️ OPÉRATIONS EFFECTUÉES:',
                '───────────────────────────────────────',
                '  • Le lien personnel ↔ compte a été supprimé',
                '  • Le compte utilisateur a été désactivé',
                '  • Les données ont été conservées',
                '',
                'ℹ️ Le personnel n\'a désormais plus de compte',
                '   utilisateur associé.',
                '',
                '📝 Pour réassocier un compte, utilisez le',
                '   bouton "Créer un Compte".',
                '',
                '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
            ].join('\n');

            alert(successLines);

        } else {
            console.error('❌ Échec de la dissociation');
            console.error('Message:', result.message);
            console.error('Erreur:', result.error);

            const errorLines = [
                '╔═══════════════════════════════════════╗',
                '║   ❌ ÉCHEC DE LA DISSOCIATION         ║',
                '╚═══════════════════════════════════════╝',
                '',
                '⚠️ Une erreur est survenue lors de la dissociation:',
                '',
                `📋 Détails: ${result.message || 'Erreur inconnue'}`,
                '',
                '💡 ACTIONS RECOMMANDÉES:',
                '───────────────────────────────────────',
                '  1. Vérifiez que le compte existe toujours',
                '  2. Actualisez la page et réessayez',
                '  3. Contactez l\'administrateur si le problème persiste',
                '',
                '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
            ].join('\n');

            alert(errorLines);

            throw new Error(result.message || 'Erreur lors de la dissociation');
        }
    } catch (error) {
        console.error('═══════════════════════════════════════');
        console.error('❌ ERREUR CRITIQUE DISSOCIATION');
        console.error('═══════════════════════════════════════');
        console.error('Type:', error.name);
        console.error('Message:', error.message);
        console.error('Stack:', error.stack);

        const errorLines = [
            '╔═══════════════════════════════════════╗',
            '║   ❌ ERREUR TECHNIQUE                 ║',
            '╚═══════════════════════════════════════╝',
            '',
            `⚠️ ${error.message}`,
            '',
            '🔍 INFORMATIONS TECHNIQUES:',
            '───────────────────────────────────────',
            `  • Type: ${error.name || 'Erreur inconnue'}`,
            '  • La requête n\'a pas pu être complétée',
            '',
            '💡 VÉRIFICATIONS:',
            '───────────────────────────────────────',
            '  ✓ Votre connexion internet',
            '  ✓ Les permissions de votre compte',
            '  ✓ L\'état du serveur',
            '',
            '📞 Si le problème persiste, contactez',
            '   l\'administrateur système.',
            '',
            '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
        ].join('\n');

        alert(errorLines);

        // Restaurer le bouton en cas d'erreur
        if (btnDetach) {
            btnDetach.disabled = false;
            btnDetach.style.cursor = 'pointer';
            btnDetach.style.opacity = '1';
            btnDetach.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                Dissocier le Compte
            `;
            console.log('🔄 Bouton restauré après erreur');
        }
    }
}

/**
 * Fermer la modale avec la touche Escape
 */
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('assignUserModal');
        if (modal && modal.classList.contains('show')) {
            console.log('⌨️ Touche Escape détectée - fermeture modale');
            closeAssignUserModal();
        }
    }
});

/**
 * Fermer la modale en cliquant sur l'overlay (fond sombre)
 * IMPORTANT: Empêcher la propagation depuis les éléments enfants
 */
document.getElementById('assignUserModal').addEventListener('click', (e) => {
    // Ne fermer QUE si on clique directement sur l'overlay
    // PAS si on clique sur le contenu de la modale
    if (e.target.id === 'assignUserModal') {
        console.log('🖱️ Clic sur overlay détecté - fermeture modale');
        closeAssignUserModal();
    } else {
        console.log('🖱️ Clic sur contenu modale - pas de fermeture');
    }
});

/**
 * Empêcher la propagation des clics depuis le contenu de la modale
 * vers l'overlay (pour éviter les fermetures accidentelles)
 */
document.getElementById('assignUserModalContent')?.addEventListener('click', (e) => {
    console.log('🛡️ Clic sur contenu modale - propagation bloquée');
    e.stopPropagation(); // ✅ CRITIQUE: Empêche la remontée de l'événement
});

// ═══════════════════════════════════════════════════════════════
// GESTION DE LA MODALE D'ÉDITION PERSONNEL
// ═══════════════════════════════════════════════════════════════

/**
 * Ouvrir la modale d'édition et pré-remplir avec TOUTES les données actuelles
 */
async function editPersonnel() {
    console.log('═══════════════════════════════════════');
    console.log('📝 OUVERTURE MODALE ÉDITION PERSONNEL');
    console.log('═══════════════════════════════════════');

    // Données COMPLÈTES du personnel à éditer
    const personnel = {
        id: {{ $personnel->id }},
        civilite: "{{ $personnel->civilite ?? '' }}",
        nom: "{{ $personnel->nom }}",
        prenoms: "{{ $personnel->prenoms }}",
        sexe: "{{ $personnel->sexe ?? '' }}",
        date_naissance: "{{ $personnel->date_naissance ? $personnel->date_naissance->format('Y-m-d') : '' }}",
        numero_identification: "{{ $personnel->numero_identification ?? '' }}",
        email: "{{ $personnel->email ?? '' }}",
        telephone_code_pays: "{{ $personnel->telephone_code_pays ?? '' }}",
        telephone: "{{ $personnel->telephone ?? '' }}",
        telephone_whatsapp: {{ $personnel->telephone_whatsapp ? 'true' : 'false' }},
        adresse: "{{ $personnel->adresse ?? '' }}",
        matricule: "{{ $personnel->matricule }}",
        poste: "{{ $personnel->poste ?? '' }}",
        departement_id: "{{ $personnel->departement_id ?? '' }}",
        service_id: "{{ $personnel->service_id ?? '' }}",
        type_contrat: "{{ $personnel->type_contrat ?? '' }}",
        date_embauche: "{{ $personnel->date_embauche ? $personnel->date_embauche->format('Y-m-d') : '' }}",
        date_fin_contrat: "{{ $personnel->date_fin_contrat ? $personnel->date_fin_contrat->format('Y-m-d') : '' }}",
        is_active: {{ $personnel->is_active ? 'true' : 'false' }}
    };

    console.log('👤 Données personnel complètes:', personnel);

    // Pré-remplir TOUS les champs du formulaire
    document.getElementById('edit_civilite').value = personnel.civilite || '';
    document.getElementById('edit_nom').value = personnel.nom || '';
    document.getElementById('edit_prenoms').value = personnel.prenoms || '';
    document.getElementById('edit_sexe').value = personnel.sexe || '';
    document.getElementById('edit_date_naissance').value = personnel.date_naissance || '';
    document.getElementById('edit_numero_identification').value = personnel.numero_identification || '';
    document.getElementById('edit_telephone_code_pays').value = personnel.telephone_code_pays || '';
    document.getElementById('edit_telephone').value = personnel.telephone || '';
    document.getElementById('edit_telephone_whatsapp').checked = personnel.telephone_whatsapp;
    document.getElementById('edit_adresse').value = personnel.adresse || '';
    document.getElementById('edit_matricule').value = personnel.matricule || '';
    document.getElementById('edit_poste').value = personnel.poste || '';

    // Debug: Vérifier les départements disponibles
    const deptSelect = document.getElementById('edit_departement_id');
    const deptCount = deptSelect.options.length - 1; // -1 pour exclure l'option vide
    console.log('🏢 Nombre de départements dans le select:', deptCount);
    console.log('🏢 Options disponibles:', Array.from(deptSelect.options).map(opt => ({value: opt.value, text: opt.text})));

    if (deptCount === 0) {
        console.error('⚠️ PROBLÈME: Aucun département trouvé dans le select!');
        console.error('⚠️ Vérifiez que $departements est bien passé à la vue par le controller');
    } else {
        console.log(`✅ ${deptCount} département(s) disponible(s)`);
    }

    document.getElementById('edit_departement_id').value = personnel.departement_id || '';
    document.getElementById('edit_type_contrat').value = personnel.type_contrat || '';
    document.getElementById('edit_date_embauche').value = personnel.date_embauche || '';
    document.getElementById('edit_date_fin_contrat').value = personnel.date_fin_contrat || '';
    document.getElementById('edit_is_active').checked = personnel.is_active;

    console.log('✅ Formulaire pré-rempli avec TOUTES les données');

    // Charger les services si un département est sélectionné
    if (personnel.departement_id) {
        console.log('⏳ Chargement des services avant définition du service_id...');
        await loadServices(personnel.departement_id);
        // Définir la valeur du service APRÈS le chargement
        if (personnel.service_id) {
            document.getElementById('edit_service_id').value = personnel.service_id;
            console.log(`✅ Service ${personnel.service_id} sélectionné`);
        }
    }

    // Gérer l'affichage de la date de fin selon le type de contrat
    toggleDateFinContrat(personnel.type_contrat);

    // Ouvrir la modale
    document.getElementById('editPersonnelModal').classList.add('show');
    console.log('✅ Modale ouverte');
    console.log('═══════════════════════════════════════');
}

/**
 * Fermer la modale d'édition
 */
function closeEditPersonnelModal() {
    console.log('🔒 Fermeture modale édition...');
    const modal = document.getElementById('editPersonnelModal');
    const form = document.getElementById('editPersonnelForm');

    if (modal) {
        modal.classList.remove('show');
        console.log('✅ Modale fermée');
    }

    // Reset du formulaire après animation
    if (form) {
        setTimeout(() => {
            form.reset();
            console.log('✅ Formulaire réinitialisé');
        }, 300);
    }
}

/**
 * Gérer l'affichage du champ "Date fin de contrat" selon le type de contrat
 * CDI = pas de date de fin (champ caché et vidé)
 * CDD/Stage/Prestation = date de fin requise (champ visible)
 */
function toggleDateFinContrat(typeContrat) {
    const dateFinGroup = document.getElementById('edit_date_fin_contrat_group');
    const dateFinInput = document.getElementById('edit_date_fin_contrat');

    if (!dateFinGroup || !dateFinInput) return;

    if (typeContrat === 'CDI') {
        // CDI = pas de date de fin
        dateFinGroup.style.display = 'none';
        dateFinInput.value = ''; // Vider le champ
        dateFinInput.removeAttribute('required');
        console.log('📅 CDI détecté - Date fin masquée et vidée');
    } else {
        // CDD/Stage/Prestation = date de fin requise
        dateFinGroup.style.display = 'block';
        if (typeContrat === 'CDD' || typeContrat === 'Stage') {
            dateFinInput.setAttribute('required', 'required');
        }
        console.log(`📅 ${typeContrat} détecté - Date fin affichée`);
    }
}

/**
 * Charger les services d'un département (version async/await)
 * Ne définit PAS automatiquement le service sélectionné
 * Retourne une Promise pour permettre l'utilisation avec await
 */
async function loadServices(departementId) {
    console.log(`🔄 Chargement des services du département ${departementId}...`);

    const serviceSelect = document.getElementById('edit_service_id');

    if (!serviceSelect) {
        console.error('❌ Select service non trouvé');
        return;
    }

    try {
        const response = await fetch(`/personnels/services/${departementId}`);
        const result = await response.json();

        // Le controller retourne { success: true, data: [...] }
        const services = result.data || [];

        console.log(`✅ ${services.length} service(s) trouvé(s)`);

        // Vider le select
        serviceSelect.innerHTML = '<option value="">Sélectionner un service</option>';

        // Ajouter les services
        services.forEach(service => {
            const option = document.createElement('option');
            option.value = service.id;
            option.textContent = service.nom;
            serviceSelect.appendChild(option);
        });

        console.log('✅ Services chargés dans le select (prêt pour sélection)');
    } catch (error) {
        console.error('❌ Erreur chargement services:', error);
    }
}

/**
 * Event listener pour changement de département
 */
document.getElementById('edit_departement_id')?.addEventListener('change', function() {
    const departementId = this.value;
    if (departementId) {
        loadServices(departementId);
    } else {
        document.getElementById('edit_service_id').innerHTML = '<option value="">Sélectionner un service</option>';
    }
});

/**
 * Event listener pour changement de type de contrat
 */
document.getElementById('edit_type_contrat')?.addEventListener('change', function() {
    toggleDateFinContrat(this.value);
});

/**
 * Validation côté client du formulaire
 */
function validateEditForm() {
    let isValid = true;
    const errors = {};

    // Réinitialiser les erreurs
    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
    document.querySelectorAll('.form-input-compact').forEach(el => {
        el.style.borderColor = '';
    });

    // Validation Nom
    const nom = document.getElementById('edit_nom').value.trim();
    if (!nom || nom.length < 2) {
        errors.nom = 'Le nom doit contenir au moins 2 caractères';
        isValid = false;
    }

    // Validation Prénoms
    const prenoms = document.getElementById('edit_prenoms').value.trim();
    if (!prenoms || prenoms.length < 2) {
        errors.prenoms = 'Le(s) prénom(s) doivent contenir au moins 2 caractères';
        isValid = false;
    }

    // Validation Date de naissance (pas dans le futur)
    const dateNaissance = document.getElementById('edit_date_naissance').value;
    if (dateNaissance && new Date(dateNaissance) > new Date()) {
        errors.date_naissance = 'La date de naissance ne peut pas être dans le futur';
        isValid = false;
    }

    // Validation Date d'embauche (pas dans le futur)
    const dateEmbauche = document.getElementById('edit_date_embauche').value;
    if (dateEmbauche && new Date(dateEmbauche) > new Date()) {
        errors.date_embauche = 'La date d\'embauche ne peut pas être dans le futur';
        isValid = false;
    }

    // Validation Date fin contrat (doit être après la date d'embauche pour CDD)
    const typeContrat = document.getElementById('edit_type_contrat').value;
    const dateFinContrat = document.getElementById('edit_date_fin_contrat').value;
    if (typeContrat === 'CDD' && dateFinContrat && dateEmbauche) {
        if (new Date(dateFinContrat) <= new Date(dateEmbauche)) {
            errors.date_fin_contrat = 'La date de fin doit être après la date d\'embauche';
            isValid = false;
        }
    }

    // Afficher les erreurs
    Object.keys(errors).forEach(field => {
        const errorElement = document.getElementById(`error_${field}`);
        const inputElement = document.getElementById(`edit_${field}`);

        if (errorElement) {
            errorElement.textContent = errors[field];
        }
        if (inputElement) {
            inputElement.style.borderColor = '#ef4444';
            inputElement.focus();
        }
    });

    if (!isValid) {
        console.log('❌ Validation échouée:', errors);
        alert('Veuillez corriger les erreurs dans le formulaire avant de continuer.');
    }

    return isValid;
}

/**
 * Soumission du formulaire d'édition
 */
document.getElementById('editPersonnelForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Validation côté client
    if (!validateEditForm()) {
        return;
    }

    console.log('═══════════════════════════════════════');
    console.log('📤 SOUMISSION ÉDITION PERSONNEL');
    console.log('═══════════════════════════════════════');

    const formData = new FormData(e.target);
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Désactiver le bouton et afficher un loader
    const originalBtnHtml = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;">
            <circle cx="12" cy="12" r="10"></circle>
        </svg>
        <style>@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }</style>
        Enregistrement...
    `;

    // Convertir FormData en objet
    const data = {};
    formData.forEach((value, key) => {
        if (key === '_token' || key === '_method') return;
        if (key === 'is_active') {
            data[key] = value ? 1 : 0;
        } else if (key === 'date_fin_contrat' && !value) {
            // Si date_fin_contrat est vide (CDI), envoyer null au lieu de chaîne vide
            data[key] = null;
        } else {
            data[key] = value || null;
        }
    });

    console.log('📦 Données à envoyer:', data);

    try {
        const response = await fetch('/personnels/{{ $personnel->id }}', {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        console.log('📡 Réponse reçue:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok
        });

        const result = await response.json();
        console.log('📦 Données de la réponse:', result);

        if (response.ok && result.success) {
            console.log('✅ Modification réussie');
            console.log('═══════════════════════════════════════');

            // Afficher le message de succès moderne
            showSuccessMessage({
                nom: data.nom,
                prenoms: data.prenoms,
                matricule: data.matricule,
                poste: data.poste
            });

            // Fermer la modale et recharger la page
            closeEditPersonnelModal();
            setTimeout(() => {
                window.location.reload();
            }, 2000);

        } else {
            throw new Error(result.message || 'Erreur lors de la modification');
        }
    } catch (error) {
        console.error('═══════════════════════════════════════');
        console.error('❌ ERREUR MODIFICATION');
        console.error('═══════════════════════════════════════');
        console.error('Type:', error.name);
        console.error('Message:', error.message);

        const errorLines = [
            '╔═══════════════════════════════════════╗',
            '║   ❌ ERREUR DE MODIFICATION           ║',
            '╚═══════════════════════════════════════╝',
            '',
            `⚠️ ${error.message}`,
            '',
            '💡 VÉRIFICATIONS:',
            '───────────────────────────────────────',
            '  ✓ Tous les champs requis sont remplis',
            '  ✓ Les données sont valides',
            '  ✓ Votre connexion internet',
            '',
            '📞 Si le problème persiste, contactez',
            '   l\'administrateur système.',
            '',
            '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━'
        ].join('\n');

        alert(errorLines);

        // Restaurer le bouton
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHtml;
    }
});

/**
 * Afficher un message de succès moderne avec animation
 */
function showSuccessMessage(personnel) {
    // Créer l'élément de notification
    const notification = document.createElement('div');
    notification.className = 'success-notification';
    notification.innerHTML = `
        <div class="success-notification-content">
            <div class="success-icon-wrapper">
                <svg class="success-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
            </div>
            <div class="success-text">
                <h3 class="success-title">Modification réussie</h3>
                <p class="success-details">
                    <strong>${personnel.nom} ${personnel.prenoms}</strong><br>
                    <span class="success-meta">Matricule: ${personnel.matricule} • ${personnel.poste || 'Poste non défini'}</span>
                </p>
                <p class="success-reload">La page va se recharger dans un instant...</p>
            </div>
        </div>
        <div class="success-progress"></div>
    `;

    // Ajouter au body
    document.body.appendChild(notification);

    // Animation d'entrée
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Animation de la barre de progression
    setTimeout(() => {
        const progress = notification.querySelector('.success-progress');
        progress.style.width = '0%';
    }, 100);

    // Retirer après 2 secondes
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 1800);
}

/**
 * Fermer la modale d'édition avec Escape
 */
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modal = document.getElementById('editPersonnelModal');
        if (modal && modal.classList.contains('show')) {
            console.log('⌨️ Touche Escape - fermeture modale édition');
            closeEditPersonnelModal();
        }
    }
});

/**
 * Fermer la modale d'édition en cliquant sur l'overlay
 */
document.getElementById('editPersonnelModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'editPersonnelModal') {
        console.log('🖱️ Clic sur overlay - fermeture modale édition');
        closeEditPersonnelModal();
    }
});

/**
 * Empêcher la propagation depuis le contenu de la modale d'édition
 */
document.getElementById('editPersonnelModalContent')?.addEventListener('click', (e) => {
    e.stopPropagation();
});

/**
 * Validation en temps réel des champs
 */
document.addEventListener('DOMContentLoaded', function() {
    // Validation Nom en temps réel
    const nomInput = document.getElementById('edit_nom');
    if (nomInput) {
        nomInput.addEventListener('blur', function() {
            const value = this.value.trim();
            const errorEl = document.getElementById('error_nom');
            if (value.length > 0 && value.length < 2) {
                errorEl.textContent = 'Le nom doit contenir au moins 2 caractères';
                this.style.borderColor = '#ef4444';
            } else if (value.length >= 2) {
                errorEl.textContent = '';
                this.style.borderColor = '#10b981';
            } else {
                errorEl.textContent = '';
                this.style.borderColor = '';
            }
        });
    }

    // Validation Prénoms en temps réel
    const prenomsInput = document.getElementById('edit_prenoms');
    if (prenomsInput) {
        prenomsInput.addEventListener('blur', function() {
            const value = this.value.trim();
            const errorEl = document.getElementById('error_prenoms');
            if (value.length > 0 && value.length < 2) {
                errorEl.textContent = 'Le(s) prénom(s) doivent contenir au moins 2 caractères';
                this.style.borderColor = '#ef4444';
            } else if (value.length >= 2) {
                errorEl.textContent = '';
                this.style.borderColor = '#10b981';
            } else {
                errorEl.textContent = '';
                this.style.borderColor = '';
            }
        });
    }

    // Validation Email en temps réel
    const emailInput = document.getElementById('edit_email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value.length > 0 && !value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                this.style.borderColor = '#ef4444';
            } else if (value.length > 0) {
                this.style.borderColor = '#10b981';
            } else {
                this.style.borderColor = '';
            }
        });
    }

    // Validation Téléphone (format)
    const telInput = document.getElementById('edit_telephone');
    if (telInput) {
        telInput.addEventListener('input', function() {
            // Auto-formatage pour numéro
            let value = this.value.replace(/[^\d\s]/g, '');
            this.value = value;
        });
    }

    // Validation Code Pays (format)
    const codePaysInput = document.getElementById('edit_telephone_code_pays');
    if (codePaysInput) {
        codePaysInput.addEventListener('input', function() {
            // Auto-formatage pour code pays (ex: +225)
            let value = this.value.replace(/[^\d+]/g, '');
            if (value && !value.startsWith('+')) {
                value = '+' + value;
            }
            this.value = value;
        });
    }
});
</script>
@endsection
