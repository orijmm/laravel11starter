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
        </Panel>
        <Panel title="Permisos">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-3">
                <div>
                    <TableSimple :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting"
                        :actions="table.actions" :records="table.records" :pagination="table.pagination" filter="true"
                        :is-loading="table.loading" @action="onTableAction">
                    </TableSimple>
                </div>
                <div class="border-solid border-2 border-slate-100 rounded-md p-3">
                    <div class="my-3 text-lg">{{ trans('global.pages.permission_asigned') }}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1">
                        <Badge theme="info" rounded="rounded-full" class="flex flex-wrap items-center justify-between" v-for="(item, index) in form.abilities"
                            :key="item.id">
                            <div class="w-50 truncate">{{ item.name }}</div>
                            <span @click="removeAbility(index)"
                                class="flex justify-center cursor-pointer w-4 h-4 ms-2 text-xs font-semibold text-blue-400 bg-blue-300 rounded-full">
                                x
                            </span>
                        </Badge>

                    </div>
                </div>
            </div>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import { fillObject, reduceProperties } from "@/helpers/data"
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { toUrl } from "@/helpers/routing";
import Button from "@/views/components/input/Button";
import Badge from "@/views/components/Badge";
import TextInput from "@/views/components/input/TextInput";
import TableSimple from "@/views/components/TableSimple";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import FileInput from "@/views/components/input/FileInput";
import Form from "@/views/components/Form";
import RoleService from "@/services/RoleService";
import Tooltip from "@/views/components/Tooltip";

export default defineComponent({
    components: {
        Form,
        FileInput,
        Panel,
        Alert,
        Dropdown,
        TextInput,
        Button,
        Page,
        TableSimple,
        Badge,
        Tooltip
    },
    setup() {
        const { user } = useAuthStore();
        const route = useRoute();
        const form = reactive({
            name: '',
            title: '',
            abilities: []
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

        //Tabla de permisos / abilidades
        const table = reactive({
            headers: {
                id: trans('users.labels.id_pound'),
                name: trans('users.labels.first_name'),
                title: trans('users.labels.title'),
            },
            pagination: {
                meta: null,
                links: null,
            },
            actions: {
                add: {
                    id: 'add',
                    name: trans('global.buttons.add'),
                    icon: "fa fa-plus",
                    showName: false,
                    danger: true,
                }
            },
            loading: false,
            records: null
        });

        //listado de todos los permisos
        const allAbilities = reactive({
            records: null
        });

        function onTableAction(params) {
            switch (params.action.id) {
                case 'add':
                    addAbility(params.item);
                    break;
            }
        }

        const service = new RoleService();

        onBeforeMount(() => {
            //Todos los permisos
            service.find('abilities/select')
                .then((response) => {
                    allAbilities.records = response.data;
                });
            //Cargar datos del rol
            service.edit(route.params.id).then((response) => {
                fillObject(form, response.data.model);
                page.loading = false;
                getAllAbilities();
            });
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
                    reduceProperties(form, ['abilities'], 'id')
                );
                fillObject(form, response.data.record);
            } catch (error) {
                console.error('Error:', error);
            }
            return false;
        }

        function addAbility(value) {
            form.abilities.push(value);
            getAllAbilities();
        }

        function removeAbility(index) {
            form.abilities.splice(index, 1); // Elimina la habilidad del array
            getAllAbilities();
        }

        function getAllAbilities() {
            table.records = allAbilities.records.filter(item1 =>
                !form.abilities.some(item2 => item1.id === item2.id && item1.name === item2.name)
            );
        }

        return {
            trans,
            user,
            form,
            onSubmit,
            onAction,
            page,
            table,
            allAbilities,
            addAbility,
            removeAbility,
            onTableAction,
            getAllAbilities
        }
    }
})
</script>

<style scoped></style>
