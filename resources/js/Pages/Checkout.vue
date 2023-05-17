<template>
    <CheckoutLayout :loading="loading">
        <!-- MOBILE & TABLETTES -->
        <section class="mobile container mx-auto padding-navbar">
            <h1 class="title">Checkout</h1>
            <a @click="pay">PAYER</a>
        </section>

        <!-- ORDINATEUR -->
        <section class="ordinateur container mx-auto padding-navbar">
            ordinateur
        </section>
    </CheckoutLayout>
</template>

<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue'
import axios from 'axios'

export default {
    components: {
        CheckoutLayout
    },

    data() {
        return {
            loading: false,
            form: {
                firstname: "",
                lastname: "",
                phone: "",
                address: "",
                postal_code: "",
                city: ""
            }
        }
    },

    methods: {
        pay() {
            this.loading = true;

            axios.post(route('pay'))
                .then((response) => {
                    window.location.href = response.data.redirect_stripe_url;
                    this.loading = false;
                })
                .catch((error) => {
                    // Rediriger vers le panier ?
                    // Montrer quels articles posent soucis
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
.mobile {
    display: none;
}

.ordinateur {
    height: 100vh;
}

@media screen and (max-width: 1300px) {
    .mobile {
        display: block;
    }

    .ordinateur {
        display: none;
    }
}
</style>