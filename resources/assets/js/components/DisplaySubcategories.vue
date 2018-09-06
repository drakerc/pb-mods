<template>
    <div>
        <div v-for="(value, index) in subcategories">
            <p>tytuł: {{ value.title }}</p>
            <p>opis: {{ value.description }}</p>

            <div v-if="value.subcategories === undefined">
                <div @click="getSubcategories(index, value.id)">Rozwiń podkategorie tej podkategorii</div>
            </div>

            <div v-for="child in value.children">
                <display-subcategories :categories="[child]"></display-subcategories>
            </div>

            <hr>
        </div>
    </div>
</template>

<script>
    import DisplaySubcategories from './DisplaySubcategories';
    import axios from "axios";

    export default {
        props: ['categories'],
        components: {
            DisplaySubcategories,
        },
        data: function () {
            return {
                subcategories: this.categories,
            }
        },
        beforeCreate() {
            this.$options.components.DisplaySubcategories = require('./DisplaySubcategories.vue');
        },
        beforeMount: function () {
            var that = this;
            this.subcategories.forEach(function (item, index) { // TODO: change to => function
                return that.subcategories[index].children = [];
            });
        },
        methods: {
            getSubcategories: function (id, categoryId) {
                axios.get('/api/categories/' + categoryId + '/subcategories').then(response => {
                    this.subcategories[id].children = response.data;
                    this.subcategories[id].updated_at = 'now';
                    var newVal = Object.assign({}, this.subcategories[id], {subcategories: true});
                    Vue.set(this.subcategories, id, newVal) // VueJS does not reload the DOM tree after changing an array; using a set method will trigger a reload
                });
            }
    }}
</script>
