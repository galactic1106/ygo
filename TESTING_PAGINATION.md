# Testing Guide: Pagination Feature

## Quick Start Testing

### 1. Basic Pagination Test

**URL:** `/cards?fname=blue&num=10`

**Expected Results:**
- Shows first 10 cards with "blue" in the name
- Displays "Showing 10 of X cards (Page 1 of Y)"
- Next button is enabled
- Previous button is disabled
- URL query params include `num=10&offset=0`

### 2. Navigate to Next Page

**Action:** Click "Next" button from test above

**Expected Results:**
- URL updates to `/cards?fname=blue&num=10&offset=10`
- Shows cards 11-20
- Displays "Showing 10 of X cards (Page 2 of Y)"
- Both Previous and Next buttons are enabled (unless on last page)
- Page indicator updates to "Page 2 of Y"

### 3. Navigate to Previous Page

**Action:** Click "Previous" button

**Expected Results:**
- URL updates back to `/cards?fname=blue&num=10&offset=0`
- Returns to first 10 cards
- Previous button is disabled again
- Next button is enabled

### 4. Change Results Per Page

**Action:** 
1. Search for `fname=blue` with `num=20`
2. Navigate to page 2
3. Change "Results Per Page" to 50
4. Submit form again

**Expected Results:**
- New search resets to page 1 (offset=0)
- Shows first 50 results
- Total pages is recalculated
- URL: `/cards?fname=blue&num=50&offset=0`

## Comprehensive Test Scenarios

### Scenario A: Small Result Set (Single Page)

```
Search: fname=Exodia
Expected total: ~5 cards
```

**Expected Behavior:**
- Results display normally
- NO pagination controls appear
- Info shows "Showing 5 of 5 cards" (no page indicator)

### Scenario B: Medium Result Set (Multiple Pages)

```
Search: fname=dragon&num=20
Expected total: 500+ cards
```

**Expected Behavior:**
- Shows 20 cards
- "Showing 20 of 500+ cards (Page 1 of 25+)"
- Next button enabled
- Previous button disabled
- Can navigate through all pages

### Scenario C: Large Result Set with Custom Page Size

```
Search: type=Monster&num=100
Expected total: 10,000+ cards
```

**Expected Behavior:**
- Shows 100 cards
- "Showing 100 of 10000+ cards (Page 1 of 100+)"
- Pagination controls present
- Efficient loading (not all cards fetched at once)

### Scenario D: Last Page

**Steps:**
1. Search with known small result set (e.g., `fname=blue-eyes&num=5`)
2. Navigate to last page

**Expected Behavior:**
- Next button is disabled
- Previous button is enabled
- Shows remaining cards (may be less than `num`)
- "Showing X of Y cards (Page Z of Z)"

### Scenario E: Direct URL Access

**Test URL:** `/cards?fname=dragon&num=20&offset=40`

**Expected Behavior:**
- Loads page 3 directly (cards 41-60)
- All pagination controls work correctly
- Page indicator shows "Page 3 of Z"
- Can navigate forward and backward from this page

### Scenario F: Browser Navigation

**Steps:**
1. Search for cards
2. Navigate to page 3
3. Click browser back button
4. Click browser forward button

**Expected Behavior:**
- Back button returns to page 2
- Forward button returns to page 3
- State is correctly restored each time
- No double-loading or race conditions

### Scenario G: Invalid Offset

**Test URL:** `/cards?fname=blue&num=20&offset=999999`

**Expected Behavior:**
- Either shows empty results page OR
- API returns error/empty data gracefully
- No crashes or infinite loops

## Edge Cases to Test

### Edge Case 1: Offset Not Multiple of Num

**URL:** `/cards?fname=blue&num=20&offset=15`

**Expected:** Should work, shows cards starting at position 15

### Edge Case 2: Zero Results

**Search:** `fname=nonexistentcard12345`

**Expected:**
- "No cards found" message
- No pagination controls
- No meta data displayed

### Edge Case 3: Exactly One Page

**Search:** `fname=test&num=100` (if results = 100 or less)

**Expected:**
- All results shown
- No pagination controls
- "Showing X of X cards" (no page indicator)

### Edge Case 4: Missing Num Parameter

**URL:** `/cards?fname=blue` (no num specified)

**Expected:**
- Uses default page size (20)
- Pagination works normally

### Edge Case 5: Only Offset Provided

**URL:** `/cards?fname=blue&offset=20` (no num)

**Expected:**
- Server validation may reject (required_with rule)
- OR API uses default num value

## API Response Validation

### Check Meta Data Structure

