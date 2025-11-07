# Guide de Design - Portail RH

## Vue d'ensemble

Le Portail RH utilise un design moderne et professionnel avec une interface utilisateur fluide et intuitive. Ce guide explique les fonctionnalités principales du système de design.

---

## 🎨 Caractéristiques Principales

### 1. **Sidebar Intelligent avec Auto-Hover**

#### Desktop (> 1024px)
- **État par défaut** : Sidebar réduite (70px de largeur) affichant uniquement les icônes
- **Au survol** : La sidebar s'étend automatiquement à 280px et affiche les textes
- **Tooltips** : Les labels apparaissent au survol des icônes quand la sidebar est réduite
- **Transition fluide** : Animation douce de 0.4s avec courbe de Bézier personnalisée

#### Mobile (≤ 1024px)
- **État par défaut** : Sidebar cachée hors écran
- **Menu burger** : Un seul bouton dans le header pour ouvrir/fermer
- **Overlay** : Fond semi-transparent cliquable pour fermer le menu
- **Pleine largeur** : Sidebar prend 280px de largeur quand ouverte

### 2. **Contenu Pleine Largeur**

- Le contenu principal s'adapte automatiquement à la largeur disponible
- **Desktop** : Marge gauche de 70px (sidebar réduite)
- **Mobile** : Pas de marge, contenu en pleine largeur
- **Responsive** : S'adapte dynamiquement à tous les écrans

### 3. **Header Moderne**

- **Effet glassmorphism** : Arrière-plan semi-transparent avec backdrop-filter
- **Titre avec gradient** : Le titre de page utilise un dégradé de couleurs
- **Actions utilisateur** : Notifications, thème, et profil utilisateur
- **Position sticky** : Reste visible en scrollant

### 4. **Footer Harmonisé**

- **Design cohérent** : Même style que le header avec glassmorphism
- **Liens interactifs** : Soulignement animé au survol
- **Badge de version** : Affichage de la version de l'application
- **Responsive** : S'adapte sur mobile en colonne

---

## 🎯 Fonctionnalités UX

### Navigation

#### Desktop
1. **Hover automatique** : Le menu se déplie au survol
2. **Tooltips intelligents** : Affichés uniquement quand le sidebar est réduit
3. **Sous-menus** : S'ouvrent en accordéon au clic
4. **État actif** : Mise en évidence du lien actuel

#### Mobile
1. **Bouton burger unique** : Animation hamburger → X
2. **Fermeture automatique** : Au clic sur un lien
3. **Touche Escape** : Ferme le menu
4. **Scroll bloqué** : Empêche le scroll de la page quand le menu est ouvert

### Interactions

- **Animations d'icônes** : Effet de scale au clic
- **Feedback haptique** : Vibration légère sur mobile (si supporté)
- **Transitions douces** : Toutes les interactions sont fluides
- **Focus visible** : États de focus clairs pour l'accessibilité

---

## 🎨 Système de Couleurs

### Light Mode
- **Primary** : `#6366f1` (Indigo)
- **Primary Hover** : `#4f46e5`
- **Primary Dark** : `#4338ca`
- **Background** : `#f9fafb` (Gray 50)
- **Sidebar** : `#ffffff` (White)
- **Text** : `#4b5563` (Gray 600)

### Dark Mode
- **Primary** : `#818cf8` (Lighter Indigo)
- **Background** : `#111827` (Gray 900)
- **Sidebar** : `#1f2937` (Gray 800)
- **Text** : `#d1d5db` (Gray 300)

---

## 📐 Dimensions

- **Sidebar réduite** : `70px`
- **Sidebar étendue** : `280px`
- **Header** : `70px`
- **Footer** : `64px`

---

## ⚡ Performance

### Optimisations
- **Transitions CSS** : Utilisation de `transform` pour de meilleures performances
- **Debouncing** : Sur les événements de resize
- **RequestAnimationFrame** : Pour les événements de scroll
- **Will-change** : Propriété CSS pour optimiser les animations

### Accessibilité
- **Focus visible** : États de focus clairs pour la navigation au clavier
- **ARIA labels** : Sur tous les boutons interactifs
- **Reduced motion** : Respect des préférences utilisateur
- **Touch targets** : Taille minimale de 44px sur mobile

---

## 🔧 Variables CSS

Toutes les couleurs, dimensions et transitions sont définies dans les variables CSS pour une personnalisation facile :

```css
:root {
    --sidebar-width-expanded: 280px;
    --sidebar-width-collapsed: 70px;
    --header-height: 70px;
    --footer-height: 64px;
    --primary: #6366f1;
    --transition-smooth: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
```

---

## 📱 Breakpoints Responsive

- **Desktop** : `> 1024px` - Sidebar avec auto-hover
- **Tablet/Mobile** : `≤ 1024px` - Sidebar mobile avec burger menu
- **Small Mobile** : `≤ 640px` - Adaptations supplémentaires pour petits écrans

---

## 🚀 Utilisation

### Pour les développeurs

1. **Modifier les couleurs** : Éditer les variables CSS dans `sidebar.css`
2. **Ajuster les dimensions** : Modifier les variables de largeur/hauteur
3. **Personnaliser les transitions** : Ajuster les valeurs de `transition`

### Pour ajouter un nouveau lien

```html
<div class="nav-item">
    <a href="/route" class="nav-link" data-tooltip="Nom du lien">
        <svg class="nav-icon"><!-- Icône SVG --></svg>
        <span class="nav-text">Nom du lien</span>
    </a>
</div>
```

Le `data-tooltip` est obligatoire pour afficher le tooltip en mode desktop réduit.

---

## ✨ Animations Incluses

1. **fadeIn** : Apparition douce des éléments
2. **slideIn** : Entrée latérale des items de navigation
3. **fadeInContent** : Animation de chargement du contenu
4. **Hover effects** : Scale, translation, et changements de couleur

---

## 🎯 Bonnes Pratiques

### Design
- ✅ Utiliser les variables CSS pour la cohérence
- ✅ Respecter la hiérarchie visuelle
- ✅ Maintenir des espacements cohérents
- ✅ Tester sur différents appareils

### Code
- ✅ Utiliser les classes utilitaires existantes
- ✅ Éviter les styles inline
- ✅ Optimiser les performances
- ✅ Maintenir l'accessibilité

---

## 🐛 Dépannage

### Le sidebar ne se déplie pas au survol
- Vérifier que vous êtes en mode desktop (> 1024px)
- Vérifier que le CSS `sidebar.css` est bien chargé

### Le bouton burger ne fonctionne pas
- Vérifier que `app.js` est bien chargé
- Vérifier les IDs : `sidebar`, `mobileMenuButton`, `sidebarOverlay`

### Les tooltips ne s'affichent pas
- Vérifier que l'attribut `data-tooltip` est présent sur les liens
- Vérifier que vous êtes en mode desktop

---

## 📞 Support

Pour toute question ou problème, veuillez consulter la documentation complète ou contacter l'équipe de développement.

---

**Version** : 1.0.0
**Dernière mise à jour** : Novembre 2025
**Auteur** : Équipe Portail RH
