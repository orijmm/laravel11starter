<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-component" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('global.menu.componenttype')"
                    :serverSearchMinCharacters="0" />
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
                    <Button :theme="form.type == 'text' ? 'success' : 'outline'" type="button"
                        @click="toggleContent('text')" :label="trans('global.buttons.content_text')" />
                    <Button :theme="form.type == 'img' ? 'success' : 'outline'" type="button"
                        @click="toggleContent('img')" :label="trans('global.buttons.content_img')" />
                </div>
            </Form>
        </Panel>
        <Panel otherClass="overflow-visible">
            <Dropdown v-if="form.type == 'text'" class="mb-4" name="type" :options="numberContent"
                @input="handleNumberCols" :placeholder="trans('users.labels.number_content')"
                v-model="form.number_content" :label="trans('users.labels.number_content')"
                :serverSearchMinCharacters="0" />
            <div v-if="form.type == 'text'" v-for="(content, i) in form.contents" :key="i">
                <TextInput :name="i" class="mb-4" type="text" :required="true" v-model="content.text"
                    :label="`${trans('users.labels.content')} #${i + 1}`" />
            </div>
            <div v-if="form.type == 'img'">
                <div class="grid grid-cols-1">
                    <FormImg @error="errorImg = true" @success="setImgFile" />
                    <div class="flex flex-row gap-2">
                        <div class="bg-gray-50 rounded p-1" v-for="(image, i) in form.img" :key="`img-${i}`">
                            <button class="file-input__clear text-gray-300" type="button" @click="onClearImg(i, 'img')">
                                <i class="fa fa-times"></i>
                            </button>
                            <img :src="getImgVisual(image)" class="object-scale-down h-48 w-96" :alt="trans('users.labels.img')" />
                        </div>
                        <div class="bg-gray-50 rounded p-1" v-for="(imgI, i) in form.inputImg" :key="`inputImg-${i}`">
                            <button class="file-input__clear text-gray-300" type="button" @click="onClearImg(i, 'inputImg')">
                                <i class="fa fa-times"></i>
                            </button>
                            <img :src="getImgVisual(imgI)" class="object-scale-down h-48 w-96" :alt="trans('users.labels.img')" />
                        </div>
                    </div>
                </div>
            </div>
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
import Dropdown from "@/views/components/input/Dropdown";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
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
        Dropdown,
        FormImg
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            component_type_id: undefined,
            number_content: undefined,
            contents: undefined,
            type: 'text',
            img: [],
            inputImg: []
        });

        let errorImg = ref(false);

        const numberContent = ref([
            { id: 1, name: 1 },
            { id: 2, name: 2 },
            { id: 3, name: 3 },
            { id: 4, name: 4 },
            { id: 5, name: 5 },
            { id: 6, name: 6 },
            { id: 7, name: 7 },
            { id: 8, name: 8 },
            { id: 9, name: 9 },
        ]);

        const service = new PagesService('components');

        const page = reactive({
            id: 'edit_component',
            title: trans('global.pages.component_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.components'),
                    to: toUrl('/pages/components'),
                },
                {
                    name: trans('global.pages.component_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: '',
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

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                //Agregar variables a link de regresar
                const actionNode = page.actions.find(action => action.id === 'back');
                if (actionNode) {
                    actionNode.to = toUrl(`pages/page/${response.data.model.section.page_id}/section/${response.data.model.section.id}/column/${response.data.model.column_id}`);
                }

                if (response.data.model.contents.length) {
                    form.number_content = { id: response.data.model.contents.length, name: response.data.model.contents.length }
                }
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
            console.log(form.img);
            service.handleUpdate('edit-component', route.params.id, reduceProperties(form, [], 'id'), null, true);
            return false;
        }

        function handleNumberCols() {
            if (form.number_content.id > form.contents.length) {
                let numberOfElements = form.number_content.id - form.contents.length;
                for (let index = 0; index < numberOfElements; index++) {
                    form.contents.push({ 'type': 'text', 'text': 'ipsum quia dolor sit amet' });
                }
            } else {
                let numberOfElements = form.contents.length - form.number_content.id;
                form.contents.splice(- numberOfElements);
            }
        }

        //Cambiar entre contenido e imagenes
        function toggleContent(type) {
            form.type = type
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
            numberContent,
            handleNumberCols,
            toggleContent,
            errorImg,
            setImgFile,
            onClearImg,
            getImgVisual
        }
    }
})
</script>
