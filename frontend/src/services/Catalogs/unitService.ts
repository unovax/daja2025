import apiUnit from "@/axios"
import type { Unit } from "@/types/Catalogs"
import type { ParamsData } from "@/types/Commons"

export const getUnitsService = async (paramsData: ParamsData) => {
    const response = await apiUnit.get('units', {
        params: paramsData
    })
    return response
}

export const createUnitService = async (unit: Unit) => {
    const response = await apiUnit.post('units', unit);
    return response;
}

export const updateUnitService = async (unit: Unit) => {
    const response = await apiUnit.put(`units/${unit.id}`, unit);
    return response;
}

export const deleteUnitService = async(id: string) =>  {
    const response = await apiUnit.delete(`units/${id}`);
    return response;
}
