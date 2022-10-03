<template>

        <!-- ALl sections tracks -->
        <div class="offset-lg-2 col-lg-10">
            <h3 class="wrapper-heading">Explore: &nbsp;All Sections</h3>

            <div class="container-fluid nopadding">
                <h3 class="wrapper-sub-hdr">Trending Beat Tracks</h3>

                <div id="tracks-container" class="row">
                    <BeatCard
                        v-for="beat in trendingBeats.data"
                        :key="beat.id"
                        :beat="beat"
                    />
                </div>
            </div>
        </div>

        <!-- Latest Beat tracks -->
        <div class="offset-lg-2 col-lg-10">
            <div class="container-fluid nopadding">
                <h3 class="wrapper-sub-hdr wrapper-hdr-edit">latest Beat Tracks</h3>

                <div id="tracks-container" class="row">
                    <BeatCard v-for="beat in latestBeats.data" :key="beat.id" :beat="beat"/>
                </div>
            </div>
        </div>

        <!-- Popular Producers -->
        <div id="popluar-pr-sec" class="offset-lg-2 col-lg-10">
            <div class="container-fluid nopadding">
                <h3 class="wrapper-sub-hdr wrapper-hdr-edit">Popular Producer</h3>

                <div id="tracks-container" class="row b-popular-pro">
                    <ExploreProducerCard
                        v-for="producer in popularProducers.data"
                        :key="producer.id"
                        :producer="producer"
                    />
                </div>
            </div>
        </div>

</template>

<script>

import BeatCard from "@/Components/BeatCard";
import ExploreProducerCard from "@/Components/ExploreProducerCard";

export default {
    name: "StandardVue",
    components: {
        BeatCard,
        ExploreProducerCard,
    },
    props: {
        trendingBeats: {
            type: Array,
            required: true
        },
        latestBeats: {
            type: Array,
            required: true
        },
        popularProducers: {
            type: Array,
            required: true
        },
    }
}
</script>

<style scoped>

</style>
