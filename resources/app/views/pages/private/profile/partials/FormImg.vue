<template>
    <Panel :title="trans('users.labels.img_settings')">
        <FileInput @error="alertError" @change="onChange" name="file" :label="trans('users.labels.img')" v-model="form.file" @clear="form.file = ''" accept="image/*" class="mb-4"></FileInput>
    </Panel>
</template>

<script>
import {reactive, defineComponent} from "vue";
import {useAlertStore} from "@/stores";
import Alert from "@/views/components/Alert";
import {trans} from "@/helpers/i18n";
import Button from "@/views/components/input/Button";
import FileInput from "@/views/components/input/FileInput";
import Panel from "@/views/components/Panel";

export default defineComponent({
    emits: ['error', 'success'],
    components: {
        Panel,
        FileInput,
        Button,
        Alert
    },
    setup(props, {emit}) {

        const alertStore = useAlertStore();
        const form = reactive({
            file: null,
        })

        function onChange() {
            alertStore.clear();
            emit('success', form.file);
        }

        function alertError(err){
            alertStore.error(err.message);
        }

        return {
            onChange,
            form,
            trans,
            alertError
        }
    }
});
</script>
