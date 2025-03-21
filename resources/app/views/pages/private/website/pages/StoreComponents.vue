<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
                <TextInput sizeInput="md" type="text" name="classes" v-model="classesCol.classes"
                    :label="trans('global.pages.column_classes')" />
                <div class="flex items-end">
                    <Button type="button" @click="updateColumn" :label="trans('global.buttons.add')" />
                </div>
            </div>
        </Panel>
        <Panel otherClass="overflow-visible">
            <div class="grid grid-cols-1 gap-1">
                <h2 class="text-md font-bold text-gray-500 pb-2">Agregar componentes a la columna ID #{{
                    $route.params.id
                }}</h2>
                <Form id="add-component" @submit.prevent="onSubmitComponent">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-1">
                        <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                            name="type" v-model="form.component_type_id" :label="trans('global.menu.componenttype')"
                            :placeholder="trans('global.menu.componenttype')" :serverSearchMinCharacters="0" />
                        <Dropdown class="mb-4" :required="true" name="type" :options="numberContent"
                            :placeholder="trans('users.labels.number_content')" v-model="form.number_content"
                            :label="trans('users.labels.number_content')" :serverSearchMinCharacters="0" />
                        <div class="content-center">
                            <Button type="button" @click="onSubmitComponent" :label="trans('global.buttons.add')" />
                        </div>
                    </div>
                </Form>
                <hr class="my-12 h-0.5 border-x  bg-neutral-100 dark:bg-white/10" />
                <h3 class="text-gray-500 my-2">{{ trans('global.pages.added_components') }}</h3>
                <div>
                    <ul class="flex-column space-y space-y-4 text-sm">
                        <li v-for="comp in allComp.components" :key="comp.id"
                            :class="{ 'bg-gray-300': selectedComponent === comp.id }"
                            class="flex justify-between items-center px-4 py-3 bg-gray-200 rounded-lg w-full hover:bg-gray-300 text-gray-500">
                            <a href="#">
                                {{ comp.componenttype.name }}
                            </a>
                            <Tooltip :text="trans('global.actions.edit')">
                                <a :href="`/panel/pages/components/${comp.id}`">
                                    <i class="text-gray-500 fa fa-edit cursor-pointer"></i>
                                </a>
                            </Tooltip>

                            <Tooltip :text="trans('global.actions.delete')">
                                <a @click="deleteComponent(comp.id)">
                                    <i class="text-gray-500 fa fa-trash cursor-pointer"></i>
                                </a>
                            </Tooltip>
                        </li>
                    </ul>
                </div>
            </div>
        </Panel>
        <Panel otherClass="overflow-visible">
            <div class="grid grid-cols-1 gap-3">

            </div>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, reactive, onBeforeMount, ref } from "vue";
import { toUrl } from "@/helpers/routing";
import { trans } from "@/helpers/i18n";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import { useRoute } from "vue-router";
import ModelService from "@/services/ModelService";
import Dropdown from "@/views/components/input/Dropdown";
import Button from "@/views/components/input/Button";
import { clearObject, reduceProperties } from "@/helpers/data";
import TextInput from "@/views/components/input/TextInput";
import alertHelpers from "@/helpers/alert";
import Tooltip from "@/views/components/Tooltip";

export default defineComponent({
    components: { Panel, Page, Dropdown, Button, TextInput, Tooltip },
    setup() {
        const route = useRoute();
        const form = reactive({
            id: undefined,
            filename: undefined,
            number_content: undefined
        });

        let classesCol = reactive({
            classes: null
        });

        const allComp = reactive({
            components: undefined
        });

        let selectedComponent = ref(null);

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

        const page = reactive({
            id: 'edit_componenttype',
            title: trans('global.buttons.store_components'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.section'),
                    to: toUrl(`/pages/page/${route.params.page}/section/${route.params.section}`),
                },
                {
                    name: trans('global.buttons.store_components'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl(`/pages/page/${route.params.page}/section/${route.params.section}`),
                    theme: 'outline',
                }
            ]
        });

        function selectComponent(id) {
            selectedComponent.value = id; // Actualiza el componente seleccionado
        }

        const service = new ModelService;

        function fetchItems() {
            service.find(route.params.id, 'pages/page/column')
                .then((response) => {
                    form.id = response.data.column.id
                    allComp.components = response.data.column.components
                    classesCol.classes = response.data.column.classes
                    page.loading = false
                });
        }

        onBeforeMount(() => {
            fetchItems();
        });

        function updateColumn() {
            service.handleUpdate('classes', route.params.id, reduceProperties(classesCol, [], 'id'), 'pages/page/update/column');
            return false;
        }

        function onSubmitComponent() {
            service.handleCreate('add-component', reduceProperties(form, [], 'id'), `/pages/page/column/${form.id}/storecomponent`).then(() => {
                clearObject(form)
            }).then(response => {
                fetchItems();
            });
            return false;
        }

        function deleteComponent(componentId) {
            alertHelpers.confirmWarning(function () {
                service.delete(componentId, 'pages/components').then(function () {
                    fetchItems();
                });
            })
        }

        return {
            trans,
            page,
            form,
            allComp,
            numberContent,
            fetchItems,
            onSubmitComponent,
            selectedComponent,
            selectComponent,
            deleteComponent,
            classesCol,
            updateColumn
        }
    }
})
</script>