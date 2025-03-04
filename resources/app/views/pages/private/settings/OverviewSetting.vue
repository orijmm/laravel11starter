<template>
    <Panel>
        <div class="flex">
            <div class="w-1/2 md:w-1/6 px-2">
                <img v-if="logo" :src="logo" class="w-full rounded-full" alt="logosite"/>
                <div v-else class="rounded-full">
                    <NoLogo></NoLogo>
                </div>
            </div>
            <div class="w-5/6 px-6 pt-2">
                <div class="items-center">
                    <div class="mt-4">
                        <Button @click.prevent="onChangeLogo" type="success" :label="trans('global.buttons.change_logo')"/>
                    </div>
                </div>
            </div>
        </div>
    </Panel>
</template>

<script>
import {trans} from "@/helpers/i18n";

import { defineComponent} from 'vue'
import Button from "@/views/components/input/Button";
import Panel from "@/views/components/Panel";
import Badge from "@/views/components/Badge";
import NoLogo from '@/views/pages/private/website/components/NoLogo';


export default defineComponent({
    components: {
        Panel,
        Badge,
        Button,
        NoLogo
    },
    props: {
        logo: {
            type: String,
            default: null,
        }
    },
    emits: ['change-logo-started'],
    setup(props, {emit}) {

        function onChangeLogo() {
            emit('change-logo-started');
        }

        return {
            onChangeLogo,
            trans,
        }
    }
});
</script>
