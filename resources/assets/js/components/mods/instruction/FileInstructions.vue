<template>
    <div class="row">
        <instruction v-for="instruction in instructions" :key="instructions.id" :instruction="instruction" :file="file"></instruction>

        <div v-if="instructions.length > 0">
            <a :href="$route.params['mod'] + '/files/' + file.id + '/download-with-instructions'" class="btn btn-lg btn-outline-primary">
                Pobierz plik wraz z instrukcjami
            </a>
        </div>
    </div>
</template>
<script>
    import routeMixin from '../../../route-mixin.js';
    import Instruction from "./Instruction";

    export default {
        mixins: [ routeMixin ],
        props: ['passedModId', 'passedFile'],
        data() {
            return {
                instructions: '',
                file: '',
                mod: '',
                auth: '',
            }
        },
        mounted() {
            if (this.instructions.length === 0) {
                this.file = this.passedFile;
                axios.get('/api/mods/modifications/' + this.passedModId + '/files/' + this.file.id + '/instructions').then(({data}) => {
                    this.instructions= data['instructions'];
                });
            }
        },
        components: {
            Instruction,
        },
        methods: {
            assignData({instructions, auth, mod, file}) {
                this.instructions = instructions;
                this.auth = auth;
                this.mod = mod;
                this.file = file;
            },
        },
    }
</script>
<style>
</style>