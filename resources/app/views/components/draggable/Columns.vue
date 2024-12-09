<template>
    <div class="text-gray-400 bg-gray-100 p-1 rounded-lg text-center">
        <draggable v-model="localColumns" :sortableOptions="{ direction: 'horizontal' }" class="grid grid-flow-col"
            item-key="id" animation="200" @start="drag = true" @end="onDragEnd">
            <template #item="{ element }">
                <div class="bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
                    {{ element.id }}
                </div>
            </template>
        </draggable>
        <Tooltip :text="trans('global.phrases.add_morecolumns')"><i @click="toggleAddItems(localColumns, 'row_id', rowid)" class="fa fa-plus cursor-pointer"></i></Tooltip>
    </div>
</template>

<script>
import { defineComponent, ref, watch } from "vue";
import { toggleAddItems } from "@/helpers/draggable";
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
            emit("update:columns", props.columns);
            emit("update:columns", localColumns.value); // Emitir el índice y las columnas actualizadas
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
            toggleAddItems
        }
    }
})
</script>