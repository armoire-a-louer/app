<template>
  <div class="accordion">
    <div
      v-for="(item, index) in items"
      :key="index"
      class="accordion-item"
      :class="{ 'show': activeIndex === index }"
    >
      <div class="accordion-header" @click="toggleItem(index)">
        <h4>{{ item.header }}</h4>
        <span :class="{ 'show': activeIndex === index }">
          <font-awesome-icon icon="fa-solid fa-chevron-right" />
        </span>
      </div>
      <div class="accordion-content">
        {{ item.content }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeIndex: null,
      items: [
        {
          header: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate'
        },
        {
          header: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate'
        },
        {
          header: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit ?',
          content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco aboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate'
        }
      ]
    }
  },
  methods: {
    toggleItem(index) {
      if (this.activeIndex === index) {
        this.activeIndex = null
      } else {
        this.activeIndex = index
      }
    }
  }
}
</script>

<style>
.accordion {
  display: flex;
  flex-direction: column;
  gap: 25px;
  max-width: 1000px;
  margin: auto;
  margin-top: 50px;
}

.accordion-item {
  margin-bottom: 1rem;
  box-shadow: 0px 2px 30px #0000001A;
  padding: 28px 40px;
}

.accordion-header {
  cursor: pointer;
  font-size: 22px;
  font-weight: bold;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 25px;
}

@media screen and (max-width: 600px) {
  .accordion-header {
    font-size: 18px;
  }
}

.accordion-content {
  overflow: hidden;
  -webkit-transition: max-height 1s ease; 
  -moz-transition: max-height 1s ease; 
  -ms-transition: max-height 1s ease; 
  -o-transition: max-height 1s ease; 
  transition: max-height 1s ease;  
  -webkit-transition: padding 1s ease; 
  -moz-transition: padding 1s ease; 
  -ms-transition: padding 1s ease; 
  -o-transition: padding 1s ease; 
  transition: padding 1s ease;
  -webkit-transition: opacity 1s ease; 
  -moz-transition: opacity 1s ease; 
  -ms-transition: opacity 1s ease; 
  -o-transition: opacity 1s ease; 
  transition: opacity 1s ease;  
  max-height: 0;
  overflow: hidden;
  opacity: 0;
}

.accordion-item.show .accordion-content {
  max-height: 1000px !important;
  padding-top: 25px;
  opacity: 1;
}

.accordion-header span.show {
  transform: rotate(-90deg);
}

.accordion-header span {
  -webkit-transition: transform 500ms ease; 
  -moz-transition: transform 500ms ease; 
  -ms-transition: transform 500ms ease; 
  -o-transition: transform 500ms ease; 
  transition: transform 500ms ease;  
}
</style>
