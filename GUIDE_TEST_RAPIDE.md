# 🧪 GUIDE DE TEST RAPIDE

## 🎯 Objectif
Tester rapidement les 4 fonctionnalités principales du module Personnel.

---

## ✅ TEST 1: Création de Compte Utilisateur

### Étapes:
1. Aller sur `/personnels` → Cliquer sur un personnel **SANS compte utilisateur**
2. Dans la section "Compte Utilisateur", cliquer sur **"Créer un Compte Utilisateur"**
3. Vérifier que:
   - ✅ La modal s'ouvre
   - ✅ L'email est pré-rempli avec l'email du personnel
   - ✅ Le champ "Mot de passe" est visible
4. **Cliquer DANS le champ email** → La modal doit **RESTER OUVERTE** ✅
5. **Cliquer sur un rôle** (ex: "Employé") → La modal doit **RESTER OUVERTE** ✅
6. Remplir le formulaire:
   - Sélectionner au moins 1 rôle
   - Entrer un mot de passe
   - Laisser "Compte actif" coché
7. Cliquer **"Créer le Compte"**
8. Vérifier le message de succès avec format Unicode:
```
╔═══════════════════════════════════════════╗
║   ✅ COMPTE UTILISATEUR CRÉÉ AVEC SUCCÈS   ║
╚═══════════════════════════════════════════╝
```
9. Vérifier que la section "Compte Utilisateur" affiche maintenant:
   - ✅ Email du compte
   - ✅ Rôle(s) en badges bleus
   - ✅ Statut "Actif" en vert
   - ✅ Boutons "Modifier les Rôles" et "Dissocier le Compte"

### ❌ Ce qui NE doit PAS arriver:
- La modal se ferme en cliquant dans les champs
- Les champs Rôle(s) ou Statut restent vides après création
- Aucun message de succès

### 🐛 Debugging:
- Ouvrir DevTools (F12) → Console
- Chercher les logs:
```
═══════════════════════════════════════
✅ CRÉATION COMPTE RÉUSSIE
📦 Réponse complète: {...}
```

---

## ✅ TEST 2: Dissociation de Compte

### Étapes:
1. Sur la page d'un personnel **AVEC compte utilisateur**
2. Cliquer **"Dissocier le Compte"**
3. Lire le message de confirmation:
```
╔══════════════════════════════════════╗
║   ⚠️ CONFIRMATION DE DISSOCIATION   ║
╚══════════════════════════════════════╝
```
4. Cliquer **OK**
5. Vérifier:
   - ✅ Le bouton affiche "Dissociation en cours..." avec loader animé
   - ✅ Le bouton est désactivé (grisé)
6. Après 1-2 secondes:
   - ✅ Message de succès s'affiche
   - ✅ La section "Compte Utilisateur" affiche "Ce personnel n'a pas de compte utilisateur"
   - ✅ Bouton "Créer un Compte Utilisateur" est visible

### ❌ Ce qui NE doit PAS arriver:
- Le bouton reste bloqué sur "Dissociation en cours..."
- La page ne se met pas à jour
- Erreur JavaScript dans la console

### 🐛 Debugging:
```javascript
console.log('🔓 DISSOCIATION COMPTE');
console.log('✅ Dissociation réussie');
```

---

## ✅ TEST 3: Modification Personnel

### Étapes:
1. Sur la page détails d'un personnel
2. Cliquer le bouton **"Modifier"** (en haut à droite)
3. Vérifier que la modal s'ouvre avec:
   - ✅ **Tous les champs pré-remplis** (nom, prénom, email, etc.)
   - ✅ Département sélectionné
   - ✅ Service sélectionné (si département a des services)
   - ✅ Checkbox "Personnel actif" cochée/décochée selon l'état
4. **Cliquer dans un champ** → Modal doit **RESTER OUVERTE** ✅
5. Modifier quelques champs:
   - Changer le nom
   - Changer le département
   - Vérifier que la liste des services se met à jour automatiquement
   - Sélectionner un nouveau service
6. Cliquer **"Enregistrer les Modifications"**
7. Vérifier:
   - ✅ Message de succès professionnel
   - ✅ Modal se ferme
   - ✅ Page se recharge (0.5s après)
   - ✅ Les modifications sont visibles

### 🧪 Test Selects en Cascade:
1. Dans la modal d'édition, changer le département
2. Vérifier que:
   - ✅ La liste des services se vide
   - ✅ Nouveaux services apparaissent automatiquement
   - ✅ Premier service est "Sélectionner un service"

### ❌ Ce qui NE doit PAS arriver:
- Formulaire vide ou partiellement rempli
- Services ne se chargent pas après changement de département
- Modal se ferme en cliquant dans les champs

### 🐛 Debugging:
```javascript
console.log('📝 OUVERTURE MODALE ÉDITION PERSONNEL');
console.log('👤 Données personnel:', {...});
console.log('✅ Formulaire pré-rempli');
console.log('🔄 Chargement des services du département 2...');
console.log('✅ 3 service(s) trouvé(s)');
```

