import { Bell, Check, Clock, Info, LucideIcon, MessageSquare } from 'lucide-react'

export interface Notification {
    id: number
    title: string
    description: string
    icon: LucideIcon
    time: string
    read: boolean
}

const notifications: Notification[] = [
    {
        id: 1,
        title: 'New message received',
        description: 'You have received a new message from Sarah Johnson',
        icon: MessageSquare,
        time: '5 minutes ago',
        read: false
    },
    {
        id: 2,
        title: 'Task completed',
        description: "Your task 'Update documentation' has been marked as complete",
        icon: Check,
        time: '1 hour ago',
        read: false
    },
    {
        id: 3,
        title: 'Meeting reminder',
        description: 'Your meeting with the design team starts in 30 minutes',
        icon: Clock,
        time: '2 hours ago',
        read: true
    },
    {
        id: 4,
        title: 'System update',
        description: 'The system will be updated tonight at 2:00 AM. Please save your work.',
        icon: Info,
        time: 'Yesterday',
        read: true
    },
    {
        id: 5,
        title: 'New feature available',
        description: 'Check out the new dashboard features that were just released',
        icon: Bell,
        time: '2 days ago',
        read: false
    },
    {
        id: 6,
        title: 'Account security',
        description: 'We recommend updating your password for security purposes',
        icon: Info,
        time: '3 days ago',
        read: true
    },
    {
        id: 7,
        title: 'Subscription renewal',
        description: 'Your subscription will renew in 7 days. Review your payment details.',
        icon: Clock,
        time: '1 week ago',
        read: false
    },
    {
        id: 8,
        title: 'New comment on your post',
        description: 'Alex left a comment on your recent post',
        icon: MessageSquare,
        time: '1 week ago',
        read: true
    },
    {
        id: 9,
        title: 'Project milestone reached',
        description: 'Your team has reached the first milestone for Project Alpha',
        icon: Check,
        time: '2 weeks ago',
        read: true
    },
    {
        id: 10,
        title: 'Holiday schedule',
        description: 'Check the upcoming holiday schedule for office closures',
        icon: Info,
        time: '3 weeks ago',
        read: true
    }
]

export default notifications
