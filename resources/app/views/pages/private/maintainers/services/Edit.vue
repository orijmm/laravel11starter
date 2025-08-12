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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Columna 1: Dropdown -->
                    <TextInput class="mb-4" type="text" name="icon" v-model="form.icon" :label="trans('users.labels.icon')"
                    :labelsmall="trans('global.phrases.add_path_icon')" />
                    <!-- Columna 2: Color preview alineado abajo -->
                    <div class="flex flex-col justify-end mb-4">
                        <a target="_blank" href="/panel/pages/list/iconsvg"><Button type="button" :label="trans('global.pages.icon_gallery_svg')" /></a>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <!-- Columna 1: Dropdown -->
                    <Dropdown class="mb-4" :options="textcolor" name="icon_color_class"
                        @update:model-value="e => getColorExample(e)" :placeholder="trans('users.labels.select')"
                        v-model="form.icon_color_class" :label="trans('users.labels.icon_color_class')" />
                    <!-- Columna 2: Color preview alineado abajo -->
                    <div class="flex flex-col justify-end mb-4">
                        <div v-if="colorHex" class="p-2 border rounded-md text-gray-200"
                            :style="{ background: colorHex, fontSize: '0.9rem' }">
                            {{ colorHex }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 bg-teal-50 rounded p-2">
                    <TextInput class="mb-4" type="text" name="link" v-model="form.link"
                        :label="trans('users.labels.link')" @update:model-value="e => setUrl('link', e)" />
                    <Dropdown @update:model-value="e => setUrl('page', e)" class="mb-4" :server="'pages/page'"
                        :server-per-page="15" name="type" v-model="form.page_id" :label="trans('global.pages.page')"
                        :serverSearchMinCharacters="0" />
                </div>
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
import { setColorSample } from "@/helpers/SetColor"
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
        FormImg,
        setColorSample
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
            page_id: undefined,
            link_color_class: undefined,
            component_type_id: undefined,
            content: undefined,
            inputImg: [],
            img: [],
        });

        let colorHex = ref(null);

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
            _content: form.content ?? '',
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
                colorHex.value = setColorSample(form.icon_color_class);
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

        function setUrl(type, even = null) {
            if (type == 'page') {
                form.link = undefined;
            } else {
                form.page_id = undefined;
            }
        }

        function getColorExample(event) {
            colorHex.value = setColorSample(event);
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
            getColorExample,
            colorHex,
            state,
            errorImg,
            getImgVisual,
            setImgFile,
            onClearImg,
            setUrl
        }
    }
})
</script>
