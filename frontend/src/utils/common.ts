import type { ParamsData } from "@/types/Commons"

export const clone = (json: any) => {
  return JSON.parse(JSON.stringify(json))
}

export const set = (name: string, json: any) => {
  localStorage.setItem(name, JSON.stringify(json))
}

export const get = (name: string) => {
  const item = localStorage.getItem(name)
  return item !== null ? JSON.parse(item) : null
}

export const remove = (name: string) => {
  localStorage.removeItem(name);
}

export const getParamsData = (data: ParamsData, paramsData: ParamsData) => {
  const params : ParamsData = data;
  params.search = paramsData.search;
  delete params.data;
  delete params.links;
  params.page = params.current_page; 
  return params;
}
 