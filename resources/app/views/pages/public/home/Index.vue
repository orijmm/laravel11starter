<template>
    <div class="bg-gray-100 flex">
        <aside class="relative bg-theme-600 h-screen w-64 hidden sm:block shadow-xl">
            <div class="p-6 border-b border-theme-600">
                header header
            </div>
            <nav class="text-white text-base py-4 px-3 rounded">
                <!-- <Menu :state="state" :type="'desktop'" /> -->
            </nav>
        </aside>
        <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
            <!-- Desktop Header -->
            <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
                desktop header
            </header>

            <!-- Mobile Header & Nav -->
            <header class="w-full bg-theme-600 py-5 px-6 sm:hidden">
                menu mobile
            </header>

            <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
                <!-- <main class="w-full flex-grow p-6">
                    <router-view />
                </main> -->
                <footer class="w-full bg-white text-center text-sm p-4" v-html="trans('global.phrases.copyright')">
                </footer>
            </div>

        </div>
    </div>
</template>

<script>

import {trans} from "@/helpers/i18n"

export default {
    name: "IndexSite",
    components: {
    },
    setup() {
        return {
            trans,
        }
    }
};
</script>
