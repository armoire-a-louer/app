<template>
  <button type="button" class="button font-heavy" :class="isSelected ? 'selected' : ''" :disabled="disabled">
    {{ size.toUpperCase() }}
    <span class="check" v-if="isSelected">
        <font-awesome-icon icon="fa-solid fa-check" />
    </span>
  </button>
</template>

<script>
export default {
    props: ["size", "selectedSize", "disabled"],

    computed: {
        isSelected() {
            return this.size === this.selectedSize;
        }
    }
}
</script>

<style scoped>
.button {
    background: white;
    color: black;
    font-size: 20px;
    height: 56px;
    width: 56px;
    text-align: center;
    line-height: 56px;
    transition: 300ms ease;
    position: relative;
    box-shadow: 0px 0px 30px #00000017;
}

.button:disabled {
    opacity: 0.5;
}

.selected {
    border: 2px solid black;
}

.check {
    color: white;
    background: black;
    border-radius: 150px;
    padding: 3px;
    top: -9px;
    right: -9px;
    font-size: 12px;
    line-height: 10px;
    position: absolute;
}
</style>