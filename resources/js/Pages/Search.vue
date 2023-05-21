<template>
    <Layout>
        <div class="container mx-auto mt-40 mb-10">
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
                    <div class="flex justify-between items-center">
                        <span>
                            {{ products.total }} produit{{ products.total > 1 ? 's' : '' }}
                        </span>
                        <div>
                            <span class="font-bold">Trier par</span>
                        </div>
                    </div>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-x-4 gap-y-14">
                        <ProductCard v-for="product in products.data" :key="product.id" :product="product"/>
                    </div>

                    <div class="flex justify-center">
                        <Pagination :paginationData="paginationData"/>
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
            }
        }
    },

    watch: {
        filters: {
            handler(newValue, oldValue) {
                this.reload();
            },
            deep: true
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
                page: this.products.current_page
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
</style>