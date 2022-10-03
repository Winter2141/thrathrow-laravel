<template>
    <section id="explore-sec" class="container-fluid">
        <div class="row">
            <SideBar :genres="genres.data" :show-filters="!search"/>
            <StandardVue v-if="!search" :latest-beats="latestBeats" :popular-producers="popularProducers" :trending-beats="trendingBeats" />
            <SearchVue v-else :beats="latestBeats" :producers="popularProducers" />
        </div>
    </section>
</template>

<script>
import BeatCard from '@/Components/BeatCard'
import ExploreProducerCard from '@/Components/ExploreProducerCard'
import SideBar from '@/Components/SideBar'
import Default from "@/Layouts/Default";
import StandardVue from "@/Components/Explore/StandardVue";
import SearchVue from "@/Components/Explore/SearchVue";

export default {
    name: 'Index',
    components: {SearchVue, StandardVue, SideBar, ExploreProducerCard, BeatCard},
    auth: false,
    layout: Default,
    props: {
        trendingBeats: {
            type: Object,
            required: true,
        },
        latestBeats: {
            type: Object,
            required: true,
        },
        popularProducers: {
            type: Object,
            required: true,
        },
        genres: {
            type: Object,
            required: true
        },
        search: {
            type: Boolean,
            required: true,
        }
    },

    computed: {
        filters() {
            return []
        },
    },
    watch: {
        async filters(val) {
            let queryparams = ''

            if (val.genres.length > 0) {
                queryparams = '?'
                queryparams += 'genres=' + val.genres.join(',')
            }

            const trendingBeats = await this.$axios.$get(
                'api/trending/beats' + queryparams
            )
            const latestBeats = await this.$axios.$get(
                '/api/latest/beats' + queryparams
            )
            const popularProducers = await this.$axios.$get(
                'api/trending/producers' + queryparams
            )

            this.trendingBeats = trendingBeats.data
            this.latestBeats = latestBeats.data
            this.popularProducers = popularProducers.data
        },
    },
}
</script>

<style scoped></style>
