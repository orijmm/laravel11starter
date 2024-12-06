<template>
    <div>
        <draggable v-model="sectionList.rows" group="people" @start="drag = true" @end="updateOrder(sectionList, drag)"
            item-key="id" class="space-y-4 bg-gray-100 p-2 rounded-lg" animation="200">
            <template #item="{ element, index }">
                <div class="p-4 bg-white rounded-md shadow-md cursor-move sortable-handle">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-200">{{ `${trans('global.pages.row')} ${index + 1}` }}</span>
                        <span>
                            <Tooltip :text="trans('global.actions.delete')"> <i @click="deleteItems(sectionList, index)"
                                    class="text-gray-200 fa fa-times cursor-pointer"></i>
                            </Tooltip>
                        </span>
                    </div>
                    <div class="p-1 border-2 border-gray-100 rounded-md">
                        <Button icon="fa fa-plus" type="button" class="mb-2" theme="info"
                            @click="displayModalColumns(index)"
                            :label="`${trans('global.buttons.add')} ${trans('global.pages.columns')}`">
                        </Button>
                        <div v-if="element.columns.length">
                            <Columns :columns="element.columns"></Columns>
                        </div>
                        <div class="text-gray-400 bg-gray-100 p-2 rounded-lg text-center" v-else>{{
                            trans('global.pages.nocolumns') }}</div>
                    </div>
                </div>
            </template>
        </draggable>
        <Modal :is-showing="columnsShow" @close="columnsShow = false;">
            <Panel :title="trans('global.pages.columns')">
                <div>
                    <label :for="name" class="text-sm text-gray-500">
                        {{ trans('global.phrases.add_numbercolumns') }}
                    </label>
                    <input v-if="type !== 'textarea'" id="numbercolumns" type="number" v-model="numberColumns"
                        :required="true" placeholder="1-12" @input="validateNumberColumns" min="1" max="12"
                        class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-theme-500 focus:border-theme-500 text-sm" />
                    <p v-if="errorColumnRange" class="mt-1 text-sm text-red-600">{{ errorColumnRange }}</p>
                    <Button icon="fa fa-plus" type="button" class="mt-2" theme="info" @click="setColumns()"
                        :label="`${trans('global.buttons.add')}`">
                    </Button>
                </div>
            </Panel>
        </Modal>
    </div>
</template>

<script>
import { defineComponent, ref } from "vue";
import { updateOrder, deleteItems } from "@/helpers/draggable";
import Tooltip from "@/views/components/Tooltip";
import draggable from 'vuedraggable';
import Button from "@/views/components/input/Button";
import { trans } from "@/helpers/i18n";
import Columns from "@/views/components/draggable/Columns";
import Modal from "@/views/components/Modal";
import Panel from "@/views/components/Panel";
import TextInput from "@/views/components/input/TextInput";

export default defineComponent({
    components: { draggable, Tooltip, Columns, Button, Modal, Panel, TextInput },
    props: {
        sectionList: {
            type: String,
            required: true
        }
    },
    setup(props) {
        let drag = ref(false);
        let numberColumns = ref(1);
        let errorColumnRange = ref('');
        let columnsShow = ref(false);
        let rowIndex = ref(null);

        function validateNumberColumns() {
            if (numberColumns.value > 12) {
                numberColumns.value = 12;
                errorColumnRange.value = 'El número debe ser al menos 1 y no puede ser mayor a 12';
            } else {
                errorColumnRange.value = '';
            }
        }

        function displayModalColumns(index) {
            columnsShow.value = true;
            rowIndex.value = index;
        }

        function setColumns() {
            console.log(this.sectionList.rows[rowIndex.value]);
        }

        return {
            drag,
            columnsShow,
            trans,
            updateOrder,
            deleteItems,
            numberColumns,
            validateNumberColumns,
            errorColumnRange,
            displayModalColumns,
            setColumns,
            rowIndex
        }
    }
})
</script>

<style scoped>
.sortable-drag {
    background-color: #f3f4f6;
    /* Tailwind's gray-200 */
    transform: scale(1.05);
    transition: transform 0.2s ease;
    cursor: move !important;
}
</style>