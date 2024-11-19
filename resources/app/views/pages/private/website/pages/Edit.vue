<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <Form id="edit-page" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" :labelsmall="trans('global.pages.lowercase')" />
                <TextInput class="mb-4" type="text" :required="true" name="slug" v-model="form.slug"
                    :label="trans('users.labels.slug')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <Dropdown class="mb-4" :server="'pages/templates'" :server-per-page="15" :required="true" name="type"
                    v-model="form.template_id" :label="trans('users.labels.templates')"
                    :serverSearchMinCharacters="0" />
            </Form>
        </Panel>
        <Panel :title="trans('global.pages.sections')" otherClass="">
            <div class="text-right mb-4">
                <Button type="button" @click="toggleAddItems"
                    :label="page.toggleAddItems? `${trans('global.buttons.hide')}` :`${trans('global.buttons.add')} ${trans('global.pages.section')}`" />
            </div>
            <div v-if="page.toggleAddItems">
                <Form id="add-item" @submit.prevent="onSubmitSection">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-3">
                        <TextInput class="mb-4" type="text" :required="true" name="name" v-model="formItem.name"
                            :label="trans('users.labels.name')" />
                        <TextInput class="mb-4" type="text" :required="true" name="backgroundcolor"
                            v-model="formItem.backgroundcolor" :label="trans('users.labels.backgroundcolor')" />
                        <TextInput class="mb-4" type="text" :required="true" name="textcolor"
                            v-model="formItem.textcolor" :label="trans('users.labels.textcolor')" />
                        <TextInput class="mb-4" type="number" :required="true" name="order" v-model="formItem.order"
                            :label="trans('users.labels.order')" />
                    </div>
                    <div class="text-right mb-4">
                        <Button type="button" @click="onSubmitSection" :label="trans('global.buttons.add')" />
                    </div>
                </Form>
            </div>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
                <template v-slot:content-page="props">
                    <div>
                        {{ props.item.page?.name ?? '-' }}
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
import { trans } from "@/helpers/i18n";
import { fillObject, clearObject, reduceProperties } from "@/helpers/data"
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
import Dropdown from "@/views/components/input/Dropdown";
import { isAllowed } from "@/helpers/isreq";
import Table from "@/views/components/Table";
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
        Dropdown,
        Table
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            id: undefined,
            title: undefined,
            description: undefined,
            slug: undefined,
            template_id: undefined
        });

        const page = reactive({
            id: 'edit_page',
            title: trans('global.pages.page_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.page'),
                    to: toUrl('/pages/page'),
                },
                {
                    name: trans('global.pages.page_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/pages/page'),
                    theme: 'outline',
                },
                {
                    id: 'submit',
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ],
            toggleAddItems: false
        });

        const service = new ModelService;

        function fetchItems() {
            service.find(route.params.id, 'page').then((response) => {
                fillObject(form, response.data.model);
                table.records = response.data.model.sections;
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
            service.handleUpdate('edit-page', route.params.id, reduceProperties(form, ['roles'], 'id'));
            return false;
        }

        function toggleAddItems() {
            page.toggleAddItems = !page.toggleAddItems;
        }

        const table = reactive({
            headers: {
                order: trans('users.labels.order'),
                name: trans('users.labels.first_name')
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
                    to: toUrl('/pages/page/{id}'),
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
        });

        const formItem = reactive({
            name: undefined,
            backgroundcolor: undefined,
            order: undefined,
            textcolor: undefined,
        });

        function onSubmitSection() {
            service.handleCreate('add-item', reduceProperties(formItem, [], 'id'), `/pages/page/${form.id}/storesection`).then(() => {
                clearObject(formItem)
            }).then(response => {
                fetchItems();
            });
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
            onSubmitSection,
            toggleAddItems,
            formItem
        }
    }
})
</script>

<style scoped></style>
