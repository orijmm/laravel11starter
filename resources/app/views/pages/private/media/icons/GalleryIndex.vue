<template>
    <div class="p-2 mx-auto">
        <div v-for="(iconList, category) in icons" :key="category" class="mb-8">
            <h2 class="text-xl font-semibold mb-4 capitalize">{{ category }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                <div v-for="path in iconList" :key="path" class="flex flex-col items-center gap-4 mb-4 border-b pb-2">
                    <img :src="`${path}`" alt="icon" class="w-10 h-10 shrink-0" />
                    <Button type="button" class="text-xs" :label="path" @click="copyToClipboard(path)" theme="light-grey">
                    </Button>
                    <span v-if="copiedPath === path" class="text-green-500 text-xs mt-1">
                        {{ trans('global.pages.copied') }} ✔
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { trans } from "@/helpers/i18n";
import ModelService from '@/services/ModelService';
import { onBeforeMount, ref } from 'vue';
import Button from "@/views/components/input/Button";

export default {
    components: {
        Button
    },
    setup(props) {
        const icons = ref({})
        const copiedPath = ref('')

        const service = new ModelService();

        function fetchItems() {
            service.index(null, 'media/iconsvg').then((response) => {
                console.log(response.data);
                icons.value = response.data
            });
        }

        onBeforeMount(() => {
            fetchItems();
        });

        function copyToClipboard(text) {
            if (!navigator.clipboard) {
                alert('La función de copiar al portapapeles no está disponible en este navegador o contexto.')
                return
            }

            navigator.clipboard.writeText(text).then(() => {
                copiedPath.value = text
                setTimeout(() => {
                    copiedPath.value = ''
                }, 2000)
            }).catch((err) => {
                console.error('Error al copiar al portapapeles:', err)
            })
        }

        return {
            trans,
            icons,
            copiedPath,
            copyToClipboard
        }
    }
}
</script>
