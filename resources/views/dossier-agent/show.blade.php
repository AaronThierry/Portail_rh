@extends('layouts.app')

@section('title', 'Dossier de ' . $personnel->nom . ' ' . $personnel->prenoms)

@section('styles')
<style>
:root {
    --da-primary: #667eea;
    --da-secondary: #764ba2;
    --da-success: #10b981;
    --da-danger: #ef4444;
    --da-warning: #f59e0b;
    --da-info: #3b82f6;
}

.dossier-show-page {
    padding: 1.5rem;
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

/* Header Agent */
.agent-header {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.agent-profile {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex: 1;
    min-width: 300px;
}

.agent-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.35);
}

.agent-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}

.agent-details h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
}

.agent-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: #64748b;
    font-size: 0.875rem;
}

.agent-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.agent-stats-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.agent-stat-box {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    border-radius: 14px;
    padding: 1rem 1.5rem;
    text-align: center;
    min-width: 100px;
}

.agent-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--da-primary);
    line-height: 1;
}

.agent-stat-value.success { color: var(--da-success); }
.agent-stat-value.danger { color: var(--da-danger); }
.agent-stat-value.warning { color: var(--da-warning); }

.agent-stat-label {
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 0.25rem;
}

/* Actions */
.agent-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-action {
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

/* Tabs Catégories */
.categories-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.5rem;
    padding: 0.5rem;
    background: white;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
}

.category-tab {
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    border: none;
    background: transparent;
    color: #64748b;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.category-tab:hover {
    background: rgba(102, 126, 234, 0.08);
    color: var(--da-primary);
}

.category-tab.active {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
}

.category-tab .badge {
    padding: 0.125rem 0.5rem;
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    font-size: 0.75rem;
}

.category-tab:not(.active) .badge {
    background: #e2e8f0;
    color: #64748b;
}

/* Documents Grid */
.documents-section {
    margin-bottom: 2rem;
}

.documents-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
    padding: 0 0.5rem;
}

.documents-section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
}

.documents-section-title .icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.document-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: all 0.3s;
    border: 2px solid transparent;
}

.document-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: var(--da-primary);
}

.document-card-header {
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
}

