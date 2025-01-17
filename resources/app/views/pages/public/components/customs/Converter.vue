<template>
    <BaseSection>
        <LandingBuyTradeImage class="sm:hidden mb-8" />
        <div data-aos="fade-right" class="col-span-12 lg:col-span-6 mt-4 xl:mt-20 space-y-6 px-4">
            <h2 class="text-4xl font-semibold sm:pr-8 xl:pr-12">
                Buy & trade on the <br class="hidden sm:block" />
                original crypto exchange.
            </h2>
            <p class="paragraph">
                Buy now and get 40% extra bonus Minimum pre-sale amount 25 Crypto Coin. We accept BTC
                crypto-currency
            </p>
            <div class="space-y-6 lg:pr-12">
                <LandingExchange title="Amount" name="amount" type="number" default-value="5.000"
                    :exchangeSelected="currencySelected" :exchanges="currencies" />
                <LandingExchange title="Get" name="get" type="number" default-value="0.10901"
                    :exchangeSelected="cryptoSelected" :exchanges="cryptocurrencies" />
                <BaseButton class="w-full px-5 py-4 bg-blue-gradient text-white text-base font-medium">Buy Now
                </BaseButton>
            </div>
        </div>
        <LandingBuyTradeImage data-aos="fade-left" class="hidden sm:block" />
    </BaseSection>
</template>
<script>

import { ref, reactive } from 'vue';
import BaseSection from '@/views/pages/public/template/components/base/Section';
import LandingBuyTradeImage from '@/views/pages/public/template/components/landing/BuyTradeImage';
import LandingExchange from '@/views/pages/public/template/components/landing/Exchange';
import BaseButton from '@/views/pages/public/template/components/base/Button';

export default {
    components: { BaseSection, LandingBuyTradeImage, BaseButton, LandingExchange },
    props: {
        content: {
            type: [Array],
            default: [], 
        },
    },
    setup(props) {
        const dropdownConcurency = ref(false);
        const dropdownCrypto = ref(false);

        const currencySelected = reactive({
            img: 'country-icon/eng.png',
            name: 'USD',
        });

        const currencies = reactive([
            {
                img: 'country-icon/eng.png',
                name: 'USD',
            },
        ]);

        const cryptoSelected = reactive({
            img: 'crypto-icon/bitcoin.png',
            name: 'BTC',
        });

        const cryptocurrencies = reactive([
            {
                img: 'crypto-icon/bitcoin.png',
                name: 'BTC',
            },
        ]);

        return {
            currencySelected,
            currencies,
            cryptoSelected,
            cryptocurrencies,
            dropdownConcurency,
            dropdownCrypto,
        }
    }
}
</script>
