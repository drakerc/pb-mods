<template>
    <div>
        <b-navbar toggleable="md" type="dark" variant="info">
            <b-navbar-nav>
                <b-nav-item to="/game" exact>Games</b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-form @submit.prevent="onSubmit">
                    <b-form-input size="sm" class="mr-sm-2" type="text" placeholder="Search" v-model="phrase"/>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit" :disabled="phrase.length===0">Search</b-button>
                </b-nav-form>
            </b-navbar-nav>
        </b-navbar>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "GameMain",
        data() {
            return {
                phrase: ""
            }
        },
        methods: {
            onSubmit() {
                this.$router.push({
                    name: 'search_results',
                    props: { phrase: this.phrase},
                    query: { phrase: this.phrase }
                });
            }
        }
    }
</script>

<style scoped>

</style>