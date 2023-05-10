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

            // Ensure the slider doesn't move past its bounds
            const wrapperWidth = this.$refs.wrapper.getBoundingClientRect().width;
            const sliderWidth = this.$refs.wrapper.scrollWidth;
            const minX = -(sliderWidth - wrapperWidth);
            const maxX = sliderWidth - wrapperWidth;

            if (this.posX < minX) {
              this.posX = minX;
            } else if (this.posX > maxX) {
              this.posX = maxX;
            }

            this.dragStart = currentPos;
          }
    }
  }
};
</script>

<style>
</style>