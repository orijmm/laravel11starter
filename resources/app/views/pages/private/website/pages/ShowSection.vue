<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-section" @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3">
                    <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                        :label="trans('users.labels.name')" />
                    <TextInput class="mb-4" type="text" :required="true" name="order" v-model="form.order"
                        :label="trans('users.labels.order')" />
                    <TextInput class="mb-4" type="text" name="classes" v-model="form.classes"
                        :label="trans('users.labels.classes')" />
                </div>
            </Form>
        </Panel>

        <Panel :title="trans('global.pages.structure_design')" otherClass="overflow-visible">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 py-3">
                <Button icon="fa fa-plus" type="button" theme="info"
                    @click="toggleAddItems(sectionList.rows, 'section_id', $route.params.id)" class=""
                    :label="`${trans('global.buttons.add')} ${trans('global.pages.rows')}`">
                </Button>
                <Button icon="fa fa-save" theme="success" type="button" @click="saveItems('sectionList')"
                    class="lg:col-start-4" :label="`${trans('global.buttons.save')} ${trans('global.pages.rows')}`">
                </Button>
            </div>
            <Draggable v-if="sectionList.rows.length" :sectionList="sectionList" />
            <div v-else class="space-y-4 text-gray-400 bg-gray-100 p-6 rounded-lg text-center">{{
                trans('global.pages.norows') }}</div>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data";
import { toggleAddItems } from "@/helpers/draggable";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import Dropdown from "@/views/components/input/Dropdown";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import PagesService from "@/services/PagesService";
import Tooltip from "@/views/components/Tooltip";
import Draggable from "@/views/components/draggable/Index";
import alertHelpers from "@/helpers/alert";

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
        Tooltip,
        Draggable
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: undefined,
            order: undefined,
            classes: undefined,
            page_id: undefined,
        });

        const sectionList = reactive({
            rows: []
        });

        const service = new PagesService(`page/${route.params.page}/section`);

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                sectionList.rows = response.data.model.rows
                page.loading = false;
            })
        });

        const page = reactive({
            id: 'edit_section',
            title: trans('global.pages.section'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.page'),
                    to: toUrl(`/pages/page/${route.params.page}`),
                },
                {
                    name: trans('global.pages.section'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl(`/pages/page/${route.params.page}`),
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

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-section', route.params.id, reduceProperties(form, [], 'id'), `pages/page/updatesection`);
            return false;
        }

        function saveItems(type) {
            alertHelpers.confirmDanger(async function () {
                try {
                    let response = await service.update(route.params.id, sectionList, 'pages/page/updaterows', true);
                    fillObject(sectionList.rows, response.data.record);
                    return false;
                } catch (error) {
                    console.error('Error:', error);

                }
            })
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            sectionList,
            saveItems,
            toggleAddItems
        }
    }
})
</script>
