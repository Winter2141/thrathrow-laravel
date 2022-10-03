<template>
    <section id="home-sec">
        <!-- Main Screen Tagline and Search  -->
        <div id="main-scr" class="container-fluid">
            <div id="main-src-con" class="col-lg-7 col-md-8 col-sm-10">
                <p>
                    Get <span>beats <img src="data/Path 14649.svg"/> </span> for
                    your next hit song
                </p>

                <div id="main-src-srch">
                    <form @submit.prevent="submit">
                        <img id="main-src-img" src="data/search-i-2.svg"/>
                        <input
                            v-model="searchForm.term"
                            type="text"
                            name=""
                            placeholder='Try "Hip hop beat" or "Davido beat"'
                        />
                    </form>

                    <div class="main-src-sel">
                        <!-- <span class="ver-line1"></span> -->

                        <select v-model="searchForm.section">
                            <option value="all">All</option>
                            <option value="beats">Beats</option>
                            <option value="producers">Producers</option>
                        </select>
                        <img src="data/Arrow-down-2.svg" for="select"/>
                    </div>
                </div>
            </div>

            <!-- Hire Producer  -->
            <div id="hire-pro">
                <Link href="/explore/producers">
                    <span>Hire Producer</span>
                    <span class="hire-arrow"><i class="fas fa-arrow-right"></i></span>
                </Link>
            </div>
        </div>
        <!-- =================  -->

        <!-- Trending Beat Tracks START -->
        <div id="wrapper-1" class="container-fluid">
            <h3 class="wrapper-hdr">Trending Beat Tracks</h3>

            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper col-lg-12 nopadding">
                    <swiper
                        v-if="trendingBeats"
                        ref="trendingBeats"
                        :pagination="swiperOptions.pagination"
                        :navigation="swiperOptions.navigation"
                        :speed="swiperOptions.speed"
                        :breakpoints="swiperOptions.breakpoints"
                        :spaceBetween="swiperOptions.spaceBetween"
                    >
                        <swiper-slide v-for="beat in trendingBeats.data" :key="beat.id">
                            <BeatCard :beat="beat"/>
                        </swiper-slide>
                    </swiper>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev trending-beats"></div>
                <div class="swiper-button-next trending-beats"></div>
            </div>
        </div>
        <!-- Trending Beat Tracks END -->

        <!-- Latest Beat Tracks START -->
        <div id="wrapper-2" class="container-fluid">
            <h3 class="wrapper-hdr">Latest Beat Tracks</h3>

            <!--Style section -->
            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper col-lg-12 nopadding">
                    <!-- Slides -->
                    <!-- Card 1 -->
                    <swiper
                        v-if="latestBeats"
                        ref="latestBeats"
                        :pagination="latestBeatsSwiperOptions.pagination"
                        :navigation="latestBeatsSwiperOptions.navigation"
                        :speed="latestBeatsSwiperOptions.speed"
                        :breakpoints="latestBeatsSwiperOptions.breakpoints"
                        :spaceBetween="latestBeatsSwiperOptions.spaceBetween"
                    >
                        <swiper-slide v-for="beat in latestBeats.data" :key="beat.id">
                            <BeatCard :beat="beat"/>
                        </swiper-slide>
                    </swiper>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev latest-beats"></div>
                <div class="swiper-button-next latest-beats"></div>
            </div>
        </div>
        <!-- Latest Beat Tracks END -->

        <!-- Player overlay  START-->
        <div class="main-player container-fluid">
            <!-- Duration -->
            <form id="pr-progress" class="col-lg-12 nopadding">
                <input id="song-duration" type="range" min="0" max="100"/>
            </form>

            <div class="row">
                <div class="left-block col-lg-4">
                    <!-- Song Image -->
                    <div class="pr-song-img col-lg-3 col-sm-2">
                        <img src="images/img3.jpg"/>
                    </div>

                    <div class="pr-song-info col-lg-7">
                        <p>African afrobeat danceall beatz</p>
                        <span>Pixel da beatzz</span>
                    </div>
                    <a
                        href="javascript:void(0)"
                        class="cr-price-btn"
                        onclick="openModal()"
                    >
                        <img src="data/Icon-shopping-cart.svg"/>
                        <button>
                            $500
                        </button>
                    </a>
                </div>

                <!-- Player controls -->
                <div class="col-lg-2 offset-lg-2 col-sm-4 offset-sm-2 play-controls">
                    <a href="#"><span class="material-icons">skip_previous</span></a>
                    <a href="#"><img src="data/Group 86.svg"/></a>
                    <a href="#"><span class="material-icons">skip_next</span></a>
                </div>

                <!-- right side block options -->
                <div class="right-block col-lg-2 col-sm-6 offset-lg-2 col-md-5">
                    <ul>
                        <li>
                            <a href="#"><img src="data/download-icon.svg"/></a>
                        </li>
                        <li>
                            <a href="#"><span class="material-icons">repeat</span></a>
                        </li>
                        <li>
                            <a href="#"><img src="data/add-icon.svg"/></a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="track-menu-li mp-icon"
                            ><img src="data/Component 13 – 5.svg"
                            /></a>
                        </li>
                        <li>
                            <a id="song-playlist-i" href="javascript:void(0)"
                            ><span class="material-icons">queue_music</span></a
                            >
                        </li>
                    </ul>
                    <!-- Menu option on Main player -->
                    <div class="track-menu t-menu-2">
                        <ul>
                            <li><a href="#">Play</a></li>
                            <li><a href="#">Add To Cart</a></li>
                            <li><a href="#">View Producer</a></li>
                            <li><a href="#">Add to playlist</a></li>
                            <li><a href="#">Comment</a></li>
                            <li><a href="#">Share</a></li>
                        </ul>
                    </div>

                    <!-- Songs on playlist -->
                    <div id="pl-songlist" class="col-lg-3 col-md-7">
                        <div id="pl-hdr">
                            <p>playing queue</p>
                            <button class="pl-close-btn">
                                <span class="material-icons">clear</span>
                            </button>
                        </div>

                        <div class="songs-list">
                            <!-- Song 1 -->
                            <div class="pl-song">
                                <span class="pl-count">1</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 2 -->
                            <div class="pl-song">
                                <span class="pl-count">2</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 3 -->
                            <div class="pl-song">
                                <span class="pl-count">3</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 4 -->
                            <div class="pl-song">
                                <span class="pl-count">5</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 5 -->
                            <div class="pl-song">
                                <span class="pl-count">5</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 6 -->
                            <div class="pl-song">
                                <span class="pl-count">6</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 2 -->
                            <div class="pl-song">
                                <span class="pl-count">2</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 3 -->
                            <div class="pl-song">
                                <span class="pl-count">3</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 4 -->
                            <div class="pl-song">
                                <span class="pl-count">5</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 5 -->
                            <div class="pl-song">
                                <span class="pl-count">5</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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

                            <!-- Song 6 -->
                            <div class="pl-song">
                                <span class="pl-count">6</span>
                                <div class="pl-song-img col-lg-3 col-md-3 col-sm-2">
                                    <img src="images/img5.jpg"/>
                                </div>

                                <div class="pl-song-name">
                                    <p>African afrobeat danceall beatz</p>
                                    <span>Pixel da beatzz</span>
                                </div>

                                <a
                                    href="javascript:void(0)"
                                    class="track-menu-li"
                                    onclick="showListPLMenu(this)"
                                ><img src="data/horizontal-menu-i.svg"
                                /></a>

                                <!-- Menu option on Main player -->
                                <div class="track-menu t-menu-2">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Player overlay  END-->

        <!-- Find Producer START-->
        <div id="find-producer-sec" class="container-fluid">
            <div id="find-pro-data" class="col-lg-5 col-md-10">
                <h2>
                    Commission a Producer,<br/>
                    Get the best producer to make your next hit song
                </h2>

                <p>
                    Afrobeats is here to stay and we are proud to be the largest hub for
                    Afrobeats music producers so if you are looking for that authentic
                    Afrobeat sound, you have come <br/>to the right place.
                </p>

                <Link id="find-pro-btn" href="/explore/producers">
                    <button>Find Producer</button>
                </Link>
            </div>
        </div>
        <!-- Find Producer END-->

        <!-- Popular Producer START-->
        <div id="wrapper-3" class="container-fluid">
            <h3 class="wrapper-hdr">Popular Producers</h3>

            <!--Style section -->
            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper col-lg-12 nopadding">
                    <swiper
                        v-if="popularProducers"
                        ref="popularProducers"
                        :pagination="producerSwiperOptions.pagination"
                        :navigation="producerSwiperOptions.navigation"
                        :speed="producerSwiperOptions.speed"
                        :breakpoints="producerSwiperOptions.breakpoints"
                        :spaceBetween="producerSwiperOptions.spaceBetween"
                    >
                        <swiper-slide
                            v-for="producer in popularProducers.data"
                            :key="producer.id"
                        >
                            <ProducerCard :producer="producer"/>
                        </swiper-slide>
                    </swiper>
                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev popular-producers"></div>
                <div class="swiper-button-next popular-producers"></div>
            </div>
        </div>
        <!-- Popular Producer END-->

        <!-- Sell Beat Section START-->
        <div class="sell-beat-sec container-fluid">
            <div id="sell-b-data">
                <h2>
                    Sell Your Beats, <br/>
                    Start making money selling your beats
                </h2>

                <p>
                    Afrobeats is here to stay and we are proud to be the largest hub for
                    Afrobeats music <br/>
                    producers so if you are looking for that authentic Afrobeat sound, you
                    have come to <br/>
                    the right place.
                </p>

                <Link id="sell-b-btn" href="/upload">
                    <button>Sell Beat</button>
                </Link>
            </div>
        </div>
        <!-- Sell Beat Section END-->

        <!-- Promotion/Download App Section START-->
        <div id="promo-sec" class="container-fluid">
            <div id="promo-data" class="col-lg-5">
                <h1>Your All in One <span> Beat </span> Tracks App</h1>
                <p>
                    Listen to beats, buy and sell beats, and chat and enjoy live session
                    all from Thathrowdown app!
                </p>

                <div>
                    <a href="#"><img src="data/play-store-i.svg"/></a>
                    <a href="#"><img src="data/app-store-i.svg"/></a>
                </div>
            </div>
            <div id="promo-img"></div>
        </div>
        <!-- Promotion/Download App Section END-->

        <!-- Newsletter Section START-->
        <div id="news-letter" class="container-fluid">
            <h2>SUBSCRIBE TO OUR NEWSLETTER</h2>
            <p>
                Yes! Send me personalized tips for shopping and selling on Thathrowdown
                beats.
            </p>

            <div id="news-letter-input" class="col-lg-5 col-md-8 col-sm-10">
                <form>
                    <span id="mail-i" class="material-icons">local_post_office</span>
                    <input
                        id="news-input"
                        type="text"
                        name=""
                        placeholder="Enter Email Address"
                    />
                    <input id="news-sub-btn" type="submit" name="" value="Subscribe"/>
                </form>
            </div>
        </div>
        <!-- Newlater Section END-->
    </section>
