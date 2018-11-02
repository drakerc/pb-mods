<template>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <div class="text-center">
                <router-link :to="{ name: 'mods_category', params: { game: gameid, category: category.id } }">
                    <img class="card-img-top" :src="categoryThumbnail">
                </router-link>
            </div>

            <div class="card-body">
                <router-link :to="{ name: 'mods_category', params: { game: gameid, category: category.id } }">
                    <h5 class="card-title">{{ category.title }}</h5>
                </router-link>
                <p class="card-text">{{ category.description | truncate(100) }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">{{
                            category.deepSubcategoriesCount }} podkategorii
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">{{
                            category.deepModificationsCount}} modyfikacji
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['category', 'gameid'],
        computed: {
            categoryThumbnail() {
                return this.category.thumbnail
            },
        }
    }
</script>
<style>
    .card-img-top {
        width: 200px;
        height: 200px;
        text-align: center;
    }
</style>