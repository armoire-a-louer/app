<template>
  <Layout>
    <div class="container mx-auto">
      <Breadcrumb class="padding-navbar" :actualPage="product.name" :links="[{ name: product.category.name, route: route('index') }]"/>
      <section class="py-14 flex gap-16 xl:gap-32 items-start">
        <div class="flex-1">
          <img class="w-full" :src="images.big">
          <div class="flex flex-wrap gap-4 mt-8">
            <img class="small-images cursor-pointer" v-for="(image, index) in images.smalls" :key="image" :src="image" @click="changeBigImage(index)">
          </div>

          <div class="border-light mt-20 mb-10"></div>

          <h2 class="description">Description</h2>
          <p class="mt-9">
            {{ product.description }}
          </p>

          <div class="flex gap-9 mt-8 items-center" v-if="currentItem">
            <img class="object-cover object-center" style="height: 150px; width: 200px;" :src="currentItem.model.image_url" :alt="currentItem.model.name">

            <div class="flex flex-col items-start justify-center">
              <span>Article porté par</span>
              <h5 class="mt-3 model-name">{{ currentItem.model.name }}</h5>
              <span>{{ currentItem.model.size }}cm</span>
              <span>Taille {{ currentItem.model_size.toUpperCase() }}</span>
            </div>
          </div>

          <button type="button" class="font-xl font-bold uppercase underline mt-12">Voir le guide des tailles</button>
        </div>
        <div class="flex-1">
          <span class="font-sackers">{{ product.brand.name }}</span>

          <h1 class="title line-height-65 mt-4 w-full 2xl:w-2/3">{{ product.name }}.</h1>

          <div class="flex gap-4 items-center py-6">
            <div class="flex gap-1">
              <span v-for="index in 5" :key="index">
                <font-awesome-icon  :icon="(ratingsAvg >= index ? 'fa-solid' : 'fa-regular') + ' fa-star'" style="color: #D9C9B0;"/>
              </span>
            </div>
            <a href="#avis" class="underline">
              {{ product.ratings.length }} avis vérifié{{ product.ratings.length > 1 ? 's' : '' }}
            </a>
          </div>

          <span class="price font-black">
            {{ product.price_per_day }}€
            <sup>/</sup>
            <sup class="font-normal"><sup class="jour"> jour</sup></sup>
          </span>

          <div class="flex flex-wrap gap-x-16">
            <div>
              <h4 class="label">Votre taille</h4>
              <div class="flex gap-4 mt-3">
                <SizeButton v-for="size in sizes" :key="size" :size="size" :selectedSize="currentItem ? currentItem.size : ''" @click="changeSize(size)"/>
              </div>
            </div>
            
            <div>
              <h4 class="label">La couleur</h4>
              <div class="flex gap-4 mt-3">
                <ColorButton v-for="color in colors" :key="color" :color="color" :selectedColor="currentItem ? currentItem.primary_color.hex_code : ''" @click="changeColor(color)" :disabled="! colorIsAvailable(color)"/>
              </div>
            </div>
          </div>

          <div>
            <h4 class="label">Vos dates de location</h4>
            <DatesChoices class="flex-1 mt-3"/>
          </div>

          <div class="flex gap-4 items-center mt-12 w-full xl:w-2/3">
            <Button class="flex-1" text="ajouter au panier" route="#" color="white" textColor="black" border="black"/>

            <button class="like-button" type="button" @click="liked = !liked">
              <font-awesome-icon icon="fa-solid fa-heart" class="text-xl" v-if="liked"/>
              <font-awesome-icon icon="fa-regular fa-heart" class="text-xl" v-else/>
            </button>
          </div>

          <div class="flex flex-col items-start mt-12 gap-7">
            <div class="flex gap-5">
              <div class="relative">
                <img class="h-11 w-11" src="/images/pressing.svg" alt="Pressing offert">
                <img class="h-4 w-4 top-0 right-0 absolute" src="/images/ellipse.svg" alt="ellipse">
              </div>
              <div>
                <h4 class="infos">Pressing offert</h4>
                <p>Lorem ipsum dolor amet</p>
              </div>
            </div>

            <div class="flex gap-5">
              <div class="relative">
                <img class="h-11 w-11" src="/images/livraison.svg" alt="Livraison et retours gratuits">
                <img class="h-4 w-4 top-0 left-0 absolute" src="/images/ellipse.svg" alt="ellipse">
              </div>
              <div>
                <h4 class="infos">Livraison et retours gratuits</h4>
                <p>Lorem ipsum dolor amet</p>
              </div>
            </div>

            <div class="flex gap-5">
              <div class="relative">
                <img class="h-11 w-11" src="/images/acheter.svg" alt="Possibilité d'acheter">
                <img class="h-4 w-4 bottom-1 right-0 absolute" src="/images/ellipse.svg" alt="ellipse">
              </div>
              <div>
                <h4 class="infos">Possibilité d'acheter</h4>
                <p>Lorem ipsum dolor amet</p>
              </div>
            </div>
          </div>

        </div>
      </section>
    </div>
  </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import Breadcrumb from '@/Components/Layout/Breadcrumb.vue'
