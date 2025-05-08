<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-project" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" :readOnly="true" name="slug" v-model="form.slug"
                    :label="trans('users.labels.slug')" />
                <TextInput class="mb-4" type="text" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="text" name="url" v-model="form.url"
                    :label="trans('global.pages.project_url')" />
                <TextInput class="mb-4" type="text" name="client_name" v-model="form.client_name"
                    :label="trans('global.pages.project_client_name')" />
                <TextInput class="mb-4" type="date" name="date" v-model="form.date"
                    :label="trans('global.pages.project_date')" />
                <TextInput class="mb-4" type="text" name="category" v-model="form.category"
                    :label="trans('users.labels.category')" />
                <TextInput class="mb-4" type="text" name="img_alt" v-model="form.img_alt"
                    :label="trans('users.labels.img_alt')" />
                <FormImg @error="errorImg = true" @success="setImgFile" />
                <div class="flex flex-row gap-2">
                    <div class="bg-gray-50 rounded p-1" v-for="(image, i) in form.img" :key="`img-${i}`">
                        <button class="file-input__clear text-gray-300" type="button" @click="onClearImg(i, 'img')">
                            <i class="fa fa-times"></i>
                        </button>
                        <img :src="getImgVisual(image)" class="object-scale-down h-48 w-96"
                            :alt="trans('users.labels.img')" />
                    </div>
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
import { defineComponent, onBeforeMount, reactive, ref, watch } from "vue";
import _ from 'lodash';
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
import FormImg from "@/views/pages/private/profile/partials/FormImg.vue";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        FormImg
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            inputImg: [],
            img: [],
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

        watch(
            () => form.title,
            (title) => {
                if (title) {
                    form.slug = _.kebabCase(title);
                }
            }
        )

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
            // se agrega null, true para archivos
            service.handleUpdate('edit-project', route.params.id, reduceProperties(form, [], 'id'), null, true);
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
            onSubmit,
            onAction,
            page,
            bgcolor,
            errorImg,
            setImgFile,
            onClearImg,
            getImgVisual
        }
    }
})
</script>
