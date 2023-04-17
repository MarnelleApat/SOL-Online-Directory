import {
    helpers,
    minLength,
    maxLength,
    required,
    email
} from '@vuelidate/validators';

export const required$ = (label) => helpers.withMessage(`${label} is required.`, required)

export const email$ = helpers.withMessage('Not a valid email address format', email)

export const minLength$ = (min=0) => helpers.withMessage(`Minimum number should contain ${min} digits.`, minLength(min))

export const maxLength$ = (max=4) => helpers.withMessage(`Text limit to ${max} digits only.`, maxLength(max))

// export const phoneNumberMaxDigit$ = (length) => helpers.withMessage(`Phone number should contain ${length} digits only.`, maxLength(length))
