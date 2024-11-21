<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-section" @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3">
                    <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                        :label="trans('users.labels.name')" />
                    <TextInput class="mb-4" type="text" :required="true" name="order" v-model="form.order"
                        :label="trans('users.labels.order')" />
                    <TextInput class="mb-4" type="text" name="backgroundcolor" v-model="form.backgroundcolor"
                        :label="trans('users.labels.backgroundcolor')" />
                    <TextInput class="mb-4" type="text" name="textcolor" v-model="form.textcolor"
                        :label="trans('users.labels.textcolor')" />
                </div>
            </Form>
        </Panel>
        <Panel :title="trans('global.pages.structure_design')" otherClass="">
            
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
import Dropdown from "@/views/components/input/Dropdown";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import PagesService from "@/services/PagesService";

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
            order: undefined,
            backgroundcolor: undefined,
            textcolor: undefined,
            page_id: undefined,
        });

        const service = new PagesService(`page/${route.params.page}/section`);

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
            })
        });

        const page = reactive({
            id: 'edit_section',
            title: trans('global.pages.section'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.page'),
                    to: toUrl(`/pages/page/${route.params.page}`),
                },
                {
                    name: trans('global.pages.section'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl(`/pages/page/${route.params.page}`),
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

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-section', route.params.id, reduceProperties(form, [], 'id'));
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

<style scoped></style>
