import { Link } from '@inertiajs/react'
import { ComponentProps, FC } from 'react'

interface Props extends ComponentProps<typeof Link> {
    href: string
}

const NavLink: FC<Props> = (props) => {
    const external = /(http|https):\/\//i.test(props.href)

    if (external) {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        return <a target="_blank" rel="noopener noreferrer" {...props} />
    }

    return <Link {...props} />
}

export default NavLink
