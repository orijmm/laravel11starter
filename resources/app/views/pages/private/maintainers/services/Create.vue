<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-service" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('global.menu.componenttype')"
                    :serverSearchMinCharacters="0" />
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                    <div contenteditable="true" class="form-control" @input="onInput" v-html="content"></div>
                <TextInput class="mb-4" type="text" name="icon" v-model="form.icon"
                    :label="trans('users.labels.icon')" :labelsmall="trans('global.phrases.add_path_icon')" />
                <Dropdown class="mb-4" :options="textcolor" name="icon_color_class"
                    :placeholder="trans('users.labels.select')" v-model="form.icon_color_class"
                    :label="trans('users.labels.icon_color_class')" />
                <TextInput class="mb-4" type="text" name="link" v-model="form.link"
                    :label="trans('users.labels.link')" />
                <Dropdown class="mb-4" :options="linkcolor" name="link_color_class"
                    :placeholder="trans('users.labels.select')" v-model="form.link_color_class"
                    :label="trans('users.labels.link_color_class')" />
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
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import ManteinerService from "@/services/ManteinerService";
import { textcolor, linkcolor } from "@/views/pages/private/maintainers/frontUtils/colors";

export default defineComponent({
    name: 'PageServiceCreate',
    components: { Form, Panel, Alert, TextInput, Dropdown, Button, Page },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            icon_color_class: undefined,
            icon: undefined,
            title: undefined,
            description: undefined,
            link: undefined,
            link_color_class: undefined,
            component_type_id: undefined,
            content: undefined
        });

        const page = reactive({
            id: 'create_services',
            title: trans('global.pages.service_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.services'),
                    to: toUrl('/manteiners/services'),

                },
                {
                    name: trans('global.pages.service_create'),
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
                    name: trans('global.buttons.save'),
                    icon: "fa fa-save",
                    type: 'submit',
                }
            ]
        });

        const service = new ManteinerService('services');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-service', reduceProperties(form, ['icon_color_class', 'link_color_class'], 'id')).then(() => {
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
            textcolor,
            linkcolor
        }
    }
})
</script>
