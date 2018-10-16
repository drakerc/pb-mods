<template>
    <div>
        <b-btn @click="show=true" v-b-modal="'delete-news'">Usuń newsa</b-btn>

        <b-modal v-model="show" :id="'delete-news" title="Usuwanie newsa">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć newsa {{ news.title}}? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteNews">
                    Usuń
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['mod', 'news'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            deleteNews: function () {
                axios.delete('/api/mods/modifications/' + this.mod.id + '/news/' + this.news.id + '/delete').then(response => {
                    if (response.data.status === true) {
                        alert('Pomyślnie usunięto newsa!');
                        this.$router.push({ name: 'modification_view', params: { mod: this.mod.id } });
                        this.show = false;
                    } else {
                        alert('Nie udało się usunąć pliku. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
