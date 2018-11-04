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
        updated() {
            this.created_at_date = new Date(this.created_at).toLocaleDateString('pl-PL');
            this.updated_at_date = new Date(this.updated_at).toLocaleDateString('pl-PL');
        },
    }
</script>
