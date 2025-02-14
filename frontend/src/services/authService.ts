import apiClient from '@/axios'
import router from '@/router'
import { useUser } from '@/stores/useUser'
import type {
  LoginCredentials,
  RegisterCredentials,
  ForgotPasswordCredentials,
  User,
  ResetPasswordCredentials
} from '@/types/Auth'

export const loginService = async (credentials: LoginCredentials) => {
  const response = await apiClient.post('login', credentials)
  return response
}

export const registerService = async (credentials: RegisterCredentials) => {
  const response = await apiClient.post('register', credentials)
  return response
}

export const logoutService = async () => {
  const response = await apiClient.delete('logout')
  return response
}

export const setUserService = (user: User) => {
  useUser().setUser(user)
  router.push({ name: 'Home' })
}

export const removeUserService = () => {
  useUser().removeUser()
  router.push({ name: 'Login' })
}

export const forgotPasswordService = async (credentials: ForgotPasswordCredentials) => {
  const response = await apiClient.post('forgot_password', credentials)
  return response;
}

export const resetPasswordService = async (credentials: ResetPasswordCredentials) => {
  const response = await apiClient.post('reset_password', credentials)
  return response;
}