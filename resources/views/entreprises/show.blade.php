@extends('layouts.app')

@section('title', $entreprise->nom)
@section('page-title', $entreprise->nom)
@section('page-subtitle', $entreprise->sigle ?? 'Profil entreprise')
@section('page-icon')
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
</svg>
@endsection

@section('content')
<style>
/* =============================================
   WORLD-CLASS ENTERPRISE PROFILE
   Premium Design System
   ============================================= */

/* CSS Variables - Premium Color Palette */
:root {
    --wc-bg: #0a0a0b;
    --wc-surface: #141416;
    --wc-surface-2: #1a1a1d;
    --wc-surface-3: #222225;
    --wc-border: rgba(255, 255, 255, 0.08);
    --wc-border-hover: rgba(255, 255, 255, 0.15);
    --wc-text: #ffffff;
    --wc-text-secondary: rgba(255, 255, 255, 0.6);
    --wc-text-tertiary: rgba(255, 255, 255, 0.4);
    --wc-accent: #6366f1;
    --wc-accent-glow: rgba(99, 102, 241, 0.4);
    --wc-gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --wc-gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --wc-gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --wc-gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --wc-success: #10b981;
    --wc-warning: #f59e0b;
    --wc-danger: #ef4444;
    --wc-info: #3b82f6;
}

/* Light Mode Variables */
.wc-light {
    --wc-bg: #f8fafc;
    --wc-surface: #ffffff;
    --wc-surface-2: #f1f5f9;
    --wc-surface-3: #e2e8f0;
    --wc-border: rgba(0, 0, 0, 0.08);
    --wc-border-hover: rgba(0, 0, 0, 0.15);
    --wc-text: #0f172a;
    --wc-text-secondary: rgba(15, 23, 42, 0.7);
    --wc-text-tertiary: rgba(15, 23, 42, 0.5);
}

/* Animations */
@keyframes wc-fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes wc-scaleIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes wc-slideRight {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes wc-glow {
    0%, 100% { box-shadow: 0 0 20px var(--wc-accent-glow); }
    50% { box-shadow: 0 0 40px var(--wc-accent-glow), 0 0 60px var(--wc-accent-glow); }
}

@keyframes wc-gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes wc-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

@keyframes wc-pulse-ring {
    0% { transform: scale(0.8); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

@keyframes wc-shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* Base Container */
.wc-enterprise {
    min-height: 100vh;
    animation: wc-fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

/* =============================================
   HERO SECTION - Glassmorphism Design
   ============================================= */
.wc-hero {
    position: relative;
    margin: -24px -24px 32px -24px;
    padding: 0;
    overflow: hidden;
}

.wc-hero-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    overflow: hidden;
}

.wc-hero-bg::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
    animation: wc-gradient-shift 15s ease infinite;
    background-size: 200% 200%;
}

.wc-hero-bg::after {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.wc-hero-content {
    position: relative;
    padding: 48px 48px 40px;
    z-index: 1;
}

/* Breadcrumb */
.wc-breadcrumb {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 32px;
    font-size: 0.875rem;
}

.wc-breadcrumb a {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.5);
    text-decoration: none;
    padding: 8px 14px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.wc-breadcrumb a:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.wc-breadcrumb svg {
    width: 16px;
    height: 16px;
}

.wc-breadcrumb-sep {
    color: rgba(255, 255, 255, 0.3);
}

.wc-breadcrumb-current {
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

/* Hero Main */
.wc-hero-main {
    display: flex;
    align-items: flex-start;
    gap: 32px;
}

/* Company Avatar */
.wc-avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.wc-avatar {
    width: 140px;
    height: 140px;
    border-radius: 28px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    animation: wc-scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
}

.wc-avatar::before {
    content: '';
    position: absolute;
    inset: -2px;
    background: var(--wc-gradient-1);
    border-radius: 30px;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s;
}

.wc-avatar:hover::before {
    opacity: 1;
}

.wc-avatar img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 16px;
    filter: brightness(1.1);
}

.wc-avatar-placeholder {
    font-size: 3rem;
    font-weight: 800;
    background: var(--wc-gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-transform: uppercase;
    letter-spacing: -1px;
}

.wc-avatar-ring {
    position: absolute;
    inset: -8px;
    border: 2px solid rgba(99, 102, 241, 0.3);
    border-radius: 32px;
    animation: wc-pulse-ring 2s cubic-bezier(0.16, 1, 0.3, 1) infinite;
}

/* Hero Info */
.wc-hero-info {
    flex: 1;
    min-width: 0;
    animation: wc-slideRight 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
}

.wc-company-name {
    font-size: 2.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 12px 0;
    letter-spacing: -1px;
    line-height: 1.1;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

.wc-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 50px;
    font-size: 0.8125rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.wc-status.active {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.wc-status.inactive {
    background: rgba(239, 68, 68, 0.15);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.wc-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
    position: relative;
}

.wc-status.active .wc-status-dot::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: currentColor;
    opacity: 0.4;
    animation: wc-pulse-ring 1.5s ease-out infinite;
}

.wc-tagline {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.wc-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    font-weight: 500;
    backdrop-filter: blur(10px);
    transition: all 0.3s;
}

.wc-tag:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.wc-tag svg {
    width: 18px;
    height: 18px;
    opacity: 0.7;
}

/* Hero Actions */
.wc-hero-actions {
    display: flex;
    gap: 12px;
    margin-left: auto;
    flex-shrink: 0;
    animation: wc-scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
}

.wc-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 24px;
    border-radius: 14px;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: none;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}

.wc-btn svg {
    width: 18px;
    height: 18px;
}

.wc-btn-primary {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: #fff;
    box-shadow: 0 8px 32px rgba(99, 102, 241, 0.35);
}

.wc-btn-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
    opacity: 0;
    transition: opacity 0.3s;
}

.wc-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 40px rgba(99, 102, 241, 0.5);
}

.wc-btn-primary:hover::before {
    opacity: 1;
}

.wc-btn-primary span,
.wc-btn-primary svg {
    position: relative;
    z-index: 1;
}

.wc-btn-glass {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
}

.wc-btn-glass:hover {
    background: rgba(255, 255, 255, 0.18);
    border-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-3px);
}

/* =============================================
   STATS SECTION - Bento Grid Style
   ============================================= */
.wc-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}

