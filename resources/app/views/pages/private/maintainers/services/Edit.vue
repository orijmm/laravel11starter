<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-service" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="text" :required="true" name="icon" v-model="form.icon"
                    :label="trans('users.labels.icon')" :labelsmall="trans('global.phrases.add_path_icon')" />
                <Dropdown class="mb-4" :options="textcolor" name="icon_color_class"
                    :placeholder="trans('users.labels.select')" v-model="form.icon_color_class"
                    :label="trans('users.labels.icon_color_class')" />
                <TextInput class="mb-4" type="text" :required="true" name="link" v-model="form.link"
                    :label="trans('users.labels.link')" />
                <Dropdown class="mb-4" :options="linkcolor" name="link_color_class"
                    :placeholder="trans('users.labels.select')" v-model="form.link_color_class"
                    :label="trans('users.labels.link_color_class')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive } from "vue";
import { textcolor, linkcolor } from "@/views/pages/private/maintainers/frontUtils/colors";
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
import Form from "@/views/components/Form";
import Table from "@/views/components/Table";
import Dropdown from "@/views/components/input/Dropdown";
import ManteinerService from "@/services/ManteinerService";

export default defineComponent({
    components: {
        Form,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Table,
        Dropdown
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            icon_color_class: undefined,
            icon: undefined,
            title: undefined,
            description: undefined,
            link: undefined,
            link_color_class: undefined
        });

        const page = reactive({
            id: 'edit_service',
            title: trans('global.pages.service_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.services'),
                    to: toUrl('/manteiners/services'),
                },
                {
                    name: trans('global.pages.service_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/manteiners/services'),
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


        const service = new ManteinerService('services');

        function fetchItems() {
            service.find(route.params.id, 'manteiners/services').then((response) => {
                fillObject(form, response.data.model);
                //Dropdown Selected
                console.log(form.icon_color_class, form.link_color_class);
                form.icon_color_class = {id: form.icon_color_class, name: form.icon_color_class}
                form.link_color_class = {id: form.link_color_class, name: form.link_color_class}
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
            service.handleUpdate('edit-service', route.params.id, reduceProperties(form,['icon_color_class', 'link_color_class'], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            linkcolor,
            textcolor
        }
    }
})
</script>
