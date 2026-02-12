@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Utilisateurs')
@section('page-subtitle', 'Gérez les accès et permissions')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
    <circle cx="12" cy="7" r="4"></circle>
</svg>
@endsection

@section('content')
<style>
/* ========================================
   PAGE UTILISATEURS - DESIGN WORLD-CLASS
   ======================================== */

:root {
    --usr-primary: #4A90D9;
    --usr-primary-dark: #2E6BB3;
    --usr-orange: #FF9500;
    --usr-orange-dark: #E68600;
    --usr-success: #10b981;
    --usr-danger: #ef4444;
    --usr-warning: #f59e0b;
    --usr-info: #3b82f6;
    --usr-purple: #8b5cf6;
    --usr-pink: #ec4899;
    --usr-gray-50: #f9fafb;
    --usr-gray-100: #f3f4f6;
    --usr-gray-200: #e5e7eb;
    --usr-gray-300: #d1d5db;
    --usr-gray-400: #9ca3af;
    --usr-gray-500: #6b7280;
    --usr-gray-600: #4b5563;
    --usr-gray-700: #374151;
    --usr-gray-800: #1f2937;
    --usr-gray-900: #111827;
    --usr-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --usr-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --usr-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --usr-shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Animation Keyframes */
@keyframes usr-fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes usr-slideIn {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes usr-scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes usr-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes usr-shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes usr-countUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Page Container */
.usr-page {
    padding: 0;
    animation: usr-fadeIn 0.5s ease-out;
}

/* ========================================
   STATISTICS GRID
   ======================================== */
.usr-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}

.usr-stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--usr-gray-200);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: usr-fadeIn 0.5s ease-out backwards;
}

.usr-stat-card:nth-child(1) { animation-delay: 0.1s; }
.usr-stat-card:nth-child(2) { animation-delay: 0.2s; }
.usr-stat-card:nth-child(3) { animation-delay: 0.3s; }
.usr-stat-card:nth-child(4) { animation-delay: 0.4s; }

.usr-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--usr-shadow-xl);
}

.usr-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    border-radius: 16px 16px 0 0;
}

.usr-stat-card.total::before {
    background: linear-gradient(90deg, var(--usr-orange), var(--usr-orange-dark));
}

.usr-stat-card.active::before {
    background: linear-gradient(90deg, var(--usr-success), #059669);
}

.usr-stat-card.inactive::before {
    background: linear-gradient(90deg, var(--usr-danger), #dc2626);
}

.usr-stat-card.warning::before {
    background: linear-gradient(90deg, var(--usr-warning), #d97706);
}

.usr-stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.usr-stat-content {
    flex: 1;
}

.usr-stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 6px;
    background: linear-gradient(135deg, var(--usr-gray-800), var(--usr-gray-600));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.usr-stat-card.total .usr-stat-value {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    -webkit-background-clip: text;
    background-clip: text;
}

.usr-stat-card.active .usr-stat-value {
    background: linear-gradient(135deg, var(--usr-success), #059669);
    -webkit-background-clip: text;
    background-clip: text;
}

.usr-stat-card.inactive .usr-stat-value {
    background: linear-gradient(135deg, var(--usr-danger), #dc2626);
    -webkit-background-clip: text;
    background-clip: text;
}

.usr-stat-card.warning .usr-stat-value {
    background: linear-gradient(135deg, var(--usr-warning), #d97706);
    -webkit-background-clip: text;
    background-clip: text;
}

.usr-stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--usr-gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.usr-stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.usr-stat-card.total .usr-stat-icon {
    background: linear-gradient(135deg, rgba(255, 149, 0, 0.15), rgba(255, 149, 0, 0.05));
    color: var(--usr-orange);
}

.usr-stat-card.active .usr-stat-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
    color: var(--usr-success);
}

.usr-stat-card.inactive .usr-stat-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.05));
    color: var(--usr-danger);
}

.usr-stat-card.warning .usr-stat-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));
    color: var(--usr-warning);
}

.usr-stat-icon svg {
    width: 26px;
    height: 26px;
    stroke-width: 2;
}

/* ========================================
   TOOLBAR
   ======================================== */
.usr-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
    background: white;
    padding: 16px 20px;
    border-radius: 14px;
    border: 1px solid var(--usr-gray-200);
    animation: usr-fadeIn 0.5s ease-out 0.3s backwards;
}

.usr-toolbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
    flex: 1;
}

.usr-search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.usr-search-box input {
    width: 100%;
    padding: 10px 16px 10px 44px;
    border: 1px solid var(--usr-gray-200);
    border-radius: 10px;
    font-size: 0.9375rem;
    background: var(--usr-gray-50);
    transition: all 0.2s ease;
    color: var(--usr-gray-800);
}

.usr-search-box input:hover {
    border-color: var(--usr-gray-300);
}

.usr-search-box input:focus {
    outline: none;
    border-color: var(--usr-orange);
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1);
}

.usr-search-box input::placeholder {
    color: var(--usr-gray-400);
}

.usr-search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--usr-gray-400);
    pointer-events: none;
}

.usr-filter-group {
    display: flex;
    gap: 8px;
}

.usr-filter-btn {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 600;
    border: 1px solid var(--usr-gray-200);
    background: white;
    color: var(--usr-gray-600);
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.usr-filter-btn:hover {
    border-color: var(--usr-orange);
    color: var(--usr-orange);
    background: rgba(255, 149, 0, 0.05);
}

.usr-filter-btn.active {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    color: white;
    border-color: var(--usr-orange);
}

.usr-filter-btn .count {
    background: rgba(0, 0, 0, 0.1);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.75rem;
}

.usr-filter-btn.active .count {
    background: rgba(255, 255, 255, 0.25);
}

.usr-toolbar-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.usr-view-toggle {
    display: flex;
    background: var(--usr-gray-100);
    border-radius: 8px;
    padding: 4px;
}

.usr-view-btn {
    padding: 8px 12px;
    border: none;
    background: transparent;
    color: var(--usr-gray-500);
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.usr-view-btn:hover {
    color: var(--usr-gray-700);
}

.usr-view-btn.active {
    background: white;
    color: var(--usr-orange);
    box-shadow: var(--usr-shadow-sm);
}

.usr-view-btn svg {
    width: 18px;
    height: 18px;
}

.usr-btn-add {
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
}

.usr-btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 149, 0, 0.4);
}

.usr-btn-add svg {
    width: 18px;
    height: 18px;
}

/* ========================================
   USERS GRID VIEW
   ======================================== */
.usr-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 20px;
    animation: usr-fadeIn 0.5s ease-out 0.4s backwards;
}

