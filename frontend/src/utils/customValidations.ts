import { helpers } from "@vuelidate/validators"

/**
 * Valida que la fecha de finalización sea mayor que la fecha de inicio.
 * @param startDate - Fecha de inicio a comparar.
 * @returns Función de validación.
 */
export const endDateAfterStartDate = (startDate: string) =>
  helpers.withMessage(
    "La fecha de finalización debe ser mayor que la fecha de inicio",
    (value: string) => {
      if (!value || !startDate) return true
      return new Date(value) > new Date(startDate)
    }
  )
