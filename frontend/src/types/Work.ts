export interface Work {
    id?: string | null
    code: string
    notes: string
    start_date: string
    end_date: string
    client_id: string | null
    tenant_id: string | null
    work_details: WorkDetail[]
    individual_dates?: boolean
}

export interface WorkDetail {
    id?: string | null
    code: string | number
    name: string
    description: string
    price: number
    start_date: string
    end_date: string
    photo: string
    is_new: boolean
    work_id?: string | null
}


export const defaultWorkDetail : WorkDetail = {
    id: null,
    code: 1,
    name: '',
    description: '',
    price: 0,
    start_date: new Date().toISOString().slice(0, 16),
    end_date: new Date().toISOString().slice(0, 16),
    photo: '',
    is_new: false,
    work_id: null
}

export const defaultWork : Work = {
    id: null,
    code: '',
    notes: '',
    start_date: new Date().toISOString().slice(0, 16),
    end_date: new Date().toISOString().slice(0, 16),
    client_id: null,
    tenant_id: null,
    work_details: [
        defaultWorkDetail
    ],
    individual_dates: false 
}
