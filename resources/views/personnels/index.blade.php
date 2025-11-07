@extends('layouts.app')

@section('title', 'Gestion du Personnel')

@section('styles')
<style>
/* Base Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

/* Page Container */
.personnel-page {
    padding: 24px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--text-primary);
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-description {
    color: var(--text-muted);
    font-size: 0.9375rem;
    margin-top: 4px;
}

/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: var(--gradient);
    transition: width 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
}

.stat-card:hover::before {
    width: 100%;
    opacity: 0.05;
}

.stat-card.total::before { background: var(--primary-gradient); }
.stat-card.active::before { background: var(--success-gradient); }
.stat-card.inactive::before { background: var(--danger-gradient); }
.stat-card.no-account::before { background: var(--warning-gradient); }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 12px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-card.total .stat-icon {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    color: #667eea;
}

.stat-card.active .stat-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
    color: #10b981;
}

.stat-card.inactive .stat-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(220, 38, 38, 0.1) 100%);
    color: #ef4444;
}

.stat-card.no-account .stat-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
    color: #f59e0b;
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 8px;
    font-weight: 500;
}

/* Search and Filter Toolbar */
.table-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 1px solid var(--card-border);
    border-radius: 10px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: var(--transition);
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.toolbar-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Buttons */
.btn {
    padding: 13px 24px;
    border-radius: 12px;
    font-size: 0.938rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    letter-spacing: 0.3px;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.2);
    transition: left 0.5s ease;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: var(--primary-gradient);
    color: #ffffff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.5);
}

.btn-secondary {
    background: #ffffff;
    color: #475569;
    border-color: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.dark .btn-secondary {
    background: #334155;
    color: #e2e8f0;
    border-color: #475569;
}

.btn-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

/* Table Card */
.table-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.table-container {
    overflow-x: auto;
}

.personnel-table {
    width: 100%;
    border-collapse: collapse;
}

.personnel-table thead {
    background: var(--primary-gradient);
}

.personnel-table th {
    padding: 18px 20px;
    text-align: left;
    font-size: 0.813rem;
    font-weight: 700;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    white-space: nowrap;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.personnel-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
    font-size: 0.9375rem;
}

.personnel-table tbody tr {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.personnel-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    transform: translateY(-1px);
}

/* Personnel Avatar */
.personnel-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.personnel-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--card-border);
}

.personnel-info {
    display: flex;
    flex-direction: column;
}

.personnel-name {
    font-weight: 600;
    color: var(--text-primary);
}