.usr-card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--usr-gray-200);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.usr-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--usr-shadow-xl);
    border-color: var(--usr-orange);
}

.usr-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--usr-orange), var(--usr-orange-dark));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.usr-card:hover::before {
    opacity: 1;
}

.usr-card-header {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid var(--usr-gray-100);
}

.usr-avatar {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: var(--usr-shadow);
}

.usr-card-info {
    flex: 1;
    min-width: 0;
}

.usr-card-name {
    font-size: 1.0625rem;
    font-weight: 700;
    color: var(--usr-gray-800);
    margin: 0 0 4px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.usr-card-email {
    font-size: 0.8125rem;
    color: var(--usr-gray-500);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.usr-card-badges {
    display: flex;
    flex-direction: column;
    gap: 6px;
    align-items: flex-end;
}

.usr-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.6875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.usr-badge-role {
    background: linear-gradient(135deg, var(--usr-purple), #7c3aed);
    color: white;
}

.usr-badge-role.super-admin {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
}

.usr-badge-role.admin {
    background: linear-gradient(135deg, var(--usr-primary), var(--usr-primary-dark));
}

.usr-badge-role.manager {
    background: linear-gradient(135deg, var(--usr-info), #2563eb);
}

.usr-badge-role.rh {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
}

.usr-badge-role.employe {
    background: linear-gradient(135deg, var(--usr-success), #059669);
}

.usr-badge-status {
    font-size: 0.625rem;
}

.usr-badge-status.active {
    background: rgba(16, 185, 129, 0.12);
    color: var(--usr-success);
}

.usr-badge-status.inactive {
    background: rgba(239, 68, 68, 0.12);
    color: var(--usr-danger);
}

.usr-card-body {
    padding: 16px 20px;
}

.usr-card-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--usr-gray-100);
}

.usr-card-row:last-child {
    border-bottom: none;
}

.usr-card-row-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: var(--usr-gray-100);
    color: var(--usr-gray-500);
}

.usr-card-row-icon svg {
    width: 16px;
    height: 16px;
}

.usr-card-row-content {
    flex: 1;
    min-width: 0;
}

.usr-card-row-label {
    font-size: 0.6875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--usr-gray-400);
    font-weight: 600;
    margin-bottom: 2px;
}

.usr-card-row-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--usr-gray-700);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.usr-card-row-value a {
    color: var(--usr-primary);
    text-decoration: none;
    transition: color 0.2s ease;
}

.usr-card-row-value a:hover {
    color: var(--usr-orange);
}

.usr-2fa-badge {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 0.6875rem;
    font-weight: 700;
}

.usr-2fa-badge.enabled {
    background: rgba(16, 185, 129, 0.12);
    color: var(--usr-success);
}

.usr-2fa-badge.disabled {
    background: rgba(239, 68, 68, 0.12);
    color: var(--usr-danger);
}

.usr-card-footer {
    padding: 14px 20px;
    background: var(--usr-gray-50);
    border-top: 1px solid var(--usr-gray-100);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.usr-card-date {
    font-size: 0.75rem;
    color: var(--usr-gray-500);
    display: flex;
    align-items: center;
    gap: 6px;
}

.usr-card-date svg {
    width: 14px;
    height: 14px;
}

.usr-card-actions {
    display: flex;
    gap: 8px;
}

.usr-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.usr-action-btn svg {
    width: 16px;
    height: 16px;
}

.usr-action-btn.view {
    background: rgba(59, 130, 246, 0.1);
    color: var(--usr-info);
}

.usr-action-btn.view:hover {
    background: var(--usr-info);
    color: white;
}

.usr-action-btn.edit {
    background: rgba(255, 149, 0, 0.1);
    color: var(--usr-orange);
}

.usr-action-btn.edit:hover {
    background: var(--usr-orange);
    color: white;
}

.usr-action-btn.delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--usr-danger);
}

.usr-action-btn.delete:hover {
    background: var(--usr-danger);
    color: white;
}

/* ========================================
   USERS TABLE VIEW
   ======================================== */
.usr-table-container {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--usr-gray-200);
    overflow: hidden;
    animation: usr-fadeIn 0.5s ease-out 0.4s backwards;
    display: none;
}

.usr-table-container.active {
    display: block;
}

.usr-grid.active {
    display: grid;
}

.usr-grid:not(.active) {
    display: none;
}

.usr-table {
    width: 100%;
    border-collapse: collapse;
}

.usr-table th {
    padding: 14px 20px;
    text-align: left;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--usr-gray-500);
    background: var(--usr-gray-50);
    border-bottom: 1px solid var(--usr-gray-200);
}

.usr-table td {
    padding: 16px 20px;
    border-bottom: 1px solid var(--usr-gray-100);
    font-size: 0.875rem;
    color: var(--usr-gray-700);
}

.usr-table tbody tr {
    transition: background 0.2s ease;
}

.usr-table tbody tr:hover {
    background: rgba(255, 149, 0, 0.03);
}

.usr-table tbody tr:last-child td {
    border-bottom: none;
}

.usr-table-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.usr-table-avatar {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    object-fit: cover;
}

.usr-table-info {
    min-width: 0;
}

.usr-table-name {
    font-weight: 600;
    color: var(--usr-gray-800);
    margin-bottom: 2px;
}

.usr-table-email {
    font-size: 0.8125rem;
    color: var(--usr-gray-500);
}

.usr-table-actions {
    display: flex;
    gap: 8px;
}

/* ========================================
   EMPTY STATE
   ======================================== */
.usr-empty {
    text-align: center;
    padding: 60px 40px;
    background: white;
    border-radius: 16px;
    border: 1px solid var(--usr-gray-200);
}

.usr-empty-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, rgba(255, 149, 0, 0.1), rgba(255, 149, 0, 0.05));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--usr-orange);
}

.usr-empty-icon svg {
    width: 40px;
    height: 40px;
}

.usr-empty-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--usr-gray-800);
    margin: 0 0 8px 0;
}

.usr-empty-text {
    font-size: 0.9375rem;
    color: var(--usr-gray-500);
    margin: 0;
}

/* ========================================
   MODAL PREMIUM
   ======================================== */
