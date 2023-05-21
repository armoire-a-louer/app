<template>
    <div>
        <div class="flex gap-2">
            <Link class="font-bold" :href="route('index')">Accueil</Link>
            <span class="text-md font-bold">
                >
            </span>
            <div v-for="link in links" :key="link.name" class="flex gap-2">
                <Link class="font-bold" :href="link.route">{{ link.name }}</Link>
                <span class="text-md font-bold">
                    >
                </span>
            </div>
            <span>
                {{ actualPage }}
            </span>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: ["links", "actualPage"],

    components: {
        Link
    }
}
</script>

<style scoped>
</style>