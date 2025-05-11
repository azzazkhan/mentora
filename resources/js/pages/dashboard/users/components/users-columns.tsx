'use client'

import { ColumnDef } from '@tanstack/react-table'

import { DataTableColumnHeader } from '@/components/ui/data-table'
// import { bookApprovals, bookStatus, bookTypes } from '../data/book-options'
import { UsersTableRowActions } from './users-table-row-actions'

import { Badge } from '@/components/ui/badge'
import { Checkbox } from '@/components/ui/checkbox'
import { ProtectedUserModel } from '@/lib/schemas'
import { Role } from '@/lib/schemas/role.schema'
import { cn } from '@/lib/utils'
import { Link } from '@inertiajs/react'
import { formatDistance, formatISO } from 'date-fns'

type User = ProtectedUserModel & { roles: Role[] }

export const usersColumns: ColumnDef<User>[] = [
    {
        id: 'select',
        header: ({ table }) => (
            <Checkbox
                checked={table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate')}
                onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
                aria-label="Select all"
                className="translate-x-2 translate-y-[2px]"
            />
        ),
        cell: ({ row }) => (
            <Checkbox
                checked={row.getIsSelected()}
                onCheckedChange={(value) => row.toggleSelected(!!value)}
                aria-label="Select row"
                className="translate-x-2 translate-y-[2px]"
            />
        ),
        // cell: () => <div className="size-0"></div>,
        enableSorting: false,
        enableHiding: false
    },
    // {
    //     accessorKey: 'uid',
    //     header: ({ column }) => <DataTableColumnHeader column={column} title="Book" />,
    //     cell: ({ row }) => <div className="w-[80px] uppercase">{row.getValue('uid')}</div>,
    //     enableSorting: false,
    //     enableHiding: false
    // },
    {
        accessorKey: 'name',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Name" />,
        cell: ({ row }) => {
            // const status = statuses.find((status) => status.value === row.original.status)
            // const type = bookTypes.find((type) => type.value === row.original.type)
            // const approval = bookApprovals.find(
            //     (approval) => approval.value === row.original.approval
            // )

            return (
                <div className="flex space-x-2">
                    <div className="bg-muted-foreground/10 size-10 rounded-full"></div>
                    {/* <div>
                        {status && <Badge variant="outline">{status.label}</Badge>}

                    </div> */}
                    <div className="flex max-w-[500px] flex-col gap-1 truncate">
                        <div className="flex items-center gap-x-2">
                            <Link
                                href={route('dashboard.users.show', { user: row.original.uuid })}
                                className={cn({
                                    'truncate font-medium underline-offset-2 hover:underline': true
                                    // 'text-red-600 dark:text-red-500': approval?.value === 'rejected',
                                    // 'text-amber-600 dark:text-amber-500': approval?.value === 'pending'
                                })}
                            >
                                {row.getValue('name')}
                            </Link>
                            <Badge variant="outline">{row.original.roles[0].label}</Badge>
                        </div>
                        <span className="text-muted-foreground text-xs">{row.original.email}</span>
                    </div>
                </div>
            )
        }
    },
    // {
    //     accessorKey: 'type',
    //     header: ({ column }) => (
    //         <DataTableColumnHeader className="hidden" column={column} title="Type" />
    //     ),
    //     cell: ({ row }) => {
    //         const type = bookStatus.find((status) => status.value === row.getValue('type'))

    //         if (!type) {
    //             return null
    //         }

    //         return (
    //             // flex
    //             <div className="hidden w-[100px] items-center">
    //                 {type.icon && <type.icon className="text-muted-foreground mr-2 h-4 w-4" />}
    //                 <span>{type.label}</span>
    //             </div>
    //         )
    //     },
    //     filterFn: (row, id, value) => {
    //         return value.includes(row.getValue(id))
    //     }
    // },
    // {
    //     accessorKey: 'status',
    //     header: ({ column }) => <DataTableColumnHeader column={column} title="Status" />,
    //     cell: ({ row }) => {
    //         const status = bookStatus.find((status) => status.value === row.getValue('status'))

    //         if (!status) {
    //             return null
    //         }

    //         return (
    //             <div className="flex w-[100px] items-center">
    //                 {status.icon && <status.icon className="text-muted-foreground mr-2 h-4 w-4" />}
    //                 <span>{status.label}</span>
    //             </div>
    //         )
    //     },
    //     filterFn: (row, id, value) => {
    //         return value.includes(row.getValue(id))
    //     }
    // },
    // {
    //     accessorKey: 'approval',
    //     header: ({ column }) => (
    //         <DataTableColumnHeader className="hidden" column={column} title="Approval" />
    //     ),
    //     cell: ({ row }) => {
    //         const approval = bookApprovals.find(
    //             (approval) => approval.value === row.getValue('approval')
    //         )

    //         if (!approval) {
    //             return null
    //         }

    //         return (
    //             <div className="hidden items-center">
    //                 {approval.icon && (
    //                     <approval.icon className="text-muted-foreground mr-2 h-4 w-4" />
    //                 )}
    //                 <span>{approval.label}</span>
    //             </div>
    //         )
    //     },
    //     filterFn: (row, id, value) => {
    //         return value.includes(row.getValue(id))
    //     }
    // },
    {
        accessorKey: 'created_at',
        header: ({ column }) => <DataTableColumnHeader column={column} title="Created At" />,
        cell: ({ row }) => {
            return (
                <div className="flex space-x-2">
                    {formatDistance(formatISO(row.original.created_at), new Date(), {
                        addSuffix: true
                    })}
                    {/* {status && <Badge variant="outline">{status.label}</Badge>} */}
                    {/* {type && <Badge variant="outline">{type.label}</Badge>}
                    <span
                        className={cn({
                            'flex max-w-[500px] items-center gap-2 truncate font-medium': true,
                            'font-medium text-red-600 dark:text-red-500':
                                approval?.value === 'rejected',
                            'font-medium text-amber-600 dark:text-amber-500':
                                approval?.value === 'pending'
                        })}
                    >
                        {row.getValue('name')}
                    </span> */}
                </div>
            )
        }
    },
    {
        id: 'actions',
        cell: ({ row }) => <UsersTableRowActions row={row} />
    }
]
