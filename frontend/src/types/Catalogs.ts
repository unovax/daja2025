export interface Client {
  id: string | null,
  code?: string
  name: string
  lastname: string
  email: string
  phone: string
};

export const defaultClient = {
    id: null,
    name: '',
    lastname: '',
    email: '',
    phone: '',
};

export interface Unit {
  id: string,
  code?: string
  name: string
};

export const defaultUnit = {
    id: 0,
    name: '',
};

export interface Measure {
  id: string,
  code?: string
  name: string
  value: string
  client_id: string | null
  unit_id: string | null
  unit?: Unit
  client?: Client
};

export const defaultMeasure = {
    id: 0,
    name: '',
    value: '',
    client_id: null,
    unit_id: null
};