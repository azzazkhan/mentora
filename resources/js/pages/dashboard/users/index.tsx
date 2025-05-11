import { DashboardLayout, Page } from '@/components/layout/dashboard'
import { Button } from '@/components/ui/button'
import { ProtectedUserModel } from '@/lib/schemas'
import { Breadcrumb } from '@/types/components'
import { Link } from '@inertiajs/react'
import { Plus } from 'lucide-react'
import { usersColumns } from './components/users-columns'
import { UsersTable } from './components/users-table'

interface Props {
    users: ProtectedUserModel[]
}

export default function ListUsers({ users }: Props) {
    const breadcrumbs: Breadcrumb[] = [{ label: 'Dashboard', link: route('dashboard') }, { label: 'Users' }]

    console.log(users)

    return (
        <DashboardLayout>
            <Page
                title="Users"
                breadcrumbs={breadcrumbs}
                actions={
                    <Button asChild>
                        <Link href={route('dashboard.users.create')}>
                            <Plus className="size-4" /> Add User
                        </Link>
                    </Button>
                }
            >
                {/* <BookModals /> */}
                <UsersTable data={users} columns={usersColumns} />
            </Page>
        </DashboardLayout>
    )
}
