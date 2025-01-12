<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-page" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" :labelsmall="trans('global.pages.lowercase')" />
                <TextInput class="mb-4" type="text" :required="true" name="slug" v-model="form.slug"
                    :label="trans('users.labels.slug')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <Dropdown class="mb-4" :server="'pages/templates'" :server-per-page="15" :required="true" name="type"
                    v-model="form.template_id" :label="trans('users.labels.templates')"
                    :serverSearchMinCharacters="0" />
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
import Dropdown from "@/views/components/input/Dropdown";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import PagesService from "@/services/PagesService";
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";

export default defineComponent({
    name: 'PagePageCreate',
    components: { Form, FileInput, Panel, Alert, TextInput, Button, Page, Dropdown },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            title: undefined,
            description: undefined,
            slug: undefined,
            template_id: undefined
        });

        const page = reactive({
            id: 'create_page',
            title: trans('global.pages.page_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.page'),
                    to: toUrl('/pages/page'),

                },
                {
                    name: trans('global.pages.page_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/page'),
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

        const service = new PagesService('page');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-page', reduceProperties(form, [], 'id')).then(() => {
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
