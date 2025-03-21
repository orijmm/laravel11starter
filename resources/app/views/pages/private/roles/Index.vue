<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onPageAction">

        <template #filters v-if="page.toggleFilters">
            <Filters @clear="onFiltersClear">
                <FiltersRow>
                    <FiltersCol>
                        <TextInput name="name" :label="trans('users.labels.first_name')"
                            v-model="mainQuery.filters.name.value"></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput name="title" :label="trans('users.labels.title')"
                            v-model="mainQuery.filters.title.value"></TextInput>
                    </FiltersCol>
                </FiltersRow>
            </Filters>
        </template>

        <template #default>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
                <template v-slot:content-abilities="props">
                    <div>
                        <span
                            class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"
                            v-for="(entry, index) in limitedAbilities(props.item.abilities)" :key="index">
                            {{ entry.name }}
                        </span>

                        <span v-if="remainingAbilities(props.item.abilities) > 0"
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                            + {{ remainingAbilities(props.item.abilities) }}
                        </span>
                    </div>
                </template>
            </Table>
        </template>
    </Page>
</template>

<script>

import { trans } from "@/helpers/i18n";
import { watch, onMounted, defineComponent, reactive } from 'vue';
import { getResponseError, prepareQuery } from "@/helpers/api";
import { toUrl } from "@/helpers/routing";
import { useAlertStore } from "@/stores";
import alertHelpers from "@/helpers/alert";
import { isAllowed } from "@/helpers/isreq";
import Page from "@/views/layouts/Page";
import Table from "@/views/components/Table";
import Avatar from "@/views/components/icons/Avatar";
import Filters from "@/views/components/filters/Filters";
import FiltersRow from "@/views/components/filters/FiltersRow";
import FiltersCol from "@/views/components/filters/FiltersCol";
import TextInput from "@/views/components/input/TextInput";
import RoleService from "@/services/RoleService";

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
        const service = new RoleService();
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
                title: {
                    value: '',
                    comparison: '='
                }
            }
        });

        const page = reactive({
            id: 'list_roles',
            title: trans('global.pages.roles'),
            breadcrumbs: [
                {
                    name: trans('global.pages.roles'),
                    to: toUrl('/roles'),
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
                    to: toUrl('/roles/create'),
                    isAllowed: isAllowed(['create_role'])
                }
            ],
            toggleFilters: false,
        });

        const table = reactive({
            headers: {
                id: trans('users.labels.id_pound'),
                name: trans('users.labels.first_name'),
                title: trans('users.labels.title'),
                abilities: trans('global.pages.permission'),
            },
            sorting: {
                roles: true,
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
                    to: toUrl('/roles/{id}/edit'),
                    isAllowed: isAllowed(['edit_role'])
                },
                delete: {
                    id: 'delete',
                    name: trans('global.actions.delete'),
                    icon: "fa fa-trash",
                    showName: false,
                    danger: true,
                    isAllowed: isAllowed(['delete_role'])
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
                .list(query)
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

        //limitar abilities mostradas en la tabla
        function limitedAbilities(abilities) {
            // Muestra solo los primeros 6 elementos
            return abilities.slice(0, 5);
        };
        function remainingAbilities(abilities) {
            // Calcula cuántos elementos quedan sin mostrar
            return abilities.length - 5;
        };

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
            remainingAbilities,
            limitedAbilities,
            isAllowed
        }

    },
});
</script>
