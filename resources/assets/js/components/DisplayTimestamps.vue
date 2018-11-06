<template>
    <div>
        <p v-if="created_at">
            Stworzono dnia: <b>{{ created_at_date }}</b>
        </p>
        <p v-if="created_at !== updated_at">
            Zaktualizowano dnia: <b>{{ updated_at_date }}</b>
        </p>
    </div>
</template>

<script>
    export default {
        props: ['created_at', 'updated_at'],
        data() {
            return {
                created_at_date: '',
                updated_at_date: '',
            }
        },
        watch: {
            created_at: function (value) {
                if (value !== undefined) {
                    this.created_at_date = new Date(this.created_at).toLocaleDateString('pl-PL');
                }
            },
            updated_at: function (value) {
                if (value !== undefined) {
                    this.updated_at_date = new Date(this.updated_at).toLocaleDateString('pl-PL');
                }
            },
        },
        mounted() {
            if (this.created_at !== undefined && this.created_at !== null) {
                this.created_at_date = new Date(this.created_at).toLocaleDateString('pl-PL');
            } else {
                this.created_at_date = 'Nieznana';
            }
            if (this.updated_at !== undefined && this.updated_at !== null) {
                this.updated_at_date = new Date(this.updated_at).toLocaleDateString('pl-PL');
            } else {
                this.updated_at_date = 'Nieznana';
            }
        },
    }
</script>
