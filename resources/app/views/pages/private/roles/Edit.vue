<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel>
            <Form id="edit-role" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name" v-model="form.name"
                    :label="trans('users.labels.first_name')" />
                <TextInput class="mb-4" type="text" :required="true" name="title" v-model="form.title"
                    :label="trans('users.labels.title')" />
            </Form>
            {{ table }}
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting" :actions="table.actions"
                :records="table.records" :pagination="table.pagination" :is-loading="table.loading"
                @page-changed="onTablePageChange" @action="onTableAction" @sort="onTableSort">
                <!-- <template v-slot:content-abilities="props">
                    <div>
                        <span  class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800" v-for="(entry, index) in props.item.abilities" :key="index">
                            {{ entry.name }}<span v-if="index < props.item.abilities.length - 1"> </span>
                        </span>
                    </div>
                </template> -->
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
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import RoleService from "@/services/RoleService";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        Dropdown,
        TextInput,
        Button,
        Page
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: '',
            title: '',
        });

        const page = reactive({
            id: 'edit_role',
            title: trans('global.pages.roles_edit'),
            filters: false,
            loading: true,
            breadcrumbs: [
                {
                    name: trans('global.pages.roles'),
                    to: toUrl('/roles'),
                },
                {
                    name: trans('global.pages.roles_edit'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'back',
                    name: trans('global.buttons.back'),
                    icon: "fa fa-angle-left",
                    to: toUrl('/roles/list'),
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

        const table = reactive({
            headers: {
                id: trans('users.labels.id_pound'),
                name: trans('users.labels.first_name'),
                title: trans('users.labels.title'),
            },
            sorting: {
                name: true,
            },
            pagination: {
                meta: null,
                links: null,
            },
            actions: {
                delete: {
                    id: 'delete',
                    name: trans('global.actions.delete'),
                    icon: "fa fa-trash",
                    showName: false,
                    danger: true,
                }
            },
            loading: false,
            records: null
        })

        const service = new RoleService();

        onBeforeMount(() => {
            //Cargar datos del rol
            service.edit(route.params.id).then((response) => {
                fillObject(form, response.data.model);
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

        async function onSubmit() {
            try {
                let response = await service.handleUpdate(
                    'edit-role',
                    route.params.id,//url la toma de la ruta actual
                    reduceProperties(form, ['roles'], 'id')
                );
                fillObject(form, response.data.record);
                console.log('Response:', response);  
            } catch (error) {
                console.error('Error:', error);
            }
            return false;
        }

        //Cargar abilidades / permisos
        function fetchPage(params) {
            // table.records = [];
            // table.loading = true;
            // let query = prepareQuery(params);
            // service
            //     .index(query)
            //     .then((response) => {
            //         table.records = response.data.data;
            //         table.pagination.meta = response.data.meta;
            //         table.pagination.links = response.data.links;
            //         table.loading = false;
            //     })
            //     .catch((error) => {
            //         alertStore.error(getResponseError(error));
            //         table.loading = false;
            //     });
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            table,
            fetchPage
        }
    }
})
</script>

<style scoped></style>
