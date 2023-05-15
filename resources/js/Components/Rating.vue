<template>
    <div class="avis" data-aos="fade-up">
        <h4 class="name">{{ rating.user.firstname }} {{ rating.user.lastname.slice(0, 1).toUpperCase() }}.</h4>
        <span>Loué en {{ date }}</span>
        
        <div class="flex gap-1 mt-4">
            <span v-for="index in 5" :key="index">
            <font-awesome-icon  :icon="(rating.rating >= index ? 'fa-solid' : 'fa-regular') + ' fa-star'" style="color: #D9C9B0;"/>
            </span>
        </div>

        <p class="mt-6">
            {{ rating.comment }}
        </p>
    </div>
</template>

<script>
export default {
    props: ["rating"],

    computed: {
        date() {
            const date = new Date(this.rating.rented_at);
            const options = { month: 'long', year: 'numeric' };
            const formattedString = date.toLocaleString('fr-FR', options);
            return formattedString;
        }
    }
}
</script>

<style scoped>
.avis {
    box-shadow: 0px 0px 20px #00000012;
    padding: 40px 50px;
}

.name {
    font-weight: 900;
    font-size: 23px;
    line-height: 27px;
}

</style>