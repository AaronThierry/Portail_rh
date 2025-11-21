# Multi-Step Entreprise Modal - Flow Diagram

## Visual Flow Chart

```
┌─────────────────────────────────────────────────────────────┐
│                    MODAL OPENS                              │
│  ┌───────────────────────────────────────────────────┐     │
│  │  Premium Header (Purple Gradient)                 │     │
│  │  [Icon] Nouvelle Entreprise                       │ [X] │
│  │         Ajoutez une nouvelle entreprise partenaire│     │
│  └───────────────────────────────────────────────────┘     │
│                                                             │
│  ┌───────────────────────────────────────────────────┐     │
│  │         PROGRESS INDICATOR                        │     │
│  │  ⬤━━━━○━━━━○━━━━○                                │     │
│  │  Info Contact Loc Legal                           │     │
│  └───────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

## Step-by-Step Flow

### STEP 1: Informations de base
```
┌─────────────────────────────────────────────────────────────┐
│ ⬤━━━━○━━━━○━━━━○                                          │
│ Info Contact Loc Legal                                      │
│                                                             │
│ [Building Icon] Informations de base                       │
│ Renseignez les informations principales de l'entreprise    │
│                                                             │
│ ┌───────────────────────────────────────────────────┐      │
│ │ Nom de l'entreprise *                             │      │
│ │ [________________Full Width_____________________] │      │
│ └───────────────────────────────────────────────────┘      │
│                                                             │
│ ┌─────────────────────┐  ┌─────────────────────────┐      │
│ │ Sigle / Acronyme *  │  │ Secteur d'activité      │      │
│ │ [________50%_______]│  │ [________50%___________]│      │
│ └─────────────────────┘  └─────────────────────────┘      │
│                                                             │
│ ┌───────────────────────────────────────────────────┐      │
│ │ Description                                       │      │
│ │ [________________Full Width_____________________] │      │
│ │                                                   │      │
│ └───────────────────────────────────────────────────┘      │
│                                                             │
│ ─────────────────────────────────────────────────────      │
│              Étape 1 sur 4            [Suivant →]          │
└─────────────────────────────────────────────────────────────┘
```

**Validation Rules**:
- ✅ Nom (required)
- ✅ Sigle (required)
- ⚪ Secteur (optional)
- ⚪ Description (optional)

**Actions**:
- Click "Suivant" → Validate → Go to Step 2
- Press Enter → Same as "Suivant"

---

### STEP 2: Contact
```
┌─────────────────────────────────────────────────────────────┐
│ ✓━━━━⬤━━━━○━━━━○                                          │
│ Info Contact Loc Legal                                      │
│                                                             │
│ [Phone Icon] Coordonnées                                   │
│ Comment contacter cette entreprise                          │
│                                                             │
│ ┌─────────────────────┐  ┌─────────────────────────┐      │
│ │ E-mail *            │  │ Téléphone               │      │
│ │ [________50%_______]│  │ [________50%___________]│      │
│ └─────────────────────┘  └─────────────────────────┘      │
│                                                             │
│ ┌───────────────────────────────────────────────────┐      │
│ │ Site web                                          │      │
│ │ [________________Full Width_____________________] │      │
│ └───────────────────────────────────────────────────┘      │
│                                                             │
│ ─────────────────────────────────────────────────────      │
│ [← Retour]        Étape 2 sur 4            [Suivant →]     │
└─────────────────────────────────────────────────────────────┘
```

**Validation Rules**:
- ✅ Email (required, email format)
- ⚪ Téléphone (optional)
- ⚪ Site web (optional, URL format if filled)

**Actions**:
- Click "Retour" → Go to Step 1
- Click "Suivant" → Validate → Go to Step 3
- Click Step 1 circle → Go to Step 1

---

### STEP 3: Localisation
```
┌─────────────────────────────────────────────────────────────┐
│ ✓━━━━✓━━━━⬤━━━━○                                          │
│ Info Contact Loc Legal                                      │
│                                                             │
│ [Map Pin Icon] Localisation                                │
│ Où se trouve l'entreprise                                  │
│                                                             │
│ ┌───────────────────────────────────────────────────┐      │
│ │ Adresse                                           │      │
│ │ [________________Full Width_____________________] │      │
│ └───────────────────────────────────────────────────┘      │
│                                                             │
│ ┌─────────────────────┐  ┌─────────────────────────┐      │
│ │ Ville               │  │ Code postal             │      │
│ │ [________50%_______]│  │ [________50%___________]│      │
│ └─────────────────────┘  └─────────────────────────┘      │
│                                                             │
│ ┌───────────────────────────────────────────────────┐      │
│ │ Pays *                                            │      │
│ │ [Cameroun___________Full Width__________________] │      │
│ └───────────────────────────────────────────────────┘      │
│                                                             │
│ ─────────────────────────────────────────────────────      │
│ [← Retour]        Étape 3 sur 4            [Suivant →]     │
└─────────────────────────────────────────────────────────────┘
```

**Validation Rules**:
- ⚪ Adresse (optional)
- ⚪ Ville (optional)
- ⚪ Code postal (optional)
- ✅ Pays (required, default: "Cameroun")

**Actions**:
- Click "Retour" → Go to Step 2
- Click "Suivant" → Validate → Go to Step 4
- Click Step 1 or 2 circles → Jump back

---

### STEP 4: Informations légales
```
┌─────────────────────────────────────────────────────────────┐
│ ✓━━━━✓━━━━✓━━━━⬤                                          │
│ Info Contact Loc Legal                                      │
│                                                             │
│ [Document Icon] Informations légales                       │
│ Détails juridiques et administratifs                        │
│                                                             │
│ ┌─────────────────────┐  ┌─────────────────────────┐      │
│ │ Numéro de registre  │  │ Numéro fiscal           │      │
│ │ [________50%_______]│  │ [________50%___________]│      │
│ └─────────────────────┘  └─────────────────────────┘      │
│                                                             │
│ ┌─────────────────────┐  ┌─────────────────────────┐      │
│ │ Nombre d'employés   │  │ Statut                  │      │
│ │ [________50%_______]│  │ [◉──] Active            │      │
│ └─────────────────────┘  └─────────────────────────┘      │
│                                                             │
│ ─────────────────────────────────────────────────────      │
│ [← Retour]        Étape 4 sur 4   [✓ Créer l'entreprise]  │
└─────────────────────────────────────────────────────────────┘
```

**Validation Rules**:
- ⚪ All fields optional
- Toggle switch for active status (default: checked)

**Actions**:
- Click "Retour" → Go to Step 3
- Click "Créer l'entreprise" → Submit form
- Click any previous step circle → Jump back

---

## Progress Indicator States

### State Transitions
```
STEP 1:  ⬤━━━━○━━━━○━━━━○     (Active: Step 1)
         └─Active (Purple)

STEP 2:  ✓━━━━⬤━━━━○━━━━○     (Active: Step 2)
         └─Complete (Green)
              └─Active (Purple)

STEP 3:  ✓━━━━✓━━━━⬤━━━━○     (Active: Step 3)
         └─Complete────┘
                   └─Active (Purple)

STEP 4:  ✓━━━━✓━━━━✓━━━━⬤     (Active: Step 4)
         └─All Previous Complete
                        └─Active (Purple)
```

### Visual States
```
Pending:    ○  (Gray circle, muted icon)
Active:     ⬤  (Purple gradient, white icon, glow)
Completed:  ✓  (Green gradient, checkmark icon)
Connector:  ━  (Gray if next step pending, Green if next step completed)
```

---

## Footer Button Logic

```
┌──────────────────────────────────────────────────────┐
│ STEP 1:                                              │
│ [ Hidden ]       Étape 1 sur 4        [Suivant →]   │
└──────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────┐
│ STEP 2-3:                                            │
│ [← Retour]       Étape X sur 4        [Suivant →]   │
└──────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────┐
│ STEP 4:                                              │
│ [← Retour]       Étape 4 sur 4   [✓ Créer l'entreprise]│
└──────────────────────────────────────────────────────┘
```

---

## Validation Flow

```
User clicks "Suivant"
        ↓
   validateStep(currentStep)
        ↓
   ┌────────────────┐
   │ Get all inputs │
   │  with required │
   └────────────────┘
        ↓
   ┌────────────────────┐
   │ Check each field:  │
   │ - Empty? → Error   │
   │ - Invalid? → Error │
   │ - Valid? → Success │
   └────────────────────┘
        ↓
   ┌───────────────┐
   │  All valid?   │
   └───────────────┘
      │          │
     Yes        No
      │          │
      ↓          ↓
   nextStep()  Show errors
      ↓          & stop
   Step N+1
```

---

## Success Flow

```
Step 1 → Step 2 → Step 3 → Step 4 → Submit
  ↓        ↓        ↓        ↓        ↓
 Fill    Fill     Fill     Fill   AJAX POST
  ↓        ↓        ↓        ↓        ↓
Validate Validate Validate Optional Response
  ↓        ↓        ↓        ↓        ↓
  ✓        ✓        ✓        ✓     Success
                                      ↓
                              Show Notification
                                      ↓
                               Reload Page
                                      ↓
                              New Entreprise
```

---

## Interactive Features

### Clickable Progress Steps
```
Step on Step 3:  ✓━━━━✓━━━━⬤━━━━○
                 ↑    ↑    ↑    ↑
                 │    │    │    └─ Not clickable
                 │    │    └────── Currently active
                 │    └─────────── Clickable (go to Step 2)
                 └──────────────── Clickable (go to Step 1)
```

### Keyboard Shortcuts
```
Enter (in input)  → Next step
Enter (in textarea) → New line
Escape           → Close modal
Tab              → Next field
```

---

**Legend**:
- ⬤ Active step (purple)
- ✓ Completed step (green)
- ○ Pending step (gray)
- ━ Connector line
- * Required field
- [ ] Input field
- [Button] Action button
