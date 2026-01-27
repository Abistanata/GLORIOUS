# TODO: Customer Login & Cart/Wishlist Implementation

## 1. Routing Changes
- [ ] Modify AuthController loginCustomer() to not redirect to dashboard
- [ ] Modify AuthController register() to not redirect to dashboard
- [ ] Update login to stay on current page or redirect to home

## 2. Product Detail Page (show.blade.php)
- [ ] Add "Tambah ke Cart" button
- [ ] Add "Tambah ke Wishlist" button
- [ ] Integrate with localStorage cart system
- [ ] Update JavaScript for cart/wishlist functionality
- [ ] Handle guest vs authenticated user states

## 3. Register Error Fix
- [ ] Identify cause of 500 error in registration
- [ ] Fix validation or database issues
- [ ] Test registration process

## 4. JavaScript Updates
- [ ] Update cart functionality in theme.blade.php
- [ ] Update wishlist functionality
- [ ] Ensure localStorage integration works
- [ ] Test guest and authenticated user flows

## 5. Testing
- [ ] Test customer login stays on page
- [ ] Test cart/wishlist buttons work
- [ ] Test registration works without errors
- [ ] Test both guest and authenticated flows
