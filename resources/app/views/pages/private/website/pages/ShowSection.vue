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
                    <TextInput class="mb-4" type="text" name="backgroundcolor" v-model="form.backgroundcolor"
                        :label="trans('users.labels.backgroundcolor')" />
                    <TextInput class="mb-4" type="text" name="textcolor" v-model="form.textcolor"
                        :label="trans('users.labels.textcolor')" />
                </div>
            </Form>
        </Panel>

        <Panel :title="trans('global.pages.structure_design')" otherClass="overflow-visible">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 py-3">
                <Button icon="fa fa-plus" type="button"
                    @click="toggleAddItems(sectionList, 'section_id', $route.params.id)" class=""
                    :label="`${trans('global.buttons.add')} ${trans('global.pages.rows')}`">
                </Button>
                <Button icon="fa fa-save" theme="success" type="button" @click="saveItems('sectionList')"
                    class="lg:col-start-4" :label="`${trans('global.buttons.save')} ${trans('global.pages.rows')}`">
                </Button>
            </div>
            <draggable v-model="sectionList.rows" group="people" @start="drag = true" @end="updateOrder(sectionList)"
                item-key="id" class="space-y-4 bg-gray-100 p-6 rounded-lg" animation="200">
                <template #item="{ element, index }">
                    <div
                        class="p-4 bg-white rounded-md shadow-md flex justify-between items-center cursor-move sortable-handle">
                        <!-- <span class="text-gray-200">{{ element.name }}</span> -->
                        <span class="text-gray-200">{{ `${trans('global.pages.row')} ${index + 1}` }}</span>
                        <span>
                            <Tooltip :text="trans('global.actions.delete')"> <i @click="deleteItems(sectionList, index)"
                                    class="text-gray-200 fa fa-times cursor-pointer"></i>
                            </Tooltip>
                        </span>
                    </div>
                </template>
            </draggable>

        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data"
import { toggleAddItems, updateOrder, deleteItems } from "@/helpers/draggable";
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
import draggable from 'vuedraggable';
import Tooltip from "@/views/components/Tooltip";
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
        draggable,
        Tooltip
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: undefined,
            order: undefined,
            backgroundcolor: undefined,
            textcolor: undefined,
            page_id: undefined,
        });

        //Dragable
        let drag = ref(false);

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
            alertHelpers.confirmDanger(function () {
                service.update(route.params.id, sectionList, 'pages/page/updaterows', true);
                return false;
            })
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            drag,
            sectionList,
            saveItems,
            toggleAddItems,
            deleteItems,
            updateOrder
        }
    }
})
</script>

<style scoped>
.sortable-drag {
    background-color: #f3f4f6;
    /* Tailwind's gray-200 */
    transform: scale(1.05);
    transition: transform 0.2s ease;
    cursor: move !important;
}
</style>
