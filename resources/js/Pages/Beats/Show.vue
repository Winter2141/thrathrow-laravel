<template>
    <div>
        <section class="container-fluid nopadding">
            <div class="beats-info-hdr">
                <div id="bt-sub-hdr">
                    <!-- Beat info Cover Image -->
                    <div class="bt-info-img">
                        <img :src="beat.artwork_url" />
                    </div>

                    <!-- Beat info (Name and description, date) -->
                    <div id="bt-info-contents">
                        <h2 class="bt-hdr1">{{ beat.name }}</h2>
                        <h3 class="bt-hdr2">{{ beat.uploader.name }}</h3>
                        <p class="bt-date">
                            Posted: {{ new Date(beat.created_at).toDateString() }}
                        </p>

                        <button class="bt-price-btn">
                            <img src="/data/cart-i2.svg" />
                            {{ beat.price }}
                        </button>
                    </div>
                </div>

                <!-- Switching Tabs for Beat info content -->
                <div class="pro-tab-switch bt-tabs-rw row">
                    <a
                        style="cursor: pointer"
                        :class="{ 'active-state': currentTab === 1 }"
                        @click.prevent="switchTab(1)"
                    >Description</a
                    >
                    <a
                        style="cursor: pointer"
                        :class="{ 'active-state': currentTab === 2 }"
                        @click.prevent="switchTab(2)"
                    >Artist</a
                    >
                    <a
                        style="cursor: pointer"
                        :class="{ 'active-state': currentTab === 3 }"
                        @click.prevent="switchTab(3)"
                    >Comments</a
                    >
                </div>
            </div>
        </section>
        <section v-if="currentTab === 1" class="bt-info-block">
            <div class="bt-info-con">
                <p class="bt-info-txt">
                    {{ beat.description }}
                </p>
            </div>
        </section>
        <section v-if="currentTab === 2" class="bt-info-block">
            <div class="bt-info-con">
                <div id="pro-bg-overlay">
                    <div class="producer-img">
                        <img :src="beat.uploader.profile_image_url" />
                    </div>

                    <div id="producer-details" class="container">
                        <!-- Producer Name -->
                        <p class="producer-name">{{ beat.uploader.name }}</p>

                        <!-- Producer Bio text -->
                        <p class="producer-bio">
                            {{ showMore ? beat.uploader.about : producerText }}
                            <a
                                v-if="!showMore && hasMore"
                                href="#"
                                class="pro-read-more"
                                @click.prevent="toggleShowMore"
                            >Read More</a
                            >
                            <a
                                v-if="showMore"
                                href="#"
                                class="pro-read-more"
                                @click.prevent="toggleShowMore"
                            >Read Less</a
                            >
                        </p>

                        <div id="pro-lower-row">
                            <div id="hire-producer-btn">
                                <!-- Producer Hire Button -->
                                <Link v-if="currentUser" :href="`/producers/${beat.uploader.id}/hire`"
                                ><button>
                                    <i class="fas fa-file-contract"></i>Hire producer
                                </button></Link
                                >
                                <Link v-else href="/login"> Please login to hire a producer </Link>
                            </div>

                            <div id="pro-social-medias">
                                <a :href="beat.uploader.soundcloud_url"
                                ><i class="fab fa-soundcloud"></i
                                ></a>
                                <a :href="beat.uploader.twitter_url"
                                ><i class="fab fa-twitter"></i
                                ></a>
                                <a :href="beat.uploader.facebook_url"
                                ><i class="fab fa-facebook-f"></i
                                ></a>
                                <a :href="beat.uploader.instagram_url"
                                ><i class="fab fa-instagram"></i
                                ></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section v-if="currentTab === 3" class="bt-info-block">
            <form @submit.prevent="submit" v-if="currentUser" id="bt-comments-bl">
                <!-- Comment input and button -->
                <textarea
                    v-model="form.content"
                    placeholder="write comment here (min 10 characters)"
                ></textarea>
                <p style="margin-top: 1rem; color: red" v-if="form.errors.content"> {{ form.errors.content }} </p>
                <button
                    type="submit"
                    id="bt-cmt-btn"
                    :disabled="form.processing"
                >
                    Comment
                </button>
            </form>
            <div
                v-else
                style="
          margin-top: 2rem;
          margin-bottom: 2rem;
          text-align: center;
          color: white;
        "
            >
                <Link :href="route('login')"> Please log in to create a comment </Link>
            </div>
            <div class="bt-info-con cmt-block">
                <h5 class="cmt-hdr">
                    Comments <span>({{ comments.meta.total }})</span>
                </h5>

                <!-- Comment 1 -->
                <div
                    v-for="comment in comments.data"
                    :key="comment.id"
                    class="cmt-item"
                >
                    <div class="cmt-img" >
                        <img style="height: 60px; width: 60px; border-radius: 50%" :src="comment.user.profile_image_url" :alt="comment.user.name" />
                    </div>

                    <div class="cmt-contents">
                        <p class="cmtr-name">{{ comment.user.name }}</p>
                        <p class="cmtr-txt" style="word-wrap: anywhere">{{ comment.content }}</p>
                        <span class="cmt-date">{{
                                new Date(comment.created_at).toLocaleString()
                            }}</span>

                        <button @click="likeCall(comment.id, comment.has_liked)" :title="comment.has_liked ? 'Unlike' : 'Like'" :disabled="currentUser.data.id === comment.user.id" class="cmt-like-btn">
              <span>{{ comment.likes_count }}</span
              ><img style="background-color: #0A0A0A" src="/data/thumbs-up-i.svg" />
                        </button>
                        <hr class="cmt-hr" />
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between">
                    <Link preserve-state preserve-scroll :only="['comments']" v-if="comments.links.prev" :href="comments.links.prev"> Previous </Link>
                    <Link preserve-state preserve-scroll :only="['comments']" v-if="comments.links.next" :href="comments.links.next"> Next </Link>
                </div>
                <p v-if="comments.meta.last_page > 1" style="color: white">
                    Page: {{ comments.meta.current_page }} of
                    {{ comments.meta.last_page }}
                </p>
            </div>
        </section>
    </div>
