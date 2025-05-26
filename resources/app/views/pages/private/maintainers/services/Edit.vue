<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-service" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('global.menu.componenttype')"
                    :serverSearchMinCharacters="0" />
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
                <TextInput class="mb-4" type="text" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <div class="text-gray-500 text-sm">Contenido</div>
                <quill-editor v-model:value="form.content" :options="state.editorOption" :disabled="state.disabled" />
                <div class="text-gray-500 text-sm mt-4">{{ trans('users.labels.img') }}</div>
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
                <TextInput class="mb-4" type="text" name="icon" v-model="form.icon" :label="trans('users.labels.icon')"
                    :labelsmall="trans('global.phrases.add_path_icon')" />
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
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
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
import { quillEditor } from 'vue3-quill';
import FormImg from "@/views/pages/private/profile/partials/FormImg.vue";

export default defineComponent({
    components: {
        Form,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Table,
        Dropdown,
        quillEditor,
        FormImg
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
            link_color_class: undefined,
            component_type_id: undefined,
            content: undefined,
            inputImg: [],
            img: [],
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

        const state = reactive({
            _content: '',
            editorOption: {
                placeholder: trans('global.phrases.add_content'),
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote'],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ indent: '-1' }, { indent: '+1' }],
                        [{ size: ['small', false, 'large', 'huge'] }],
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ color: [] }, { background: [] }],
                        [{ align: [] }],
                        ['clean'],
                    ]
                }
            },
            disabled: false
        });

        const service = new ManteinerService('services');

        function fetchItems() {
            service.find(route.params.id, 'manteiners/services').then((response) => {
                fillObject(form, response.data.model);
                //Dropdown Selected
                form.icon_color_class = { id: form.icon_color_class, name: form.icon_color_class }
                form.link_color_class = { id: form.link_color_class, name: form.link_color_class }
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
            service.handleUpdate('edit-service', route.params.id, reduceProperties(form, ['icon_color_class', 'link_color_class'], 'id'), null, true);
            return false;
        }

        let errorImg = ref(false);

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
            linkcolor,
            textcolor,
            state,
            errorImg,
            getImgVisual,
            setImgFile,
            onClearImg
        }
    }
})
</script>
