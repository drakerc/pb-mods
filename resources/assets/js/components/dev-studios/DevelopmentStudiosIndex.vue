<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <p>Studia deweloperskie:</p>
        <template v-if="studios">
            <b-card v-for="studio in studios.data" :key="studio.id" class="my-2 small">
                <b-link slot="header" :to="{name: 'dev_studio_details', params:{id: studio.id}}">{{studio.name}}</b-link>
                <!--<b-link class="h3" :to="`/game/${game.id}`"></b-link>-->
                <truncate clamp="Show more" :length="50" less="Show Less" type="html" :text="studio.description" action-class="text-primary"/>
            </b-card>
            <paginate :data="studios" @pagination-change-page="getResults"></paginate>
        </template>
        <template v-else>
            <h2>Brak studiów deweloperskich w bazie.</h2>
        </template>
    </div>
</template>

<script>
    import axios from 'axios';
    import paginate from 'laravel-vue-pagination';
    import truncate from 'vue-truncate-collapsed';

    const fetch = (callback) => {
        axios.get(`/api/devstudios`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "DevelopmentStudiosIndex",
        data() {
            return {
                studios: null
            }
        },
        components: {
            paginate,
            truncate
        },
        beforeRouteEnter(to, from, next) {
            fetch((err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        methods: {
            setData(err, data) {
                if (err) {
                    console.error(err);
                    this.$router.push({
                        name: 'game_index'
                    });
                } else {
                    console.log(data);
                    this.studios = data.studios;
                }
            },

            getResults(page) {
                axios.get(`/api/devstudios`, {
                    params: {
                        page
                    }
                })
                    .then(response => this.studios = response.data.studios)
                    .catch(err => console.error(err));
            }
        },
    }
</script>

<style scoped>

</style>