---

## ✅ TEST 4: Modal - Pas de Fermeture Accidentelle

### Test Complet des Interactions:

#### A. Modal Création Compte
1. Ouvrir modal "Créer un Compte Utilisateur"
2. Tester tous ces clics (modal doit **RESTER OUVERTE**):
   - ✅ Clic dans champ Email
   - ✅ Clic dans champ Mot de passe
   - ✅ Clic sur checkbox "Compte actif"
   - ✅ Clic sur un label de rôle
   - ✅ Clic sur un checkbox de rôle
   - ✅ Clic sur le titre de la modal
   - ✅ Clic sur le formulaire (fond blanc)
3. Tester fermetures (modal doit **SE FERMER**):
   - ✅ Clic sur bouton X (haut droite)
   - ✅ Clic sur bouton "Annuler"
   - ✅ Clic sur fond gris (overlay)
   - ✅ Touche Escape

#### B. Modal Édition Personnel
1. Ouvrir modal "Modifier le Personnel"
2. Tester tous ces clics (modal doit **RESTER OUVERTE**):
   - ✅ Clic dans champ Nom
   - ✅ Clic dans champ Téléphone
   - ✅ Clic sur select Département
   - ✅ Clic sur select Service
   - ✅ Clic sur une option de select
   - ✅ Clic sur section "Informations Personnelles"
   - ✅ Clic sur section "Informations Professionnelles"
3. Tester fermetures (modal doit **SE FERMER**):
   - ✅ Clic sur bouton X
   - ✅ Clic sur bouton "Annuler"
   - ✅ Clic sur overlay
   - ✅ Touche Escape

### 🐛 Debugging:
Ouvrir Console (F12) et chercher:
```
🛡️ Clic sur contenu modale - propagation bloquée
🖱️ Clic sur overlay - fermeture modale édition
```

---

## 📊 CHECKLIST FINALE

Après tous les tests:

- [ ] ✅ Création compte: Email pré-rempli
- [ ] ✅ Création compte: Rôles et Statut affichés
- [ ] ✅ Création compte: Messages professionnels
- [ ] ✅ Dissociation: Bouton ne reste pas bloqué
- [ ] ✅ Dissociation: UI mise à jour sans reload
- [ ] ✅ Modification: Formulaire pré-rempli
- [ ] ✅ Modification: Selects en cascade fonctionnent
- [ ] ✅ Modification: Modifications enregistrées
- [ ] ✅ Modals: Ne se ferment PAS en cliquant champs
- [ ] ✅ Modals: SE ferment avec X/Annuler/Overlay/Escape
- [ ] ✅ Console: Aucune erreur JavaScript
- [ ] ✅ Console: Logs détaillés présents

---

## 🚨 EN CAS DE PROBLÈME

### Problème 1: Modal ne s'ouvre pas
```javascript
// Console DevTools
Uncaught ReferenceError: editPersonnel is not defined
```
**Solution**: Vérifier que le JavaScript est bien chargé (regarder fin du fichier `show.blade.php`)

---

### Problème 2: Champs vides après création compte
```javascript
// Console DevTools
❌ ERREUR CRITIQUE: Aucun objet user
```
**Solution**:
1. Vérifier route `/personnels/{id}/assign-user` fonctionne
2. Vérifier que le controller retourne bien `user` avec `roles`

---

### Problème 3: Services ne se chargent pas
```javascript
// Console DevTools
❌ Erreur chargement services: 404
```
**Solution**:
1. Vérifier route `/personnels/services/{departementId}`
2. Vérifier méthode `getServicesByDepartement()` dans controller
3. Tester directement dans le navigateur: `/personnels/services/1`

---

### Problème 4: Modal se ferme accidentellement
```javascript
// Console DevTools
🖱️ Clic sur overlay - fermeture modale édition
```
**Solution**:
1. Vérifier présence de `stopPropagation()` sur `#editPersonnelModalContent`
2. Vérifier que le clic n'est pas sur l'overlay directement
3. Regarder les logs console pour comprendre le flow

---

### Problème 5: Bouton dissociation bloqué
**Symptôme**: Bouton reste sur "Dissociation en cours..." indéfiniment

**Solution**:
1. Ouvrir Console → Network
2. Regarder la requête POST vers `/personnels/{id}/detach-user`
3. Vérifier le status code (200 = OK, 500 = erreur serveur)
4. Regarder la réponse JSON
5. Vérifier les logs Laravel: `storage/logs/laravel.log`

---

## 🎯 RÉSULTAT ATTENDU

**TOUS les tests ci-dessus doivent passer ✅**

Si un seul test échoue, consulter:
- Les logs console (F12)
- Le fichier `IMPLEMENTATION_COMPLETE_RESUME.md`
- Les documentations techniques dans le dossier racine

---

*Guide de test rapide - Portail RH*
*Durée estimée: 10-15 minutes*
