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

                        <div v-if="userId">
                            <div class="content__header__add-receipt-btn__wrapper" v-if="isSaved == 0">
                                <form id="form-addSaved" enctype="multipart/form-data">
                                    <button type="button" class="content__header__add-receipt-btn" @click.prevent="addToSaved(receipt[0].id)">
                                        <span uk-icon="bookmark" class="receipt__content__options__btn__icon"></span>
                                        Добавить в книгу рецептов
                                        <span class="content__header__add-receipt-btn__count">1</span>
                                    </button>
                                </form>
                            </div>
                            <div class="content__header__add-receipt-btn__wrapper" v-if="isSaved != 0">
                                <div class="receipt__content__options__btn__wrapper" style="min-width: 0px; border-color: #af212b;">
                                    <!--                                                    <input style="display: none" type="text" value="{{ record.id }}">-->
                                    <!--                                                    <label style="display: none" v-model="idReceipt">{{  }}</label>-->
                                    <button type="button" class="receipt__content__options__btn" @click.prevent="removeFromSaved(receipt[0].id)">
                                        <div class="receipt__content__options__btn__inner">
                                            <i class="fas fa-bookmark nav__user-navbar__item__link-bookmark"></i>
                                            Додано
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="content__header__add-receipt-btn__wrapper" v-else>
                            <button type="button" class="content__header__add-receipt-btn">
                                <span uk-icon="bookmark" class="receipt__content__options__btn__icon"></span>
                                Добавить в книгу рецептов
                                <span class="content__header__add-receipt-btn__count">2</span>
                            </button>
                        </div>

                        <div class="content__header__rate__wrapper">
                            <div class="content__header__rate__inner">
                                <button type="button" class="content__header__rate__like-btn">
                                    <i class="fal fa-thumbs-up content__header__rate__icon content__header__rate__icon__like__active"></i>
                                </button>
                                <span class="content__header__rate__like-count">3</span>

                                <button type="button" class="content__header__rate__like-btn">
                                    <i class="fal fa-thumbs-down content__header__rate__icon content__header__rate__icon__dislike__active"></i>
                                </button>
                                <span class="content__header__rate__dislike-count">1</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content__receipt__main-img__container">
                    <img class="content__receipt__main-img" :src="'../storage/images/'+ receipt[0].main_img" alt="">
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
                                        <span class="content__user-info__user-content__info__author">Автор: {{ receipt[0].username }} {{ receipt[0].surname }}</span>
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

                    <div v-for="(item, index) of ingradients" class="content__ingradients__item__container">
                        <div class="content__ingradients__item__inner">
                            <div class="content__ingradients__item__name__container" style="cursor: pointer" @mouseover ="toggleActive(index)"
                                 @mouseleave ="untoggleActive()">
                                <span class="content__ingradients__item__name" style="position: relative">{{ item.ingradient }}
