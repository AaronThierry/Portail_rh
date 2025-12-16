@extends('layouts.app')

@section('title', 'Gestion des Entreprises')

@section('styles')
<style>
/* ==================== ENTREPRISES PAGE - RH+ DESIGN ==================== */

:root {
    --rh-primary: #4A90D9;
    --rh-primary-dark: #2E6BB3;
    --rh-primary-light: #E8F4FD;
    --rh-orange: #FF9500;
    --rh-orange-dark: #FF6B00;
    --rh-orange-light: #FFF3E0;
    --rh-success: #27AE60;
    --rh-danger: #E74C3C;
    --rh-gray: #7F8C8D;
    --rh-text: #2C3E50;
    --rh-text-muted: #8B9CAD;
    --rh-border: #E8ECF0;
    --rh-bg: #F8FAFB;
    --rh-card: #ffffff;
    --rh-shadow: rgba(74, 144, 217, 0.1);
}

.dark {
    --rh-bg: #111622;
    --rh-card: #1A1F2E;
    --rh-text: #E8ECF0;
    --rh-text-muted: #8B9CAD;
    --rh-border: #2D3548;
    --rh-shadow: rgba(0, 0, 0, 0.3);
}

/* Page Container */
.entreprises-page {
    padding: 1.5rem;
    max-width: 1600px;
    margin: 0 auto;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ==================== HEADER SECTION ==================== */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--rh-primary) 0%, var(--rh-primary-dark) 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 24px rgba(74, 144, 217, 0.3);
}

.page-icon svg {
    width: 28px;
    height: 28px;
}

.page-title-group h1 {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--rh-text);
    margin: 0;
    letter-spacing: -0.5px;
}

.page-title-group p {
    font-size: 0.875rem;
    color: var(--rh-text-muted);
    margin: 0.25rem 0 0 0;
}

.page-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-primary-rh {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--rh-primary) 0%, var(--rh-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(74, 144, 217, 0.3);
}

.btn-primary-rh:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(74, 144, 217, 0.4);
}

.btn-secondary-rh {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: var(--rh-card);
    color: var(--rh-text);
    border: 2px solid var(--rh-border);
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary-rh:hover {
    border-color: var(--rh-primary);
    color: var(--rh-primary);
}

/* ==================== STATS CARDS ==================== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 1200px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
}

.stat-card {
    background: var(--rh-card);
    border: 1px solid var(--rh-border);
    border-radius: 14px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px var(--rh-shadow);
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon svg {
    width: 24px;
    height: 24px;
}

.stat-icon.primary {
    background: var(--rh-primary-light);
    color: var(--rh-primary);
}

.stat-icon.success {
    background: rgba(39, 174, 96, 0.1);
    color: var(--rh-success);
}

.stat-icon.danger {
    background: rgba(231, 76, 60, 0.1);
    color: var(--rh-danger);
}

.stat-icon.orange {
    background: var(--rh-orange-light);
    color: var(--rh-orange);
}

.stat-content h3 {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--rh-text);
    margin: 0;
    line-height: 1;
}

.stat-content p {
    font-size: 0.8125rem;
    color: var(--rh-text-muted);
    margin: 0.375rem 0 0 0;
    font-weight: 500;
}

/* ==================== TOOLBAR ==================== */
.toolbar {
    background: var(--rh-card);
    border: 1px solid var(--rh-border);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.search-box {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-box svg {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--rh-text-muted);
    width: 18px;
    height: 18px;
}

.search-input {
    width: 100%;
    padding: 0.625rem 1rem 0.625rem 2.75rem;
    border: 2px solid var(--rh-border);
    border-radius: 10px;
    background: var(--rh-bg);
    color: var(--rh-text);
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--rh-primary);
    box-shadow: 0 0 0 4px rgba(74, 144, 217, 0.1);
}

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 2px solid var(--rh-border);
    border-radius: 8px;
    background: transparent;
    color: var(--rh-text-muted);
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.filter-btn:hover {
    border-color: var(--rh-primary);
    color: var(--rh-primary);
}

.filter-btn.active {
    background: linear-gradient(135deg, var(--rh-primary) 0%, var(--rh-primary-dark) 100%);
    border-color: transparent;
    color: white;
}

.filter-btn .count {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.125rem 0.5rem;
    border-radius: 10px;
    font-size: 0.75rem;
}

.filter-btn:not(.active) .count {
    background: var(--rh-border);
}

.view-toggle {
    display: flex;
    background: var(--rh-bg);
    border-radius: 8px;
    padding: 0.25rem;
}

.view-btn {
    padding: 0.5rem 0.75rem;
    border: none;
    background: transparent;
    color: var(--rh-text-muted);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.25s ease;
}

.view-btn:hover {
    color: var(--rh-primary);
}

.view-btn.active {
    background: var(--rh-card);
    color: var(--rh-primary);
    box-shadow: 0 2px 8px var(--rh-shadow);
}

/* ==================== COMPANIES GRID ==================== */
.companies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1.25rem;
}

