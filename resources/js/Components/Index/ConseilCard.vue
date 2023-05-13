<template>
  <div class="card flex flex-col gap-7">
    <div class="image-container">
        <img class="lg:h-full h-56 object-cover w-full" :src="conseil.img" :alt="conseil.title">
    </div>
    <div class="flex items-center gap-4">
        <span class="tag">Mode</span>
        <span class="centered-dot">&#183;</span>
        <span class="date">Publié le {{ conseil.date }}</span>
    </div>
    <div>
        <h3 class="title mb-2">{{ conseil.title }}</h3>
        <p>{{ conseil.short_description }}</p>
    </div>
  </div>
</template>

<script>
export default {
    props: ['//conseil'],

    data() {
        return {
            conseil: {
                img: '/images/banner-4.jpg',
                title: 'Nos 3 conseils du mois !',
                category: 'Mode',
                date: '06/01/2023',
                short_description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation'
            }
        }
    }
}
</script>

<style scoped>
.card:hover {
    cursor: pointer;
}

.image-container{
    overflow: hidden;
}

.image-container img {
    transition: 300ms ease;
}

.card:hover .image-container img {
    transform: scale(1.10);
}

.tag {
    font-size: 18px;
    font-weight: bold;
}

.centered-dot {
    font-size: 50px;
    line-height: 0;
}

.title {
    font-size: 30px;
    font-weight: bold;
}

@media screen and (max-width: 1100px){
    .title {
        font-size: 25px !important;
    }
}
</style>