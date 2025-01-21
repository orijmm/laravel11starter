<template>
    <div class="w-full">
        <!-- sections -->
        <section v-for="(section, i) in page.sections" :id="`section-${section.name}`" :class="section.classes">
            <div v-for="row in section.rows" class="grid grid-flow-col">
                <div v-for="col in row.columns">
                    <div v-for="component in col.components">
                        <component :is="component.componenttype.name || 'div'" :content="component.contents">
                            {{ component.componenttype.name ? '' : 'Componente no encontrado' }}
                        </component>

                    </div>
                </div>
            </div>
        </section>

        <!-- Credit card section -->
        <section class="w-full my-36">
            <BaseSection data-aos="fade-down">
                <div class="col-span-12 lg:col-span-7">
                    <div class="w-full">
                        <img src="@/views/pages/public/template/assets/img/nefa-cc.webp" class="w-[95%]" alt="" />
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-5 space-y-6 px-4 sm:px-6 mt-20">
                    <h2 class="text-4xl font-semibold">
                        Introducing the <span class="text-header-gradient">NEFA</span> Credit Card
                    </h2>
                    <p class="paragraph">Subject to cardholder and rewards terms which will be available at application.
                    </p>
                    <ul class="space-y-4 sm:space-y-2">
                        <LandingListItem title="Up to 3% back on purchases" />
                        <LandingListItem title="Earn rewards in bitcoin or any crypto on NEFA" />
                        <LandingListItem title="No annual fee" />
                    </ul>
                    <BaseButton
                        class="w-full sm:max-w-[240px] px-10 py-4 bg-inherit text-gradient border border-[#0c66ee] text-base">
                        Join the waitlist</BaseButton>
                </div>
            </BaseSection>
        </section>

        <!-- Advanced trading tools section -->
        <section class="bg-trading-tools relative max-w-full sm:mx-4 my-20 py-16 shadow rounded-2xl overflow-hidden">
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
        </section>

        <!-- Industry-leading security section -->
        <section class="w-full my-24">
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
        </section>

        <!-- Getting started section -->
        <section
            class="bg-trading-tools relative max-w-full sm:mx-4 xl:mx-10 my-24 shadow sm:rounded-2xl overflow-hidden">
            <div class="w-full py-16 flex flex-col items-center">
                <h2 data-aos="flip-down" class="text-3xl sm:text-4xl font-semibold text-center">
                    Get started in just a few minutes
                </h2>
                <div data-aos="fade-up"
                    class="relative w-full flex flex-col lg:flex-row items-center justify-between space-y-12 lg:space-y-0 px-4 xl:px-10 mt-16 sm:mt-8">
                    <LandingStep v-for="step in steps" :key="step.title" :step="step" />
                    <img src="@/views/pages/public/template/assets/img/getting-started/arrow.png"
                        class="hidden lg:inline-block absolute top-32 left-64 xl:left-[22rem] w-24 xl:w-[9.5rem]"
                        alt="" />
                    <img src="@/views/pages/public/template/assets/img/getting-started/arrow.png"
                        class="hidden lg:inline-block absolute top-32 right-64 xl:right-[22rem] w-24 xl:w-[9.5rem]"
                        alt="" />
                </div>
            </div>
        </section>

        <!-- FAQ section -->
        <section class="w-full my-24">
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

import TitleOne from '@/views/pages/public/components/general/titleOne';
import ListOne from '@/views/pages/public/components/general/ListOne';
import SimpleParagraph from '@/views/pages/public/components/general/SimpleParagraph';
import FullImage from '@/views/pages/public/components/general/FullImage';
import Button from '@/views/pages/public/components/general/Button';

export default {
    name: "IndexSite",
    components: {
        BaseSection, LandingPartnerImage, LandingStep, LandingTradingToolImage, BaseButton, LandingCryptoStatistic, LandingListItem, BaseAccordion,
        Header, Grafics, Converter, Partners, TitleOne, ListOne, SimpleParagraph, FullImage, Button
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

        const steps = reactive([
            {
                img: 'sign-up.png',
                title: 'Sign Up',
                description:
                    'Sign up for your free NEFA Wallet on web, iOS or Android and follow our easy process to set up your profile',
            },
            {
                img: 'fund.png',
                title: 'Fund',
                description:
                    'Choose your preferred payment method such as bank transfer or credit card to top up your NEFA Wallet',
            },
            {
                img: 'buy-crypto.png',
                title: 'Buy Crypto',
                description:
                    'Buy Bitcoin or Ethereum, then securely store it in your Wallet or send it on easily to your friends anywhere',
            },
        ]);

        // Retornar variables y objetos
        return {
            selected,
            accordions,
            steps,
            trans
        };
    },
};
</script>