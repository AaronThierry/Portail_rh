@extends('layouts.app')

@section('title', 'Gestion des Comptes Utilisateurs')

@section('styles')
<style>
/* ========================================
   Base Variables & Animations
   ======================================== */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
    --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    --animation-smooth: cubic-bezier(0.4, 0, 0.2, 1);
    --animation-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Keyframe Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes glow {
    0%, 100% {
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
    }
    50% {
        box-shadow: 0 0 30px rgba(102, 126, 234, 0.5);
    }
}

/* ========================================
   Page Container - Full Width
   ======================================== */
.users-page {
    padding: 0;
    margin: 0;
    width: 100%;
    min-height: 100vh;
    background: var(--bg-primary);
}

/* Section Wrapper - Full Width */
.section-wrapper {
    width: 100%;
    margin: 0;
}

/* ========================================
   Page Header - Full Width with Gradient
   ======================================== */
.page-header {
    position: relative;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    padding: 48px 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid transparent;
    border-image: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    border-image-slice: 1;
    flex-wrap: wrap;
    gap: 24px;
    overflow: hidden;
    animation: fadeInDown 0.6s var(--animation-smooth);
}

.page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shimmer 3s infinite;
}

.page-title-group {
    flex: 1;
    animation: slideInLeft 0.6s var(--animation-smooth);
}

.page-title {
    font-size: 2.75rem;
    font-weight: 900;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
    letter-spacing: -1px;
    position: relative;
    display: inline-block;
}

.page-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 4px;
    background: var(--primary-gradient);
    border-radius: 2px;
    animation: slideInLeft 0.8s var(--animation-smooth) 0.2s both;
}

.page-description {
    color: var(--text-muted);
    font-size: 1.125rem;
    margin: 0;
    font-weight: 500;
    opacity: 0;
    animation: fadeInUp 0.6s var(--animation-smooth) 0.3s forwards;
}

/* ========================================
   Statistics Section - Full Width
   ======================================== */
.stats-section {
    background: var(--bg-secondary);
    padding: 48px 60px;
    border-bottom: 1px solid var(--card-border);
    animation: fadeInUp 0.6s var(--animation-smooth) 0.2s both;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 32px;
    width: 100%;
}

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 24px;
    padding: 32px;
    transition: all 0.5s var(--animation-smooth);
    position: relative;
    overflow: hidden;
    cursor: pointer;
    opacity: 0;
    animation: scaleIn 0.6s var(--animation-smooth) forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 5px;
    height: 100%;
    background: var(--gradient);
    transition: all 0.5s var(--animation-smooth);
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    transition: all 0.6s var(--animation-smooth);
    pointer-events: none;
}

.stat-card:hover {
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    border-color: transparent;
}

.stat-card:hover::before {
    width: 100%;
    opacity: 0.08;
}

.stat-card:hover::after {
    width: 500px;
    height: 500px;
}

.stat-card.total::before { background: var(--primary-gradient); }
.stat-card.active::before { background: var(--success-gradient); }
.stat-card.inactive::before { background: var(--danger-gradient); }
.stat-card.no-personnel::before { background: var(--warning-gradient); }

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 3rem;
    font-weight: 900;
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: 12px;
    letter-spacing: -1px;
    transition: all 0.3s var(--animation-smooth);
}

.stat-card:hover .stat-value {
    transform: scale(1.1);
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.938rem;
    color: var(--text-muted);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.4s var(--animation-smooth);
    position: relative;
    z-index: 1;
}

.stat-card:hover .stat-icon {
    transform: rotate(10deg) scale(1.1);
    animation: float 2s ease-in-out infinite;
}

.stat-card.total .stat-icon {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.2);
}

.stat-card.active .stat-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.15) 100%);
    color: #10b981;
    box-shadow: 0 8px 16px rgba(16, 185, 129, 0.2);
}

.stat-card.inactive .stat-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.15) 100%);
    color: #ef4444;
    box-shadow: 0 8px 16px rgba(239, 68, 68, 0.2);
}

.stat-card.no-personnel .stat-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(217, 119, 6, 0.15) 100%);
    color: #f59e0b;
    box-shadow: 0 8px 16px rgba(245, 158, 11, 0.2);
}

/* ========================================
   Toolbar Section - Full Width
   ======================================== */