.company-card {
    background: var(--rh-card);
    border: 1px solid var(--rh-border);
    border-radius: 14px;
    padding: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.company-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--rh-primary) 0%, var(--rh-orange) 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.company-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px var(--rh-shadow);
    border-color: var(--rh-primary-light);
}

.company-card:hover::before {
    transform: scaleX(1);
}

.company-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.company-logo {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid var(--rh-border);
}

.company-logo-placeholder {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--rh-primary) 0%, var(--rh-primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 1rem;
}

.company-info {
    flex: 1;
    min-width: 0;
}

.company-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--rh-text);
    margin: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.company-sigle {
    font-size: 0.75rem;
    color: var(--rh-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.company-status {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-active {
    background: rgba(39, 174, 96, 0.1);
    color: var(--rh-success);
}

.badge-active::before {
    content: '';
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.badge-inactive {
    background: rgba(231, 76, 60, 0.1);
    color: var(--rh-danger);
}

.company-details {
    display: flex;
    flex-direction: column;
    gap: 0.625rem;
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.detail-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: var(--rh-primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rh-primary);
    flex-shrink: 0;
}

.detail-icon svg {
    width: 16px;
    height: 16px;
}

.detail-content {
    flex: 1;
    min-width: 0;
}

.detail-label {
    font-size: 0.6875rem;
    color: var(--rh-text-muted);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.detail-value {
    font-size: 0.8125rem;
    color: var(--rh-text);
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.company-footer {
    display: flex;
    gap: 0.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--rh-border);
}

.btn-action {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.625rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
    text-decoration: none;
}

.btn-view {
    background: var(--rh-primary-light);
    color: var(--rh-primary);
}

.btn-view:hover {
    background: var(--rh-primary);
    color: white;
}

.btn-edit {
    background: rgba(39, 174, 96, 0.1);
    color: var(--rh-success);
}

.btn-edit:hover {
    background: var(--rh-success);
    color: white;
}

.btn-delete {
    background: rgba(231, 76, 60, 0.1);
    color: var(--rh-danger);
    flex: 0 0 auto;
    padding: 0.625rem 0.75rem;
}

.btn-delete:hover {
    background: var(--rh-danger);
    color: white;
}

/* ==================== TABLE VIEW ==================== */
.companies-table-container {
    background: var(--rh-card);
    border: 1px solid var(--rh-border);
    border-radius: 14px;
    overflow: hidden;
}

.companies-table {
    width: 100%;
    border-collapse: collapse;
}

.companies-table thead {
    background: linear-gradient(135deg, var(--rh-primary) 0%, var(--rh-primary-dark) 100%);
}

.companies-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.companies-table tbody tr {
    border-bottom: 1px solid var(--rh-border);
    transition: all 0.25s ease;
}

.companies-table tbody tr:last-child {
    border-bottom: none;
}

.companies-table tbody tr:hover {
    background: var(--rh-primary-light);
}

.companies-table td {
    padding: 1rem 1.25rem;
    color: var(--rh-text);
    font-size: 0.875rem;
}

.table-company-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-company-info {
    display: flex;
    flex-direction: column;
}

.table-company-name {
    font-weight: 700;
    color: var(--rh-text);
}

.table-company-sigle {
    font-size: 0.75rem;
    color: var(--rh-text-muted);
}

.table-actions {
    display: flex;
    gap: 0.5rem;
}

.table-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.25s ease;
    border: none;
}

.table-btn svg {
    width: 16px;
    height: 16px;
}

/* ==================== EMPTY STATE ==================== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    grid-column: 1 / -1;
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 1.5rem;
    background: var(--rh-primary-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rh-primary);
}

.empty-icon svg {
    width: 48px;
    height: 48px;
    opacity: 0.6;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--rh-text);
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    color: var(--rh-text-muted);
    margin: 0 0 1.5rem 0;
}

/* ==================== NOTIFICATIONS ==================== */
.notification {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    animation: slideIn 0.4s ease;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.notification-success {
    background: rgba(39, 174, 96, 0.1);
    border: 1px solid rgba(39, 174, 96, 0.2);
    color: var(--rh-success);
}

.notification-error {
    background: rgba(231, 76, 60, 0.1);
    border: 1px solid rgba(231, 76, 60, 0.2);
    color: var(--rh-danger);
}

.notification svg {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

/* ==================== MODAL - Portail RH ==================== */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(10, 15, 28, 0.8);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.modal-overlay.show {
    display: flex;
    opacity: 1;
}

.modal {
    background: var(--rh-card);
    border-radius: 12px;
    width: 100%;
    max-width: 780px;
    max-height: 88vh;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    animation: modalSlideIn 0.35s ease-out;
    position: relative;
    display: flex;
    flex-direction: column;
    border-top: 4px solid var(--rh-primary);
}

@keyframes modalSlideIn {
    0% {
        opacity: 0;
        transform: scale(0.95) translateY(20px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

/* Modal Header - Orange */
.modal-header {
    position: relative;
    background: linear-gradient(135deg, var(--rh-orange) 0%, var(--rh-orange-dark) 100%);
    color: white;
    flex-shrink: 0;
}

.modal-header-bg {
    display: none;
}

.modal-header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
}

.modal-header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-icon {
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-icon svg {
    width: 22px;
    height: 22px;
}

.modal-header-text h2 {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
}

.modal-header-text p {
    font-size: 0.75rem;
    opacity: 0.9;
    margin: 0.125rem 0 0 0;
}

.modal-close {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.15);
    border: none;
    border-radius: 8px;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.95);
    color: var(--rh-danger);
}

.modal-close svg {
    width: 18px;
    height: 18px;
}

/* Modal Body */
.modal-body {
    padding: 1.25rem;
    max-height: calc(88vh - 140px);
    overflow-y: auto;
    background: var(--rh-card);
    flex: 1;
}

/* Custom Scrollbar */
.modal-body::-webkit-scrollbar {
    width: 5px;
}

.modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.modal-body::-webkit-scrollbar-thumb {
    background: var(--rh-border);
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: var(--rh-primary);
}

/* Form Section */
.form-section {
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px dashed var(--rh-border);
    position: relative;
}

.form-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.form-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.form-section-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--rh-primary-light) 0%, rgba(74, 144, 217, 0.1) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--rh-primary);
    transition: all 0.3s ease;
}

.form-section-icon svg {
    width: 18px;
    height: 18px;
}

.form-section-icon.success {
    background: linear-gradient(135deg, rgba(39, 174, 96, 0.12) 0%, rgba(39, 174, 96, 0.05) 100%);
    color: var(--rh-success);
}

.form-section-title {
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--rh-text);
    margin: 0;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 640px) {
    .form-grid { grid-template-columns: 1fr; }
}

/* Form Group */
.form-group {
    margin-bottom: 0;
    position: relative;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* Form Label */
.form-label {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--rh-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
}

.form-label.required::after {
    content: '*';
    color: var(--rh-orange);
    font-size: 0.875rem;
    font-weight: 800;
}

/* Form Input */
.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1.5px solid var(--rh-border);
    border-radius: 10px;
    background: var(--rh-bg);
    color: var(--rh-text);
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.25s ease;
}

.form-input:hover {
    border-color: rgba(74, 144, 217, 0.4);
}

.form-input:focus {
    outline: none;
    border-color: var(--rh-orange);
    box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.12);
}

.form-input::placeholder {
    color: var(--rh-text-muted);
    font-weight: 400;
}

textarea.form-input {
    resize: vertical;
    min-height: 80px;
    line-height: 1.5;
}

/* Form Input Error State */
.form-input.error {
    border-color: var(--rh-danger);
    box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.12);
}

.error-message {
    font-size: 0.75rem;
    color: var(--rh-danger);
    margin-top: 0.375rem;
    font-weight: 500;
}

/* Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: wait;
}

/* Status Cards Selection */
.status-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.status-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--rh-bg);
    border: 2px solid var(--rh-border);
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    overflow: hidden;
}

