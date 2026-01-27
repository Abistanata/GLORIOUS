# 🧪 Cart and Wishlist LocalStorage Testing Checklist

## 🎯 **Quick Start Testing (Essential Features)**

### **1. Basic Cart Functionality**
- [ ] Visit products page (`/products`)
- [ ] Click cart button (🛒) on any product
- [ ] Check if success toast appears
- [ ] Check if cart icon in navbar shows badge with count
- [ ] Click cart icon to open sidebar
- [ ] Verify item appears in cart with correct details
- [ ] Click remove button (×) to remove item
- [ ] Check if cart becomes empty

### **2. Basic Wishlist Functionality**
- [ ] Click heart button (❤️) on a product
- [ ] Check if heart turns red and success toast appears
- [ ] Check if wishlist icon in navbar shows badge
- [ ] Visit wishlist page (`/wishlist`)
- [ ] Verify item appears in wishlist
- [ ] Click remove button to remove item
- [ ] Check empty state message

### **3. WhatsApp Integration**
- [ ] Add item to cart
- [ ] Click "Lanjut ke Checkout" in cart sidebar
- [ ] If not logged in: should prompt login popup
- [ ] Login as customer, then try checkout again
- [ ] Check if WhatsApp opens with order details

---

## 🔍 **Comprehensive Testing (All Features)**

### **Frontend Testing**

#### **Product Cards (Products Page)**
- [ ] Cart button (🛒) visible and clickable on each product
- [ ] Wishlist button (❤️) visible and clickable on each product
- [ ] "Beli via WhatsApp" button separate and functional
- [ ] Button states update correctly (heart color changes)
- [ ] Toast notifications appear for all actions
- [ ] Navbar badges update in real-time

#### **Cart Sidebar**
- [ ] Opens/closes smoothly with cart icon click
- [ ] Displays items with image, name, price, quantity
- [ ] Total price calculates correctly
- [ ] Remove buttons work for each item
- [ ] "Lanjut Belanja" button closes sidebar
- [ ] "Lanjut ke Checkout" triggers WhatsApp or login

#### **Wishlist Page**
- [ ] Items display with correct product information
- [ ] Stats section shows accurate counts
- [ ] "Add to Cart" buttons work from wishlist
- [ ] Remove buttons work correctly
- [ ] Empty state displays when no items
- [ ] "Add All to Cart" functionality

### **Authentication Testing**

#### **Guest User Experience**
- [ ] Can add items to cart and wishlist without login
- [ ] Data persists across page refreshes
- [ ] Data persists across browser sessions
- [ ] Checkout prompts login when attempted
- [ ] WhatsApp messages work without customer data

#### **Logged-in User Experience**
- [ ] Cart and wishlist data syncs after login
- [ ] Existing data merges with localStorage data
- [ ] WhatsApp checkout includes customer information
- [ ] Data persists across login/logout cycles

#### **Data Synchronization**
- [ ] Guest data transfers to account when logging in
- [ ] Multiple tab synchronization works
- [ ] Database and localStorage stay in sync

### **WhatsApp Integration Testing**

#### **Guest Checkout Messages**
- [ ] Basic product information included
- [ ] Price and quantity details
- [ ] Professional message format

#### **Customer Checkout Messages**
- [ ] Customer name, username included
- [ ] Phone and email (if available)
- [ ] Complete order details with all items
- [ ] Proper total calculation
- [ ] Business-appropriate message structure

#### **Direct Product Purchase**
- [ ] "Beli via WhatsApp" button works
- [ ] Includes customer data when logged in
- [ ] Works for guest users

### **LocalStorage Testing**

#### **Data Persistence**
- [ ] Items remain after page refresh
- [ ] Items remain after browser restart
- [ ] Data integrity maintained
- [ ] localStorage contains correct JSON structure

#### **Data Operations**
- [ ] Add/remove operations update localStorage
- [ ] Quantity changes reflect correctly
- [ ] Duplicate prevention works (wishlist)
- [ ] Clear operations work properly

### **Edge Cases & Error Handling**

#### **Stock Validation**
- [ ] Out-of-stock items cannot be added to cart
- [ ] Stock validation prevents over-ordering
- [ ] UI reflects stock status correctly

#### **Network Scenarios**
- [ ] Slow connection handling
- [ ] Offline functionality (localStorage still works)
- [ ] Server unavailability handling

#### **Browser Compatibility**
- [ ] Works in Chrome, Firefox, Edge
- [ ] Works in incognito/private mode
- [ ] Graceful degradation without JavaScript

#### **Mobile Experience**
- [ ] Responsive design works on mobile
- [ ] Touch interactions work properly
- [ ] Cart sidebar adapts to small screens

### **API & Backend Testing**

#### **Endpoint Testing**
- [ ] `/wishlist/sync` accepts localStorage data
- [ ] `/wishlist/local-storage-data` returns data
- [ ] Authentication works correctly
- [ ] Error responses handled properly

#### **AJAX Operations**
- [ ] Network requests use correct methods
- [ ] CSRF tokens included
- [ ] Response parsing works
- [ ] Error states handled

---

## 🚀 **Testing Priority Order**

### **Phase 1: Critical Path (Must Test First)**
1. Basic cart add/remove functionality
2. Basic wishlist add/remove functionality
3. Cart sidebar display and interactions
4. WhatsApp checkout flow
5. localStorage persistence

### **Phase 2: User Experience**
1. Authentication integration
2. Data synchronization
3. Mobile responsiveness
4. Error handling

### **Phase 3: Edge Cases & Polish**
1. Network issues
2. Browser compatibility
3. Stock validation
4. Performance optimization

---

## 🐛 **Bug Report Template**

If you find any issues during testing, please document:

**Issue Description:**
- What were you trying to do?
- What happened instead?
- Expected behavior?

**Steps to Reproduce:**
1. Step 1
2. Step 2
3. Step 3

**Environment:**
- Browser: [Chrome/Firefox/Edge]
- Device: [Desktop/Mobile]
- Logged in: [Yes/No]
- localStorage state: [Empty/Has data]

**Screenshots/Console Errors:**
- [Attach if available]

---

## ✅ **Testing Completion Checklist**

- [ ] All Phase 1 tests passed
- [ ] All Phase 2 tests passed
- [ ] All Phase 3 tests passed
- [ ] No critical bugs found
- [ ] Performance acceptable
- [ ] Mobile experience good
- [ ] Documentation updated if needed

**Ready for production deployment:** [Yes/No]
