'use client'

import { Row } from '@tanstack/react-table'
import { Archive, ArchiveRestore, Eye, MoreHorizontal, PencilLine, Trash2 } from 'lucide-react'

import { Button } from '@/components/ui/button'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import { useEvent } from '@/hooks/use-event'
import { OPEN_USER_ARCHIVAL_MODAL, OPEN_USER_DELETION_MODAL, OPEN_USER_RESTORATION_MODAL } from '@/lib/events'
import { ProtectedUserModel } from '@/lib/schemas'
import { Fragment } from 'react'

interface DataTableRowActionsProps<TData> {
    row: Row<TData>
}

export function UsersTableRowActions<TData>({ row }: DataTableRowActionsProps<TData>) {
    const user = row.original as ProtectedUserModel
    const { emit } = useEvent()

    return (
        <Fragment>
            <DropdownMenu>
                <DropdownMenuTrigger asChild>
                    <Button variant="ghost" className="data-[state=open]:bg-muted flex h-8 w-8 p-0">
                        <MoreHorizontal />
                        <span className="sr-only">Open menu</span>
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" className="w-[160px]">
                    <DropdownMenuItem>
                        <Eye className="size-4" /> View
                    </DropdownMenuItem>
                    <DropdownMenuItem>
                        <PencilLine className="size-4" /> Edit
                    </DropdownMenuItem>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem onClick={() => emit(OPEN_USER_ARCHIVAL_MODAL, user)}>
                        <Archive className="size-4" /> Archive
                    </DropdownMenuItem>
                    <DropdownMenuItem onClick={() => emit(OPEN_USER_RESTORATION_MODAL, user)}>
                        <ArchiveRestore className="size-4" /> Restore
                    </DropdownMenuItem>
                    <DropdownMenuItem onClick={() => emit(OPEN_USER_DELETION_MODAL, user)}>
                        <Trash2 className="size-4" /> Delete
                        <DropdownMenuShortcut>⌘⌫</DropdownMenuShortcut>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </Fragment>
    )
}
