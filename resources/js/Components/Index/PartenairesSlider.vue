<template>
  <div
    class="mx-auto container mt-16"
    @mousedown="startDrag"
    @mouseup="endDrag"
    @touchstart="startDrag"
    @touchend="endDrag"
    @mousemove="move"
    @touchmove="move"
  >
    <div
      ref="wrapper"
      class="flex items-center justify-evenly gap-20 w-auto"
      :style="{ transform: 'translateX(' + posX + 'px)' }"
    >
      <img class="" src="/images/ami.png" alt="Ami" />
      <img class="" src="/images/izac.png" alt="Izac" />
      <img class="" src="/images/marant.png" alt="Marant" />
      <img
        class=""
        src="/images/parisienne-et-alors-1.png"
        alt="Parisienne et alors"
      />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dragging: false,
      dragStart: 0,
      dragEnd: 0,
      posX: 0,
      width: 0,
    };
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

        this.posX += diff;
      }
    },

    move(e) {
        if (this.dragging) {
            const currentPos = e.clientX || e.touches[0].clientX;
            const diff = currentPos - this.dragStart;

            this.posX += diff;

            // Make sure the slider stays within the bounds of the wrapper
            // if (this.posX > 0) {
            // this.posX = 0;
            // } 
            // else if (this.posX < -(this.width - this.$refs.wrapper.offsetWidth)) {
            // this.posX = -(this.width - this.$refs.wrapper.offsetWidth);
            // }

            this.dragStart = currentPos;
        }
    },

    setWidth() {
      this.width = this.$refs.wrapper.offsetWidth;
    },
  },

  mounted() {
    this.setWidth();
  },
};
</script>

<style>
</style>