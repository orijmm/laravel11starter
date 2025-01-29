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

        <!-- Advanced trading tools section -->
        <!-- <section class="bg-trading-tools relative max-w-full sm:mx-4 my-20 py-16 shadow rounded-2xl overflow-hidden">
            <div class="relative max-w-screen-xl px-4 sm:px-2 mx-auto grid grid-cols-12 gap-x-6">
                <LandingTradingToolImage class="sm:hidden" />
                <div data-aos="fade-right" class="col-span-12 lg:col-span-6 space-y-8 sm:space-y-6 px-4 sm:px-6 mt-8">
                    <h2 class="text-4xl font-semibold">Advanced Trading <span class="text-header-gradient">Tools</span>
                    </h2>
                    <div class="space-y-2">
                        <h4 class="text-lg font-medium">Professional Access, Non-stop Availability</h4>
                        <p class="paragraph text-sm xl:text-base">
                            We provide premium access to crypto trading for both individuals and institutions through
                            high liquidity,
                            reliable order execution and constant uptime.
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-lg font-medium">A Range of Powerful Apis</h4>
                        <p class="paragraph text-sm xl:text-base">
                            Set up your own trading interface or deploy your algorithmic strategy with our
                            high-performance FIX and
                            HTTP APIs. Connect to our WebSocket for real-time data streaming.
                        </p>
                    </div>
                    <div class="space-y-2">
                        <h4 class="text-lg font-medium">Customer Support</h4>
                        <p class="paragraph text-sm xl:text-base">
                            Premium 24/7 support available to all customers worldwide by phone or email. Dedicated
                            account managers
                            for partners.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <BaseButton class="px-10 py-4 bg-inherit text-gradient border border-[#4A8FF6] text-base">
                            Get Started
                        </BaseButton>
                        <BaseButton class="bg-inherit text-[#4A8FF6] px-10 py-4 text-center underline rounded-full">
                            Learn More
                        </BaseButton>
                    </div>
                </div>
                <LandingTradingToolImage data-aos="fade-left" class="hidden sm:block" />
            </div>
        </section> -->

        <!-- Industry-leading security section -->
        <!-- <section class="w-full my-24">
            <div class="relative max-w-screen-xl px-8 mx-auto grid grid-cols-12 gap-x-6">
                <div data-aos="fade-right" class="col-span-12 lg:col-span-6">
                    <div class="w-full">
                        <img src="@/views/pages/public/template/assets/img/industry-leading-security.webp"
                            class="w-full" alt="" />
                    </div>
                </div>
                <div data-aos="fade-left" class="col-span-12 lg:col-span-5 space-y-8 sm:space-y-6 mt-8 xl:px-8">
                    <h2 class="text-4xl font-semibold">Industry-leading security from day one</h2>
                    <ul class="space-y-8 sm:space-y-4">
                        <LandingListItem title="Safety, security and compliance">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                NEFA is a licensed New York trust company that undergoes regular bank exams and is
                                subject to the
                                cybersecurity audits conducted by the New York Department of Financial Services.
                                <span class="underline">Learn more</span> about our commitment to security.
                            </p>
                        </LandingListItem>
                        <LandingListItem title="Hardware security keys">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                With NEFA you can secure your account with a hardware security key via WebAuthn.
                            </p>
                        </LandingListItem>
                        <LandingListItem title="SOC Certifications">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                NEFA is <span class="underline">SOC 1 Type 2</span> and
                                <span class="underline">SOC 2 Type 2</span> compliant. We are the world’s first
                                cryptocurrency exchange
                                and custodian to complete these exams.
                            </p>
                        </LandingListItem>
                    </ul>
                </div>
            </div>
        </section> -->

        <!-- FAQ section -->
        <!-- <section class="w-full my-24">
            <BaseSection>
                <div data-aos="fade-right" data-aos-delay="150" class="col-span-12 lg:col-span-6">
                    <div class="w-full">
                        <img src="@/views/pages/public/template/assets/img/faq.webp" class="w-full" alt="" />
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-delay="150" class="col-span-12 lg:col-span-6 px-4 sm:px-6 mt-8">
                    <span class="text-base text-gradient font-semibold uppercase mb-4 sm:mb-2">Support</span>
                    <h2 class="text-3xl sm:text-4xl font-semibold mb-10 sm:mb-6">Frequently asked questions</h2>
                    <ul class="shadow-box">
                        <BaseAccordion v-for="(accordion, index) in accordions" :key="index" :accordion="accordion" />
                    </ul>
                </div>
            </BaseSection>
        </section> -->
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

        const accordions = reactive([
            {
                title: 'Why should I choose NEFA?',
                description:
                    "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over 8 million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.",
            },
            {
                title: 'How secure is NEFA?',
                description:
                    "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.",
            },
            {
                title: 'Do I have to buy a whole Bitcoin?',
                description:
                    "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.",
            },
            {
                title: 'How do I actually buy Bitcoin?',
                description:
                    "We're industry pioneers, having been in the cryptocurrency industry since 2016. We've facilitated more than 21 billion USD worth of transactions on our exchange for customers in over 40 countries. Today, we're trusted by over million customers around the world and have received praise for our easy-to-use app, secure wallet, and range of features.",
            },
        ]);


        function checkAnimate(filename) {
            return filename.startsWith('general/');
        }

        // Retornar variables y objetos
        return {
            selected,
            accordions,
            trans,
            checkAnimate
        };
    },
};
</script>