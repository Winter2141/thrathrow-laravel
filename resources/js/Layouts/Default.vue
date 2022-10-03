<template>
    <div>
        <notifications/>
        <header class="container-fluid">
            <div class="row">
                <!-- Logo -->
                <div id="logo" class="col-lg-1 col-md-2 col-sm-3 col-4">
                    <Link href="/"
                    ><a><img src="/images/Group 274@2x.png"/></a
                    ></Link>
                </div>

                <!-- Search on navigation bar -->
                <div class="search-bar col-lg-4 col-md-3 col-sm-8 col-8">
                    <div class="col-sm-12">
                        <form class="nav-srch" method="get" @submit.prevent="submit">
                            <img id="n-srch-i" src="/data/search-i.svg"/>
                            <!--                            <a href="search.html" class="srch-link">-->
                            <input
                                id="search-input"
                                type="text"
                                name=""
                                placeholder="Search"
                                class="none"
                                v-model="searchForm.term"
                            />
                            <!--                            </a>-->

                            <!-- search options -->
                            <div id="search-options" class="search-options none">
                                <select v-model="searchForm.section">
                                    <option value="all">All</option>
                                    <option value="beats">Beats</option>
                                    <option value="producers">Producers</option>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </form>
                    </div>

                    <!-- Hamburger Menu icon -->
                    <button id="ham-btn">
                        <div id="nav-icon3">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>

                <!-- Navigation Links and Icons -->
                <div id="nav-li-i" class="col-lg-6 col-md-7 offset-lg-1">
                    <div class="row">
                        <div class="nav-li-1 col-lg-6 col-md-7 col-sm-12 nopadding">
                            <Link href="/">
                                <a>
                                    <div :class="{ 'nav-circle': $page.props.currentRoute === 'home' }"></div>
                                    <span>Home</span>
                                </a>
                            </Link>

                            <Link href="/explore">
                                <a>
                                    <div
                                        :class="{ 'nav-circle': $page.props.currentRoute.startsWith('explore') }"
                                    ></div>
                                    <span>Explore</span>
                                </a>
                            </Link>

                            <Link v-if="$page.props.auth.user" href="/upload">
                                <a class="n-upload-btn"> Upload </a>
                            </Link>
                        </div>

                        <div class="nav-li-2 col-lg-6 col-md-5">
                            <!-- Cart Icon -->
                            <a id="cart-icon" href="/cart">
                                <span class="material-icons"> shopping_cart </span>
                                <p v-if="cart && cart.beats" class="cart-num">
                                    {{ cart.beats.length }}
                                </p>
                            </a>

                            <!-- Notification Icon -->
                            <div id="nt-i" v-if="currentUser">
                                <a href="javascript:void(0)"
                                ><i id="nt-i2" class="fas fa-bell"></i
                                ></a>

                                <!-- Notifications Box -->
                                <div id="notification-box">
                                    <span class="material-icons nt-arrow-up">arrow_drop_up</span>

                                    <Link href="/notifications">
                                        <div id="msg-box">
                                            <img src="/data/msg-i.svg" class="msg-i"/>

                                            <div class="msg-contents">
                                                <p>Inbox</p>
                                                <p>{{ notifications.total }} unread messages</p>
                                            </div>
                                        </div>
                                    </Link>
                                    <hr class="nt-line"/>

                                    <!-- Notifications list -->
                                    <div class="nt-item-b">
                                        <!-- Notifications 1 -->
                                        <Link :href="`/notifications/${notification.id}`" class="nt-item" v-for="notification in notifications.content"  :key="notification.id">
                    <span class="material-icons nt-dot"
                    >radio_button_checked</span
                    >

                                                <p class="nt-txt"> {{ notification.data.title }} </p>
                                                <span class="nt-time">{{ luxon.fromISO(notification.created_at).toRelative() }}</span>
                                        </Link>
                                    </div>
                                </div>
                            </div>

                            <!-- User profile Icon -->
                            <a v-if="$page.props.auth.user" id="dropdown-m" class="n-account-i"
                               @click="showMenu = !showMenu"
                            ><i id="dropdown-icon" class="fas fa-user"></i
                            ></a>

                            <!-- Dorpdown menu for User -->
                            <div
                                v-if="currentUser"
                                id="nav-dropdown"
                                :class="[showMenu ? 'pr_show' : '']"
                                @click="showMenu = false"
                            >
                                <!-- User profile pic and Name here -->
                                <div id="usr-img-name">
                                    <a href="user_profile.html">
                                        <div class="usr-img">
                                            <img :src="currentUser.profile_image_url"/>
                                        </div>
                                        <span class="user-name">{{ currentUser.name }}</span>
                                    </a>
                                </div>

                                <!-- Wallet Balance -->
                                <p id="wallet-bl">Wallet Balance: <span>0$</span></p>
                                <div class="nav-hr row"></div>

                                <div class="dropdown-links">
                                    <!-- Link 1 -->
                                    <div>
                                        <Link href="/my_beats">
                                            <span><i class="fas fa-music"></i></span>
                                            <p>My Beats</p>
                                        </Link>
                                    </div>
                                    <!-- Link 2 -->
                                    <div>
                                        <a href="my_playlist.html">
                                            <span class="material-icons">queue_music</span>
                                            <p>My Playlist</p>
                                        </a>
                                    </div>
                                    <!-- Link 3 -->
                                    <div>
                                        <a href="my_wallet.html">
                                            <span><i class="fas fa-wallet"></i></span>
                                            <p>My Wallet</p>
                                        </a>
                                    </div>
                                    <!-- Link 1 -->
                                    <div>
                                        <Link href="/purchases">
                                            <span><i class="fas fa-shopping-basket"></i></span>
                                            <p>Purchases</p>
                                        </Link>
                                    </div>
                                </div>

                                <div class="nav-hr2 row"></div>

                                <div class="dropdown-links">
                                    <!-- Link 1 -->
                                    <div>
                                        <a href="#">
                    <span
                    ><img src="/data/Icon ionic-ios-paper.svg"
                    /></span>
                                            <p>Terms & Conditions</p>
                                        </a>
                                    </div>
                                    <!-- Link 2 -->
                                    <div>
                                        <a href="#">
                                            <span class="material-icons">visibility</span>
                                            <p>Privacy Policy</p>
                                        </a>
                                    </div>
                                    <!-- Link 3 -->
                                    <div>
                                        <a @click.prevent="logout">
                                            <span class="material-icons">logout</span>
                                            <p>Logout</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="!$page.props.auth.user" class="nav-li-1 col-lg-6 col-md-7 col-sm-12 nopadding">
                            <Link href="/login">
                                <a> <span>Login</span> </a>
                            </Link>
                            <Link href="/register">
                                <a>
                                    <span>Register</span>
                                </a>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <slot/>
        </main>

        <footer v-if="$page.props.currentRoute === 'home'">
            <div class="row">
                <div id="bl-1" class="col-lg-3 col-md-3 col-sm-6">
                    <h2>ThaThrowDown</h2>

                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li>
                            <Link href="/login">
                                <a>Sign In</a>
                            </Link>
                        </li>
                        <li>
                            <Link href="/register">
                                <a>Create Account</a>
                            </Link>
                        </li>
                    </ul>
                </div>

                <div id="bl-2" class="col-lg-3 col-md-3 col-sm-6">
                    <h2>Explore</h2>

                    <ul>
                        <li><a href="#">beats</a></li>
                        <li><a href="#">Hire Producer</a></li>
                        <li><a href="#">Sell beats</a></li>
                    </ul>
                </div>

                <div id="bl-3" class="col-lg-3 col-md-3 col-sm-6">
                    <h2>Legal</h2>

                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Disclaimer</a></li>
                    </ul>
                </div>

                <div id="bl-4" class="col-lg-3 col-md-3 col-sm-6">
                    <h2>Download App</h2>

                    <div id="bl-4-img">
                        <a href="#"><img src="/data/app-store-i.svg"/></a>
                        <a href="#"><img src="/data/play-store-i.svg"/></a>
                    </div>
                </div>
            </div>
            <div class="row footer-credit">
                <div id="social-medias">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
                <p>
                    Copyright ©{{ new Date().getFullYear() }} All rights reserved by
                    ThaThrowDown.
                </p>
            </div>
        </footer>
    </div>
