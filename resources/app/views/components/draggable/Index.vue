<template>
    <draggable v-model="sectionList.rows" group="people" @start="drag = true" @end="updateOrder(sectionList)"
        item-key="id" class="space-y-4 bg-gray-100 p-6 rounded-lg" animation="200">
        <template #item="{ element, index }">
            <div
                class="p-4 bg-white rounded-md shadow-md flex justify-between items-center cursor-move sortable-handle">
                <span class="text-gray-200">{{ `${trans('global.pages.row')} ${index + 1}` }}</span>
                <span>
                    <Tooltip :text="trans('global.actions.delete')"> <i @click="deleteItems(sectionList, index)"
                            class="text-gray-200 fa fa-times cursor-pointer"></i>
                    </Tooltip>
                </span>
            </div>
        </template>
    </draggable>
</template>

<script>
import { defineComponent, ref } from "vue";
import { updateOrder, deleteItems } from "@/helpers/draggable";
import Tooltip from "@/views/components/Tooltip";
import draggable from 'vuedraggable';
import { trans } from "@/helpers/i18n";

export default defineComponent({
    components: {draggable, Tooltip},
    props: {
        sectionList: {
            type: String,
            required: true
        }
    },
    setup(props) {
        let drag = ref(false);

        return {
            drag,
            trans,
            updateOrder,
            deleteItems
        }
    }
})
</script>