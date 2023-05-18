<template>
    <div class="flex gap-5 items-center my-20 font-bold">
        <span class="flex gap-3 items-center cursor-pointer" @click="$emit('setStep', 1)">
            Livraison
            <img v-if="step > 1" src="/images/check-black.svg">
            <img v-else src="/images/check-gray.svg">
        </span>
        <hr class="flex-1">
        <span class="flex gap-3 items-center cursor-pointer" @click="$emit('setStep', 2)">
            Retours
            <img v-if="step > 2" src="/images/check-black.svg">
            <img v-else src="/images/check-gray.svg">
        </span>
        <hr class="flex-1">
        <span class="flex gap-3 items-center cursor-pointer" @click="$emit('setStep', 3)">
            Paiement
            <img src="/images/check-gray.svg">
        </span>
    </div>
</template>

<script>
export default {
    props: ["step"]
}
</script>

<style scoped>

</style>