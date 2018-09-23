<template>
    <div>
        <b-btn @click="show=true" v-b-modal="'delete-file-' + file.id">Usuń plik</b-btn>

        <b-modal v-model="show" :id="'delete-file-' + file.id" title="Usuwanie modyfikacji">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć plik {{ file.file_path }} {{ file.pivot.title }}? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteFile">
                    Usuń
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['mod', 'file', 'index'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            deleteFile: function () {
                axios.delete('/api/mods/modifications/' + this.mod.id + '/files/' + this.file.id + '/delete').then(response => {
                    if (response.data.status === true) {
                        alert('Pomyślnie usunięto plik!');
                        this.$emit('delete-file', this.index);
                        this.show = false;
                    } else {
                        alert('Nie udało się usunąć modyfikacji. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
