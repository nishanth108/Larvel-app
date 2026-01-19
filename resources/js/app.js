import "./bootstrap";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Pusher = Pusher;

// 1. INITIALIZE ECHO FIRST
window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    forceTLS: false,
    enabledTransports: ["ws"],
});

// 3. NOW DO CHECKS AND LISTENERS
console.log("Echo initialized:", !!window.Echo);

if (window.Echo?.connector?.pusher?.connection) {
    const connection = window.Echo.connector.pusher.connection;

    connection.bind("connected", () => {
        console.log("%cReverb Connected ✅", "color: green; font-weight: bold");
        console.log("Socket ID:", connection.socket_id);
    });
}