After any search with results, verify API response includes:

```json
{
  "data": [...],
  "meta": {
    "generated": "timestamp",
    "current_rows": number,
    "total_rows": number,
    "rows_remaining": number,
    "total_pages": number,
    "pages_remaining": number,
    "next_page": "string (optional)",
    "next_page_offset": number (optional),
    "previous_page": "string (optional)",
    "previous_page_offset": number (optional)
  }
}
```

### Verify Calculations

**Current Page Calculation:**
```
Current Page = floor(offset / num) + 1
```

Example: `offset=40, num=20` → Page 3

**Total Pages:**
```
Total Pages = ceil(total_rows / num)
```

Example: `total_rows=127, num=20` → 7 pages

## Performance Testing

### Test 1: Large Page Size

**URL:** `/cards?fname=dragon&num=100`

**Measure:**
- Page load time
- Memory usage
- Scroll performance with 100 card elements

### Test 2: Rapid Page Navigation

**Actions:** Quickly click Next multiple times

**Check:**
- No race conditions
- Requests complete in order
- UI doesn't flash or jump

### Test 3: Network Throttling

**Test with slow 3G:**
- Pagination still works
- Loading states appropriate
- No timeout errors

## Accessibility Testing

- [ ] Keyboard navigation (Tab to buttons, Enter to activate)
- [ ] Screen reader announces page changes
- [ ] Disabled buttons clearly indicated
- [ ] Focus management when navigating pages
- [ ] High contrast mode compatibility

## Mobile Testing

- [ ] Pagination controls touch-friendly
- [ ] Page indicator readable on small screens
- [ ] No horizontal scrolling needed
- [ ] Buttons adequately sized for touch (min 44x44px)

## Common Issues & Solutions

### Issue: Pagination controls don't appear

**Check:**
- Is `meta` prop being passed from controller?
- Does API response include `meta` field?
- Is `meta.total_pages > 1`?

### Issue: Next/Previous buttons always disabled

**Check:**
- Are `next_page_offset` and `previous_page_offset` in meta?
- Is API returning correct offset values?
- TypeScript type errors preventing proper checks?

### Issue: Page number calculation wrong

**Check:**
- Is `offset` and `num` correctly passed in filters?
- Math.floor calculation: `floor(offset / num) + 1`
- Are offset and num both numbers?

### Issue: Reset to page 1 not working

**Check:**
- Is `filters.offset = 0` being set before navigation?
- Is old offset being preserved in URL?

## Manual Test Checklist

Before marking this feature complete, verify:

- [ ] Search returns paginated results
- [ ] Results per page selector works (10, 20, 50, 100)
- [ ] Next button navigates forward
- [ ] Previous button navigates backward
- [ ] Next button disabled on last page
- [ ] Previous button disabled on first page
- [ ] Page indicator shows correct page number
- [ ] Result count shows correctly (X of Y cards)
- [ ] URL updates with offset parameter
- [ ] Direct URL access works
- [ ] Browser back/forward buttons work
- [ ] New search resets to page 1
- [ ] Page navigation preserves scroll position
- [ ] New search scrolls to top
- [ ] Shareable URLs work correctly
- [ ] No console errors
- [ ] No TypeScript errors
- [ ] Build completes successfully

## Automated Test Ideas

Future test suite could include:

```php
// Laravel Feature Tests
test('pagination includes meta data', function () {
    $response = $this->get('/cards?fname=blue&num=10');
    $response->assertSuccessful();
    $props = $response->viewData('props');
    expect($props['meta'])->toHaveKeys(['current_rows', 'total_rows', 'total_pages']);
});

test('next page offset increases correctly', function () {
    $response = $this->get('/cards?fname=blue&num=20&offset=20');
    $response->assertSuccessful();
    $props = $response->viewData('props');
    expect($props['meta']['previous_page_offset'])->toBe(0);
});
```

```typescript
// Vitest Component Tests
describe('Browse Pagination', () => {
  it('disables previous button on first page', () => {
    const wrapper = mount(Browse, {
      props: {
        meta: { previous_page_offset: null, total_pages: 5 },
        filters: { offset: 0, num: 20 }
      }
    });
    expect(wrapper.find('button:contains("Previous")').attributes('disabled')).toBe('');
  });
});
```

## Testing Complete When...

✅ All manual checklist items pass
✅ No console errors during navigation
✅ Build completes without errors
✅ TypeScript diagnostics clean
✅ Works on mobile and desktop
✅ Accessible to keyboard and screen reader users
✅ Performance acceptable with large result sets
