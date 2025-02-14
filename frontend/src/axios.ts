import axios from 'axios';
import type { AxiosInstance } from 'axios';
import { useUser } from './stores/useUser';
import {   removeUserService } from '@/services/authService';
import { errorNotification } from './utils/notifications';

const ERR_NETWORK = "ERR_NETWORK";

const apiClient: AxiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/', 
  timeout: 5000, 
  headers: {
    'Content-Type': 'application/json',
    Authorization: '',
  },
});

apiClient.interceptors.request.use((config) => {
  const token = useUser().user.token;

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
}, (error) => {
  return Promise.reject(error);
});

apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if(error.code === ERR_NETWORK){
      errorNotification("Error de conexión", "Ocurrio un error en la conexion con el servidor.");
    }
    if (error.response && error.response.status === 401) {
      removeUserService();
    }
    return Promise.reject(error);
  }
);

export default apiClient;
