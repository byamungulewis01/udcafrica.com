import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { computed, createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import PermissionsPlugin from "@/lib/permissions";
import { usePage } from "@inertiajs/vue3";

const page = usePage();

const appName = computed(() => page.props.settings.site.site_title || "UDC Africa");

createInertiaApp({
    title: (title) => `${title} - ${appName.value}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const vueApp = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PermissionsPlugin)
            .use(ZiggyVue);

        return vueApp.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
