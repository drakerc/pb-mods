<template>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <router-link :to="{ name: 'mods_category', params: { game: gameid, category: category.id } }">
                <div class="card-img-top" :style="backgroundImageStyle">{{ category.title }}</div>
                <div class="card-body">
                    <p class="card-text">{{ category.description | truncate(100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{ category.deepSubcategoriesCount }} podkategorii</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">{{ category.deepModificationsCount}} modyfikacji</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                    </div>
                </div>
            </router-link>
        </div>
    </div>
</template>
<script>
    export default {
        props: [ 'category', 'gameid' ],
        computed: {
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.category.thumbnail}")`
                }
            }
        }
    }
</script>
<style>
    .card-img-top {
        width: 150px;
        height: 150px;
        text-align: center;
    }
</style>