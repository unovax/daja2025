import apiMeasure from "@/axios"
import type { Measure } from "@/types/Catalogs"
import type { ParamsData } from "@/types/Commons"

export const getMeasuresService = async (paramsData: ParamsData) => {
    const response = await apiMeasure.get('measures', {
        params: paramsData
    })
    return response
}

export const createMeasureService = async (measure: Measure) => {
    const response = await apiMeasure.post('measures', measure);
    return response;
}

export const updateMeasureService = async (measure: Measure) => {
    const response = await apiMeasure.put(`measures/${measure.id}`, measure);
    return response;
}

export const deleteMeasureService = async(id: string) =>  {
    const response = await apiMeasure.delete(`measures/${id}`);
    return response;
}
