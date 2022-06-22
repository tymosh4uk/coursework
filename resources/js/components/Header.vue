<template>
    <div style="position: relative; background-color: #fff; box-shadow: 0 0 15px rgb(0 0 0 / 15%); z-index: 5;">
        <div class="nav__container" v-if="!mobile">

            <a href="" class="nav-line__logo__wrapper">
                <i class="fas fa-hat-chef"></i>
            </a>

            <div class="nav__top-line__container">
                <ul class="nav__navbar">
                    <li class="nav__navbar__li" v-for="link in links">
                        <router-link :to="link.href">{{ link.title }}</router-link>
                    </li>
                </ul>
            </div>

            <div class="nav__user-navbar__container">
                <router-link :to="'/find'">
                    <div class="nav__user-navbar__item_search__container nav__user-navbar__item">
                        <!--                <form method="POST" action="{{ route('receiptSearch') }}">-->
                        <i class="fas fa-search nav__user-navbar__item_search"></i>
                        <span class="nav__user-navbar__item_search__text">Пошук</span>
                        <!--                </form>-->
                    </div>
                </router-link>
            </div>

            <div class="nav__user-navbar__container" v-if="!isAuth">
                <div class="nav__user-navbar__item_search__container nav__user-navbar__item nav__user-navbar__item_border">
                    <div class="nav__user-navbar__item__link-bookmark__container">
                        <i class="fas fa-bookmark nav__user-navbar__item__link-bookmark"></i>
                        <span class="nav__user-navbar__item__link-bookmark__text">Книга рецептів</span>
                    </div>
                </div>
            </div>
            <div class="nav__user-navbar__container" v-if="isAuth">
                <router-link :to="savedHref">
                    <div class="nav__user-navbar__item_search__container nav__user-navbar__item nav__user-navbar__item_border">
                        <div class="nav__user-navbar__item__link-bookmark__container">
                            <i class="fas fa-bookmark nav__user-navbar__item__link-bookmark"></i>
                            <span class="nav__user-navbar__item__link-bookmark__text">Книга рецептів</span>
                        </div>
                    </div>
                </router-link>
            </div>



            <div class="nav__user-navbar__container" v-if="!isAuth">
                <div class="nav__user-navbar__item_enter__container nav__user-navbar__item nav__user-navbar__item_border">
                    <a href="/login" class="nav__user-navbar__item_enter__link">
                        <i class="fas fa-hat-chef"></i>
                        <span>Увійти</span>
                    </a>
                </div>
            </div>

            <div class="nav__user-navbar__container" v-if="isAuth">
                <div class="nav__user-navbar__item_enter__container nav__user-navbar__item nav__user-navbar__item_border">
                    <a href="/login" class="nav__user-navbar__item_enter__link">
                        <img class="header_user_img" :src="'img/camera.png'" alt="Nazariy">
                        <span>{{ userName }}</span>
                    </a>
                    <div uk-drop="pos: bottom-justify">
                        <div class="uk-card uk-card-body uk-card-default" style="padding: 20px 10px; width: 130px">
                            <form id="form-logout" enctype="multipart/form-data">
                                <button class="uk-button uk-button-danger" @click.prevent="logout">

                                    <span>Вийти</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav__user-navbar__container">
                <div class="nav__user-navbar__item_add__container nav__user-navbar__item">
                    <a href="/createReceipt" class="nav__user-navbar__item_add__link">Додати рецепт</a>
                </div>
            </div>

        </div>
        <div class="nav__container" v-if="mobile">
            <header :class="{ 'scrolled-nav':scrolledNav }">
                <nav class="custom-navigation" >
                    <a href="" class="nav-line__logo__wrapper">
                        <i class="fas fa-hat-chef"></i>
                    </a>
                    <div class="icon">
                        <i @click="toggleMobileNav" v-show="mobile" class="far fa-bars" :class="{'icon-active' : mobileNav }"></i>
                    </div>
                    <div v-show="mobileNav" class="dropdown-nav__background" @click="toggleMobileNav">
                    </div>
                    <transition name="mobile-nav">

                        <ul v-show="mobileNav" class="dropdown-nav" style="">
                            <li class="nav__navbar__li" v-for="link in links">
                                <router-link :to="link.href">{{ link.title }}</router-link>
                            </li>

                            <li class="nav__navbar__li" >
                                <router-link :to="'/find'">
                                      ПОШУК
                                </router-link>
                            </li>
                            <div v-if="!isAuth">
                                <li class="nav__navbar__li" >
                                    <a href="/">Книга рецептів</a>

                                </li>
                            </div>
                            <div  v-if="isAuth">
                                <li class="nav__navbar__li" >
                                    <router-link :to="savedHref">
                                        Книга рецептів
                                    </router-link>
                                </li>
                            </div>
                            <div class="nav__user-navbar__container">
                                <div class="nav__user-navbar__item_add__container nav__user-navbar__item" style="width: 100%; text-align: center;">
                                    <a href="/createReceipt" class="nav__user-navbar__item_add__link" style="justify-content: center">Додати рецепт</a>
                                </div>
                            </div>
                        </ul>
                    </transition>
                </nav>
            </header>
        </div>


