import { Header } from '@/components/layout/dashboard/header'
import { DashboardSidebar } from '@/components/layout/dashboard/sidebar'
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar'
import { FC, ReactNode } from 'react'

interface Props {
    children?: ReactNode
}

const DashboardLayout: FC<Props> = ({ children }) => {
    return (
        <SidebarProvider>
            <div className="flex h-screen w-screen overflow-hidden">
                <DashboardSidebar className="shrink-0" />
                <SidebarInset className="flex grow flex-col">
                    <Header className="shrink-0" />
                    <div className="custom-scrollbar w-full grow overflow-x-hidden overflow-y-auto px-4 py-2">
                        <div>{children}</div>
                    </div>
                </SidebarInset>
            </div>
        </SidebarProvider>
    )
}

export default DashboardLayout
