<template>
    <div>
        <div class="flex justify-between items-center py-8 cursor-pointer" @click="open = !open">
            <h3 class="font-bold text-xl">
                {{ name }}
            </h3>
            <font-awesome-icon icon="fa-solid fa-chevron-down" class="transition-all" :class="{ 'rotate': open }" />
        </div>

        <div v-if="open" class="mb-10 flex flex-col items-start gap-3">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    props: ['name', 'close'],

    data() {
        return {
            open: true
        }
    },

    mounted() {
        if (this.close) {
            this.open = false;
        }
    }
}
</script>

<style scoped>
.rotate {
    transform: rotate(-180deg);
}
</style>