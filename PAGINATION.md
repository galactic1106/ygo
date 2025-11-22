# Pagination Feature

## Overview

The Browse page now includes pagination support using the YGOPRODeck API's built-in pagination metadata. Users can navigate through large result sets without loading all cards at once.

## How It Works

### API Response Structure

The YGOPRODeck API returns pagination metadata in the `meta` field:

```json
{
  "data": [...],
  "meta": {
    "generated": "2025-11-22T19:32:34+00:00",
    "current_rows": 10,
    "total_rows": 65,
    "rows_remaining": 55,
    "total_pages": 6,
    "pages_remaining": 6,
    "next_page": "https://db.ygoprodeck.com/api/v7/cardinfo.php?fname=blue&num=10&offset=10",
    "next_page_offset": 10,
    "previous_page": "...",
    "previous_page_offset": 0
  }
}
```

### Backend Implementation

**CardController.php**
- Extracts `meta` from the API response
- Passes it to the Browse page via Inertia props
- Meta is only present when there are search results

**CardDataRequest.php**
- Validates `num` (results per page) and `offset` (starting position)
- Both parameters are optional
- `num` and `offset` require each other if one is present (required_with)

### Frontend Implementation

**Browse.vue**

#### Form Controls
- **Results Per Page**: Select dropdown with options: 10, 20, 50, 100
  - Defaults to 20 if not specified
  - Stored in `num` parameter
  
- **Offset**: Hidden field managed automatically by pagination controls
  - Resets to 0 on new search
  - Updated by Previous/Next buttons

#### Pagination Controls

When results span multiple pages, pagination controls appear below the card grid:

- **Previous Button**: Navigates to previous page
  - Disabled on first page
  - Uses `meta.previous_page_offset`
  
- **Next Button**: Navigates to next page
  - Disabled on last page
  - Uses `meta.next_page_offset`
  
- **Page Indicator**: Shows current page and total pages
  - Calculated: `floor(offset / num) + 1`

#### Results Counter

The results header displays:
- Number of cards in current page (`meta.current_rows`)
- Total cards matching the search (`meta.total_rows`)
- Current page number and total pages (if multi-page)

Example: "Showing 20 of 65 cards (Page 2 of 7)"

## Usage

### Default Behavior
```
GET /cards?fname=blue
```
- Returns first 20 results (API default)
- No offset applied

### Custom Page Size
```
GET /cards?fname=blue&num=50
```
- Returns first 50 results

### Navigate to Specific Page
```
GET /cards?fname=blue&num=20&offset=40
```
- Returns results 41-60 (page 3)

### User Flow

1. User enters search criteria and submits form
2. Results display with "Showing X of Y cards"
3. If more than one page exists:
   - Pagination controls appear
   - User clicks "Next" to see more results
4. Offset updates in URL query params
5. Controller fetches new page from API
6. Browse page re-renders with new cards

## Technical Details

### State Management
- Pagination state stored in URL query parameters
- Enables shareable/bookmarkable result pages
- Browser back/forward buttons work correctly

### Scroll Behavior
- New search: scrolls to top (`preserveScroll: false`)
- Page navigation: preserves scroll position (`preserveScroll: true`)

### Type Safety
- `Meta` interface defines pagination structure
- Props are typed for compile-time checking
- Page calculations use TypeScript math operators

## Future Enhancements

Potential improvements:
- Jump to specific page number input
- Display page numbers (1, 2, 3... Last)
- Keyboard navigation (arrow keys)
- URL-based deep linking to specific pages
- Remember user's preferred page size
- Infinite scroll option
- Loading states during page transitions
