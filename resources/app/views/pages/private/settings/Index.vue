<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onAction"
        :is-loading="page.loading">
        <OverviewSetting :logo="form.logo_thumb_url" class="mb-4" @change-logo-started="isAvatarModalShowing = true;" />
        <Form id="edit-setting" @submit.prevent="onSubmit">

            <Panel otherClass="overflow-visible">
                <h4 class="text-gray-500 text-xl my-3">{{ trans('global.phrases.data_bussiness') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                    <TextInput class="col-span-1 md:col-span-2" type="text" :required="true" name="name_company"
                        v-model="form.name_company" :label="trans('users.labels.first_name')" />
                    <TextInput type="text" :required="true" name="description" v-model="form.description"
                        :label="trans('users.labels.description')" />
                    <TextInput type="text" :required="true" name="address" v-model="form.address"
                        :label="trans('users.labels.address')" />
                    <TextInput type="text" :required="true" name="phone" v-model="form.phone"
                        :label="trans('users.labels.phone')" />
                    <TextInput type="text" :required="true" name="email" v-model="form.email"
                        :label="trans('users.labels.email')" />
                    <Dropdown :server="'languages'" :server-per-page="15" :required="true" name="type"
                        v-model="form.locale" :label="trans('users.labels.locale')" />
                    <Dropdown :server="'timezones'" :server-per-page="15" :required="true" name="type"
                        v-model="form.timezone" :label="trans('users.labels.timezone')" />
                    <Dropdown :server="'countries'" :server-per-page="15" :required="true" name="type"
                        v-model="form.country_id" :label="trans('users.labels.country')" />
                    <Dropdown :server="'states'" :server-per-page="15" :required="true" name="type"
                        v-model="form.state_id" :label="trans('users.labels.state')" />
                    <Dropdown :server="'cities'" :server-per-page="15" :required="true" name="type"
                        v-model="form.city_id" :label="trans('users.labels.city')" />
                    <Dropdown :server="'currencies'" :server-per-page="15" :required="true" name="type"
                        v-model="form.currency_id" :label="trans('users.labels.currency')" />
                    <TextInput class="col-span-1 md:col-span-3" type="text" :required="true" name="googlemaps"
                        v-model="form.googlemaps" :label="trans('users.labels.google_maps')" />
                </div>
            </Panel>

            <Panel otherClass="overflow-visible">
                <h4 class="text-gray-500 text-xl my-3">{{ trans('users.labels.socialmedia') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
                    <TextInput type="text" :required="true" name="instagram" v-model="form.instagram"
                        :label="trans('users.labels.instagram')" />
                    <TextInput type="text" :required="true" name="facebook" v-model="form.facebook"
                        :label="trans('users.labels.facebook')" />
                    <TextInput type="text" :required="true" name="twitter" v-model="form.twitter"
                        :label="trans('users.labels.twitter')" />
                    <TextInput type="text" :required="true" name="tiktok" v-model="form.tiktok"
                        :label="trans('users.labels.tiktok')" />
                </div>

            </Panel>
        </Form>
    </Page>
    <Modal :is-showing="isAvatarModalShowing" @close="isAvatarModalShowing = false;">
        <FormLogo @error="isAvatarModalShowing = false;" @done="isAvatarModalShowing = false;"
            @success="onAvatarChange" />
    </Modal>
</template>

<script>
import { defineComponent, onBeforeMount, reactive, ref } from "vue";
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
import Modal from "@/views/components/Modal";
import FormLogo from "@/views/pages/private/settings/FormLogo";
import OverviewSetting from "@/views/pages/private/settings/OverviewSetting";

export default defineComponent({
    name: 'settingindex',
    components: { Form, Panel, Alert, Dropdown, TextInput, Button, Page, Modal, OverviewSetting, FormLogo },
    setup() {
        const isAvatarModalShowing = ref(false);

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
            currency_id: undefined,
            logo_thumb_url: undefined
        });

        //Configuracion del breadcrumbs (navegacion y botones superiores) 
        const page = reactive({
            id: 'edit_settings',
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
                });
        });

        function onAction(data) {
            switch (data.action.id) {
                case 'submit':
                    onSubmit();
                    break;
            }
        }

        function onSubmit() {
            service.handleUpdate('edit-setting', route.params.id, reduceProperties(form, [], 'id'))
                .then((response) => {
                    window.location.reload();
                });
            return false;
        }

        function onAvatarChange(data) {
            form.logo_thumb_url = data.logo_thumb_url;
        }

        return {
            trans,
            user,
            form,
            page,
            onSubmit,
            onAction,
            isAvatarModalShowing,
            onAvatarChange
        }
    }
});
</script>
