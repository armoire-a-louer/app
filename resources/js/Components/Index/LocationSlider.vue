<template>
  <div>
    <div class="slider" ref="slider" @mousedown="startDrag" @touchstart="startDrag" @mouseup="endDrag" @touchend="endDrag">
        <div class="slider__wrapper" ref="wrapper" :style="{ transform: 'translateX(' + posX + 'px)' }">
        <div class="slider__item" v-for="(item, index) in items" :key="index" :style="{ flex: '0 0 calc(100% / ' + this.itemsPerPage + ')' }">

            <div>
                <img :src="item.img" alt="">
                <div class="slider__item__hover">
                    <LikeButton :liked="false"/>
                    <Button class="w-full" text="ajouter au panier" :route="route('index')" color="black" textColor="white"/>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h4 class="text-center">{{ item.brand }}</h4>
                <h3 class="title text-center">{{ item.name }}</h3>
                <p class="text-center">
                    {{ item.price }} euros / jour
                </p>
            </div>
        </div>
        </div>

        <div class="slider__wraper"></div>
    </div>
  </div>
</template>

<script>
import Button from '@/Components/Buttons/Button.vue'
import LikeButton from '@/Components/Buttons/LikeButton.vue'

export default {
    name: "Slider",

    components: {
        Button,
        LikeButton
    },
    
  data() {
    return {
      items: [
        {
            img: '/images/location-1.png',
            brand: 'Ami Paris',
            name: 'T-shirt Ami du Coeur',
            price: 11
        },
        {
            img: '/images/location-2.png',
            brand: 'Isabel Marant',
            name: 'Robe Costas',
            price: 13
        },
        {
            img: '/images/location-3.png',
            brand: 'Parisienne et alors',
            name: 'Perfecto Court Daru',
            price: 14
        },
        {
            img: '/images/location-4.png',
            brand: 'Sezane',
            name: 'Robe Pia',
            price: 11
        },
        {
            img: '/images/location-5.png',
            brand: 'Sezane',
            name: 'Costume',
            price: 24
        },
      ],
      posX: 0,
      wrapperWidth: 0,
      itemWidth: 0,
      dragging: false,
      dragStart: 0,
      dragEnd: 0,
      itemsPerPage: window.innerWidth / 426
    };
  },
  mounted() {
    this.setWidths();
    this.$nextTick(() => {
        window.addEventListener('resize', this.setWidths);
    })
  },

  beforeDestroy() {
    this.$nextTick(() => {
        window.removeEventListener('resize', this.setWidths);
    })
  },

  methods: {
    startDrag(e) {
      this.dragging = true;
      this.dragStart = e.clientX || e.touches[0].clientX;
    },
    endDrag(e) {
      if (this.dragging) {
        this.dragging = false;
        this.dragEnd = e.clientX || e.changedTouches[0].clientX;
        const diff = this.dragEnd - this.dragStart;
        const totalPages = this.items.length;
        const currentPage = Math.round(Math.abs(this.posX) / this.itemWidth);
        let targetPage = currentPage;
        if (diff > 0 && currentPage > 0) {
          targetPage--;
        } else if (diff < 0 && currentPage < totalPages - this.itemsPerPage) {
          targetPage++;
        }
        this.posX = -(targetPage * this.itemWidth);

        this.checkButtons();
      }
    },

    setWidths() {
        this.itemWidth = this.$refs.wrapper.offsetWidth / this.itemsPerPage + 8;
        this.wrapperWidth = this.$refs.slider.offsetWidth;

        this.itemsPerPage = window.innerWidth / 426;
    },

    prev() {
        if (this.posX < 0) {
            this.posX += this.itemWidth;

            this.checkButtons();
        }
    },

    next() {
        if (this.posX > -(this.items.length - this.itemsPerPage) * this.itemWidth) {
            this.posX -= this.itemWidth;
            
            this.checkButtons();
        }
    },

    checkButtons() {
        if (this.posX > -(this.items.length - this.itemsPerPage) * this.itemWidth) {
            this.$emit('canNext', true)
        }
        else this.$emit('canNext', false);

        if (this.posX < 0) {
            this.$emit('canPrev', true)
        }
        else this.$emit('canPrev', false);
    }
  }
};
</script>

<style scoped>
.slider {
  overflow: hidden;
  position: relative;
  margin-top: 80px;
}

.slider__wraper {
  position: absolute;
  top: 0;
  right: 0;
  height: 100%;
  width: 300px;
  background: transparent linear-gradient(271deg, #FAF9F7 0%, #FFFFFF00 100%) 0% 0% no-repeat padding-box;
}

@media screen and (max-width: 850px) {
  .slider__wraper {
    width: 150px;
  }
}

.slider h3{
    font-size: 27px;
}

.slider h4{
    font-family: 'SackersGothic', sans-serif;
    text-transform: lowercase;
    letter-spacing: 3px;
}

.slider__wrapper {
  display: flex;
  gap: 16px;
  transition: transform 0.3s ease-out;
}

.slider__item {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.slider__item div {
    position: relative;
    overflow: hidden;
}

.slider__item:hover img{
    transform: scale(1.1);
}

.slider__item img{
    transition: transform 300ms ease;
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
    height: 500px;
}

.slider__item:hover .slider__item__hover{
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 1;
}

.slider__item__hover{
    display: none;
    opacity: 0;
    transition: opacity 300ms ease;
    flex-direction: column;
    justify-content: space-between;
    padding: 25px;
    align-items: flex-start;
}
</style>