# Customer Frontend Guide

## UX/UI Structure

The Vue customer side follows a real e-commerce flow:

- Home: header, hero banner, category shortcuts, featured products, new arrivals, best sellers, brands, reviews, footer.
- Catalog: product listing with search, category, brand, sort, pagination, and add-to-cart actions.
- Product details: gallery, price, discount, stock, warranty, specifications, related products.
- Shopping: cart review, quantity updates, remove item, checkout, order history.
- Account: login, register, profile update, authenticated order access.
- Content: about and contact pages for trust, support, and store information.

## Folder Structure

```text
src/
  assets/css/style.css       Tailwind entry and shared UI classes
  components/
    layout/                  Header and footer
    shop/                    Product, category, brand, quantity components
    ui/                      Shared section and empty-state UI
  data/fallbacks.ts          Development fallback shop data
  router/index.ts            Vue Router page map and auth guards
  services/
    api.ts                   Axios instance, auth header, asset URL helpers
    shopApi.ts               Laravel API methods
  stores/
    auth.ts                  Token auth state and profile actions
    cart.ts                  Cart state and cart mutations
  types/shop.ts              Product, cart, order, user, API types
  utils/format.ts            Money, date, and price helpers
  views/                     Route pages
```

## Component Structure

- `AppHeader.vue`: navigation, search, cart count, login/account actions, mobile menu.
- `AppFooter.vue`: shop links and contact information.
- `ProductCard.vue`: reusable product display with image, discount, stock, price, and add action.
- `CategoryCard.vue`: category image card linking into filtered products.
- `BrandPill.vue`: brand shortcut linking into filtered products.
- `QuantityStepper.vue`: fixed-size quantity control for cart and product details.
- `SectionHeader.vue`: consistent section titles and optional actions.
- `EmptyState.vue`: reusable empty/error-like content state.

## API Integration

Set these environment values if your backend does not run on the defaults:

```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
VITE_ASSET_BASE_URL=http://127.0.0.1:8000
```

The frontend currently calls:

- `GET /api/home/hero`
- `GET /api/home/featured`
- `GET /api/home/latest`
- `GET /api/home/categories`
- `GET /api/products`
- `GET /api/products/{slug}`
- `GET /api/products/brands`
- `POST /api/auth/login`
- `POST /api/auth/register`
- `POST /api/auth/logout`
- `GET /api/auth/profile`
- `PUT /api/auth/profile`
- `GET /api/cart`
- `POST /api/cart`
- `PUT /api/cart/{itemId}`
- `DELETE /api/cart/{itemId}`
- `GET /api/orders`
- `POST /api/orders`

## Laravel Connection Best Practices

- Use bearer tokens from Laravel Sanctum personal access tokens for this separate Vue app.
- Return a consistent `{ success, message, data }` envelope from API controllers.
- Keep images under Laravel public storage and return relative paths; `assetUrl()` converts them.
- Protect cart, checkout, orders, and profile with `auth:sanctum`.
- Keep product listing filters stable: `search`, `category`, `brand`, `sort`, `page`, `per_page`.
- Add CORS support for the Vite dev origin, usually `http://localhost:5173`.
- Keep admin Blade and customer API separated so admin changes do not break customer routes.
