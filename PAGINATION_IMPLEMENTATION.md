# Pagination Implementation Summary

## Overview

Successfully added pagination functionality to the Browse page, allowing users to navigate through large card result sets using the YGOPRODeck API's built-in pagination metadata.

## Changes Made

### Backend Changes

#### 1. CardController.php (`app/Http/Controllers/CardController.php`)

**Changes:**
- Added `meta` variable extraction from API response
- Pass `meta` to Browse page via Inertia props
- Meta contains pagination information (current page, total pages, next/previous offsets)

```php
$meta = null;

if (!empty($validated)) {
    $response = $this->yaps->getCardData($validated);
    $cards = $response['data'] ?? [];
    $meta = $response['meta'] ?? null;
}

return Inertia::render('Browse', [
    // ... existing props
    'cards' => $cards,
    'filters' => $validated,
    'meta' => $meta,  // NEW
]);
```

#### 2. CardDataRequest.php (`app/Http/Requests/CardDataRequest.php`)

**Status:** No changes needed
- Already had validation rules for `num` and `offset` parameters
- `num` and `offset` are optional but require each other (`required_with`)

### Frontend Changes

#### Browse.vue (`resources/js/pages/Browse.vue`)

**1. Added Meta Interface**
```typescript
interface Meta {
  current_rows: number;
  total_rows: number;
  rows_remaining: number;
  total_pages: number;
  pages_remaining: number;
  next_page?: string;
  next_page_offset?: number;
  previous_page?: string;
  previous_page_offset?: number;
}
```

**2. Updated Props Interface**
- Added `meta: Meta | null` to Props interface

**3. Updated Form Schema**
- Added `num` field (string type for Select compatibility)
- Added `offset` field (number, managed automatically)

**4. Updated Initial Values**
- `num`: defaults to 20 or uses value from filters
- `offset`: defaults to 0 or uses value from filters

**5. Added Pagination Logic**
```typescript
// Convert num to number for API
if (filters.num && typeof filters.num === 'string') {
  filters.num = parseInt(filters.num, 10);
}

// Reset to first page on new search
filters.offset = 0;
```

**6. Added Navigation Functions**
- `goToPage(offset)`: Navigate to specific offset
- `goToNextPage()`: Navigate to next page using `meta.next_page_offset`
- `goToPreviousPage()`: Navigate to previous page using `meta.previous_page_offset`

**7. Added UI Components**

**Results Per Page Select:**
```vue
<FormField name="num">
  <FormLabel>Results Per Page</FormLabel>
  <Select>
    <SelectItem value="10">10</SelectItem>
    <SelectItem value="20">20</SelectItem>
    <SelectItem value="50">50</SelectItem>
    <SelectItem value="100">100</SelectItem>
  </Select>
</FormField>
```

**Pagination Info Display:**
```vue
<div v-if="props.meta">
  Showing {{ props.meta.current_rows }} of {{ props.meta.total_rows }} cards
  <span v-if="props.meta.total_pages > 1">
    (Page {{ Math.floor((props.filters.offset || 0) / (props.filters.num || 20)) + 1 }}
    of {{ props.meta.total_pages }})
  </span>
</div>
```

**Pagination Controls:**
```vue
<div v-if="props.meta && props.meta.total_pages > 1">
  <Button @click="goToPreviousPage" :disabled="!props.meta.previous_page_offset">
    Previous
  </Button>
  <div>Page X of Y</div>
  <Button @click="goToNextPage" :disabled="!props.meta.next_page_offset">
    Next
  </Button>
</div>
```

## Features Implemented

### 1. Configurable Page Size
- Users can select 10, 20, 50, or 100 results per page
- Default: 20 results per page
- Persisted in URL query parameters

### 2. Previous/Next Navigation
- Previous button: disabled on first page
- Next button: disabled on last page
- Uses API-provided offsets for accurate navigation

### 3. Pagination Metadata Display
- Shows current results count vs total
- Displays current page and total pages
- Only shows when results span multiple pages

### 4. Smart Search Behavior
- New searches reset to page 1 (offset = 0)
- Page navigation preserves scroll position
- New searches scroll to top

### 5. URL State Management
- All pagination state in query parameters
- Shareable/bookmarkable URLs
- Browser back/forward support

## API Parameters Used

| Parameter | Type | Description |
|-----------|------|-------------|
| `num` | integer | Number of results per page (default: 20) |
| `offset` | integer | Starting position (default: 0) |

## Example URLs

```
# First page, default size
/cards?fname=blue

# First page, 50 results
/cards?fname=blue&num=50

# Third page, 20 results per page
/cards?fname=blue&num=20&offset=40
```

## API Response Structure

The YGOPRODeck API returns:
```json
{
  "data": [ /* card objects */ ],
  "meta": {
    "current_rows": 20,
    "total_rows": 127,
    "total_pages": 7,
    "next_page_offset": 20,
    "previous_page_offset": 0
  }
}
```

## User Flow

1. User enters search criteria and selects results per page (optional)
2. Submit form → navigates to `/cards?[filters]&num=20&offset=0`
3. Results display with "Showing X of Y cards (Page 1 of Z)"
4. If multiple pages exist, Previous/Next buttons appear
5. Click Next → URL updates to `&offset=20`
6. New page loads with updated results
7. Pagination controls update accordingly

## Technical Highlights

- **Type Safety**: Full TypeScript types for Meta interface
- **Validation**: Server-side validation via CardDataRequest
- **State Management**: URL-based state (no client state)
- **Accessibility**: Disabled buttons for invalid navigation
- **UX**: Smart scroll behavior (preserve on page change, reset on search)

## Files Modified

1. `app/Http/Controllers/CardController.php`
2. `resources/js/pages/Browse.vue`

## Files Created

1. `PAGINATION.md` - User documentation
2. `PAGINATION_IMPLEMENTATION.md` - This file

## Testing Checklist

- [x] Build succeeds without errors
- [x] TypeScript diagnostics pass
- [ ] Manual testing needed:
  - Search with results spanning multiple pages
  - Navigate forward through pages
  - Navigate backward through pages
  - Change results per page
  - Previous button disabled on first page
  - Next button disabled on last page
  - URL updates correctly
  - Browser back/forward works
  - Shareable URLs work correctly

## Future Enhancements

Suggested improvements for later:
- Jump to specific page number input
- Page number list (1, 2, 3, ... Last)
- Keyboard shortcuts (arrow keys)
- Loading indicators during page transitions
- Remember user's preferred page size (localStorage)
- Infinite scroll mode option
- "Load more" button alternative
- Skeleton loaders while fetching
