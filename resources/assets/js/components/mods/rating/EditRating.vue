<template>
    <form enctype="multipart/form-data" role="form" method="POST" :action="'/mods/modifications/' + mod.id + '/ratings/' + rating.id + '/edit'">
        <input type="hidden" name="_token" :value="csrf_token">
        <input type="hidden" name="modId" :value="mod.id">

        <h3>Edytujesz ocenę modyfikację {{ mod.title }}</h3>
        <p>Prosimy o stworzenie rzetelnej, sumiennej oceny. Twoja recenzja będzie czytana przez innych użytkowników i będzie mieć wpływ na ich wybór przy pobieraniu modyfikacji.</p>

        <div class="form-group">
            <label for="title">Tytuł</label>
            <input id="title" type="text" name="title" class="form-control"
                   placeholder="Tytuł" v-model="title" required autofocus>
        </div>

        <div class="form-group">
            <input type="hidden" name="description" :value="description">
            <label for="description">Opis</label>
            <vue-editor id="description" v-model="description"></vue-editor>
        </div>

        <div class="form-group">
            <input type="hidden" name="rating" :value="rating.value">
            <label for="rating">Ocena ogólna</label>
            <multiselect id="rating" class="form-control" track-by="value" label="label" v-model="rating" :options="rating_options"></multiselect>
        </div>

        <div class="form-group">
            <input type="hidden" name="rating_usability" :value="rating_usability.value">
            <label for="rating_usability">Ocena użyteczności</label>
            <multiselect id="rating_usability" class="form-control" track-by="value" label="label" v-model="rating_usability" :options="rating_usability_options"></multiselect>
        </div>

        <div class="form-group">
            <input type="hidden" name="rating_fun" :value="rating_fun.value">
            <label for="rating_fun">Ocena rozrywki</label>
            <multiselect id="rating_fun" class="form-control" track-by="value" label="label" v-model="rating_fun" :options="rating_fun_options"></multiselect>
        </div>

        <div class="form-group">
            <input type="hidden" name="rating_quality" :value="rating_quality.value">
            <label for="rating_quality">Ocena jakości</label>
            <multiselect id="rating_quality" class="form-control" track-by="value" label="label" v-model="rating_quality" :options="rating_quality_options"></multiselect>
        </div>

        <div class="form-control">
            <delete-rating :rating="id" :mod="mod"></delete-rating>
            <b-button size="lg" variant="primary" type="submit">
                <font-awesome-icon icon="save" />
                Wyślij
            </b-button>
        </div>
    </form>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import { VueEditor } from 'vue2-editor'
    import Multiselect from 'vue-multiselect'
    import DeleteRating from './DeleteRating';

    export default {
        mixins: [ routeMixin ],
        components: {
            VueEditor,
            Multiselect,
            DeleteRating
        },
        data() {
            return {
                id: '',
                title: '',
                rating: '',
                description: '',
                rating_usability: '',
                rating_fun: '',
                rating_quality: '',
                csrf_token: window.window.csrf_token,
                mod: '',
                auth: '',
                rating_options: [{label: '1/5', value: 1}, {label: '2/5', value: 2}, {label: '3/5', value: 3}, {label: '4/5', value: 4}, {label: '5/5', value: 5}],
                rating_usability_options: [{label: 'Nieużyteczna', value: 1}, {label: 'Ledwie użyteczna', value: 2}, {label: 'Użyteczna', value: 3}, {label: 'Mocno użyteczna', value: 4}, {label: 'Bardzo użyteczna', value: 5}],
                rating_fun_options: [{label: 'Okropna', value: 1}, {label: 'Kiepska', value: 2}, {label: 'Średnia', value: 3}, {label: 'Dobra', value: 4}, {label: 'Bardzo dobra', value: 5}],
                rating_quality_options: [{label: 'Okropna', value: 1}, {label: 'Kiepska', value: 2}, {label: 'Średnia', value: 3}, {label: 'Dobra', value: 4}, {label: 'Wyjątkowa', value: 5}],
            };
        },
        methods: {
            assignData({mod, rating, auth}) {
                this.mod = mod;
                this.$emit('set-mod-link', this.mod.game_id, this.mod.category_id, this.mod.id);
                this.auth = auth;
                this.title = rating.title;
                this.description = rating.description;
                this.id = rating.id;

                this.rating = this.rating_options.find(obj => {
                    return obj.value === rating.rating;
                });
                this.rating_fun = this.rating_fun_options.find(obj => {
                    return obj.value === rating.rating_fun;
                });
                this.rating_quality = this.rating_quality_options.find(obj => {
                    return obj.value === rating.rating_quality;
                });
                this.rating_usability = this.rating_usability.find(obj => {
                    return obj.value === rating.rating_usability;
                });
            },
        },
    }
</script>
<style>
</style>