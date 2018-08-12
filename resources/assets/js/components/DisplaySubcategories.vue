<template>
    <div>
        <div v-for="(value, index) in subcategories">
            <p>{{ value.title }}</p>
            <p>{{ value.description }}</p>

            <div v-for="child in value.children">
                {{ child.title }}
                <!--<display-subcategories :categories="child"></display-subcategories>-->
            </div>

            <div v-if="value.subcategories === undefined">
                <div @click="getSubcategories(index, value.id)">Rozwiń podkategorie tej podkategorii</div>
            </div>
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
                subcategories: this.categories
            }
        },
        mounted: function () {
            var that = this;
            this.subcategories.forEach(function (item, index) { // TODO: change to => function
                return that.subcategories[index].children = [];
            });
        },
        methods: {
            getSubcategories: function (id, categoryId) {
                axios.get('/api/categories/' + categoryId + '/subcategories').then(response => {
                    this.subcategories[id].children = response.data;
                    this.subcategories[id].subcategories = true;
                });
            }
    }}
</script>
