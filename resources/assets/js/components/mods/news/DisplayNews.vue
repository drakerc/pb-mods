<template>
    <div v-if="news.id !== undefined" class="jumbotron container dark-jumbotron">
        <div class="row">
            <div class="col-md-8">
                <h1 class="font-italic">{{ news.title }}</h1>
                <h4>Autor: {{ news.creatorName  }}</h4>
            </div>
            <div class="col-md-4">
                <display-timestamps :created_at="news.created_at" :updated_at="news.updated_at">
                </display-timestamps>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group" v-if="canManageMod">
                    <router-link :to="{ name: 'modification_edit_news', params: { mod: mod.id, news: news.id } }">
                        <b-btn>
                            <font-awesome-icon icon="edit" />
                            Edytuj
                        </b-btn>
                    </router-link>
                    <delete-news :news="news" :mod="mod"></delete-news>
                </div>
                <div v-html="news.description"></div>
            </div>
        </div>
        <hr class="mb-4">
    </div>
</template>
<script>
    import DisplayTimestamps from '../../DisplayTimestamps';
    import DeleteNews from './DeleteNews';

    export default {
        components: {DeleteNews, DisplayTimestamps},
        props: ['news', 'mod', 'canManageMod'],
    }
</script>
<style>
    .dark-jumbotron {
        color: #e3e3e3;
        background-color: #464646;
    }
</style>