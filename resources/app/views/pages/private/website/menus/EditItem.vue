<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="editmenuitem" @submit.prevent="onSubmit">
                {{ section.name }}
                <TextInput class="mb-4" type="text" :required="true" name="label" v-model="form.label"
                    :label="trans('users.labels.label')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Columna 1: Dropdown -->
                    <TextInput class="mb-4" type="text" name="icon" v-model="form.icon"
                        :label="trans('users.labels.icon')" :labelsmall="trans('global.phrases.add_path_icon')" />
                    <!-- Columna 2: Color preview alineado abajo -->
                    <div class="flex flex-col justify-end mb-4">
                        <a target="_blank" href="/panel/pages/list/iconsvg"><Button type="button"
                                :label="trans('global.pages.icon_gallery_svg')" /></a>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Columna 1: Dropdown -->
                    <Dropdown class="mb-4" :options="textcolor" name="icon_color_class"
                        @update:model-value="e => getColorExample(e)" :placeholder="trans('users.labels.select')"
                        v-model="form.icon_color_class" :label="trans('users.labels.icon_color_class')" />
                    <!-- Columna 2: Color preview alineado abajo -->
                    <div v-if="colorHex" class="flex flex-col justify-end mb-4">
                        <div class="p-2 border rounded-md text-gray-200"
                            :style="{ background: colorHex, fontSize: '0.9rem' }">
                            {{ colorHex }}
                        </div>
                    </div>
                </div>
                <Dropdown class="mb-4" :options="menuItems.options" optionLabel="label" name="label"
                    v-model="form.parent_id" :label="trans('users.labels.parent_id')" />
                <TextInput class="mb-4" type="number" :required="true" name="order" v-model="form.order"
                    :label="trans('users.labels.order')" />
                <div class="grid grid-cols-2 gap-2 bg-teal-50 rounded p-2">
                    <Dropdown @update:model-value="e => setUrl('page', e)" class="mb-4" :server="'pages/page'"
                        :server-per-page="15" name="type" v-model="form.page_id" :label="trans('global.pages.page')"
                        :serverSearchMinCharacters="0" />
                    <Dropdown @update:model-value="e => setUrl('section', e)" class="mb-4"
                        :server="'pages/page/sections'" :server-per-page="15" name="type" v-model="form.section"
                        :label="trans('global.pages.section')" :serverSearchMinCharacters="0" />
                </div>
                <TextInput class="mb-4" type="text" name="url" v-model="form.url" :label="trans('users.labels.url')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data";
import { setColorSample } from "@/helpers/SetColor"
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import ModelService from "@/services/ModelService";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import Form from "@/views/components/Form";
import Dropdown from "@/views/components/input/Dropdown";
import { textcolor } from "@/views/pages/private/maintainers/frontUtils/colors";

export default defineComponent({
    components: {
        Form,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Dropdown,
        setColorSample
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            label: undefined,
            description: undefined,
            url: undefined,
            order: undefined,
            page_id: undefined,
            parent_id: undefined,
            icon: undefined,
            icon_color_class: undefined
        });

        let section = ref('');

        let colorHex = ref(null);

        const menuItems = reactive({
            options: []
        });

        const page = reactive({
            id: 'edit_menu_item',
            title: trans('global.pages.menu_items'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.menus'),
                    to: toUrl(`/pages/menus/${route.params.menu}`),
                },
                {
                    name: trans('global.pages.menu_items'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl(`/pages/menus/${route.params.menu}`),
                    theme: 'outline',
                },
                {
                    id: 'submit',
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new ModelService;

        onBeforeMount(() => {
            service.find(route.params.id, `pages/menus/${route.params.menu}/showitem`).then((response) => {
                fillObject(form, response.data.model);
                menuItems.options = response.data.parents;
                page.loading = false;
                form.icon_color_class = { id: form.icon_color_class, name: form.icon_color_class }
                colorHex.value = setColorSample(form.icon_color_class);
            });
        });

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('editmenuitem', route.params.id, reduceProperties(form, ['parent_id', 'page_id', 'icon_color_class'], 'id'), `pages/menus/${route.params.menu}/updateitem`);
            return false;
        }

        function setUrl(type, even = null) {
            if (type == 'page') {
                form.section = undefined;
                form.url = undefined;
            } else {
                form.url = '#section-' + even.name;
                form.page_id = undefined;
            }
        }

        function getColorExample(event) {
            colorHex.value = setColorSample(event);
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            menuItems,
            setUrl,
            section,
            textcolor,
            getColorExample,
            colorHex
        }
    }
})
</script>

<style scoped></style>
