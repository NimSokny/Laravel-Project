import { computed, reactive } from 'vue'
import { AUTH_TOKEN_KEY, AUTH_USER_KEY, getApiErrorMessage } from '@/services/api'
import { shopApi } from '@/services/shopApi'
import type { AuthPayload, User } from '@/types/shop'

interface AuthState {
  user: User | null
  token: string | null
  loading: boolean
  error: string
}

function readStoredUser(): User | null {
  const raw = localStorage.getItem(AUTH_USER_KEY)

  if (!raw) {
    return null
  }

  try {
    return JSON.parse(raw) as User
  } catch {
    localStorage.removeItem(AUTH_USER_KEY)
    return null
  }
}

const state = reactive<AuthState>({
  user: readStoredUser(),
  token: localStorage.getItem(AUTH_TOKEN_KEY),
  loading: false,
  error: '',
})

function persistAuth(payload: AuthPayload) {
  state.user = payload.user
  state.token = payload.token
  localStorage.setItem(AUTH_TOKEN_KEY, payload.token)
  localStorage.setItem(AUTH_USER_KEY, JSON.stringify(payload.user))
}

function clearAuth() {
  state.user = null
  state.token = null
  localStorage.removeItem(AUTH_TOKEN_KEY)
  localStorage.removeItem(AUTH_USER_KEY)
}

async function login(payload: { email: string; password: string }) {
  state.loading = true
  state.error = ''

  try {
    persistAuth(await shopApi.login(payload))
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to sign in.')
    throw error
  } finally {
    state.loading = false
  }
}

async function register(payload: FormData | {
  name: string
  email: string
  password: string
  password_confirmation: string
  phone?: string
  address?: string
}) {
  state.loading = true
  state.error = ''

  try {
    persistAuth(await shopApi.register(payload))
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to create account.')
    throw error
  } finally {
    state.loading = false
  }
}

async function logout() {
  state.loading = true

  try {
    if (state.token) {
      await shopApi.logout()
    }
  } finally {
    clearAuth()
    state.loading = false
  }
}

async function loadProfile() {
  if (!state.token) {
    return
  }

  state.loading = true
  state.error = ''

  try {
    state.user = await shopApi.getProfile()
    localStorage.setItem(AUTH_USER_KEY, JSON.stringify(state.user))
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to load your profile.')
    clearAuth()
  } finally {
    state.loading = false
  }
}

async function updateProfile(payload: { name: string; phone?: string | null; address?: string | null }) {
  state.loading = true
  state.error = ''

  try {
    state.user = await shopApi.updateProfile(payload)
    localStorage.setItem(AUTH_USER_KEY, JSON.stringify(state.user))
  } catch (error) {
    state.error = getApiErrorMessage(error, 'Unable to update your profile.')
    throw error
  } finally {
    state.loading = false
  }
}

export function useAuthStore() {
  return {
    state,
    isAuthenticated: computed(() => Boolean(state.token)),
    login,
    register,
    logout,
    loadProfile,
    updateProfile,
    clearAuth,
  }
}
