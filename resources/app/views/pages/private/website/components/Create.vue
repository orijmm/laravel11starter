<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-component" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" :labelsmall="trans('global.pages.lowercase')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="textarea" :required="true" name="content" v-model="form.content"
                    :label="trans('users.labels.content')" />
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('users.labels.componenttype')"
                    :serverSearchMinCharacters="0" />
                <TextInput class="mb-4" type="text" :required="true" name="filename" v-model="form.filename"
                    :label="trans('users.labels.filename')" :labelsmall="trans('global.pages.filename_case_sensitive')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import { useAuthStore } from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import PagesService from "@/services/PagesService";
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import Dropdown from "@/views/components/input/Dropdown";

export default defineComponent({
    name: 'PageMenuCreate',
    components: { Form, FileInput, Panel, Alert, TextInput, Button, Page, Dropdown },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            content: undefined,
            name: undefined,
            description: undefined,
            component_type_id: undefined,
            filename: undefined
        });

        const page = reactive({
            id: 'create_components',
            title: trans('global.pages.component_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.components'),
                    to: toUrl('/pages/components'),

                },
                {
                    name: trans('global.pages.component_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/components'),
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

        const service = new PagesService('components');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-component', reduceProperties(form, [], 'id')).then(() => {
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

<style scoped></style>