.wc-stat {
    background: var(--wc-surface);
    border: 1px solid var(--wc-border);
    border-radius: 20px;
    padding: 28px;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    animation: wc-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.wc-stat:nth-child(1) { animation-delay: 0.1s; }
.wc-stat:nth-child(2) { animation-delay: 0.15s; }
.wc-stat:nth-child(3) { animation-delay: 0.2s; }
.wc-stat:nth-child(4) { animation-delay: 0.25s; }

.wc-stat::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    border-radius: 20px 20px 0 0;
    opacity: 0;
    transition: opacity 0.3s;
}

.wc-stat:hover {
    transform: translateY(-6px);
    border-color: var(--wc-border-hover);
    box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
}

.wc-stat:hover::before {
    opacity: 1;
}

.wc-stat.blue::before { background: var(--wc-gradient-3); }
.wc-stat.green::before { background: var(--wc-gradient-4); }
.wc-stat.purple::before { background: var(--wc-gradient-1); }
.wc-stat.orange::before { background: var(--wc-gradient-2); }

.wc-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    position: relative;
}

.wc-stat.blue .wc-stat-icon {
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.15) 100%);
    color: #4facfe;
}
.wc-stat.green .wc-stat-icon {
    background: linear-gradient(135deg, rgba(67, 233, 123, 0.15) 0%, rgba(56, 249, 215, 0.15) 100%);
    color: #43e97b;
}
.wc-stat.purple .wc-stat-icon {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    color: #667eea;
}
.wc-stat.orange .wc-stat-icon {
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.15) 0%, rgba(245, 87, 108, 0.15) 100%);
    color: #f093fb;
}

.wc-stat-icon svg {
    width: 28px;
    height: 28px;
}

.wc-stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--wc-text);
    line-height: 1;
    margin-bottom: 8px;
    letter-spacing: -1px;
}

.wc-stat-label {
    font-size: 0.875rem;
    color: var(--wc-text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* =============================================
   MAIN LAYOUT - Asymmetric Grid
   ============================================= */
.wc-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 28px;
    align-items: start;
}

/* =============================================
   CARDS - Premium Glass Effect
   ============================================= */
.wc-card {
    background: var(--wc-surface);
    border: 1px solid var(--wc-border);
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 28px;
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    animation: wc-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) backwards;
}

