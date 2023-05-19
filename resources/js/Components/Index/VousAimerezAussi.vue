<template>
    <img src="/images/arrondi.svg">
    <section class="location">
        <div class="container mx-auto py-20 overflow-visible">
            <div class="flex justify-between items-center">
                <h2 class="title">{{ title }}</h2>
                <div class="flex gap-10">
                    <button class="text-4xl" :class="canPrev ? '' : 'disabled'" type="button" @click="$refs.slider.prev()">
                        <font-awesome-icon icon="fa-solid fa-chevron-left" />
                    </button>
                    <button class="text-4xl" :class="canNext ? '' : 'disabled'" type="button" @click="$refs.slider.next()">
                        <font-awesome-icon icon="fa-solid fa-chevron-right" />
                    </button>
                </div>
            </div>

            <LocationSlider ref="slider" :products="products" @canPrev="canPrev = $event" @canNext="canNext = $event"/>
        </div>
    </section>
    <img src="/images/arrondi-bas.svg">
</template>

<script>
import LocationSlider from './LocationSlider.vue'

export default {
    components: {
        LocationSlider
    },

    props: ["title", "products"],

    data() {
        return {
            canPrev: false,
            canNext: true
        }
    }
}
</script>

<style scoped>
.location {
    background-color: rgba(202, 189, 168, 0.1);
}

.disabled {
    color: rgba(0, 0, 0, 0.3);
}
</style>