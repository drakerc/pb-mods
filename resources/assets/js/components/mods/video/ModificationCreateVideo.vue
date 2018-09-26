<template>
    <div>
        <div class="form-group">
            <label :for="'videos[' + index + '][title]'">Tytuł - jeśli nie zostanie wypełniony, zostanie uzupełniony tytułem filmiku z Youtube</label>
            <input :id="'videos[' + index + '][title]'" type="text" :name="'videos[' + index + '][title]'" class="form-control"
                   placeholder="Tytuł" v-model="title" autofocus>
        </div>

        <div class="form-group">
            <label :for="'videos[' + index + '][url]'">Link do YouTube</label>
            <input type="text" :id="'videos[' + index + '][url]'" :name="'videos[' + index + '][url]'" class="form-control" v-model="url">
        </div>

        <div v-if="edit === true" class="form-group">
            <div class="radio-inline">
                <label><input type="radio" :name="'videos[' + index + '][availability]'" value="1" :checked="video.availability === 1">Dostępny</label>
            </div>
            <div class="radio-inline">
                <label><input type="radio" :name="'videos[' + index + '][availability]'" value="0" :checked="video.availability === 0">Niedostępny</label>
            </div>
        </div>

    </div>
</template>
<script>

    export default {
        props: ['index', 'video', 'edit'],
        beforeMount: function () {
            if (this.video !== undefined) {
                this.title = this.video.title;
                this.url = this.video.url;
            }
        },

        data() {
            return {
                title: '',
                url: '',
            };
        },
    }
</script>
