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
                <div v-html="news.description"></div>
                <router-link :to="{ name: 'modification_edit_news', params: { mod: mod.id, news: news.id } }">
                    Edytuj
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import DisplayTimestamps from '../../DisplayTimestamps';

    export default {
        components: {DisplayTimestamps},
        props: ['news', 'mod'],
    }
</script>
<style>
</style>