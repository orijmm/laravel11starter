<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-componenttype" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/component/type/filename'" :server-per-page="15"
                    :required="true" name="filename" v-model="form.filename" :label="trans('users.labels.filename')"
                    :serverSearchMinCharacters="0" />
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" :labelsmall="trans('global.pages.case_sensitive')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive, watch } from "vue";
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
    name: 'PagecomponenttypeCreate',
    components: { Form, FileInput, Panel, Alert, TextInput, Button, Page, Dropdown },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            name: undefined,
            filename: undefined,
            description: undefined,
        });

        const page = reactive({
            id: 'create_componenttype',
            title: trans('global.pages.componenttype_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.componenttype'),
                    to: toUrl('/pages/componenttype'),

                },
                {
                    name: trans('global.pages.componenttype_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/componenttype'),
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

        const service = new PagesService('componenttype');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-componenttype', reduceProperties(form, [], 'id')).then(() => {
                clearObject(form)
            })
            return false;
        }

        watch(
            () => form.filename,
            (filename) => {
                if(filename){
                    form.name = filename.name.split('/')[1];
                }
            }
        )

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
        }
    }
})
</script>

<style scoped></style>
