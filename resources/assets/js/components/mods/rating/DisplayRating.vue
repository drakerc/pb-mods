<template>
    <div v-if="rating.id !== undefined" class="col-md-10 bg-light">
        <div class="row">
            <div class="col-md-8">
                <h1 class="font-italic">{{ rating.title }}</h1>
                <h4>Autor: {{ rating.creatorName }}</h4>
            </div>
            <div class="col-md-4">
                <display-total-rating :rating="rating.rating"></display-total-rating>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div v-html="rating.description"></div>
                <router-link v-if="userId === rating.author_id" :to="{ name: 'modification_edit_rating', params: { mod: $route.params['mod'], rating: rating.id } }">
                    Edytuj
                </router-link>
            </div>
            <div class="col-md-4">
                <div>Ocena ogólna: {{ rating.rating }}</div>
                <div>Ocena użyteczności: {{ rating.rating_usability }}</div>
                <div>Ocena rozrywki: {{ rating.rating_fun }}</div>
                <div>Ocena jakości: {{ rating.quality }}</div>
            </div>
        </div>
        <hr class="mb-4">
    </div>
</template>
<script>
    import DisplayTotalRating from "./DisplayTotalRating";

    export default {
        components: {DisplayTotalRating},
        props: ['rating', 'mod'],
        data() {
            return {
                userId: window.window.user_id,
            }
        },
    }
</script>
<style>
</style>