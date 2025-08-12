<template>
    <div ref="vantaRef" class="vanta-container">
        <slot /> <!-- Opcional: contenido dentro -->
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue'
import * as THREE from 'three'
import NET from 'vanta/dist/vanta.net.min' // cambia "net" por el efecto que quieras

const vantaRef = ref(null)
let vantaEffect = null

onMounted(() => {
    if (!vantaEffect) {
        vantaEffect = NET({
            el: vantaRef.value,
            THREE, // muy importante pasar la instancia de THREE
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            scale: 1.0,
            scaleMobile: 1.0,
            color: 0xb8b6ff,
            backgroundColor: 0xe0f7f5
        })
    }
})

onBeforeUnmount(() => {
    if (vantaEffect) {
        vantaEffect.destroy()
    }
})
</script>

<style scoped>

</style>
