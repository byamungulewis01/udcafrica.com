import { usePage } from '@inertiajs/vue3';

export default {
  install(app) {
    app.config.globalProperties.$can = (permission) => {
      const permissions = usePage().props.auth?.user?.permissions ?? [];
      return permissions.includes(permission);
    };
  }
};