</template>

<script>

import Layout from '../../Layouts/Default'
import {Link, useForm} from '@inertiajs/inertia-vue3'

export default {
    name: 'SingleBeat',
    layout: Layout,
    components: {
        Link,
    },
    props: {
        beat: {
            type: Object,
            required: true,
        },
        comments: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            currentTab: 1,
            showMore: false,
            commentContent: '',
            submittingComment: false,
            commentsPage: 1,
        }
    },
    head() {
        return {
            title: 'Beat',
        }
    },
    setup(props) {
        const form = useForm({
            content: null,
        })

        const like = useForm({})
        const dislike = useForm({})

        const submit = () => {
            form.post(`/beats/${props.beat.id}/comments`, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => form.reset('content')
            })
        }

        const likeCall = (commentId, hasLiked) => {
            if (hasLiked) {
                form.delete(`/beats/${props.beat.id}/comments/${commentId}/likes`, {
                    preserveScroll: true,
                    preserveState: true,
                })
            } else {
                form.post(`/beats/${props.beat.id}/comments/${commentId}/likes`, {
                    preserveScroll: true,
                    preserveState: true,
                })
            }
        }

        return { form, submit, likeCall }
    },
    computed: {
        currentUser() {
            return this.$page.props.auth.user
        },
        producerText() {
            if (
                this.beat.uploader.about &&
                this.beat.uploader.about.trim().length > 150
            ) {
                return this.beat.uploader.about.trim().substr(0, 150) + '...'
            }

            return this.beat.uploader.about ? this.beat.uploader.about.trim() : ''
        },
        hasMore() {
            return (
                this.beat.uploader.about && this.beat.uploader.about.trim().length > 150
            )
        },
    },
    methods: {
        switchTab(tab) {
            this.currentTab = tab
        },
        toggleShowMore() {
            this.showMore = !this.showMore
        },
    },
}
</script>

<style scoped></style>
