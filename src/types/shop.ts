export interface Category {
  id: number
  name: string
  slug: string
  description?: string | null
  image?: string | null
  products_count?: number
}

export interface Brand {
  id: number
  name: string
  slug: string
  description?: string | null
  logo?: string | null
}

export interface ProductImage {
  id?: number
  image?: string | null
  path?: string | null
  url?: string | null
}

export interface Product {
  id: number
  category_id?: number
  brand_id?: number
  name: string
  slug: string
  description?: string | null
  specification?: string | null
  price: number | string
  discount_price?: number | string | null
  stock?: number
  thumbnail?: string | null
  warranty?: string | null
  status?: boolean
  category?: Category | null
  brand?: Brand | null
  images?: ProductImage[]
  rating?: number
  reviews_count?: number
  sold_count?: number
  created_at?: string
}

export interface HeroContent {
  title: string
  subtitle: string
  image?: string | null
  button_text: string
  button_link: string
}

export interface Role {
  id: number
  name: string
}

export interface User {
  id: number
  role_id?: number
  name: string
  email: string
  phone?: string | null
  address?: string | null
  profile_image?: string | null
  role?: Role | null
  role_name?: string | null
}

export interface AuthPayload {
  user: User
  token: string
}

export interface CartItem {
  id: number
  product_id: number
  quantity: number
  price: number | string
  subtotal: number | string
  product: Product
}

export interface Cart {
  id: number | null
  user_id?: number
  items: CartItem[]
  total: number | string
  items_count: number
}

export interface OrderItem {
  id: number
  order_id?: number
  product_id: number
  quantity: number
  price: number | string
  subtotal: number | string
  product?: Product | null
}

export interface Order {
  id: number
  order_number: string
  total_price: number | string
  payment_method: 'Cash' | 'ABA' | 'ACLEDA' | 'Wing'
  payment_status: 'Pending' | 'Paid' | 'Failed' | 'Refund'
  order_status: 'Pending' | 'Processing' | 'Shipping' | 'Delivered' | 'Cancelled'
  shipping_address: string
  created_at?: string
  items?: OrderItem[]
}

export interface PaginatedResult<T> {
  data: T[]
  current_page: number
  last_page: number
  total: number
  per_page: number
}

export interface ProductQuery {
  search?: string
  category?: number | string
  brand?: number | string
  sort?: 'latest' | 'price_low' | 'price_high' | 'name_asc'
  page?: number
  per_page?: number
}

export interface CheckoutPayload {
  shipping_address: string
  payment_method: 'Cash' | 'ABA' | 'ACLEDA' | 'Wing'
}

export interface ApiEnvelope<T> {
  success: boolean
  message?: string
  data: T
  errors?: Record<string, string[]>
}
