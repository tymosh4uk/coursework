<template>
    <div v-if="receipt.length">
        <h3>Редагування посту #{{ receipt[0].id }}</h3>
        <div class="uk-margin">
            <label class="uk-form-label" >Назва рецепту</label>
            <div class="uk-form-controls">
                <input class="uk-input"  type="text"  v-model="receipt[0].name">
            </div>
        </div>
        <div class="uk-margin">
            <div class="js-upload" uk-form-custom>
                <input id="main_img_file" type="file" ref="main_img_file" accept="image/*">
                <button class="uk-button uk-button-default" type="button" tabindex="-1">Select</button>
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" >Час приготування</label>
            <div class="uk-form-controls">
                <label class="uk-form-label" >Годин:</label>
                <input class="uk-input"  type="text"  v-model="receipt[0].cooking_hours">
            </div>
            <div class="uk-form-controls">
                <label class="uk-form-label" style="margin-top: 5px">Хвилин:</label>
                <input class="uk-input"  type="text"  v-model="receipt[0].cooking_minutes">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" >Категорія</label>
            <select id="categories" class="uk-select" >
                <option value="" selected>{{ receipt[0].category }}</option>
                <option v-for="category in getInfo.categories" :value="category.category">{{ category.category }}</option>
            </select>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label" >Національна кухня</label>
            <select id="kitchens" class="uk-select" >
                <option value="" selected>{{ receipt[0].kitchen }}</option>
                <option v-for="kitchen in getInfo.kitchens" :value="kitchen.kitchen">{{ kitchen.kitchen }}</option>
            </select>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" >Порада</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea"  type="text"  v-model="receipt[0].advice"></textarea>
            </div>
        </div>
        <div class="uk-margin">
            <button class="uk-button uk-button-primary" @click.prevent="editReceipt">Редагувати</button>
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
        getInfo: {},
        user_id: "",
        loading: true,
        userId: Number,
        receipt: [],
        ingradients: [],
        steps: [],
        not_found: false,
        comment: "",
        comments: "",
        isSaved: "",
        form: {
            category: "",
            kitchen: "",
            main_img_file: ""
        }
    }),
    mounted() {
        this.loadReceipt(this.$route.params.id)
        // console.log(this.userId)
    },
    methods: {
        loadReceipt(id) {
            axios.get('/api/receipts/' + id)
                .then(res => {
                    if(res.data.status) {
                        this.receipt = res.data.receipt;
                        this.ingradients = res.data.ingradients;
                        this.steps = res.data.steps;
                        console.log(res.data);
                        this.loading = false;
                    }
                })
                .catch(err => {
                    this.not_found = true;
                    this.loading = false;
                })
        },
        getData() {
            axios.get('/api/receipts/create').then(({ data }) => ( this.getInfo = data));
        },
        editReceipt() {
            // console.log(receipt);

            this.form.main_img_file = this.$refs.main_img_file.files[0];



            let category = document.getElementById('categories');
            this.form.category = category.options[category.selectedIndex].text;

            let kitchen = document.getElementById('kitchens');
            this.form.kitchen = kitchen.options[kitchen.selectedIndex].text;

            const data = new FormData();
            //
            data.append('id_receipt', this.receipt[0].id);
            data.append('name', this.receipt[0].name);
            data.append('cooking_hours',this.receipt[0].cooking_hours);
            data.append('cooking_minutes', this.receipt[0].cooking_minutes);
            if(this.form.category != this.receipt[0].category) {
                data.append('category', this.form.category);
            }
            if(this.form.kitchen != this.receipt[0].kitchen) {
                data.append('kitchen', this.form.kitchen);
            }
            data.append('id_category', this.receipt[0].category);
            data.append('id_kitchen', this.receipt[0].kitchen);
            data.append('advice', this.receipt[0].advice);
            if(this.form.main_img_file) {
                data.append('photo', this.form.main_img_file);
            }
            //
            axios.post('/editReceipt', data)
                .then(res => {
                    console.log(res.data);
                    // window.location.reload();
                    if (res.data) {
                        this.$router.push('/receipt/' + this.receipt[0].id);
                    }
                    else {
                        window.location.reload();
                    }
                })
        }
    },
    created() {
        this.getData();
    }
}
</script>

<style scoped>

</style>
