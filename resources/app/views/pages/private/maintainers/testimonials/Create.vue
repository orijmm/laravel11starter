<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel>
            <Form id="create-testimonial" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name" :label="trans('users.labels.first_name')" :labelsmall="trans('global.pages.lowercase')"/>
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description" :label="trans('users.labels.description')"/>
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
import {clearObject, reduceProperties} from "@/helpers/data";
import {toUrl} from "@/helpers/routing";
import Form from "@/views/components/Form";
import ManteinerService from "@/services/ManteinerService";

export default defineComponent({
    name: 'PageTestimonialCreate',
    components: {Form, FileInput, Panel, Alert, TextInput, Button, Page},
    setup() {
        const {user} = useAuthStore();
        const form = reactive({
            name: undefined,
            description: undefined,
        });

        const page = reactive({
            id: 'create_testimonials',
            title: trans('global.pages.testimonial_create'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.testimonials'),
                    to: toUrl('/manteiners/testimonials'),

                },
                {
                    name: trans('global.pages.testimonial_create'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/manteiners/testimonials'),
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

        const service = new ManteinerService('testimonials');

        function onAction(data) {
            switch(data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-testimonial', reduceProperties(form, [], 'id')).then(() => {
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
