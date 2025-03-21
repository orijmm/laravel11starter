<template>
    <div class="w-full">
        <!-- sections -->
        <!--------------- bootstrap css --------------->
        <section v-for="(section, i) in page.sections" :id="`section-${section.name}`" :class="section.classes">
            <div v-for="row in section.rows" class="row" :class="row.classes">
                <div v-for="col in row.columns" :class="`${col.classes??''} col-12 col-md-${col.width}`">
                    <div v-for="component in col.components">
                        <component :is="component.componenttype.name || 'div'" :content="component.contents"
                            :img="component.img"
                            :data-aos="checkAnimate(component.componenttype.filename) ? 'flip-down' : ''">
                            {{ component.componenttype.name ? '' : 'Componente no encontrado' }}
                        </component>

                    </div>
                </div>
            </div>
        </section>
        <!--------------- tailwindcss --------------->
        <!--  <section v-for="(section, i) in page.sections" :id="`section-${section.name}`" :class="section.classes">
            <div v-for="row in section.rows" class="row" :class="row.classes">
                <div v-for="col in row.columns" class="col" :class="col.classes">
                    l
                    <div v-for="component in col.components">
                        <component :is="component.componenttype.name || 'div'" :content="component.contents" :img="component.img" :data-aos="checkAnimate(component.componenttype.filename) ? 'flip-down' : ''">
                            {{ component.componenttype.name ? '' : 'Componente no encontrado' }}
                        </component>

                    </div>
                </div>
            </div>
        </section>
        Scroll to top
        <div class="w-full my-10 flex justify-center">
            <a v-smooth-scroll data-aos="flip-down" data-aos-delay="150" href="#navbar"
                class="px-6 py-3 flex items-center space-x-2 bg-[#FAFAFA] hover:bg-gray-100 hover:shadow-md border border-[#DDDDDD] rounded-md text-gray-700">
                <span>Back to top</span>
                <ArrowUp :size="20" />
            </a>
        </div> -->
    </div>
</template>

<script>

import { trans } from "@/helpers/i18n";
import { ref } from 'vue';

export default {
    name: "IndexSite",
    components: {
        // BaseSection
    },
    props: {
        page: {
            type: Object,
            default: {}
        },
    },
    setup() {
        // Variables reactivas
        const selected = ref(0);

        function checkAnimate(filename) {
            return filename.startsWith('general/');
        }

        // Retornar variables y objetos
        return {
            selected,
            trans,
            checkAnimate
        };
    },
};
</script>