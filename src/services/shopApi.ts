import api, { unwrapData, unwrapPaginated } from '@/services/api'
import type {
  AuthPayload,
  Brand,
  Cart,
  Category,
  CheckoutPayload,
  HeroContent,
  Order,
  PaginatedResult,
  Product,
  ProductQuery,
  User,
} from '@/types/shop'

export const shopApi = {
  async getHero(): Promise<HeroContent> {
    return unwrapData<HeroContent>(await api.get('/home/hero'))
  },

  async getFeaturedProducts(): Promise<Product[]> {
    return unwrapData<Product[]>(await api.get('/home/featured'))
  },

  async getLatestProducts(): Promise<Product[]> {
    return unwrapData<Product[]>(await api.get('/home/latest'))
  },

  async getCategories(): Promise<Category[]> {
    return unwrapData<Category[]>(await api.get('/home/categories'))
  },

  async getBrands(): Promise<Brand[]> {
    return unwrapData<Brand[]>(await api.get('/products/brands'))
  },

  async getProducts(params: ProductQuery = {}): Promise<PaginatedResult<Product>> {
    return unwrapPaginated<Product>(await api.get('/products', { params }))
  },

  async getProduct(slug: string): Promise<Product> {
    return unwrapData<Product>(await api.get(`/products/${slug}`))
  },

  async login(payload: { email: string; password: string }): Promise<AuthPayload> {
    return unwrapData<AuthPayload>(await api.post('/auth/login', payload))
  },

  async register(payload: FormData | {
    name: string
    email: string
    password: string
    password_confirmation: string
    phone?: string
    address?: string
  }): Promise<AuthPayload> {
    return unwrapData<AuthPayload>(await api.post('/auth/register', payload))
  },

  async logout(): Promise<void> {
    await api.post('/auth/logout')
  },

  async getProfile(): Promise<User> {
    return unwrapData<User>(await api.get('/auth/profile'))
  },

  async updateProfile(payload: {
    name: string
    phone?: string | null
    address?: string | null
  }): Promise<User> {
    return unwrapData<User>(await api.put('/auth/profile', payload))
  },

  async getCart(): Promise<Cart> {
    return unwrapData<Cart>(await api.get('/cart'))
  },

  async addToCart(productId: number, quantity = 1): Promise<Cart> {
    return unwrapData<Cart>(await api.post('/cart', { product_id: productId, quantity }))
  },

  async updateCartItem(itemId: number, quantity: number): Promise<Cart> {
    return unwrapData<Cart>(await api.put(`/cart/${itemId}`, { quantity }))
  },

  async removeCartItem(itemId: number): Promise<Cart> {
    return unwrapData<Cart>(await api.delete(`/cart/${itemId}`))
  },

  async checkout(payload: CheckoutPayload): Promise<Order> {
    return unwrapData<Order>(await api.post('/orders', payload))
  },

  async getOrders(page = 1): Promise<PaginatedResult<Order>> {
    return unwrapPaginated<Order>(await api.get('/orders', { params: { page } }))
  },

  async getOrder(orderNumber: string): Promise<Order> {
    return unwrapData<Order>(await api.get(`/orders/${orderNumber}`))
  },
}
