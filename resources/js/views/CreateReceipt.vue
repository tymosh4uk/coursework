<template>
    <div>
        <div class="uk-alert-danger" uk-alert v-if="error">
            <a class="uk-alert-close" uk-close></a>
            <p>Проверьте правильность введенный полей</p>
        </div>
        <form id="form" style="margin-bottom: 20px;" enctype="multipart/form-data">
            <fieldset class="uk-fieldset">

                <div class="form__title__wrapper">
                    <span class="form__title small-title">Ваш новий рецепт:</span>
                </div>

                <div class="form__name__wrapper">
                    <textarea class="form__name" v-model="form.name" autocomplete="on" placeholder="Назва рецепту"></textarea>
                </div>

                <div class="form__title__wrapper">
                    <span class="form__title small-title">Час приготування:</span>
                </div>

                <div class="form__cooking-time__wrapper">

                    <div class="form__cooking-time__hours__wrapper">
                        <input class="form__cooking-time__item" v-model="form.cooking_hours" type="number" min="0" step="1" value="0">
                        <span class="form__cooking-time__text">Годин</span>
                    </div>

                    <div class="form__cooking-time__hours__wrapper" style="margin-left: 17px;">
                        <input class="form__cooking-time__item" v-model="form.cooking_minutes" type="number" min="0" step="1" value="1">
                        <span class="form__cooking-time__text">Хвилин</span>
                    </div>
                </div>


                <div class="form__title__wrapper">
                    <span class="form__title small-title">Фото готової страви</span>
                </div>

                <div id="form__main-img__wrapper" class="form__main-img__wrapper">
                    <div class="form__main-img__wrapper__inner">

                        <input id="main_img_file" class="form__main-img__input" type="file" name="main_img_file" ref="main_img_file">

                        <div class="form__main-img__content">
                            <div class="form__main-img__content__aligner">
                                <span class="form__main-img__content__icon" uk-icon="icon: cloud-upload"></span>
                                <span class="form__main-img__content__text">
                                    Додати фото
                                    <br>
                                    (Завантажити)
                                </span>
                            </div>
                        </div>

                        <div class="form__main-img__contain">
                            <div class="form__main-img__overlay">
                                <img id="previewHolder" alt="Uploaded Image Preview Holder"/>
                            </div>
                        </div>
                    </div>
                </div>

<!--                <div class="uk-margin">-->
<!--                    <input type="file" class="form-control" v-on:change="onImageChange">-->
<!--                    <input id="main_img_file" type="file" name="main_img_file" ref="main_img_file">-->

