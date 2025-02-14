import { get } from "@/utils/common"

export interface Loading {
  state: boolean
  text: string | null
}

export interface ParamsData {
  first_page: number
  search: string
  page: number
  current_page: number
  first_page_url: string
  from: number
  last_page: number
  last_page_url: string
  next_page_url: string
  path: string
  per_page: number
  prev_page_url: any
  to: number
  total: number,
  data?: any[],
  links?: any[],
}

export const defaultParamsData : ParamsData = {
    first_page: 1,
    search: '',
    current_page: 1,
    page: 1,
    first_page_url: '',
    from: 1,
    last_page: 1,
    last_page_url: '',
    next_page_url: '',
    path: '',
    per_page: get('perPage') ?? 10,
    prev_page_url: '',
    to: 1,
    total: 1,
}
