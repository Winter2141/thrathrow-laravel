<template>
    <div class="trending-card">
        <div class="cr-img-content">
            <!-- Card image -->
            <div class="cr-img-contain">
                <!--                <span class="track-num">1</span>-->
                <img :src="beat.artwork_url"/>
            </div>

            <!-- Content on overlay effect -->
            <div class="cr-over-content">
                <button class="cr-play-btn" onclick="mainPlayer()">
                    <span class="material-icons">play_arrow</span>
                </button>

                <div class="cr-over-options">
                    <a href="#"><img src="/data/download-icon.svg"/></a>
                    <a href="#"><img src="/data/add-icon.svg"/></a>

                    <a
                        href="javascript:void(0)"
                        class="track-menu-li"
                        onclick="showListMenu(this)"
                    ><img src="/data/horizontal-menu-i.svg"
                    /></a>
                </div>
            </div>

            <div class="track-menu">
                <ul>
                    <li><a href="#">Play</a></li>
                    <li><a href="#">Add To Cart</a></li>
                    <li>
                        <Link :to="`/producers/${beat.uploader.id}`">
                            <a>View Producer</a>
                        </Link>
                    </li>
                    <li><a href="#">Add to playlist</a></li>
                    <li><a href="#">Comment</a></li>
                    <li><a href="#">Share</a></li>
                </ul>
            </div>
        </div>

        <div class="cr-info">
            <Link :href="`/beats/${beat.id}`">
                <p class="cr-song-name">{{ beat.name }}</p>
            </Link>
            <div class="cr-song-data">
                <div>
                    <Link :href="`/producers/${beat.uploader.id}`">
                        <span>{{ beat.uploader.name }}</span></Link
                    >
                    <br/>
                    <span>{{ beat.bpm || 'N/A' }}BPM</span>
                </div>

                <div class="song-tags">
                    <a href="#" class="first-tag">{{ beat.bpm || 'N/A' }} BPM</a>
                    <a v-for="genre in beat.genres" :key="genre.id" href="#">{{ genre.name }}</a>
                </div>
                <a href="javascript:void(0)" class="cr-price-btn" onclick="openModal()"
                ><img src="/data/Icon-shopping-cart.svg"/>
                    <button>
                        £{{ beat.price }}
                    </button>
                </a
                >
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: 'ExploreBeatCard',
    components: {
        Link
    },
    props: {
        beat: {
            type: Object,
            required: true,
        },
    },
}
</script>

<style scoped></style>
