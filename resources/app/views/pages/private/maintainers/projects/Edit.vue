<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel>
            <Form id="edit-project" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive } from "vue";
import alertHelpers from "@/helpers/alert";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties, clearObject } from "@/helpers/data"
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import Table from "@/views/components/Table";
import Dropdown from "@/views/components/input/Dropdown";
import { isAllowed } from "@/helpers/isreq";
import ModelService from "@/services/ModelService";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        TextInput,
        Button,
        Page,
        Table,
        Dropdown
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

        const page = reactive({
            id: 'edit_project',
            title: trans('global.pages.project_edit'),
            filters: false,
            loading: true,
            toggleAddItems: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.projects'),
                    to: toUrl('/manteiners/projects'),
                },
                {
                    name: trans('global.pages.project_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/manteiners/projects'),
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

        //tabla de items de project
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
                    to: toUrl(`/manteiners/projects/${route.params.id}/showitem/{id}`),
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
                        service.deleteCustom(`pages/projects/${params.item.id}/deleteitem`).then(function (response) {
                            fetchItems();
                        });
                    })
                    break;
            }
        }

        const service = new ModelService;

        function fetchItems() {
            service.find(route.params.id, 'pages/projects').then((response) => {
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
            service.handleUpdate('edit-project', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            onSubmit,
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
