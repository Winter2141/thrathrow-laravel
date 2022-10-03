<template>
    <div class="track-menu show-menu my-height">
        <ul class="my-height">
            <li @click.prevent="play"><a href="#">Play</a></li>
            <li @click.prevent="showModal"><a href="#">Add To Cart</a></li>
            <li>
                <nuxt-link :to="`/producers/${uploader.id}`">
                    <a>View Producer</a>
                </nuxt-link>
            </li>
            <li @click.prevent="addToPlaylist">
                <a href="#">Add to playlist</a>
            </li>
            <li><a href="#">Comment</a></li>
            <li><a href="#">Share</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'BeatContextualMenu',
    props: {
        beat: {
            type: Object,
            required: true,
        },
        uploader: {
            type: Object,
            required: true,
        },
    },
    methods: {
        showModal() {
            this.closeMenu()
            this.$store.commit('cart/setBeatToAdd', this.beat)
            this.$store.commit('cart/setShowAddToCartModal', true)
        },
        play() {
            this.closeMenu()
            this.$store.commit('player/hidePlayer')
            setTimeout(() => {
                this.$store.commit('player/displayPlayer')
                this.$store.commit('player/play', this.beat)
                this.$store.commit('player/setPlaylist', this.beat)
            }, 300)
        },
        addToPlaylist() {
            this.closeMenu()
            this.$store.commit('player/addToPlaylist', this.beat)
        },
        closeMenu() {
            this.$emit('close')
        },
    },
}
</script>

<style scoped>
.my-height {
    min-height: 500px;
}
</style>
