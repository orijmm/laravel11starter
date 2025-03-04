<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-componenttype" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <Dropdown class="mb-4" :server="'pages/component/type/filename'" :server-per-page="15" :required="true"
                    name="filename" v-model="form.filename" :label="trans('users.labels.filename')"
                    :labelsmall="trans('global.pages.filename_case_sensitive')" :serverSearchMinCharacters="0" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data"
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import PagesService from "@/services/PagesService";
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
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: undefined,
            filename: undefined,
            description: undefined,
        });

        const page = reactive({
            id: 'edit_componenttype',
            title: trans('global.pages.componenttype_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.componenttype'),
                    to: toUrl('/pages/componenttype'),
                },
                {
                    name: trans('global.pages.componenttype_edit'),
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
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new PagesService('componenttype');

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
            })
        });

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-componenttype', route.params.id, reduceProperties(form, [], 'id'));
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
