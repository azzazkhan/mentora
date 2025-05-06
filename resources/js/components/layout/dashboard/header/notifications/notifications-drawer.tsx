'use client'

import { ScrollArea } from '@/components/ui/scroll-area'
import { SheetContent, SheetHeader, SheetTitle } from '@/components/ui/sheet'
import { useMap } from '@mantine/hooks'
import initialNotifications from './data'
import NotificationItem from './notification-item'

const NotificationsDrawer = () => {
    const notifications = useMap(
        initialNotifications.map((notification) => [notification.id, notification])
    )

    return (
        <SheetContent className="w-full max-w-xs sm:max-w-sm">
            <SheetHeader className="shrink-0">
                <SheetTitle className="text-lg">Notifications</SheetTitle>
            </SheetHeader>
            <ScrollArea className="min-h-0 w-full grow px-4 pb-4">
                <div className="grid h-full w-full gap-4">
                    {Array.from(notifications).map(([key, value]) => {
                        return (
                            <NotificationItem
                                key={key}
                                notification={value}
                                remove={notifications.delete}
                                markRead={(read: boolean) => {
                                    notifications.set(key, { ...value, read })
                                }}
                            />
                        )
                    })}
                </div>
            </ScrollArea>
        </SheetContent>
    )
}

export default NotificationsDrawer
