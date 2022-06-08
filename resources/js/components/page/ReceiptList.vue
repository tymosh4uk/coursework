<template>

        <ul style="list-style: none; margin: 0; padding: 0;">
            <li v-for="record of receipts">
                <router-link :to="'/receipt/' + record.id">
                    <item :record="record"/>
                </router-link>

            </li>
    </ul>
</template>

<script>
import axios from "axios";
import receipt from "../../views/Receipt";
import Item from "./ItemReceipt";
import Spin from "../Spin";

export default {
    components: {
        Spin,
        Item
    },
    data: () => ({
        mobile: null,
        windowWidth: null,
        likesCount: 0,
        dislikesCount: 0,
    }),
    props: {
        receipts: {
            required: true,
            type: Array
        },
        ingradients: {
        }
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

    }


    // props: {
    //     id: {
    //         type: Number,
    //         default: "NULL"
    //     },
    //     name: {
    //         type: String,
    //         default: "NULL"
    //     },
    //     category: {
    //         type: String,
    //         default: "NULL"
    //     },
    //     kitchen: {
    //         type: String,
    //         default: "NULL"
    //     },
    //     cooking_hours: {
    //         type: Number,
    //         default: "NULL"
    //     },
    //     cooking_minutes: {
    //         type: Number,
    //         default: "NULL"
    //     },
    //     ingradients: {
    //         type: Object,
    //         default: "NULL"
    //     }
    // }
}


</script>

<style scoped>

</style>
