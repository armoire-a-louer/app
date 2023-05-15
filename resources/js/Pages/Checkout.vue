<template>
    <Layout>
        <section class="container mx-auto padding-navbar">
            <h1 class="title">Checkout</h1>
            <a :href="payUrl">PAYER</a>
        </section>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'

export default {
    components: {
        Layout
    },

    props: ["payUrl"]
}
</script>

<style>

</style>