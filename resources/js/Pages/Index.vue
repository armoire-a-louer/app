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
                    <Button class="mt-5" text="Découvrir nos marques" :route="route('index')" color="white" textColor="black"/>
                </div>
            </div>
            <div class="header-bottom"></div>
        </div>

        <section class="steps container mx-auto flex justify-center items-center pt-28 flex-wrap gap-x-6 gap-y-16">
            <div class="flex flex-col gap-2 items-center">
                <img src="/images/illu-1.svg" alt="Choisissez vos vêtements">
                <h3 class="text-center pt-5 title">Choisissez vos vêtements.</h3>
                <p class="text-center w-2/3">
                    Parcourez nos collections et choisissez ce qu’il vous plaît
                </p>
            </div>
            <div class="flex flex-col gap-2 items-center">
                <img src="/images/illu-2.svg" alt="Portez-les">
                <h3 class="text-center pt-5 title">Portez-les.</h3>
                <p class="text-center w-2/3">
                    Parcourez nos collections et choisissez ce qu’il vous plaît
                </p>
            </div>
            <div class="flex flex-col gap-2 items-center">
                <img src="/images/illu-3.svg" alt="Retournez-les ou achetez-les">
                <h3 class="text-center pt-5 title">Retournez-les ou achetez-les.</h3>
                <p class="text-center w-2/3">
                    Parcourez nos collections et choisissez ce qu’il vous plaît
                </p>
            </div>
        </section>

        <section class="relative a-propos mt-20 md:mt-52">
            <img src="/images/photo-men.png" alt="">
            <div class="flex flex-col gap-7 items-start py-24 px-16">
                <h2 class="title">
                    Avec l’Armoire à Louer, n’achetez plus vos vêtements, louez-les !
                </h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                </p>
                <Button text="À propos de nous" :route="route('index')" border="black" textColor="black"/>
            </div>
        </section>

        <section class="selection container mx-auto mt-20 md:mt-36">
            <h2 class="title text-center">On les a séléctionnés pour vous.</h2>
            <div class="flex justify-between mt-11">
                <img src="/images/photo-1.png" alt="Vestes">
                <img src="/images/photo-2.png" alt="Vestes">
                <img src="/images/photo-3.png" alt="Vestes">
                <img src="/images/photo-4.png" alt="Vestes">
            </div>
        </section>

        <img class="location-separation" src="/images/arrondi.svg">
        <section class="location">
            <div class="container mx-auto py-20 overflow-visible">
                <div class="flex justify-between items-center">
                    <h2 class="title">Les plus loués.</h2>
                    <div class="flex gap-10">
                        <button class="text-4xl" :class="canPrev ? '' : 'disabled'" type="button" @click="$refs.slider.prev()">
                            <font-awesome-icon icon="fa-solid fa-chevron-left" />
                        </button>
                        <button class="text-4xl" :class="canNext ? '' : 'disabled'" type="button" @click="$refs.slider.next()">
                            <font-awesome-icon icon="fa-solid fa-chevron-right" />
                        </button>
                    </div>
                </div>

                <LocationSlider ref="slider" @canPrev="canPrev = $event" @canNext="canNext = $event"/>
            </div>
        </section>
        <img src="/images/arrondi-bas.svg">


    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import Button from '@/Components/Buttons/Button.vue'
import LocationSlider from '@/Components/Index/LocationSlider.vue'

export default {
    name: 'Index',
    
    components: {
        Layout,
        Button,
        LocationSlider
    },

    data() {
        return {
            canPrev: false,
            canNext: true
        }
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
        line-height: 75px;
    }   
}

@media screen and (max-width: 550px){
    .header h1 {
        font-size: 50px;
        line-height: 65px;
    }
}

@media screen and (max-width: 460px){
    .header h1 {
        font-size: 40px;
        line-height: 55px;
    }
}

.header p {
    text-rendering: optimizeLegibility;
}

.steps h3 {
    font-size: 27px;
    font-family: 'Roslindaleme';
}

.steps img {
    height: 230px;
    width: auto;
}

.a-propos div{
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    width: 60%;
}

.a-propos h2 {
    font-size: 46px;
    line-height: 59px;
}

.a-propos div > *{
    max-width: 600px;
}

@media screen and (max-width: 1220px){
    .a-propos img{
        max-height: 500px;
        object-fit: cover;
    }
}

@media screen and (max-width: 1023px){
    .a-propos img{
        width: 450px;
    }
}

@media screen and (max-width: 850px){
    .a-propos div{
        position: relative;
        width: 100%;
        transform: none;
    }

    .a-propos img{
        width: 100%;
        height: 300px;
        object-fit: cover;
        object-position: top;
    }
}

@media screen and (max-width: 600px){
    .a-propos img{
        height: 230px;
    }

    .a-propos div{
        padding-top: 30px;
    }

    .a-propos h2 {
        font-size: 24px;
        line-height: 34px;
    }
}

.selection h2{
    font-size: 48px;
}

.selection img {
    width: 23%;
}

@media screen and (max-width: 980px){
    .selection {
        margin-top: 200px;
    }
}

@media screen and (max-width: 700px){
    .selection div {
        flex-direction: column;
        gap: 25px;
    }

    .selection img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        object-position: top;
    }

    .selection h2 {
        font-size: 24px;
    }

    .selection {
        margin-top: 50px;
    }
}

.location-separation {
    margin-top: 100px;
}

.location {
    background-color: rgba(202, 189, 168, 0.1);
}

.location h2{
    font-size: 48px;
}

.disabled {
    color: rgba(0, 0, 0, 0.3);
}
</style>