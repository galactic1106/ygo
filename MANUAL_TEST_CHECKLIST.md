# Manual Testing Checklist

Use this checklist to verify all form fields work correctly in the browser.

## Prerequisites
- [ ] Navigate to `/cards` (Browse page)
- [ ] Open browser console (F12) to check for errors
- [ ] Clear any existing filters

---

## 🧪 Individual Field Tests

### Test 1: Card Name (Fuzzy Search)
- [ ] Enter "blue" in the "Card Name" field
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show cards with "blue" in the name
- [ ] **Expected:** Form keeps "blue" in the field after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 2: Card ID
- [ ] Clear the form (refresh page)
- [ ] Enter "46986414" in the "Card ID" field
- [ ] Click "Search Cards"
- [ ] **Expected:** Shows only "Dark Magician"
- [ ] **Expected:** Form keeps the ID after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 3: Type Filter
- [ ] Clear the form (refresh page)
- [ ] Select "Spell Card" from the Type dropdown
- [ ] Click "Search Cards"
- [ ] **Expected:** All results are Spell Cards
- [ ] **Expected:** "Spell Card" remains selected after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 4: Race Filter
- [ ] Clear the form
- [ ] Select "Dragon" from the Race dropdown
- [ ] Click "Search Cards"
- [ ] **Expected:** All results are Dragon-type
- [ ] **Expected:** "Dragon" remains selected after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 5: Attribute Filter
- [ ] Clear the form
- [ ] Select "DARK" from the Attribute dropdown
- [ ] Click "Search Cards"
- [ ] **Expected:** All results have DARK attribute
- [ ] **Expected:** "DARK" remains selected after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 6: ATK Value
- [ ] Clear the form
- [ ] Enter "3000" in the ATK field
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show cards with 3000 ATK
- [ ] **Expected:** "3000" remains in field after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 7: DEF Value
- [ ] Clear the form
- [ ] Enter "2500" in the DEF field
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show cards with 2500 DEF
- [ ] **Expected:** "2500" remains in field after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 8: Level
- [ ] Clear the form
- [ ] Enter "8" in the Level field
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show Level 8 monsters
- [ ] **Expected:** "8" remains in field after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 9: Link Value
- [ ] Clear the form
- [ ] Enter "4" in the Link Value field
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show Link-4 monsters
- [ ] **Expected:** "4" remains in field after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 10: Archetype
- [ ] Clear the form
- [ ] Select "Blue-Eyes" from the Archetype dropdown
- [ ] Click "Search Cards"
- [ ] **Expected:** Results show Blue-Eyes archetype cards
- [ ] **Expected:** "Blue-Eyes" remains selected after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 11: Frame Type
- [ ] Clear the form
- [ ] Select a frame type from the dropdown (e.g., "xyz")
- [ ] Click "Search Cards"
- [ ] **Expected:** Results match the selected frame type
- [ ] **Expected:** Selection remains after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 12: Results Per Page
- [ ] Clear the form
- [ ] Enter "dragon" in Card Name
- [ ] Select "10" from Results Per Page dropdown
- [ ] Click "Search Cards"
- [ ] **Expected:** Shows exactly 10 cards
- [ ] **Expected:** Both fields remain filled after search
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 🔄 Pagination Tests

### Test 13: Next Button
- [ ] Perform a search that returns multiple pages (e.g., "dragon" with 20 per page)
- [ ] Verify pagination controls appear below results
- [ ] Click "Next" button
- [ ] **Expected:** Shows next page of results (cards 21-40)
- [ ] **Expected:** Previous button becomes enabled
- [ ] **Expected:** Form still shows original search criteria
- [ ] **Expected:** URL updates with offset parameter
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 14: Previous Button
- [ ] From page 2 or higher, click "Previous" button
- [ ] **Expected:** Returns to previous page
- [ ] **Expected:** Form still shows original search criteria
- [ ] **Expected:** URL offset decreases
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 15: Previous Button Disabled on First Page
- [ ] Navigate to first page of results
- [ ] **Expected:** Previous button is disabled/grayed out
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 16: Next Button Disabled on Last Page
- [ ] Navigate to last page of results (or search for something with few results)
- [ ] **Expected:** Next button is disabled/grayed out
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 17: Page Counter Display
- [ ] Perform a multi-page search
- [ ] **Expected:** Shows "Showing X of Y cards (Page Z of W)"
- [ ] Click Next
- [ ] **Expected:** Page number increments correctly
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 18: Change Results Per Page During Pagination
- [ ] Perform a search, navigate to page 2
- [ ] Change "Results Per Page" from 20 to 50
- [ ] Click "Search Cards"
- [ ] **Expected:** Returns to page 1 with 50 results
- [ ] **Expected:** Total pages recalculated
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 🎯 Combined Filter Tests

