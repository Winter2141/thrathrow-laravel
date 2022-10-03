<template>
    <section class="container-fluid nopadding" id="my-beats-sec">
        <div class="my-beats-hdr">
            <h2>My Beats</h2>
        </div>
    </section>

    <section class="my-beats-con">
        <!-- ALl sections tracks -->
        <div class="container-fluid">
            <div class="hdr-uppr-row">
                <h3 class="wrapper-heading">Beats ({{ beats.meta.total }})</h3>

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
                <div class="row" :class="[listView ? 'list-view' : '']" id="tracks-container">
                    <BeatListItem v-for="beat in beats.data" :key="beat.id" :user="beat.uploader" :beat="beat" />
                </div>
            </div>
        </div>
    </section>

    <Pagination v-if="beats.meta.total > 20" :prev-url="beats.links.prev" :next-url="beats.links.next" :links="beats.meta.links" :only="['beats']" preserve-state />
</template>

<script>

import { Link} from "@inertiajs/inertia-vue3";
import Default from "@/Layouts/Default";
import BeatCard from "@/Components/BeatCard";
import BeatListItem from "@/Components/BeatListItem";
import Pagination from "@/Components/Pagination";

export default {
    name: "MyBeats",
    components: {
        BeatListItem,
        BeatCard,
        Link,
        Pagination
    },
    layout: Default,
    props: {
        beats: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            listView: false,
        }
    },
}
</script>

<style scoped>

</style>