.toolbar-section {
    background: var(--card-bg);
    padding: 32px 60px;
    border-bottom: 1px solid var(--card-border);
    animation: fadeInUp 0.6s var(--animation-smooth) 0.4s both;
    position: sticky;
    top: 0;
    z-index: 100;
    backdrop-filter: blur(10px);
}

.toolbar-container {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
    flex: 1;
    min-width: 300px;
    max-width: 600px;
    animation: slideInLeft 0.6s var(--animation-smooth) 0.5s both;
}

.search-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    pointer-events: none;
    transition: all 0.3s var(--animation-smooth);
}

.search-box input:focus + .search-icon {
    color: #667eea;
    transform: translateY(-50%) scale(1.1);
}

.search-box input {
    width: 100%;
    padding: 16px 24px 16px 56px;
    border: 2px solid var(--card-border);
    border-radius: 16px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 1rem;
    transition: all 0.4s var(--animation-smooth);
    font-weight: 500;
}

.search-box input::placeholder {
    color: var(--text-muted);
    font-weight: 400;
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    background: var(--card-bg);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.toolbar-actions {
    display: flex;
    gap: 16px;
    align-items: center;
    animation: slideInRight 0.6s var(--animation-smooth) 0.5s both;
}

/* ========================================
   Buttons with Advanced Animations
   ======================================== */
.btn {
    padding: 16px 32px;
    border-radius: 16px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s var(--animation-smooth);
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    letter-spacing: 0.5px;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.25);
    transition: width 0.6s var(--animation-smooth), height 0.6s var(--animation-smooth);
    z-index: -1;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn svg {
    transition: all 0.4s var(--animation-smooth);
}

.btn:hover svg {
    transform: scale(1.2) rotate(10deg);
}

.btn-primary {
    background: var(--primary-gradient);
    color: #ffffff;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    animation: slideInRight 0.6s var(--animation-smooth) 0.2s both;
}

.btn-primary:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 12px 36px rgba(102, 126, 234, 0.6);
}

.btn-primary:active {
    transform: translateY(-2px) scale(1.02);
}

.btn-secondary {
    background: var(--card-bg);
    color: var(--text-primary);
    border-color: var(--card-border);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn-secondary:hover {
    background: var(--bg-secondary);
    border-color: #667eea;
    transform: translateY(-3px) scale(1.03);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.btn-secondary:active {
    transform: translateY(-1px) scale(1.01);
}

/* ========================================
   Table Section - Full Width
   ======================================== */
.table-section {
    background: var(--bg-primary);
    padding: 48px 60px 60px;
    animation: fadeInUp 0.6s var(--animation-smooth) 0.6s both;
}

.table-container-wrapper {
    width: 100%;
}

.table-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    transition: all 0.4s var(--animation-smooth);
}

.table-card:hover {
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
}

.table-container {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
}

.users-table thead {
    background: var(--primary-gradient);
    position: relative;
}

.users-table thead::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
    background-size: 200% 100%;
    animation: shimmer 3s infinite;
}

.users-table th {
    padding: 24px 28px;
    text-align: left;
    font-size: 0.875rem;
    font-weight: 800;
    color: #ffffff;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    white-space: nowrap;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    position: relative;
}

.users-table td {
    padding: 24px 28px;
    border-bottom: 1px solid var(--card-border);
    color: var(--text-primary);
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s var(--animation-smooth);
}

.users-table tbody tr {
    transition: all 0.4s var(--animation-smooth);
    cursor: pointer;
    position: relative;
}

.users-table tbody tr::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 0;
    height: 100%;
    background: var(--primary-gradient);
    opacity: 0.1;
    transition: width 0.4s var(--animation-smooth);
}

.users-table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.06) 0%, rgba(118, 75, 162, 0.06) 100%);
    transform: translateX(8px);
    box-shadow: -4px 0 12px rgba(102, 126, 234, 0.15);
}

.users-table tbody tr:hover::before {
    width: 6px;
}

.users-table tbody tr:hover td {
    color: var(--text-primary);
    font-weight: 600;
}

/* ========================================
   User Cell with Hover Effects
   ======================================== */
.user-cell {
    display: flex;
    align-items: center;
    gap: 20px;
}

.user-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid transparent;
    background: var(--primary-gradient);
    padding: 3px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.4s var(--animation-smooth);
}

