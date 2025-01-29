<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction" :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-menu_item" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="label" v-model="form.label" :label="trans('users.labels.label')"/>
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description" :label="trans('users.labels.description')"/>
                <TextInput class="mb-4" type="text" name="url" v-model="form.url"
                            :label="trans('users.labels.url')" />
                <TextInput class="mb-4" type="number" :required="true" name="order" v-model="form.order"
                :label="trans('users.labels.order')" />
                <Dropdown class="mb-4" :server="'pages/page'" :server-per-page="15" 
                            name="type" v-model="form.page_id" :label="trans('global.pages.page')"
                            :serverSearchMinCharacters="0" />
                <Dropdown class="mb-4" :options="menuItems.options" optionLabel="label"
                    name="label" v-model="form.parent_id" :label="trans('users.labels.parent_id')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, onBeforeMount, reactive} from "vue";
import {trans} from "@/helpers/i18n";
import {fillObject, reduceProperties} from "@/helpers/data"
import {useRoute} from "vue-router";
import {useAuthStore} from "@/stores/auth";
import {toUrl} from "@/helpers/routing";
import ModelService from "@/services/ModelService";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import Dropdown from "@/views/components/input/Dropdown";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Dropdown
    },
    setup() {
        const {user} = useAuthStore();
        const route = useRoute();
        const form = reactive({
            label: undefined,
            description: undefined,
            url: undefined,
            order: undefined,
            page_id: undefined,
            parent_id: undefined
        });

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
            });
        });

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-menu_item', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            menuItems
        }
    }
})
</script>

<style scoped>

</style>
