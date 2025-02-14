export interface Tenant {
    code: string,
    name: string
}

export interface User {
    name : string,
    lastname : string,
    email : string,
    token? : string,
    tenant: Tenant,
    profilePicture: string | null,
}

export const defaultUser : User = {
    name: '',
    lastname: '',
    email: '',
    token: '',
    tenant: {
        code: '',
        name: '',
    },
    profilePicture: ''
}

export interface LoginCredentials {
    email : string,
    password : string,
} 

export const emptyLoginCredentials : LoginCredentials = {
    email: '',
    password: ''
}

export interface RegisterCredentials {
    name : string,
    lastname : string,
    email : string,
    password : string,
    password_confirmation : string,
    tenant: Tenant
} 

export const emptyRegisterCredentials : RegisterCredentials = {
    name: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
    tenant: {
        code: '',
        name: ''
    }
}

export interface ForgotPasswordCredentials {
    email: string
}

export const emptyForgotPasswordCredentials = {
    email: ''
}

export interface ResetPasswordCredentials {
    email: string,
    token: string,
    password: string,
    password_confirmation: string
}

export const emptyResetPasswordCredentials = {
    email: '',
    token: '',
    password: '',
    password_confirmation: ''
}