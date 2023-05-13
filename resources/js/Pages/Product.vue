<template>
  <Layout>
    <div class="container mx-auto">
      <Breadcrumb class="padding-navbar" :actualPage="product.name" :links="[{ name: product.category.name, route: route('index') }]"/>
      <section class="py-14 flex gap-32 items-start">
        <div class="flex-1">
          <img class="w-full" :src="images.big">
          <div class="flex flex-wrap gap-4 mt-8">
            <img class="small-images cursor-pointer" v-for="(image, index) in images.smalls" :key="image" :src="image" @click="changeBigImage(index)">
          </div>
        </div>
        <div class="flex-1">
          <span class="font-sackers">{{ product.brand.name }}</span>

          <h1 class="title line-height-65 mt-4">{{ product.name }}.</h1>

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
      </section>
    </div>
  </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import Breadcrumb from '@/Components/Layout/Breadcrumb.vue'
import SizeButton from '@/Components/Buttons/SizeButton.vue'
import ColorButton from '@/Components/Buttons/ColorButton.vue'

export default {
    name: "Product",

    props: ["product"],

    components: {
      Layout,
      Breadcrumb,
      SizeButton,
      ColorButton
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
        colors: []
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
</style>