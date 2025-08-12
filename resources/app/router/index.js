import { createWebHistory, createRouter } from "vue-router";

import routes from "@/router/routes";
import { useAlertStore } from "@/stores/alert";
import { useAuthStore } from "@/stores/auth";
import { useGlobalStateStore } from "@/stores";

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'active',
    routes,
});



router.beforeEach(async (to, from, next) => {
    const globalStateStore = useGlobalStateStore();
    globalStateStore.setUILoading(true);
    const authStore = useAuthStore();
    const requiresAbility = to?.meta?.requiresAbility;
    const requiresAuth = to?.meta?.requiresAuth;
    const belongsToOwnerOnly = to?.meta?.isOwner;
    //limpiar alertas de formulario 
    const alertStore = useAlertStore();
    alertStore.clear();

    if (!authStore.user) {
        await authStore.getCurrentUser();
    }
    if (!authStore.user) {
        authStore.clearBrowserData();
        if (requiresAuth) {
            next({ name: 'login' })
        }
    }

    if (to?.meta?.isPublicAuthPage && authStore.user) {
        next({ name: 'dashboard' })
        return;
    }

    if (requiresAbility && requiresAuth) {
        if (authStore.hasAbilities(requiresAbility)) {
            next()
        } else {
            next({
                name: 'profile'
            })
        }
    } else if (belongsToOwnerOnly) {
        if (authStore.user.is_owner) {
            next()
        } else {
            next({ name: 'dashboard' })
        }
    } else {
        next()
    }
});

router.afterEach(() => {
    // const globalStore = useGlobalStateStore()
    // // Desactiva el loader con pequeño delay opcional para evitar parpadeo
    // setTimeout(() => {
    //     globalStore.setUILoading(false)
    // }, 700)
})

export default router;
