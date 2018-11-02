<template>
    <div>
        <b-btn variant="warning" @click="show=true" v-b-modal="'delete-rating'">
            <font-awesome-icon icon="trash" />
            Usuń ocenę
        </b-btn>

        <b-modal v-model="show" :id="'delete-rating'" title="Usuwanie oceny">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć ocenę? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteRating">
                    Usuń
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['mod', 'rating'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            deleteRating: function () {
                axios.delete('/api/mods/modifications/' + this.mod.id + '/ratings/' + this.rating + '/delete').then(response => {
                    if (response.data.status === true) {
                        alert('Pomyślnie usunięto ocenę!');
                        this.$router.push({name: 'modification_view', params: {mod: this.mod.id}});
                    } else {
                        alert('Nie udało się usunąć modyfikacji. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
