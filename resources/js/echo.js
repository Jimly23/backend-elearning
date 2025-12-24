import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true, // Tambahkan ini untuk performa
});

// console.log("MENCOBA KONEK KE VPS...");

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: 'local', // sesuai .env vps
//     wsHost: 'elearning.bitblock.my.id', 
//     wsPort: 443,
//     wssPort: 443,
//     forceTLS: true,
//     enabledTransports: ['ws', 'wss']
// });