### Test 19: Multiple Filters Together
- [ ] Clear the form
- [ ] Enter "dragon" in Card Name
- [ ] Select "Effect Monster" from Type
- [ ] Select "DARK" from Attribute
- [ ] Enter "4" in Level
- [ ] Click "Search Cards"
- [ ] **Expected:** All results match ALL criteria
- [ ] **Expected:** All form fields retain their values
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 20: Modify Existing Search
- [ ] Perform a search with one filter
- [ ] Add another filter to the form
- [ ] Click "Search Cards" again
- [ ] **Expected:** Results update with both filters
- [ ] **Expected:** Both filters remain in form
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 🔗 URL and Browser Navigation Tests

### Test 21: Direct URL Access
- [ ] Copy URL from an active search (e.g., `/cards?fname=blue&num=20`)
- [ ] Open in new tab or refresh
- [ ] **Expected:** Form pre-populates with values from URL
- [ ] **Expected:** Results display immediately
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 22: Browser Back Button
- [ ] Perform search A
- [ ] Perform search B (different criteria)
- [ ] Click browser Back button
- [ ] **Expected:** Returns to search A with correct form values
- [ ] **Expected:** Shows search A results
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 23: Browser Forward Button
- [ ] After using Back button (test 22)
- [ ] Click browser Forward button
- [ ] **Expected:** Returns to search B with correct form values
- [ ] **Expected:** Shows search B results
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 24: Shareable URLs
- [ ] Perform a search with multiple filters
- [ ] Copy URL from address bar
- [ ] Share with someone or open in incognito window
- [ ] **Expected:** Same results and form state appear
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## ⚠️ Edge Case Tests

### Test 25: Empty Search
- [ ] Clear all form fields
- [ ] Click "Search Cards"
- [ ] **Expected:** No results shown (or "perform a search" message)
- [ ] **Expected:** No errors in console
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 26: No Results Found
- [ ] Enter "zzznonexistentcard99999" in Card Name
- [ ] Click "Search Cards"
- [ ] **Expected:** "No cards found" message appears
- [ ] **Expected:** No pagination controls shown
- [ ] **Expected:** Form keeps the search term
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 27: Single Page Results
- [ ] Search for something with < 20 results (e.g., "Exodia")
- [ ] **Expected:** Results display normally
- [ ] **Expected:** No pagination controls appear
- [ ] **Expected:** Shows "Showing X of X cards" (no page indicator)
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 28: Very Large Page Size
- [ ] Perform a search
- [ ] Select "100" from Results Per Page
- [ ] Click "Search Cards"
- [ ] **Expected:** Shows up to 100 results
- [ ] **Expected:** Page loads reasonably fast
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 🎨 UI/UX Tests

### Test 29: Card Clicking
- [ ] Click on any card in the results
- [ ] **Expected:** Navigate to card detail page
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 30: Form Validation Messages
- [ ] Try entering invalid data (e.g., negative number, text in number field)
- [ ] **Expected:** Validation messages appear
- [ ] **Expected:** Form doesn't submit with invalid data
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 31: Dropdown Population
- [ ] Check all dropdown fields
- [ ] **Expected:** All dropdowns have options populated
- [ ] **Expected:** No empty dropdowns
- [ ] **Expected:** Options are readable (not IDs or codes)
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 32: Responsive Layout
- [ ] Resize browser window to mobile size
- [ ] **Expected:** Form remains usable
- [ ] **Expected:** Results display properly
- [ ] **Expected:** Pagination controls accessible
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 🐛 Error Testing

### Test 33: Console Errors
- [ ] Open browser console (F12)
- [ ] Perform various searches and navigation
- [ ] **Expected:** No JavaScript errors appear
- [ ] **Expected:** No warning messages about missing props/data
- [ ] **Status:** ⬜ Pass / ⬜ Fail

### Test 34: Network Tab
- [ ] Open Network tab in dev tools
- [ ] Perform a search
- [ ] **Expected:** API requests complete successfully (200 status)
- [ ] **Expected:** No failed requests
- [ ] **Status:** ⬜ Pass / ⬜ Fail

---

## 📊 Results Summary

Total Tests: 34

- **Passed:** _____
- **Failed:** _____
- **Not Tested:** _____

---

## 🚨 Issues Found

Document any issues here:

| Test # | Issue Description | Severity | Notes |
|--------|-------------------|----------|-------|
|        |                   |          |       |
|        |                   |          |       |
|        |                   |          |       |

---

## ✅ Final Sign-Off

- [ ] All critical tests passed
- [ ] No console errors
- [ ] Form persistence working
- [ ] Pagination functional
- [ ] Ready for production use

**Tested By:** _______________  
**Date:** _______________  
**Browser:** _______________  
**Result:** ⬜ PASS / ⬜ FAIL

---

## Quick Test Commands

```bash
# Navigate to test URL
http://localhost/cards

# Example test URLs
/cards?fname=blue
/cards?type=Spell%20Card&num=20
/cards?fname=dragon&attribute=DARK&level=8
/cards?fname=blue&num=10&offset=10
```
