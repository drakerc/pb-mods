<template>
    <div v-if="rating.id !== undefined" class="dark-jumbotron jumbotron container">
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
                <div>Ocena ogólna: <b>{{ rating.rating }}</b></div>
                <div>Ocena użyteczności: <b>{{ rating.rating_usability }}</b></div>
                <div>Ocena rozrywki: <b>{{ rating.rating_fun }}</b></div>
                <!--<div>Ocena jakości: <b>{{ rating.quality }}</b></div>-->
                <display-timestamps :created_at="rating.created_at" :updated_at="rating.updated_at">
                </display-timestamps>
            </div>
        </div>
        <hr class="mb-4">
    </div>
</template>
<script>
    import DisplayTotalRating from "./DisplayTotalRating";
    import DisplayTimestamps from '../../DisplayTimestamps';
    import { Auth } from "../../../auth";

    export default {
        components: {DisplayTotalRating, DisplayTimestamps},
        props: ['rating', 'mod'],
        data() {
            return {
                userId: Auth.getId(),
            }
        },
    }
</script>
<style>
    .dark-jumbotron {
        color: #e3e3e3;
        background-color: #464646;
    }
</style>