<!--                    <input class="uk-input" v-model="form.main_img" type="text" placeholder="main_img">-->
<!--                </div>-->


                <div class="selects__container">
                    <div class="selects__container__wrapper">
                        <div class="selects__container__left">
                            <span class="form__title small-title">Категорії страви</span>
                            <div class="selects__container__left__selector">
                                <select id="categories" class="uk-select" >
                                    <option value="" disabled selected>Оберіть категорію</option>
                                    <option v-for="category in getInfo.categories" :value="category.category">{{ category.category }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="selects__container__right">
                            <span class="form__title small-title">Національна кухня</span>
                            <div class="selects__container__right__selector">
                                <select id="kitchens" class="uk-select" >
                                    <option value="" disabled selected>Оберіть кухню</option>
                                    <option v-for="kitchen in getInfo.kitchens" :value="kitchen.kitchen">{{ kitchen.kitchen }}</option>
                                </select>
                            </div></div>
                    </div>
                </div>



<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input" v-model="form.id_user" type="number" placeholder="id_user">-->
<!--                </div>-->





                <div class="hr"></div>

                <div class="ingradients__wrapper">
                    <div class="ingradients__cont">
                        <div id="ingradients" class="ingradients">
                            <span title="" class="ingradients__title">Інградієнти</span>
                            <p class="ingradients__info">Вкажіть всі інгредієнти, які необхідні для приготування і подачі данної страви</p>

                        </div>
                        <button id="addIngradient" class="ingradients__add-button" onclick="event.preventDefault()">
                            <div class="ingradients__add-button__container">
                                <span class="first" uk-icon="plus-circle"></span>
                                <span class="second">Додати інградієнт</span>
                            </div>

                        </button>
                    </div>
                </div>

<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input"  type="text" name="ingradients[]" placeholder="ingradient">-->
<!--                </div>-->

<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input"  type="number" name="count_ingradients[]" placeholder="count_ingradient">-->
<!--                </div>-->

<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input"  type="text" name="type_measurings[]" placeholder="type_measuring">-->
<!--                </div>-->

<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input"  type="text" name="ingradients2[]" placeholder="ingradient">-->
<!--                </div>-->


                <div class="hr"></div>

                <div class="ingradients__wrapper">
                    <div class="ingradients__cont">
                        <div id="steps" class="ingradients">
                            <div id="step_clicks" style="display:none">0</div>
                            <span title="" class="ingradients__title">Покрокова інструкція</span>
                            <p class="ingradients__info">Покрокова інструкція допоможе початківцям приготувати ваш рецепт. Ми рекомендуємо розбити рецепт мінімум на 5 кроків</p>

                        </div>
                        <button id="addStep" class="ingradients__add-button" onclick="event.preventDefault()">
                            <div class="ingradients__add-button__container">
                                <span class="first" uk-icon="plus-circle"></span>
                                <span class="second">Додати інградієнт</span>
                            </div>

                        </button>
                    </div>
                </div>

                <div class="hr"></div>

                <div class="ingradients__wrapper">
                    <div class="ingradients__cont advice">
                        <span title="" class="ingradients__title">Порада до рецепту</span>


                    </div>

                    <span class="form__title small-title">Примітка</span>

                    <div class="advice__wrapper">
                        <textarea v-model="form.advice" placeholder="Використовуйте дане поле для опису альтернативного способу приготування страви чи варіантів заміни інградієнтів на подібні" name="input" autocomplete="on"></textarea>
                    </div>

                </div>


                <div class="uk-margin">
                    <input class="uk-input" v-model="form.id_step" type="number" placeholder="id_step">
                </div>





                <button class="uk-button uk-button-primary" @click.prevent="store">
                    <div uk-spinner v-if="loading"></div>
                    <span v-else>Опубликовать</span>
                </button>
            </fieldset>

        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    components: {

    },
    data: () => ({
        getInfo: {},
        form: {
            name: "",
            cooking_hours: "",
            cooking_minutes: "",
            main_img_file: "",
            category: "",
            kitchen: "",
            advice: "",
            user_id: "",
            id_step: "",
            ingradients: [],
            count_ingradients: [],
            type_measurings: [],
            step_images: [],
            step_descriptions: []
        },
        loading: false,
        error: false
    }),
    methods: {
        filldata() {
            this.form.main_img_file = this.$refs.main_img_file.files[0];

            //console.log(this.$refs.step_img_file);

            let category = document.getElementById('categories');
            this.form.category = category.options[category.selectedIndex].text;

            let kitchen = document.getElementById('kitchens');
            this.form.kitchen = kitchen.options[kitchen.selectedIndex].text;

            var ingradient = $('input[name*="ingradients"]');
            var ingradients = [];

            ingradient.each(function() {
                if (this.value != "") {
                    ingradients.push({ ingradient: this.value });
                }
            });
            this.form.ingradients = ingradients;

            var count = $('input[name*="count"]');
            var counts = [];

            count.each(function() {
                if (this.value != "") {
                    counts.push({ count_ingradient: this.value });
                }
            });

            this.form.count_ingradients = counts;

            var measuring = document.getElementsByName("type_measurings[]");
            var measurings = [];

            for (let i = 0; i < measuring.length; i++) {
                measurings.push({ type_measuring: measuring[i].options[measuring[i].selectedIndex].text });
            }

            this.form.type_measurings = measurings;


            //console.log(measurings);

        },

        store() {
            this.loading = true;
            this.filldata();



            const data = new FormData();

            data.append('name', this.form.name);
            data.append('cooking_hours', this.form.cooking_hours);
            data.append('cooking_minutes', this.form.cooking_minutes);
            data.append('category', this.form.category);
            data.append('kitchen', this.form.kitchen);
            data.append('advice', this.form.advice);
            data.append('user_id', this.form.user_id);
            data.append('id_step', this.form.id_step);
            data.append('ingradients', JSON.stringify(this.form.ingradients));
            data.append('count_ingradients', JSON.stringify(this.form.count_ingradients));
            data.append('type_measurings', JSON.stringify(this.form.type_measurings));


            data.append('photo', this.form.main_img_file);


            // for (var pair of data.entries()) {
            //     console.log(pair[0]+ ', ' + pair[1]);
            // }


            axios.post('/api/receipts', data)
                .then(res => {
                    // console.log(res.data);
                    if (res.data.status) {
                        this.$router.push('/receipt/' + res.data.receipt.id);


                    } else {
                        setTimeout(() => {
                            this.loading = false;
                        }, 300);
                        this.error = true;
                    }
                })
        },

        getData() {
            axios.get('/api/receipts/create').then(({ data }) => ( this.getInfo = data));
            axios.get('/currentUserId').then(({ data }) => ( this.form.user_id = data));
            //console.log(this.getInfo );

        }
    },
    created() {
        this.getData();
    }
}