.wc-card:hover {
    border-color: var(--wc-border-hover);
    box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.2);
}

.wc-card-header {
    padding: 24px 28px;
    border-bottom: 1px solid var(--wc-border);
    display: flex;
    align-items: center;
    gap: 16px;
}

.wc-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.wc-card-icon svg {
    width: 24px;
    height: 24px;
    color: var(--wc-accent);
}

.wc-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--wc-text);
    letter-spacing: -0.25px;
}

.wc-card-body {
    padding: 28px;
}

/* =============================================
   INFO GRID - Modern List Design
   ============================================= */
.wc-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

.wc-info-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    padding: 18px;
    background: var(--wc-surface-2);
    border-radius: 16px;
    border: 1px solid transparent;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.wc-info-item:hover {
    background: var(--wc-surface-3);
    border-color: var(--wc-border);
    transform: translateX(4px);
}

.wc-info-item.full {
    grid-column: span 2;
}

.wc-info-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--wc-surface-3);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.wc-info-icon svg {
    width: 20px;
    height: 20px;
    color: var(--wc-text-secondary);
}

.wc-info-icon.accent {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
}

.wc-info-icon.accent svg {
    color: var(--wc-accent);
}

.wc-info-icon.success {
    background: rgba(16, 185, 129, 0.1);
}

.wc-info-icon.success svg {
    color: var(--wc-success);
}

.wc-info-icon.info {
    background: rgba(59, 130, 246, 0.1);
}

.wc-info-icon.info svg {
    color: var(--wc-info);
}

.wc-info-content {
    flex: 1;
    min-width: 0;
}

.wc-info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.75px;
    color: var(--wc-text-tertiary);
    margin-bottom: 6px;
    font-weight: 600;
}

.wc-info-value {
    font-size: 0.9375rem;
    color: var(--wc-text);
    font-weight: 600;
    word-break: break-word;
}

.wc-info-value.highlight {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.wc-info-value a {
    color: var(--wc-accent);
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.wc-info-value a:hover {
    color: #8b5cf6;
}

.wc-info-value a::after {
    content: '→';
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.2s;
}

.wc-info-value a:hover::after {
    opacity: 1;
    transform: translateX(0);
}

/* =============================================
   SIDEBAR - Floating Design
   ============================================= */
.wc-sidebar {
    position: sticky;
    top: 24px;
}

/* Quick Actions */
.wc-actions-card {
    background: var(--wc-surface);
    border: 1px solid var(--wc-border);
    border-radius: 24px;
    padding: 24px;
    margin-bottom: 28px;
    animation: wc-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.3s backwards;
}

.wc-actions-title {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--wc-text-tertiary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 18px;
    padding-left: 4px;
}

.wc-action {
    display: flex;
    align-items: center;
    gap: 14px;
    width: 100%;
    padding: 16px 18px;
    border-radius: 14px;
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid transparent;
    text-decoration: none;
    color: var(--wc-text-secondary);
    background: var(--wc-surface-2);
    margin-bottom: 10px;
    position: relative;
    overflow: hidden;
}

.wc-action:last-child {
    margin-bottom: 0;
}

.wc-action::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--wc-gradient-1);
    transform: scaleY(0);
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}

.wc-action:hover {
    background: var(--wc-surface-3);
    color: var(--wc-text);
    transform: translateX(4px);
    border-color: var(--wc-border);
}

.wc-action:hover::before {
    transform: scaleY(1);
}

.wc-action svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.wc-action-arrow {
    margin-left: auto;
    opacity: 0;
    transform: translateX(-8px);
    transition: all 0.3s;
}

.wc-action:hover .wc-action-arrow {
    opacity: 1;
    transform: translateX(0);
}

/* Activity Timeline */
.wc-timeline-card {
    background: var(--wc-surface);
    border: 1px solid var(--wc-border);
    border-radius: 24px;
    overflow: hidden;
    animation: wc-fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) 0.35s backwards;
}

.wc-timeline-header {
    padding: 22px 24px;
    border-bottom: 1px solid var(--wc-border);
    font-size: 0.9375rem;
    font-weight: 700;
    color: var(--wc-text);
    display: flex;
    align-items: center;
    gap: 10px;
}

