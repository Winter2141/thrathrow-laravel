<template>
    <section id="beats-sec" class="container-fluid">
        <div class="row" :class="[listView ? 'list-view' : '']">
            <SideBar :genres="genres.data" :show-filters="!search"/>
            <div class="offset-lg-2 col-lg-10 col-md-12">
                <div class="hdr-uppr-row">
                    <h3 class="wrapper-heading">Trending Beat Tracks</h3>

                    <div id="view-icons" style="cursor: pointer">
                        <a
                            id="card-view-i"
                            :class="[!listView ? 'active-view' : '']"
                            @click="listView = false"
                        ><img src="/data/card-view-i.svg"
                        /></a>
                        <a
                            id="list-view-i"
                            :class="[listView ? 'active-view' : '']"
                            @click="listView = true"
                        ><img src="/data/list-view-i.svg"
                        /></a>
                    </div>
                </div>

                <div class="container-fluid nopadding">
                    <div id="tracks-container" class="row">
                        <ExploreBeatCard
                            v-for="beat in trendingBeats.data"
                            :key="beat.id"
                            :beat="beat"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ExploreBeatCard from "@/Components/ExploreBeatCard";
import SideBar from "@/Components/SideBar";
import Default from "@/Layouts/Default";
export default {
    name: 'ExploreBeats',
    components: { SideBar, ExploreBeatCard },
    auth: false,
    layout: Default,
    props: {
        trendingBeats: {
            type: Object,
            required:true
        },
        search: {
            type: Boolean,
            required: false,
            default: false
        },
        genres: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            listView: false,
        }
    },
    computed: {
        filters() {
            // return this.$store.state.explore.filters
        },
    },
    watch: {
        async filters(val) {
            let queryparams = '?limit=20'

            if (val.genres.length > 0) {
                queryparams += '&genres=' + val.genres.join(',')
            }

            if (val.price.length > 0) {
                queryparams +=
                    '&min_price=' + val.price[0] + '&max_price=' + val.price[1]
            }

            if (val.bpm.length > 0) {
                queryparams += '&min_bpm=' + val.bpm[0] + '&max_bpm=' + val.bpm[1]
            }

            if (val.isFree) {
                queryparams += '&is_free=' + val.isFree
            }

            const trendingBeats = await this.$axios.$get(
                'api/trending/beats' + queryparams
            )

            this.trendingBeats = trendingBeats.data
        },
    },
}
</script>

<style scoped></style>
