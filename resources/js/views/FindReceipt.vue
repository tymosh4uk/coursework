<template>
    <div>
        <form id="form" style="margin-bottom: 20px;" enctype="multipart/form-data">
            <h3>Пошук</h3>
            <div class="uk-margin">
                <label class="uk-form-label" >Назва рецепту</label>
                <div class="uk-form-controls">
                    <input class="uk-input" v-model="form.searchData" type="text" placeholder="Введіть назву" >
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" >Категорія</label>
                <select id="categories" class="uk-select" >
                    <option value="" disabled selected>Оберіть категорію</option>
                    <option v-for="category in getInfo.categories" :value="category.category">{{ category.category }}</option>
                </select>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" >Національна кухня</label>
                <select id="kitchens" class="uk-select" >
                    <option value="" disabled selected>Оберіть кухню</option>
                    <option v-for="kitchen in getInfo.kitchens" :value="kitchen.kitchen">{{ kitchen.kitchen }}</option>
                </select>
            </div>
            <div class="uk-margin">
                <div style="display: inline-flex">
                    <button class="uk-button uk-button-primary" @click.prevent="findReceipt">Знайти</button>
                    <button class="uk-button uk-button-danger" @click.prevent="refreshReceipt" style="margin-left: 10px;">Очистити</button>
                </div>
            </div>
        </form>
        <div class="comments__row"></div>
        <div style="margin-top:30px;" >

            <item
                :receipts="receipts"
                :ingradients="receipts"
            />
        </div>
    </div>
</template>

<script>
import Spin from "../components/Spin";
import axios from "axios";
import Item from '../components/page/ItemReceipt';
import paginationMixin from '../mixins/pagination.mixin';

export default {
    mixins: [paginationMixin],
    components: {
        Spin,
        Item
    },
    data: () => ({
        getInfo: {},
        user_id: "",
        loading: true,
        userId: Number,
        receipts: [],
        ingradients: [],
        steps: [],
        not_found: false,
        comment: "",
        comments: "",
        isSaved: "",
        form: {
            category: "",
            kitchen: "",
            main_img_file: "",
            searchData: null
        }
    }),
    mounted() {
        // this.loadReceipt(this.$route.params.id)
        // console.log(this.userId)
    },
    created() {
        this.getData();
    },
    methods: {
        findReceipt() {
            let category = document.getElementById('categories');
            this.form.category = category.options[category.selectedIndex].text;

            let kitchen = document.getElementById('kitchens');
            this.form.kitchen = kitchen.options[kitchen.selectedIndex].text;

            if(this.form.searchData !== null || this.form.category != 'Оберіть категорію' || this.form.kitchen != 'Оберіть кухню') {

                const data = new FormData();

                if(this.form.searchData !== null) {
                    data.append('name', this.form.searchData);
                }

                if (this.form.category != 'Оберіть категорію') {
                    data.append('category', this.form.category);
                }
                if (this.form.kitchen != 'Оберіть кухню') {
                    data.append('kitchen', this.form.kitchen);
                }


                axios.post('/findReceipt', data)
                    .then(res => {
                        if (res.data) {
                            this.receipts = res.data;
                            // this.ingradients = res.data.ingradients;
                            // this.steps = res.data.steps;
                            console.log(res.data);
                            this.loading = false;
                        }
                    })
                    .catch(err => {
                        this.not_found = true;
                        this.loading = false;
                    })
            }
        },
        refreshReceipt() {
            window.location.reload();
        },
        getData() {
            axios.get('/api/receipts/create').then(({data}) => (this.getInfo = data));
        }
    }
}
</script>

<style scoped>

</style>
