'use client'

// import icon from '@/assets/icons/icon-square-primary.webp'
import { ScrollArea } from '@/components/ui/scroll-area'
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem
} from '@/components/ui/sidebar'
// import Image from 'next/image'
import { Link } from '@inertiajs/react'
import { ComponentProps, FC } from 'react'
import data from './data'
import NavMain from './nav-main'
import NavSecondary from './nav-secondary'
import NavUser from './nav-user'

const DashboardSidebar: FC<ComponentProps<typeof Sidebar>> = ({ ...props }) => {
    return (
        <Sidebar variant="inset" {...props}>
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/">
                                <div className="bg-muted flex aspect-square size-8 overflow-hidden rounded-sm">
                                    <div className="size-8 bg-black dark:bg-white" />
                                    {/* <Image
                                        src={icon}
                                        height={32}
                                        width={32}
                                        alt={process.env.NEXT_PUBLIC_APP_NAME}
                                    /> */}
                                </div>
                                <div className="grid flex-1 text-left text-sm leading-tight">
                                    <span className="truncate font-semibold">{import.meta.env.VITE_APP_NAME}</span>
                                    <span className="truncate text-xs">Management Dashboard</span>
                                </div>
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>
            <SidebarContent className="flex overflow-hidden">
                <ScrollArea
                    className="min-h-0 w-full grow group-data-[collapsible=icon]:overflow-hidden"
                    viewportClassName="[&>div]:h-full"
                >
                    <div className="flex h-full grow flex-col gap-2">
                        <NavMain items={data.navMain} />
                        <NavSecondary items={data.secondary} className="mt-auto" />
                    </div>
                </ScrollArea>
            </SidebarContent>
            <SidebarFooter>
                <NavUser user={data.user} />
            </SidebarFooter>
        </Sidebar>
    )
}

export default DashboardSidebar
