<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <Panel>
            <Form id="edit-setting" @submit.prevent="onSubmit">
                <TextInput class="mb-4" type="text" :required="true" name="name_company" v-model="form.name_company"
                    :label="trans('users.labels.first_name')" />
                <TextInput class="mb-4" type="text" :required="true" name="description" v-model="form.description"
                    :label="trans('users.labels.description')" />
                <TextInput class="mb-4" type="text" :required="true" name="address" v-model="form.address"
                    :label="trans('users.labels.address')" />
                <TextInput class="mb-4" type="text" :required="true" name="phone" v-model="form.phone"
                    :label="trans('users.labels.phone')" />
                <TextInput class="mb-4" type="text" :required="true" name="email" v-model="form.email"
                    :label="trans('users.labels.email')" />
                <Dropdown class="mb-4" :server="'languages'" :server-per-page="15"
                    :required="true" name="type" v-model="form.locale" :label="trans('users.labels.locale')" />
                <Dropdown class="mb-4" :server="'timezones'" :server-per-page="15"
                    :required="true" name="type" v-model="form.timezone" :label="trans('users.labels.timezone')" />
                <Dropdown class="mb-4" :server="'countries'" :server-per-page="15"
                    :required="true" name="type" v-model="form.country_id" :label="trans('users.labels.country')" />
                <Dropdown class="mb-4" :server="'states'" :server-per-page="15"
                    :required="true" name="type" v-model="form.state_id" :label="trans('users.labels.state')" />
                <Dropdown class="mb-4" :server="'cities'" :server-per-page="15"
                    :required="true" name="type" v-model="form.city_id" :label="trans('users.labels.city')" />
                <Dropdown class="mb-4" :server="'currencies'" :server-per-page="15"
                    :required="true" name="type" v-model="form.currency_id" :label="trans('users.labels.currency')" />
            </Form>
        </Panel>
    </Page>
</template>

<script>
import { defineComponent, onBeforeMount, reactive } from "vue";
import { trans } from "@/helpers/i18n";
import { useAuthStore } from "@/stores/auth";
import Button from "@/views/components/input/Button";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";
import Alert from "@/views/components/Alert";
import Panel from "@/views/components/Panel";
import Page from "@/views/layouts/Page";
import SettingService from "@/services/SettingService";
import { fillObject, reduceProperties } from "@/helpers/data"
import { toUrl } from "@/helpers/routing";
import Form from "@/views/components/Form";
import { useRoute } from "vue-router";

export default defineComponent({
    name: 'settingindex',
    components: { Form, Panel, Alert, Dropdown, TextInput, Button, Page },
    setup() {
        const { user } = useAuthStore();
        //Router vue
        const route = useRoute();
        //Datos delformularo
        const form = reactive({
            name_company: undefined,
            description: undefined,
            address: undefined,
            phone: undefined,
            email: undefined,
            locale: undefined,
            timezone: undefined,
            state_id: undefined,
            city_id: undefined,
            country_id: undefined,
            currency_id: undefined
        });

        //Configuracion del breadcrumbs (navegacion y botones superiores) 
        const page = reactive({
            id: 'edit_setting',
            title: trans('global.pages.settings_edit'),
            filters: false,
            breadcrumbs: [
                {
                    name: trans('global.pages.settings'),
                    to: toUrl('/settings'),
                }
            ],
            actions: [
                {
                    id: 'submit',
                    name: trans('global.buttons.save'),
                    icon: "fa fa-save",
                    type: 'submit',
                }
            ]
        });

        //Se obtiene la data de setting
        const service = new SettingService();

        onBeforeMount(() => {
            //Se consume el servicio de route.param.id (se puede personalizar): service.edit(RutaBack)
            service.edit(route.params.id)
                .then((response) => {
                    //helper ordena y asigna la data desde el back
                    fillObject(form, response.data.model);
                    //
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
            service.handleUpdate('edit-setting', route.params.id, reduceProperties(form, [], 'id'));
            return false;
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
        }
    }
});
</script>
