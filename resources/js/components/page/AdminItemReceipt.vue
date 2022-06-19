<template>

    <ul>
        <li v-for="record of receipts">
            <router-link :to="'/receipt/' + record.id">
                <div class="receipt__container">
                    <div class="receipt__aligner__container">
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
                                                <span>5 інгредієнтів</span>
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
                                                                1
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="receipt__content__options__element__wrapper">
                                                    <div class="receipt__content__options__element__inner">
                                                            <span class="receipt__content__options__element__text">
                                                                 <i class="receipt__content__options__element__icon material-icons">thumb_up</i>
                                                                2
                                                            </span>
                                                    </div>
                                                </div>
                                                <div class="receipt__content__options__element__wrapper">
                                                    <div class="receipt__content__options__element__inner">
                                                            <span class="receipt__content__options__element__text">
                                                                <i class="receipt__content__options__element__icon material-icons">thumb_down</i>
                                                                0
                                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="receipt__delete__container">
                            <form id="form-deleteReceipt" enctype="multipart/form-data">
                                <button type="button" style="height: 40px; width: 150px;" class="uk-button-danger" @click.prevent="deleteReceipt(record.id)">
                                    Видалити
                                </button>
                            </form>
                        </div>
                        <div class="receipt__delete__container" style="margin-left: 10px">
                            <form id="form-editReceipt" enctype="multipart/form-data">
                                <router-link :to="'/adminEdit/' + record.id">
                                    <button type="button" style="height: 40px; width: 150px;" class="uk-button-primary">
                                        Редагувати
                                    </button>
                                </router-link>
                            </form>
                        </div>
                    </div>
                </div>
            </router-link>

        </li>
    </ul>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({

    }),
    props: {
        receipts: {
            required: true,
            type: Array
        }
        // ingradients: {
        //     required: true,
        //     type: Array
        //     // type: Object
        // }
    },
    mounted() {
        // console.log(this.ingradients);
    },
    methods: {
        deleteReceipt(receipt) {

            //
            axios.delete('api/receipts/'+ receipt)
                .then(res => {
                    // console.log(res.data);
                    window.location.reload();
                    if (res.data.status) {
                        //
                        //             // this.$router.push('/receipt/' + this.receipt[0].id);
                        //
                        //
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