.personnel-matricule {
    font-size: 0.8125rem;
    color: var(--text-muted);
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.badge-success {
    background: var(--success-gradient);
    color: #ffffff;
}

.badge-danger {
    background: var(--danger-gradient);
    color: #ffffff;
}

.badge-warning {
    background: var(--warning-gradient);
    color: #ffffff;
}

.badge-info {
    background: var(--info-gradient);
    color: #ffffff;
}

.badge-primary {
    background: var(--primary-gradient);
    color: #ffffff;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-icon.btn-view {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.btn-icon.btn-view:hover {
    background: var(--info-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-icon.btn-edit {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.btn-icon.btn-edit:hover {
    background: var(--success-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-icon.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.btn-icon.btn-delete:hover {
    background: var(--danger-gradient);
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Multi-Step Modal - Ultra Professional */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(88, 28, 135, 0.3) 100%);
    backdrop-filter: blur(12px) saturate(180%);
    -webkit-backdrop-filter: blur(12px) saturate(180%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 20px;
}

.modal-overlay.show {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 24px;
    box-shadow:
        0 50px 100px -20px rgba(102, 126, 234, 0.25),
        0 30px 60px -30px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(40px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.dark .modal {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(148, 163, 184, 0.1);
}

.modal-overlay.show .modal {
    transform: scale(1) translateY(0);
}

.modal::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 400px;
    background: radial-gradient(circle at 50% 0%, rgba(102, 126, 234, 0.08) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 32px 32px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.modal-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    letter-spacing: -0.025em;
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 12px;
}

.modal-title::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 28px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 2px;
}

.modal-close {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg) scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
}

.modal-close:active {
    transform: rotate(90deg) scale(0.95);
}

/* Step Indicator - Enhanced */
.step-indicator {
    display: flex;
    justify-content: space-between;
    padding: 32px 40px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
    border-bottom: 1px solid var(--card-border);
    position: relative;
    overflow: hidden;
}

.step-indicator::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--primary-gradient);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.5s ease;
}

.step-indicator.progress-33::before {
    transform: scaleX(0.33);
}

.step-indicator.progress-66::before {
    transform: scaleX(0.66);
}

.step-indicator.progress-100::before {
    transform: scaleX(1);
}

.step {
    flex: 1;
    display: flex;
    align-items: center;
    position: relative;
    cursor: pointer;
    padding: 8px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.step:hover:not(.completed) {
    background: rgba(102, 126, 234, 0.05);
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: calc(50% + 24px);
    right: calc(-50% + 24px);
    top: 28px;
    height: 3px;
    background: var(--card-border);
    z-index: 0;
    transition: all 0.5s ease;
}

.step.active:not(:last-child)::after,
.step.completed:not(:last-child)::after {
    background: var(--primary-gradient);
    height: 4px;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.step-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    border: 3px solid var(--card-border);
    color: var(--text-muted);
    font-weight: 700;
    font-size: 1rem;
    z-index: 1;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.step-circle::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--primary-gradient);
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s ease;
}

.step.active .step-circle::before {
    opacity: 0.2;
    transform: scale(1.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.2;
        transform: scale(1.3);
    }
    50% {
        opacity: 0.1;
        transform: scale(1.5);
    }
}

.step.active .step-circle {
    background: var(--primary-gradient);
    border-color: #667eea;
    color: #ffffff;
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
    transform: scale(1.1);
}

.step.completed .step-circle {
    background: var(--success-gradient);
    border-color: #10b981;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    transform: scale(1.05);
}

.step-info {
    margin-left: 16px;
    flex: 1;
}

.step-label {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 4px;
    transition: all 0.3s ease;
    letter-spacing: 0.3px;
}

.step.active .step-label {
    color: #667eea;
    transform: translateX(2px);
}

.step.completed .step-label {
    color: #10b981;
}

.step-description {
    font-size: 0.75rem;
    color: var(--text-muted);
    opacity: 0.7;
    transition: all 0.3s ease;
}

.step.active .step-description {
    opacity: 1;
    color: #667eea;
}

.step.completed .step-description {
    opacity: 0.8;
    color: #10b981;
}

/* Modal Body - Premium Design */
.modal-body {
    padding: 32px 36px;
    max-height: calc(90vh - 280px);
    overflow-y: auto;
    position: relative;
    z-index: 1;
    background: rgba(255, 255, 255, 0.4);
}

.dark .modal-body {
    background: rgba(15, 23, 42, 0.4);
}

.step-content {
    display: none;
}

.step-content.active {
    display: block;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Matricule Preview - Professional Badge */
.matricule-preview {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border: 2px dashed rgba(102, 126, 234, 0.3);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.matricule-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.matricule-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    flex-shrink: 0;
}

.matricule-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.matricule-label {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #667eea;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.matricule-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

/* Form Grid - Enhanced */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.form-grid.full {
    grid-template-columns: 1fr;
}

.form-group {
    margin-bottom: 0;
    position: relative;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 10px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    font-size: 0.75rem;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 6px;
    font-size: 1rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid transparent;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.8);
    color: var(--text-primary);
    font-size: 0.9375rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow:
        0 1px 3px rgba(0, 0, 0, 0.05),
        inset 0 1px 2px rgba(0, 0, 0, 0.05);
}

.dark .form-input,
.dark .form-select,
.dark .form-textarea {
    background: rgba(30, 41, 59, 0.8);
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #667eea;
    background: #ffffff;
    box-shadow:
        0 0 0 4px rgba(102, 126, 234, 0.12),
        0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-1px);
}

.dark .form-input:focus,
.dark .form-select:focus,
.dark .form-textarea:focus {
    background: #1e293b;
}

.form-input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.form-error {
    color: #ef4444;
    font-size: 0.8125rem;
    margin-top: 6px;
    display: none;
}

.form-error.show {
    display: block;
}

/* Phone Input with Country Code */
.phone-input-group {
    display: flex;
    gap: 8px;
}

.phone-input-group .form-select {
    flex: 0 0 100px;
}

.phone-input-group .form-input {
    flex: 1;
}

/* Checkbox Group */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: var(--bg-secondary);
    border-radius: 10px;
    border: 1px solid var(--card-border);
}

.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-input {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #667eea;
}

.checkbox-label {
    font-size: 0.9375rem;
    color: var(--text-primary);
    font-weight: 500;
    cursor: pointer;
}

/* Date Fin CDD (conditional) */
#dateFin ContratGroup {
    transition: all 0.3s ease;
}

#dateFinContratGroup.hidden {
    display: none;
}

/* Modal Footer */
.modal-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 24px 28px;
    border-top: 1px solid var(--card-border);
    background: var(--bg-secondary);
}

