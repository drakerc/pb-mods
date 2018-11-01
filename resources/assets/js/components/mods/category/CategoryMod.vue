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
                <b><p class="card-text" v-html="$options.filters.truncate(mod.description, 150)"></p></b>
                <p class="card-text secondary-info">
                    <b>Data wydania:</b> {{ mod.release_date }}
                </p>
                <p class="card-text secondary-info">
                    <b>Autor:</b> {{ mod.creatorName }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <font-awesome-icon icon="download" />
                            {{ mod.downloadsCount }} <b>pobrań</b>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <font-awesome-icon icon="code-branch" />
                            <b>Wersja:</b> {{ mod.version }}
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
    .card-img-top {
        height: 185px;
        width: 100%
    }

    .secondary-info {
        font-size: 9pt;
    }
</style>