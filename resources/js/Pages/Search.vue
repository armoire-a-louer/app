<template>
    <Layout>
        <div class="container mx-auto mb-10 navbar-margin">
            <div class="flex md:hidden h-12 text-center items-center">
                <div class="flex-1">
                    <font-awesome-icon icon="fa-solid fa-sliders" />
                    Filtres
                </div>
                <div class="flex-1">
                    Trier par
                </div>
            </div>

            <div class="flex gap-14">
                <section class="w-80 hidden md:block">
                    <h2 class="font-serif text-2xl mb-10">Filtres</h2>

                    <hr>

                    <FilterGroup name="Type de produit">
                        <div class="flex gap-3 items-center" v-for="category in categories" :key="category.id">
                            <input class="checkbox" :id="'category' + category.id" type="checkbox" :value="category.id" :checked="filters.selectedCategories.includes(
                                category.id)" v-model="filters.selectedCategories">
                            <label :for="'category' + category.id">
                                {{ category.name }}
                            </label>
                        </div>
                    </FilterGroup>

                    <hr>

                    <FilterGroup name="Couleur">
                        <div class="flex gap-3 items-center" v-for="color in colors" :key="color.id">
                            <input class="checkbox" :id="'color' + color.id" type="checkbox" :value="color.id" :checked="filters.selectedColors.includes(
                                color.id)" v-model="filters.selectedColors">
                            <label :for="'color' + color.id">
                                {{ color.name }}
                            </label>
                        </div>
                    </FilterGroup>

                    <hr>

                    <FilterGroup name="Sexe">
                        <div class="flex gap-3 items-center" v-for="sex in sexes" :key="sex">
                            <input class="checkbox" :id="'sex' + sex" type="checkbox" :value="sex" :checked="filters.selectedSexes.includes(
                                sex)" v-model="filters.selectedSexes">
                            <label :for="'sex' + sex">
                                {{ sex }}
                            </label>
                        </div>
                    </FilterGroup>

                    <hr>

                    <FilterGroup name="Marques" :close="filters.selectedBrands.length === 0">
                        <div class="flex gap-3 items-center" v-for="brand in brands" :key="brand.id">
                            <input class="checkbox" :id="'brand' + brand.id" type="checkbox" :value="brand.id" :checked="filters.selectedBrands.includes(
                                brand.id)" v-model="filters.selectedBrands">
                            <label :for="'brand' + brand.id">
                                {{ brand.name }}
                            </label>
                        </div>
                    </FilterGroup>

                    <hr>
                </section>

                <div class="flex-1">
                    <div class="justify-between items-center hidden md:flex">
                        <span>
                            {{ products.total }} produit{{ products.total > 1 ? 's' : '' }}
                        </span>
                        <div>
                            <span class="font-bold">
                                Trier par
                                <select class="select" v-model="selectedSort">
                                    <option :selected="selectedSort == sort.value" v-for="sort in sorts" :key="sort.name" :value="sort.value">
                                        {{ sort.name }}
                                    </option>
                                </select>
                            </span>
                        </div>
                    </div>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-x-4 gap-y-14">
                        <ProductCard v-for="product in products.data" :key="product.id" :product="product"/>
                    </div>

                    <div class="flex justify-center mt-16">
                        <Pagination :paginationData="paginationData" @setPage="page = $event"/>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/Layout.vue'
import { Inertia } from '@inertiajs/inertia'
import FilterGroup from '@/Components/Search/FilterGroup.vue'
import ProductCard from '@/Components/ProductCard.vue'
import Pagination from '@/Components/Search/Pagination.vue'

export default {
    name: 'Search',

    props: ['products', 'categories', 'sexes', 'colors', 'brands'],

    data() {
        return {
            filters: {
                selectedCategories: this.$page.props.queryParams.categories ? this.$page.props.queryParams.categories : [],
                selectedSexes: this.$page.props.queryParams.sexes ? this.$page.props.queryParams.sexes : [],
                selectedColors: this.$page.props.queryParams.colors ? this.$page.props.queryParams.colors : [],
                selectedBrands: this.$page.props.queryParams.brands ? this.$page.props.queryParams.brands : [],
            },
            page: this.products.current_page,
            sorts: [
                {
                    name: "Nouveautés",
                    value: 0
                },
                {
                    name: "Prix croissant",
                    value: "price_per_day,asc"
                },
                {
                    name: "Prix décroissant",
                    value: "price_per_day,desc"
                }
            ],
            selectedSort: this.$page.props.queryParams.sort ? this.$page.props.queryParams.sort : 0,
            search: this.$page.props.queryParams.search ? this.$page.props.queryParams.search : ""
        }
    },

    watch: {
        filters: {
            handler(newValue, oldValue) {
                this.reload();
            },
            deep: true
        },
        page: {
            handler(newValue, oldValue) {
                this.reload();
            }
        },
        selectedSort: {
            handler(newValue, oldValue) {
                this.reload();
            }
        }
    },
    
    components: {
        Layout,
        FilterGroup,
        ProductCard,
        Pagination,
    },

    methods: {
        reload() {
            const data = {
                categories: this.filters.selectedCategories,
                sexes: this.filters.selectedSexes,
                colors: this.filters.selectedColors,
                brands: this.filters.selectedBrands,
                page: this.page,
                sort: this.selectedSort,
                search: this.search
            }

            const options = {
                method: 'get',
                data: data,
                preserveScroll: false,
                onSuccess: page => {

                },
            }

            Inertia.visit(route('search'), options);
        }
    },

    computed: {
        paginationData() {
            return {
                page: this.products.current_page,
                total: this.products.total,
                per_page: this.products.per_page,
                first_page_url: this.products.first_page_url,
                last_page_url: this.products.last_page_url,
                prev_page_url: this.products.prev_page_url,
                next_page_url: this.products.next_page_url
            };
        }
    },
}
</script>

<style scoped>
.checkbox {
    border: 2px solid black;
    box-shadow: rgba(0, 0, 0, 0.56) 0px 22px 70px 4px;
    height: 14px;
    width: 14px;
}

.checkbox:checked {
    background-color: black;
}

.select {
    border: none;
    font-weight: 400;
}

.navbar-margin {
    margin-top: 160px;
}

@media screen and (max-width: 767px) {
    .navbar-margin {
        margin-top: 120px;
    }
}
</style>