import SizeButton from '@/Components/Buttons/SizeButton.vue'
import ColorButton from '@/Components/Buttons/ColorButton.vue'
import DatesChoices from '@/Components/DatesChoices.vue'
import Button from '@/Components/Buttons/Button.vue'

export default {
    name: "Product",

    props: ["product"],

    components: {
      Layout,
      Breadcrumb,
      SizeButton,
      ColorButton,
      DatesChoices,
      Button
    },

    data() {
      return {
        currentItem: null,
        images: {
          big: '',
          smalls: []
        },
        currentSize: "",
        currentColor: "",
        sizes: [],
        colors: [],
        liked: false,
      }
    },

    methods: {
      choseDefaultItem() {
        if (! this.product.items) {
          this.$inertia.replace(route('index'));
        }

        // Set sizes and colors
        for (let item of this.product.items) {
          if (! this.sizes.includes(item.size)) {
            this.sizes.push(item.size);
          }

          if (! this.colors.includes(item.primary_color.hex_code)) {
            this.colors.push(item.primary_color.hex_code);
          }
        }

        this.setCurrentItem(this.product.items[0]);
      },
      

      setCurrentItem(item) {
        this.currentItem = item;

        this.images = {
          // just one big
          big: this.currentItem.first_image_url,
          // multiple smalls array
          smalls: []
        }

        if (this.currentItem.second_image_url) {
          this.images.smalls.push(this.currentItem.second_image_url);
        }

        if (this.currentItem.third_image_url) {
          this.images.smalls.push(this.currentItem.third_image_url);
        }

        if (this.currentItem.fourth_image_url) {
          this.images.smalls.push(this.currentItem.fourth_image_url);
        }

        this.currentSize = this.currentItem.size;
        this.currentColor = this.currentItem.primary_color.hex_code;
      },

      changeBigImage(index) {
        // trick to copy string
        const oldBigImage = (' ' + this.images.big).slice(1);
        this.images.big = this.images.smalls[index];
        this.images.smalls[index] = oldBigImage;
      },

      changeColor(hexCode) {
        const itemSameSize = this.findItem(hexCode, this.currentSize);
        if (itemSameSize) {
          this.setCurrentItem(itemSameSize);
          return;
        }
        
        const item = this.findItemBySize(size);
        if (item) {
          this.setCurrentItem(item);
          return;
        }

        alert('Veuillez recharger la page.');
      },

      changeSize(size) {
        const itemSameColor = this.findItem(this.currentColor, size);
        if (itemSameColor) {
          this.setCurrentItem(itemSameColor);
          return;
        }
        
        const item = this.findItemBySize(size);
        if (item) {
          this.setCurrentItem(item);
          return;
        }

        alert('Veuillez recharger la page.');
      },

      findItem(hexCode, size) {
        for (let item of this.product.items) {
          if (item.size == size && item.primary_color.hex_code == hexCode) {
            return item;
          }
        }
        return null;
      },

      findItemByColor(hexCode) {
        for (let item of this.product.items) {
          if (item.primary_color.hex_code == hexCode) {
            return item;
          }
        }
        return null;
      },

      findItemBySize(size) {
        for (let item of this.product.items) {
          if (item.size == size) {
            return item;
          }
        }
        return null;
      },

      colorIsAvailable(hexCode) {
        const item = this.findItem(hexCode, this.currentSize);
        if (item) {
          return true;
        }

        return false;
      }
    },

    mounted() {
        console.log(this.product)
        this.choseDefaultItem();
    },

    computed: {
      ratingsAvg() {
        if (! this.product.ratings) return 0;
        return this.product.ratings.reduce((sum, rating) => sum + rating.rating, 0);
      }
    }
}
</script>

<style scoped>
.small-images {
  max-width: 160px;
  max-height: 140px;
  object-fit: cover;
  object-position: center;
}

.line-height-65 {
  line-height: 65px;
}

.price {
  font-size: 46px;
  line-height: 46px;
}

.jour {
  display: inline-block;
  transform: translate(10px, 7px);
}

.label {
  font-weight: 600;
  line-height: 24px;
  font-size: 18;
  margin-top: 26px;
}

.like-button {
  height: 60px;
  width: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px solid black;
  transition: 300ms ease;
}

.like-button:hover {
  color: white;
  background: black;
  border: 0;
}

.infos {
  font-weight: 900;
}

.border-light {
  width: 400px;
  max-width: 100%;
  background-color: #7070701D;
  height: 1px;
}

.description {
  font-size: 50px;
  font-family: 'Roslindale', serif !important;
  line-height: 79px;
}

@media screen and (max-width: 1000px){
  .description {
    font-size: 36px;
  }
}

@media screen and (max-width: 600px){
  .description {
    font-size: 24px;
  }
}

.model-name {
  font-family: "Roslindale", serif;
  font-size: 23px;
  line-height: 27px;
}
</style>