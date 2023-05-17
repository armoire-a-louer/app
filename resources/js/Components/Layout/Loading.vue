<template>
  <div class="modal-blur" v-show="loading">
    <div class="loader">
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
    </div>
  </div>
</template>

<script>
export default {
    props: ["loading"],

    mounted() {
        console.log(this.loading)
    }
}
</script>

<style scoped>
.modal-blur {
    backdrop-filter: blur(5px);
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10000000;
    position: absolute;
    top: 0;
    left: 0;
}

.loader {
  display: flex;
  justify-content: center;
}

.square {
  width: 40px;
  height: 40px;
  background-color: black;
  border: 1px solid white;
  margin: 0 5px;
  animation: grow 1.75s infinite;
}

@media screen and(max-width: 600px){
    .square {
        width: 15px;
        height: 15px;
    }
}

.square:nth-child(1) {
  animation-delay: 0s;
}

.square:nth-child(2) {
  animation-delay: 0.25s;
}

.square:nth-child(3) {
  animation-delay: 0.5s;
}

.square:nth-child(4) {
  animation-delay: 0.75s;
}

.square:nth-child(5) {
  animation-delay: 1s;
}

@keyframes grow {
    0% {
        transform: scale(1);
    }
    20% {
        transform: scale(1.5);
    }
    40% {
        transform: scale(1);
    }
}
 
</style>