.users-table tbody tr:hover .user-avatar {
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    animation: float 2s ease-in-out infinite;
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.user-name {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1.063rem;
    transition: all 0.3s var(--animation-smooth);
}

.users-table tbody tr:hover .user-name {
    color: #667eea;
    transform: translateX(4px);
}

.user-email {
    font-size: 0.875rem;
    color: var(--text-muted);
    transition: all 0.3s var(--animation-smooth);
}

.users-table tbody tr:hover .user-email {
    color: var(--text-secondary);
}

/* Personnel Link */
.personnel-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    color: #667eea;
    font-size: 0.875rem;
    font-weight: 700;
    transition: all 0.4s var(--animation-smooth);
    text-decoration: none;
    border: 2px solid transparent;
}

.personnel-link:hover {
    background: rgba(102, 126, 234, 0.2);
    transform: translateX(6px) scale(1.05);
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.personnel-link svg {
    transition: all 0.3s var(--animation-smooth);
}

.personnel-link:hover svg {
    transform: scale(1.2);
}

.no-personnel {
    color: var(--text-muted);
    font-style: italic;
    font-size: 0.875rem;
    opacity: 0.7;
}

/* ========================================
   Badges with Gradients & Animations
   ======================================== */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 24px;
    font-size: 0.813rem;
    font-weight: 800;
    white-space: nowrap;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.4s var(--animation-smooth);
    position: relative;
    overflow: hidden;
}

.badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.6s var(--animation-smooth);
}

.badge:hover::before {
    left: 100%;
}

.badge:hover {
    transform: scale(1.1);
}

.badge-success {
    background: var(--success-gradient);
    color: #ffffff;
}

.badge-success:hover {
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.badge-danger {
    background: var(--danger-gradient);
    color: #ffffff;
}

.badge-danger:hover {
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

.badge-warning {
    background: var(--warning-gradient);
    color: #ffffff;
}

.badge-warning:hover {
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
}

.badge-info {
    background: var(--info-gradient);
    color: #ffffff;
}

.badge-info:hover {
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
}

.badge-primary {
    background: var(--primary-gradient);
    color: #ffffff;
}

.badge-primary:hover {
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* ========================================
   Action Buttons with Micro-Animations
   ======================================== */
.action-buttons {
    display: flex;
    gap: 12px;
    opacity: 0.7;
    transition: opacity 0.3s var(--animation-smooth);
}

.users-table tbody tr:hover .action-buttons {
    opacity: 1;
}

.btn-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.4s var(--animation-smooth);
    position: relative;
    overflow: hidden;
}

.btn-icon::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transition: width 0.5s var(--animation-smooth), height 0.5s var(--animation-smooth);
}

.btn-icon:hover::before {
    width: 100px;
    height: 100px;
}

.btn-icon svg {
    position: relative;
    z-index: 1;
    transition: all 0.4s var(--animation-smooth);
}

.btn-icon:hover svg {
    transform: scale(1.25) rotate(10deg);
}

.btn-icon.btn-view {
    background: rgba(59, 130, 246, 0.15);
    color: #3b82f6;
    border-color: rgba(59, 130, 246, 0.2);
}

.btn-icon.btn-view:hover {
    background: var(--info-gradient);
    color: #ffffff;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
    transform: translateY(-4px) scale(1.1);
    border-color: #3b82f6;
}

.btn-icon.btn-edit {
    background: rgba(16, 185, 129, 0.15);
    color: #10b981;
    border-color: rgba(16, 185, 129, 0.2);
}

.btn-icon.btn-edit:hover {
    background: var(--success-gradient);
    color: #ffffff;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    transform: translateY(-4px) scale(1.1);
    border-color: #10b981;
}

.btn-icon.btn-delete {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border-color: rgba(239, 68, 68, 0.2);
}

.btn-icon.btn-delete:hover {
    background: var(--danger-gradient);
    color: #ffffff;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    transform: translateY(-4px) scale(1.1);
    border-color: #ef4444;
}

.btn-icon:active {
    transform: translateY(-2px) scale(1.05);
}

/* Modal Overlay */
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
        0 30px 60px -30px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 700px;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(40px);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.dark .modal {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    border: 1px solid rgba(148, 163, 184, 0.1);
}

.modal-overlay.show .modal {
    transform: scale(1) translateY(0);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 32px 32px 28px;
    background: var(--primary-gradient);
    position: relative;
    overflow: hidden;
}

.modal-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: #ffffff;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    letter-spacing: -0.025em;
    position: relative;
    z-index: 1;
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
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: rotate(90deg) scale(1.05);
}