.modal-footer .btn-group {
    display: flex;
    gap: 12px;
}

/* File Upload Preview */
.file-upload-wrapper {
    position: relative;
}

.file-preview {
    margin-top: 12px;
    display: none;
}

.file-preview.show {
    display: block;
}

.file-preview img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid var(--card-border);
}

/* Notification Toast */
.notification-toast {
    position: fixed;
    top: 20px;
    right: -400px;
    min-width: 320px;
    max-width: 420px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    z-index: 10000;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border-left: 4px solid #667eea;
}

.dark .notification-toast {
    background: #1e293b;
}

.notification-toast.show {
    right: 20px;
}

.notification-toast.notification-success {
    border-left-color: #10b981;
}

.notification-toast.notification-error {
    border-left-color: #ef4444;
}

.notification-toast.notification-info {
    border-left-color: #3b82f6;
}

.notification-content {
    display: flex;
    align-items: start;
    gap: 12px;
    padding: 16px 20px;
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0;
}

.notification-success .notification-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #10b981;
}

.notification-error .notification-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #ef4444;
}

.notification-info .notification-icon {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.15) 100%);
    color: #3b82f6;
}

.notification-message {
    flex: 1;
    font-size: 0.9375rem;
    color: var(--text-primary);
    line-height: 1.5;
}

.notification-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 24px;
    height: 24px;
    border: none;
    background: transparent;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 24px;
    line-height: 1;
    transition: all 0.2s ease;
}

.notification-close:hover {
    color: var(--text-primary);
    transform: rotate(90deg);
}

/* Loading Spinner Animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Form Improvements */
.form-input.error,
.form-select.error {
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

.form-input:disabled,
.form-select:disabled {
    background: var(--bg-tertiary);
    opacity: 0.6;
    cursor: not-allowed;
}

/* Better Modal Scrollbar */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: var(--bg-secondary);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .table-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        max-width: 100%;
    }

    /* Mobile Step Indicator */
    .step-indicator {
        padding: 20px 16px;
    }

    .step {
        flex-direction: column;
        padding: 4px;
    }

    .step-info {
        margin-left: 0;
        margin-top: 8px;
        text-align: center;
    }

    .step-label {
        font-size: 0.75rem;
        margin-bottom: 2px;
    }

    .step-description {
        display: none;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
    }

    .step:not(:last-child)::after {
        display: none;
    }

    .modal {
        max-width: 100%;
        border-radius: 0;
        max-height: 100vh;
    }

    .modal-body {
        padding: 20px;
    }

    .notification-toast {
        min-width: auto;
        left: 10px;
        right: 10px;
        max-width: calc(100% - 20px);
    }

    .notification-toast.show {
        right: 10px;
    }
}

