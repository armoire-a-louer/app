<template>
    <Layout>
        <Head>
            <title>Concept</title>
            <meta name="description" content="Bienvenue sur L'Armoire à Louer, votre destination en ligne pour louer des vêtements de marque de qualité. Découvrez notre vaste sélection de styles et louez votre tenue parfaite pour chaque occasion. Profitez de la flexibilité de la location de vêtements et élevez votre style sans effort.">
        </Head>

        <PageInProgress class="mt-60 mb-20 "/>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import { Head } from '@inertiajs/inertia-vue3'
import PageInProgress from '@/Components/PageInProgress.vue'

export default {
    name: 'Concept',
    
    components: {
        Layout,
        Head,
        PageInProgress
    }
}
</script>

<style scoped>

</style>