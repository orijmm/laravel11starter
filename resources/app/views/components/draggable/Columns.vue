<template>
    <div class="text-gray-400 bg-gray-100 p-2 rounded-lg text-center">
        <draggable v-model="localColumns" :sortableOptions="{ direction: 'horizontal' }" class="flex space-x-2"
            item-key="id" animation="200" @start="drag = true" @end="onDragEnd">
            <template #item="{ element }">
                <div class="bg-white rounded-md shadow-md">{{ element.id }}</div>
            </template>
        </draggable>
    </div>
</template>

<script>
import { defineComponent, ref, watch } from "vue";
// import { updateOrder, deleteItems } from "@/helpers/draggable";
// import Tooltip from "@/views/components/Tooltip";
import draggable from 'vuedraggable';
import { trans } from "@/helpers/i18n";

export default defineComponent({
    components: { draggable },
    props: {
        columns: {
            type: Array,
            default: () => []
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
            localColumns
        }
    }
})
</script>