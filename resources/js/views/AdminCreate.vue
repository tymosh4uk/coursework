<template>
    <div>
        <div class="uk-alert-danger" uk-alert v-if="error">
            <a class="uk-alert-close" uk-close></a>
            <p>Перевірте коректність введених даних</p>
        </div>

        <!-- This is the modal -->
        <div id="modal-example" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">Дані успішно додані</h2>
                <p>Дані, які ви ввели є абсолютно коректними і найближчим часом будуть додані до бази даних. Сподіваємося, що це не займе багато часу.</p>
            </div>
        </div>
        <form style="margin-bottom: 50px;" enctype="multipart/form-data">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Створення категорії</legend>

                <div class="uk-margin">
                    <input class="uk-input" id="category" v-model="form.category" type="text" placeholder="Назва категорії">
                </div>



                <button class="uk-button uk-button-primary" @click.prevent="createCategory">
                    <div uk-spinner v-if="loading"></div>
                    <span v-else>Додати категорію</span>
                </button>
            </fieldset>

        </form>
        <form style="margin-bottom: 20px;" enctype="multipart/form-data">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Створити національну кухню</legend>

                <div class="uk-margin">
                    <input class="uk-input" v-model="form.kitchen" type="text" placeholder="Назва кухні">
                </div>



                <button class="uk-button uk-button-primary" @click.prevent="createKitchen">
                    <div uk-spinner v-if="loading"></div>
                    <span v-else>Додати національну кухню</span>
                </button>
            </fieldset>

        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    components: {

    },
    data: () => ({
        form: {
            category: "",
            kitchen: "",
        },
        loading: false,
        error: false
    }),
    methods: {
        createCategory() {
            this.loading = true;

            const data = new FormData();

            data.append('category', this.form.category);

            axios.post('/createCategory', data)
                .then(res => {
                    if (res.data) {
                        console.log(res.data);
                        UIkit.modal("#modal-example").show();
                        this.form.category = "";
                        this.form.kitchen = "";
                        this.loading = false;
                    } else {
                        setTimeout(() => {
                            this.loading = false;
                        }, 300);
                        this.error = true;
                    }
                })
        },
        createKitchen() {
            this.loading = true;

            const data = new FormData();

            data.append('kitchen', this.form.kitchen);

            axios.post('/createKitchen', data)
                .then(res => {
                    if (res.data) {
                        console.log(res.data);
                        UIkit.modal("#modal-example").show();
                        this.form.kitchen = "";
                        this.form.category = "";
                        this.loading = false;
                    } else {
                        setTimeout(() => {
                            this.loading = false;
                        }, 300);
                        this.error = true;
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
