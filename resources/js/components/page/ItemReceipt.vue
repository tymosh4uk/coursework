<template>
    <div>
        <div v-show="!mobile" class="receipt__container">
            <div class="receipt__container__inner">
                <div class="receipt__img__container">
                    <div class="receipt__img__wrapper" v-if="record.image !== null">

                        <img :src="'../storage/images/'+ record.image" />

                    </div>
                    <div class="receipt__img__wrapper" v-else>

                        <img src="https://i.stack.imgur.com/6M513.png" alt="">

                    </div>
                </div>
                <div class="receipt__content__container">

                    <div class="receipt__content__type__wrapper">
                        <a href="">
                            <span class="receipt__content__type__item">{{ record.category }} •</span>
                        </a>
                        <a href="">
                            <span class="receipt__content__type__item"> {{ record.kitchen }}</span>
                        </a>
                    </div>

                    <div class="receipt__content__title__wrapper">
                        <span class="receipt__content__title">{{ record.name }}</span>
                    </div>

                    <div class="receipt__content__description">
                        <span title="" class="receipt__content__description__author">Автор: {{ record.username }} {{ record.surname }}</span>
                        <div class="receipt__content__description__elements__wrapper">
                            <div class="receipt__content__description__elements__container">
                                <div class="receipt__content__description__elements__ingradients__container">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="dish" style="enable-background:new 0 0 32 32;width: 15px; margin-right: 5px;" version="1.1" viewBox="0 0 32 32" xml:space="preserve"><g><path d="M15,8H17c0.6,0,1-0.4,1-1s-0.4-1-1-1H15c-0.6,0-1,0.4-1,1S14.4,8,15,8z"/><path d="M29.9,20.5C29.7,20.2,29.3,20,29,20h-1.1c-0.5-4.4-4.1-8.8-8.7-10.2c-2.1-0.7-4.4-0.7-6.5,0C8.2,11.2,4.5,15.6,4.1,20H3   c-0.3,0-0.7,0.2-0.9,0.5s-0.2,0.7,0,1C3.5,24.3,6.3,26,9.5,26h13.1c3.1,0,6-1.7,7.4-4.6C30,21.1,30,20.8,29.9,20.5z M13.3,11.7   c1.7-0.5,3.6-0.5,5.3,0c3.7,1.1,6.8,4.7,7.3,8.3H6.1C6.6,16.4,9.6,12.9,13.3,11.7z M22.5,24H9.5c-1.8,0-3.4-0.7-4.6-2h22.2   C25.9,23.3,24.3,24,22.5,24z"/></g></svg>
                                    <span>5 інградієнтів</span>
                                </div>
                                <div class="receipt__content__description__elements__time__container">
                                    <span uk-icon="clock" class="receipt__content__description__elements__time-icon"></span>
                                    <span class="receipt__content__description__elements__time" v-if="record.cooking_hours != null && record.cooking_hours != 0">
                                                    {{ record.cooking_hours }}год.
                                                </span>
                                    <span class="receipt__content__description__elements__time" v-if="record.cooking_minutes != null && record.cooking_minutes != 0">
                                                    {{ record.cooking_minutes }}хв.
                                                </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="receipt__content__options">
                        <div class="receipt__content__options__wrapper">
                            <div class="receipt__content__options__inner">
                                <form id="form-logout" enctype="multipart/form-data">
                                    <div class="receipt__content__options__btn__wrapper">
                                        <!--                                                    <input style="display: none" type="text" value="{{ record.id }}">-->
                                        <!--                                                    <label style="display: none" v-model="idReceipt">{{  }}</label>-->
                                        <button type="button" class="receipt__content__options__btn" @click.prevent="addToSaved(record.id)">
                                            <div class="receipt__content__options__btn__inner">
                                                <span uk-icon="bookmark" class="receipt__content__options__btn__icon"></span>
                                                Добавить в книгу рецептов
                                            </div>
                                        </button>
                                    </div>
                                </form>
                                <div class="receipt__content__options__elements__container">
                                    <div class="receipt__content__options__element__wrapper">
                                        <div class="receipt__content__options__element__inner">
                                                        <span class="receipt__content__options__element__text">
                                                            <i class="receipt__content__options__element__icon material-icons">bookmark</i>
                                                            {{getSavedsById(record.id)}}
                                                        </span>
                                        </div>
                                    </div>
                                    <div class="receipt__content__options__element__wrapper">
                                        <div class="receipt__content__options__element__inner">
                                                        <span class="receipt__content__options__element__text">
                                                             <i class="receipt__content__options__element__icon material-icons">thumb_up</i>
                                                            {{getLikesCount(record.id)}}
                                                        </span>
                                        </div>
                                    </div>
                                    <div class="receipt__content__options__element__wrapper">
                                        <div class="receipt__content__options__element__inner">
                                                        <span class="receipt__content__options__element__text">
                                                            <i class="receipt__content__options__element__icon material-icons">thumb_down</i>
                                                            {{getDislikesCount(record.id)}}
                                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--                        {{ record.id }}-->
            <!--                        {{ record.name }}-->
            <!--                        {{ record.category }}-->
            <!--                        {{ record.kitchen }}-->
            <!--                        {{ record.image }}-->
        </div>

        <div v-show="mobile" class="mobile-receipt--container">
            <div class="mobile-receipt__img--container">
                <div class="mobile-receipt__img--wrapper" v-if="record.image !== null">
                    <img :src="'../storage/images/'+ record.image" />
                </div>
                <div class="mobile-receipt__img--wrapper" v-else>
                    <img src="https://i.stack.imgur.com/6M513.png" alt="">
                </div>

                <div class="mobile-receipt__info--container">
                    <div class="mobile-receipt__type__wrapper">
                        <a href="">
                            <span class="receipt__content__type__item">{{ record.category }} •</span>
                        </a>
                        <a href="">
                            <span class="receipt__content__type__item"> {{ record.kitchen }}</span>
                        </a>
                    </div>

                    <div class="mobile-receipt__title__wrapper">
                        <span class="receipt__content__title">{{ record.name }}</span>
                    </div>

                    <div class="mobile-receipt__author__wrapper">
                        <span title="" class="receipt__content__description__author">Автор: {{ record.username }} {{ record.surname }}</span>
                    </div>
                </div>
            </div>
            <div class="mobile-receipt__description--container">
                <div class="mobile-receipt__options--wrapper">
                    <i class="receipt__content__options__element__icon material-icons">bookmark</i>
                    <span class="receipt__content__options__element__text">
                                    1
                                </span>
                    <i class="receipt__content__options__element__icon material-icons">thumb_up</i>
                    <span class="receipt__content__options__element__text">
                                    {{getLikesCount(record.id)}}
                                </span>
                    <i class="receipt__content__options__element__icon material-icons">thumb_down</i>
                    <span class="receipt__content__options__element__text">
                                    {{getDislikesCount(record.id)}}
                                </span>
                </div>

                <div class="mobile-receipt__content--container">
                    <div class="mobile-receipt__content__ingradients__container">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="dish" style="enable-background:new 0 0 32 32;width: 21px; margin-right: 5px;" version="1.1" viewBox="0 0 32 32" xml:space="preserve"><g><path d="M15,8H17c0.6,0,1-0.4,1-1s-0.4-1-1-1H15c-0.6,0-1,0.4-1,1S14.4,8,15,8z"/><path d="M29.9,20.5C29.7,20.2,29.3,20,29,20h-1.1c-0.5-4.4-4.1-8.8-8.7-10.2c-2.1-0.7-4.4-0.7-6.5,0C8.2,11.2,4.5,15.6,4.1,20H3   c-0.3,0-0.7,0.2-0.9,0.5s-0.2,0.7,0,1C3.5,24.3,6.3,26,9.5,26h13.1c3.1,0,6-1.7,7.4-4.6C30,21.1,30,20.8,29.9,20.5z M13.3,11.7   c1.7-0.5,3.6-0.5,5.3,0c3.7,1.1,6.8,4.7,7.3,8.3H6.1C6.6,16.4,9.6,12.9,13.3,11.7z M22.5,24H9.5c-1.8,0-3.4-0.7-4.6-2h22.2   C25.9,23.3,24.3,24,22.5,24z"/></g></svg>
                        <span class="mobile-receipt__content__ingradients">{{ record.ingradients_count }} інградієнтів</span>
                    </div>
                    <div class="mobile-receipt__content__time__container">
                        <span uk-icon="clock" class="receipt__content__description__elements__time-icon"></span>
                        <span class="receipt__content__description__elements__time mobile-receipt__content__time" v-if="record.cooking_hours != null && record.cooking_hours != 0">
                                        {{ record.cooking_hours }}год.
                                    </span>
                        <span class="receipt__content__description__elements__time" v-if="record.cooking_minutes != null && record.cooking_minutes != 0">
                                        {{ record.cooking_minutes }}хв.
                                    </span>
                    </div>
                </div>
                <div class="mobile-receipt__btn--wrapper">
                    <button type="button" class="receipt__content__options__btn" @click.prevent="addToSaved(record.id)">
                        <div class="receipt__content__options__btn__inner">
                            <span uk-icon="bookmark" class="receipt__content__options__btn__icon"></span>
                            Добавить в книгу рецептов
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import receipt from "../../views/Receipt";

