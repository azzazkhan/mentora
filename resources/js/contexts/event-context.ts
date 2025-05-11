'use client'

/* eslint-disable @typescript-eslint/no-explicit-any */
import { createContext } from 'react'

export type EventCallback<T = any> = (data: T) => void
export type EventMap = Map<string, Set<EventCallback>>

export interface EventContextType {
    emit: (name: string, data?: any) => void
    on: <T = any>(name: string, callback: EventCallback<T>) => () => void
}

export const EventContext = createContext<EventContextType | null>(null)
