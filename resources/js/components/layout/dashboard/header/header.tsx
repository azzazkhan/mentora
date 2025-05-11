import { SidebarTrigger } from '@/components/ui/sidebar'
import { cn } from '@/lib/utils'
import { ComponentProps, FC } from 'react'
import { Notifications } from './notifications'
import { Search } from './search'
import ThemeToggler from './theme-toggler'

const Header: FC<ComponentProps<'header'>> = ({ className, ...props }) => {
    return (
        <header className={cn('flex h-16 items-center justify-between gap-2 px-4', className)} {...props}>
            <div className="flex grow items-center gap-4 md:grow-0">
                <SidebarTrigger className="-ml-1" />

                <Search />
            </div>

            <div className="flex items-center gap-2">
                <Notifications />
                <ThemeToggler />
            </div>
        </header>
    )
}

export default Header
