<template>
    <div>
        test
    </div>
</template>

<script>
export default {
    props: ['paginationData'],

    mounted() {
        console.log(this.paginationData)
    },
}
</script>

<style scoped>

</style>