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
                        <input class="form__cooking-time__item" v-model="form.cooking_hours" type="number" min="0" max="23" step="1" value="0">
                        <span class="form__cooking-time__text">Годин</span>
                    </div>

                    <div class="form__cooking-time__hours__wrapper" style="margin-left: 17px;">
                        <input class="form__cooking-time__item" v-model="form.cooking_minutes" type="number" min="0" max="59" step="1" value="1">
                        <span class="form__cooking-time__text">Хвилин</span>
                    </div>
                </div>


                <div class="form__title__wrapper">
                    <span class="form__title small-title">Фото готової страви</span>
                </div>

                <div id="form__main-img__wrapper" class="form__main-img__wrapper">
                    <div class="form__main-img__wrapper__inner">

                        <input id="main_img_file" class="form__main-img__input" type="file" name="main_img_file" ref="main_img_file" accept="image/*">

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
                            <span title="" class="ingradients__title">Інгредієнти</span>
                            <p class="ingradients__info">Вкажіть всі інгредієнти, які необхідні для приготування і подачі данної страви</p>

                        </div>
                        <button id="addIngradient" class="ingradients__add-button" onclick="event.preventDefault()">
                            <div class="ingradients__add-button__container">
                                <span class="first" uk-icon="plus-circle"></span>
                                <span class="second">Додати інгредієнт</span>
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
                            <div id="step_clicks" style="display:none">1</div>
                            <span title="" class="ingradients__title">Покрокова інструкція</span>
                            <p class="ingradients__info">Покрокова інструкція допоможе початківцям приготувати ваш рецепт. Ми рекомендуємо розбити рецепт мінімум на 5 кроків</p>

                        </div>
                        <button id="addStep" class="ingradients__add-button" onclick="event.preventDefault()">
                            <div class="ingradients__add-button__container">
                                <span class="first" uk-icon="plus-circle"></span>
                                <span class="second">Додати новий крок</span>
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
                        <textarea v-model="form.advice" placeholder="Використовуйте дане поле для опису альтернативного способу приготування страви чи варіантів заміни інгредієнтів на подібні" name="input" autocomplete="on"></textarea>
                    </div>

                </div>


