<template>
    <ul class="dropdown-menu px-2">
        <div v-for="menu in menus" :key="`divlit-${i}`">
            <li v-if="menu.children_recursive.length && isDesktop" class="dropdown dropdown-submenu dropend">
                <div class="d-flex align-items-center">
                    <div class="icon-svg icon-svg-xxs mask-center-contain d-none d-lg-block"
                        :class="menu.icon_color_class" :style="{
                            WebkitMaskImage: `url(${menu.icon})`,
                            maskImage: `url(${menu.icon})`
                        }"></div>
                    <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" :href="menu.url ?? '#'">{{
                        menu.label
                        }}</a>
                </div>
                <NavbarItem v-if="menu.children_recursive.length" :menus="menu.children_recursive"
                    :is-desktop="isDesktop" :is-active-menu="isActiveMenu" :generate-url="generateUrl" />
            </li>
            <li v-else-if="menu.children_recursive.length && !isDesktop" class="nav-item dropdown">
                <a :class="`dropdown-item dropdown-toggle ${isActiveMenu(menu) ? 'active' : ''}`" href="#"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{{ menu.label }}
                </a>
                <NavbarItem v-if="menu.children_recursive.length" :menus="menu.children_recursive"
                    :is-desktop="isDesktop" :is-active-menu="isActiveMenu" :generate-url="generateUrl" />
            </li>
            <li class="nav-item d-flex align-items-center" v-else>
                <div class="icon-svg icon-svg-xxs mask-center-contain  d-none d-lg-block" :class="menu.icon_color_class"
                    :style="{
                        WebkitMaskImage: `url(${menu.icon})`,
                        maskImage: `url(${menu.icon})`
                    }">
                </div>
                <a class="dropdown-item" href="#">{{ menu.label }}</a>
            </li>
        </div>
    </ul>
</template>

<script>
import { useRoute } from "vue-router";

export default {
    name: "NavbarItem",
    props: {
        menus: Object,
        isDesktop: Boolean,
        isActiveMenu: Function,
        generateUrl: Function,
    },
    setup() {
        const route = useRoute();
        return { route };
    },
};
</script>
