import apiClient from "@/axios"
import type { ParamsData } from "@/types/Commons";
import type { Work } from "@/types/Work";

export const getWorksService = async (paramsData: ParamsData) => {
    const response = await apiClient.get('works', {
        params: paramsData
    });
    return response;
}

export const createWorkService = async(work : Work) => {
    const response = await apiClient.post('works', work);
    return response;
}