<template>
    <div class="nav__container">
        <header :class="{ 'scrolled-nav':scrolledNav }">
            <nav class="custom-navigation">
                <a href="" class="nav-line__logo__wrapper">
                    <i class="fas fa-hat-chef"></i>
                </a>
                <ul v-show="!mobile" class="navigation">
                    <li class="nav__navbar__li" v-for="link in links">
                        <router-link class="link" :to="link.href">{{ link.title }}</router-link>
                    </li>
                </ul>
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
                    </ul>
                </transition>
            </nav>
        </header>
    </div>
</template>

<script>
export default {
    data() {
        return {
            scrolledNav: null,
            mobile: null,
            mobileNav: null,
            windowWidth: null,
            isAuth: Boolean,
            userName: Object,
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
                    title: "Создать кухню",
                    href: "/create"
                },
                {
                    title: "Создать рецепт",
                    href: "/createReceipt"
                }
            ]
        }
    },
    created() {
        window.addEventListener('resize', this.checkScreen);
        this.checkScreen();
    },
    mounted() {
        window.addEventListener('scroll', this.updateScroll);
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
        }
    }
};

</script>

<style lang="scss" scoped>
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
