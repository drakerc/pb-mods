<template>
    <div class="listing-summary">
        <router-link :to="{ name: 'modification_view', params: { mod: mod.id } }">
            <div class="wrapper">
                <div class="thumbnail" :style="backgroundImageStyle"></div>
                <div class="info title">
                    <span>{{ mod.title }}</span>
                    <span>{{ mod.description | truncate(100) }}</span>
                </div>
            </div>
        </router-link>
    </div>
</template>
<script>
    export default {
        props: [ 'mod' ],
        computed: {
            backgroundImageStyle() {
                return {
                    'background-image': `url("${this.mod.thumbnail}")`
                }
            }
        }
    }
</script>
<style>
    .listing-summary {
        flex: 0 0 auto;
    }
    .listing-summary a {
        text-decoration: none;
    }
    .listing-summary .wrapper {
        max-width: 350px;
        display: block;
    }
    .listing-summary .thumbnail {
        width: 350px;
        height: 250px;
        background-size: cover;
        background-position: center;
    }
    .listing-summary .info {
        color: #484848;
        word-wrap: break-word;
        letter-spacing: 0.2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .listing-summary .info.title {
        padding-top: 5px;
        font-weight: 700;
        font-size: 16px;
        line-height: 24px;
    }
</style>