<template>
    <div>
        <b-btn @click="show=true" v-b-modal="'delete-video-' + video.id">
            <font-awesome-icon icon="trash" />
            Usuń film
        </b-btn>

        <b-modal v-model="show" :id="'delete-video-' + video.id" title="Usuwanie filmu">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć film {{ video.title }}? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteVideo">
                    Usuń
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['mod', 'video', 'index'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            deleteVideo: function () {
                axios.delete('/api/mods/modifications/' + this.mod.id + '/videos/' + this.video.id + '/delete').then(response => {
                    if (response.data.status === true) {
                        alert('Pomyślnie usunięto film!');
                        this.$emit('delete-file', this.index);
                        this.show = false;
                    } else {
                        alert('Nie udało się usunąć filmu. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
