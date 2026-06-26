import axios, { type AxiosResponse } from 'axios'
import type { ApiEnvelope, PaginatedResult } from '@/types/shop'

export const AUTH_TOKEN_KEY = 'computer_shop_token'
export const AUTH_USER_KEY = 'computer_shop_user'

const defaultApiUrl = 'http://127.0.0.1:8000/api'

export const API_BASE_URL = (import.meta.env.VITE_API_BASE_URL || defaultApiUrl).replace(/\/$/, '')
export const ASSET_BASE_URL = (
  import.meta.env.VITE_ASSET_BASE_URL || API_BASE_URL.replace(/\/api$/, '')
).replace(/\/$/, '')

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem(AUTH_TOKEN_KEY)

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  // Let browser set Content-Type for FormData
  if (config.data instanceof FormData) {
    delete config.headers['Content-Type']
  }

  return config
})

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem(AUTH_TOKEN_KEY)
      localStorage.removeItem(AUTH_USER_KEY)
    }

    return Promise.reject(error)
  },
)

export function unwrapData<T>(response: AxiosResponse<ApiEnvelope<T> | T>): T {
  const payload = response.data

  if (payload && typeof payload === 'object' && 'data' in payload) {
    return (payload as ApiEnvelope<T>).data
  }

  return payload as T
}

export function unwrapPaginated<T>(
  response: AxiosResponse<PaginatedResult<T> & { success?: boolean; message?: string }>,
): PaginatedResult<T> {
  const payload = response.data

  return {
    data: payload.data ?? [],
    current_page: Number(payload.current_page ?? 1),
    last_page: Number(payload.last_page ?? 1),
    total: Number(payload.total ?? payload.data?.length ?? 0),
    per_page: Number(payload.per_page ?? payload.data?.length ?? 0),
  }
}

export function getApiErrorMessage(error: unknown, fallback = 'Something went wrong.'): string {
  if (axios.isAxiosError(error)) {
    const message = error.response?.data?.message

    if (typeof message === 'string' && message.length > 0) {
      return message
    }

    if (typeof error.message === 'string' && error.message.length > 0) {
      return error.message
    }
  }

  if (error instanceof Error && error.message.length > 0) {
    return error.message
  }

  return fallback
}

export function assetUrl(path?: string | null, fallback = ''): string {
  if (!path) {
    return fallback
  }

  if (/^(https?:|data:|blob:)/i.test(path)) {
    return path
  }

  const cleanPath = path.replace(/^\/+/, '')

  if (cleanPath.startsWith('storage/')) {
    return `${ASSET_BASE_URL}/${cleanPath}`
  }

  return `${ASSET_BASE_URL}/storage/${cleanPath}`
}

export default api
