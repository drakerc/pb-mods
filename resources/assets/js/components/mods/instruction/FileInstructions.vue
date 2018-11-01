<template>
    <div>
        <instruction v-for="instruction in instructions" :key="instructions.id" :instruction="instruction" :file="file"></instruction>
        <div class="pt-1 mt-1" v-if="instructions.length > 0">
            <a v-if="instructions.length > 0" :href="$route.params['mod'] + '/files/' + file.id + '/download-with-instructions'" class="btn btn-block btn-warning">
                <font-awesome-icon icon="file-download" />
                Pobierz plik z instrukcjami
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