.usr-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.usr-modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.usr-modal {
    background: white;
    border-radius: 20px;
    width: 100%;
    max-width: 620px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    transform: translateY(20px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.usr-modal-overlay.active .usr-modal {
    transform: translateY(0) scale(1);
}

.usr-modal-header {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    padding: 24px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.usr-modal-header-content {
    display: flex;
    align-items: center;
    gap: 16px;
}

.usr-modal-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.usr-modal-icon svg {
    width: 26px;
    height: 26px;
    stroke: white;
}

.usr-modal-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    margin: 0 0 4px 0;
}

.usr-modal-subtitle {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.usr-modal-close {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: none;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.usr-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

.usr-modal-close svg {
    width: 20px;
    height: 20px;
}

/* Wizard Steps */
.usr-wizard-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 28px;
    background: var(--usr-gray-50);
    border-bottom: 1px solid var(--usr-gray-200);
}

.usr-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
}

.usr-step-number {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--usr-gray-200);
    color: var(--usr-gray-500);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.usr-step.active .usr-step-number {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
}

.usr-step.completed .usr-step-number {
    background: var(--usr-success);
    color: white;
}

.usr-step.completed .usr-step-number::after {
    content: '✓';
}

.usr-step-label {
    font-size: 0.6875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--usr-gray-400);
}

.usr-step.active .usr-step-label {
    color: var(--usr-orange);
}

.usr-step.completed .usr-step-label {
    color: var(--usr-success);
}

.usr-step-divider {
    width: 60px;
    height: 2px;
    background: var(--usr-gray-200);
    margin: 0 16px 22px;
    transition: background 0.3s ease;
}

.usr-step.completed + .usr-step-divider {
    background: var(--usr-success);
}

/* Modal Body */
.usr-modal-body {
    flex: 1;
    overflow-y: auto;
    padding: 28px;
    background: white;
}

.usr-wizard-panel {
    display: none;
}

.usr-wizard-panel.active {
    display: block;
    animation: usr-slideIn 0.3s ease;
}

.usr-panel-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--usr-gray-800);
    margin: 0 0 6px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.usr-panel-title svg {
    width: 22px;
    height: 22px;
    color: var(--usr-orange);
}

.usr-panel-desc {
    font-size: 0.875rem;
    color: var(--usr-gray-500);
    margin: 0 0 24px 0;
}

.usr-form-field {
    margin-bottom: 20px;
}

.usr-form-label {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--usr-gray-700);
}

.usr-form-label .required {
    color: var(--usr-danger);
}

.usr-form-input,
.usr-form-select {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--usr-gray-300);
    border-radius: 10px;
    font-size: 0.9375rem;
    color: var(--usr-gray-800);
    background: white;
    transition: all 0.2s ease;
}

.usr-form-input:hover,
.usr-form-select:hover {
    border-color: var(--usr-gray-400);
}

.usr-form-input:focus,
.usr-form-select:focus {
    outline: none;
    border-color: var(--usr-orange);
    box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1);
}

.usr-select-wrapper {
    position: relative;
}

.usr-select-wrapper select {
    appearance: none;
    padding-right: 44px;
    cursor: pointer;
}

.usr-select-wrapper::after {
    content: '';
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 6px solid var(--usr-gray-400);
    pointer-events: none;
}

/* Searchable Select */
.usr-search-select { position: relative; }
.usr-search-select .usr-search-input {
    width: 100%; padding: 12px 16px 12px 42px; background: white;
    border: 1px solid var(--usr-gray-300); border-radius: 10px;
    font-size: 0.9375rem; color: var(--usr-gray-800); box-sizing: border-box; transition: all 0.2s ease;
}
.usr-search-select .usr-search-input:hover { border-color: var(--usr-gray-400); }
.usr-search-select .usr-search-input:focus { outline: none; border-color: var(--usr-orange); box-shadow: 0 0 0 3px rgba(255, 149, 0, 0.1); }
.usr-search-select .usr-search-icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--usr-gray-400); pointer-events: none;
}
.usr-search-select .usr-search-clear {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    width: 20px; height: 20px; border: none; background: none; cursor: pointer;
    color: var(--usr-gray-400); display: none; padding: 0; font-size: 1.125rem; line-height: 1;
}
.usr-search-select .usr-search-clear:hover { color: var(--usr-gray-800); }
.usr-search-dropdown {
    display: none; position: absolute; top: 100%; left: 0; right: 0;
    background: white; border: 1px solid var(--usr-gray-200);
    border-radius: 10px; max-height: 220px; overflow-y: auto; z-index: 100;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12); margin-top: 4px;
}
.usr-search-option {
    padding: 10px 16px; cursor: pointer; font-size: 0.9375rem;
    color: var(--usr-gray-800); transition: background 0.15s;
}
.usr-search-option:hover { background: rgba(255, 149, 0, 0.08); }
.usr-search-option .usr-opt-sub { color: var(--usr-gray-400); font-size: 0.8125rem; }
.usr-search-no-results {
    padding: 12px 16px; color: var(--usr-gray-400); font-style: italic;
    font-size: 0.875rem; text-align: center; display: none;
}
.dark .usr-search-select .usr-search-input { background: var(--usr-gray-700); border-color: var(--usr-gray-600); color: white; }
.dark .usr-search-dropdown { background: var(--usr-gray-700); border-color: var(--usr-gray-600); }
.dark .usr-search-option { color: var(--usr-gray-200); }
.dark .usr-search-option:hover { background: rgba(255, 149, 0, 0.15); }

.usr-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.usr-employee-preview {
    background: var(--usr-gray-50);
    border: 1px solid var(--usr-gray-200);
    border-radius: 12px;
    padding: 16px;
    margin-top: 16px;
    display: none;
}

.usr-employee-preview.visible {
    display: block;
    animation: usr-fadeIn 0.3s ease;
}

.usr-preview-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 0.875rem;
    color: var(--usr-gray-600);
}

.usr-preview-item svg {
    width: 16px;
    height: 16px;
    color: var(--usr-gray-400);
}

.usr-info-box {
    display: flex;
    gap: 12px;
    padding: 14px 16px;
    background: rgba(255, 149, 0, 0.08);
    border-radius: 10px;
    border-left: 3px solid var(--usr-orange);
    margin-top: 20px;
}

.usr-info-box svg {
    width: 18px;
    height: 18px;
    color: var(--usr-orange);
    flex-shrink: 0;
    margin-top: 1px;
}

.usr-info-box span {
    font-size: 0.8125rem;
    color: var(--usr-gray-700);
    line-height: 1.5;
}

/* Modal Footer */
.usr-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 20px 28px;
    background: var(--usr-gray-50);
    border-top: 1px solid var(--usr-gray-200);
}

.usr-btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    border: none;
}

.usr-btn svg {
    width: 18px;
    height: 18px;
}

.usr-btn-secondary {
    background: white;
    color: var(--usr-gray-600);
    border: 1px solid var(--usr-gray-300);
}

