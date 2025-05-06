import {
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem
} from '@/components/ui/sidebar'
import { LucideIcon } from 'lucide-react'
import { ComponentPropsWithoutRef, FC } from 'react'

interface Item {
    title: string
    url: string
    icon: LucideIcon
}

interface Props extends ComponentPropsWithoutRef<typeof SidebarGroup> {
    items: Item[]
}

const NavSecondary: FC<Props> = ({ items, ...props }) => {
    return (
        <SidebarGroup {...props}>
            <SidebarGroupContent>
                <SidebarMenu>
                    {items.map((item) => (
                        <SidebarMenuItem key={item.title}>
                            <SidebarMenuButton asChild size="sm">
                                <a href={item.url}>
                                    <item.icon />
                                    <span>{item.title}</span>
                                </a>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    ))}
                </SidebarMenu>
            </SidebarGroupContent>
        </SidebarGroup>
    )
}

export default NavSecondary
