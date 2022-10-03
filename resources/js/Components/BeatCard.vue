<template>
    <div class="trending-card">
        <div class="cr-img-content">
            <!-- Card image -->
            <div class="cr-img-contain">
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
                        <inertia-link :href="`/producers/${beat.uploader.id}`">
                            <a>View Producer</a>
                        </inertia-link>
                    </li>
                    <li><a href="#">Add to playlist</a></li>
                    <li><a href="#">Comment</a></li>
                    <li><a href="#">Share</a></li>
                </ul>
            </div>
        </div>

        <div class="cr-info">
            <inertia-link :href="`/beats/${beat.id}`">
                <p class="cr-song-name">{{ beat.name }}</p>
            </inertia-link>
            <div class="cr-song-data">
                <div>
                    <inertia-link :href="`/producers/${beat.uploader.id}`">
                        <span>{{ beat.uploader.name }}</span>
                    </inertia-link>
                    <br />
                              <span>{{ beat.bpm || 'N/A' }}BPM</span>
                </div>
                <a class="cr-price-btn" @click="showModal"
                ><img src="/data/Icon-shopping-cart.svg" /><button>
                    £{{ beat.price }}
                </button></a
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BeatCard',
    props: {
        beat: {
            type: Object,
            required: true,
        },
    },
    methods: {
        showModal() {
            this.$store.commit('cart/setBeatToAdd', this.beat)
            this.$store.commit('cart/setShowAddToCartModal', true)
        },
    },
}
</script>

<style scoped></style>
