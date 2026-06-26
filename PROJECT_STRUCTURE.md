# Vue.js Project Structure

## Overview
This document outlines the comprehensive folder structure for the modern e-commerce frontend.

## Directory Structure

```
src/
├── assets/                    # Static assets
│   ├── images/               # Images organized by type
│   │   ├── brands/          # Brand logos
│   │   ├── categories/      # Category images
│   │   ├── products/        # Product images
│   │   └── banners/         # Hero banners
│   ├── icons/               # Custom SVG icons
│   └── styles/              # Global styles
│       ├── main.css         # Main stylesheet
│       └── tailwind.css     # Tailwind imports

├── components/               # Vue components
│   ├── base/                # Base/UI components (reusable)
│   │   ├── BaseButton.vue   # Button component with variants
│   │   ├── BaseCard.vue     # Card component
│   │   ├── BaseInput.vue    # Input component
│   │   ├── BaseSelect.vue   # Select dropdown
│   │   ├── BaseTextarea.vue # Textarea component
│   │   ├── BaseCheckbox.vue # Checkbox component
│   │   ├── BaseRadio.vue    # Radio button component
│   │   ├── BaseBadge.vue    # Badge/tag component
│   │   ├── BaseModal.vue    # Modal dialog
│   │   ├── BaseDropdown.vue # Dropdown menu
│   │   ├── BaseTabs.vue     # Tab navigation
│   │   ├── BasePagination.vue # Pagination component
│   │   ├── BaseSpinner.vue  # Loading spinner
│   │   ├── BaseAlert.vue    # Alert/notification
│   │   └── BaseTooltip.vue  # Tooltip component
│   │
│   ├── layout/              # Layout components
│   │   ├── AppHeader.vue    # Main header/navigation
│   │   ├── AppFooter.vue    # Main footer
│   │   ├── Sidebar.vue      # Sidebar navigation
│   │   ├── MobileMenu.vue   # Mobile navigation drawer
│   │   └── Breadcrumb.vue   # Breadcrumb navigation
│   │
│   ├── shop/                # Shop-specific components
│   │   ├── ProductCard.vue  # Product display card
│   │   ├── CategoryCard.vue # Category display card
│   │   ├── BrandPill.vue    # Brand badge/pill
│   │   ├── ProductGallery.vue # Product image gallery
│   │   ├── QuantityStepper.vue # Quantity selector
│   │   ├── PriceDisplay.vue # Price with discount
│   │   ├── RatingStars.vue  # Star rating display
│   │   ├── StockBadge.vue   # Stock status badge
│   │   ├── FilterPanel.vue  # Filter sidebar
│   │   ├── SearchBar.vue    # Search input
│   │   ├── CartItem.vue     # Shopping cart item
│   │   ├── OrderSummary.vue # Order summary
│   │   └── ReviewCard.vue   # Customer review card
│   │
│   ├── auth/                # Authentication components
│   │   ├── LoginForm.vue    # Login form
│   │   ├── RegisterForm.vue # Registration form
│   │   ├── ForgotPasswordForm.vue # Password reset
│   │   └── SocialLogin.vue # Social auth buttons
│   │
│   ├── account/             # User account components
│   │   ├── ProfileForm.vue  # Profile editing
│   │   ├── OrderCard.vue    # Order display
│   │   ├── OrderDetails.vue # Order details
│   │   ├── WishlistItem.vue # Wishlist item
│   │   ├── AddressForm.vue  # Address management
│   │   └── AccountNav.vue   # Account sidebar nav
│   │
│   ├── checkout/            # Checkout components
│   │   ├── ShippingForm.vue # Shipping information
│   │   ├── PaymentMethod.vue # Payment selection
│   │   ├── OrderReview.vue  # Order review
│   │   └── CheckoutSteps.vue # Step indicator
│   │
│   └── ui/                  # General UI components
│       ├── SectionHeader.vue # Section title header
│       ├── EmptyState.vue   # Empty state display
│       ├── LoadingState.vue # Loading skeleton
│       ├── ErrorState.vue   # Error display
│       └── Notification.vue # Toast notification

├── composables/             # Vue composables (reusable logic)
│   ├── useApi.ts           # API request handling
│   ├── useAuth.ts          # Authentication logic
│   ├── useCart.ts          # Cart management
│   ├── useProducts.ts      # Product operations
│   ├── usePagination.ts    # Pagination logic
│   ├── useFilters.ts       # Filter management
│   ├── useSearch.ts        # Search functionality
│   ├── useDebounce.ts      # Debounce utility
│   ├── useLocalStorage.ts  # Local storage helper
│   └── useMediaQuery.ts    # Responsive breakpoints

├── stores/                  # Pinia state management
│   ├── auth.ts             # Authentication state
│   ├── cart.ts             # Shopping cart state
│   ├── products.ts         # Products state
│   ├── categories.ts       # Categories state
│   ├── brands.ts           # Brands state
│   ├── wishlist.ts         # Wishlist state
│   ├── ui.ts               # UI state (modals, notifications)
│   └── filters.ts          # Filter state

├── services/                # API services
│   ├── api.ts              # Axios configuration
│   ├── authApi.ts          # Authentication API
│   ├── productApi.ts       # Product API
│   ├── categoryApi.ts      # Category API
│   ├── brandApi.ts         # Brand API
│   ├── cartApi.ts          # Cart API
│   ├── orderApi.ts         # Order API
│   ├── userApi.ts          # User API
│   └── uploadApi.ts        # File upload API

├── types/                   # TypeScript type definitions
│   ├── shop.ts             # Shop-related types
│   ├── auth.ts             # Auth-related types
│   ├── cart.ts             # Cart-related types
│   ├── order.ts            # Order-related types
│   ├── user.ts             # User-related types
│   ├── api.ts              # API response types
│   └── common.ts           # Common utility types

├── utils/                   # Utility functions
│   ├── format.ts           # Formatting (currency, dates)
│   ├── validation.ts       # Validation helpers
│   ├── constants.ts        # Constants (enums, config)
│   ├── helpers.ts          # General helpers
│   └── storage.ts          # Storage utilities

├── router/                  # Vue Router configuration
│   ├── index.ts            # Main router setup
│   ├── routes.ts           # Route definitions
│   ├── guards.ts           # Navigation guards
│   └── middleware.ts       # Route middleware

├── views/                   # Page components
│   ├── HomeView.vue        # Home page
│   ├── ProductsView.vue    # Product listing
│   ├── ProductDetailsView.vue # Product detail
│   ├── CategoriesView.vue  # Categories listing
│   ├── BrandsView.vue      # Brands listing
│   ├── CartView.vue        # Shopping cart
│   ├── CheckoutView.vue    # Checkout process
│   ├── LoginView.vue       # Login page
│   ├── RegisterView.vue    # Registration page
│   ├── ForgotPasswordView.vue # Password reset
│   ├── ProfileView.vue     # User profile
│   ├── OrdersView.vue      # Order history
│   ├── OrderDetailsView.vue # Order details
│   ├── WishlistView.vue    # Wishlist
│   ├── AboutView.vue       # About page
│   └── ContactView.vue     # Contact page

├── data/                    # Static data / fallbacks
│   ├── fallbacks.ts        # Fallback data for development
│   └── mockData.ts         # Mock data for testing

├── App.vue                  # Root component
├── main.ts                  # Application entry point
└── env.d.ts                 # TypeScript environment declarations

public/                      # Public assets
├── favicon.ico
├── logo.svg
└── robots.txt
```

## Component Naming Conventions

- **Base components**: Prefix with `Base` (e.g., `BaseButton.vue`)
- **Layout components**: Descriptive names (e.g., `AppHeader.vue`)
- **Feature components**: Descriptive names (e.g., `ProductCard.vue`)
- **Page components**: Suffix with `View` (e.g., `HomeView.vue`)

## File Organization Principles

1. **Group by feature**: Components related to the same feature are grouped together
2. **Separation of concerns**: Clear separation between UI, logic, and data
3. **Scalability**: Structure supports growth without major refactoring
4. **Maintainability**: Easy to locate and modify files
5. **Reusability**: Common components in `base/` folder

## Import Path Aliases

Configure in `tsconfig.json`:
- `@/` → `src/`
- `@components/` → `src/components/`
- `@composables/` → `src/composables/`
- `@stores/` → `src/stores/`
- `@services/` → `src/services/`
- `@types/` → `src/types/`
- `@utils/` → `src/utils/`
- `@views/` → `src/views/`
- `@assets/` → `src/assets/`
