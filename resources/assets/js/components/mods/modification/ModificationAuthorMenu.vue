<template>
    <div>
        <router-link :to="{ name: 'modification_create_files', params: { mod: mod.id } }">
            Dodaj plik/i
        </router-link>

        <router-link :to="{ name: 'modification_create_images', params: { mod: mod.id } }">
            Dodaj galerię zdjęć
        </router-link>

        <router-link :to="{ name: 'modification_create_videos', params: { mod: mod.id } }">
            Dodaj filmiki
        </router-link>

        <router-link :to="{ name: 'modification_update', params: { mod: mod.id } }">
            Edytuj tą modyfikację
        </router-link>

        <span v-if="files_added">
            <router-link :to="{ name: 'modification_edit_files', params: { mod: mod.id } }">
                Edytuj pliki
            </router-link>
        </span>

        <span v-if="images_added">
            <router-link :to="{ name: 'modification_edit_images', params: { mod: mod.id } }">
                Edytuj obrazki
            </router-link>
        </span>

        <span v-if="videos_added">
            <router-link :to="{ name: 'modification_edit_videos', params: { mod: mod.id } }">
                Edytuj filmiki
            </router-link>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['mod'],
        data() {
            return {
                files_added: true,
                images_added: true,
                videos_added: true // TODO: add fetching the amounts of these things from api
            }
        },
    }
</script>