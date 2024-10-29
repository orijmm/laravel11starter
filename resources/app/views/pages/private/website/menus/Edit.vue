<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction" :is-loading="page.loading">
        <Panel>
            <Form id="edit-menu" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name" :label="trans('users.labels.first_name')"/>
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description" :label="trans('users.labels.description')"/>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, onBeforeMount, reactive, ref} from "vue";
import {trans} from "@/helpers/i18n";
import {fillObject, reduceProperties} from "@/helpers/data"
import {useRoute} from "vue-router";
import {useAuthStore} from "@/stores/auth";
import {toUrl} from "@/helpers/routing";
import PagesService from "@/services/PagesService";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        TextInput,
        Button,
        Page
    },
    setup() {
        const {user} = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: '',
            description: '',
        });

        const page = reactive({
            id: 'edit_menu',
            title: trans('global.pages.menu_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.menus'),
                    to: toUrl('/pages/menus'),
                },
                {
                    name: trans('global.pages.menu_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/menus'),
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

        const service = new PagesService('menus');

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
            })
        });

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-menu', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page
        }
    }
})
</script>

<style scoped>

</style>
