<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel otherClass="overflow-visible">
            <h2 class="text-md font-bold text-gray-500 pb-2">Agregar componentes a la columna ID #{{ $route.params.id
                }}</h2>
            <Form id="add-component" @submit.prevent="onSubmitComponent">
                <Dropdown class="mb-4" :server="'pages/componenttype'" :server-per-page="15" :required="true"
                    name="type" v-model="form.component_type_id" :label="trans('users.labels.componenttype')"
                    :placeholder="trans('users.labels.componenttype')" :serverSearchMinCharacters="0" />
                <Dropdown class="mb-4" :required="true" name="type" :options="numberContent"
                    :placeholder="trans('users.labels.number_content')" v-model="form.number_content"
                    :label="trans('users.labels.number_content')" :serverSearchMinCharacters="0" />
                <div class="text-right mb-4">
                    <Button type="button" @click="onSubmitComponent" :label="trans('global.buttons.add')" />
                </div>
            </Form>
        </Panel>
        <Panel otherClass="overflow-visible">
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <div v-for="comp in allComp.components"
                        class="divide-y divide-gray-200 border border-gray-300 rounded-lg">
                        <div class="p-4 hover:bg-gray-100 cursor-pointer">{{ comp.id }}</div>
                    </div>
                </div>
                <div class="col-span-2">sd</div>
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
import { clearObject, reduceProperties } from "@/helpers/data"

export default defineComponent({
    components: { Panel, Page, Dropdown, Button },
    setup() {
        const route = useRoute();
        const form = reactive({
            id: undefined,
            filename: undefined,
            number_content: undefined
        });

        const allComp = reactive({
            components: undefined
        });

        const numberContent = ref([
            { id: 1, name: 1 },
            { id: 2, name: 2 },
            { id: 3, name: 3 },
            { id: 4, name: 4 },
            { id: 5, name: 5 },
            { id: 6, name: 6 },
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
                },
                {
                    id: 'submit',
                    name: trans('global.buttons.update'),
                    icon: "fa fa-save",
                    type: 'submit'
                }
            ]
        });

        const service = new ModelService;

        function fetchItems() {
            service.find(route.params.id, 'pages/page/column')
                .then((response) => {
                    console.log(response);
                    form.id = response.data.column.id
                    allComp.components = response.data.column.components
                    page.loading = false
                });
        }

        onBeforeMount(() => {
            fetchItems();
        });

        function onSubmitComponent() {
            service.handleCreate('add-component', reduceProperties(form, [], 'id'), `/pages/page/column/${form.id}/storecomponent`).then(() => {
                clearObject(form)
            }).then(response => {
                fetchItems();
            });
            return false;
        }

        return {
            trans,
            page,
            form,
            allComp,
            numberContent,
            fetchItems,
            onSubmitComponent
        }
    }
})
</script>