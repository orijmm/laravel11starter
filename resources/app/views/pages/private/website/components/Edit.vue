<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-component" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('users.labels.componenttype')"
                    :serverSearchMinCharacters="0" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
                        <Button :theme="form.type == 'text' ? 'success': 'outline'" type="button" @click="toggleContent" :label="trans('global.buttons.content_text')" />
                        <Button :theme="form.type == 'img' ? 'success': 'outline'"  type="button" @click="toggleContent" :label="trans('global.buttons.content_img')" />
                    </div>
                    <Dropdown v-if="form.type == 'text'" class="mb-4" :required="true" name="type" :options="numberContent" @input="handleNumberCols"
                    :placeholder="trans('users.labels.number_content')" v-model="form.number_content"
                    :label="trans('users.labels.number_content')" :serverSearchMinCharacters="0" />
            </Form>
        </Panel>
        <Panel otherClass="overflow-visible">
            <div v-for="(content, i) in form.contents" :key="i">
                <TextInput :name="i" class="mb-4" type="text" :required="true" v-model="content.text"
                    :label="`${trans('users.labels.content')} #${i + 1}`" />
            </div>
            <div v-if="form.type == 'img'">
                <FormImg @error="errorImg = true" @success="setImgFile"/>
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
            contentsCopy: undefined,
            type: 'text',
            img: undefined
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
                //copia content para toggleContent()
                form.contentsCopy = response.data.model.contents
                form.type = response.data.model.img ? 'img' : 'text'
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
            console.log(form, 'onsubmit');
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

        function toggleContent(){
            if (form.type == 'text') {
                form.type = 'img';
                form.contents = [];
            }else{
                form.type = 'text';
                form.contents = form.contentsCopy
            }
        }

        function setImgFile(data){
            console.log(data, 'setImgFile');
            form.img = data;
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
            setImgFile
        }
    }
})
</script>
