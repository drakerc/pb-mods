<template>
    <div>
        <b-btn @click="show=true" v-b-modal="'show-instruction-' + instruction.id">Instrukcja {{ instruction.title }}</b-btn>

        <b-modal size="lg" v-model="show" :id="'show-instruction-' + instruction.id" :title="instruction.title">
            <p class="my-4" v-html="instruction.description"></p>
            <div slot="modal-footer" class="w-100">
                <router-link :to="{ name: 'modification_edit_instruction', params: { mod: $route.params['mod'], file: file.id, instruction: instruction.id } }">
                    <b-btn size="sm" variant="warning" @click="print">
                        Edytuj
                    </b-btn>
                </router-link>
                <b-btn size="sm" class="float-right" variant="primary" @click="print">
                    Drukuj
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['file', 'instruction'],

        data() {
            return {
                csrf_token: window.window.csrf_token,
                show: false,
            };
        },
        methods: {
            print: function () {
            }
        },
    }
</script>
