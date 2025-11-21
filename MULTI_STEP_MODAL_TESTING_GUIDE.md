# Multi-Step Entreprise Modal - Testing Guide

## Quick Test Checklist

### 1. Visual Design Testing ✓
- [ ] Modal header has purple gradient (#667eea to #764ba2)
- [ ] Header icon has glassmorphism effect (backdrop blur)
- [ ] Close button rotates 90° on hover
- [ ] Progress indicator shows 4 steps with icons
- [ ] Active step has purple gradient and scale animation
- [ ] Completed steps show green gradient with checkmark
- [ ] Footer has 3 sections: Back | Step indicator | Next/Submit

### 2. Step 1 - Informations de base
**Required Fields**:
- [ ] Nom de l'entreprise (required, shows error if empty)
- [ ] Sigle (required, shows error if empty)

**Optional Fields**:
- [ ] Secteur d'activité
- [ ] Description (textarea)

**Test Cases**:
1. Try clicking "Suivant" with empty nom → Should show error
2. Fill nom only → Should show error for sigle
3. Fill both nom and sigle → Should advance to Step 2
4. Press Enter in nom field → Should advance if valid

### 3. Step 2 - Contact
**Required Fields**:
- [ ] Email (required, email format validation)

**Optional Fields**:
- [ ] Téléphone
- [ ] Site web (URL validation if filled)

**Test Cases**:
1. Try "test@" → Should show "Format d'email invalide"
2. Try valid email → Should remove error, add green border
3. Try site_web "google.com" → Should show "doit commencer par http://"
4. Try site_web "https://google.com" → Should validate successfully
5. Click back button → Should return to Step 1 with data preserved

### 4. Step 3 - Localisation
**Required Fields**:
- [ ] Pays (required, default "Cameroun")

**Optional Fields**:
- [ ] Adresse
- [ ] Ville
- [ ] Code postal

**Test Cases**:
1. Leave pays field → Should auto-fill "Cameroun"
2. Clear pays field and advance → Should show error
3. Fill pays → Should advance to Step 4

### 5. Step 4 - Informations légales
**All Optional**:
- [ ] Numéro de registre
- [ ] Numéro fiscal
- [ ] Nombre d'employés
- [ ] Statut (toggle switch)

**Test Cases**:
1. Toggle statut switch → Should animate smoothly
2. Check "Suivant" button changed to "Créer l'entreprise"
3. Submit form → Should show loading state
4. Success → Should show green notification

### 6. Progress Indicator Testing
**Test Navigation**:
- [ ] Click Step 1 circle when on Step 2 → Should go back to Step 1
- [ ] Click Step 3 circle when on Step 2 → Should do nothing (disabled)
- [ ] Hover over completed steps → Should show hover effect
- [ ] Hover over future steps → Should show not-allowed cursor

**Visual States**:
- [ ] Step 1 pending: Gray circle, muted icon
- [ ] Step 1 active: Purple gradient, white icon, scale animation
- [ ] Step 1 completed: Green gradient, checkmark icon
- [ ] Connector between completed steps → Should be green
- [ ] Connector to future steps → Should be gray

### 7. Footer Navigation Testing
**Step 1**:
- [ ] Back button is hidden
- [ ] Step indicator shows "Étape 1 sur 4"
- [ ] Next button visible with gradient

**Step 2-3**:
- [ ] Back button visible
- [ ] Step indicator updates correctly
- [ ] Next button visible

**Step 4**:
- [ ] Back button visible
- [ ] Step indicator shows "Étape 4 sur 4"
- [ ] Submit button visible (not Next)
- [ ] Submit button text: "Créer l'entreprise"

### 8. Keyboard Navigation Testing
- [ ] Press Escape → Modal closes
- [ ] Press Enter in input field → Advances to next step
- [ ] Press Enter in textarea → Creates new line (doesn't advance)
- [ ] Tab between fields → Works normally

### 9. Validation Testing
**Required Field Validation**:
- [ ] Empty required field → Red border + error message
- [ ] Fill required field → Green border, error cleared
- [ ] Try to advance with errors → Blocked with visual feedback

**Email Validation**:
- [ ] "test" → Invalid
- [ ] "test@" → Invalid
- [ ] "test@domain" → Invalid
- [ ] "test@domain.com" → Valid

**URL Validation**:
- [ ] "google.com" → Invalid
- [ ] "www.google.com" → Invalid
- [ ] "http://google.com" → Valid
- [ ] "https://google.com" → Valid

### 10. Responsive Design Testing
**Desktop (> 1024px)**:
- [ ] Footer: Back | Indicator | Next (horizontal)
- [ ] Progress circles: 52px diameter
- [ ] Step labels visible
- [ ] Form grid: 2 columns

**Tablet (768px - 1024px)**:
- [ ] Layout adapts smoothly
- [ ] Buttons remain visible

**Mobile (< 768px)**:
- [ ] Footer stacks vertically
- [ ] Step indicator at top
- [ ] Progress circles: 44px diameter
- [ ] Form grid: 1 column
- [ ] All buttons full-width

### 11. Animation Testing
**Modal Open**:
- [ ] Smooth slide-in animation
- [ ] Background overlay fades in

**Step Transitions**:
- [ ] Content fades in from right
- [ ] Progress indicator animates smoothly
- [ ] No layout shifts

**Button Hovers**:
- [ ] Next button: Gradient shine effect
- [ ] Back button: Background color change
- [ ] Close button: Rotation animation
- [ ] Progress circles: Scale up on hover

### 12. Data Persistence Testing
**Navigate Between Steps**:
1. Fill Step 1 completely
2. Go to Step 2
3. Click back to Step 1
- [ ] All Step 1 data should be preserved
4. Fill Step 2 and Step 3
5. Go back to Step 1
- [ ] All data from all steps preserved

### 13. Form Submission Testing
**Create Mode**:
- [ ] Fill all 4 steps with valid data
- [ ] Click "Créer l'entreprise"
- [ ] Button shows loading spinner
- [ ] Success notification appears
- [ ] Page reloads with new entreprise

**Edit Mode**:
- [ ] Click edit on existing entreprise
- [ ] All fields pre-filled
- [ ] Can navigate through steps
- [ ] Data preserved
- [ ] Submit button says "Enregistrer les modifications"

### 14. Error Handling Testing
- [ ] Server validation errors display correctly
- [ ] Network errors handled gracefully
- [ ] Modal can be closed during submission
- [ ] Form reset works after error

### 15. Dark Mode Testing
- [ ] Header gradient adapts to dark mode
- [ ] Progress indicators readable
- [ ] Form inputs have proper contrast
- [ ] Buttons maintain visibility
- [ ] Error messages readable

## Test URLs
- **Create**: Click "Nouvelle Entreprise" button
- **Edit**: Click edit icon on any entreprise card/row

## Expected Behavior Summary

### Success Flow
1. Open modal → Step 1 shown
2. Fill required fields → Green borders
3. Click Next → Step 2 shown, Step 1 marked complete
4. Continue through steps → Progress updates
5. Step 4 submit → Loading state → Success notification

### Error Flow
1. Open modal → Step 1 shown
2. Click Next without filling → Red errors shown
3. Fill partially → Errors remain on empty fields
4. Fill all required → Can advance
5. Invalid email/URL → Specific error messages

### Navigation Flow
1. Can go back to any previous step
2. Can click completed progress circles
3. Cannot skip ahead to future steps
4. Data preserved when navigating
5. Escape closes modal anytime

## Browser Testing Matrix
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

## Performance Checks
- [ ] Modal opens in < 300ms
- [ ] Step transitions smooth (60fps)
- [ ] No layout shifts
- [ ] No console errors
- [ ] Form submission < 2s

## Accessibility Checks
- [ ] Keyboard navigation works
- [ ] Focus visible on inputs
- [ ] Error messages announced
- [ ] Close button has ARIA label
- [ ] High contrast mode works

---

## Quick Test Commands

```bash
# Check for JavaScript errors
# Open browser console and look for errors when:
- Opening modal
- Navigating steps
- Submitting form
- Closing modal

# Test responsive design
# Resize browser window to:
- 1920px (desktop)
- 1024px (tablet)
- 768px (small tablet)
- 375px (mobile)
```

## Status Indicators
✅ **Pass**: Feature works as expected
⚠️ **Warning**: Works but needs improvement
❌ **Fail**: Feature broken or doesn't work
🔄 **In Progress**: Currently testing

---

**Last Updated**: Multi-step modal implementation complete
**Tested By**: Ready for QA team
**Priority**: High - New feature for entreprise management