/* Tablet */
@media (min-width: 769px) and (max-width: 1024px) {
    .step-description {
        font-size: 0.7rem;
    }

    .step-circle {
        width: 44px;
        height: 44px;
    }
}
</style>
@endsection

@section('content')
<div class="personnel-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestion du Personnel</h1>
            <p class="page-description">Gérez les employés et leurs informations</p>
        </div>
        <button class="btn btn-primary" id="btnAddPersonnel">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            Ajouter un personnel
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->total() ?? 0 }}">0</div>
                    <div class="stat-label">Personnel Total</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card active">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->where('is_active', true)->count() }}">0</div>
                    <div class="stat-label">Personnel Actif</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card inactive">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->where('is_active', false)->count() }}">0</div>
                    <div class="stat-label">Personnel Inactif</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>
        <div class="stat-card no-account">
            <div class="stat-header">
                <div class="stat-content">
                    <div class="stat-value" data-count="{{ $personnels->whereNull('user_id')->count() }}">0</div>
                    <div class="stat-label">Sans Compte</div>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="table-toolbar">
        <div class="search-box">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="search" placeholder="Rechercher un personnel..." id="searchInput">
        </div>
        <div class="toolbar-actions">
            <button class="btn btn-secondary" id="btnFilter">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                Filtrer
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-container">
            <table class="personnel-table">
                <thead>
                    <tr>
                        <th>Personnel</th>
                        <th>Sexe</th>
                        <th>Poste</th>
                        <th>Département</th>
                        <th>Téléphone</th>
                        <th>Contrat</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="personnelTableBody">
                    @forelse($personnels as $personnel)
                    <tr data-personnel-id="{{ $personnel->id }}">
                        <td>
                            <div class="personnel-cell">
                                <img src="{{ $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel->nom_complet) . '&background=667eea&color=fff' }}" alt="Photo" class="personnel-avatar">
                                <div class="personnel-info">
                                    <span class="personnel-name">{{ $personnel->nom_complet }}</span>
                                    <span class="personnel-matricule">{{ $personnel->matricule }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $personnel->sexe ?? 'N/A' }}</td>
                        <td>{{ $personnel->poste ?? 'Non défini' }}</td>
                        <td>{{ $personnel->departement->nom ?? 'Non assigné' }}</td>
                        <td>{{ $personnel->telephone_complet ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $personnel->type_contrat === 'CDI' ? 'badge-info' : 'badge-warning' }}">
                                {{ $personnel->type_contrat }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $personnel->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $personnel->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('personnels.show', $personnel->id) }}" class="btn-icon btn-view" title="Voir détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <button class="btn-icon btn-edit" title="Modifier" onclick="editPersonnel({{ $personnel->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </button>
                                <button class="btn-icon btn-delete" title="Supprimer" onclick="deletePersonnel({{ $personnel->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 60px 20px;">
                            <div style="opacity: 0.6;">
                                <svg style="width: 80px; height: 80px; margin: 0 auto 20px; color: var(--text-muted);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary); margin-bottom: 8px;">Aucun personnel trouvé</h3>
                                <p style="color: var(--text-muted); font-size: 0.9375rem;">Commencez par ajouter votre premier employé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($personnels->hasPages())
    <div style="margin-top: 24px;">
        {{ $personnels->links() }}
    </div>
    @endif
</div>