$('body').delegate('#addIngradient', 'click', function () {
    let day = $(this).attr('day');
    let setIngradient = '<div class="ingradients__group">'
    setIngradient += '<div class="ingradients__ingradient">'
    setIngradient += '<div class="ingradients__ingradient__container">'
    setIngradient += '<input class="uk-input"  type="text" name="ingradients[]" placeholder="Вкажіть інградієнт">'
    setIngradient += '</div>'
    setIngradient += '</div>'

    setIngradient += '<div class="ingradients__numbers">'
    setIngradient += '<div class="ingradients__count">'
    setIngradient += '<input class="uk-input"  type="number" name="count[]" value=0 min=0>'
    setIngradient += '</div>'

    setIngradient += '<div class="ingradients__type">'
    setIngradient += '<select class="uk-select" name="type_measurings[]">\n' +
                      '<option name="measure">мл</option>\n' +
                      '<option name="measure">грам</option>\n' +
                      '<option name="measure">штук</option>\n' +
                      '</select>\n' +
                      '</div> '
    setIngradient += '</div>'

    setIngradient += '<div class="ingradients__button" style="position: absolute; top: 15px; right: -30px; cursor: pointer;">'
    setIngradient += '<button id=deleteIngradient class="ingradients__deleteIngradient uk-close-large" onclick="event.preventDefault()" type="button" uk-close></button>'
    setIngradient += '</div>'

    setIngradient += '</div>'

    $('#ingradients').append(setIngradient)
})
$('body').delegate('#deleteIngradient', 'click', function () {
    $(this).parent().parent().remove()
})



$('body').delegate('#addStep', 'click', function () {
    let setStep = '<div class="step">'
    setStep += '<div class="step__header">'
    setStep += '<span class="step__header__title">Крок ' + $('#step_clicks').html(function(i, val) { return val }).html() + '</span>'
    setStep += '</div>'

    setStep += '<div class="step__body">'

    setStep += '<div class="step__body__image__wrapper">'
    setStep += '<div class="step__body__image__wrapper__content">'

    setStep += '<input id="step_img_file" class="step__body__input" type="file" name="step_img_file" ref="step_img_file">'
    setStep += '<div class="step__img__content">'
    setStep += '<div class="step__img__content__aligner">'
    setStep += '<span class="step__img__content__icon" uk-icon="icon: cloud-upload"></span>'
    setStep += '<span class="step__img__content__text">Додати фото<br>(Завантажити)</span>'
    setStep += '</div>'
    setStep += '</div>'

    setStep += '<div class="step__img__contain">'
    setStep += '<div class="step__img__overlay">'
    setStep += '<img id="previewStepHolder" alt="Uploaded Image Preview Holder"/>'
    setStep += '</div>'
    setStep += '</div>'

    setStep += '</div>'
    setStep += '</div>'

    setStep += '<div class="step__textarea__container">'
    setStep += '<textarea class="step__textarea" placeholder="Инструкция к шагу приготовления" name="input" autocomplete="on">fhgjrh</textarea>'
    setStep += '</div>'


    setStep += '</div>'

    setStep += '<div class="step__button" style="position: absolute; top: 15px; right: -30px; cursor: pointer;">'
    setStep += '<button id=deleteStep class="ingradients__deleteIngradient uk-close-large" onclick="event.preventDefault()" type="button" uk-close></button>'
    setStep += '</div>'

    setStep += '</div>'

    $('#steps').append(setStep)
})

$('body').delegate('#deleteStep', 'click', function () {
    $(this).parent().parent().remove();
    $('#step_clicks').html(function(i, val) { return val*1-1 });
})

$('body').delegate('#addStep', 'click', function () {
    $('#step_clicks').html(function(i, val) { return val*1+1 });
})
$('body').delegate('#main_img_file', 'change', function () {
    readURL(this);
    console.log("Uploading image");
})
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#previewHolder').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else {
    }
}


// $(function(){
//     $('#addStep').click(function() {
//         $('#step_clicks').html(function(i, val) { return val*1+1 });
//     });
// });

$(function(){
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewHolder').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
        }
    }

    $("#main_img_file").change(function() {
        readURL(this);
        console.log("Uploading image");
    });

    function readStepURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previewStepHolder').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
        }
    }

    $("#step_img_file").change(function() {
        readStepURL(this);
        console.log("Uploading image");
    });
});





</script>

<style scoped>

</style>