</template>

<style scoped>
</style>

<script>
import Default from "@/Layouts/Default";
import ProducerCard from "@/Components/ProducerCard";
import BeatCard from "@/Components/BeatCard";
import 'swiper/swiper.scss';
import {Link, useForm} from "@inertiajs/inertia-vue3";

// import Swiper core and required modules
import SwiperCore, { Navigation } from 'swiper';

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/swiper.scss';
import 'swiper/components/navigation/navigation.scss';

// install Swiper modules
SwiperCore.use([Navigation]);


export default {
    layout: Default,
    components: {
        BeatCard,
        ProducerCard,
        Swiper,
        SwiperSlide,
        Link
    },

    props: {
        auth: Object,
        canLogin: Boolean,
        canRegister: Boolean,
        errors: Object,
        trendingBeats: Object,
        latestBeats: Object,
        popularProducers: Object,
    },
    data() {
        return {
            swiperOptions: {
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: {
                    nextEl: '.swiper-button-next.trending-beats',
                    prevEl: '.swiper-button-prev.trending-beats',
                },
                spaceBetween: 30,
                speed: 400,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1600: {
                        slidesPerView: 6,
                    },
                },
                // Some Swiper option/callback...
            },
            latestBeatsSwiperOptions: {
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: {
                    nextEl: '.swiper-button-next.latest-beats',
                    prevEl: '.swiper-button-prev.latest-beats',
                },
                spaceBetween: 30,
                speed: 400,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1600: {
                        slidesPerView: 6,
                    },
                },
                // Some Swiper option/callback...
            },
            producerSwiperOptions: {
                pagination: {
                    el: '.swiper-pagination',
                },
                navigation: {
                    nextEl: '.swiper-button-next.popular-producers',
                    prevEl: '.swiper-button-prev.popular-producers',
                },
                spaceBetween: 3,
                slidesPerView: 2,
                speed: 400,
                breakpoints: {
                    640: {
                        slidesPerView: 6,
                    },
                    768: {
                        slidesPerView: 4,
                    },
                    1024: {
                        slidesPerView: 5,
                    },
                    1600: {
                        slidesPerView: 6,
                    },
                },
                // Some Swiper option/callback...
            },
            showAddToCartModal: false,
            beatToAdd: null,
        }
    },
    setup() {
        const searchForm = useForm({
            term: null,
            section: 'all'
        })

        const submit = () => {
            let url = '/explore'
            if (searchForm.section !== 'all') {
                url += `/${searchForm.section}`
            }

            url += `?term=${searchForm.term}`

            searchForm.get(url)
        }

        return {
            searchForm,
            submit
        }
    }
}
</script>