<!-- Multi-Step Modal -->
<div class="modal-overlay" id="personnelModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Enregistrer un nouveau personnel</h2>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <!-- Step Indicator - Enhanced -->
        <div class="step-indicator progress-33" id="stepIndicator">
            <div class="step active" data-step="1" onclick="goToStep(1)">
                <div class="step-circle">1</div>
                <div class="step-info">
                    <div class="step-label">Informations Personnelles</div>
                    <div class="step-description">Identité et civilité</div>
                </div>
            </div>
            <div class="step" data-step="2" onclick="goToStep(2)">
                <div class="step-circle">2</div>
                <div class="step-info">
                    <div class="step-label">Coordonnées & Documents</div>
                    <div class="step-description">Contact et pièces</div>
                </div>
            </div>
            <div class="step" data-step="3" onclick="goToStep(3)">
                <div class="step-circle">3</div>
                <div class="step-info">
                    <div class="step-label">Poste & Contrat</div>
                    <div class="step-description">Emploi et statut</div>
                </div>
            </div>
        </div>

        <form id="personnelForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="personnelId" name="personnel_id">

            <div class="modal-body">
                <!-- Step 1: Informations Personnelles -->
                <div class="step-content active" data-step="1">
                    @if(auth()->user()->hasRole('Super Admin'))
                    <div class="form-grid full" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="entreprise_id" class="form-label required">Entreprise</label>
                            <select id="entreprise_id" name="entreprise_id" class="form-select" required>
                                <option value="">Sélectionner une entreprise</option>
                                @foreach($entreprises as $entreprise)
                                <option value="{{ $entreprise->id }}" {{ $entreprise->id == auth()->user()->entreprise_id ? 'selected' : '' }}>
                                    {{ $entreprise->nom }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-error" id="errorEntreprise"></div>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="entreprise_id" value="{{ auth()->user()->entreprise_id }}">
                    @endif

                    <div class="form-grid full" style="margin-bottom: 20px;">
                        <div class="form-group">
                            <label for="matricule" class="form-label">Matricule (optionnel)</label>
                            <input type="text" id="matricule" name="matricule" class="form-input" placeholder="Laissez vide pour génération automatique">
                            <div style="margin-top: 8px; font-size: 0.813rem; color: var(--text-muted);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 4px;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="16" x2="12" y2="12"></line>
                                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                </svg>
                                Si vide, sera généré automatiquement au format: <strong>PER{{ date('Y') }}####</strong>
                            </div>
                            <div class="form-error" id="errorMatricule"></div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="civilite" class="form-label">Civilité</label>
                            <select id="civilite" name="civilite" class="form-select">
                                <option value="">Sélectionner</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                                <option value="Dr">Dr</option>
                                <option value="Pr">Pr</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select id="sexe" name="sexe" class="form-select">
                                <option value="">Sélectionner</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nom" class="form-label required">Nom</label>
                            <input type="text" id="nom" name="nom" class="form-input" placeholder="Nom de famille" required>
                            <div class="form-error" id="errorNom"></div>
                        </div>

                        <div class="form-group">
                            <label for="prenoms" class="form-label required">Prénoms</label>
                            <input type="text" id="prenoms" name="prenoms" class="form-input" placeholder="Prénoms" required>
                            <div class="form-error" id="errorPrenoms"></div>
                        </div>

                        <div class="form-group">
                            <label for="date_naissance" class="form-label">Date de Naissance</label>
                            <input type="date" id="date_naissance" name="date_naissance" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" id="photo" name="photo" class="form-input" accept="image/*" onchange="previewPhoto(event)">
                            <div class="file-preview" id="photoPreview">
                                <img id="photoPreviewImg" src="" alt="Aperçu">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Coordonnées & Documents -->
                <div class="step-content" data-step="2">
                    <div class="form-grid full">
                        <div class="form-group">
                            <label for="adresse" class="form-label">Adresse</label>
                            <input type="text" id="adresse" name="adresse" class="form-input" placeholder="Adresse complète">
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <div class="phone-input-group">
                                <select id="telephone_code_pays" name="telephone_code_pays" class="form-select">
                                    <option value="+225" selected>+225 (CI)</option>
                                    <option value="+33">+33 (FR)</option>
                                    <option value="+1">+1 (US)</option>
                                    <option value="+44">+44 (UK)</option>
                                    <option value="+237">+237 (CM)</option>
                                    <option value="+221">+221 (SN)</option>
                                </select>
                                <input type="tel" id="telephone" name="telephone" class="form-input" placeholder="0123456789">
                            </div>
                            <div style="margin-top: 8px;">
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" id="telephone_whatsapp" name="telephone_whatsapp" class="checkbox-input" value="1">
                                    <span class="checkbox-label">Numéro WhatsApp</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero_identification" class="form-label">N° d'Identification</label>
                            <input type="text" id="numero_identification" name="numero_identification" class="form-input" placeholder="CNI, Passeport, etc.">
                        </div>
                    </div>
                </div>

                <!-- Step 3: Poste & Contrat -->
                <div class="step-content" data-step="3">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="poste" class="form-label">Poste</label>
                            <input type="text" id="poste" name="poste" class="form-input" placeholder="Ex: Développeur Web">
                        </div>

                        <div class="form-group">
                            <label for="departement_id" class="form-label">Département</label>
                            <select id="departement_id" name="departement_id" class="form-select" onchange="loadServices(this.value)">
                                <option value="">Sélectionner un département</option>
                                @foreach($departements as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="service_id" class="form-label">Service</label>
                            <select id="service_id" name="service_id" class="form-select" disabled>
                                <option value="">Sélectionner d'abord un département</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_embauche" class="form-label">Date d'Embauche</label>
                            <input type="date" id="date_embauche" name="date_embauche" class="form-input">
                        </div>
                    </div>

                    <div class="form-grid full">
                        <div class="form-group">
                            <label class="form-label required">Type de Contrat</label>
                            <div class="checkbox-group">
                                <label class="checkbox-wrapper">
                                    <input type="radio" name="type_contrat" value="CDI" class="checkbox-input" checked onchange="toggleDateFinContrat()">
                                    <span class="checkbox-label">CDI (Contrat à Durée Indéterminée)</span>
                                </label>
                                <label class="checkbox-wrapper">
                                    <input type="radio" name="type_contrat" value="CDD" class="checkbox-input" onchange="toggleDateFinContrat()">
                                    <span class="checkbox-label">CDD (Contrat à Durée Déterminée)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid hidden" id="dateFinContratGroup">
                        <div class="form-group">
                            <label for="date_fin_contrat" class="form-label required">Date de Fin de Contrat (CDD)</label>
                            <input type="date" id="date_fin_contrat" name="date_fin_contrat" class="form-input">
                            <div class="form-error" id="errorDateFinContrat"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnPrevStep" onclick="prevStep()" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Précédent
                </button>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                    <button type="button" class="btn btn-primary" id="btnNextStep" onclick="nextStep()">
                        Suivant
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Multi-step form logic
let currentStep = 1;
const totalSteps = 3;

// Open modal
document.getElementById('btnAddPersonnel').addEventListener('click', () => {
    document.getElementById('personnelModal').classList.add('show');
    resetForm();
});

// Close modal
function closeModal() {
    document.getElementById('personnelModal').classList.remove('show');
    resetForm();
}

// Reset form
function resetForm() {
    document.getElementById('personnelForm').reset();
    currentStep = 1;
    updateStepDisplay();
}

// Next step
function nextStep() {
    if (validateStep(currentStep)) {
        currentStep++;
        updateStepDisplay();
    }
}

// Previous step
function prevStep() {
    currentStep--;
    updateStepDisplay();
}

// Go to specific step (with validation)
function goToStep(targetStep) {
    // Ne permet pas d'aller à une étape future sans validation
    if (targetStep > currentStep) {
        // Valider toutes les étapes entre current et target
        for (let i = currentStep; i < targetStep; i++) {
            if (!validateStep(i)) {
                return; // Bloque si validation échoue
            }
        }
    }

    currentStep = targetStep;
    updateStepDisplay();
}

// Update step display - Enhanced
function updateStepDisplay() {
    const stepIndicator = document.getElementById('stepIndicator');

    // Update progress bar
    stepIndicator.classList.remove('progress-33', 'progress-66', 'progress-100');
    if (currentStep === 1) {
        stepIndicator.classList.add('progress-33');
    } else if (currentStep === 2) {
        stepIndicator.classList.add('progress-66');
    } else if (currentStep === 3) {
        stepIndicator.classList.add('progress-100');
    }

    // Update step indicator
    document.querySelectorAll('.step').forEach((step, index) => {
        const stepNum = index + 1;
        step.classList.remove('active', 'completed');

        if (stepNum < currentStep) {
            step.classList.add('completed');
            step.querySelector('.step-circle').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        } else if (stepNum === currentStep) {
            step.classList.add('active');
            step.querySelector('.step-circle').innerHTML = stepNum;
        } else {
            step.querySelector('.step-circle').innerHTML = stepNum;
        }
    });

    // Update step content with animation
    document.querySelectorAll('.step-content').forEach((content, index) => {
        content.classList.remove('active');
        if (index + 1 === currentStep) {
            setTimeout(() => {
                content.classList.add('active');
            }, 50);
        }
    });

    // Update buttons
    document.getElementById('btnPrevStep').style.display = currentStep === 1 ? 'none' : 'inline-flex';
    document.getElementById('btnNextStep').style.display = currentStep === totalSteps ? 'none' : 'inline-flex';
    document.getElementById('btnSubmit').style.display = currentStep === totalSteps ? 'inline-flex' : 'none';
}

// Validate step
function validateStep(step) {
    let isValid = true;
    const stepContent = document.querySelector(`.step-content[data-step="${step}"]`);
    const requiredInputs = stepContent.querySelectorAll('[required]');

    requiredInputs.forEach(input => {
        const value = input.type === 'checkbox' || input.type === 'radio'
            ? (input.type === 'radio' ? document.querySelector(`input[name="${input.name}"]:checked`) : input.checked)
            : input.value.trim();

        if (!value) {
            isValid = false;
            input.classList.add('error');

            // Show error message
            const errorId = `error${input.id.charAt(0).toUpperCase() + input.id.slice(1)}`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.textContent = 'Ce champ est requis';
                errorElement.classList.add('show');
            }
        } else {
            input.classList.remove('error');

            // Hide error message
            const errorId = `error${input.id.charAt(0).toUpperCase() + input.id.slice(1)}`;
            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.classList.remove('show');
            }
        }
    });

    // Special validation for type_contrat
    if (step === 3) {
        const typeContrat = document.querySelector('input[name="type_contrat"]:checked');
        if (!typeContrat) {
            isValid = false;
            showNotification('Veuillez sélectionner un type de contrat', 'error');
        }
    }

    return isValid;
}

// Add real-time validation
function addRealTimeValidation() {
    const inputs = document.querySelectorAll('.form-input[required], .form-select[required]');

    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('error');
                const errorId = `error${this.id.charAt(0).toUpperCase() + this.id.slice(1)}`;
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.classList.remove('show');
                }
            }
        });
    });
}

// Initialize real-time validation
document.addEventListener('DOMContentLoaded', () => {
    addRealTimeValidation();
    animateStats();
});

// Animate statistics counters
function animateStats() {
    const statValues = document.querySelectorAll('.stat-value[data-count]');

    statValues.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-count'));
        const duration = 1500; // 1.5 seconds
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                stat.textContent = target;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(current);
            }
        }, 16);
    });
}

// Toggle date fin contrat visibility
function toggleDateFinContrat() {
    const typeContrat = document.querySelector('input[name="type_contrat"]:checked').value;
    const dateFinGroup = document.getElementById('dateFinContratGroup');

    if (typeContrat === 'CDD') {
        dateFinGroup.classList.remove('hidden');
        document.getElementById('date_fin_contrat').required = true;
    } else {
        dateFinGroup.classList.add('hidden');
        document.getElementById('date_fin_contrat').required = false;
    }
}

// Load services by department
async function loadServices(departementId) {
    const serviceSelect = document.getElementById('service_id');

    if (!departementId) {
        serviceSelect.disabled = true;
        serviceSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        return;
    }

    // Show loading state
    serviceSelect.disabled = true;
    serviceSelect.innerHTML = '<option value="">Chargement...</option>';

    try {
        const response = await fetch(`/personnels/services/${departementId}`);
        const data = await response.json();

        if (data.success && data.data) {
            serviceSelect.disabled = false;
            serviceSelect.innerHTML = '<option value="">Sélectionner un service (optionnel)</option>';

            data.data.forEach(service => {
                const option = document.createElement('option');
                option.value = service.id;
                option.textContent = service.nom;
                serviceSelect.appendChild(option);
            });
        } else {
            serviceSelect.disabled = false;
            serviceSelect.innerHTML = '<option value="">Aucun service disponible</option>';
        }
    } catch (error) {
        console.error('Erreur lors du chargement des services:', error);
        serviceSelect.disabled = false;
        serviceSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        showNotification('Erreur lors du chargement des services', 'error');
    }
}

// Preview photo
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreviewImg').src = e.target.result;
            document.getElementById('photoPreview').classList.add('show');
        };
        reader.readAsDataURL(file);
    }
}

// Submit form
document.getElementById('personnelForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    // Validate final step
    if (!validateStep(currentStep)) {
        showNotification('Veuillez remplir tous les champs requis', 'error');
        return;
    }

    const formData = new FormData(e.target);
    const submitBtn = document.getElementById('btnSubmit');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg> Enregistrement...';

    try {
        const response = await fetch('{{ route("personnels.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showNotification('Personnel enregistré avec succès!', 'success');
            closeModal();
            setTimeout(() => {
                window.location.href = window.location.href;
            }, 800);
        } else {
            // Display validation errors
            if (data.errors) {
                let errorMessage = 'Erreurs de validation:\n';
                Object.keys(data.errors).forEach(key => {
                    errorMessage += `- ${data.errors[key][0]}\n`;
                });
                showNotification(errorMessage, 'error');
            } else {
                showNotification(data.message || 'Une erreur est survenue lors de l\'enregistrement', 'error');
            }
        }
    } catch (error) {
        console.error('Erreur:', error);
        showNotification('Erreur de connexion au serveur', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Enregistrer';
    }
});

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotif = document.querySelector('.notification-toast');
    if (existingNotif) {
        existingNotif.remove();
    }

    const notif = document.createElement('div');
    notif.className = `notification-toast notification-${type}`;
    notif.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                ${type === 'success' ? '✓' : type === 'error' ? '✕' : 'ℹ'}
            </div>
            <div class="notification-message">${message.replace(/\n/g, '<br>')}</div>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">×</button>
    `;
    document.body.appendChild(notif);

    setTimeout(() => {
        notif.classList.add('show');
    }, 100);

    setTimeout(() => {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 300);
    }, 5000);
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal on overlay click
document.getElementById('personnelModal').addEventListener('click', (e) => {
    if (e.target.id === 'personnelModal') {
        closeModal();
    }
});

// Delete personnel
async function deletePersonnel(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce personnel?')) {
        return;
    }

    try {
        const response = await fetch(`/personnels/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('Personnel supprimé avec succès!');
            window.location.reload();
        } else {
            alert('Erreur: ' + (data.message || 'Une erreur est survenue'));
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur lors de la suppression');
    }
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#personnelTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});
</script>
@endsection