.document-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.document-icon.pdf { background: #fef2f2; color: #dc2626; }
.document-icon.doc { background: #eff6ff; color: #2563eb; }
.document-icon.xls { background: #f0fdf4; color: #16a34a; }
.document-icon.img { background: #fefce8; color: #ca8a04; }
.document-icon.default { background: #f1f5f9; color: #64748b; }

.document-info {
    flex: 1;
    min-width: 0;
}

.document-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.938rem;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.document-filename {
    font-size: 0.75rem;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.document-badges {
    display: flex;
    gap: 0.375rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.doc-badge {
    padding: 0.125rem 0.5rem;
    border-radius: 20px;
    font-size: 0.688rem;
    font-weight: 600;
}

.doc-badge.expire { background: #fef2f2; color: #dc2626; }
.doc-badge.expiring { background: #fffbeb; color: #d97706; }
.doc-badge.confidentiel { background: #fef3c7; color: #92400e; }

.document-card-body {
    padding: 1rem;
}

.document-meta {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #64748b;
    margin-bottom: 1rem;
}

.document-meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.document-actions {
    display: flex;
    gap: 0.5rem;
}

.doc-btn {
    flex: 1;
    padding: 0.625rem;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.813rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    transition: all 0.2s;
    text-decoration: none;
}

.doc-btn.download {
    background: linear-gradient(135deg, var(--da-primary) 0%, var(--da-secondary) 100%);
    color: white;
}

.doc-btn.preview {
    background: #f1f5f9;
    color: #475569;
}

.doc-btn.delete {
    background: #fef2f2;
    color: #dc2626;
    padding: 0.625rem 0.75rem;
    flex: 0;
}

.doc-btn:hover {
    transform: translateY(-1px);
}

/* Empty Category */
.empty-category {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 14px;
    border: 2px dashed #e2e8f0;
}

.empty-category-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

/* ==================== UPLOAD MODAL PREMIUM ==================== */
.upload-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.upload-modal.show {
    display: flex;
    opacity: 1;
}

.upload-modal-content {
    background: #ffffff;
    border-radius: 28px;
    width: 100%;
    max-width: 680px;
    max-height: 92vh;
    overflow: hidden;
    box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1);
    transform: scale(0.9) translateY(20px);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.upload-modal.show .upload-modal-content {
    transform: scale(1) translateY(0);
}

.upload-modal-header {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    color: white;
    padding: 2rem 2rem 1.75rem;
    position: relative;
    overflow: hidden;
}

.upload-modal-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.upload-modal-header::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.upload-modal-header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.upload-modal-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
}

.upload-modal-icon svg {
    width: 28px;
    height: 28px;
}

.upload-modal-title-group h3 {
    margin: 0 0 0.25rem;
    font-size: 1.375rem;
    font-weight: 700;
    letter-spacing: -0.025em;
}

.upload-modal-subtitle {
    margin: 0;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.75);
}

.upload-modal-close {
    position: absolute;
    right: 1.25rem;
    top: 1.25rem;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 1.25rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
}

.upload-modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: rotate(90deg);
}

.upload-modal-body {
    padding: 2rem;
    max-height: calc(92vh - 200px);
    overflow-y: auto;
}

.upload-modal-body::-webkit-scrollbar {
    width: 6px;
}

.upload-modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
}

.upload-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.upload-modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Form Styles Premium */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.625rem;
    font-size: 0.875rem;
}

.form-label svg {
    width: 16px;
    height: 16px;
    color: #6366f1;
}

.form-label .required {
    color: #ef4444;
    font-weight: 700;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1.125rem;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    font-size: 0.9375rem;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-control:hover {
    border-color: #cbd5e1;
}

.form-control:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-control::placeholder {
    color: #94a3b8;
}

/* File Upload Zone Premium */
.file-upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.file-upload-zone::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.file-upload-zone:hover {
    border-color: #6366f1;
    background: linear-gradient(135deg, #faf5ff 0%, #f0f9ff 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.12);
}

.file-upload-zone:hover::before {
    opacity: 1;
}

.file-upload-zone.dragover {
    border-color: #6366f1;
    border-style: solid;
    background: linear-gradient(135deg, #ede9fe 0%, #e0e7ff 100%);
    transform: scale(1.02);
}

.file-upload-zone.has-file {
    border-color: #10b981;
    border-style: solid;
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
}

.file-upload-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.25rem;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    position: relative;
    z-index: 1;
    box-shadow: 0 12px 32px rgba(99, 102, 241, 0.3);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.file-upload-zone:hover .file-upload-icon {
    transform: scale(1.05) rotate(-3deg);
}

.file-upload-icon svg {
    width: 36px;
    height: 36px;
}

.file-upload-icon.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 12px 32px rgba(16, 185, 129, 0.3);
}

.file-upload-text {
    position: relative;
    z-index: 1;
}

.file-upload-title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    margin: 0 0 0.375rem;
}

.file-upload-subtitle {
    font-size: 0.8125rem;
    color: #6b7280;
    margin: 0 0 0.75rem;
}

.file-upload-formats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.375rem;
}

.file-format-badge {
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
    background: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.file-selected-info {
    display: none;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    margin-top: 1rem;
    border: 1px solid #d1fae5;
}

.file-upload-zone.has-file .file-selected-info {
    display: flex;
}

.file-selected-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.file-selected-icon.pdf { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }
.file-selected-icon.doc { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
.file-selected-icon.xls { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white; }
.file-selected-icon.img { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; }
.file-selected-icon.default { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; }

.file-selected-icon svg {
    width: 20px;
    height: 20px;
}

.file-selected-name {
    flex: 1;
    font-weight: 600;
    color: #1e293b;
    font-size: 0.875rem;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-selected-size {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

.file-remove-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: #fef2f2;
    color: #ef4444;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.file-remove-btn:hover {
    background: #fee2e2;
}

.file-remove-btn svg {
    width: 16px;
    height: 16px;
}

/* Form Row */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}

/* Checkbox Premium */
.form-check-group {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.25rem;
    background: #f8fafc;
    border-radius: 12px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.3s ease;
    flex: 1;
    min-width: 180px;
}

.form-check:hover {
    background: #f1f5f9;
    border-color: #e2e8f0;
}

.form-check.checked {
    background: #ede9fe;
    border-color: #8b5cf6;
}

.form-check input[type="checkbox"] {
    display: none;
}

.form-check-box {
    width: 22px;
    height: 22px;
    border-radius: 6px;
    border: 2px solid #d1d5db;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
}

.form-check.checked .form-check-box {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-color: transparent;
}

.form-check-box svg {
    width: 14px;
    height: 14px;
    color: white;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.2s;
}

.form-check.checked .form-check-box svg {
    opacity: 1;
    transform: scale(1);
}

.form-check-content {
    flex: 1;
}

.form-check-label {
    font-weight: 600;
    font-size: 0.875rem;
    color: #374151;
    display: block;
}

.form-check-desc {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.125rem;
}

.form-check-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.form-check-icon.confidential {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: #ef4444;
}

.form-check-icon.visible {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #10b981;
}

.form-check-icon svg {
    width: 18px;
    height: 18px;
}

/* Modal Footer Premium */
.upload-modal-footer {
    padding: 1.25rem 2rem;
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-modal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    border-radius: 14px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
}

.btn-modal svg {
    width: 18px;
    height: 18px;
}

.btn-modal-cancel {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
}

.btn-modal-cancel:hover {
    border-color: #cbd5e1;
    color: #475569;
    background: #f8fafc;
}

.btn-modal-submit {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
}

.btn-modal-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 28px rgba(99, 102, 241, 0.4);
}

.btn-modal-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Section Divider */
.form-section {
    margin-top: 1.75rem;
    padding-top: 1.75rem;
    border-top: 1px solid #e2e8f0;
}

.form-section-title {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    font-size: 0.8125rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 1.25rem;
}

.form-section-title svg {
    width: 16px;
    height: 16px;
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.breadcrumb a {
    color: #64748b;
    text-decoration: none;
}

.breadcrumb a:hover {
    color: var(--da-primary);
}

.breadcrumb span {
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 768px) {
    .agent-header {
        flex-direction: column;
    }

    .agent-profile {
        flex-direction: column;
        text-align: center;
    }

    .agent-meta {
        justify-content: center;
    }

    .agent-stats-row {
        justify-content: center;
    }

    .agent-actions {
        justify-content: center;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .documents-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="dossier-show-page">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('admin.dossiers-agents.index') }}">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
            </svg>
            Dossiers Agents
        </a>
        <span>/</span>
        <span>{{ $personnel->nom }} {{ $personnel->prenoms }}</span>
    </div>

    <!-- Header Agent -->
    <div class="agent-header">
        <div class="agent-profile">
            <div class="agent-avatar">
                @if($personnel->photo)
                    <img src="{{ asset('storage/' . $personnel->photo) }}" alt="{{ $personnel->nom }}">
                @else
                    {{ strtoupper(substr($personnel->nom, 0, 1) . substr($personnel->prenoms, 0, 1)) }}
                @endif
            </div>
            <div class="agent-details">
                <h1>{{ $personnel->nom }} {{ $personnel->prenoms }}</h1>
                <div class="agent-meta">
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

        <div class="agent-stats-row">
            <div class="agent-stat-box">
                <div class="agent-stat-value">{{ $stats['total'] }}</div>
                <div class="agent-stat-label">Documents</div>
            </div>
            <div class="agent-stat-box">
                <div class="agent-stat-value success">{{ $stats['actifs'] }}</div>
                <div class="agent-stat-label">Actifs</div>
            </div>
            @if($stats['expires'] > 0)
            <div class="agent-stat-box">
                <div class="agent-stat-value danger">{{ $stats['expires'] }}</div>
                <div class="agent-stat-label">Expirés</div>
            </div>
            @endif
            @if($stats['expirent_bientot'] > 0)
            <div class="agent-stat-box">
                <div class="agent-stat-value warning">{{ $stats['expirent_bientot'] }}</div>
                <div class="agent-stat-label">Expirent bientôt</div>
            </div>
            @endif
        </div>

        <div class="agent-actions">
            <button onclick="openUploadModal()" class="btn-action btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Ajouter un document
            </button>
            <a href="{{ route('admin.personnels.show', $personnel) }}" class="btn-action btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Fiche employé
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <!-- Documents par catégorie -->
    @foreach($categories as $categorie)
    <div class="documents-section" id="category-{{ $categorie->id }}">
        <div class="documents-section-header">
            <div class="documents-section-title">
                <div class="icon" style="background: {{ $categorie->couleur }};">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                {{ $categorie->nom }}
                <span style="color: #94a3b8; font-weight: 400;">({{ $categorie->documents_count ?? count($documentsByCategory[$categorie->id] ?? []) }})</span>
            </div>
        </div>

        @if(isset($documentsByCategory[$categorie->id]) && count($documentsByCategory[$categorie->id]) > 0)
        <div class="documents-grid">
            @foreach($documentsByCategory[$categorie->id] as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
        @else
        <div class="empty-category">
            <div class="empty-category-icon">
                <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p style="color: #64748b; margin: 0;">Aucun document dans cette catégorie</p>
        </div>
        @endif
    </div>
    @endforeach

    <!-- Documents sans catégorie -->
    @if(count($documentsSansCategorie) > 0)
    <div class="documents-section">
        <div class="documents-section-header">
            <div class="documents-section-title">
                <div class="icon" style="background: #94a3b8;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                Non classés
                <span style="color: #94a3b8; font-weight: 400;">({{ count($documentsSansCategorie) }})</span>
            </div>
        </div>
        <div class="documents-grid">
            @foreach($documentsSansCategorie as $document)
            @include('dossier-agent.partials.document-card', ['document' => $document])
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Modal Upload Premium -->
<div class="upload-modal" id="uploadModal">
    <div class="upload-modal-content">
        <div class="upload-modal-header">
            <div class="upload-modal-header-content">
                <div class="upload-modal-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div class="upload-modal-title-group">
                    <h3>Ajouter un document</h3>
                    <p class="upload-modal-subtitle">Ajoutez un nouveau document au dossier de {{ $personnel->prenoms }}</p>
                </div>
            </div>
            <button class="upload-modal-close" onclick="closeUploadModal()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.dossier-agent.store', $personnel) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="upload-modal-body">
                <!-- Zone d'upload -->
                <div class="form-group">
                    <label class="form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Fichier <span class="required">*</span>
                    </label>
                    <div class="file-upload-zone" id="dropZone">
                        <input type="file" name="document" id="fileInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.webp" required style="display: none;">
                        <div class="file-upload-icon" id="uploadIcon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </div>
                        <div class="file-upload-text">
                            <p class="file-upload-title" id="fileLabel">Cliquez ou glissez votre fichier ici</p>
                            <p class="file-upload-subtitle">Selectionnez un document depuis votre ordinateur</p>
                            <div class="file-upload-formats">
                                <span class="file-format-badge">PDF</span>
                                <span class="file-format-badge">DOC</span>
                                <span class="file-format-badge">XLS</span>
                                <span class="file-format-badge">JPG</span>
                                <span class="file-format-badge">PNG</span>
                            </div>
                        </div>
                        <div class="file-selected-info" id="fileSelectedInfo">
                            <div class="file-selected-icon" id="fileTypeIcon">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="file-selected-name" id="fileName">document.pdf</div>
                                <div class="file-selected-size" id="fileSize">2.4 Mo</div>
                            </div>
                            <button type="button" class="file-remove-btn" id="removeFileBtn" onclick="removeFile(event)">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Categorie -->
                <div class="form-group">
                    <label class="form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>
                        </svg>
                        Categorie
                    </label>
                    <select name="categorie_id" class="form-control">
                        <option value="">Selectionner une categorie...</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Titre -->
                <div class="form-group">
                    <label class="form-label">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Titre du document
                    </label>
                    <input type="text" name="titre" class="form-control" placeholder="Ex: Contrat de travail, CNI recto-verso...">
                </div>

                <!-- Section Dates -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Informations de date
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date du document</label>
                            <input type="date" name="date_document" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date d'expiration</label>
                            <input type="date" name="date_expiration" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Section Details -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Details supplementaires
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reference</label>
                        <input type="text" name="reference" class="form-control" placeholder="Ex: N° de contrat, N° CNI, N° permis...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Ajoutez des notes ou commentaires sur ce document..."></textarea>
                    </div>
                </div>

                <!-- Options -->
                <div class="form-section">
                    <div class="form-section-title">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                        </svg>
                        Options de visibilite
                    </div>

                    <div class="form-check-group">
                        <label class="form-check" id="confidentielCheck">
                            <input type="checkbox" name="confidentiel" id="confidentiel" value="1">
                            <div class="form-check-icon confidential">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </div>
                            <div class="form-check-content">
                                <span class="form-check-label">Document confidentiel</span>
                                <span class="form-check-desc">Acces restreint aux admins</span>
                            </div>
                            <div class="form-check-box">
                                <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </label>

                        <label class="form-check checked" id="visibleCheck">
                            <input type="checkbox" name="visible_employe" id="visible_employe" value="1" checked>
                            <div class="form-check-icon visible">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                            <div class="form-check-content">
                                <span class="form-check-label">Visible par l'employe</span>
                                <span class="form-check-desc">L'employe peut voir ce document</span>
                            </div>
                            <div class="form-check-box">
                                <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="upload-modal-footer">
                <button type="button" class="btn-modal btn-modal-cancel" onclick="closeUploadModal()">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="btn-modal btn-modal-submit" id="submitBtn">
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
    const checkboxes = document.querySelectorAll('.form-check input[type="checkbox"]');
    checkboxes.forEach(cb => {
        cb.checked = false;
        cb.closest('.form-check').classList.remove('checked');
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
        return `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <path d="M10 12h4M10 16h4M8 12h.01M8 16h.01"/>
        </svg>`;
    }

    // Images
    if (mimeType.startsWith('image/') || ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(ext)) {
        return `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21,15 16,10 5,21"/>
        </svg>`;
    }

    // Documents Word
    if (['doc', 'docx'].includes(ext) || mimeType.includes('word')) {
        return `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10,9 9,9 8,9"/>
        </svg>`;
    }

    // Excel
    if (['xls', 'xlsx', 'csv'].includes(ext) || mimeType.includes('spreadsheet') || mimeType.includes('excel')) {
        return `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14,2 14,8 20,8"/>
            <rect x="8" y="12" width="8" height="6"/>
            <line x1="12" y1="12" x2="12" y2="18"/>
            <line x1="8" y1="15" x2="16" y2="15"/>
        </svg>`;
    }

    // Fichier générique
    return `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2">
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

// Gestion des checkboxes premium
document.querySelectorAll('.form-check input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        if (this.checked) {
            this.closest('.form-check').classList.add('checked');
        } else {
            this.closest('.form-check').classList.remove('checked');
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
        this.querySelector('.upload-modal').focus();
    }
});
</script>
@endsection
