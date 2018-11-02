<template>
    <div class="pt-1 mt-1 mr-1 pt-1">
        <b-btn block="true" @click="show=true" v-b-modal="'show-instruction-' + instruction.id">
            <font-awesome-icon icon="book" />
            Instrukcja {{ instruction.title }}</b-btn>

        <b-modal size="lg" v-model="show" :id="'show-instruction-' + instruction.id" :title="'Instrukcja ' + instruction.title">
            <h3>Autor: {{ instruction.creatorName }}</h3>
            <p class="my-4" v-html="instruction.description"></p>
            <div slot="modal-footer" class="w-100">
                <router-link :to="{ name: 'modification_edit_instruction', params: { mod: $route.params['mod'], file: file.id, instruction: instruction.id } }">
                    <b-btn v-if="canManageMod" size="sm" variant="warning" @click="print">
                        Edytuj
                    </b-btn>
                </router-link>
                <b-btn size="sm" class="float-right" :href="$route.params['mod'] + '/files/' + file.id + '/instruction/' + instruction.id + '/print'" variant="primary" @click="print">
                    Drukuj
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>
<script>
    export default {
        props: ['file', 'instruction', 'canManageMod'],

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
