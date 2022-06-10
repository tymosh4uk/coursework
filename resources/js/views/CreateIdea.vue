<template>
    <div>
        <spin v-if="loading"></spin>
        <div v-else>
            <fieldset class="uk-fieldset">

                <div class="form__title__wrapper">
                    <span class="form__title small-title">Ваша авторська ідея:</span>
                </div>

                <div class="form__name__wrapper">
                    <textarea class="form__name" v-model="form.name" autocomplete="on" placeholder="Назва авторської ідеї"></textarea>
                </div>

                <div class="form__title__wrapper">
                    <span class="form__title small-title">Фото авторської ідеї</span>
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

                <div class="form__title__wrapper">
                    <span class="form__title small-title">Зміст:</span>
                </div>
                <div class="form__editor">
                    <vue-editor v-model="form.description"></vue-editor>
                </div>

                <div class="send-btn__container">
                    <button class="send-btn__on-create" @click.prevent="store">
                        <div uk-spinner v-if="loading"></div>
                        <span v-else>Опубликовать</span>
                    </button>
                </div>
            </fieldset>
        </div>
    </div>
</template>

<script>
import Spin from "../components/Spin";
import { VueEditor } from "vue2-editor";
import axios from 'axios';

export default {
    components: {
        Spin,
        VueEditor
    },

    data: () => ({
        loading: false,
        form: {
            name: "",
            image: "",
            description: ""
        }
    }),
    mounted() {

    },
    methods: {
        store() {
            this.loading = true;
            this.form.image = this.$refs.main_img_file.files[0];
            console.log(this.form.name);
            console.log(this.form.image);
            console.log(this.form.description);
            if(this.form.name != "" && this.form.image != "" && this.form.description != "") {


                const data = new FormData();

                data.append('name', this.form.name);
                data.append('image', this.form.image);
                data.append('description', JSON.stringify(this.form.description));

                axios.post('/createIdea', data)
                    .then(res => {
                        // console.info(res.data);
                        if (res.data.status) {
                            // this.$router.push('/receipt/' + res.data.receipt.id);


                        } else {
                            setTimeout(() => {
                                this.loading = false;
                            }, 300);
                            this.error = true;
                        }
                    })
            }
        },
    }
}

$('body').delegate('#main_img_file', 'change', function () {
    readURL(this);
    // console.log("Uploading image");
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


</script>

<style scoped>

</style>
