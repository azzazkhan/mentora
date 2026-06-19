<div x-init="initializeClient()">
    @assets
        @vite('resources/js/agora.ts')
    @endassets

    @unless ($joined)
        <div class="flex flex-col items-center justify-center h-screen">
            <h1 class="text-2xl font-bold">{{ $livestream->title }}</h1>
            <p class="text-sm text-gray-500">{{ $livestream->description }}</p>

            <button wire:click="join" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">
                Join as {{ $role }}
            </button>

        </div>
    @endunless

    @if ($joined)
        <div class="h-screen w-screen bg-gray-900 flex flex-col" x-init="{{ $role === 'teacher' ? 'window.joinAsHost()' : 'window.joinAsAudience()' }}">
            <div class="flex-1 relative">
            <div class="w-full h-full bg-black flex items-center justify-center">
                <div class="text-white text-xl opacity-50" id="remoteStream">
                📹 Live Stream
                </div>

                <div class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                🔴 LIVE
                </div>

                @if ($role === 'teacher')
                    <div class="absolute bottom-4 right-4 w-48 h-36 bg-gray-800 rounded-lg border-2 border-gray-600 flex items-center justify-center">
                        <div class="text-white text-sm opacity-75" id="localStream">
                            📷 You
                        </div>
                    </div>
                @endif
            </div>
            </div>

            <div class="bg-gray-800 p-6 border-t border-gray-700">
            <div class="flex justify-center items-center space-x-6">
                <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-full font-medium transition-all duration-200 hover:scale-105 active:scale-95 flex items-center space-x-2 shadow-lg">
                <span class="text-lg">❌</span>
                <span>End Call</span>
                </button>

                <button class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-3 rounded-full font-medium transition-all duration-200 hover:scale-105 active:scale-95 flex items-center space-x-2 shadow-lg">
                <span class="text-lg">📷</span>
                <span>Camera</span>
                </button>

                <button class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-3 rounded-full font-medium transition-all duration-200 hover:scale-105 active:scale-95 flex items-center space-x-2 shadow-lg">
                <span class="text-lg">🎤</span>
                <span>Microphone</span>
                </button>
            </div>
            </div>
        </div>
    @endif

    <script>
        let client = null;
        let localAudioTrack = null;
        let localVideoTrack = null;

        // Initialize the AgoraRTC client
        function initializeClient() {
            client = AgoraRTC.createClient({ mode: "live", codec: "vp8", role: "host" });
            setupEventListeners();
        }

        async function joinAsHost() {
            await client.join("{{ config('services.agora.app_id') }}", '{{ $livestream->uuid }}', null, '{{ $livestream->uid }}');
            // A host can both publish tracks and subscribe to tracks
            client.setClientRole("host");
            // Create and publish local tracks
            await createLocalMediaTracks();
            await publishLocalTracks();
            displayLocalVideo();
        }

        async function joinAsAudience() {
            await client.join(appId, channel, token, uid);

            // Set ultra-low latency level for interactive live streaming
            let clientRoleOptions = { level: 2 };
            // Audience can only subscribe to tracks
            client.setClientRole("audience", clientRoleOptions);
        }

        // Create local audio and video tracks
        async function createLocalMediaTracks() {
            localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            localVideoTrack = await AgoraRTC.createCameraVideoTrack();
        }

        async function publishLocalTracks() {
            await client.publish([localAudioTrack, localVideoTrack]);
        }

        // Handle client events
        function setupEventListeners() {
            // Declare event handler for "user-published"
            client.on("user-published", async (user, mediaType) => {
                // Subscribe to media streams
                await client.subscribe(user, mediaType);
                if (mediaType === "video") {
                    // Specify the ID of the DOM element or pass a DOM object.
                    user.videoTrack.play("remoteStream");
                }
                if (mediaType === "audio") {
                    user.audioTrack.play();
                }
            });

            // Handle the "user-unpublished" event to unsubscribe from the user's media tracks
            client.on("user-unpublished", async (user) => {
                const remotePlayerContainer = document.getElementById(user.uid);
                remotePlayerContainer && remotePlayerContainer.remove();
            });
        }

        // Display local video
        function displayLocalVideo() {
            const localPlayerContainer = document.createElement("div");
            localPlayerContainer.id = uid;
            localPlayerContainer.textContent = `Local user ${uid}`;
            localPlayerContainer.style.width = "640px";
            localPlayerContainer.style.height = "480px";
            document.body.append(localPlayerContainer);
            localVideoTrack.play(localPlayerContainer);
        }

        // Display remote user's video
        function displayRemoteVideo(user) {
            const remotePlayerContainer = document.getElementById("remoteStream");
            remotePlayerContainer.id = user.uid.toString();
            remotePlayerContainer.textContent = `Remote user ${user.uid}`;
            remotePlayerContainer.style.width = "640px";
            remotePlayerContainer.style.height = "480px";
            user.videoTrack.play(remotePlayerContainer);
        }

        // Leave the channel and clean up
        async function leaveChannel() {
            // Stop the local media tracks to release the microphone and camera resources
            if (localAudioTrack) {
                localAudioTrack.close();
                localAudioTrack = null;
            }
            if (localVideoTrack) {
                localVideoTrack.close();
                localVideoTrack = null;
            }
            // Leave the channel
            await client.leave();
        }

    </script>
</div>
