<template>
    <div>
        <b-modal size="lg" ok-only="true" v-model="show" id="preview-mod" title="Podgląd strony" v-if="mod.id !== undefined" >
            <modification-details v-if="mod.id !== undefined" :modPassed="mod"></modification-details>
        </b-modal>

        <b-btn size="lg" variant="success" v-b-modal.preview-mod>
            <font-awesome-icon icon="search" />
            Podejrzyj stronę modyfikacji
        </b-btn>
    </div>
</template>
<script>
    import ModificationDetails from './ModificationDetails';

    export default {
        components: {
            ModificationDetails,
        },
        props: [
            'font_color',
            'font_color_splash_text',
            'color_splash_background',
            'transparency_splash_background',
            'font_color_description',
            'color_description_background',
            'transparency_description_background',
            'mod'
        ],
        data() {
            return {
                show: false,
            };
        },
        watch: {
            font_color: function () {
                this.setData();
            },
            font_color_splash_text: function () {
                this.setData();
            },
            color_splash_background: function () {
                this.setData();
            },
            transparency_splash_background: function () {
                this.setData();
            },
            font_color_description: function () {
                this.setData();
            },
            color_description_background: function () {
                this.setData();
            },
            transparency_description_background: function () {
                this.setData();
            },
        },
        methods: {
            setData() {
                this.mod.font_color = this.font_color;
                this.mod.font_color_splash_text = this.font_color_splash_text;
                this.mod.color_splash_background = this.color_splash_background;
                this.mod.transparency_splash_background = this.transparency_splash_background;
                this.mod.font_color_description = this.font_color_description;
                this.mod.color_description_background = this.color_description_background;
                this.mod.transparency_description_background = this.transparency_description_background;
            }
        },
    }
</script>
<style>
    .modal-lg {
        max-width: 1600px !important;
    }
</style>