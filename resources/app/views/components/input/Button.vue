<template>
    <router-link v-if="$props.to" :class="classes" :to="$props.to">
        <template v-if="$props.icon"><i class="mr-1" :class="$props.icon"></i></template>
        {{ $props.label }}
    </router-link>
    <button v-else :type="type" :class="classes" @click="onClick" :disabled="disabled">
        <template v-if="$props.icon"><i class="mr-1" :class="$props.icon"></i></template>
        {{ $props.label }}
    </button>
</template>

<script>

import {computed, defineComponent} from "vue";

export default defineComponent({
    props: {
        label: {
            type: String,
            default: "Submit",
        },
        type: {
            type: String,
            default: "submit",
        },
        icon: {
            type: String,
            default: "",
        },
        class: {
            type: String,
            default: "",
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        theme: {
            type: String,
            default: ""
        },
        to: {
            type: String,
            default: null,
        }
    },
    emits: ['click'],
    setup(props, {emit}) {

        function onClick(event) {
            emit('click', event);
        }

        const classes = computed(() => {
            let value = 'px-4 py-2 border text-sm rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 text-center transition ';
            switch (props.theme) {
                case 'success':
                    value += 'text-white border-green-600 border-2 bg-green-600 hover:bg-green-800 focus:bg-green-800 focus:ring-green-800';
                    break;
                case 'info':
                    value += 'text-white border-sky-600 border-2 bg-sky-600 hover:bg-sky-800 focus:bg-sky-800 focus:ring-sky-800';
                    break;
                case 'warning':
                    value += 'text-white border-orange-500 border-2 bg-orange-500 hover:bg-orange-700 focus:bg-orange-700 focus:ring-orange-700';
                    break;
                case 'danger':
                case 'error':
                    value += 'text-white border-red-600 border-2 bg-red-600 hover:bg-red-800 focus:bg-red-800 focus:ring-red-800';
                    break;
                case 'outline':
                    value += 'text-theme-600 border-theme-600 border-solid border-2 hover:bg-theme-800 hover:text-white hover:border-transparent'
                    break;
                case 'light-grey':
                    value += 'text-gray-500 hover:text-gray-100 border-gray-300 border-2 bg-gray-300 hover:bg-gray-400 focus:bg-gray-400 focus:ring-gray-400'
                    break;
                default:
                    value += 'text-white border-theme-600 border-2 bg-theme-600 hover:bg-theme-800 focus:bg-theme-800 focus:ring-theme-800';
                    break;
            }

            if (props.class) {
                value += ' ' + props.class;
            }

            if (props.disabled) {
                value += ' opacity-25';
            }

            return value;
        });

        return {
            onClick,
            classes
        }
    }
});
</script>
