import { BookOpen, ChartLine, CreditCard, LifeBuoy, Network, Presentation, Send, Settings2, User } from 'lucide-react'

const data = {
    user: {
        name: 'shadcn',
        email: 'm@example.com',
        avatar: 'https://ui.shadcn.com/avatars/shadcn.jpg'
    },
    navMain: [
        {
            title: 'Users',
            url: '/users',
            icon: User,
            isActive: true,
            items: [
                {
                    title: 'All Users',
                    url: '/users'
                },
                {
                    title: 'Students',
                    url: '/users/students'
                },
                {
                    title: 'Teachers',
                    url: '/users/teachers'
                }
            ]
        },
        {
            title: 'Classrooms',
            url: '/classrooms',
            icon: Presentation
        },
        {
            title: 'Transactions',
            url: '/transactions',
            icon: CreditCard
        },
        {
            title: 'Usage',
            url: '/usage',
            icon: ChartLine
        },
        {
            title: 'Integrations',
            url: '/integrations',
            icon: Network
        },
        {
            title: 'Documentation',
            url: '#',
            icon: BookOpen,
            items: [
                {
                    title: 'Introduction',
                    url: '#'
                },
                {
                    title: 'Get Started',
                    url: '#'
                },
                {
                    title: 'Tutorials',
                    url: '#'
                },
                {
                    title: 'Changelog',
                    url: '#'
                }
            ]
        },
        {
            title: 'Settings',
            url: '#',
            icon: Settings2,
            items: [
                {
                    title: 'General',
                    url: '#'
                },
                {
                    title: 'Team',
                    url: '#'
                },
                {
                    title: 'Billing',
                    url: '#'
                },
                {
                    title: 'Limits',
                    url: '#'
                }
            ]
        }
    ],
    secondary: [
        {
            title: 'Support',
            url: '#',
            icon: LifeBuoy
        },
        {
            title: 'Feedback',
            url: '#',
            icon: Send
        }
    ]
}

export default data
