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
        <Panel :title="trans('global.pages.menu_items')">
            <Form id="add-item" @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    <TextInput class="mb-4" type="text" :required="true" name="label" v-model="formItem.label"
                        :label="trans('users.labels.label')" />
                    <TextInput class="mb-4" type="text" :required="true" name="url" v-model="formItem.url"
                        :label="trans('users.labels.url')" />
                    <TextInput class="mb-4" type="text" :required="true" name="description"
                        v-model="formItem.description" :label="trans('users.labels.description')" />
                    <TextInput class="mb-4" type="text" :required="true" name="order" v-model="formItem.order"
                        :label="trans('users.labels.order')" />
                    <TextInput class="mb-4" type="text" :required="true" name="parent_id" v-model="formItem.parent_id"
                        :label="trans('users.labels.parent_id')" />
                    <TextInput class="mb-4" type="text" :required="true" name="menu_id" v-model="formItem.menu_id"
                        :label="trans('users.labels.menu_id')" />
                    <TextInput class="mb-4" type="text" :required="true" name="page_id" v-model="formItem.page_id"
                        :label="trans('users.labels.page_id')" />
                </div>
            </Form>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
            </Table>
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
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import Table from "@/views/components/Table";
import { isAllowed } from "@/helpers/isreq";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Table
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            id: undefined,
            name: undefined,
            description: undefined,
        });

        const formItem = reactive({
            label: undefined,
            url: undefined,
            description: undefined,
            order: undefined,
            parent_id: undefined,
            menu_id: undefined,
            page_id: undefined,
        });

        const page = reactive({
            id: 'edit_menu',
            title: trans('global.pages.menu_edit'),
            filters: false,
            loading: true,
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
                label: trans('users.labels.label'),
                parent_id: trans('users.labels.parent'),
                description: trans('users.labels.description'),
                page_id: trans('global.pages.page'),
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
                    to: toUrl('/pages/menus/{id}'),
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
                        service.delete(params.item.id).then(function (response) {
                            fetchPage(mainQuery);
                        });
                    })
                    break;
            }
        }

        const service = new PagesService('menus');

        onBeforeMount(() => {
            service.find(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                table.records = response.data.model.items;
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
            service.handleUpdate('edit-menu', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        function onSubmitItem() {
            service.handleCreate('add-item', reduceProperties(formItem, [], 'id'), `/pages/menus/${form.id}/storeitem`).then(() => {
                clearObject(formItem)
            })

            return false;
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
            onTablePageChange,
            onTableAction,
            onTableSort
        }
    }
})
</script>

<style scoped></style>