.usr-btn-secondary:hover {
    background: var(--usr-gray-100);
}

.usr-btn-primary {
    background: linear-gradient(135deg, var(--usr-orange), var(--usr-orange-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);
}

.usr-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(255, 149, 0, 0.4);
}

.usr-btn-success {
    background: linear-gradient(135deg, var(--usr-success), #059669);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.usr-btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

.usr-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

/* Spin Animation */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* ========================================
   DARK MODE
   ======================================== */
.dark .usr-stat-card,
.dark .usr-toolbar,
.dark .usr-card,
.dark .usr-table-container,
.dark .usr-empty {
    background: var(--usr-gray-800);
    border-color: var(--usr-gray-700);
}

.dark .usr-stat-value {
    background: linear-gradient(135deg, var(--usr-gray-100), var(--usr-gray-300));
    -webkit-background-clip: text;
    background-clip: text;
}

.dark .usr-stat-label {
    color: var(--usr-gray-400);
}

.dark .usr-search-box input {
    background: var(--usr-gray-700);
    border-color: var(--usr-gray-600);
    color: white;
}

.dark .usr-search-box input:focus {
    background: var(--usr-gray-700);
}

.dark .usr-filter-btn {
    background: var(--usr-gray-700);
    border-color: var(--usr-gray-600);
    color: var(--usr-gray-300);
}

.dark .usr-view-toggle {
    background: var(--usr-gray-700);
}

.dark .usr-view-btn {
    color: var(--usr-gray-400);
}

.dark .usr-view-btn.active {
    background: var(--usr-gray-600);
    color: var(--usr-orange);
}

.dark .usr-card-header {
    border-color: var(--usr-gray-700);
}

.dark .usr-card-name,
.dark .usr-table-name {
    color: var(--usr-gray-100);
}

.dark .usr-card-email,
.dark .usr-table-email {
    color: var(--usr-gray-400);
}

.dark .usr-card-row {
    border-color: var(--usr-gray-700);
}

.dark .usr-card-row-icon {
    background: var(--usr-gray-700);
    color: var(--usr-gray-400);
}

.dark .usr-card-row-value {
    color: var(--usr-gray-300);
}

.dark .usr-card-footer {
    background: var(--usr-gray-900);
    border-color: var(--usr-gray-700);
}

.dark .usr-card-date {
    color: var(--usr-gray-500);
}

.dark .usr-table th {
    background: var(--usr-gray-900);
    color: var(--usr-gray-400);
    border-color: var(--usr-gray-700);
}

.dark .usr-table td {
    color: var(--usr-gray-300);
    border-color: var(--usr-gray-700);
}

.dark .usr-modal {
    background: var(--usr-gray-800);
}

.dark .usr-wizard-steps {
    background: var(--usr-gray-900);
    border-color: var(--usr-gray-700);
}

.dark .usr-step-number {
    background: var(--usr-gray-700);
    color: var(--usr-gray-400);
}

.dark .usr-step-divider {
    background: var(--usr-gray-700);
}

.dark .usr-modal-body {
    background: var(--usr-gray-800);
}

.dark .usr-panel-title {
    color: var(--usr-gray-100);
}

.dark .usr-panel-desc {
    color: var(--usr-gray-400);
}

.dark .usr-form-label {
    color: var(--usr-gray-300);
}

.dark .usr-form-input,
.dark .usr-form-select {
    background: var(--usr-gray-700);
    border-color: var(--usr-gray-600);
    color: white;
}

.dark .usr-employee-preview {
    background: var(--usr-gray-900);
    border-color: var(--usr-gray-700);
}

.dark .usr-preview-item {
    color: var(--usr-gray-400);
}

.dark .usr-info-box {
    background: rgba(255, 149, 0, 0.1);
}

.dark .usr-info-box span {
    color: var(--usr-gray-300);
}

.dark .usr-modal-footer {
    background: var(--usr-gray-900);
    border-color: var(--usr-gray-700);
}

.dark .usr-btn-secondary {
    background: var(--usr-gray-700);
    color: var(--usr-gray-300);
    border-color: var(--usr-gray-600);
}

.dark .usr-btn-secondary:hover {
    background: var(--usr-gray-600);
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1200px) {
    .usr-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .usr-stats-grid {
        grid-template-columns: 1fr;
    }

    .usr-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .usr-toolbar-left {
        flex-direction: column;
    }

    .usr-search-box {
        max-width: 100%;
    }

    .usr-filter-group {
        justify-content: center;
        flex-wrap: wrap;
    }

    .usr-toolbar-right {
        justify-content: space-between;
    }

    .usr-grid {
        grid-template-columns: 1fr;
    }

    .usr-modal {
        max-width: 95%;
        margin: 20px;
    }

    .usr-form-grid {
        grid-template-columns: 1fr;
    }

    .usr-wizard-steps {
        padding: 16px 20px;
    }

    .usr-step-number {
        width: 32px;
        height: 32px;
        font-size: 0.75rem;
    }

    .usr-step-divider {
        width: 40px;
        margin: 0 10px 18px;
    }
}

/* ========================================
   NOTIFICATION TOAST
   ======================================== */
.usr-notification-toast {
    position: fixed;
    top: 20px;
    right: -400px;
    min-width: 320px;
    max-width: 420px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    z-index: 10000;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border-left: 4px solid var(--usr-orange);
}

.dark .usr-notification-toast {
    background: var(--usr-gray-800);
}

.usr-notification-toast.show {
    right: 20px;
}

.usr-notification-toast.usr-notification-success {
    border-left-color: var(--usr-success);
}

.usr-notification-toast.usr-notification-error {
    border-left-color: var(--usr-danger);
}

.usr-notification-toast.usr-notification-info {
    border-left-color: var(--usr-info);
}

.usr-notification-toast.usr-notification-warning {
    border-left-color: var(--usr-warning);
}

.usr-notification-content {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
}

.usr-notification-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.usr-notification-icon svg {
    width: 20px;
    height: 20px;
}

.usr-notification-success .usr-notification-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.15));
    color: var(--usr-success);
}

.usr-notification-error .usr-notification-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(220, 38, 38, 0.15));
    color: var(--usr-danger);
}

.usr-notification-info .usr-notification-icon {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.15));
    color: var(--usr-info);
}

.usr-notification-warning .usr-notification-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(217, 119, 6, 0.15));
    color: var(--usr-warning);
}

.usr-notification-text {
    flex: 1;
    min-width: 0;
}

.usr-notification-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--usr-gray-800);
    margin: 0 0 4px 0;
}

