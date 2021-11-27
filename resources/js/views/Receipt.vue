<template>

    <div>
        <spin v-if="loading"/>
        <div v-else-if="!loading && !not_found">
            <div class="content__container">
                <div class="content__header">
                    <div class="content__header__keys__wrapper">
                        <div class="content__header__keys__inner">
                            <span class="content__header__key">
                                <a href="">
                                    <span class="content__header__key-info">{{ receipt[0].category }}</span>
                                     <span class="content__header__key-dot"></span>
                                </a>
                            </span>
                            <span class="content__header__key">
                                <a href="">
                                    <span class="content__header__key-info">{{ receipt[0].kitchen }}</span>
                                </a>
                            </span>
                        </div>
                    </div>

                    <div class="content__header__title__wrapper">
                        <span class="content__header__title__inner">
                            <h1 class="content__header__title">{{ receipt[0].name }}</h1>
                        </span>
                    </div>

                    <div class="content__header__options">
                        <div class="content__header__left">
                            <span class="content__header__time__wrapper">
                                <span uk-icon="clock" class="content__header__time-icon"></span>
                                <span class="content__header__time" v-if="receipt[0].cooking_hours != null && receipt[0].cooking_hours != 0">
                                    {{ receipt[0].cooking_hours }} год.
                                </span>
                                <span class="content__header__time" v-if="receipt[0].cooking_minutes != null && receipt[0].cooking_minutes != 0">
                                    &nbsp;{{ receipt[0].cooking_minutes }} хв.
                                </span>
                            </span>
                        </div>

                        <div class="content__header__add-receipt-btn__wrapper">
                            <button type="button" class="content__header__add-receipt-btn">
                                <span uk-icon="bookmark" class="receipt__content__options__btn__icon"></span>
                                Добавить в книгу рецептов
                                <span class="content__header__add-receipt-btn__count">1</span>
                            </button>
                        </div>

                        <div class="content__header__rate__wrapper">
                            <div class="content__header__rate__inner">
                                <button type="button" class="content__header__rate__like-btn">
                                    <i class="fal fa-thumbs-up content__header__rate__icon content__header__rate__icon__like__active"></i>
                                </button>
                                <span class="content__header__rate__like-count">55</span>

                                <button type="button" class="content__header__rate__like-btn">
                                    <i class="fal fa-thumbs-down content__header__rate__icon content__header__rate__icon__dislike__active"></i>
                                </button>
                                <span class="content__header__rate__dislike-count">16</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content__receipt__main-img__container">
                    <img class="content__receipt__main-img" src="https://storge.pic2.me/c/1360x800/575/586198aedc963.jpg" alt="">
                </div>
            </div>

            <div class="content__user-info__container">
                <div class="content__user-info__inner">
                    <div class="content__user-info__aligner">
                        <span class="content__user-info__section-text__header">Автор рецепту</span>

                        <div class="content__user-info__user-content__container">
                            <a href="">
                                <div class="content__user-info__user-content__inner">
                                    <div class="content__user-info__user-content__img__aligner">
                                        <img class="content__user-info__user-content__img" src="https://agile.yakubovsky.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" alt="">
                                    </div>
                                    <div class="content__user-info__user-content__info__container">
                                        <span class="content__user-info__user-content__info__author">Автор: Алексей Скобелев</span>
                                        <span class="content__user-info__user-content__info__receipts">2 рецепта</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="content__user-info__subscription__container">
                            <button type="button" class="content__user-info__subscription">Підписатися</button>
                        </div>

                    </div>
                </div>
            </div>

            <div class="content__user-info__container">
                <span class="content__advice">{{ receipt[0].advice }}</span>
            </div>

            <div class="content__user-info__container">
                <div class="content__ingradients__container">

                    <div class="content__ingradients__header__container">
                        <div class="content__ingradients__header__wrapper">
                            <span class="content__ingradients__header">Інградієнти</span>
                        </div>
                    </div>

                    <div v-for="item of ingradients" class="content__ingradients__item__container">
                        <div class="content__ingradients__item__inner">
                            <div class="content__ingradients__item__name__container">
                                <span class="content__ingradients__item__name">{{ item.ingradient }}</span>
                            </div>
                            <span class="content__ingradients__item__line-aligner"></span>
                            <span class="content__ingradients__item__cost">{{ item.count_ingradient }} {{ item.type_measuring }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content__steps__container">
                <div class="content__steps__wrapper">
                    <div class="content__steps__header__container">

                        <div class="content__steps__header__left__container">
                            <span class="content__steps__header__left__text">
                                Інструкція по приготуванню
                            </span>
                        </div>

                        <div class="content__steps__header__right__container">
                            <span class="content__header__time__wrapper">
                                <span uk-icon="clock" class="content__header__time-icon"></span>
                                <span class="content__header__time" v-if="receipt[0].cooking_hours != null && receipt[0].cooking_hours != 0">
                                    {{ receipt[0].cooking_hours }} год.
                                </span>
                                <span class="content__header__time" v-if="receipt[0].cooking_minutes != null && receipt[0].cooking_minutes != 0">
                                    &nbsp;{{ receipt[0].cooking_minutes }} хв.
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="content__steps__step__container">

                        <div class="content__steps__step__img__container">
                            <div class="content__steps__step__img__aligner">
                                <img class="content__steps__step__img" alt="" src="https://eda.ru/img/eda/c434x295/s1.eda.ru/StaticContent/Photos/110811142241/1703141651290/p_O.png">
                            </div>
                        </div>

                        <div class="content__steps__step__info__container">
                            <div class="content__steps__step__info__inner">
                                <div class="content__steps__step__info__aligner">
                                    <span class="content__steps__step__info__count">1</span>
                                    <span class="content__steps__step__info__text">
                                        Всыпьте в творог 5 столовых ложек (с горкой) муки и тщательно перемешайте. Можно добавить немного больше муки, сырники получатся тогда более плотными. Или муки можно добавить чуть меньше, и тогда сырники будут нежнее. В итоге у вас должна получиться однородная масса, из которой можно будет лепить сырники.
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>


            <div class="comments__container" v-if="userId">
                <div>
                    <form id="form-logout" enctype="multipart/form-data">
                        <div class="comments__row"></div>
    <!--                    <p>{{ userId }}</p>-->
                        <textarea placeholder="Добавить комментарий" v-model="comment" name="input" autocomplete="on" class="comments__textarea"></textarea>

                        <div class="comments__button__wrapper">

                            <button type="button" class="comments__button" @click.prevent="sendComment">Отправить</button>


                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div uk-alert v-if="not_found">
            <a class="uk-alert-close" uk-close></a>
            <h3>Не знайдено!!!</h3>
        </div>
    </div>
</template>

<script>
import Spin from "../components/Spin";
import axios from "axios";
export default {
    components: {
        Spin
    },
    data: () => ({
        loading: true,
        userId: Number,
        receipt: Object,
        ingradients: [],
        not_found: false,
        comment: ""
    }),
    mounted() {
        this.loadReceipt(this.$route.params.id)
        this.checkAuth()
        console.log(this.userId)
    },
    methods: {
        loadReceipt(id) {
            axios.get('/api/receipts/' + id)
            .then(res => {
                this.receipt = res.data.receipt;
                this.ingradients = res.data.ingradients;
                // console.log(this.receipt[0].id);
                this.loading = false;
            })
            .catch(err => {
                this.not_found = true;
                this.loading = false;
            })
        },
        checkAuth() {
            axios.get('/getAuthStatus')
                .then(response => {
                    this.userId = response.data;
                    console.log(this.userId)
                })
                .catch(error => console.log("error"));

        },
        sendComment() {
            const data = new FormData();

            data.append('comment', this.comment);
            data.append('id_receipt', this.receipt[0].id);
            data.append('id_user', this.userId);
            this.comment = "";
            axios.post('/addComment', data)
                .then(res => {
                    // console.log(res.data);
                    if (res.data.status) {

                        this.$router.push('/receipt/' + this.receipt[0].id);


                    } else {
                        setTimeout(() => {
                            this.loading = false;
                        }, 300);
                    }
                })

        }
    }
}
</script>

<style scoped>

</style>
