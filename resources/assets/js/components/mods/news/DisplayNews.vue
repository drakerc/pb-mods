<template>
    <div v-if="news.id !== undefined" class="col-md-10 bg-light">
        <div class="row">
            <div class="col-md-8">
                <h1 class="font-italic">{{ news.title }}</h1>
                <h4>Autor: {{ news.author_id }}</h4>
            </div>
            <div class="col-md-4">
                <display-timestamps :created_at="news.created_at" :updated_at="news.updated_at">
                </display-timestamps>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <router-link :to="{ name: 'modification_edit_news', params: { mod: mod.id, news: news.id } }">
                        <b-btn>Edytuj</b-btn>
                    </router-link>
                    <delete-news :news="news"></delete-news>
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
        props: ['news', 'mod'],
    }
</script>
<style>
</style>