<template>
    <Panel :title="trans('users.labels.logo_settings')">
        <form @submit.prevent="onSubmit">
            <FileInput name="file" :label="trans('users.labels.logo')" v-model="form.file" @clear="form.file = ''"
                accept="image/*" class="mb-4"></FileInput>
            <Button :label="trans('global.buttons.upload')" />
        </form>
    </Panel>
</template>

<script>
import { reactive, defineComponent } from "vue";
import { useAlertStore } from "@/stores";
import { trans } from "@/helpers/i18n";
import { reduceProperties } from "@/helpers/data"
import Button from "@/views/components/input/Button";
import FileInput from "@/views/components/input/FileInput";
import Panel from "@/views/components/Panel";
import ModelService from "@/services/ModelService";
import { useRoute } from "vue-router";

export default defineComponent({
    emits: ['done', 'error', 'success'],
    components: {
        Panel,
        FileInput,
        Button
    },
    setup(props, { emit }) {
        const service = new ModelService();
        const route = useRoute();

        const alertStore = useAlertStore();
        const form = reactive({
            file: null,
        })

        function onChange(event) {
            alertStore.clear();
            form.file = event.target.files[0];
        }

        function onSubmit() {
            service.handleUpdatePut(
                'edit-logo',
                route.params.id,//url la toma de la ruta actual
                reduceProperties({'logo': form.file}, [], 'id'),
                `/settingad/${route.params.id}/logo`
            ).then((response) => {
                emit('success', response?.data?.record);
            }).catch((error) => {
                emit('error');
            });
            emit('done');
        }

        return {
            onSubmit,
            onChange,
            form,
            trans,
        }
    }
});
</script>
