import { create } from 'zustand'

interface LayoutStore {
    commandOpened: boolean
    toggleCommand: (opened?: boolean) => void

    notificationOpened: boolean
    toggleNotification: (opened?: boolean) => void
}

export const useLayoutStore = create<LayoutStore>()((set) => ({
    commandOpened: false,
    toggleCommand: (opened) =>
        set((state) => ({
            commandOpened: typeof opened === 'boolean' ? opened : !state.commandOpened
        })),

    notificationOpened: false,
    toggleNotification: (opened) =>
        set((state) => ({
            notificationOpened: typeof opened === 'boolean' ? opened : !state.notificationOpened
        }))
}))