<!--                                    <v-btn icon>-->
<!--                                        <v-icon>{{ showPopUp.includes(index) ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>-->
<!--                                     </v-btn>-->
                                    <ReceiptPopUp v-show="showPopUp.includes(index)" :ingragient=item.ingradient :count_ingradient=item.count_ingradient :type_measuring=item.type_measuring />
                                </span>

                            </div>
                            <span class="content__ingradients__item__line-aligner"></span>
                            <span class="content__ingradients__item__cost">{{ item.count_ingradient }} {{ item.type_measuring }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content__user-info__container">
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



                        <div class="content__steps__step__container" v-for="item of steps">

                            <div class="content__steps__step__img__container">
                                <div class="content__steps__step__img__aligner">
                                    <img class="content__steps__step__img" alt="" :src="'../storage/step_images/'+ item.step_image">
                                </div>
                            </div>

                            <div class="content__steps__step__info__container">
                                <div class="content__steps__step__info__inner">
                                    <div class="content__steps__step__info__aligner">
                                        <span class="content__steps__step__info__count">{{ item.step }}</span>
                                        <span class="content__steps__step__info__text">
                                            {{ item.step_description }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <div class="content__user-info__container">
                <div class="comments__container" v-if="userId">
                    <div>
                        <form id="form-logout" enctype="multipart/form-data">
                            <div class="comments__row"></div>
        <!--                    <p>{{ userId }}</p>-->
                            <textarea placeholder="Додати коментарій" v-model="comment" name="input" autocomplete="on" class="comments__textarea"></textarea>

                            <div class="comments__button__wrapper">

                                <button type="button" class="comments__button" @click.prevent="sendComment">Надіслати</button>


                            </div>
                        </form>
                    </div>
                </div>

                <div class="comments__container" v-if="comments != 0">
                    <div class="comments__inner">

                        <div class="comments__header__container">
                            <span class="comments__header">Коментарії</span>
                        </div>

                        <div class="comments__content__container">
                            <div class="comments__content__wrapper">
                                <div class="comments__content__item__container" v-for="commentary in comments">
                                    <div class="comments__content__item__user__container">
                                        <a href="">
                                            <div class="comments__content__item__user__wrapper">
                                                <div class="comments__content__item__user__img__container">
                                                    <div class="comments__content__item__user__img__wrapper">
                                                        <img class="content__user-info__user-content__img" src="https://agile.yakubovsky.com/wp-content/plugins/all-in-one-seo-pack/images/default-user-image.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="comments__content__item__user__info__container">
                                                    <span class="comments__content__item__user__info__name">{{ commentary.name }} {{ commentary.surname }}</span>
                                                    <span class="comments__content__item__user__info__date">{{ commentary.created_at }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="comments__content__item__text__container">
                                        <span class="comments__content__item__text">{{ commentary.comment }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
import ReceiptPopUp from "../components/page/ReceiptPopUp";
import Vue from 'vue';
import Vuetify from 'vuetify';

Vue.use(Vuetify);
export default {
    vuetify: new Vuetify(),
    components: {
        ReceiptPopUp,
        Spin
    },
    data: () => ({
        loading: true,
        userId: Number,
        receipt: Object,
        ingradients: [],
        steps: [],
        not_found: false,
        comment: "",
        comments: "",
        isSaved: "",
        showPopUp: [],
    }),
    mounted() {
        this.loadReceipt(this.$route.params.id)
        this.checkAuth()
        this.getAllComments()
        this.getSavedById()
        // console.log(this.userId)
    },
    methods: {
        toggleActive(index) {
            if (this.showPopUp.includes(index)) {
                this.showPopUp.pop(index);
                return;
            }

            this.showPopUp = [];
            this.showPopUp.push(index);
        },
        untoggleActive() {
            this.showPopUp = [];
        },
        loadReceipt(id) {
            axios.get('/api/receipts/' + id)
                .then(res => {
                    this.receipt = res.data.receipt;
                    this.ingradients = res.data.ingradients;
                    this.steps = res.data.steps;
                    console.log(this.steps);
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
                    // console.log(this.userId)
                })
                .catch(error => console.log("error"));

        },
        getAllComments() {
            axios.get('/getAllComments', {
                params: {
                    receipt: this.$route.params.id
                }
            })
                .then(res => {
                    // console.log(res.data);
                    this.comments = res.data;
                    // this.receipt = res.data.receipt;
                    // this.ingradients = res.data.ingradients;
                    // console.log(this.receipt[0].id);
                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                })
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
                    window.location.reload();
                    if (res.data.status) {

                        this.$router.push('/receipt/' + this.receipt[0].id);


                    } else {
                        setTimeout(() => {
                            this.loading = false;
                        }, 300);
                    }
                })

        },
        addToSaved(receipt) {
            // console.log(receipt);
            const data = new FormData();
            //
            data.append('id_receipt', receipt);
            //
            axios.post('/saveReceipt', data)
                .then(res => {
                    // console.log(res.data);
                    window.location.reload();
                    if (res.data.status) {
                        // this.$router.push('/receipt/' + this.receipt[0].id);
                    }
                    else {
                    }
                })
        },
        getSavedById() {
            axios.get('/getSavedById', {
                params: {
                    receipt: this.$route.params.id
                }
            })
                .then(res => {
                    console.log(res.data);
                    this.isSaved = res.data;
                    // this.receipt = res.data.receipt;
                    // this.ingradients = res.data.ingradients;
                    // console.log(this.receipt[0].id);
                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                })
        },
        removeFromSaved(receipt) {
            const data = new FormData();
            //
            data.append('id_receipt', receipt);
            //
            axios.post('/removeFromSaved', data)
                .then(res => {
                    console.log(res.data);
                    window.location.reload();
                    if (res.data.status) {
                        // this.$router.push('/receipt/' + this.receipt[0].id);
                    }
                    else {
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
