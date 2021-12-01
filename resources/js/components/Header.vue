<template>
    <div>
    <div class="nav__container">

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
            <div class="nav__user-navbar__item_search__container nav__user-navbar__item">
<!--                <form method="POST" action="{{ route('receiptSearch') }}">-->
                    <i class="fas fa-search nav__user-navbar__item_search"></i>
                    <span class="nav__user-navbar__item_search__text">Пошук по сайту</span>
<!--                </form>-->
            </div>
        </div>

        <div class="nav__user-navbar__container" v-if="!isAuth">
            <div class="nav__user-navbar__item_search__container nav__user-navbar__item nav__user-navbar__item_border">
                <div class="nav__user-navbar__item__link-bookmark__container">
                    <i class="fas fa-bookmark nav__user-navbar__item__link-bookmark"></i>
                    <span class="nav__user-navbar__item__link-bookmark__text">Моя книга рецептів</span>
                </div>
            </div>
        </div>
        <div class="nav__user-navbar__container" v-if="isAuth">
            <router-link :to="savedHref">
                <div class="nav__user-navbar__item_search__container nav__user-navbar__item nav__user-navbar__item_border">
                    <div class="nav__user-navbar__item__link-bookmark__container">
                        <i class="fas fa-bookmark nav__user-navbar__item__link-bookmark"></i>
                        <span class="nav__user-navbar__item__link-bookmark__text">Моя книга рецептів</span>
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


    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">

            <ul class="uk-navbar-nav">
                <li v-for="link in links">
                    <router-link :to="link.href">{{ link.title }}</router-link>
                </li>
            </ul>

        </div>
    </nav>
    </div>
</template>

<script>
import axios from "axios";


export default {




    data() {

        return {
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

    mounted() {
        this.checkAuth()
    },
    methods: {
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

<style scoped>

</style>
