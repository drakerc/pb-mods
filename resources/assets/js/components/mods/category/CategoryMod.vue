<template>
    <div :id="'mod-card-' + mod.id" class="col-md-4">
        <div class="card mod-card mb-4 box-shadow">
            <div class="text-center">
                <router-link :to="{ name: 'modification_view', params: { mod: mod.id } }">
                    <img class="card-img-top" :src="modThumbnail">
                </router-link>
            </div>

            <div class="card-body d-flex flex-column">
                <router-link :to="{ name: 'modification_view', params: { mod: mod.id } }">
                    <h5 class="card-title">{{ mod.title }}</h5>
                </router-link>
                <b><p class="card-text main-info" v-html="$options.filters.truncate(mod.description, 150)"></p></b>
                <div class="mt-auto ">
                    <p class="secondary-info">
                        <b>Autor:</b> {{ mod.creatorName }}
                    </p>
                    <p class="secondary-info" v-if="mod.devStudio">
                        <b>Studio deweloperskie:</b> {{ mod.devStudio.name }}
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            <font-awesome-icon icon="download" />
                            {{ mod.downloadsCount }} <b>pobrań</b>
                        </div>
                        <div class="col-md-6">
                            <font-awesome-icon icon="code-branch" />
                            <b>Wersja:</b> {{ mod.version }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9" v-if="mod.release_date">
                            <font-awesome-icon icon="clock" />
                            <b>Wydano:</b> {{ mod.release_date }}
                        </div>
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

    .mod-card {
        min-height: 500px;
    }

    .main-info {
        font-size: 11pt;
    }

    .secondary-info {
        font-size: 9pt !important;
    }
</style>