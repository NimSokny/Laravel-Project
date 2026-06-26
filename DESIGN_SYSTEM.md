# Modern E-Commerce Design System

## Color Palette

### Primary Colors
- **Primary Blue**: `#0EA5E9` (Sky 500) - Primary actions, links, highlights
- **Primary Dark**: `#0284C7` (Sky 600) - Hover states, active elements
- **Primary Light**: `#E0F2FE` (Sky 100) - Backgrounds, subtle accents

### Secondary Colors
- **Accent Purple**: `#8B5CF6` (Violet 500) - Special offers, premium features
- **Accent Teal**: `#14B8A6` (Teal 500) - Success states, trust indicators
- **Accent Orange**: `#F97316` (Orange 500) - Call-to-action buttons, urgency

### Neutral Colors
- **Background**: `#FFFFFF` (White) - Main background
- **Surface**: `#F8FAFC` (Slate 50) - Card backgrounds, sections
- **Border**: `#E2E8F0` (Slate 200) - Borders, dividers
- **Text Primary**: `#0F172A` (Slate 900) - Headings, important text
- **Text Secondary**: `#475569` (Slate 600) - Body text, descriptions
- **Text Muted**: `#94A3B8` (Slate 400) - Meta information, placeholders

### Semantic Colors
- **Success**: `#10B981` (Emerald 500) - Success messages, in-stock
- **Warning**: `#F59E0B` (Amber 500) - Warnings, limited stock
- **Error**: `#EF4444` (Red 500) - Errors, sold out, discounts
- **Info**: `#3B82F6` (Blue 500) - Informational messages

## Typography

### Font Family
- **Primary**: Inter, system-ui, -apple-system, sans-serif
- **Monospace**: JetBrains Mono, monospace (for codes, specs)

### Font Scale
- **Display**: 48px / 56px (Hero headings)
- **H1**: 36px / 44px (Page titles)
- **H2**: 30px / 38px (Section headings)
- **H3**: 24px / 32px (Card titles)
- **H4**: 20px / 28px (Subheadings)
- **Body Large**: 18px / 28px (Lead text)
- **Body**: 16px / 24px (Body text)
- **Body Small**: 14px / 20px (Secondary text)
- **Caption**: 12px / 16px (Labels, meta)
- **Micro**: 11px / 16px (Fine print)

### Font Weights
- **Regular**: 400
- **Medium**: 500
- **Semibold**: 600
- **Bold**: 700

## Spacing Scale

- **0**: 0px
- **1**: 4px
- **2**: 8px
- **3**: 12px
- **4**: 16px
- **5**: 20px
- **6**: 24px
- **8**: 32px
- **10**: 40px
- **12**: 48px
- **16**: 64px
- **20**: 80px
- **24**: 96px

## Border Radius

- **Sm**: 4px (Small elements, tags)
- **Md**: 8px (Cards, buttons)
- **Lg**: 12px (Large cards, modals)
- **Xl**: 16px (Hero elements)
- **Full**: 9999px (Pills, badges)

## Shadows

- **Sm**: `0 1px 2px 0 rgb(0 0 0 / 0.05)`
- **Md**: `0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)`
- **Lg**: `0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)`
- **Xl**: `0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)`

## Transitions

- **Fast**: 150ms ease-in-out
- **Base**: 200ms ease-in-out
- **Slow**: 300ms ease-in-out

## Component Design Principles

### Buttons
- **Primary**: Solid background, prominent for main actions
- **Secondary**: Outlined or subtle background for secondary actions
- **Ghost**: Transparent background, icon-only buttons
- **Sizes**: Sm (32px), Md (40px), Lg (48px)

### Cards
- **Elevation**: Subtle shadow on hover
- **Border**: Thin border for definition
- **Radius**: Consistent 8px or 12px
- **Padding**: 16px - 24px internal spacing

### Inputs
- **Border**: 1px solid, focus ring on active
- **Radius**: 8px
- **Height**: 40px - 48px
- **States**: Default, focus, error, disabled

### Navigation
- **Desktop**: Horizontal navigation with dropdowns
- **Mobile**: Hamburger menu with slide-out drawer
- **Breadcrumbs**: Clear hierarchy indication

## Layout Patterns

### Container
- **Max Width**: 1280px (xl), 1024px (lg)
- **Padding**: 16px mobile, 24px tablet, 32px desktop

### Grid Systems
- **Product Grid**: 2 columns mobile, 3 tablet, 4 desktop
- **Category Grid**: 2 columns mobile, 3 tablet, 4 desktop
- **Feature Grid**: 1 column mobile, 2 tablet, 3 desktop

## Responsive Breakpoints

- **Mobile**: < 640px
- **Tablet**: 640px - 1024px
- **Desktop**: 1024px - 1280px
- **Wide**: > 1280px

## Accessibility

- **Contrast Ratio**: Minimum 4.5:1 for text
- **Focus States**: Visible focus rings on interactive elements
- **Touch Targets**: Minimum 44x44px for touch devices
- **Semantic HTML**: Proper heading hierarchy, ARIA labels
- **Keyboard Navigation**: Full keyboard accessibility

## Animation Guidelines

- **Hover Effects**: Subtle scale (1.02-1.05), shadow increase
- **Page Transitions**: Fade in (300ms)
- **Loading States**: Skeleton screens, spinners
- **Micro-interactions**: Button press, checkbox toggle

## Iconography

- **Icon Set**: Lucide Icons (already in use)
- **Sizes**: 16px, 20px, 24px, 32px
- **Stroke**: 2px stroke width
- **Color**: Inherit from text or semantic colors

## Image Guidelines

- **Aspect Ratios**: 
  - Product cards: 4:3
  - Category cards: 5:3
  - Hero banners: 16:9 or 21:9
- **Quality**: WebP format, lazy loading
- **Fallback**: Placeholder images for missing assets
- **Alt Text**: Descriptive alt text for accessibility