.wc-timeline-header svg {
    width: 18px;
    height: 18px;
    color: var(--wc-accent);
}

.wc-timeline-body {
    padding: 24px;
}

.wc-timeline-item {
    display: flex;
    gap: 16px;
    position: relative;
    padding-bottom: 24px;
}

.wc-timeline-item:last-child {
    padding-bottom: 0;
}

.wc-timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 44px;
    bottom: 0;
    width: 2px;
    background: linear-gradient(180deg, var(--wc-border) 0%, transparent 100%);
}

.wc-timeline-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}

.wc-timeline-icon.created {
    background: rgba(16, 185, 129, 0.12);
    color: var(--wc-success);
}

.wc-timeline-icon.updated {
    background: rgba(59, 130, 246, 0.12);
    color: var(--wc-info);
}

.wc-timeline-icon svg {
    width: 18px;
    height: 18px;
}

.wc-timeline-content {
    flex: 1;
    padding-top: 2px;
}

.wc-timeline-text {
    font-size: 0.9375rem;
    color: var(--wc-text);
    font-weight: 500;
    margin-bottom: 4px;
}

.wc-timeline-date {
    font-size: 0.8125rem;
    color: var(--wc-text-tertiary);
}

/* =============================================
   RESPONSIVE DESIGN
   ============================================= */
@media (max-width: 1280px) {
    .wc-layout {
        grid-template-columns: 1fr 360px;
    }
}