.status-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: transparent;
    transition: all 0.3s ease;
}

.status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

/* Active Card Styling */
.status-card.active {
    border-color: rgba(39, 174, 96, 0.3);
}

.status-card.active:hover {
    border-color: var(--rh-success);
    background: rgba(39, 174, 96, 0.03);
}

.status-card.active.selected {
    border-color: var(--rh-success);
    background: linear-gradient(135deg, rgba(39, 174, 96, 0.08) 0%, rgba(39, 174, 96, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(39, 174, 96, 0.2);
}

.status-card.active.selected::before {
    background: linear-gradient(90deg, var(--rh-success) 0%, #2ECC71 100%);
}

.status-card.active .status-card-icon {
    background: linear-gradient(135deg, rgba(39, 174, 96, 0.15) 0%, rgba(39, 174, 96, 0.05) 100%);
    color: var(--rh-success);
}

.status-card.active.selected .status-card-icon {
    background: linear-gradient(135deg, var(--rh-success) 0%, #1E8449 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
}

/* Inactive Card Styling */
.status-card.inactive {
    border-color: rgba(231, 76, 60, 0.3);
}

.status-card.inactive:hover {
    border-color: var(--rh-danger);
    background: rgba(231, 76, 60, 0.03);
}

.status-card.inactive.selected {
    border-color: var(--rh-danger);
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.08) 0%, rgba(231, 76, 60, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(231, 76, 60, 0.2);
}

.status-card.inactive.selected::before {
    background: linear-gradient(90deg, var(--rh-danger) 0%, #E74C3C 100%);
}

.status-card.inactive .status-card-icon {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.05) 100%);
    color: var(--rh-danger);
}

.status-card.inactive.selected .status-card-icon {
    background: linear-gradient(135deg, var(--rh-danger) 0%, #C0392B 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
}

/* Status Card Icon */
.status-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.status-card-icon svg {
    width: 24px;
    height: 24px;
}

/* Status Card Content */
.status-card-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.status-card-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--rh-text);
    transition: color 0.3s ease;
}

.status-card.selected .status-card-title {
    color: var(--rh-text);
}

.status-card-desc {
    font-size: 0.75rem;
    color: var(--rh-text-muted);
    font-weight: 500;
}

/* Status Card Check */
.status-card-check {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: var(--rh-border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    opacity: 0;
    transform: scale(0.5);
    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.status-card-check svg {
    width: 14px;
    height: 14px;
    color: white;
}

.status-card.selected .status-card-check {
    opacity: 1;
    transform: scale(1);
}

.status-card.active.selected .status-card-check {
    background: linear-gradient(135deg, var(--rh-success) 0%, #1E8449 100%);
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.4);
}

.status-card.inactive.selected .status-card-check {
    background: linear-gradient(135deg, var(--rh-danger) 0%, #C0392B 100%);
    box-shadow: 0 2px 8px rgba(231, 76, 60, 0.4);
}

/* Responsive */
@media (max-width: 500px) {
    .status-cards {
        grid-template-columns: 1fr;
    }
}

/* Modal Footer */
.modal-footer {
    padding: 1rem 1.75rem;
    background: var(--rh-bg);
    border-top: 1px solid var(--rh-border);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    flex-shrink: 0;
}

.btn-cancel {
    padding: 0.625rem 1.25rem;
    background: transparent;
    color: var(--rh-text-muted);
    border: 1.5px solid var(--rh-border);
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-cancel svg {
    width: 16px;
    height: 16px;
    transition: transform 0.25s ease;
}

.btn-cancel:hover {
    background: rgba(231, 76, 60, 0.08);
    border-color: var(--rh-danger);
    color: var(--rh-danger);
}

.btn-cancel:hover svg {
    transform: rotate(90deg);
}

.btn-submit {
    padding: 0.625rem 1.5rem;
    background: linear-gradient(135deg, var(--rh-orange) 0%, var(--rh-orange-dark) 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-submit svg {
    width: 16px;
    height: 16px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 149, 0, 0.4);
}

.btn-submit:active {
    transform: translateY(-1px);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .page-actions {
        width: 100%;
    }

    .page-actions .btn-primary-rh {
        flex: 1;
        justify-content: center;
    }

    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        min-width: auto;
    }

    .filter-group {
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .companies-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="entreprises-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="page-title-group">
                <h1>Entreprises</h1>
                <p>Gérez vos entreprises partenaires</p>
            </div>
        </div>
        <div class="page-actions">
            <button type="button" class="btn-secondary-rh" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Exporter
            </button>
            <button type="button" class="btn-primary-rh" onclick="openCreateModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nouvelle Entreprise
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $entreprises->count() }}</h3>
                <p>Total Entreprises</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $entreprises->where('is_active', true)->count() }}</h3>
                <p>Actives</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon danger">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ $entreprises->where('is_active', false)->count() }}</h3>
                <p>Inactives</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($entreprises->sum('nombre_employes') ?? 0) }}</h3>
                <p>Total Employés</p>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="notification notification-success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="notification notification-error">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="search" class="search-input" placeholder="Rechercher une entreprise..." id="searchInput">
        </div>

        <div class="filter-group">
            <button class="filter-btn active" data-filter="all" onclick="filterCompanies('all')">
                Toutes
                <span class="count">{{ $entreprises->count() }}</span>
            </button>
            <button class="filter-btn" data-filter="active" onclick="filterCompanies('active')">
                Actives
                <span class="count">{{ $entreprises->where('is_active', true)->count() }}</span>
            </button>
            <button class="filter-btn" data-filter="inactive" onclick="filterCompanies('inactive')">
                Inactives
                <span class="count">{{ $entreprises->where('is_active', false)->count() }}</span>
            </button>
        </div>

        <div class="view-toggle">
            <button type="button" class="view-btn active" id="gridViewBtn" onclick="switchView('grid')">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>
            </button>
            <button type="button" class="view-btn" id="tableViewBtn" onclick="switchView('table')">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Companies Grid View -->
    <div class="companies-grid" id="companiesGrid">
        @forelse($entreprises as $entreprise)
        <div class="company-card" data-status="{{ $entreprise->is_active ? 'active' : 'inactive' }}" data-name="{{ strtolower($entreprise->nom) }}" data-email="{{ strtolower($entreprise->email) }}">
            <div class="company-status">
                @if($entreprise->is_active)
                <span class="badge badge-active">Active</span>
                @else
                <span class="badge badge-inactive">Inactive</span>
                @endif
            </div>

            <div class="company-header">
                @if($entreprise->logo)
                <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}" class="company-logo">
                @else
                <div class="company-logo-placeholder">
                    {{ strtoupper(substr($entreprise->nom, 0, 2)) }}
                </div>
                @endif
                <div class="company-info">
                    <h3 class="company-name">{{ $entreprise->nom }}</h3>
                    @if($entreprise->sigle)
                    <span class="company-sigle">{{ $entreprise->sigle }}</span>
                    @endif
                </div>
            </div>

            <div class="company-details">
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">{{ $entreprise->email }}</span>
                    </div>
                </div>

                @if($entreprise->telephone)
                <div class="detail-row">
                    <div class="detail-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Téléphone</span>
                        <span class="detail-value">{{ $entreprise->telephone }}</span>
                    </div>
                </div>
                @endif

                <div class="detail-row">
                    <div class="detail-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Localisation</span>
                        <span class="detail-value">{{ $entreprise->ville ?? $entreprise->pays ?? 'Non spécifié' }}</span>
                    </div>
                </div>
            </div>

            <div class="company-footer">
                <a href="{{ route('admin.entreprises.show', $entreprise->id) }}" class="btn-action btn-view">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                    Voir
                </a>
                <button type="button" onclick="openEditModal({{ $entreprise->id }})" class="btn-action btn-edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Modifier
                </button>
                <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3>Aucune entreprise</h3>
            <p>Commencez par créer votre première entreprise</p>
            <button type="button" class="btn-primary-rh" onclick="openCreateModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Créer une entreprise
            </button>
        </div>
        @endforelse
    </div>

    <!-- Table View (Hidden by default) -->
    <div class="companies-table-container" id="companiesTable" style="display: none;">
        <table class="companies-table">
            <thead>
                <tr>
                    <th>Entreprise</th>
                    <th>Contact</th>
                    <th>Localisation</th>
                    <th>Employés</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entreprises as $entreprise)
                <tr data-status="{{ $entreprise->is_active ? 'active' : 'inactive' }}" data-name="{{ strtolower($entreprise->nom) }}" data-email="{{ strtolower($entreprise->email) }}">
                    <td>
                        <div class="table-company-cell">
                            @if($entreprise->logo)
                            <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}" class="company-logo" style="width: 40px; height: 40px;">
                            @else
                            <div class="company-logo-placeholder" style="width: 40px; height: 40px; font-size: 0.875rem;">
                                {{ strtoupper(substr($entreprise->nom, 0, 2)) }}
                            </div>
                            @endif
                            <div class="table-company-info">
                                <span class="table-company-name">{{ $entreprise->nom }}</span>
                                @if($entreprise->sigle)
                                <span class="table-company-sigle">{{ $entreprise->sigle }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $entreprise->email }}</div>
                        @if($entreprise->telephone)
                        <small style="color: var(--rh-text-muted);">{{ $entreprise->telephone }}</small>
                        @endif
                    </td>
                    <td>{{ $entreprise->ville ?? $entreprise->pays ?? '-' }}</td>
                    <td><strong>{{ $entreprise->nombre_employes ?? '-' }}</strong></td>
                    <td>
                        @if($entreprise->is_active)
                        <span class="badge badge-active">Active</span>
                        @else
                        <span class="badge badge-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.entreprises.show', $entreprise->id) }}" class="table-btn btn-view" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </a>
                            <button type="button" onclick="openEditModal({{ $entreprise->id }})" class="table-btn btn-edit" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
                            <form action="{{ route('admin.entreprises.destroy', $entreprise->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer cette entreprise ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="table-btn btn-delete" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <h3>Aucune entreprise</h3>
                            <p>Commencez par créer votre première entreprise</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="modal-overlay" id="entrepriseModal">
    <div class="modal">
        <div class="modal-header">
            <!-- Decorative background element -->
            <div class="modal-header-bg"></div>
            <div class="modal-header-content">
                <div class="modal-header-left">
                    <div class="modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="modal-header-text">
                        <h2 id="modalTitle">Nouvelle Entreprise</h2>
                        <p id="modalSubtitle">Remplissez les informations de l'entreprise</p>
                    </div>
                </div>
                <button type="button" class="modal-close" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
        </div>

        <form id="entrepriseForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="modal-body">
                <!-- Informations générales -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                            </svg>
                        </div>
                        <h3 class="form-section-title">Informations générales</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required">Nom de l'entreprise</label>
                            <input type="text" name="nom" id="nom" class="form-input" placeholder="Nom de l'entreprise" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sigle</label>
                            <input type="text" name="sigle" id="sigle" class="form-input" placeholder="Ex: ABC">
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Email</label>
                            <input type="email" name="email" id="email" class="form-input" placeholder="contact@entreprise.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-input" placeholder="+225 XX XX XX XX">
                        </div>
                    </div>
                </div>

                <!-- Adresse -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <h3 class="form-section-title">Adresse</h3>
                    </div>
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" id="adresse" class="form-input" placeholder="Adresse complète">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ville</label>
                            <input type="text" name="ville" id="ville" class="form-input" placeholder="Ville">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pays</label>
                            <input type="text" name="pays" id="pays" class="form-input" placeholder="Pays">
                        </div>
                    </div>
                </div>

                <!-- Statut -->
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-icon success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        <h3 class="form-section-title">Statut de l'entreprise</h3>
                    </div>

                    <!-- Status Cards Selection -->
                    <div class="status-cards">
                        <input type="hidden" name="is_active" id="is_active" value="1">

                        <div class="status-card active selected" data-status="1" onclick="selectStatus(1)">
                            <div class="status-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <div class="status-card-content">
                                <span class="status-card-title">Active</span>
                                <span class="status-card-desc">Visible et opérationnelle</span>
                            </div>
                            <div class="status-card-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>

                        <div class="status-card inactive" data-status="0" onclick="selectStatus(0)">
                            <div class="status-card-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="15" y1="9" x2="9" y2="15"/>
                                    <line x1="9" y1="9" x2="15" y2="15"/>
                                </svg>
                            </div>
                            <div class="status-card-content">
                                <span class="status-card-title">Inactive</span>
                                <span class="status-card-desc">Suspendue temporairement</span>
                            </div>
                            <div class="status-card-check">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                    Annuler
                </button>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
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
// View Toggle
function switchView(view) {
    const gridView = document.getElementById('companiesGrid');
    const tableView = document.getElementById('companiesTable');
    const gridBtn = document.getElementById('gridViewBtn');
    const tableBtn = document.getElementById('tableViewBtn');

    if (view === 'grid') {
        gridView.style.display = 'grid';
        tableView.style.display = 'none';
        gridBtn.classList.add('active');
        tableBtn.classList.remove('active');
    } else {
        gridView.style.display = 'none';
        tableView.style.display = 'block';
        gridBtn.classList.remove('active');
        tableBtn.classList.add('active');
    }
}