<!--                <div class="uk-margin">-->
<!--                    <input class="uk-input" v-model="form.id_step" type="number" placeholder="id_step">-->
<!--                </div>-->





                <div class="send-btn__container">
                    <button class="send-btn__on-create" @click.prevent="store">
                        <div uk-spinner v-if="loading"></div>
                        <span v-else>Опубликовать</span>
                    </button>
                </div>
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
            ingradients: [],
            count_ingradients: [],
            type_measurings: [],
            step_images: [],
            step_descriptions: [],
            step_count: ""
        },
        loading: false,
        error: false
    }),
    methods: {

        filldata() {
            this.form.main_img_file = this.$refs.main_img_file.files[0];

            var imagesArr = [];
            var stepImages = $( ".step_img_file" );



            for(var i = 0; i < stepImages.length; i++){
                var fileUpload = stepImages[i];                    // ***
                if (fileUpload.files.length > 0) {
                    // var file = {
                    //     'lastMod'    : fileUpload.files[0].lastModified,
                    //     'lastModDate': fileUpload.files[0].lastModifiedDate,
                    //     'name'       : fileUpload.files[0].name,
                    //     'size'       : fileUpload.files[0].size,
                    //     'type'       : fileUpload.files[0].type
                    // }
                    // ***
                    imagesArr.push(fileUpload.files[0]);
                    // imagesArr.push({ step_image: fileUpload.files[0]});

                }                                                 // ***
            }
             // console.log(imagesArr);
            this.form.step_images = imagesArr;
            this.form.step_count = imagesArr.length;

            // stepImages.each(function() {
            //     this.form.step_images.push(this.files[0]);
            // });

            // $('.step_img_file').each(function() {
            //     console.log($(this).files[0]);
            // });


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


            var step_description = $('textarea[name*="step_description"]');
            var step_descriptions = [];

            step_description.each(function() {
                if (this.value != "") {
                    step_descriptions.push({ step_description: this.value });
                }
            });

            this.form.step_descriptions = step_descriptions;

            // console.log(this.form);

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
            data.append('ingradients', JSON.stringify(this.form.ingradients));
            data.append('count_ingradients', JSON.stringify(this.form.count_ingradients));
            data.append('type_measurings', JSON.stringify(this.form.type_measurings));
            data.append('step_descriptions', JSON.stringify(this.form.step_descriptions));
            data.append('step_count', this.form.step_count);
            var stepImages = $( ".step_img_file" );



            for(var i = 0; i < stepImages.length; i++) {
                var fileUpload = stepImages[i];                    // ***
                if (fileUpload.files.length > 0) {
                    data.append('step_images_'+i, fileUpload.files[0]);
                }
            }

            // data.append('step_images', JSON.stringify(this.form.step_images));
            for(var i=0; i<this.form.step_images.length; i++){

            }

            data.append('photo', this.form.main_img_file);


            // for (var pair of data.entries()) {
            //     console.log(pair[0]+ ', ' + pair[1]);
            // }


            axios.post('/api/receipts', data)
                .then(res => {
                    // console.info(res.data);
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
    setIngradient += '<input class="uk-input"  type="text" name="ingradients[]" placeholder="Вкажіть інгредієнт">'
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
                      '<option name="measure">столових ложок</option>\n' +
                      '<option name="measure">чайних ложок</option>\n' +
                      '<option name="measure">за смаком</option>\n' +
                      '<option name="measure">стакан</option>\n' +
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

    setStep += '<input id="" class="step__body__input step_img_file" type="file" name="step_img_file" accept="image/*" ref="step_img_file">'
    setStep += '<div class="step__img__content">'
    setStep += '<div class="step__img__content__aligner">'
    setStep += '<span class="step__img__content__icon" uk-icon="icon: cloud-upload"></span>'
    setStep += '<span class="step__img__content__text">Додати фото<br>(Завантажити)</span>'
    setStep += '</div>'
    setStep += '</div>'

    setStep += '<div class="step__img__contain">'
    setStep += '<div class="step__img__overlay">'
    setStep += '<img class="previewStepHolder" alt="Uploaded Image Preview Holder"/>'
    setStep += '</div>'
    setStep += '</div>'

    setStep += '</div>'
    setStep += '</div>'

    setStep += '<div class="step__textarea__container">'
    setStep += '<textarea class="step__textarea" placeholder="Інструкція до кроку приготування" name="step_description" autocomplete="on"></textarea>'
    setStep += '</div>'


    setStep += '</div>'

    setStep += '<div class="step__button" style="position: absolute; top: 15px; right: -30px; cursor: pointer;">'
    setStep += '<button id=deleteStep class="ingradients__deleteIngradient uk-close-large" onclick="event.preventDefault()" type="button" uk-close></button>'
    setStep += '</div>'

    setStep += '</div>'

    $('#steps').append(setStep)
    let lastItem = $( "#steps > div:last " )
    let lastInput = lastItem.find('.step_img_file')
    lastInput.attr('name', $('#step_clicks').html(function(i, val) { return val }).html())
    let lastImg = lastItem.find('.previewStepHolder')
    lastImg.attr('id', 'step-img-'+ $('#step_clicks').html(function(i, val) { return val }).html())
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
    // console.log("Uploading image");
})

$('body').delegate('.step_img_file', 'change', function () {
    readStepURL(this);
    // console.log("Uploading step image");
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

function readStepURL(input) {
    // console.log(input.name)
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#step-img-'+input.name).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else {}
}

// $("#step_img_file").change(function() {
//     readStepURL(this);
//     console.log("Uploading image");
// });


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
