<template>
    <div class="container my-2 col-sm-9 mx-auto">
        <div v-if="loading">
            Loading...
        </div>
        <template v-else-if="studios.length > 0">
            <b-col>
                <b-row>
                    <p>Studia, z którymi współpracujesz:</p>
                </b-row>
                <b-row>
                    <b-list-group>
                        <b-list-group-item class="my-1" v-for="studio in studios" :key="studio.id" :to="{name: 'dev_studio_details', params: {id: studio.id}}">
                            <h4 class="mx-auto mt-4">{{studio.name}}</h4>
                        </b-list-group-item>
                    </b-list-group>
                </b-row>
            </b-col>
        </template>
        <template v-else>
            <b-row>
                <p class="mx-auto">Obecnie nie współpracujesz z żadnym ze studiów. Może <b-link :to="{name: 'new_dev_studio'}">utwórz nowy</b-link>?</p>
            </b-row>
        </template>
    </div>
</template>

<script>
    import axios from 'axios';

    const fetch = (callback) => {
        axios.get(`/api/devstudios/my-studios`).then((response) => {
            callback(null, response.data);
        }).catch(error => callback(error, error.response.data));
    };

    export default {
        name: "MyDevelopmentStudios",
        data() {
            return {
                loading: true,
                studios: []
            }
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
                        name: 'home'
                    });
                } else {
                    console.log(data);
                    this.studios = data;
                    this.loading = false;
                }
            },
        }
    }
</script>

<style scoped>

</style>