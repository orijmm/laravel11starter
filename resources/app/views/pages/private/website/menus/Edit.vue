<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel>
            <Form id="edit-menu" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
            </Form>
        </Panel>
        <Panel :title="trans('global.pages.menu_items')" otherClass="">
            <div class="text-right mb-4">
                <Button type="button" @click="toggleAddItems"
                    :label="`${trans('global.buttons.add')} ${trans('global.pages.menu_item')}`" />
            </div>
            <div v-if="page.toggleAddItems">
                <Form id="add-item" @submit.prevent="onSubmitItem">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <TextInput class="mb-4" type="text" :required="true" name="label" v-model="formItem.label"
                            :label="trans('users.labels.label')" />
                        <TextInput class="mb-4" type="text" name="url" v-model="formItem.url"
                            :label="trans('users.labels.url')" />
                        <TextInput class="mb-4" type="text" :required="true" name="description"
                            v-model="formItem.description" :label="trans('users.labels.description')" />
                        <TextInput class="mb-4" type="text" name="icon" v-model="formItem.icon"
                            :label="trans('users.labels.icon')" :labelsmall="trans('global.phrases.add_path_icon')" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <!-- Columna 1: Dropdown -->
                            <Dropdown class="mb-4" :options="textcolor" name="icon_color_class"
                                @update:model-value="e => getColorExample(e)"
                                :placeholder="trans('users.labels.select')" v-model="formItem.icon_color_class"
                                :label="trans('users.labels.icon_color_class')" />
                            <!-- Columna 2: Color preview alineado abajo -->
                            <div v-if="colorHex" class="flex flex-col justify-end mb-4">
                                <div class="p-2 border rounded-md text-gray-200"
                                    :style="{ background: colorHex, fontSize: '0.9rem' }">
                                    {{ colorHex }}
                                </div>
                            </div>
                        </div>
                        <TextInput class="mb-4" type="number" :required="true" name="order" v-model="formItem.order"
                            :label="trans('users.labels.order')" />
                        <Dropdown class="mb-4" :server="'pages/page'" :server-per-page="15" name="type"
                            v-model="formItem.page_id" :label="trans('global.pages.page')"
                            :serverSearchMinCharacters="0" />
                        <Dropdown class="mb-4" :options="form.items" optionLabel="label" :serverSearchMinCharacters="0"
                            name="label" v-model="formItem.parent_id" :label="trans('users.labels.parent_id')" />
                    </div>
                    <div class="text-right mb-4">
                        <Button type="button" @click="onSubmitItem" :label="trans('global.buttons.add')" />
                    </div>
                </Form>
            </div>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
                <template v-slot:content-page="props">
                    <div>
                        {{ props.item.page?.title ?? '-' }}
                    </div>
                </template>
                <template v-slot:content-parent="props">
                    <div>
                        {{ props.item.parent?.label ?? '-' }}
                    </div>
                </template>
            </Table>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
import alertHelpers from "@/helpers/alert";
import { trans } from "@/helpers/i18n";
import { setColorSample } from "@/helpers/SetColor"
import { fillObject, reduceProperties, clearObject } from "@/helpers/data"
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
import { isAllowed } from "@/helpers/isreq";
import ModelService from "@/services/ModelService";
import { textcolor } from "@/views/pages/private/maintainers/frontUtils/colors";

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
        setColorSample
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            id: undefined,
            name: undefined,
            description: undefined,
            items: undefined
        });

        const formItem = reactive({
            label: undefined,
            url: undefined,
            description: undefined,
            order: undefined,
            parent_id: undefined,
            menu_id: undefined,
            page_id: undefined,
            icon: undefined,
            icon_color_class: undefined
        });

        let colorHex = ref(null);

        const page = reactive({
            id: 'edit_menu',
            title: trans('global.pages.menu_edit'),
            filters: false,
            loading: true,
            toggleAddItems: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.menus'),
                    to: toUrl('/pages/menus'),
                },
                {
                    name: trans('global.pages.menu_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/menus'),
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

        //tabla de items de menu
        const table = reactive({
            headers: {
                order: trans('users.labels.order'),
                label: trans('users.labels.label'),
                parent: trans('users.labels.parent'),
                description: trans('users.labels.description'),
                page: trans('global.pages.page'),
            },
            sorting: {
                name: true,
            },
            pagination: {
                meta: null,
                links: null,
            },
            actions: {
                edit: {
                    id: 'edit',
                    name: trans('global.actions.edit'),
                    icon: "fa fa-edit",
                    showName: false,
                    to: toUrl(`/pages/menus/${route.params.id}/showitem/{id}`),
                    isAllowed: isAllowed(['edit_pages'])
                },
                delete: {
                    id: 'delete',
                    name: trans('global.actions.delete'),
                    icon: "fa fa-trash",
                    showName: false,
                    danger: true,
                    isAllowed: isAllowed(['delete_pages'])
                }
            },
            loading: false,
            records: null
        })

        function onTableSort(params) {
            mainQuery.sort = params;
        }

        function onTablePageChange(page) {
            mainQuery.page = page;
        }

        function onTableAction(params) {
            switch (params.action.id) {
                case 'delete':
                    alertHelpers.confirmWarning(function () {
                        service.deleteCustom(`pages/menus/${params.item.id}/deleteitem`).then(function (response) {
                            fetchItems();
                        });
                    })
                    break;
            }
        }

        const service = new ModelService;

        function fetchItems() {
            service.find(route.params.id, 'pages/menus').then((response) => {
                fillObject(form, response.data.model);
                table.records = response.data.model.items;
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
            service.handleUpdate('edit-menu', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        function onSubmitItem() {
            service.handleCreate('add-item', reduceProperties(formItem, ['icon_color_class'], 'id'), `/pages/menus/${form.id}/storeitem`).then(() => {
                clearObject(formItem)
            }).then(response => {
                fetchItems();
            });
            return false;
        }

        function toggleAddItems() {
            page.toggleAddItems = !page.toggleAddItems;
        }

        function getColorExample(event) {
            colorHex.value = setColorSample(event);
        }

        return {
            trans,
            user,
            form,
            formItem,
            onSubmit,
            onSubmitItem,
            onAction,
            page,
            table,
            textcolor,
            colorHex,
            onTablePageChange,
            onTableAction,
            onTableSort,
            toggleAddItems,
            getColorExample
        }
    }
})
</script>

<style scoped></style>
