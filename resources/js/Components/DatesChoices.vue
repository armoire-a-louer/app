<template>
    <button class="button flex gap-5 items-center" type="button">
        <font-awesome-icon class="text-xl" icon="fa-regular fa-calendar" />
        <span class="font-bold text-lg">Choisissez vos dates</span>
        <font-awesome-icon icon="fa-solid fa-chevron-down" />
    </button>
</template>

<script>
export default {
    data() {
        return {
            isModalOpen: false
        }
    },

    methods: {
        toggleModal() {
            this.isModalOpen = ! this.isModalOpen;
        }
    }
}
</script>

<style scoped>
.button {
    box-shadow: 0px 0px 30px #00000017;
    background: #FFFFFF 0% 0% no-repeat padding-box;
    color: black;
    padding: 17px 28px;
}
</style>