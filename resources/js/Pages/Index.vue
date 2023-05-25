<template>
    <Layout ref="layout">

        <Head>
            <title>Accueil</title>
            <meta name="description" content="Bienvenue sur L'Armoire à Louer, votre destination en ligne pour louer des vêtements de marque de qualité. Découvrez notre vaste sélection de styles et louez votre tenue parfaite pour chaque occasion. Profitez de la flexibilité de la location de vêtements et élevez votre style sans effort.">
        </Head>

        <div class="header">
            <div class="header-gradient"></div>
            <div class="container mx-auto header-container">
                <div class="z-50 flex gap-4 flex-col items-start">
                    <h1 class="app-title">Changer de look <br> à volonté.</h1>
                    <p class="w-100 sm:w-4/5 md:w-3/5 lg:w-2/5 text-white">
                        L’Armoire à louer, plateforme de location de vêtements de haute couture vous offre l’opportunité de vivre un luxe responsable quand vous le souhaitez.
                    </p>
                    <Button class="mt-5" text="Découvrir nos marques" :route="route('search')" color="white" textColor="black"/>
                </div>
            </div>
            <div class="header-bottom"></div>
        </div>

        <section class="steps container mx-auto flex justify-center md:justify-between xl:justify-center items-center pt-28 flex-wrap gap-x-6 gap-y-16">
            <div class="flex flex-col gap-2 items-center md:w-1/4">
                <img class="mb-10" src="/images/illu-1.svg" alt="Choisissez vos vêtements">
                <h3 id="first" class="text-center mt-5 title">Choisissez vos vêtements.</h3>
                <p class="text-center xl:w-2/3">
                    Parcourez nos collections et choisissez ce qu’il vous plaît
                </p>
            </div>
            <div class="flex flex-col gap-2 items-center md:w-1/4">
                <img class="mb-10" src="/images/illu-2.svg" alt="Portez-les">
                <h3 id="second" class="text-center mt-5 title">Portez-les.</h3>
                <p class="text-center xl:w-2/3">
                    Recevez et portez vos vêtements à volonté pendant votre période de location
                </p>
            </div>
            <div class="flex flex-col gap-2 items-center md:w-1/4">
                <img class="mb-10" src="/images/illu-3.svg" alt="Retournez-les ou achetez-les">
                <h3 id="third" class="text-center mt-5 title">Retournez-les ou achetez-les.</h3>
                <p class="text-center xl:w-2/3">
                    Retournez-nous les vêtements ou achetez-les en quelques clics
                </p>
            </div>
        </section>

        <section class="relative a-propos mt-20 md:mt-52">
            <img src="/images/photo-men.png" alt="">
            <div class="flex flex-col gap-7 items-start py-24 px-16">
                <h2 class="smaller-title">
                    Avec l’Armoire à Louer, n’achetez plus vos vêtements, louez-les !
                </h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                </p>
                <Button text="À propos de nous" :route="route('concept')" border="black" textColor="black"/>
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

        <div class="location-separation"></div>
        <VousAimerezAussi title="Les plus loués." :products="mostRentedProducts"/>

        <section class="partenaires mt-16 container mx-auto">
            <h2 class="text-center title">Nos marques partenaires.</h2>
            <p class="text-center mt-5 w-100 sm:w-2/3 2xl:w-3/5  mx-auto">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
            </p>
        </section>
        <PartenairesSlider />
        <div class="flex justify-center mt-4">
            <Button :route="route('search')" text="Découvrir toutes nos marques" color="black" textColor="white"/>
        </div>


        <section class="mx-auto container mt-40">
            <div class="products">
                <div>
                    <div class="w-11/12 sm:w-10/12 md:w-9/12 lg:w-7/12 xl:w-4/12 h-full mx-auto flex flex-col gap-10 justify-center items-center">
                        <h2 class="title text-white text-center">Lorem ipsum.</h2>
                        <p class="text-white text-center">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.
                        </p>
                        <Button :route="route('search')" text="Parcourir nos produits" color="white" textColor="black"/>                        
                    </div>
                </div>
            </div>
        </section>

        <section class="faq mt-32 container mx-auto">
            <h2 class="title text-center">Vos questions fréquentes.</h2>
            <FAQ />
        </section>

        <section class="mt-36">
            <h2 class="title text-center">Ils en parlent mieux que nous.</h2>

            <Feedbacks />
        </section>

        
        <img src="/images/arrondi-conseils.svg">
        <section class="conseils pb-48">
            <div class="container mx-auto">
                <h2 class="title mb-5 pt-8">Nos conseils.</h2>
                <p class="w-full md:w-3/4 xl:w-1/2 mb-16">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>

                <div class="flex gap-8 lg:gap-4 flex-wrap lg:flex-nowrap">
                    <div class="w-full">
                        <ConseilCard />
                    </div>
                    <div class="w-full">
                        <ConseilCard />
                    </div>
                    <div class="w-full">
                        <ConseilCard />
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import Button from '@/Components/Buttons/Button.vue'
import PartenairesSlider from '@/Components/Index/PartenairesSlider.vue'
import FAQ from '@/Components/Index/FAQ.vue'
import Feedbacks from '@/Components/Index/Feedbacks.vue'
import ConseilCard from '@/Components/Index/ConseilCard.vue'
import VousAimerezAussi from '@/Components/Index/VousAimerezAussi.vue'
import { Head } from '@inertiajs/inertia-vue3'

export default {
    name: 'Index',
    
    components: {
        Layout,
        Button,
        PartenairesSlider,
        FAQ,
        Feedbacks,
        ConseilCard,
        VousAimerezAussi,
        Head
    },

    props: ["mostRentedProducts"],

    data() {
        return {

        }
    },

    mounted() {
        if (this.$inertia.page.props.openBasket) {
            this.$refs.layout.toggleBasket();
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

.location-separation {
    margin-top: 100px;
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

.app-title {
    font-size: 80px;
    font-weight: bold;
    color: white;
    line-height: 95px;
    font-family: 'Roslindale', serif !important;
}

@media screen and (max-width: 1100px){
    .app-title {
        font-size: 60px;
        line-height: 75px;
    }
}

@media screen and (max-width: 550px){
    .app-title {
        font-size: 50px;
        line-height: 65px;
    }
}

@media screen and (max-width: 460px){
    .app-title {
        font-size: 40px;
        line-height: 55px;
    }
}

.header p {
    text-rendering: optimizeLegibility;
}

.steps h3 {
    font-size: 27px;
    font-family: 'Roslindale';
    position: relative;
}

.steps h3::before {
    position: absolute;
    width: 100%;
    height: 100px;
    line-height: 100px;
    text-align: center;
    font-family: 'Roslindale';
    left: 0;
    top: 0;
    font-size: 80px;
    color: #1A1A1A;
    opacity: 0.04;
    display: block;
    top: 50%;
    transform: translateY(-50%);
}

#first::before {
    content: "01";
}

#second::before {
    content: "02";
}

#third::before {
    content: "03";
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

    .selection {
        margin-top: 50px;
    }
}

.products {
    height: 560px;
    display: flex;
    background: url('/images/photo-container.jpg');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}

.products > div {
    background: rgba(0, 0, 0, 0.3);
    flex: 1;
}

.conseils {
    background: rgba(202, 189, 168, 0.08);
}
</style>