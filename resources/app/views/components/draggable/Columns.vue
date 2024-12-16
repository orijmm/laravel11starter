<template>
    <div class="text-gray-400 bg-gray-100 p-1 rounded-lg text-center">
        <draggable v-model="localColumns" :sortableOptions="{ direction: 'horizontal' }" class="grid grid-flow-col"
            item-key="id" animation="200" @start="drag = true" @end="onDragEnd">
            <template #item="{ element, index }">
                <div class="bg-white px-2 border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-200">{{ `${trans('global.pages.column')} ${index + 1}` }}</span>
                        <span>
                            <i @click="onDeleteItems(localColumns, index)"
                                    class="text-gray-200 fa fa-times cursor-pointer"></i>
                            
                        </span>
                    </div>
                    <div>{{ element.id }}</div>
                </div>
            </template>
        </draggable>
        <Tooltip :text="trans('global.phrases.add_morecolumns')"><i
                @click="onToggleAddItems(localColumns, 'row_id', rowid)" class="fa fa-plus cursor-pointer"></i></Tooltip>
    </div>
</template>

<script>
import { defineComponent, ref, watch } from "vue";
import { toggleAddItems, deleteItems, updateOrder } from "@/helpers/draggable";
import draggable from 'vuedraggable';
import { trans } from "@/helpers/i18n";
import Tooltip from "@/views/components/Tooltip";

export default defineComponent({
    components: { draggable, Tooltip },
    props: {
        columns: {
            type: Array,
            default: () => []
        },
        rowid: {
            type: Number,
            default: 0
        }
    },
    emits: ['update:columns'],
    setup(props, { emit }) {
        let drag = ref(false);
        // Local copy of columns to allow modification
        const localColumns = ref([...props.columns]);

        function onDragEnd() {
            updateOrder(localColumns.value, drag);
            //actualizar las columnas de la fila desde componente hijo
            emit("update:columns", props.columns, props.rowid);
            emit("update:columns", localColumns.value, props.rowid); // Emitir el índice y las columnas actualizadas
        }

        function onToggleAddItems(cols, field, rowid) {
            toggleAddItems(cols, field, rowid)
            emit("update:columns", props.columns, props.rowid);
            emit("update:columns", localColumns.value, props.rowid); // Emitir el índice y las columnas actualizadas
        }

        function onDeleteItems(cols, index) {
            deleteItems(cols, index);
            //actualizar las columnas de la fila desde componente hijo
            emit("update:columns", props.columns, props.rowid);
            emit("update:columns", localColumns.value, props.rowid); // Emitir el índice y las columnas actualizadas
        }

        // Keep localColumns in sync with props.columns
        watch(
            () => props.columns,
            (newColumns) => {
                localColumns.value = [...newColumns];
            }
        );

        return {
            drag,
            trans,
            onDragEnd,
            localColumns,
            toggleAddItems,
            onToggleAddItems,
            deleteItems,
            onDeleteItems,
            updateOrder
        }
    }
})
</script>