<template>
    <div class="trending-card">
        <div class="cr-img-content">
            <!-- Card image -->
            <div class="cr-img-contain">
<!--                <span class="track-num">1</span>-->
                <img :src="beat.artwork_url" />
            </div>

            <!-- Content on overlay effect -->
            <div class="cr-over-content">
                <button class="cr-play-btn" onclick="mainPlayer()">
                    <span class="material-icons">play_arrow</span>
                </button>

                <div class="cr-over-options">
                    <a href="#"><img src="/data/download-icon.svg" /></a>
                    <a href="#"><img src="/data/add-icon.svg" /></a>

                    <a
                        href="javascript:void(0)"
                        class="track-menu-li"
                        @click.prevent="menuOpen = !menuOpen"
                    ><img src="/data/horizontal-menu-i.svg"
                    /></a>
                </div>
            </div>

            <beat-contextual-menu
                v-if="menuOpen"
                :beat="beat"
                :uploader="user"
                @close="menuOpen = false"
            />
        </div>

        <div class="cr-info">
            <p class="cr-song-name">
                <Link :href="`/beats/${beat.id}`">{{ beat.name }}</Link>
            </p>

            <div class="cr-song-data">
                <div>
          <span>{{ user.name }}</span
          ><br />
                    <span>{{ beat.bpm || 'N/A' }}BPM</span>
                </div>

                <div class="song-tags">
                    <a href="#" class="first-tag">{{ beat.bpm || 'N/A' }} BPM</a>
                    <a href="#" v-for="genre in beat.genres" :key="genre.id"> {{ genre.name }} </a>
                    <!--                    <a href="#">Hi-Hop</a>-->
                    <!--                    <a href="#">Afro beats</a>-->
                    <!--                    <a href="#">Trap</a>-->
                </div>
                <a href="javascript:void(0)" class="cr-price-btn" onclick="openModal()"
                ><img src="/data/Icon-shopping-cart.svg" /><button>
                    £{{ beat.price }}
                </button></a
                >
            </div>
        </div>
    </div>
</template>

<script>
import BeatContextualMenu from './BeatContextualMenu'
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'BeatListItem',
    components: { BeatContextualMenu, Link },
    props: {
        beat: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            menuOpen: false,
        }
    },
    methods: {
        openMenu() {
            this.menuOpen = true
        },
        closeMenu() {
            this.closeMenu()
        },
    },
}
</script>

<style scoped></style>
