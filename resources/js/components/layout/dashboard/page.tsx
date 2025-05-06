'use client'

import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator
} from '@/components/ui/breadcrumb'
import { cn } from '@/lib/utils'
import { Breadcrumb as BreadcrumbDef } from '@/types/components'
import { Link } from '@inertiajs/react'
import { ComponentProps, FC, Fragment, ReactNode } from 'react'

interface Props extends ComponentProps<'div'> {
    title?: string
    breadcrumbs?: BreadcrumbDef[]
    actions?: ReactNode
}

const Page: FC<Props> = ({ title, breadcrumbs, className, actions, children, ...props }) => {
    return (
        <div className={cn('@container/page flex flex-col gap-8', className)} {...props}>
            <div
                className={cn('flex flex-col gap-6 @xl/page:flex-row', {
                    '@xl/page:justify-between': actions
                })}
            >
                <div className={cn('flex-col gap-2', title || breadcrumbs ? 'flex' : 'hidden')}>
                    {title && <h2 className="text-xl font-semibold tracking-tight">{title}</h2>}
                    {breadcrumbs && <BreadCrumbWrapper breadcrumbs={breadcrumbs} />}
                </div>
                {actions && <div>{actions}</div>}
            </div>
            <div>{children}</div>
        </div>
    )
}

interface BreadCrumbWrapperProps {
    breadcrumbs: BreadcrumbDef[]
}

const BreadCrumbWrapper: FC<BreadCrumbWrapperProps> = ({ breadcrumbs }) => {
    const count = breadcrumbs.length

    return (
        <Breadcrumb>
            <BreadcrumbList>
                {breadcrumbs.map(({ label, link }, index) => {
                    return (
                        <Fragment key={index}>
                            <BreadcrumbItem>
                                {link ? (
                                    <BreadcrumbLink asChild>
                                        <Link href={link}>{label}</Link>
                                    </BreadcrumbLink>
                                ) : (
                                    <BreadcrumbPage>{label}</BreadcrumbPage>
                                )}
                            </BreadcrumbItem>

                            {index < count - 1 && <BreadcrumbSeparator />}
                        </Fragment>
                    )
                })}
            </BreadcrumbList>
        </Breadcrumb>
    )
}

export default Page
