import './bootstrap';

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import mitt from 'mitt';
import Swal from 'sweetalert2';

// Router routes
import { routes } from './routes';

// Helper singletons
import User from './helper/User';
import Notifications from './helper/Notifications';

// Expose helpers globally for components that reference them (legacy usage).
window.User = User;
window.Notifications = Notifications;
window.Swal = Swal;

// Toast notification mixin.
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});
window.Toast = Toast;

// Vue 3 removed instance $on/$off/$emit, so the former `new Vue()` event bus
// is replaced with a lightweight mitt emitter exposing a compatible API.
const emitter = mitt();
window.Reload = {
    $on: (event, handler) => emitter.on(event, handler),
    $off: (event, handler) => emitter.off(event, handler),
    $emit: (event, payload) => emitter.emit(event, payload),
};

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp({});
app.use(router);
app.mount('#app');
