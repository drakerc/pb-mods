<template>
    <div>
        <b-navbar toggleable="md" type="dark" variant="info">
            <b-navbar-nav>
                <b-nav-item to="/game" exact>Games</b-nav-item>
            </b-navbar-nav>
        </b-navbar>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "GameMain"
    }
</script>

<style scoped>

</style>