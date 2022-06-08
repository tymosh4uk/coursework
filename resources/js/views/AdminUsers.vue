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
                <label class="uk-form-label" >Автор</label>
                <select id="users" class="uk-select" >
                    <option value="Оберіть авторa" disabled selected>Оберіть авторa</option>
                    <option v-for="user in getInfo.receipts_count" :value="user.id">{{ user.surname }} {{ user.name }}</option>
                </select>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" >Дата створення рецепту</label>
                <br>
                <label class="uk-form-label" style="margin-right: 10px;">Від</label>
                <input class="uk-input" type="date" v-model="form.createdFrom" style="width: 200px">
                <label class="uk-form-label" style="margin: 0px 10px 0px 20px;">До</label>
                <input class="uk-input" type="date" v-model="form.createdTo" style="width: 200px">
            </div>
            <div class="uk-margin">
                <div style="display: inline-flex">
                    <button class="uk-button uk-button-primary" @click.prevent="findReceipt">Знайти</button>
                    <button class="uk-button uk-button-danger" @click.prevent="refreshReceipt" style="margin-left: 10px;">Очистити</button>
                    <button class="uk-button uk-button-default" style="margin-left: 10px; background-color: #90EE90" @click.prevent="downloadReceipt" >

                            Завантажити дані

                    </button>
                </div>
            </div>
        </form>
        <div class="comments__row"></div>
        <div class="uk-overflow-auto" style="margin-top:30px;">
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Прізвище</th>
                    <th>Ім'я</th>
                    <th>Email</th>
                    <th>Дата створення</th>
                    <th>Кількість рецептів</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in getInfo.receipts_count">
                    <td>{{ user.id }}</td>
                    <td>{{ user.surname }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.total }}</td>
                </tr>

                </tbody>
            </table>
        </div>
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
import Item from '../components/page/ReceiptList';
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
            searchData: null,
            createdFrom: null,
            createdTo: null
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


            let user = document.getElementById('users');
            this.form.user = user.options[user.selectedIndex].value;



            if(this.form.searchData !== null || this.form.category != 'Оберіть категорію' || this.form.kitchen != 'Оберіть кухню' || this.form.user !== 'Оберіть авторa' || this.form.createdFrom || this.form.createdTo) {

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

                if (this.form.user != 'Оберіть авторa') {
                    data.append('user', this.form.user);
                }

                if(this.form.createdFrom !== null) {
                    data.append('createdFrom', this.form.createdFrom);
                }

                if(this.form.createdTo !== null) {
                    data.append('createdTo', this.form.createdTo);
                }


                axios.post('/findAdminReceipt', data)
                    .then(res => {
                        if (res.data) {
                            console.log(res.data);
                            this.receipts = res.data;
                            // this.ingradients = res.data.ingradients;
                            // this.steps = res.data.steps;
                            // console.log(res.data);
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
        },
        downloadReceipt() {
            location.href='/receiptExport';
        }
    }
}
</script>

<style scoped>

</style>
