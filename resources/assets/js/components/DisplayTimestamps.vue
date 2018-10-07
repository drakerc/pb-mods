<template>
    <div>
        <p v-if="created_at">
            Stworzono dnia: {{ created_at }}
        </p>
        <p v-if="created_at !== updated_at">
            Zaktualizowano dnia: {{ updated_at }}
        </p>
    </div>
</template>

<script>
    export default {
        props: ['created_at', 'updated_at']
    }
</script>
