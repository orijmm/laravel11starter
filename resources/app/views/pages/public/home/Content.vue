<template>
    <div class="w-full">
        <!-- sections -->
        <section v-for="(section, i) in page.sections" :id="`section-${section.name}`" :class="section.classes">
            <div v-for="row in section.rows" class="grid grid-flow-row md:grid-flow-col lg:grid-flow-col xl:grid-flow-col" :class="row.classes">
                <div v-for="col in row.columns" :class="col.classes">
                    <div v-for="component in col.components">
                        <component :is="component.componenttype.name || 'div'" :content="component.contents" :img="component.img" :data-aos="checkAnimate(component.componenttype.filename) ? 'flip-down' : ''">
                            {{ component.componenttype.name ? '' : 'Componente no encontrado' }}
                        </component>

                    </div>
                </div>
            </div>
        </section>
        <div class="w-full my-10 flex justify-center">
            <a v-smooth-scroll data-aos="flip-down" data-aos-delay="150" href="#navbar"
                class="px-6 py-3 flex items-center space-x-2 bg-[#FAFAFA] hover:bg-gray-100 hover:shadow-md border border-[#DDDDDD] rounded-md text-gray-700">
                <span>Back to top</span>
                <ArrowUp :size="20" />
            </a>
        </div>
    </div>
</template>

<script>

import { trans } from "@/helpers/i18n";
import { ref, reactive } from 'vue';
import BaseSection from '@/views/pages/public/template/components/base/Section';
import BaseButton from '@/views/pages/public/template/components/base/Button';
import LandingCryptoStatistic from '@/views/pages/public/template/components/landing/CryptoStatistic';
import LandingListItem from '@/views/pages/public/template/components/landing/ListItem';
import BaseAccordion from '@/views/pages/public/template/components/base/Accordion';
import LandingPartnerImage from '@/views/pages/public/template/components/landing/PartnerImage';
import LandingStep from '@/views/pages/public/template/components/landing/Step';
import LandingTradingToolImage from '@/views/pages/public/template/components/landing/TradingToolImage';
import Header from '@/views/pages/public/components/customs/Header';
import Grafics from '@/views/pages/public/components/customs/Grafics';
import Converter from '@/views/pages/public/components/customs/Converter';
import Partners from '@/views/pages/public/components/customs/Partners';
import ThreeColumns from '@/views/pages/public/components/customs/ThreeColumns';
import Accordion from '@/views/pages/public/components/general/Accordion';

import TitleOne from '@/views/pages/public/components/general/titleOne';
import ListOne from '@/views/pages/public/components/general/ListOne';
import SimpleParagraph from '@/views/pages/public/components/general/SimpleParagraph';
import CustomParagraph from '@/views/pages/public/components/general/CustomParagraph';
import FullImage from '@/views/pages/public/components/general/FullImage';
import Button from '@/views/pages/public/components/general/Button';

export default {
    name: "IndexSite",
    components: {
        BaseSection, LandingPartnerImage, LandingStep, LandingTradingToolImage, BaseButton, LandingCryptoStatistic, LandingListItem, BaseAccordion,
        Header, Grafics, Converter, Partners, TitleOne, ListOne, SimpleParagraph, FullImage, Button, CustomParagraph, ThreeColumns, Accordion
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