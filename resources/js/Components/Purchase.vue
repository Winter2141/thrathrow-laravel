<template>
    <div class="trending-card">
        <div class="cr-img-content">
            <!-- Card image -->
            <div class="cr-img-contain">
                <span class="track-num">{{ index + 1 }}</span>
                <img :src="purchase.artwork_url" />
            </div>

            <!-- Content on overlay effect -->
            <div class="cr-over-content">
                <button class="cr-play-btn" onclick="mainPlayer()">
                    <span class="material-icons">play_arrow</span>
                </button>

                <div class="cr-over-options">
                    <a href="#" @click.prevent="download"
                    ><img src="assets/data/downloaded-i.svg"
                    /></a>
                    <a href="#"><img src="assets/data/add-icon.svg" /></a>

                    <a
                        href="javascript:void(0)"
                        class="track-menu-li"
                        onclick="showListMenu(this)"
                    ><img src="assets/data/horizontal-menu-i.svg"
                    /></a>
                </div>
            </div>

            <div class="track-menu">
                <ul>
                    <li><a href="#">Play</a></li>
                    <li><a href="#">Add To Cart</a></li>
                    <li><a href="#">View Producer</a></li>
                    <li><a href="#">Add to playlist</a></li>
                    <li><a href="#">Comment</a></li>
                    <li><a href="#">Share</a></li>
                </ul>
            </div>
        </div>

        <div class="cr-info">
            <p class="cr-song-name">
                <nuxt-link :to="`/beats/${purchase.id}`">{{ purchase.name }}</nuxt-link>
            </p>

            <div class="cr-song-data">
                <div>
          <span>by {{ purchase.uploader.name }}</span
          ><br />
                </div>

                <div class="song-tags">
                    <a href="#" class="first-tag">{{ purchase.bpm }} BPM</a>
                    <a v-for="genre in purchase.genres" :key="genre.id" href="#">
                        {{ genre.name }}</a
                    >
                </div>
                <!--        <a href="javascript:void(0)" class="cr-price-btn"-->
                <!--          ><img src="assets/data/Icon-shopping-cart.svg" /><button>-->
                <!--            $500-->
                <!--          </button></a-->
                <!--        >-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Purchase',
    props: {
        purchase: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            b: null,
        }
    },
    methods: {
        download() {
            this.$axios
                .$get(`api/purchases/${this.purchase.id}/download_url`)
                .then((response) => {
                    // eslint-disable-next-line no-undef
                    this.doDownload(response)
                })
                .catch((error) => {
                    this.$toast.error(error.message)
                })
        },
        doDownload(link) {
            const element = document.createElement('a')
            element.setAttribute('href', link)
            element.setAttribute('target', '_blank')

            element.style.display = 'none'
            document.body.appendChild(element)

            element.click()

            document.body.removeChild(element)
        },
    },
}
</script>

<style scoped></style>