export default {
    data: () => ({
        mobile: null,
        windowWidth: null,
        likesCount: 0,
        dislikesCount: 0,
        savedsCount: 0,
    }),
    props: {
        record: {
            required: true
        },
        ingradients
    },
    created() {
        window.addEventListener('resize', () => this.checkScreen());
        this.checkScreen();
    },
    mounted() {
        // console.log(this.ingradients);
    },
    methods: {
        checkScreen() {
            this.windowWidth = window.innerWidth;
            if(this.windowWidth <= 750) {
                this.mobile = true;
                return;
            }
            this.mobile = false;
            return;
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
                    //         // window.location.reload();
                    if (res.data.status) {
                        //
                        //             // this.$router.push('/receipt/' + this.receipt[0].id);
                        //
                        //
                    }
                    else {
                    }
                })
        },
        getLikesCount(receipt) {
            axios.get('/getLikesById', {
                params: {
                    receipt: receipt
                }
            })
                .then(res => {
                    this.likesCount = res.data.likes;
                })
                .catch(err => {
                    this.loading = false;
                });
            return this.likesCount;
        },
        getDislikesCount(receipt) {
            axios.get('/getLikesById', {
                params: {
                    receipt: receipt
                }
            })
                .then(res => {
                    this.dislikesCount = res.data.dislikes;
                })
                .catch(err => {
                    this.loading = false;
                });
            return this.dislikesCount;
        },

        getSavedsById(receipt) {
            axios.get('/getSavedsById', {
                params: {
                    receipt: receipt
                }
            })
                .then(res => {
                    this.savedsCount = res.data.saveds;
                })
                .catch(err => {
                    this.loading = false;
                });
            return this.savedsCount;
        },

    }

}


</script>

<style scoped>

</style>
