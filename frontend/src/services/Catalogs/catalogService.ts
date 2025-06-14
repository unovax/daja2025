import apiClient from "@/axios"

export const getCatalogService = async (catalog: string) => {
    const response = await apiClient.get('get_catalog', {
        params: {
            catalog: catalog
        }
    })
    return response
}
