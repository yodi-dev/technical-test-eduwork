import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from '@/Layouts/GuestLayout.vue';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue");

        const module = await pages[`./Pages/${name}.vue`]();

        if (!module || !module.default) {
            throw new Error(`Halaman ${name} tidak ditemukan.`);
        }

        // Pastikan hanya halaman login yang menggunakan GuestLayout
        if (name === "Auth/Login") {
            module.default.layout = GuestLayout;
        } else {
            module.default.layout = module.default.layout || AuthenticatedLayout;
        }

        return module;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
