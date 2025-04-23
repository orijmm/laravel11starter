<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-project" @submit.prevent="onSubmit">
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
import { defineComponent, onBeforeMount, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data"
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import { bgcolor } from "@/views/pages/private/maintainers/frontUtils/colors";
import ManteinerService from "@/services/ManteinerService";

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
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            img_src: undefined,
            img_alt: undefined,
            link: undefined,
            category: undefined,
            title: undefined,
            description: undefined
        });

        const page = reactive({
            id: 'edit_project',
            title: trans('global.pages.project_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.projects'),
                    to: toUrl('/manteiners/projects'),
                },
                {
                    name: trans('global.pages.project_edit'),
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
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new ManteinerService('projects');

        function fetchItems() {
            service.find(route.params.id, 'manteiners/projects').then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
            });
        }

        onBeforeMount(() => {
            fetchItems();
        });

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-project', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            bgcolor
        }
    }
})
</script>
