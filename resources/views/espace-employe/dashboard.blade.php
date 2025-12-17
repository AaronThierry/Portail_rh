@extends('layouts.espace-employe')

@section('title', 'Mon Espace')
@section('page-title', 'Tableau de bord')
@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('styles')
<style>
/* ==================== DASHBOARD PREMIUM ==================== */
.ee-dashboard {
    display: flex;
    flex-direction: column;
    gap: 1.75rem;
}

/* ==================== WELCOME BANNER ==================== */
.ee-welcome-banner {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    border-radius: 24px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(67, 56, 202, 0.3);
}

.ee-welcome-banner::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.ee-welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: 20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(245, 158, 11, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-20px) scale(1.05); }
}

.ee-welcome-pattern {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}

.ee-welcome-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.ee-welcome-left {
    flex: 1;
}

.ee-welcome-greeting {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 0.75rem;
}

.ee-welcome-greeting .wave {
    font-size: 1.25rem;
    animation: wave 2s ease-in-out infinite;
    transform-origin: 70% 70%;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    10%, 30% { transform: rotate(14deg); }
    20% { transform: rotate(-8deg); }
    40% { transform: rotate(-4deg); }
    50%, 100% { transform: rotate(0deg); }
}

.ee-welcome-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.ee-welcome-title .highlight {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ee-welcome-subtitle {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.75);
    max-width: 400px;
    line-height: 1.6;
}

.ee-welcome-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.ee-date-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    padding: 1.5rem 2rem;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    text-align: center;
    min-width: 120px;
}

.ee-date-day {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
    background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ee-date-month {
    font-size: 0.8125rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: rgba(255, 255, 255, 0.8);
    margin-top: 0.5rem;
}

.ee-date-year {
    font-size: 0.6875rem;
    color: rgba(255, 255, 255, 0.5);
    margin-top: 0.25rem;
}

.ee-time-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(10px);
    padding: 1rem 1.25rem;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
}

.ee-time-value {
    font-size: 1.5rem;
    font-weight: 700;
    font-family: 'SF Mono', 'Roboto Mono', monospace;
    color: white;
}

.ee-time-label {
    font-size: 0.6875rem;
    color: rgba(255, 255, 255, 0.5);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 0.25rem;
}

/* ==================== STATS GRID ==================== */
.ee-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
}

.ee-stat-card {
    background: var(--ee-card);
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid var(--ee-border);
    display: flex;
    align-items: flex-start;
    gap: 1.25rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.ee-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--stat-gradient);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.ee-stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px var(--ee-shadow-lg);
}

.ee-stat-card:hover::before {
    transform: scaleX(1);
}

.ee-stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
}

.ee-stat-icon::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: inherit;
    filter: blur(12px);
    opacity: 0.4;
    z-index: -1;
}

.ee-stat-icon svg {
    width: 28px;
    height: 28px;
}

.ee-stat-icon.primary {
    background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
    color: white;
    --stat-gradient: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
}

.ee-stat-icon.success {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    --stat-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%);
}

.ee-stat-icon.warning {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
    --stat-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
}

.ee-stat-icon.info {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
    --stat-gradient: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
}

.ee-stat-card:nth-child(1) { --stat-gradient: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%); }
.ee-stat-card:nth-child(2) { --stat-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%); }
.ee-stat-card:nth-child(3) { --stat-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); }
.ee-stat-card:nth-child(4) { --stat-gradient: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); }

.ee-stat-content {
    flex: 1;
    min-width: 0;
}

.ee-stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: var(--ee-text);
    line-height: 1;
    letter-spacing: -1px;
}

.ee-stat-label {
    font-size: 0.875rem;
    color: var(--ee-text-muted);
    margin-top: 0.5rem;
    font-weight: 500;
}

