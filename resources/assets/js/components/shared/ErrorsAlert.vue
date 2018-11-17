<template>
    <b-alert variant="danger" show>
        <ul>
            <li v-for="(error, index) in errors" :key="index">
                {{error}}
            </li>
        </ul>
    </b-alert>
</template>

<script>
    export default {
        name: "ErrorsAlert",
        props: ['errors']
    }
</script>

<style scoped>

</style>