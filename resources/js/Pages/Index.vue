<template>
    <Layout>
        <div class="header">
            <div class="header-gradient"></div>
            <div class="container mx-auto header-container">
                <div class="z-50 flex gap-4 flex-col items-start">
                    <h1 class="title">Changer de look <br> à volonté.</h1>
                    <p class="w-100 sm:w-4/5 md:w-3/5 lg:w-2/5 text-white">
                        L’Armoire à louer, plateforme de location de vêtements de haute couture vous offre l’opportunité de vivre un luxe responsable quand vous le souhaitez.
                    </p>
                    <WhiteButton class="mt-5" text="Découvrir nos marques" :route="route('index')"/>
                </div>
            </div>
            <div class="header-bottom"></div>
        </div>
        <section class="container flex justify-between items-center">
            <div class="flex flex-col gap-5 ">
                <img src="/images/home-1.png" alt="Choisissez vos vêtements">
                <h3 class="text-center">Choisissez vos vêtements.</h3>
                <p class="text-center">
                    Parcourez nos collections et choisissez ce qu’il vous plaît
                </p>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import WhiteButton from '@/Components/Buttons/WhiteButton.vue'

export default {
    name: 'Index',
    
    components: {
        Layout,
        WhiteButton
    }
}
</script>

<style scoped>
.header {
    background-image: url('/images/index-header.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    height: 945px;
    max-height: 100vh;
}

.header-bottom {
    background-image: url('/images/index-header-bottom.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 182px;    
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    transform: translateY(5px);
}

.header-container {
    height: 100%;
    display: flex;
    align-items: center;
}

.header-gradient {
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background: transparent linear-gradient(180deg, #000000 0%, #54545400 100%) 0% 0% no-repeat padding-box;
    opacity: 0.53;
    position: absolute;
}

.header h1 {
    font-size: 80px;
    font-weight: bold;
    color: white;
    line-height: 95px;
}

@media screen and (max-width: 1100px){
    .header h1 {
        font-size: 60px;
    }
}

@media screen and (max-width: 550px){
    .header h1 {
        font-size: 50px;
    }
}

@media screen and (max-width: 460px){
    .header h1 {
        font-size: 40px;
    }
}

.header p {
    text-rendering: optimizeLegibility;
}
</style>