import AgoraRTC from 'agora-rtc-sdk-ng'
import type { route as routeFn } from 'ziggy-js'

declare global {
    interface Window {
        AgoraRTC: typeof AgoraRTC
    }

    const route: typeof routeFn
}