.ee-stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.6875rem;
    font-weight: 700;
    margin-top: 0.75rem;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ee-stat-badge.success {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.ee-stat-badge.warning {
    background: rgba(245, 158, 11, 0.1);
    color: #D97706;
}

.ee-stat-badge.info {
    background: rgba(59, 130, 246, 0.1);
    color: #2563EB;
}

.ee-stat-badge svg {
    width: 12px;
    height: 12px;
}

/* ==================== QUICK ACTIONS ==================== */
.ee-quick-actions {
    background: var(--ee-card);
    border-radius: 24px;
    border: 1px solid var(--ee-border);
    padding: 1.75rem;
    box-shadow: 0 4px 24px var(--ee-shadow);
}

.ee-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.ee-section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ee-section-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.ee-section-title-icon svg {
    width: 20px;
    height: 20px;
}

.ee-section-title h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-section-subtitle {
    font-size: 0.8125rem;
    color: var(--ee-text-muted);
    margin-top: 0.125rem;
}

.ee-actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.ee-action-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1.75rem 1.25rem;
    background: var(--ee-bg-alt);
    border: 2px solid transparent;
    border-radius: 20px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.ee-action-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--action-gradient);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.ee-action-card:hover {
    border-color: var(--action-color);
    transform: translateY(-6px);
    box-shadow: 0 16px 40px var(--ee-shadow-lg);
}

.ee-action-card:hover::before {
    opacity: 0.05;
}

.ee-action-icon {
    width: 64px;
    height: 64px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
    transition: transform 0.4s ease;
}

.ee-action-card:hover .ee-action-icon {
    transform: scale(1.1) rotate(-3deg);
}

.ee-action-icon svg {
    width: 32px;
    height: 32px;
}

.ee-action-icon.purple {
    background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
    --action-color: #8B5CF6;
    --action-gradient: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
}

.ee-action-icon.green {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
    --action-color: #10B981;
    --action-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%);
}

.ee-action-icon.blue {
    background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
    --action-color: #3B82F6;
    --action-gradient: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
}

.ee-action-icon.orange {
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
    --action-color: #F59E0B;
    --action-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
}

.ee-action-card:nth-child(1) { --action-color: #8B5CF6; --action-gradient: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); }
.ee-action-card:nth-child(2) { --action-color: #10B981; --action-gradient: linear-gradient(135deg, #10B981 0%, #059669 100%); }
.ee-action-card:nth-child(3) { --action-color: #3B82F6; --action-gradient: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); }
.ee-action-card:nth-child(4) { --action-color: #F59E0B; --action-gradient: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); }

.ee-action-text {
    text-align: center;
    position: relative;
    z-index: 1;
}

.ee-action-label {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
    margin-bottom: 0.25rem;
}

.ee-action-desc {
    font-size: 0.75rem;
    color: var(--ee-text-muted);
}

/* ==================== MAIN GRID ==================== */
.ee-main-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 1.5rem;
}

/* ==================== ACTIVITIES CARD ==================== */
.ee-activities-card {
    background: var(--ee-card);
    border-radius: 24px;
    border: 1px solid var(--ee-border);
    padding: 1.75rem;
    box-shadow: 0 4px 24px var(--ee-shadow);
}

.ee-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
}

.ee-card-title-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.ee-card-title-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.ee-card-title-icon svg {
    width: 20px;
    height: 20px;
}

.ee-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--ee-text);
}

.ee-card-link {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--ee-primary);
    text-decoration: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    background: var(--ee-primary-light);
    transition: all 0.3s ease;
}

.ee-card-link:hover {
    background: var(--ee-primary);
    color: white;
}

.ee-card-link svg {
    width: 16px;
    height: 16px;
}

.ee-activity-list {
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

.ee-activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--ee-bg-alt);
    border-radius: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid transparent;
    cursor: pointer;
}

.ee-activity-item:hover {
    transform: translateX(8px);
    border-color: var(--ee-border);
    box-shadow: 0 8px 24px var(--ee-shadow);
}

