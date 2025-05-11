import { ReactNode } from 'react'

export interface Breadcrumb {
    label: ReactNode
    link?: string
    disabled?: boolean
}
