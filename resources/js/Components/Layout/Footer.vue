<template>
    <footer class="footer">
        <div class="container mx-auto pt-28">
            <div class="flex justify-between items-center md:items-start flex-col md:flex-row pb-16 md:pb-0">
                <div class="flex flex-col items-start">
                    <img class="mb-10" src="/images/logo.svg" alt="logo armoire à louer" style="width: 200px;">

                    <a class="tel mt-12" href="tel:+33-7-88-17-66-49">+33 7 88 17 66 49</a>

                    <a class="text-white mt-2" href="mailto:contact@armoire-a-louer.fr">contact@armoire-a-louer.fr</a>

                    <div class="flex gap-6 items-center mt-12 mb-20">
                        <a href="#">
                            <img src="/images/icons/instagram.png" alt="">
                        </a>
                        <a href="#">
                            <img src="/images/icons/facebook.png" alt="">
                        </a>
                        <a href="#">
                            <img src="/images/icons/pinterest.png" alt="">
                        </a>
                        <a href="#">
                            <img src="/images/icons/twitter.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="footer-links text-white flex justify-start gap-28 flex-col sm:flex-row">
                    <div>
                        <h4 class="footer-title">Titre du menu 1</h4>
                        <ul class="mt-6">
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="footer-title">Titre du menu 2</h4>
                        <ul class="mt-6">
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                            <li class="py-1">
                                <a href="#">Titre de la page</a>
                            </li>
                        </ul>
                    </div>
                    <div class="hidden lg:block"></div>
                </div>
            </div>
            <hr>
            <p class="text-white py-14">
                © 2023 L’Armoire à louer - Tous droits réservés
            </p>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>

<style scoped>
.footer {
    background-color: #1A1A1A;
}

.tel {
    font-weight: bold;
    font-size: 17px;
    line-height: 24px;
    color: white;
}

.footer-title {
    font-size: 20px;
    font-weight: bold;
}

.footer-links a {
    font-size: 17px;
}
</style>