<template>
    <b-alert variant="danger" show class="col-sm-6">
        <ul class="mx-auto">
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