@media (max-width: 1100px) {
    .wc-layout {
        grid-template-columns: 1fr;
    }

    .wc-sidebar {
        position: static;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .wc-actions-card,
    .wc-timeline-card {
        margin-bottom: 0;
    }
}

@media (max-width: 900px) {
    .wc-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .wc-hero-content {
        padding: 32px;
    }

    .wc-hero-main {
        flex-direction: column;
        text-align: center;
    }

    .wc-hero-actions {
        margin: 20px auto 0;
    }

    .wc-tagline {
        justify-content: center;
    }

    .wc-company-name {
        justify-content: center;
        font-size: 2rem;
    }
}

@media (max-width: 700px) {
    .wc-sidebar {
        grid-template-columns: 1fr;
    }

    .wc-info-grid {
        grid-template-columns: 1fr;
    }

    .wc-info-item.full {
        grid-column: span 1;
    }

    .wc-stats {
        grid-template-columns: 1fr;
    }

    .wc-hero-content {
        padding: 24px;
    }

    .wc-avatar {
        width: 100px;
        height: 100px;
        border-radius: 20px;
    }

    .wc-company-name {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 12px;
    }

    .wc-hero-actions {
        flex-direction: column;
        width: 100%;
    }

    .wc-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<div class="wc-enterprise wc-light">
    <!-- Hero Section -->
    <div class="wc-hero">
        <div class="wc-hero-bg"></div>
        <div class="wc-hero-content">
            <!-- Breadcrumb -->
            <nav class="wc-breadcrumb">
                <a href="{{ route('admin.entreprises.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                    </svg>
                    Entreprises
                </a>
                <span class="wc-breadcrumb-sep">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </span>
                <span class="wc-breadcrumb-current">{{ $entreprise->nom }}</span>
            </nav>

            <!-- Hero Main -->
            <div class="wc-hero-main">
                <!-- Avatar -->
                <div class="wc-avatar-wrap">
                    <div class="wc-avatar">
                        @if($entreprise->logo)
                            <img src="{{ asset($entreprise->logo) }}" alt="{{ $entreprise->nom }}">
                        @else
                            <span class="wc-avatar-placeholder">{{ strtoupper(substr($entreprise->nom, 0, 2)) }}</span>
                        @endif
                    </div>
                    <div class="wc-avatar-ring"></div>
                </div>

                <!-- Info -->
                <div class="wc-hero-info">
                    <h1 class="wc-company-name">
                        {{ $entreprise->nom }}
                        <span class="wc-status {{ $entreprise->is_active ? 'active' : 'inactive' }}">
                            <span class="wc-status-dot"></span>
                            {{ $entreprise->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </h1>
                    <div class="wc-tagline">
                        @if($entreprise->sigle)
                        <span class="wc-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            {{ $entreprise->sigle }}
                        </span>
                        @endif
                        @if($entreprise->secteur_activite)
                        <span class="wc-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                            </svg>
                            {{ $entreprise->secteur_activite }}
                        </span>
                        @endif
                        @if($entreprise->ville)
                        <span class="wc-tag">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            {{ $entreprise->ville }}, {{ $entreprise->pays ?? 'Burkina Faso' }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="wc-hero-actions">
                    <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="wc-btn wc-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        <span>Modifier</span>
                    </a>
                    <a href="{{ route('admin.entreprises.index') }}" class="wc-btn wc-btn-glass">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        <span>Retour</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="wc-stats">
        <div class="wc-stat blue">
            <div class="wc-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 010 7.75"></path>
                </svg>
            </div>
            <div class="wc-stat-value">{{ $entreprise->utilisateurs->count() }}</div>
            <div class="wc-stat-label">Utilisateurs</div>
        </div>

        <div class="wc-stat green">
            <div class="wc-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="wc-stat-value">{{ $entreprise->departements->count() }}</div>
            <div class="wc-stat-label">Départements</div>
        </div>

        <div class="wc-stat purple">
            <div class="wc-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                </svg>
            </div>
            <div class="wc-stat-value">{{ $entreprise->services->count() }}</div>
            <div class="wc-stat-label">Services</div>
        </div>

        <div class="wc-stat orange">
            <div class="wc-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20V10"></path>
                    <path d="M18 20V4"></path>
                    <path d="M6 20v-4"></path>
                </svg>
            </div>
            <div class="wc-stat-value">{{ $entreprise->nombre_employes ?? 0 }}</div>
            <div class="wc-stat-label">Employés</div>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="wc-layout">
        <!-- Main Content -->
        <div class="wc-main">
            <!-- Informations générales -->
            <div class="wc-card" style="animation-delay: 0.1s;">
                <div class="wc-card-header">
                    <div class="wc-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="16" x2="12" y2="12"></line>
                            <line x1="12" y1="8" x2="12.01" y2="8"></line>
                        </svg>
                    </div>
                    <h2 class="wc-card-title">Informations générales</h2>
                </div>
                <div class="wc-card-body">
                    <div class="wc-info-grid">
                        <div class="wc-info-item">
                            <div class="wc-info-icon accent">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Raison sociale</div>
                                <div class="wc-info-value highlight">{{ $entreprise->nom }}</div>
                            </div>
                        </div>

                        @if($entreprise->sigle)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="4 7 4 4 20 4 20 7"></polyline>
                                    <line x1="9" y1="20" x2="15" y2="20"></line>
                                    <line x1="12" y1="4" x2="12" y2="20"></line>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Sigle / Acronyme</div>
                                <div class="wc-info-value">{{ $entreprise->sigle }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->secteur_activite)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Secteur d'activité</div>
                                <div class="wc-info-value">{{ $entreprise->secteur_activite }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->nombre_employes)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 010 7.75"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Effectif déclaré</div>
                                <div class="wc-info-value">{{ $entreprise->nombre_employes }} employés</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->description)
                        <div class="wc-info-item full">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="17" y1="10" x2="3" y2="10"></line>
                                    <line x1="21" y1="6" x2="3" y2="6"></line>
                                    <line x1="21" y1="14" x2="3" y2="14"></line>
                                    <line x1="17" y1="18" x2="3" y2="18"></line>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Description</div>
                                <div class="wc-info-value">{{ $entreprise->description }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Coordonnées -->
            <div class="wc-card" style="animation-delay: 0.15s;">
                <div class="wc-card-header">
                    <div class="wc-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                        </svg>
                    </div>
                    <h2 class="wc-card-title">Coordonnées</h2>
                </div>
                <div class="wc-card-body">
                    <div class="wc-info-grid">
                        <div class="wc-info-item">
                            <div class="wc-info-icon info">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Email</div>
                                <div class="wc-info-value">
                                    <a href="mailto:{{ $entreprise->email }}">{{ $entreprise->email }}</a>
                                </div>
                            </div>
                        </div>

                        @if($entreprise->telephone)
                        <div class="wc-info-item">
                            <div class="wc-info-icon success">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Téléphone</div>
                                <div class="wc-info-value">
                                    <a href="tel:{{ $entreprise->telephone }}">{{ $entreprise->telephone }}</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->site_web)
                        <div class="wc-info-item full">
                            <div class="wc-info-icon accent">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Site web</div>
                                <div class="wc-info-value">
                                    <a href="{{ $entreprise->site_web }}" target="_blank">{{ $entreprise->site_web }}</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Localisation -->
            <div class="wc-card" style="animation-delay: 0.2s;">
                <div class="wc-card-header">
                    <div class="wc-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                    </div>
                    <h2 class="wc-card-title">Localisation</h2>
                </div>
                <div class="wc-card-body">
                    <div class="wc-info-grid">
                        @if($entreprise->adresse)
                        <div class="wc-info-item full">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Adresse complète</div>
                                <div class="wc-info-value">{{ $entreprise->adresse }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->quartier)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon>
                                    <line x1="8" y1="2" x2="8" y2="18"></line>
                                    <line x1="16" y1="6" x2="16" y2="22"></line>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Quartier</div>
                                <div class="wc-info-value">{{ $entreprise->quartier }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->ville)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Ville</div>
                                <div class="wc-info-value">{{ $entreprise->ville }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->code_postal)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="M6 8h.01M10 8h.01M14 8h.01M18 8h.01M6 12h.01M10 12h.01M14 12h.01M18 12h.01M6 16h.01M10 16h.01M14 16h.01"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Code postal</div>
                                <div class="wc-info-value">{{ $entreprise->code_postal }}</div>
                            </div>
                        </div>
                        @endif

                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Pays</div>
                                <div class="wc-info-value">{{ $entreprise->pays ?? 'Burkina Faso' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations légales -->
            @if($entreprise->numero_registre || $entreprise->numero_fiscal || $entreprise->numero_cnss)
            <div class="wc-card" style="animation-delay: 0.25s;">
                <div class="wc-card-header">
                    <div class="wc-card-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                        </svg>
                    </div>
                    <h2 class="wc-card-title">Informations légales</h2>
                </div>
                <div class="wc-card-body">
                    <div class="wc-info-grid">
                        @if($entreprise->numero_registre)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">N° Registre de commerce</div>
                                <div class="wc-info-value">{{ $entreprise->numero_registre }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->numero_fiscal)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">Identifiant Fiscal (IFU)</div>
                                <div class="wc-info-value">{{ $entreprise->numero_fiscal }}</div>
                            </div>
                        </div>
                        @endif

                        @if($entreprise->numero_cnss)
                        <div class="wc-info-item">
                            <div class="wc-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                            <div class="wc-info-content">
                                <div class="wc-info-label">N° CNSS</div>
                                <div class="wc-info-value">{{ $entreprise->numero_cnss }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="wc-sidebar">
            <!-- Quick Actions -->
            <div class="wc-actions-card">
                <h3 class="wc-actions-title">Actions rapides</h3>
                <a href="{{ route('admin.entreprises.edit', $entreprise) }}" class="wc-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Modifier l'entreprise
                    <svg class="wc-action-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="{{ route('admin.departements.index') }}" class="wc-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                    </svg>
                    Gérer les départements
                    <svg class="wc-action-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="{{ route('admin.services.index') }}" class="wc-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                        <path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path>
                    </svg>
                    Gérer les services
                    <svg class="wc-action-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
                <a href="{{ route('admin.utilisateurs.index') }}" class="wc-action">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 010 7.75"></path>
                    </svg>
                    Gérer les utilisateurs
                    <svg class="wc-action-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </div>

            <!-- Activity Timeline -->
            <div class="wc-timeline-card">
                <div class="wc-timeline-header">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    Activité récente
                </div>
                <div class="wc-timeline-body">
                    <div class="wc-timeline-item">
                        <div class="wc-timeline-icon created">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                        </div>
                        <div class="wc-timeline-content">
                            <div class="wc-timeline-text">Entreprise créée</div>
                            <div class="wc-timeline-date">{{ $entreprise->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                    @if($entreprise->updated_at && $entreprise->updated_at != $entreprise->created_at)
                    <div class="wc-timeline-item">
                        <div class="wc-timeline-icon updated">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                        <div class="wc-timeline-content">
                            <div class="wc-timeline-text">Dernière modification</div>
                            <div class="wc-timeline-date">{{ $entreprise->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