<!--        <nav class="uk-navbar-container" uk-navbar>-->
<!--            <div class="uk-navbar-left">-->

<!--                <ul class="uk-navbar-nav">-->
<!--                    <li v-for="link in links">-->
<!--                        <router-link :to="link.href">{{ link.title }}</router-link>-->
<!--                    </li>-->
<!--                </ul>-->

<!--            </div>-->
<!--        </nav>-->
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            isAuth: Boolean,
            userName: Object,
            scrolledNav: null,
            mobile: null,
            mobileNav: null,
            windowWidth: null,
            savedHref: "/saved",
            links: [
                {
                    title: "Головна",
                    href: "/"
                },
                {
                    title: "Рецепти",
                    href: "/recepty"
                },
                {
                    title: "Створити авторську ідею",
                    href: "/createIdea"
                }
            ]
        }
    },
    created() {
        window.addEventListener('resize', () => this.checkScreen());
        window.addEventListener('onclick', () => this.mobileNav = false);
        this.checkScreen();
    },
    mounted() {
        this.checkAuth();
        window.addEventListener('scroll', () => this.updateScroll);
    },
    methods: {
        toggleMobileNav() {
            this.mobileNav = !this.mobileNav;
        },

        updateScroll() {
            const scrollPosition = window.scrollY;
            if(scrollPosition > 50) {
                this.scrolledNav = true;
                return;
            }
            this.scrolledNav = false;
        },

        checkScreen() {
            this.windowWidth = window.innerWidth;
            if(this.windowWidth <= 750) {
                this.mobile = true;
                return;
            }
            this.mobile = false;
            this.mobileNav = false;
            return;
        },

        logout() {
            axios.post('logout')
                .then(res => {
                    //console.log(res.data);
                    window.location.reload();
                })
        },
        checkAuth() {
            axios.get('is-auth')
                .then(response => {
                    if(response.data.auth) {
                        //console.log(response.data.login);
                        this.isAuth = response.data.login;
                    }
                    if(this.isAuth) {
                        this.userName = response.data.name;
                    }
                    this.isAuth = response.data.login;
                    //console.log(response.data.login);
                    // this.isAuth = true;
                    //console.log("logged in");
                })
                .catch(error => console.log("error"));
        }
    }
}
</script>

<style lang="scss" scoped>
    .custom-navigation {
        height: auto;
        line-height: inherit;
    }

    .dropdown-nav__background {
        background-color: #000000;
        opacity: 0.6;
        width: 100vw;
        height: 100vh;
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
    }

    header {
        z-index: 99;
        background-color: rgba(0, 0, 0, 0.05);
        width: 100%;
        position: fixed;
        transition: .5s ease all;
    }

    nav {
        z-index: 99;
        position: relative;
        display: flex;
        flex-direction: row;
        padding: 12px 0;
        transition: .5s ease all;
        margin: 0 auto;

        @media(min-width: 1140px) {
            max-width: 1140px;
        }

        ul, .link {
            z-index: 99;
            list-style: none;
            text-decoration: none;
        }

        li  {
            z-index: 99;
            text-transform: uppercase;
            margin-left: 16px;
        }

        .link {
            z-index: 99;
            transition: .5s ease all;
            padding-bottom: 4px;
            border-bottom: 1px solid transparent;
        }

        &:hover {
            color: #00afea;
            border-color: #00afea;
        }
        .nav-line__logo__wrapper {
            z-index: 99;
            display: flex;
            align-items: center;
            a i{
                transition: .5s ease all;

            }
        }
    }

    .icon {
        z-index: 99;
        display: flex;
        align-items: center;
        position: absolute;
        top: 0;
        right: 24px;
        height: 100%;

        i {
            cursor: pointer;
            transition: .8s ease all;
        }
    }

    .icon-active {
        z-index: 99;
        transform: rotate(180deg);
    }

    .dropdown-nav {
        z-index: 99;
        display: flex;
        flex-direction: column;
        position: fixed;
        width: 100%;
        max-width: 250px;
        background-color: rgba(0, 0, 0, 0.05);
        top: 0;
        left: 0;
        background-color: #fff;
        height: 100vh;
        box-shadow: inset -19px 0px 16px -16px rgba(0,0,0,0.23);
        li {
            margin-left: 0;


        }
    }

    .mobile-nav-enter-active,
    .mobile-nav-leave-active {
        transition: 1s ease all;
    }

    .mobile-nav-enter-to,
    .mobile-nav-leave-from {
        transform: translateX(0px);
    }

    .mobile-nav-enter-from,
    .mobile-nav-leave-to {
        transform: translateX(-250px);
    }

    .scrolled-nav {
        z-index: 99;
        background-color: rgba(0, 0, 0, 0.05);
        box-shadow: 0 0 15px rgb(0 0 0 / 15%);

        nav  {
            padding: 8px 0;
        }
    }
</style>
