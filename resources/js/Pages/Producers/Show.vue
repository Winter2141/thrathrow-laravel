<template>
    <div>
        <section id="producer-pro-sec" class="container-fluid">
            <div class="row">
                <div id="producer-pro-data" class="container-fluid nopadding">
                    <div id="pro-bg-overlay">
                        <div class="producer-img">
                            <img :src="user.data.profile_image_url" :alt="user.data.name" />
                        </div>

                        <div id="producer-details" class="container">
                            <!-- Producer Name -->
                            <p class="producer-name">{{ user.data.name }}</p>

                            <!-- Producer Bio text -->
                            <!--              <p v-if="user.data.about" class="producer-bio">-->
                            <!--                {{ user.data.about }}-->
                            <!--                <a href="#" class="pro-read-more">Read More</a>-->
                            <!--              </p>-->

                            <div id="pro-lower-row">
                                <div id="hire-producer-btn">
                                    <!-- Producer Hire Button -->
                                    <Link v-if="currentUser" :href="`/producers/${user.data.id}/hire`"
                                    ><button :disabled="!currentUser || currentUser.id == user.data.id">
                                        <i class="fas fa-file-contract"></i>Hire producer
                                    </button></Link>
                                    <Link v-else href="/login"> Please login to hire a producer </Link>
                                </div>

                                <div id="pro-social-medias">
                                    <a :href="user.data.soundcloud_url"
                                    ><i class="fab fa-soundcloud"></i
                                    ></a>
                                    <a :href="user.data.twitter_url"><i class="fab fa-twitter"></i></a>
                                    <a :href="user.data.facebook_url"
                                    ><i class="fab fa-facebook-f"></i
                                    ></a>
                                    <a :href="user.data.instagram_url"
                                    ><i class="fab fa-instagram"></i
                                    ></a>
                                </div>
                            </div>
                            <!-- Tabs switching Row -->
                            <div class="pro-tab-switch row">
                                <a
                                    href="#"
                                    :class="[currentTab === 1 ? 'active-state' : '']"
                                    @click="currentTab = 1"
                                >Beats</a
                                >
                                <a
                                    href="#"
                                    :class="[currentTab === 2 ? 'active-state' : '']"
                                    @click="currentTab = 2"
                                >About</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="producer-tracks">
            <!-- ALl sections tracks -->
            <div v-if="currentTab === 1" class="container-fluid">
                <div class="hdr-uppr-row">
                    <h3 class="wrapper-heading">
                        Beats (
                        {{ user.data.beats_count }}
                        )
                    </h3>

                    <div id="view-icons">
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
                    <div
                        id="tracks-container"
                        class="row"
                        :class="[listView ? 'list-view' : '']"
                    >
                        <!-- CARD 1 -->
                        <beat-list-item
                            v-for="beat in beats.data"
                            :key="beat.id"
                            :beat="beat"
                            :user="user"
                        />
                    </div>
                    <div style="display: flex; justify-content: space-between">
                        <Link preserve-state preserve-scroll :only="['beats']" v-if="beats.links.prev" :href="beats.links.prev"> Previous </Link>
                        <Link preserve-state preserve-scroll :only="['beats']" v-if="beats.links.next" :href="beats.links.next"> Next </Link>
                    </div>
                    <div>
                        <p v-if="beats.meta.last_page > 1" style="color: white">
                            Page: {{ beats.meta.current_page }} of
                            {{ beats.meta.last_page }}
                        </p>
                    </div>
                </div>
            </div>

            <div v-else class="container-fluid">
                {{ user.data.about }}
            </div>
        </section>
    </div>
</template>

<script>
import BeatListItem from '../../Components/BeatListItem'
import Default from "@/Layouts/Default";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'Producer',
    components: { BeatListItem, Link },
    layout: Default,
    props: {
        user: {
            type: Object,
            required: true
        },
        beats: {
            type: Object,
            required: true
        }
    },
    computed: {
      currentUser() {
          return this.$page.props.auth.user ? this.$page.props.auth.user.data : null
      }
    },
    data() {
        return {
            currentTab: 1,
            listView: true,
        }
    },
    head() {
        return {
            title: 'Producer Profile',
        }
    },
    methods: {
        changeTab(tab) {
            this.currentTab = tab
        },
        getBeats() {
            return []
        },
    },
}
</script>

<style scoped></style>
