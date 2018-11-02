<template>
    <div>
        <b-btn @click="show=true" v-b-modal="'delete-instruction-' + instruction.id">
            <font-awesome-icon icon="trash" />
            Usuń instrukcję
        </b-btn>

        <b-modal v-model="show" :id="'delete-instruction-' + instruction.id" title="Usuwanie instrukcji">
            <p class="my-4">Czy jesteś pewien, że chcesz usunąć instrukcję {{ instruction.title }}? Jest to proces nieodwracalny!</p>
            <div slot="modal-footer" class="w-100">
                <b-btn size="sm" class="float-right" variant="secondary" @click="show=false">
                    Anuluj
                </b-btn>
                <b-btn size="sm" class="float-right" variant="primary" @click="deleteInstruction">
                    Usuń
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['modId', 'fileId', 'instruction'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            deleteInstruction: function () {
                axios.delete('/api/mods/modifications/' + this.modId + '/files/' + this.fileId + '/edit-instruction/' + this.instruction.id + '/delete').then(response => {
                    if (response.data.status === true) {
                        alert('Pomyślnie usunięto instrukcję!');
                        this.$router.push({ name: 'modification_view', params: { mod: this.modId } });
                        this.show = false;
                    } else {
                        alert('Nie udało się usunąć pliku. Może nie masz uprawnień?')
                    }
                });
            }
        },
    }
</script>
