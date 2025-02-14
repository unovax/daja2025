import { useNotification } from '@kyvg/vue3-notification'

const { notify } = useNotification()

export const successNotification = (title : string = "Operación realizada con exito", text : string = "Los cambios se guardaron correctamente") => {
    notify({
        type: 'success',
        title: title,
        text: text
    })
}

interface errorData {
    errors?: Record<string,string>
    message: string
}
export const errorNotification = (title : string = "Ocurrió un error inesperado", data : errorData | string ) => {
    let text = '';
    if(typeof data == 'string'){
        text = data;
    }else{
        for(let key in data.errors){
            text += `${data.errors[key]}\n`
        }
    }
    notify({
        type: 'error',
        title: title,
        text: text
    })
}

export const infoNotification = (title : string = "", text : string = "") => {
    notify({
        type: 'info',
        title: title,
        text: text
    })
}

import Swal from "sweetalert2";

/**
 * Muestra una notificación de confirmación con SweetAlert2.
 * @param title Título de la alerta.
 * @param text Texto descriptivo.
 * @param confirmButtonText Texto del botón de confirmación.
 * @returns Promesa que resuelve en `true` si se confirma, `false` en caso contrario.
 */
export const confirmNotification = async (
  title: string = "¿Estás seguro?",
  text: string = "Esta acción no puede deshacerse",
  confirmButtonText: string = "Eliminar"
): Promise<boolean> => {
  const result = await Swal.fire({
    title,
    text,
    icon: "warning",
    showCancelButton: true,
    confirmButtonText,
    cancelButtonText: "Cancelar",
    heightAuto: false,
  });

  return result.isConfirmed;
};
