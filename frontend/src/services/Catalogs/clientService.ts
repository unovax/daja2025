import apiClient from "@/axios"
import type { Client } from "@/types/Catalogs"
import type { ParamsData } from "@/types/Commons"

export const getClientsService = async (paramsData: ParamsData) => {
    const response = await apiClient.get('clients', {
        params: paramsData
    })
    return response
}

export const createClientService = async (client: Client) => {
    const response = await apiClient.post('clients', client);
    return response;
}

export const updateClientService = async (client: Client) => {
    const response = await apiClient.put(`clients/${client.id}`, client);
    return response;
}

export const deleteClientService = async(id: string) =>  {
    const response = await apiClient.delete(`clients/${id}`);
    return response;
}

export const getClientService = async(id: string) => {
    const response = await apiClient.get(`clients/${id}`);
    return response;
}