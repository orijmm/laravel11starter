<template>
    <div :style="style" :class="$props.class">
        <label
            :for="name"
            class="text-sm text-gray-500"
            :class="{ 'sr-only': !showLabel }"
            v-if="label">
            {{ label }}
            <small class="text-gray-300" v-if="labelsmall">{{ labelsmall }}</small>
            <span class="text-red-600" v-if="$props.required">*</span>
        </label>
        <input v-if="type !== 'textarea'"
               :id="name"
               :type="type"
               :value="modelValue"
               :required="required"
               :disabled="disabled"
               @input="onInput"
               :placeholder="placeholder"
               :autocomplete="autocomplete"
               class="block w-full placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-theme-500 focus:border-theme-500"
               :class="size"/>
        <textarea v-else
            :id="name"
            :value="modelValue"
            :required="required"
            :disabled="disabled"
            @input="onInput"
            :placeholder="placeholder"
            :autocomplete="autocomplete"
            class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-theme-500 focus:border-theme-500 text-sm"></textarea>
    </div>
</template>

<script>

import {defineComponent, ref} from "vue";

export default defineComponent({
    inheritAttrs: false,
    props: {
        class: String,
        style: [String, Object],
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            default: "",
        },
        labelsmall: {
            type: String,
            default: null,
        },
        modelValue: {
            default: "",
            type: [String, Number],
        },
        type: {
            type: String,
            default: "text",
        },
        showLabel: {
            type: Boolean,
            default: true,
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: null,
        },
        autocomplete: {
            type: String,
            default: null,
        },
        sizeInput: {
            type: String,
            default: 'md',
        }
    },
    emits: ['update:modelValue'],
    setup(props, {emit}) {

        let size = ref('');

        function onInput(event) {
            emit("update:modelValue", event.target.value);
        }

        if(props.sizeInput){
            switch (props.sizeInput) {
                case 'sm':
                    size.value = 'p-1 text-xs';
                    break;
                case 'lg':
                    size.value = 'px-3 py-2 text-md';
                    break;
                default:
                    size.value = 'px-3 py-2 text-sm';
            }
        }

        return {
            onInput,
            size
        }
    }
});
</script>
