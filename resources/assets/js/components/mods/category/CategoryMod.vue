<template>
    <div class="col-md-4">
        <div class="card mb-4 box-shadow">
            <div class="text-center">
                <router-link :to="{ name: 'modification_view', params: { mod: mod.id } }">
                    <img class="card-img-top" :src="modThumbnail">
                </router-link>
            </div>

            <div class="card-body">
                <router-link :to="{ name: 'modification_view', params: { mod: mod.id } }">
                    <h5 class="card-title">{{ mod.title }}</h5>
                </router-link>
                <p class="card-text">
                    Data wydania: {{ mod.release_date }}
                </p>
                <p class="card-text">
                    Autor: {{ mod.creator }}
                </p>
                <p class="card-text" v-html="$options.filters.truncate(mod.description, 200)"></p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            {{ mod.downloadsCount }} pobrań
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            Wersja: {{ mod.version }}
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['mod'],
        computed: {
            modThumbnail() {
                return this.mod.thumbnail
            },
        }
    }
</script>
<style>
</style>