<template>
    <div class="flex">
        <div class="box cursor-pointer" v-if="paginationData.prev_page_url" @click="$emit('setPage', paginationData.page - 1)">
            <font-awesome-icon icon="fa-solid fa-arrow-left" />
        </div>
        <div class="box cursor-pointer font-bold" @click="$emit('setPage', page)" :class="{ 'selected': page == paginationData.page }" v-for="page in arrayOf3Pages" :key="page">
            {{ page }}
        </div>
        <div class="box cursor-pointer" v-if="paginationData.next_page_url" @click="$emit('setPage', paginationData.page + 1)">
            <font-awesome-icon icon="fa-solid fa-arrow-right" />
        </div>
    </div>
</template>

<script>
export default {
    props: ['paginationData'],

    computed: {
        arrayOf3Pages() {
            // On veut toujours avoir 3 éléments affichés max
            // Si possible on met l'actuel au milieu
            // Si l'actuel est obligé d'être à gauche ou à droite, on s'assure qu'il y ait deux éléments de l'autre côté
            const totalPages = Math.ceil(this.paginationData.total / this.paginationData.per_page);

            const firstLink = Math.max(1, this.paginationData.page - 1) < 1 ? 1 : Math.max(1, this.paginationData.page - 1);
            const lastLink = firstLink + 2 > totalPages ? totalPages : firstLink + 2;

            let array = [];
            for (let i = firstLink; i <= lastLink; i++) {
                array.push(i);
            }

            return array;
        }
    }
}
</script>

<style scoped>
.box:last-child {
    border-right: 1px solid rgba(26, 26, 26, 0.2);
}

.box {
    height: 50px;
    width: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-left: 1px solid rgba(26, 26, 26, 0.2);
    border-top: 1px solid rgba(26, 26, 26, 0.2);
    border-bottom: 1px solid rgba(26, 26, 26, 0.2);
    transition: all 200ms ease;
}

.selected {
    border: 1px solid rgb(26, 26, 26) !important;
}
</style>