.ee-activity-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ee-activity-icon.file {
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
    color: var(--ee-primary);
}

.ee-activity-icon.calendar {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: var(--ee-success);
}

.ee-activity-icon.user {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: var(--ee-warning);
}

.ee-activity-icon svg {
    width: 24px;
    height: 24px;
}

.ee-activity-content {
    flex: 1;
    min-width: 0;
}

.ee-activity-title {
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--ee-text);
    margin-bottom: 0.25rem;
}

.ee-activity-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.ee-activity-date {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.75rem;
    color: var(--ee-text-muted);
}

.ee-activity-date svg {
    width: 12px;
    height: 12px;
}

.ee-activity-badge {
    font-size: 0.625rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.25rem 0.625rem;
    border-radius: 6px;
}

.ee-activity-badge.new {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.ee-empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--ee-text-muted);
}

.ee-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1rem;
    background: var(--ee-bg-alt);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ee-empty-icon svg {
    width: 32px;
    height: 32px;
    opacity: 0.5;
}

.ee-empty-text {
    font-size: 0.9375rem;
    font-weight: 500;
}

/* ==================== PROFILE CARD ==================== */
.ee-profile-card {
    background: var(--ee-card);
    border-radius: 24px;
    border: 1px solid var(--ee-border);
    overflow: hidden;
    box-shadow: 0 4px 24px var(--ee-shadow);
}

.ee-profile-header {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.ee-profile-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.ee-profile-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(139, 92, 246, 0.3) 0%, transparent 70%);
    border-radius: 50%;
}

.ee-profile-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
    z-index: 1;
}

.ee-profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.25);
    object-fit: cover;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.ee-profile-avatar:hover {
    transform: scale(1.05);
    border-color: rgba(255, 255, 255, 0.4);
}

.ee-profile-status {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 20px;
    height: 20px;
    background: #22c55e;
    border: 3px solid #312e81;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(34, 197, 94, 0.5);
}

.ee-profile-name {
    font-size: 1.375rem;
    font-weight: 700;
    color: white;
    position: relative;
    z-index: 1;
    margin-bottom: 0.25rem;
}

.ee-profile-role {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    position: relative;
    z-index: 1;
    margin-bottom: 0.75rem;
}

.ee-profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.6875rem;
    font-weight: 700;
    color: white;
    background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    position: relative;
    z-index: 1;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.ee-profile-badge svg {
    width: 12px;
    height: 12px;
}

.ee-profile-body {
    padding: 1.5rem;
}

.ee-profile-info {
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

.ee-info-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--ee-bg-alt);
    border-radius: 14px;
    transition: all 0.3s ease;
}

.ee-info-item:hover {
    background: var(--ee-primary-light);
}

.ee-info-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--ee-card);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ee-primary);
    flex-shrink: 0;
    box-shadow: 0 2px 8px var(--ee-shadow);
}

.ee-info-icon svg {
    width: 20px;
    height: 20px;
}

.ee-info-content {
    flex: 1;
    min-width: 0;
}

.ee-info-label {
    font-size: 0.6875rem;
    color: var(--ee-text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ee-info-value {
    font-size: 0.875rem;
    color: var(--ee-text);
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 0.125rem;
}

.ee-profile-footer {
    padding: 0 1.5rem 1.5rem;
}

.ee-profile-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 0.9375rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
}

.ee-profile-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(99, 102, 241, 0.35);
}

.ee-profile-btn svg {
    width: 18px;
    height: 18px;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1280px) {
    .ee-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ee-main-grid {
        grid-template-columns: 1fr;
    }

    .ee-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .ee-welcome-content {
        flex-direction: column;
        text-align: center;
    }

    .ee-welcome-subtitle {
        max-width: 100%;
    }

    .ee-welcome-right {
        flex-direction: column;
        width: 100%;
    }

    .ee-date-card {
        width: 100%;
    }

    .ee-stats-grid {
        grid-template-columns: 1fr;
    }

    .ee-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .ee-welcome-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .ee-actions-grid {
        grid-template-columns: 1fr;
    }

    .ee-welcome-banner {
        padding: 1.5rem;
    }

    .ee-stat-card {
        padding: 1.25rem;
    }

    .ee-stat-value {
        font-size: 1.5rem;
    }
}
</style>
@endsection

