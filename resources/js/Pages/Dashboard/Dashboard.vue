<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },

    data() {
        return {
            transactions: this.$page.props.reservations
        }
    },
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mes réservations</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex flex-col gap-6">
                        <div v-for="transaction in transactions" :key="transaction.id">
                            <div class="flex-1 flex items-center justify-between">
                                <h2 class="font-serif text-2xl mb-4">Réservation payée le {{ transaction.paid_at }}.</h2>
                                <h2 class="font-serif text-3xl mb-4">{{ transaction.amount / 100 }} €.</h2>
                            </div>
                            <div class="flex gap-10" v-for="reservation in transaction.reservations" :key="reservation.id">
                                <img class="object-cover" :src="reservation.item.first_image_url" alt="" style="height: 250px;">

                                <div class="flex flex-col justify-center gap-3">
                                    <h4 class="font-gothic text-xl lowercase">{{ reservation.item.product.brand.name }}</h4>
                                    <h3 class="font-serif text-2xl">{{ reservation.item.product.name }}</h3>
                                    <span class="font-bold">
                                        Du {{ reservation.earliest_date }} au {{ reservation.latest_date }}
                                    </span>
                                    <span>
                                        {{ reservation.count }} jours de location
                                    </span>
                                    <span class="flex flex-col">
                                        Taille: {{ reservation.item.size.toUpperCase() }}
                                        <span class="flex items-center gap-4">
                                            Couleur:  
                                            <span class="h-5 w-5" :style="'background-color:' + reservation.item.primary_color.hex_code + ';'">
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <hr class="my-10">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
