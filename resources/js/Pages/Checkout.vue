<template>
    <CheckoutLayout :loading="loading">
        <!-- MOBILE & TABLETTES -->
        <section class="mobile pb-14">
            <!-- <h1 class="title">Checkout</h1>
            <a @click="pay">PAYER</a> -->
            <div class="bg-beige">
                <div class="container mx-auto pt-7 pb-5">
                    <h1 class="checkout-mobile-title">Votre réservation</h1>

                    <div v-for="reservation in reservations" :key="reservation.id" class="flex justify-start items-center gap-5 py-7" data-aos="fade-up">
                        <img class="object-cover h-52 w-36 md:h-56 md:w-40 lg:h-64 lg:w-48" :src="reservation.item.first_image_url" :alt="reservation.item.product.name">

                        <div>
                            <h3 class="text-sm lg:text-xl font-gothic lowercase letter-spacing">{{ reservation.item.product.brand.name }}</h3>
                            <h2 class="font-serif text-xl md:text-2xl lg:text-3xl pt-2">{{ reservation.item.product.name }}</h2>

                            <span class="font-bold block pt-4 lg:text-lg">
                                Du {{ formatDate(reservation.earliest_date) }} au {{ formatDate(reservation.latest_date) }}
                            </span>
                            <span class="block lg:text-lg">
                                {{ countDays(reservation.earliest_date, reservation.latest_date) }} jours de location
                            </span>

                            <button @click="removeFromBasket()" type="button" class="underline mt-3 lg:text-lg text-beige">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <img src="/images/arrondi-bas.svg" alt="">

            <h2 class="font-serif text-3xl text-center mt-8 pb-2">Livraison.</h2>
            <p v-for="reservation in reservations" :key="reservation.id" class="text-center">
                Date de livraison : <span class="font-bold">{{ formatBigDate(reservation.earliest_date) }}</span>
            </p>

            <div class="container mx-auto">
                <h3 class="font-bold text-xl mt-8">Adresse de livraison</h3>

                <div v-if="addresses && addresses.length" class="mt-8 flex flex-col gap-6">
                    <div class="transition-all address" v-for="address in addresses" :key="address.id" :class="selectedAddressId === address.id ? 'selected' : ''" @click="selectedAddressId = address.id" data-aos="fade-up">
                        <p>{{ address.firstname }} {{ address.lastname.toUpperCase() }}</p>
                        <p>{{ address.address }}, {{ address.postal_code }} {{ address.city }}</p>
                        <p>{{ address.phone_number }}</p>
                    </div>
                </div>

                <p v-if="!showAddressForm" @click="showAddressForm = true" class="text-right text-beige underline mt-2">Ajouter une nouvelle addresse</p>

                <Button v-if="!showAddressForm && selectedAddressId" class="w-full mt-8" type="sumbit" text="valider mon adresse" color="black" textColor="white" @click="step = 2"/>

                <form @submit.prevent="addAddress()" class="mt-3" v-if="showAddressForm">
                    <label class="mt-3 block" for="firstname">Prénom <span class="text-beige">*</span></label>
                    <input class="input" name="firstname" type="text" v-model="form.firstname" required>

                    <label class="mt-3 block" for="lastname">Nom <span class="text-beige">*</span></label>
                    <input class="input" name="lastname" type="text" v-model="form.lastname" required>

                    <label class="mt-3 block" for="phone_number">Téléphone <span class="text-beige">*</span></label>
                    <input class="input" name="phone_number" type="text" v-model="form.phone_number" required>

                    <label class="mt-3 block" for="address">Adresse <span class="text-beige">*</span></label>
                    <input class="input" name="address" type="text" v-model="form.address" required>

                    <label class="mt-3 block" for="postal_code">Code postal <span class="text-beige">*</span></label>
                    <input class="input" name="postal_code" type="text" v-model="form.postal_code" required>

                    <label class="mt-3 block" for="city">Ville <span class="text-beige">*</span></label>
                    <input class="input" name="city" type="text" v-model="form.city" required>

                    <Button class="w-full mt-8" type="sumbit" text="Ajouter mon addresse" color="black" textColor="white"/>
                </form>

                <div v-if="step > 1" data-aos="fade-up">
                    <hr class="my-14">

                    <h2 class="font-serif text-3xl text-center mt-8 pb-2">Retour.</h2>
                    <p v-for="reservation in reservations" :key="reservation.id" class="text-center">
                        Date de retour : <span class="font-bold">{{ formatBigDate(reservation.latest_date) }}</span>
                    </p>

                    <p class="mt-8 text-center">
                        Déposez la tenue dans n'importe quel <a class="underline" href="#">point relais Colissimo</a> à la date prévue.
                    </p>
                    <Button class="w-full mt-7" text="continuer vers le paiement" @click="step = 3" color="black" textColor="white"/>
                </div>

                <div v-if="step > 2" data-aos="fade-up">
                    <hr class="my-14">

                    <h2 class="font-serif text-3xl text-center mt-8 pb-2">Paiement.</h2>
                    <span class="text-center block">
                        <font-awesome-icon icon="fa-brands fa-stripe" class="opacity-20 w-28 h-12"/>
                    </span>

                    <div class="mt-2 flex flex-col gap-2">
                        <div class="flex justify-between" v-for="reservation in reservations" :key="reservation.id">
                            <span>{{ reservation.item.product.name }}</span>
                            <span>{{ String((reservation.total_price / 100).toFixed(2)).replace('.', ',') }}€</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Livraison</span>
                            <span>10,00€</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Assurance</span>
                            <span>Offerte</span>
                        </div>
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span>{{ total }}</span>
                        </div>
                    </div>

                    <Button class="w-full mt-7" text="valider ma réservation" color="black" textColor="white" @click="pay()"/>
                </div>

            </div>
        </section>

        <!-- ORDINATEUR -->
        <section class="ordinateur container mx-auto">
            ordinateur
        </section>
    </CheckoutLayout>