</template>

<script>

import {Link, useForm} from "@inertiajs/inertia-vue3";
import { DateTime } from "luxon";

export default {
    name: "Default",
    components: {Link},
    data() {
        return {
            showMenu: false,
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
            submit,
            luxon: DateTime
        }
    },
    mounted() {
        /*Header on scroll change background color*/
        window.onscroll = function () {
            var top = window.pageYOffset || document.documentElement.scrollTop;

            if (top > 100) {
                document.querySelector('header').style.background = "#0D0D0D";
            } else {
                document.querySelector('header').style.background = "rgba(13, 13, 13, 0.5)";
            }
        };

        var body = document.querySelector('body');
        body.addEventListener('click', function(e) {

            if(e.srcElement.closest('#nav-dropdown') === null && (e.srcElement.id !== 'dropdown-m' && e.srcElement.id !== 'dropdown-icon') ){
                document.getElementById("nav-dropdown").classList.remove("pr_show");
            }

            if(e.srcElement.closest('#notification-box') === null && (e.srcElement.id !== 'nt-i2' && e.srcElement.id !== 'nt-i') ){
                document.getElementById("notification-box").classList.remove("nt-show");
            }
            if(e.target.closest('#chat-dropdown') === null && (e.target.id !== 'ch-m-btn') ){
                if (document.getElementById("chat-dropdown")) {
                    document.getElementById("chat-dropdown").classList.remove("chat-dropdown-show");
                }

                if (document.querySelector("#ch-m-btn")) {
                    document.querySelector("#ch-m-btn").classList.remove("chat-menu-ch");
                }
            }
        })
    },
    computed: {
        currentUser() {
            return this.$page.props.auth.user ? this.$page.props.auth.user.data : null
        },
        notifications() {
            return this.$page.props.notifications
        }
    }
}
</script>

<style scoped>

</style>
