<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-testimonial" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.name')" />
                <TextInput class="mb-4" type="text" :required="true" name="quote" v-model="form.quote"
                    :label="trans('users.labels.quote')" />
                <TextInput class="mb-4" type="text" :required="true" name="avatar_src" v-model="form.avatar_src"
                    :label="trans('users.labels.avatar')" />
                <TextInput class="mb-4" type="text" :required="true" name="img_src" v-model="form.img_src"
                    :label="trans('users.labels.img')" />
                <TextInput class="mb-4" type="text" :required="true" name="img_alt" v-model="form.img_alt"
                    :label="trans('users.labels.img_alt')" />
                <TextInput class="mb-4" type="text" :required="true" name="role" v-model="form.role"
                    :label="trans('users.labels.role')" />
                <Dropdown class="mb-4" :options="bgcolor" name="bg_class" :placeholder="trans('users.labels.select')"
                    v-model="form.bg_class" :label="trans('users.labels.bg_class')" />
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
import Form from "@/views/components/Form";
import Dropdown from "@/views/components/input/Dropdown";
import { bgcolor } from "@/views/pages/private/maintainers/frontUtils/colors";
import ManteinerService from "@/services/ManteinerService";

export default defineComponent({
    components: {
        Form,
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
            quote: undefined,
            avatar_src: undefined,
            img_src: undefined,
            img_alt: undefined,
            role: undefined,
            bg_class: undefined
        });

        const page = reactive({
            id: 'edit_testimonial',
            title: trans('global.pages.testimonial_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.testimonials'),
                    to: toUrl('/manteiners/testimonials'),
                },
                {
                    name: trans('global.pages.testimonial_edit'),
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
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new ManteinerService('testimonials');

        function fetchItems() {
            service.find(route.params.id, 'manteiners/testimonials').then((response) => {
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
            service.handleUpdate('edit-testimonial', route.params.id, reduceProperties(form, ['roles'], 'id'));
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

