<template>
    <!-- ALl sections tracks -->
    <div class="offset-lg-2 col-lg-10">
        <h3 class="wrapper-heading"></h3>

        <div class="container-fluid nopadding">
            <h3 class="wrapper-sub-hdr">Beats</h3>

            <div id="tracks-container" class="row">
                <ExploreBeatCard
                    v-for="beat in beats.data"
                    :key="beat.id"
                    :beat="beat"
                />
            </div>
        </div>
    </div>

    <!-- Latest Beat tracks -->
    <div class="offset-lg-2 col-lg-10">
        <div class="container-fluid nopadding">
            <h3 class="wrapper-sub-hdr wrapper-hdr-edit">Producers</h3>

            <div id="tracks-container" class="row">
                <ExploreProducerCard v-for="producer in producers.data" :key="producer.id" :producer="producer"/>
            </div>
        </div>
    </div>
</template>

<script>
import BeatCard from "@/Components/BeatCard";
import ExploreProducerCard from "@/Components/ExploreProducerCard";
import ExploreBeatCard from "@/Components/ExploreBeatCard";

export default {
    name: "SearchVue",
    components: {
        ExploreBeatCard,
        ExploreProducerCard,
        BeatCard,
    },
    props: {
        beats: {
            type: Object,
            required: true,
        },
        producers: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            searchTerm: ''
        }
    },
}
</script>

<style scoped>

</style>
