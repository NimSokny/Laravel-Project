import type { Brand, Category, HeroContent, Product } from '@/types/shop'

export const fallbackHero: HeroContent = {
  title: 'Performance gear for work, play, and serious builds',
  subtitle:
    'Shop laptops, custom desktops, components, displays, and accessories backed by local computer specialists.',
  image: 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=1800&q=80',
  button_text: 'Shop products',
  button_link: '/products',
}

export const fallbackCategories: Category[] = [
  {
    id: 1,
    name: 'Laptops',
    slug: 'laptops',
    description: 'Portable machines for students, creators, and business teams.',
    image: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=800&q=80',
    products_count: 36,
  },
  {
    id: 2,
    name: 'Gaming PCs',
    slug: 'gaming-pcs',
    description: 'Ready-to-play towers with balanced CPU and GPU performance.',
    image: 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=800&q=80',
    products_count: 18,
  },
  {
    id: 3,
    name: 'Components',
    slug: 'components',
    description: 'Processors, motherboards, RAM, SSDs, cases, and cooling.',
    image: 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=800&q=80',
    products_count: 64,
  },
  {
    id: 4,
    name: 'Monitors',
    slug: 'monitors',
    description: 'High-refresh, color-accurate, and ultrawide displays.',
    image: 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=800&q=80',
    products_count: 24,
  },
]

export const fallbackBrands: Brand[] = [
  { id: 1, name: 'ASUS', slug: 'asus', description: 'Gaming and creator hardware' },
  { id: 2, name: 'MSI', slug: 'msi', description: 'Performance laptops and components' },
  { id: 3, name: 'Lenovo', slug: 'lenovo', description: 'Business laptops and workstations' },
  { id: 4, name: 'Acer', slug: 'acer', description: 'Value laptops and monitors' },
  { id: 5, name: 'Gigabyte', slug: 'gigabyte', description: 'Motherboards and graphics cards' },
  { id: 6, name: 'Samsung', slug: 'samsung', description: 'Displays and storage' },
]

export const fallbackProducts: Product[] = [
  {
    id: 101,
    category_id: 1,
    brand_id: 1,
    name: 'ROG Strix G16 Gaming Laptop',
    slug: 'rog-strix-g16-gaming-laptop',
    description:
      'A high-refresh gaming laptop with strong cooling, fast SSD storage, and a color-rich display.',
    specification: 'Intel Core i7 / RTX graphics / 16GB RAM / 1TB SSD / 165Hz display',
    price: 1599,
    discount_price: 1499,
    stock: 12,
    warranty: '2 years',
    thumbnail: 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&w=900&q=80',
    category: fallbackCategories[0]!,
    brand: fallbackBrands[0]!,
    rating: 4.8,
    reviews_count: 42,
    sold_count: 118,
  },
  {
    id: 102,
    category_id: 2,
    brand_id: 2,
    name: 'Vector X Custom Gaming Desktop',
    slug: 'vector-x-custom-gaming-desktop',
    description:
      'A clean airflow-first desktop tuned for competitive games, streaming, and everyday productivity.',
    specification: 'Ryzen 7 / RTX graphics / 32GB RAM / 1TB NVMe SSD / 750W PSU',
    price: 1899,
    discount_price: 1749,
    stock: 7,
    warranty: '3 years',
    thumbnail: 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=900&q=80',
    category: fallbackCategories[1]!,
    brand: fallbackBrands[1]!,
    rating: 4.9,
    reviews_count: 31,
    sold_count: 76,
  },
  {
    id: 103,
    category_id: 4,
    brand_id: 6,
    name: 'Odyssey 27 Inch QHD 165Hz Monitor',
    slug: 'odyssey-27-inch-qhd-165hz-monitor',
    description:
      'A sharp QHD display with fluid motion, adaptive sync, and a compact stand for modern desks.',
    specification: '27 inch / QHD / 165Hz / 1ms / IPS panel',
    price: 329,
    discount_price: 299,
    stock: 20,
    warranty: '1 year',
    thumbnail: 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=900&q=80',
    category: fallbackCategories[3]!,
    brand: fallbackBrands[5]!,
    rating: 4.7,
    reviews_count: 55,
    sold_count: 203,
  },
  {
    id: 104,
    category_id: 3,
    brand_id: 5,
    name: 'AeroForce RTX Graphics Card',
    slug: 'aeroforce-rtx-graphics-card',
    description:
      'A quiet, efficient graphics card for gaming, video editing, and GPU-accelerated workloads.',
    specification: '12GB VRAM / triple fan cooler / PCIe 4.0 / HDMI and DisplayPort',
    price: 699,
    discount_price: null,
    stock: 9,
    warranty: '2 years',
    thumbnail: 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?auto=format&fit=crop&w=900&q=80',
    category: fallbackCategories[2]!,
    brand: fallbackBrands[4]!,
    rating: 4.6,
    reviews_count: 27,
    sold_count: 91,
  },
]

export const fallbackReviews = [
  {
    name: 'Dara S.',
    role: 'Architecture student',
    quote: 'They helped me choose a laptop that handles 3D rendering without overspending.',
    rating: 5,
  },
  {
    name: 'Sophea L.',
    role: 'Streamer',
    quote: 'My custom PC was assembled cleanly, tested properly, and delivered faster than expected.',
    rating: 5,
  },
  {
    name: 'Nita K.',
    role: 'Small business owner',
    quote: 'The checkout was simple, and support answered questions about warranty right away.',
    rating: 4,
  },
]