.dark .usr-notification-title {
    color: var(--usr-gray-100);
}

.usr-notification-message {
    font-size: 0.8125rem;
    color: var(--usr-gray-600);
    line-height: 1.5;
    margin: 0;
}

.dark .usr-notification-message {
    color: var(--usr-gray-400);
}

.usr-notification-close {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: none;
    background: transparent;
    color: var(--usr-gray-400);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.usr-notification-close:hover {
    background: var(--usr-gray-100);
    color: var(--usr-gray-600);
}

.dark .usr-notification-close:hover {
    background: var(--usr-gray-700);
    color: var(--usr-gray-300);
}

.usr-notification-close svg {
    width: 16px;
    height: 16px;
}

.usr-notification-progress {
    height: 3px;
    background: var(--usr-gray-200);
    position: relative;
    overflow: hidden;
}

.usr-notification-progress-bar {
    height: 100%;
    width: 100%;
    transform-origin: left;
    animation: usr-progress 5s linear forwards;
}

.usr-notification-success .usr-notification-progress-bar {
    background: var(--usr-success);
}

.usr-notification-error .usr-notification-progress-bar {
    background: var(--usr-danger);
}

.usr-notification-info .usr-notification-progress-bar {
    background: var(--usr-info);
}

.usr-notification-warning .usr-notification-progress-bar {
    background: var(--usr-warning);
}

@keyframes usr-progress {
    from { transform: scaleX(1); }
    to { transform: scaleX(0); }
}

@media (max-width: 768px) {
    .usr-notification-toast {
        min-width: auto;
        left: 10px;
        right: 10px !important;
        max-width: calc(100% - 20px);
    }

    .usr-notification-toast.show {
        right: 10px !important;
    }
}
</style>

{{-- Notification Toast Container --}}
@if(session('success'))
<div class="usr-notification-toast usr-notification-success" id="notificationToast">
    <div class="usr-notification-content">
        <div class="usr-notification-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="usr-notification-text">
            <h4 class="usr-notification-title">Succès</h4>
            <p class="usr-notification-message">{{ session('success') }}</p>
        </div>
    </div>
    <button class="usr-notification-close" onclick="closeNotification()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="usr-notification-progress">
        <div class="usr-notification-progress-bar"></div>
    </div>
</div>
@endif

@if(session('error'))
<div class="usr-notification-toast usr-notification-error" id="notificationToast">
    <div class="usr-notification-content">
        <div class="usr-notification-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
        </div>
        <div class="usr-notification-text">
            <h4 class="usr-notification-title">Erreur</h4>
            <p class="usr-notification-message">{{ session('error') }}</p>
        </div>
    </div>
    <button class="usr-notification-close" onclick="closeNotification()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="usr-notification-progress">
        <div class="usr-notification-progress-bar"></div>
    </div>
</div>
@endif

@if($errors->any())
<div class="usr-notification-toast usr-notification-error" id="notificationToast">
    <div class="usr-notification-content">
        <div class="usr-notification-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <div class="usr-notification-text">
            <h4 class="usr-notification-title">Erreur de validation</h4>
            <p class="usr-notification-message">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </p>
        </div>
    </div>
    <button class="usr-notification-close" onclick="closeNotification()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
    <div class="usr-notification-progress">
        <div class="usr-notification-progress-bar"></div>
    </div>
</div>
@endif

<div class="usr-page">
    {{-- Statistics Grid --}}
    <div class="usr-stats-grid">
        <div class="usr-stat-card total">
            <div class="usr-stat-header">
                <div class="usr-stat-content">
                    <div class="usr-stat-value" data-count="{{ $users->count() }}">0</div>
                    <div class="usr-stat-label">Total Comptes</div>
                </div>
                <div class="usr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="usr-stat-card active">
            <div class="usr-stat-header">
                <div class="usr-stat-content">
                    <div class="usr-stat-value" data-count="{{ $users->where('status', 'active')->count() }}">0</div>
                    <div class="usr-stat-label">Comptes Actifs</div>
                </div>
                <div class="usr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <div class="usr-stat-card inactive">
            <div class="usr-stat-header">
                <div class="usr-stat-content">
                    <div class="usr-stat-value" data-count="{{ $users->where('status', 'inactive')->count() }}">0</div>
                    <div class="usr-stat-label">Comptes Inactifs</div>
                </div>
                <div class="usr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </div>
            </div>
        </div>

        <div class="usr-stat-card warning">
            <div class="usr-stat-header">
                <div class="usr-stat-content">
                    <div class="usr-stat-value" data-count="{{ $users->filter(fn($u) => !$u->personnel)->count() }}">0</div>
                    <div class="usr-stat-label">Sans Personnel</div>
                </div>
                <div class="usr-stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="usr-toolbar">
        <div class="usr-toolbar-left">
            <div class="usr-search-box">
                <svg class="usr-search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" id="usrSearchInput" placeholder="Rechercher par nom, email ou rôle...">
            </div>
            <div class="usr-filter-group">
                <button class="usr-filter-btn active" data-filter="all">
                    Tous
                    <span class="count">{{ $users->count() }}</span>
                </button>
                <button class="usr-filter-btn" data-filter="active">
                    Actifs
                    <span class="count">{{ $users->where('status', 'active')->count() }}</span>
                </button>
                <button class="usr-filter-btn" data-filter="inactive">
                    Inactifs
                    <span class="count">{{ $users->where('status', 'inactive')->count() }}</span>
                </button>
            </div>
        </div>
        <div class="usr-toolbar-right">
            <div class="usr-view-toggle">
                <button class="usr-view-btn active" data-view="grid" title="Vue grille">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </button>
                <button class="usr-view-btn" data-view="table" title="Vue tableau">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </button>
            </div>
            @can('create-users')
            <button class="usr-btn-add" id="usrBtnAdd">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                Créer un compte
            </button>
            @endcan
        </div>
    </div>

    {{-- Grid View --}}
    @if($users->count() > 0)
    <div class="usr-grid active" id="usrGrid">
        @foreach($users as $user)
        @php
            $roles = $user->getRoleNames();
            $roleName = $roles->first() ?? 'Aucun rôle';
            $roleClass = match($roleName) {
                'Super Admin' => 'super-admin',
                'Admin' => 'admin',
                'Manager' => 'manager',
                'RH' => 'rh',
                default => 'employe'
            };
        @endphp
        <div class="usr-card" data-status="{{ $user->status }}" data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $roleName) }}">
            <div class="usr-card-header">
                <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FF9500&color=fff&bold=true' }}"
                     alt="{{ $user->name }}" class="usr-avatar">
                <div class="usr-card-info">
                    <h3 class="usr-card-name">{{ $user->name }}</h3>
                    <p class="usr-card-email">{{ $user->email }}</p>
                </div>
                <div class="usr-card-badges">
                    <span class="usr-badge usr-badge-role {{ $roleClass }}">{{ $roleName }}</span>
                    <span class="usr-badge usr-badge-status {{ $user->status }}">
                        {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>
            <div class="usr-card-body">
                <div class="usr-card-row">
                    <div class="usr-card-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="usr-card-row-content">
                        <div class="usr-card-row-label">Personnel associé</div>
                        <div class="usr-card-row-value">
                            @if($user->personnel)
                                <a href="{{ route('admin.personnels.show', $user->personnel->id) }}">
                                    {{ $user->personnel->matricule }} - {{ $user->personnel->nom_complet }}
                                </a>
                            @else
                                <span style="color: var(--usr-gray-400);">Aucun personnel lié</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="usr-card-row">
                    <div class="usr-card-row-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div class="usr-card-row-content">
                        <div class="usr-card-row-label">Authentification 2FA</div>
                        <div class="usr-card-row-value">
                            <span class="usr-2fa-badge {{ $user->google2fa_enabled ? 'enabled' : 'disabled' }}">
                                {{ $user->google2fa_enabled ? '✓ Activée' : '✗ Désactivée' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="usr-card-footer">
                <div class="usr-card-date">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Créé le {{ $user->created_at->format('d/m/Y') }}
                </div>
                <div class="usr-card-actions">
                    <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="usr-action-btn view" title="Voir">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </a>
                    @can('edit-users')
                    <button class="usr-action-btn edit" title="Modifier" onclick="editUser({{ $user->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>
                    @endcan
                    @can('delete-users')
                    <button class="usr-action-btn delete" title="Supprimer" onclick="deleteUser({{ $user->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                    </button>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table View --}}
    <div class="usr-table-container" id="usrTable">
        <table class="usr-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Personnel Associé</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>2FA</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                @php
                    $roles = $user->getRoleNames();
                    $roleName = $roles->first() ?? 'Aucun rôle';
                    $roleClass = match($roleName) {
                        'Super Admin' => 'super-admin',
                        'Admin' => 'admin',
                        'Manager' => 'manager',
                        'RH' => 'rh',
                        default => 'employe'
                    };
                @endphp
                <tr data-status="{{ $user->status }}" data-search="{{ strtolower($user->name . ' ' . $user->email . ' ' . $roleName) }}">
                    <td>
                        <div class="usr-table-user">
                            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FF9500&color=fff&bold=true' }}"
                                 alt="{{ $user->name }}" class="usr-table-avatar">
                            <div class="usr-table-info">
                                <div class="usr-table-name">{{ $user->name }}</div>
                                <div class="usr-table-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->personnel)
                            <a href="{{ route('admin.personnels.show', $user->personnel->id) }}" style="color: var(--usr-primary); text-decoration: none;">
                                {{ $user->personnel->matricule }} - {{ $user->personnel->nom_complet }}
                            </a>
                        @else
                            <span style="color: var(--usr-gray-400);">Aucun personnel lié</span>
                        @endif
                    </td>
                    <td>
                        <span class="usr-badge usr-badge-role {{ $roleClass }}">{{ $roleName }}</span>
                    </td>
                    <td>
                        <span class="usr-badge usr-badge-status {{ $user->status }}">
                            {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td>
                        <span class="usr-2fa-badge {{ $user->google2fa_enabled ? 'enabled' : 'disabled' }}">
                            {{ $user->google2fa_enabled ? '✓ Activée' : '✗ Désactivée' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="usr-table-actions">
                            <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="usr-action-btn view" title="Voir">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            @can('edit-users')
                            <button class="usr-action-btn edit" title="Modifier" onclick="editUser({{ $user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            @endcan
                            @can('delete-users')
                            <button class="usr-action-btn delete" title="Supprimer" onclick="deleteUser({{ $user->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="usr-empty">
        <div class="usr-empty-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <h3 class="usr-empty-title">Aucun compte utilisateur</h3>
        <p class="usr-empty-text">Commencez par créer un compte pour votre personnel</p>
    </div>
    @endif
</div>

{{-- Modal Create/Edit User --}}
<div class="usr-modal-overlay" id="usrModal">
    <div class="usr-modal">
        <div class="usr-modal-header">
            <div class="usr-modal-header-content">
                <div class="usr-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <div>
                    <h2 class="usr-modal-title" id="usrModalTitle">Créer un Compte</h2>
                    <p class="usr-modal-subtitle">En 3 étapes simples</p>
                </div>
            </div>
            <button class="usr-modal-close" id="usrModalClose">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="usr-wizard-steps">
            <div class="usr-step active" data-step="1">
                <div class="usr-step-number">1</div>
                <span class="usr-step-label">Employé</span>
            </div>
            <div class="usr-step-divider"></div>
            <div class="usr-step" data-step="2">
                <div class="usr-step-number">2</div>
                <span class="usr-step-label">Email</span>
            </div>
            <div class="usr-step-divider"></div>
            <div class="usr-step" data-step="3">
                <div class="usr-step-number">3</div>
                <span class="usr-step-label">Accès</span>
            </div>
        </div>

        <form id="usrForm" action="{{ route('admin.utilisateurs.store') }}" method="POST">
            @csrf
            <input type="hidden" id="usrUserId" name="user_id">

            <div class="usr-modal-body">
                {{-- Step 1: Employee Selection --}}
                <div class="usr-wizard-panel active" data-step="1">
                    <h3 class="usr-panel-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        Sélectionner l'employé
                    </h3>
                    <p class="usr-panel-desc">Choisissez l'employé pour qui vous voulez créer un compte</p>

                    <div class="usr-form-field">
                        <label class="usr-form-label">
                            Employé <span class="required">*</span>
                        </label>
                        <div class="usr-search-select" id="usrPersonnelSearch">
                            <svg class="usr-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="usr-search-input" id="usrPersonnelInput" placeholder="Rechercher un employé..." autocomplete="off">
                            <button type="button" class="usr-search-clear" title="Effacer">&times;</button>
                            <input type="hidden" id="usrPersonnelId" name="personnel_id" required>
                            <div class="usr-search-dropdown">
                                @foreach($personnels_sans_compte ?? [] as $personnel)
                                <div class="usr-search-option"
                                     data-value="{{ $personnel->id }}"
                                     data-text="{{ $personnel->matricule }} - {{ $personnel->nom_complet }}{{ $personnel->poste ? ' ('.$personnel->poste.')' : '' }}"
                                     data-email="{{ $personnel->email }}"
                                     data-phone="{{ $personnel->telephone_complet }}"
                                     data-department="{{ $personnel->departement->nom ?? 'N/A' }}">
                                    {{ $personnel->matricule }} - {{ $personnel->nom_complet }}
                                    @if($personnel->poste) <span class="usr-opt-sub">({{ $personnel->poste }})</span> @endif
                                </div>
                                @endforeach
                                <div class="usr-search-no-results">Aucun résultat</div>
                            </div>
                        </div>
                    </div>

                    <div class="usr-employee-preview" id="usrEmployeePreview">
                        <div class="usr-preview-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span id="usrPreviewEmail">-</span>
                        </div>
                        <div class="usr-preview-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span id="usrPreviewPhone">-</span>
                        </div>
                        <div class="usr-preview-item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span id="usrPreviewDept">-</span>
                        </div>
                    </div>
                </div>

                {{-- Step 2: Email --}}
                <div class="usr-wizard-panel" data-step="2">
                    <h3 class="usr-panel-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Configurer l'email
                    </h3>
                    <p class="usr-panel-desc">Saisissez l'adresse email professionnelle pour le compte</p>

                    <div class="usr-form-field">
                        <label class="usr-form-label">
                            Adresse email <span class="required">*</span>
                        </label>
                        <input type="email" id="usrEmail" name="email" class="usr-form-input"
                               placeholder="prenom.nom@entreprise.com" required>
                    </div>

                    <div class="usr-info-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                        <span>L'utilisateur recevra ses identifiants de connexion par email</span>
                    </div>
                </div>

                {{-- Step 3: Access --}}
                <div class="usr-wizard-panel" data-step="3">
                    <h3 class="usr-panel-title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        Définir les accès
                    </h3>
                    <p class="usr-panel-desc">Choisissez le rôle et le statut du compte utilisateur</p>

                    <div class="usr-form-grid">
                        <div class="usr-form-field">
                            <label class="usr-form-label">
                                Rôle <span class="required">*</span>
                            </label>
                            <div class="usr-select-wrapper">
                                <select id="usrRole" name="role" class="usr-form-select" required>
                                    <option value="">-- Choisir un rôle --</option>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                    <option value="Super Admin">Super Administrateur</option>
                                    @endif
                                    <option value="Admin">Administrateur</option>
                                    <option value="Manager">Manager</option>
                                    <option value="RH">Ressources Humaines</option>
                                    <option value="Employé">Employé</option>
                                </select>
                            </div>
                        </div>

                        <div class="usr-form-field">
                            <label class="usr-form-label">
                                Statut <span class="required">*</span>
                            </label>
                            <div class="usr-select-wrapper">
                                <select id="usrStatus" name="status" class="usr-form-select" required>
                                    <option value="active" selected>Actif</option>
                                    <option value="inactive">Inactif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="usr-info-box">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span><strong>Mot de passe :</strong> Généré automatiquement et envoyé par email/WhatsApp</span>
                    </div>
                </div>
            </div>

            <div class="usr-modal-footer">
                <button type="button" class="usr-btn usr-btn-secondary" id="usrBtnPrev" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Précédent
                </button>
                <button type="button" class="usr-btn usr-btn-secondary" id="usrBtnCancel">
                    Annuler
                </button>
                <button type="button" class="usr-btn usr-btn-primary" id="usrBtnNext">
                    Suivant
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                <button type="submit" class="usr-btn usr-btn-success" id="usrBtnSubmit" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    Créer le compte
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Users page scripts loaded successfully');

    // Counter Animation
    const stats = document.querySelectorAll('.usr-stat-value[data-count]');
    stats.forEach((stat, index) => {
        const target = parseInt(stat.getAttribute('data-count'));
        const duration = 1200;
        const increment = target / (duration / 16);
        let current = 0;

        setTimeout(() => {
            const animate = () => {
                current += increment;
                if (current >= target) {
                    stat.textContent = target;
                } else {
                    stat.textContent = Math.floor(current);
                    requestAnimationFrame(animate);
                }
            };
            animate();
        }, index * 150);
    });

    // View Toggle
    const viewBtns = document.querySelectorAll('.usr-view-btn');
    const grid = document.getElementById('usrGrid');
    const table = document.getElementById('usrTable');

    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const view = this.dataset.view;
            if (view === 'grid') {
                grid?.classList.add('active');
                table?.classList.remove('active');
            } else {
                grid?.classList.remove('active');
                table?.classList.add('active');
            }
        });
    });

    // Search
    const searchInput = document.getElementById('usrSearchInput');
    searchInput?.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        filterUsers(term, currentFilter);
    });

    // Filter
    let currentFilter = 'all';
    const filterBtns = document.querySelectorAll('.usr-filter-btn');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterUsers(searchInput?.value.toLowerCase() || '', currentFilter);
        });
    });

    function filterUsers(searchTerm, filter) {
        const cards = document.querySelectorAll('.usr-card');
        const rows = document.querySelectorAll('.usr-table tbody tr');

        [...cards, ...rows].forEach(item => {
            const status = item.dataset.status;
            const searchText = item.dataset.search || '';

            const matchesFilter = filter === 'all' || status === filter;
            const matchesSearch = !searchTerm || searchText.includes(searchTerm);

            item.style.display = matchesFilter && matchesSearch ? '' : 'none';
        });
    }

    // Modal
    const modal = document.getElementById('usrModal');
    const btnAdd = document.getElementById('usrBtnAdd');
    const btnClose = document.getElementById('usrModalClose');
    const btnCancel = document.getElementById('usrBtnCancel');
    const btnPrev = document.getElementById('usrBtnPrev');
    const btnNext = document.getElementById('usrBtnNext');
    const btnSubmit = document.getElementById('usrBtnSubmit');

    let currentStep = 1;
    const totalSteps = 3;

    function openModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        resetWizard();
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    function resetWizard() {
        currentStep = 1;
        updateWizard();
        document.getElementById('usrForm').reset();
        document.getElementById('usrEmployeePreview').classList.remove('visible');
    }

    function updateWizard() {
        // Update steps
        document.querySelectorAll('.usr-step').forEach((step, i) => {
            step.classList.remove('active', 'completed');
            if (i + 1 < currentStep) step.classList.add('completed');
            if (i + 1 === currentStep) step.classList.add('active');
        });

        // Update panels
        document.querySelectorAll('.usr-wizard-panel').forEach(panel => {
            panel.classList.remove('active');
            if (parseInt(panel.dataset.step) === currentStep) {
                panel.classList.add('active');
            }
        });

        // Update buttons
        btnPrev.style.display = currentStep > 1 ? '' : 'none';
        btnNext.style.display = currentStep < totalSteps ? '' : 'none';
        btnSubmit.style.display = currentStep === totalSteps ? '' : 'none';
    }

    console.log('Modal:', modal);
    console.log('Button Add:', btnAdd);

    btnAdd?.addEventListener('click', function() {
        console.log('Add button clicked');
        openModal();
    });
    btnClose?.addEventListener('click', closeModal);
    btnCancel?.addEventListener('click', closeModal);

    modal?.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    btnPrev?.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
        }
    });

    btnNext?.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        }
    });

    function validateStep(step) {
        if (step === 1) {
            const personnel = document.getElementById('usrPersonnelId');
            if (!personnel.value) {
                document.getElementById('usrPersonnelInput').focus();
                alert('Veuillez sélectionner un employé');
                return false;
            }
        } else if (step === 2) {
            const email = document.getElementById('usrEmail');
            if (!email.value || !email.validity.valid) {
                email.focus();
                alert('Veuillez saisir une adresse email valide');
                return false;
            }
        } else if (step === 3) {
            const role = document.getElementById('usrRole');
            if (!role.value) {
                role.focus();
                alert('Veuillez sélectionner un rôle');
                return false;
            }
        }
        return true;
    }

    // ── Searchable Personnel Select with Preview ──
    const preview = document.getElementById('usrEmployeePreview');
    const emailInput = document.getElementById('usrEmail');

    (function() {
        var wrapper = document.getElementById('usrPersonnelSearch');
        if (!wrapper) return;
        var searchInput = wrapper.querySelector('.usr-search-input');
        var hidden = document.getElementById('usrPersonnelId');
        var dropdown = wrapper.querySelector('.usr-search-dropdown');
        var options = wrapper.querySelectorAll('.usr-search-option');
        var noResults = wrapper.querySelector('.usr-search-no-results');
        var clearBtn = wrapper.querySelector('.usr-search-clear');

        function showDropdown() { dropdown.style.display = 'block'; }
        function hideDropdown() { dropdown.style.display = 'none'; }

        function filterOptions() {
            var term = searchInput.value.toLowerCase().trim();
            var visible = 0;
            options.forEach(function(opt) {
                var match = opt.getAttribute('data-text').toLowerCase().indexOf(term) !== -1;
                opt.style.display = match ? '' : 'none';
                if (match) visible++;
            });
            noResults.style.display = visible === 0 ? 'block' : 'none';
            if (visible === 1 && term.length > 0) {
                options.forEach(function(opt) {
                    if (opt.style.display !== 'none') selectOption(opt);
                });
            }
        }

        function selectOption(opt) {
            hidden.value = opt.getAttribute('data-value');
            searchInput.value = opt.getAttribute('data-text');
            clearBtn.style.display = 'block';
            hideDropdown();
            // Update preview
            document.getElementById('usrPreviewEmail').textContent = opt.dataset.email || '-';
            document.getElementById('usrPreviewPhone').textContent = opt.dataset.phone || '-';
            document.getElementById('usrPreviewDept').textContent = opt.dataset.department || '-';
            preview.classList.add('visible');
            // Auto-fill email
            if (opt.dataset.email && emailInput) {
                emailInput.value = opt.dataset.email;
            }
        }

        function clearSelection() {
            hidden.value = '';
            searchInput.value = '';
            clearBtn.style.display = 'none';
            options.forEach(function(opt) { opt.style.display = ''; });
            noResults.style.display = 'none';
            preview.classList.remove('visible');
        }

        searchInput.addEventListener('focus', function() { showDropdown(); filterOptions(); });
        searchInput.addEventListener('input', function() {
            hidden.value = '';
            clearBtn.style.display = searchInput.value ? 'block' : 'none';
            showDropdown();
            filterOptions();
            preview.classList.remove('visible');
        });
        options.forEach(function(opt) {
            opt.addEventListener('click', function() { selectOption(opt); });
        });
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearSelection();
            searchInput.focus();
        });
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) hideDropdown();
        });
    })();

    // ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    // Form submission with loading state
    const form = document.getElementById('usrForm');
    form?.addEventListener('submit', function(e) {
        // Validate step 3 before submit
        if (!validateStep(3)) {
            e.preventDefault();
            return;
        }

        const submitBtn = document.getElementById('usrBtnSubmit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
            </svg>
            Création en cours...
        `;
    });
});

// Edit user function
function editUser(id) {
    window.location.href = '{{ url("admin/utilisateurs") }}/' + id + '/edit';
}

// Delete user function
function deleteUser(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("admin/utilisateurs") }}/' + id;

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        form.appendChild(methodInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Notification system
function closeNotification() {
    const notif = document.getElementById('notificationToast');
    if (notif) {
        notif.classList.remove('show');
        setTimeout(() => notif.remove(), 400);
    }
}

function showNotification(message, type = 'info', title = '') {
    // Remove existing notification
    const existingNotif = document.getElementById('notificationToast');
    if (existingNotif) {
        existingNotif.remove();
    }

    const titles = {
        success: 'Succès',
        error: 'Erreur',
        warning: 'Attention',
        info: 'Information'
    };

    const icons = {
        success: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
        error: '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>',
        warning: '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line>',
        info: '<circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line>'
    };

    const notif = document.createElement('div');
    notif.className = `usr-notification-toast usr-notification-${type}`;
    notif.id = 'notificationToast';
    notif.innerHTML = `
        <div class="usr-notification-content">
            <div class="usr-notification-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    ${icons[type] || icons.info}
                </svg>
            </div>
            <div class="usr-notification-text">
                <h4 class="usr-notification-title">${title || titles[type] || 'Notification'}</h4>
                <p class="usr-notification-message">${message}</p>
            </div>
        </div>
        <button class="usr-notification-close" onclick="closeNotification()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <div class="usr-notification-progress">
            <div class="usr-notification-progress-bar"></div>
        </div>
    `;

    document.body.appendChild(notif);

    // Show notification with animation
    setTimeout(() => notif.classList.add('show'), 10);

    // Auto close after 5 seconds
    setTimeout(() => closeNotification(), 5000);
}

// Show notification on page load if exists
document.addEventListener('DOMContentLoaded', function() {
    const notif = document.getElementById('notificationToast');
    if (notif) {
        setTimeout(() => notif.classList.add('show'), 100);
        setTimeout(() => closeNotification(), 5000);
    }
});
</script>
@endsection
