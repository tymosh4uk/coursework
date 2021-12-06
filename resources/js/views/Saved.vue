<template>
    <div>
        <h3 class="uk-heading-small uk-text-center" style="margin-bottom: 20px;">Збережені</h3>
        <div class="receipt-container">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
            <spin v-if="loading"></spin>
            <div v-else>
                <item
                    :receipts="items"
                    :ingradients="items"
                />
                <paginate
                    v-model="page"
                    :page-count="pageCount"
                    :click-handler="pageChangeHandler"
                    :prev-text="'Назад'"
                    :next-text="'Далі'"
                    :container-class="'pagination'"
                    :page-class="'waves-effect'"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Spin from "../components/Spin";
import axios from 'axios';
import Item from '../components/page/ItemReceipt';
import paginationMixin from '../mixins/pagination.mixin';

export default {
    mixins: [paginationMixin],
    components: {
        Spin,
        Item
    },

    data: () => ({
        loading: true,
        receipts: []
    }),
    mounted() {
        this.loadReceipt()
    },
    methods: {
        loadReceipt() {
            axios.get('/getAllSaved')
                .then(res => {
                    console.log(res.data);
                    this.receipts = res.data;
                    this.setupPagination(res.data.receipts);


                    setTimeout(() => {
                        this.loading = false;
                    }, 500)

                })
        }
    }
}
</script>

<style scoped>

</style>