.modal-body {
    padding: 32px;
    max-height: calc(90vh - 200px);
    overflow-y: auto;
}

/* Form Styles */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 0.938rem;
    font-weight: 700;
    color: var(--text-secondary);
    margin-bottom: 10px;
    letter-spacing: 0.3px;
}

.form-label.required::after {
    content: '*';
    color: #ef4444;
    margin-left: 6px;
    font-size: 1.125rem;
}

.form-input,
.form-select {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid var(--card-border);
    border-radius: 12px;
    background: var(--bg-secondary);
    color: var(--text-primary);
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #667eea;
    background: var(--card-bg);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
}

.form-error {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 6px;
    display: none;
}

.form-error.show {
    display: block;
}

.form-input.error,
.form-select.error {
    border-color: #ef4444;
    background: rgba(239, 68, 68, 0.05);
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 24px 32px;
    border-top: 1px solid var(--card-border);
    background: var(--bg-secondary);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 24px;
    opacity: 0.4;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 12px;
}

.empty-description {
    color: var(--text-muted);
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 1200px) {
    .page-header,
    .toolbar-section,
    .stats-section,
    .table-section {
        padding-left: 24px;
        padding-right: 24px;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .toolbar-container {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box {
        max-width: 100%;
        min-width: auto;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .users-table {
        font-size: 0.875rem;
    }

    .users-table th,
    .users-table td {
        padding: 12px 16px;
    }
}
</style>
@endsection

@section('content')
<div class="users-page">
    <!-- Page Header Section -->
    <div class="section-wrapper">
        <div class="page-header">
            <div class="page-title-group">
                <h1 class="page-title">Comptes Utilisateurs</h1>
                <p class="page-description">Gérez les accès et permissions du système pour votre personnel</p>
            </div>
            @can('create-users')
            <button class="btn btn-primary" id="btnAddUser">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

    <!-- Statistics Section -->
    <div class="section-wrapper">
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-header">
                        <div class="stat-content">
                            <div class="stat-value" data-count="{{ $users->count() ?? 0 }}">0</div>
                            <div class="stat-label">Total Comptes</div>
                        </div>
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                            <div class="stat-value" data-count="{{ $users->where('status', 'active')->count() ?? 0 }}">0</div>
                            <div class="stat-label">Comptes Actifs</div>
                        </div>
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card inactive">
                    <div class="stat-header">
                        <div class="stat-content">
                            <div class="stat-value" data-count="{{ $users->where('status', 'inactive')->count() ?? 0 }}">0</div>
                            <div class="stat-label">Comptes Inactifs</div>
                        </div>
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card no-personnel">
                    <div class="stat-header">
                        <div class="stat-content">
                            <div class="stat-value" data-count="{{ $users->filter(function($u) { return !$u->personnel; })->count() ?? 0 }}">0</div>
                            <div class="stat-label">Sans Personnel Lié</div>
                        </div>
                        <div class="stat-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar Section -->
    <div class="section-wrapper">
        <div class="toolbar-section">
            <div class="toolbar-container">
                <div class="search-box">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="search" placeholder="Rechercher par nom, email ou rôle..." id="searchInput">
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
        </div>
    </div>

    <!-- Table Section -->
    <div class="section-wrapper">
        <div class="table-section">
            <div class="table-container-wrapper">
                <div class="table-card">
                    <div class="table-container">
                        <table class="users-table">
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
                            <tbody id="usersTableBody">
                                @forelse($users ?? [] as $user)
                                <tr data-user-id="{{ $user->id }}">
                                    <td>
                                        <div class="user-cell">
                                            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=667eea&color=fff' }}" alt="Avatar" class="user-avatar">
                                            <div class="user-info">
                                                <span class="user-name">{{ $user->name ?? 'N/A' }}</span>
                                                <span class="user-email">{{ $user->email ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->personnel)
                                            <a href="{{ route('personnels.show', $user->personnel->id) }}" class="personnel-link">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                                {{ $user->personnel->matricule }} - {{ $user->personnel->nom_complet }}
                                            </a>
                                        @else
                                            <span class="no-personnel">Aucun personnel lié</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $roles = $user->getRoleNames();
                                            $roleName = $roles->first() ?? 'Aucun rôle';
                                            $roleBadge = match($roleName) {
                                                'Super Admin' => 'badge-danger',
                                                'Admin' => 'badge-primary',
                                                'Manager' => 'badge-info',
                                                'RH' => 'badge-warning',
                                                default => 'badge-success'
                                            };
                                        @endphp
                                        <span class="badge {{ $roleBadge }}">{{ $roleName }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $user->google2fa_enabled ? 'badge-success' : 'badge-danger' }}">
                                            {{ $user->google2fa_enabled ? 'Activé' : 'Désactivé' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn-icon btn-view" title="Voir les détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>
                                            <button class="btn-icon btn-edit" title="Modifier" onclick="editUser({{ $user->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                </svg>
                                            </button>
                                            <button class="btn-icon btn-delete" title="Supprimer" onclick="deleteUser({{ $user->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <svg class="empty-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="9" cy="7" r="4"></circle>
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            </svg>
                                            <h3 class="empty-title">Aucun compte utilisateur</h3>
                                            <p class="empty-description">Commencez par créer un compte pour votre personnel</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create User Account -->
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Créer un Compte Utilisateur</h2>
            <button class="modal-close" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <form id="userForm">
            @csrf
            <input type="hidden" id="userId" name="user_id">
            <div class="modal-body">
                <div class="form-group">
                    <label for="personnel_id" class="form-label required">Sélectionner le Personnel</label>
                    <select id="personnel_id" name="personnel_id" class="form-select" required>
                        <option value="">-- Choisir un employé --</option>
                        @foreach($personnels_sans_compte ?? [] as $personnel)
                        <option value="{{ $personnel->id }}"
                                data-email-suggestion="{{ strtolower(str_replace(' ', '.', $personnel->nom_complet)) }}@entreprise.com">
                            {{ $personnel->matricule }} - {{ $personnel->nom_complet }} ({{ $personnel->poste ?? 'Poste non défini' }})
                        </option>
                        @endforeach
                    </select>
                    <div class="form-error" id="errorPersonnelId"></div>
                    <small style="color: var(--text-muted); font-size: 0.875rem; margin-top: 4px; display: block;">
                        Le nom de l'employé sera utilisé automatiquement comme nom d'utilisateur
                    </small>
                </div>

                <div class="form-group">
                    <label for="userEmail" class="form-label required">Email</label>
                    <input type="email" id="userEmail" name="email" class="form-input" placeholder="email@entreprise.com" required>
                    <div class="form-error" id="errorEmail"></div>
                    <small style="color: var(--text-muted); font-size: 0.875rem; margin-top: 4px; display: block;">
                        Un mot de passe temporaire sera généré et envoyé par email
                    </small>
                </div>

                <div class="form-group">
                    <label for="userRole" class="form-label required">Rôle</label>
                    <select id="userRole" name="role" class="form-select" required>
                        <option value="">Sélectionner un rôle</option>
                        @if(auth()->user()->hasRole('Super Admin'))
                        <option value="Super Admin">Super Administrateur</option>
                        @endif
                        <option value="Admin">Administrateur</option>
                        <option value="Manager">Manager</option>
                        <option value="RH">Ressources Humaines</option>
                        <option value="Employé">Employé</option>
                    </select>
                    <div class="form-error" id="errorRole"></div>
                </div>

                <div class="form-group">
                    <label for="userStatus" class="form-label required">Statut</label>
                    <select id="userStatus" name="status" class="form-select" required>
                        <option value="active" selected>Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                    <div class="form-error" id="errorStatus"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span id="btnSubmitText">Créer le compte</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
/* Select2 Custom Styles */
.select2-container--default .select2-selection--single {
    height: 48px !important;
    border: 2px solid var(--card-border) !important;
    border-radius: 12px !important;
    background: var(--bg-secondary) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 44px !important;
    color: var(--text-primary) !important;
    padding-left: 18px !important;
}

.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: var(--text-muted) !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
}

.select2-dropdown {
    border: 2px solid #667eea !important;
    border-radius: 12px !important;
    background: var(--card-bg) !important;
    z-index: 9999 !important; /* Au-dessus du modal */
}

.select2-container--default .select2-results__option {
    color: var(--text-primary) !important;
    background: var(--card-bg) !important;
    padding: 10px 14px !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #667eea !important;
    color: #ffffff !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: rgba(102, 126, 234, 0.15) !important;
}

.select2-search--dropdown .select2-search__field {
    border: 2px solid var(--card-border) !important;
    border-radius: 8px !important;
    padding: 8px 12px !important;
    background: var(--bg-secondary) !important;
    color: var(--text-primary) !important;
}

.select2-search--dropdown .select2-search__field:focus {
    border-color: #667eea !important;
    outline: none !important;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #667eea !important;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12) !important;
}

.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #667eea !important;
}
</style>

<script>
// Animate statistics counters on page load
document.addEventListener('DOMContentLoaded', () => {
    animateStats();
    initSelect2();
});

function animateStats() {
    const statValues = document.querySelectorAll('.stat-value[data-count]');

    statValues.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-count'));
        const duration = 1500;
        const increment = target / (duration / 16);
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

// Initialize Select2
function initSelect2() {
    // Vérifier que jQuery et Select2 sont chargés
    if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') {
        console.error('jQuery ou Select2 non chargé');
        return;
    }

    // Détruire toute instance existante avant de réinitialiser
    if ($('#personnel_id').hasClass('select2-hidden-accessible')) {
        $('#personnel_id').select2('destroy');
    }

    // Initialiser Select2
    $('#personnel_id').select2({
        placeholder: 'Rechercher un employé par nom, matricule ou poste...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#userModal'), // Important pour les modaux
        language: {
            noResults: function() {
                return "Aucun employé trouvé";
            },
            searching: function() {
                return "Recherche en cours...";
            }
        }
    });

    // Fill email suggestion when personnel is selected
    $('#personnel_id').off('select2:select').on('select2:select', function(e) {
        const selectedOption = e.params.data.element;
        const emailSuggestion = selectedOption.getAttribute('data-email-suggestion');

        if (emailSuggestion) {
            document.getElementById('userEmail').value = emailSuggestion;
        }
    });

    // Clear email when selection is cleared
    $('#personnel_id').off('select2:clear').on('select2:clear', function(e) {
        document.getElementById('userEmail').value = '';
        document.getElementById('userEmail').placeholder = 'email@entreprise.com';
    });
}

// Open modal for adding user
document.getElementById('btnAddUser')?.addEventListener('click', () => {
    document.getElementById('userModal').classList.add('show');
    document.getElementById('modalTitle').textContent = 'Créer un Compte Utilisateur';
    document.getElementById('btnSubmitText').textContent = 'Créer le compte';
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';

    // Réinitialiser Select2 complètement
    if ($('#personnel_id').hasClass('select2-hidden-accessible')) {
        $('#personnel_id').val(null).trigger('change');
    } else {
        // Si Select2 n'était pas initialisé, l'initialiser maintenant
        initSelect2();
    }

    document.getElementById('userEmail').value = '';
});

// Close modal
function closeModal() {
    document.getElementById('userModal').classList.remove('show');
    document.getElementById('userForm').reset();

    // Reset Select2
    $('#personnel_id').val(null).trigger('change');
    document.getElementById('userEmail').value = '';
}

// Close modal on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal on overlay click
document.getElementById('userModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'userModal') {
        closeModal();
    }
});

// Edit user function
function editUser(userId) {
    // TODO: Implement edit user functionality
    console.log('Edit user:', userId);
}

// Delete user function
async function deleteUser(userId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce compte utilisateur?')) {
        return;
    }

    try {
        const response = await fetch(`/utilisateurs/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert('Compte utilisateur supprimé avec succès!');
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
document.getElementById('searchInput')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#usersTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Form submission
document.getElementById('userForm')?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const submitBtn = document.getElementById('btnSubmit');

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin" style="animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg> Création...';

    try {
        const response = await fetch('{{ route("utilisateurs.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            alert('Compte utilisateur créé avec succès!');
            closeModal();
            window.location.reload();
        } else {
            alert(data.message || 'Une erreur est survenue');
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Erreur de connexion au serveur');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Créer le compte';
    }
});
</script>
@endsection
