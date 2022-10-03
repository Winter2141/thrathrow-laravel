<template>
    <fragment>
        <!-- Sidebar -->
        <button id="side-m-btn"><span class="material-icons">add</span></button>
        <div id="explore-sidebar" class="col-lg-2">
            <h3 class="sidebar-hdr">Sections</h3>

            <ul id="sb-links-1">
                <li>
                    <Link
                        :class="{ 'sb-active': $page.props.currentRoute === 'explore.index' }"
                        href="/explore"
                    >
                        <a>All sections</a>
                    </Link>
                </li>
                <li>
                    <Link
                        :class="{ 'sb-active': $page.props.currentRoute === 'explore.beats' }"
                        href="/explore/beats"
                    >
                        <a>Beats</a>
                    </Link>
                </li>
                <li>
                    <Link
                        :class="{ 'sb-active': $page.props.currentRoute === 'explore.producers' }"
                        href="/explore/producers"
                    >
                        <a>Producers</a>
                    </Link>
                </li>
            </ul>
            <div v-if="showFilters" id="sb-genres">
                <h3 class="genres-hdr">Genres</h3>

                <form class="sidebar-checkbox" method="post" action="#">
                    <!-- Hip hop -->
                    <label v-for="genre in genres" :key="genre.id">
                        <input v-model="form.genres" type="checkbox" :value="genre.id"/>
                        <div class="cr">
                            <span class="material-icons cr-icon">done</span>
                        </div>
                        {{ genre.name }}
                    </label>
                </form>

                <!--        <div class="sb-see-more">-->
                <!--          <a href="#">See more +</a>-->
                <!--        </div>-->
            </div>

            <!-- BPM Range slider -->
            <div v-if="showFilters" id="sb-bpm">
                <h3 class="genres-hdr">BPM</h3>
                <div class="sb-range-slider">
                    <div id="id66" class="range-slider">
                        <vue-slider
                            v-model="form.bpm"
                            :lazy="true"
                            :min-range="25"
                            :max="300"
                            :enable-cross="false"
                        >
                            <template #dot>
                                <button id="" class="range__button_1"></button>
                            </template>
                        </vue-slider>
                        <div class="range-results">
                            <input
                                id="id66i1"
                                v-model="form.bpm[0]"
                                class="range_inpt1"
                                type="number"
                                min="0"
                                max="300"
                            />
                            <span>to</span>
                            <input
                                id="id66i2"
                                v-model="form.bpm[1]"
                                class="range_inpt2"
                                type="number"
                                min="20"
                                max="300"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Range slider -->
            <div v-if="showFilters" id="sb-price-slider">
                <h3 class="genres-hdr">Price</h3>

                <div class="sb-range-slider">
                    <div id="secId66" class="range-slider">
                        <vue-slider
                            v-model="form.price"
                            :lazy="true"
                            :min-range="20"
                            :max="9000"
                            :enable-cross="false"
                        >
                            <template #dot>
                                <button id="" class="range__button_1"></button>
                            </template>
                        </vue-slider>

                        <div class="range-results">
                            <div>
                                <input
                                    id="secId66i3"
                                    v-model="form.price[0]"
                                    class="range_inpt1"
                                    type="number"
                                    placeholder="£"
                                    min="0"
                                    max="99999"
                                />
                                <span>£</span>
                            </div>
                            <span>to</span>
                            <div>
                                <input
                                    id="secId66i4"
                                    v-model="form.price[1]"
                                    class="range_inpt2"
                                    type="number"
                                    min="20"
                                    max="9000"
                                />
                                <span>£</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form v-if="showFilters" class="sidebar-checkbox last-t-box">
                <!-- Hip hop -->
                <label>
                    <input v-model="form.isFree" type="checkbox" value=""/>
                    <div class="cr">
                        <span class="material-icons cr-icon">done</span>
                    </div>
                    Free
                </label>
            </form>
        </div>
    </fragment>
</template>

<script>

import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'
import {Link, useForm} from "@inertiajs/inertia-vue3";
import {Inertia} from '@inertiajs/inertia'

export default {
    name: 'SideBar',
    components: {
        VueSlider,
        Link,
    },
    data() {

    },
    props: ['genres', 'filters', 'showFilters'],
    setup() {
        const form = useForm({
            genres: [],
            bpm: [0, 300],
            price: [0, 9000],
            isFree: false,
        })

        return {
            form
        }
    },
    watch: {
        $route() {
            this.selectedGenres = []
        },
        form: {
            handler(val) {
                console.log(val)
                this.submit()
            },
            deep: true
        },
        bpm(newValue) {
            this.$store.commit('explore/setBpm', newValue)
        },
        price(newValue) {
            this.$store.commit('explore/setPrice', newValue)
        },
        isFree(newValue) {
            this.$store.commit('explore/setFree', newValue)
        },
    },
    mounted() {
        /*Side Menu on Tracks page*/
        if(document.querySelector('#side-m-btn') !== null) {
            document.querySelector('#side-m-btn').addEventListener('click', function(e){
                document.querySelector("#explore-sidebar").classList.toggle('sidebar-change');
                document.querySelector("#side-m-btn").classList.toggle('sidebar-change-i');
            });
        }
    },
    methods: {
        submit() {
            let url = '';
            const pageUrl = this.$page.url
            if (pageUrl.startsWith('/explore/beats')) {
                url = '/explore/beats'
            } else if (pageUrl.startsWith('/explore/producers')) {
                url = '/explore/producers'
            } else {
                url = '/explore'
            }
            const data = {
                genres: this.form.genres,
                minBpm: this.form.bpm[0],
                maxBpm: this.form.bpm[1],
                minPrice: this.form.price[0],
                maxPrice: this.form.price[1],
                isFree: this.form.isFree
            }

            Inertia.post(url, data, {
                preserveState: true
            })

            // this.$inertia.post(url, data, {
            //
            // })
            //
            // this.form.transform((data) => {
            //    return
            // }).post(url, {
            //     preserveState: true,
            //
            // })
        }
    }
}
</script>

<style scoped>
    .sb-range-slider {
        padding: 0 2rem;
    }

    .range-slider {
        width: 100%;
    }

</style>
