<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel>
            <Form id="create-role" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name" :label="trans('users.labels.first_name')" :labelsmall="trans('global.pages.lowercase')"/>
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title" :label="trans('users.labels.title')"/>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import {defineComponent, reactive} from "vue";
import {trans} from "@/helpers/i18n";
import {useAuthStore} from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import RolesService from "@/services/RoleService";
import {clearObject, reduceProperties} from "@/helpers/data";
import {toUrl} from "@/helpers/routing";
import Form from "@/views/components/Form";

export default defineComponent({
    name: 'PageAbilityCreate',
    components: {Form, FileInput, Panel, Alert, TextInput, Button, Page},
    setup() {
        const {user} = useAuthStore();
        const form = reactive({
            name: '',
            title: '',
        });

        const page = reactive({
            id: 'create_roles',
            title: trans('global.pages.roles_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.roles'),
                    to: toUrl('/roles'),

                },
                {
                    name: trans('global.pages.roles_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/roles/list'),
                    theme: 'outline',
                },
                {
                    id: 'submit',
                    name: trans('global.buttons.save'),
                    icon: "fa fa-save",
                    type: 'submit',
                }
            ]
        });

        const service = new RolesService();

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-role', reduceProperties(form, 'roles', 'id')).then(() => {
                clearObject(form)
            })
            return false;
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction
        }
    }
})
</script>

<style scoped>

</style>
