'use client'

/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable react-hooks/exhaustive-deps */
import { EventCallback, EventContext, EventMap } from '@/contexts/event-context'
import { FC, ReactNode, useCallback } from 'react'

interface Props {
    children?: ReactNode
}

const EventProvider: FC<Props> = ({ children }) => {
    const events: EventMap = new Map()

    const emit = useCallback((name: string, data: any = undefined) => {
        const listeners = events.get(name)

        if (listeners) {
            listeners.forEach((callback) => callback(data))
        }
    }, [])

    const on = useCallback((name: string, callback: EventCallback) => {
        if (!events.has(name)) {
            events.set(name, new Set())
        }

        events.get(name)?.add(callback)

        return () => events.get(name)?.delete(callback)
    }, [])

    return <EventContext.Provider value={{ emit, on }}>{children}</EventContext.Provider>
}

export default EventProvider