@section('content')
<div class="ee-dashboard">
    <!-- Welcome Banner -->
    <div class="ee-welcome-banner animate-fade-in">
        <div class="ee-welcome-pattern"></div>
        <div class="ee-welcome-content">
            <div class="ee-welcome-left">
                <div class="ee-welcome-greeting">
                    <span class="wave">👋</span>
                    <span>Bienvenue dans votre espace</span>
                </div>
                <h2 class="ee-welcome-title">
                    Bonjour, <span class="highlight">{{ $personnel ? $personnel->prenoms : auth()->user()->name }}</span> !
                </h2>
                <p class="ee-welcome-subtitle">
                    Consultez vos informations personnelles, vos documents et gerez vos demandes en toute simplicite.
                </p>
            </div>
            <div class="ee-welcome-right">
                <div class="ee-date-card">
                    <span class="ee-date-day">{{ now()->format('d') }}</span>
                    <span class="ee-date-month">{{ now()->translatedFormat('F') }}</span>
                    <span class="ee-date-year">{{ now()->format('Y') }}</span>
                </div>
                <div class="ee-time-card">
                    <div class="ee-time-value" id="currentTime">--:--</div>
                    <div class="ee-time-label">Heure actuelle</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="ee-stats-grid">
        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.1s;">
            <div class="ee-stat-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['documents'] }}</div>
                <div class="ee-stat-label">Documents disponibles</div>
                <span class="ee-stat-badge info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    </svg>
                    Dossier actif
                </span>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.2s;">
            <div class="ee-stat-icon success">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['conges_restants'] }}</div>
                <div class="ee-stat-label">Jours de conges</div>
                <span class="ee-stat-badge success">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Disponibles
                </span>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.3s;">
            <div class="ee-stat-icon warning">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['demandes_en_cours'] }}</div>
                <div class="ee-stat-label">Demandes en cours</div>
                <span class="ee-stat-badge warning">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    En attente
                </span>
            </div>
        </div>

        <div class="ee-stat-card animate-fade-in" style="animation-delay: 0.4s;">
            <div class="ee-stat-icon info">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div class="ee-stat-content">
                <div class="ee-stat-value">{{ $stats['anciennete'] }}</div>
                <div class="ee-stat-label">Annees d'anciennete</div>
                <span class="ee-stat-badge info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                    Fidelite
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="ee-quick-actions animate-fade-in" style="animation-delay: 0.5s;">
        <div class="ee-section-header">
            <div class="ee-section-title">
                <div class="ee-section-title-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <div>
                    <h3>Actions rapides</h3>
                    <div class="ee-section-subtitle">Acces direct a vos services</div>
                </div>
            </div>
        </div>
        <div class="ee-actions-grid">
            <a href="{{ route('espace-employe.conges') }}" class="ee-action-card">
                <div class="ee-action-icon purple">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                        <path d="M9 16h6"></path>
                    </svg>
                </div>
                <div class="ee-action-text">
                    <div class="ee-action-label">Demander un conge</div>
                    <div class="ee-action-desc">Poser une demande</div>
                </div>
            </a>
            <a href="{{ route('espace-employe.attestations') }}" class="ee-action-card">
                <div class="ee-action-icon green">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M9 15l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ee-action-text">
                    <div class="ee-action-label">Attestations</div>
                    <div class="ee-action-desc">Travail, salaire...</div>
                </div>
            </a>
            <a href="{{ route('espace-employe.bulletins') }}" class="ee-action-card">
                <div class="ee-action-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div class="ee-action-text">
                    <div class="ee-action-label">Bulletins de paie</div>
                    <div class="ee-action-desc">Consulter mes fiches</div>
                </div>
            </a>
            <a href="{{ route('espace-employe.profil') }}" class="ee-action-card">
                <div class="ee-action-icon orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="ee-action-text">
                    <div class="ee-action-label">Mon profil</div>
                    <div class="ee-action-desc">Modifier mes infos</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="ee-main-grid">
        <!-- Activities -->
        <div class="ee-activities-card animate-fade-in" style="animation-delay: 0.6s;">
            <div class="ee-card-header">
                <div class="ee-card-title-group">
                    <div class="ee-card-title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                    <h3 class="ee-card-title">Activites recentes</h3>
                </div>
                <a href="{{ route('espace-employe.documents') }}" class="ee-card-link">
                    Voir tout
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
            <div class="ee-activity-list">
                @forelse($activities as $activity)
                    <div class="ee-activity-item">
                        <div class="ee-activity-icon {{ $activity['icon'] }}">
                            @if($activity['icon'] === 'file')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @elseif($activity['icon'] === 'calendar')
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            @endif
                        </div>
                        <div class="ee-activity-content">
                            <div class="ee-activity-title">{{ $activity['title'] }}</div>
                            <div class="ee-activity-meta">
                                <span class="ee-activity-date">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    {{ $activity['date']->diffForHumans() }}
                                </span>
                                @if($activity['date']->isToday())
                                    <span class="ee-activity-badge new">Nouveau</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ee-empty-state">
                        <div class="ee-empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                        </div>
                        <div class="ee-empty-text">Aucune activite recente</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Card -->
        <div class="ee-profile-card animate-fade-in" style="animation-delay: 0.7s;">
            <div class="ee-profile-header">
                <div class="ee-profile-avatar-wrapper">
                    <img src="{{ $personnel && $personnel->photo ? asset('storage/' . $personnel->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($personnel ? $personnel->nom . ' ' . $personnel->prenoms : auth()->user()->name) . '&size=200&background=6366F1&color=fff&bold=true' }}"
                         alt="Photo"
                         class="ee-profile-avatar"
                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=200&background=6366F1&color=fff&bold=true'">
                    <span class="ee-profile-status"></span>
                </div>
                <div class="ee-profile-name">{{ $personnel ? $personnel->nom_complet : auth()->user()->name }}</div>
                <div class="ee-profile-role">{{ $personnel ? $personnel->poste : 'Employe' }}</div>
                @if($personnel && $personnel->matricule)
                    <span class="ee-profile-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                        </svg>
                        {{ $personnel->matricule }}
                    </span>
                @endif
            </div>
            <div class="ee-profile-body">
                <div class="ee-profile-info">
                    @if($personnel)
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Departement</div>
                                <div class="ee-info-value">{{ $personnel->departement->nom ?? 'Non assigne' }}</div>
                            </div>
                        </div>
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Service</div>
                                <div class="ee-info-value">{{ $personnel->service->nom ?? 'Non assigne' }}</div>
                            </div>
                        </div>
                        <div class="ee-info-item">
                            <div class="ee-info-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <div class="ee-info-content">
                                <div class="ee-info-label">Date d'embauche</div>
                                <div class="ee-info-value">{{ $personnel->date_embauche ? $personnel->date_embauche->format('d/m/Y') : 'Non renseignee' }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="ee-info-item">
                        <div class="ee-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="ee-info-content">
                            <div class="ee-info-label">Email</div>
                            <div class="ee-info-value">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ee-profile-footer">
                <a href="{{ route('espace-employe.profil') }}" class="ee-profile-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Voir mon profil complet
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('currentTime').textContent = `${hours}:${minutes}`;
    }

    updateTime();
    setInterval(updateTime, 1000);
</script>
@endsection
