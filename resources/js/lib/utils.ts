import { type ClassValue, clsx } from 'clsx'
import { ChangeEvent } from 'react'
import { twMerge } from 'tailwind-merge'

export type Option<T = string> = { label: string; value: T }

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function buildInertiaFormHelper<D extends Record<string, unknown>>(
    data: D,
    setData: (key: keyof D, data: unknown) => void,
    errors: Record<string, string> = {},
    processing: boolean | undefined = undefined
) {
    return (key: keyof D) => {
        return {
            value: data[key] as string | number | readonly string[] | undefined,
            onChange: (event: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => setData(key, event.target.value),
            error: errors[key as string],
            disabled: typeof processing === 'boolean' ? processing : false
        }
    }
}
