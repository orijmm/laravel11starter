<template>
    <div>
        <draggable v-model="sectionList.rows" group="people" @start="drag = true"
            @end="updateOrder(sectionList.rows, drag)" item-key="id" class="space-y-4 bg-gray-100 p-2 rounded-lg"
            animation="200">
            <template #item="{ element, index }">
                <div class="p-2 bg-white rounded-md shadow-md cursor-move sortable-handle">
                    <div class="flex justify-between items-center text-sm mb-2">
                        <div class="text-gray-200">{{ `${trans('global.pages.row')} ${index + 1}` }}</div>
                        <div>
                            <Tooltip :text="trans('global.actions.delete')"> <i
                                    @click="deleteItems(sectionList.rows, index)"
                                    class="text-gray-200 fa fa-times cursor-pointer"></i>
                            </Tooltip>
                        </div>
                    </div>
                    <div class="text-xs col-span-5 flex">
                        <div class="flex-none content-center mr-1">{{ trans('users.labels.classes') }}:</div>
                        <div class="flex-1 content-center">
                            <TextInput sizeInput="sm" type="text" :required="true" name="classes"
                                v-model="element.classes" :placeholder="trans('users.labels.classes')" />
                        </div>
                    </div>
                    <div>
                        <!-- Agregar muchas columnas -->
                        <Button v-if="element.columns.length == 0" icon="fa fa-plus" type="button" class="mb-2"
                            theme="info" @click="displayModalColumns(index)"
                            :label="`${trans('global.buttons.add')} ${trans('global.pages.columns')}`">
                        </Button>
                        <div v-if="element.columns.length">
                            <Columns :sectionList="sectionList" :columns="element.columns" :rowid="element.id"
                                @update:columns="updateColumns"></Columns>
                        </div>
                        <div class="text-gray-400 bg-gray-100 p-2 rounded-lg text-center" v-else>
                            {{ trans('global.pages.nocolumns') }}
                        </div>
                    </div>
                </div>
            </template>
        </draggable>
        <Modal :is-showing="columnsSetter.columnsShow" @close="columnsSetter.columnsShow = false;">
            <Panel :title="trans('global.pages.columns')">
                <div>
                    <label :for="name" class="text-sm text-gray-500">
                        {{ trans('global.phrases.add_numbercolumns') }}
                    </label>
                    <select class="mt-1 block w-full" id="numbercolumns" v-model="columnsSetter.numberColumns">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                    <Button icon="fa fa-plus" type="button" class="mt-2" theme="info" @click="setColumns()"
                        :label="`${trans('global.buttons.add')}`">
                    </Button>
                </div>
            </Panel>
        </Modal>
    </div>
</template>

<script>
import { defineComponent, reactive, ref } from "vue";
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
        let columnsSetter = reactive({
            numberColumns: 1,
            columnsShow: false,
            rowIndex: null
        });

        function displayModalColumns(index) {
            columnsSetter.columnsShow = true;
            columnsSetter.rowIndex = index;
        }

        function setColumns() {
            const cols = {
                1: 12,
                2: 6,
                3: 4,
                4: 3,
                5: 1,
                6: 2,
                7: 1,
                8: 1,
                9: 1,
                10: 1,
                12: 1
            };
            for (let i = 1; i <= columnsSetter.numberColumns; i++) {
                props.sectionList.rows[columnsSetter.rowIndex].columns.push({
                    id: '0000' + i,
                    order: props.sectionList.rows[columnsSetter.rowIndex].columns.length + 1,
                    row_id: props.sectionList.rows[columnsSetter.rowIndex].id,
                    width: cols[columnsSetter.numberColumns],
                    classes: ''
                });
            }
            columnsSetter.columnsShow = false;
            columnsSetter.numberColumns = 1;
        }

        function updateColumns(newColumns, rowid) {
            //actualizar las columnas desde Componente hijo segun la fila
            let rownode = props.sectionList.rows.find(item => item.id === rowid);
            rownode.columns = newColumns;
        };

        return {
            drag,
            trans,
            updateOrder,
            deleteItems,
            displayModalColumns,
            setColumns,
            columnsSetter,
            updateColumns,
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