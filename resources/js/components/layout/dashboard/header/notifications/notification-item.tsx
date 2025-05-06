import { cn } from '@/lib/utils'
import { FC } from 'react'
import { Notification } from './data'

interface Props {
    notification: Notification
    remove: (id: number) => void
    markRead: (read: boolean) => void
}

const NotificationItem: FC<Props> = ({ notification }) => {
    const { icon: Icon } = notification

    return (
        <div className="group hover:bg-muted/80 dark:hover:bg-muted/50 relative flex items-start justify-between gap-4 rounded-md p-2 transition-colors">
            <div
                className={cn({
                    'flex size-8 shrink-0 items-center justify-center rounded-md': true,
                    'bg-muted dark:bg-muted/80 text-muted-foreground': notification.read,
                    'bg-primary/10 text-primary': !notification.read
                })}
            >
                <Icon className="size-4" />
            </div>

            <div className="flex grow flex-col gap-1.5">
                <h4
                    className={cn(
                        'text-sm leading-tight',
                        notification.read ? 'text-muted-foreground font-normal' : 'font-medium'
                    )}
                >
                    {notification.title}
                </h4>

                <p className="text-muted-foreground text-xs leading-tight">{notification.description}</p>

                <span className="text-muted-foreground mt-0.5 text-xs opacity-70">{notification.time}</span>
            </div>
        </div>
    )
}

export default NotificationItem
