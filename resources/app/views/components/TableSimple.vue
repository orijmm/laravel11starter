<template>
    <div class="w-full shadow border-b border-gray-200 mb-8 sm:rounded-lg overflow-auto">
        <div v-if="filter" class="mb-4">
            <TextInput v-model="search" name="search" placeholder="Filtrar por título" />
        </div>
        <table class="w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-gray-50">
            <tr>
                <th v-for="(item, i) in headers" scope="col" class="align-middle px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider relative">
                    <slot :name="'header-'+i">
                        <div class="leading-loose inline-block">{{ item }}</div>
                    </slot>
                </th>
                <th v-if="actions" scope="col" class="align-middle px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <slot name="actions">{{ trans('global.actions.name') }}</slot>
                </th>
            </tr>
            </thead>
            <tbody v-if="filteredRecords && filteredRecords.length && !$props.isLoading" class="bg-white divide-y divide-gray-200">
            <tr v-for="(record, i) in filteredRecords">
                <td v-for="(header, j) in headers" class="px-6 py-4 whitespace-nowrap text-sm">
                    <slot :item="record" :name="'content-'+j">
                        {{ record && record.hasOwnProperty(j) ? record[j] : '' }}
                    </slot>
                </td>
                <td v-if="actions" class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <slot :name="'actions-'+j" v-for="(action, j) in actions">
                        <router-link v-if="action.hasOwnProperty('to') && action.to" :to="getActionPage(action, record)" :class="getActionClass(action)" :title="action.name">
                            <i v-if="action.icon" :class="action.icon"></i>
                            <span v-if="(!action.hasOwnProperty('showName') || action.showName)" v-html="action.name"></span>
                        </router-link>
                        <a v-else :class="getActionClass(action)" @click="onActionClick({action: action, item: record})" :title="action.name">
                            <i v-if="action.icon" :class="action.icon"></i>
                            <span v-if="(!action.hasOwnProperty('showName') || action.showName)" v-html="action.name"></span>
                        </a>
                    </slot>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td :colspan="headersLength" class="pt-10 pb-6 text-center">
                    <template v-if="$props.isLoading">
                        <Spinner :text-new-line="true"></Spinner>
                    </template>
                    <template v-else>
                        {{ trans('global.phrases.no_records') }}
                    </template>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- paginador acá-->
</template>

<script>
import {trans} from "@/helpers/i18n";
import {computed, defineComponent, ref} from "vue";
import Pager from "@/views/components/Pager";
import Spinner from "@/views/components/icons/Spinner";
import TextInput from "@/views/components/input/TextInput";

export default defineComponent({
    components: {Spinner, Pager, TextInput},
    emits: ['pageChanged', 'action', 'sort'],
    props: {
        id: {
            type: String,
            default: "",
        },
        headers: {
            type: [Array, Object],
            default: [],
        },
        records: {
            type: [Array, Object],
            default: [],
        },
        actions: {
            type: [Array, Object],
            default: [],
        },
        sorting: {
            type: [Object],
            default: {}
        },
        pagination: {
            type: Object,
            default: {
                meta: {
                    current_page: 1,
                    last_page: 1,
                },
                links: null,
            },
        },
        isLoading: {
            type: Boolean,
            default: false,
        },
        filter: {
            type: Boolean,
            default: false,
        }
    },
    setup(props, {emit}) {

        const headersLength = computed(() => {
            let total = 0;
            for (let i in props.headers) {
                total++;
            }
            if (props.actions) {
                total++;
            }
            return total;
        })

        function getActionPage(action, record) {
            if (!action.hasOwnProperty('to')) {
                return '#';
            }
            for (let key in record) {
                if (action.to.indexOf('{' + key + '}') !== -1) {
                    return action.to.replace('{' + key + '}', record[key]);
                }
            }
            return action.to;
        }

        function getActionClass(action) {

            let classes = 'uppercase cursor-pointer text-lg';
            if (Object.keys(props.actions).length > 1) {
                classes += ' mr-3';
            }

            if (action.hasOwnProperty('danger') && action.danger) {
                classes += ' text-danger-400'
            }

            return classes;
        }

        function onActionClick(params) {
            emit('action', params)
        }

        //Buscador
        const search = ref('');
        // Computed para filtrar los registros según el valor del input
        const filteredRecords = computed(() => {
            if (!search.value) {
                return props.records; // Si no hay filtro, retorna todos los registros
            }
            return props.records.filter(record => 
                record.title.toLowerCase().includes(search.value.toLowerCase())
                || record.name.toLowerCase().includes(search.value.toLowerCase())
            );
        });

        return {
            getActionClass,
            getActionPage,
            onActionClick,
            headersLength,
            trans,
            search,
            filteredRecords, // devuelve los registros filtrados
        }
    }
});
</script>
<style>
.sort-arrows {
    font-size: 1.2em;
    line-height: 0.7;
    width: 30px;
}

.sort-arrows i.fa {
    line-height: 0.1;
}

.sort-arrows .fa {
    font-size: 15px;
}
</style>
