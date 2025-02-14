export interface Client {
  id: string,
  code?: string
  name: string
  lastname: string
  email: string
  phone: string
};

export const defaultClient = {
    id: 0,
    name: '',
    lastname: '',
    email: '',
    phone: '',
};