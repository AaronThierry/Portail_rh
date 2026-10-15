{{-- Pied de page admin — Direction B --}}
<footer class="ft-root" id="appFooter">
    <span>&copy; {{ date('Y') }} Portail RH<b>+</b> · RHPLUS SARL</span>
    <nav aria-label="Liens du pied de page">
        <a href="/mentions-legales">Mentions légales</a>
        <a href="/confidentialite">Confidentialité</a>
        <a href="/support">Support</a>
    </nav>
</footer>

<style>
.ft-root {
    display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px 20px;
    padding: 16px 32px 20px; border-top: 1px solid var(--line-soft);
    font: 400 13px var(--font); color: var(--muted);
}
.ft-root b { color: var(--orange); }
.ft-root nav { display: flex; flex-wrap: wrap; gap: 4px 18px; }
.ft-root a { color: var(--muted); text-decoration: none; }
.ft-root a:hover { color: var(--ink); text-decoration: underline; }
@media (max-width: 1024px) { .ft-root { padding: 16px; } }
@media print { .ft-root { display: none; } }
</style>
