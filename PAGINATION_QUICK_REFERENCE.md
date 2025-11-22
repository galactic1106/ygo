# Pagination Quick Reference

## 🎯 What Was Added

Pagination controls for the Browse page that let users navigate through large card search results.

## 📍 URL Structure

```
/cards?fname=dragon&num=20&offset=0
        └─search─┘  └pages┘ └start┘
```

- `num`: Results per page (10, 20, 50, 100)
- `offset`: Starting position (0, 20, 40, 60...)

## 🎨 UI Components Added

### 1. Results Per Page Selector
Location: Search form (bottom right)
Options: 10, 20, 50, 100
Default: 20

### 2. Pagination Info
Location: Above results
Shows: "Showing 20 of 127 cards (Page 3 of 7)"

### 3. Pagination Controls
Location: Below results
Buttons: Previous | Page X of Y | Next

## 🔧 How It Works

```
User Search → CardController → YGOPRODeck API
                     ↓
              Extract meta data
                     ↓
           Pass to Browse.vue
                     ↓
        Display with pagination
```

## 📊 Meta Data Structure

```json
{
  "current_rows": 20,      // Cards on current page
  "total_rows": 127,       // Total matching cards
  "total_pages": 7,        // Total pages
  "next_page_offset": 20,  // Next page starts here
  "previous_page_offset": 0 // Previous page starts here
}
```

## 🚀 Key Features

✅ Configurable page size (10/20/50/100)
✅ Previous/Next navigation
✅ Auto-disable buttons at boundaries
✅ URL-based state (shareable links)
✅ Browser back/forward support
✅ Smart scroll behavior
✅ Page reset on new search

## 📝 Code Locations

### Backend
- **Controller**: `app/Http/Controllers/CardController.php`
  - Extracts `meta` from API response
  - Passes to Inertia view

- **Validation**: `app/Http/Requests/CardDataRequest.php`
  - `num`: integer, required_with:offset
  - `offset`: integer, required_with:num

### Frontend
- **Component**: `resources/js/pages/Browse.vue`
  - Meta interface definition
  - Pagination logic functions
  - UI controls template

## 🎮 User Actions

| Action | Result |
|--------|--------|
| Select page size | Sets `num` parameter |
| Click Next | Adds `num` to `offset` |
| Click Previous | Subtracts `num` from `offset` |
| New search | Resets `offset` to 0 |
| Browser back | Restores previous page |

## 🧮 Calculations

```javascript
// Current page number
currentPage = Math.floor(offset / num) + 1

// Example: offset=40, num=20 → Page 3
```

## 🐛 Quick Debugging

**No pagination controls?**
- Check: `meta.total_pages > 1`
- Check: API returned meta data
- Check: Controller passes meta prop

**Wrong page number?**
- Verify: offset and num in URL
- Check: Math.floor(offset / num) + 1

**Buttons not working?**
- Check: next_page_offset in meta
- Check: previous_page_offset in meta
- Check: TypeScript errors

## 📋 Testing Checklist

```bash
# Small result set (no pagination)
/cards?fname=exodia

# Multiple pages
/cards?fname=dragon&num=20

# Navigate to page 2
/cards?fname=dragon&num=20&offset=20

# Large page size
/cards?fname=monster&num=100
```

## 🔗 Related Files

- `PAGINATION.md` - Full documentation
- `PAGINATION_IMPLEMENTATION.md` - Technical details
- `TESTING_PAGINATION.md` - Test scenarios

## 💡 Tips

- Default page size is 20 if not specified
- Offset must be provided with num (validation rule)
- New searches always reset to page 1
- Meta only present when results exist
- Previous button disabled when offset = 0
- Next button disabled on last page

## 🎯 Example URLs

```
# First page, default size
/cards?fname=blue

# Page 1, 50 per page
/cards?fname=blue&num=50

# Page 3, 20 per page
/cards?fname=blue&num=20&offset=40

# Last page (varies by total)
/cards?fname=blue&num=20&offset=120
```

## ⚡ Performance Notes

- Only fetches current page (not all results)
- Metadata cached by API
- No client-side pagination needed
- Efficient for large result sets

## 🔄 State Flow

```
Form Submit
    ↓
Convert num to integer
    ↓
Set offset = 0 (new search)
    ↓
router.get('/cards', filters)
    ↓
CardController validates
    ↓
API call with num + offset
    ↓
Extract data + meta
    ↓
Render Browse page
    ↓
Display results + controls
```

## 📱 Mobile Friendly

- Touch-friendly buttons
- Responsive layout
- Clear page indicators
- No horizontal scroll

---

**Last Updated**: Implementation complete
**Status**: ✅ Ready for testing
