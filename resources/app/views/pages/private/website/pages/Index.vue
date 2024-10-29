<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onPageAction">

        <template #filters v-if="page.toggleFilters">
            <Filters @clear="onFiltersClear">
                <FiltersRow>
                    <FiltersCol>
                        <TextInput name="title" :label="trans('users.labels.first_title')"
                            v-model="mainQuery.filters.title.value"></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput name="slug" :label="trans('users.labels.slug')"
                            v-model="mainQuery.filters.slug.value"></TextInput>
                    </FiltersCol>
                </FiltersRow>
            </Filters>
        </template>

        <template #default>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
                <template v-slot:content-template="props">
                    <div>
                        {{ props.item.template.name }}
                    </div>
                </template>
            </Table>
        </template>
    </Page>
</template>

<script>

import { trans } from "@/helpers/i18n";
import { watch, onMounted, defineComponent, reactive, ref } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import { toUrl } from "@/helpers/routing";
import { useAlertStore } from "@/stores";
import { isAllowed } from "@/helpers/isreq";
import alertHelpers from "@/helpers/alert";
import Page from "@/views/layouts/Page";
import Table from "@/views/components/Table";
import Avatar from "@/views/components/icons/Avatar";
import Filters from "@/views/components/filters/Filters";
import FiltersRow from "@/views/components/filters/FiltersRow";
import FiltersCol from "@/views/components/filters/FiltersCol";
import TextInput from "@/views/components/input/TextInput";
import PagesService from "@/services/PagesService";

export default defineComponent({
    components: {
        TextInput,
        FiltersCol,
        FiltersRow,
        Filters,
        Page,
        Table,
        Avatar
    },
    setup() {
        const service = new PagesService('page');
        const alertStore = useAlertStore();
        const mainQuery = reactive({
            page: 1,
            search: '',
            sort: '',
            filters: {
                name: {
                    value: '',
                    comparison: '='
                },
                slug: {
                    value: '',
                    comparison: '='
                }
            }
        });

        const page = reactive({
            id: 'list_pages',
            title: trans('global.pages.pages'),
            breadcrumbs: [
                {
                    name: trans('global.pages.pages'),
                    to: toUrl('/pages/pages'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'filters',
                    name: trans('global.buttons.filters'),
                    icon: "fa fa-filter",
                    theme: 'outline',
                },
                {
                    id: 'new',
                    name: trans('global.buttons.add_new'),
                    icon: "fa fa-plus",
                    to: toUrl('/pages/add/pages'),
                    isAllowed: isAllowed(['create_pages'])
                }
            ],
            toggleFilters: false,
        });

        const table = reactive({
            headers: {
                id: trans('users.labels.id_pound'),
                title: trans('users.labels.title'),
                description: trans('users.labels.description'),
                slug: trans('users.labels.slug'),
                template: trans('users.labels.template'),
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
                    to: toUrl('/pages/{id}/editpages'),
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

        function onPageAction(params) {
            switch (params.action.id) {
                case 'filters':
                    page.toggleFilters = !page.toggleFilters;
                    break;
            }
        }

        function onFiltersClear() {
            let clonedFilters = mainQuery.filters;
            for (let key in clonedFilters) {
                clonedFilters[key].value = '';
            }
            mainQuery.filters = clonedFilters;
        }

        function fetchPage(params) {
            table.records = [];
            table.loading = true;
            let query = prepareQuery(params);
            service
                .index(query)
                .then((response) => {
                    table.records = response.data.data;
                    table.pagination.meta = response.data.meta;
                    table.pagination.links = response.data.links;
                    table.loading = false;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                    table.loading = false;
                });
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        return {
            trans,
            page,
            table,
            onTablePageChange,
            onTableAction,
            onTableSort,
            onPageAction,
            onFiltersClear,
            mainQuery,
            isAllowed
        }

    },
});
</script>
