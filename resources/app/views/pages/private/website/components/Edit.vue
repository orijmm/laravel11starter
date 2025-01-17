<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-component" @submit.prevent="onSubmit">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('users.labels.componenttype')"
                    :serverSearchMinCharacters="0" />
                <Dropdown class="mb-4" :required="true" name="type" :options="numberContent" @input="handleNumberCols"
                    :placeholder="trans('users.labels.number_content')" v-model="form.number_content"
                    :label="trans('users.labels.number_content')" :serverSearchMinCharacters="0" />
            </Form>
        </Panel>
        <Panel otherClass="overflow-visible">
            <div v-for="(content, i) in form.contents" :key="i">
                <TextInput :name="i" class="mb-4" type="text" :required="true" v-model="content.text"
                    :label="`${trans('users.labels.content')} #${i + 1}`" />
            </div>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref, watch } from "vue";
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

export default defineComponent({
    components: {
        Form,
        FileInput,
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
            component_type_id: undefined,
            number_content: undefined,
            contents: undefined,
        });

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
                page.actions.push({
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl(`pages/page/${response.data.model.section.page_id}/section/${response.data.model.section.id}/column/${response.data.model.column_id}`),
                    theme: 'outline',
                });
                //sectionData.value = response.data.model.section;
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
            service.handleUpdate('edit-component', route.params.id, reduceProperties(form, [], 'id'), null, true);
            return false;
        }

        function handleNumberCols() {
            if (form.number_content.id > form.contents.length) {
                let numberOfElements = form.number_content.id - form.contents.length;
                for (let index = 0; index < numberOfElements; index++) {
                    form.contents.push({ 'type': 'text', 'text': 'ipsum quia dolor sit amet', 'img': '' });
                }
            } else {
                let numberOfElements = form.contents.length - form.number_content.id;
                form.contents.splice(- numberOfElements);
            }
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            numberContent,
            handleNumberCols
        }
    }
})
</script>

<style scoped></style>
