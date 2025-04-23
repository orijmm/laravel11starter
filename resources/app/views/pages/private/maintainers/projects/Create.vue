<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-project" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="text" :required="true" name="link" v-model="form.link"
                    :label="trans('users.labels.link')" />
                <TextInput class="mb-4" type="text" :required="true" name="category" v-model="form.category"
                    :label="trans('users.labels.category')" />
                <TextInput class="mb-4" type="text" :required="true" name="img_src" v-model="form.img_src"
                    :label="trans('users.labels.img_src')" />
                <TextInput class="mb-4" type="text" :required="true" name="img_alt" v-model="form.img_alt"
                    :label="trans('users.labels.img_alt')" />
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
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import ManteinerService from "@/services/ManteinerService";
import { bgcolor } from "@/views/pages/private/maintainers/frontUtils/colors";

export default defineComponent({
    name: 'PageProjectCreate',
    components: { Form, FileInput, Panel, Alert, TextInput, Button, Page },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            img_src: undefined,
            img_alt: undefined,
            link: undefined,
            category: undefined,
            title: undefined,
            description: undefined
        });

        const page = reactive({
            id: 'create_projects',
            title: trans('global.pages.project_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.projects'),
                    to: toUrl('/manteiners/projects'),

                },
                {
                    name: trans('global.pages.project_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/manteiners/projects'),
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

        const service = new ManteinerService('projects');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-project', reduceProperties(form, ['bg_class'], 'id')).then(() => {
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
            onAction,
            bgcolor
        }
    }
})
</script>