// Filter Companies
function filterCompanies(filter) {
    const cards = document.querySelectorAll('.company-card');
    const rows = document.querySelectorAll('.companies-table tbody tr[data-status]');
    const filterBtns = document.querySelectorAll('.filter-btn');

    filterBtns.forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-filter="${filter}"]`).classList.add('active');

    [...cards, ...rows].forEach(item => {
        if (filter === 'all' || item.dataset.status === filter) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

// Search
document.getElementById('searchInput').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.company-card');
    const rows = document.querySelectorAll('.companies-table tbody tr[data-status]');

    [...cards, ...rows].forEach(item => {
        const name = item.dataset.name || '';
        const email = item.dataset.email || '';
        if (name.includes(search) || email.includes(search)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

// Status Selection
function selectStatus(status) {
    // Update hidden input
    document.getElementById('is_active').value = status;

    // Update card selection
    document.querySelectorAll('.status-card').forEach(card => {
        card.classList.remove('selected');
    });

    const selectedCard = document.querySelector(`.status-card[data-status="${status}"]`);
    if (selectedCard) {
        selectedCard.classList.add('selected');
    }
}

// Modal Functions
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouvelle Entreprise';
    document.getElementById('modalSubtitle').textContent = 'Remplissez les informations';
    document.getElementById('entrepriseForm').action = '{{ route("admin.entreprises.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('entrepriseForm').reset();

    // Reset status selection to active
    selectStatus(1);

    document.getElementById('entrepriseModal').classList.add('show');
}

function openEditModal(id) {
    document.getElementById('modalTitle').textContent = 'Modifier l\'entreprise';
    document.getElementById('modalSubtitle').textContent = 'Modifiez les informations';
    document.getElementById('entrepriseForm').action = `/admin/entreprises/${id}`;
    document.getElementById('formMethod').value = 'PUT';

    // Fetch company data with JSON header
    fetch(`/admin/entreprises/${id}/edit`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('nom').value = data.nom || '';
            document.getElementById('sigle').value = data.sigle || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('telephone').value = data.telephone || '';
            document.getElementById('adresse').value = data.adresse || '';
            document.getElementById('ville').value = data.ville || '';
            document.getElementById('pays').value = data.pays || '';

            // Update status selection
            selectStatus(data.is_active ? 1 : 0);
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des données');
        });

    document.getElementById('entrepriseModal').classList.add('show');
}

function closeModal() {
    document.getElementById('entrepriseModal').classList.remove('show');
    // Clear any validation errors
    clearValidationErrors();
}

function clearValidationErrors() {
    document.querySelectorAll('.form-input.error').forEach(input => {
        input.classList.remove('error');
    });
    document.querySelectorAll('.error-message').forEach(msg => {
        msg.remove();
    });
}

function showValidationErrors(errors) {
    clearValidationErrors();
    Object.keys(errors).forEach(field => {
        const input = document.getElementById(field);
        if (input) {
            input.classList.add('error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = errors[field][0];
            input.parentNode.appendChild(errorDiv);
        }
    });
}

// Form submission handling
document.getElementById('entrepriseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;

    // Show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="12"/></svg> Enregistrement...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw { status: response.status, data: data };
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success !== false) {
            // Success - reload page
            window.location.reload();
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;

        if (error.status === 422 && error.data.errors) {
            showValidationErrors(error.data.errors);
        } else {
            alert(error.data?.message || 'Une erreur est survenue');
        }
    });
});

// Close modal on outside click
document.getElementById('entrepriseModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
</script>
@endsection
