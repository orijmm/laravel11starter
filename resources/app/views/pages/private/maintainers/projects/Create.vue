<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction">
        <Panel otherClass="overflow-visible">
            <Form id="create-project" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" :readOnly="true" name="slug" v-model="form.slug"
                    :label="trans('users.labels.slug')" />
                <TextInput class="mb-4" type="text" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="text" name="url" v-model="form.url" :label="trans('global.pages.project_url')" />
                <TextInput class="mb-4" type="text" name="client_name" v-model="form.client_name"
                    :label="trans('global.pages.project_client_name')" />
                <TextInput class="mb-4" type="text" name="date" v-model="form.date"
                    :label="trans('global.pages.project_date')" />
                <TextInput class="mb-4" type="text" name="category" v-model="form.category"
                    :label="trans('users.labels.category')" />
                <TextInput class="mb-4" type="text" name="img_alt" v-model="form.img_alt"
                    :label="trans('users.labels.img_alt')" />
                <FormImg @error="errorImg = true" @success="setImgFile" />
                <div class="flex flex-row gap-2">
                    <div class="bg-gray-50 rounded p-1" v-for="(imgI, i) in form.inputImg" :key="`inputImg-${i}`">
                        <button class="file-input__clear text-gray-300" type="button"
                            @click="onClearImg(i, 'inputImg')">
                            <i class="fa fa-times"></i>
                        </button>
                        <img :src="getImgVisual(imgI)" class="object-scale-down h-48 w-96"
                            :alt="trans('users.labels.img')" />
                    </div>
                </div>
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive, ref, watch } from "vue";
import _ from 'lodash';
import { trans } from "@/helpers/i18n";
import { useAuthStore } from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import { clearObject, reduceProperties } from "@/helpers/data";
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import ManteinerService from "@/services/ManteinerService";
import { bgcolor } from "@/views/pages/private/maintainers/frontUtils/colors";
import FormImg from "@/views/pages/private/profile/partials/FormImg.vue";

export default defineComponent({
    name: 'PageProjectCreate',
    components: { Form, Panel, Alert, TextInput, Button, Page, FormImg },
    setup() {
        const { user } = useAuthStore();
        const form = reactive({
            inputImg: [],
            img_alt: undefined,
            category: undefined,
            title: undefined,
            slug: undefined,
            description: undefined,
            url: undefined,
            client_name: undefined,
            date: undefined
        });

        let errorImg = ref(false);

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

        watch(
            () => form.title,
            (title) => {
                if (title) {
                    form.slug = _.kebabCase(title);
                }
            }
        )

        const service = new ManteinerService('projects');

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleCreate('create-project', reduceProperties(form, ['bg_class'], 'id'), null, true).then(() => {
                clearObject(form)
            })
            return false;
        }

        //Asignar el valor del archivo 
        function setImgFile(data) {
            form.inputImg.push(data);
        }

        function getImgVisual(img) {
            return typeof img == 'string' ? img : URL.createObjectURL(img);
        }

        //Borra la imagen
        function onClearImg(i, type) {
            form[type].splice(i, 1);
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
            bgcolor,
            errorImg,
            setImgFile,
            onClearImg,
            getImgVisual
        }
    }
})
</script>