</template>

<script>
import CheckoutLayout from '@/Layouts/CheckoutLayout.vue'
import axios from 'axios'
import Button from '@/Components/Buttons/Button.vue'

export default {
    components: {
        CheckoutLayout,
        Button
    },

    props: ["reservations"],

    mounted() {
        console.log(this.reservations);
        console.log(this.addresses);

        this.selectedAddressId = this.addresses[0].id;
    },

    data() {
        return {
            addresses: this.$inertia.page.props.addresses,
            step: 1,
            loading: false,
            form: {
                firstname: "",
                lastname: "",
                phone_number: "",
                address: "",
                postal_code: "",
                city: ""
            },
            selectedAddressId: null,
            showAddressForm: this.addresses && this.addresses.length === 0
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
        },

        removeFromBasket() {

        },

        formatDate(date) {
            date = new Date(date);

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            
            return `${day}/${month}`;
        },

        formatBigDate(date) {
            date = new Date(date);

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = String(date.getFullYear());

            return `${day}/${month}/${year}`;
        },

        countDays(earliestDate, latestDate) {
            earliestDate = new Date(earliestDate);
            latestDate = new Date(latestDate);

            const oneDay = 24 * 60 * 60 * 1000;

            const diffInMilliseconds = Math.abs(latestDate - earliestDate);
            // ON AJOUTE UN JOUR CAR IL FAUT TOUS LES COMPTER (PAS QUE LA DIFFERENCE)
            const diffInDays = Math.floor(diffInMilliseconds / oneDay) + 1;

            return `${diffInDays}`;
        },

        addAddress() {
            axios.post(route('add-address'), this.form)
                .then((response) => {
                    this.selectedAddressId = response.data.address.id;
                    this.addresses = response.data.addresses;
                    this.showAddressForm = false;
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    },

    computed: {
        total() {
            let total = 0;
            this.reservations.forEach((reservation) => {
                total += parseInt(reservation.total_price);
            });

            // On ajoute la livraison
            total += 1000;

            total = String((total / 100).toFixed(2)).replace('.', ',');

            return `${total}€`;
        }
    }
}
</script>

<style scoped>
.mobile {
    display: none;
    padding-top: 120px;
}

.bg-beige {
    background-color: #FAF9F7;
}

.text-beige {
    color: #CABDA8;
}

.checkout-mobile-title {
    font-family: "Roslindale", serif;
    font-size: 29px;
    line-height: 29px;
}

.ordinateur {
    min-height: 100vh;
}

.letter-spacing {
    letter-spacing: 0.2rem;
}

.input {
    width: 100%;
    border: 2px solid #1A1A1A;
    margin-top: 5px;
}

.address {
  position: relative;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
    padding: 10px 0;   
    padding-right: 20px;
}

.selected::after {
  content: '\2713';
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 5px;
  color: white;
  background-color: green;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  text-align: center;
  line-height: 20px;
  font-weight: bold;
  transition: opacity 0.3s ease-in-out;
  opacity: 0;
}

.selected.selected::after {
  opacity: 1;
}

.input:focus {
    outline: none;
    box-shadow: none;
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