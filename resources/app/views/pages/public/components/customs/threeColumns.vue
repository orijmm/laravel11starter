<template>
    <div class="w-full py-16 flex flex-col items-center">
        <h2 data-aos="flip-down" class="text-3xl sm:text-4xl font-semibold text-center">
            {{ content[0]?.text ?? trans('global.phrases.hasto_add_content') }}
        </h2>
        <div data-aos="fade-up"
            class="relative w-full flex flex-col lg:flex-row items-center justify-between space-y-12 lg:space-y-0 px-4 xl:px-10 mt-16 sm:mt-8">
            <LandingStep v-for="step in steps" :key="step.title" :step="step" />
            <img src="@/views/pages/public/template/assets/img/getting-started/arrow.png"
                class="hidden lg:inline-block absolute top-32 left-64 xl:left-[22rem] w-24 xl:w-[9.5rem]" alt="" />
            <img src="@/views/pages/public/template/assets/img/getting-started/arrow.png"
                class="hidden lg:inline-block absolute top-32 right-64 xl:right-[22rem] w-24 xl:w-[9.5rem]" alt="" />
        </div>
    </div>
</template>
<script>

import { trans } from "@/helpers/i18n";
import LandingStep from '@/views/pages/public/template/components/landing/Step';
import { reactive } from "vue";

export default {
    components: { LandingStep },
    //colocar en el div: {{ content[0].text }} ó {{ content[0].img }} por cada palabra o contenido
    props: {
        content: {
            type: [Array],
            default: [],
        },
    },
    setup(props) {
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

        return {
            trans,
            steps
        }
    }
}
</script>
