<template>
    <div>
        <ol class="list-unstyled">
            <router-link :to="{ name: 'modification_create_files', params: { mod: mod.id } }">
                <li>Dodaj plik/i</li>
            </router-link>

            <router-link :to="{ name: 'modification_create_images', params: { mod: mod.id } }">
                <li>Dodaj galerię zdjęć</li>
            </router-link>

            <router-link :to="{ name: 'modification_create_videos', params: { mod: mod.id } }">
                <li>Dodaj filmiki</li>
            </router-link>

            <router-link :to="{ name: 'modification_edit_background_images', params: { mod: mod.id } }">
                <li>Dodaj/edytuj tło</li>
            </router-link>

            <router-link :to="{ name: 'modification_edit_splash_images', params: { mod: mod.id } }">
                <li>Dodaj/edytuj splasha</li>
            </router-link>

            <router-link :to="{ name: 'modification_create_news', params: { mod: mod.id } }">
                <li>Dodaj newsa</li>
            </router-link>

            <hr>

            <router-link :to="{ name: 'modification_update', params: { mod: mod.id } }">
                <li>Edytuj tą modyfikację</li>
            </router-link>

            <router-link v-if="files_added" :to="{ name: 'modification_edit_files', params: { mod: mod.id } }">
                <li>Edytuj pliki</li>
            </router-link>

            <router-link v-if="images_added" :to="{ name: 'modification_edit_images', params: { mod: mod.id } }">
                <li>Edytuj obrazki</li>
            </router-link>

            <router-link v-if="videos_added" :to="{ name: 'modification_edit_videos', params: { mod: mod.id } }">
                <li>Edytuj filmiki</li>
            </router-link>
        </ol>
    </div>
</template>

<script>
    export default {
        props: ['mod'],
        mounted() {
            this.$emit('complete-loading');
        },
        data() {
            return {
                files_added: true,
                images_added: true,
                videos_added: true // TODO: add fetching the amounts of these things from api
            }
        },
    }
</script>
