<template>
    <section id="explore-sec" class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <SideBar :genres="genres.data" :show-filters="!search"/>

            <!-- ALl sections tracks -->
            <div class="offset-lg-2 col-lg-10">
                <h3 class="wrapper-heading">Explore: &nbsp;Producers</h3>
            </div>

            <!-- Popular Producers -->
            <div id="popluar-pr-sec" class="offset-lg-2 col-lg-10 popluar-pr-sec2">
                <div class="container-fluid nopadding">
                    <h3 class="wrapper-sub-hdr">Popular Producer</h3>

                    <div id="tracks-container" class="row b-popular-pro">
                        <ExploreProducerCardLink
                            v-for="producer in trendingProducers.data"
                            :key="producer.id"
                            :producer="producer"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import ExploreProducerCardLink from "@/Components/ExploreProducerCardLink";
import SideBar from "@/Components/SideBar";
import Default from "@/Layouts/Default";
export default {
    name: 'ExploreProducers',
    components: { SideBar, ExploreProducerCardLink },
    auth: false,
    layout: Default,
    props: {
        trendingProducers: {
            type: Object,
            required: true
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

            const trendingProducers = await this.$axios.$get(
                'api/trending/producers' + queryparams
            )

            this.trendingProducers = trendingProducers.data
        },
    },
}
</script>

<style scoped>
.b-popular-pro {
    min-height: 100vh;
}
</style>
