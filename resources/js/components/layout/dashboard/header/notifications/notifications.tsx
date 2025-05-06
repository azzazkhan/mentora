'use client'

import { Button } from '@/components/ui/button'
import { Sheet, SheetTrigger } from '@/components/ui/sheet'
import { Bell } from 'lucide-react'
import NotificationsDrawer from './notifications-drawer'

const Notifications = () => {
    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button variant="outline" size="icon" className="cursor-pointer">
                    <Bell />
                    <span className="sr-only">Toggle notification drawer</span>
                </Button>
            </SheetTrigger>

            <NotificationsDrawer />
        </Sheet>
    )
}

export default Notifications
