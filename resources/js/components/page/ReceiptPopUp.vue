<template>
    <v-card
        style="position: absolute; top: 40px; left: 0; z-index: 2;"
        class="mx-auto"
        max-width="344"
    >
        <v-img v-if=foundProduct
            :class="receipt-popup__image"
            :src=product.image
            height="200px"
        ></v-img>

        <v-img v-else
               class="receipt-popup__image"
               src="https://ru.hostings.info/upload/images/2021/12/e11044b915dc39afc3004430606bd6d1.jpg"
               height="200px"
        ></v-img>

        <v-card-title class="subheading font-weight-bold">
            {{ ingragient }}
        </v-card-title>

        <v-list dense v-if=foundProduct>
            <v-list-item>
                <v-list-item-content>Вартість:</v-list-item-content>
                <v-list-item-content class="align-end">
                    {{ product.bills }}.{{ product.coins }} ₴ / {{ product.measuring }}
                </v-list-item-content>
            </v-list-item>
        </v-list>


    </v-card>
</template>

<script>
import Vue from 'vue';
import Vuetify from 'vuetify';
import axios from "axios";
Vue.use(Vuetify);

export default {
    vuetify: new Vuetify(),
    data: () => ({
        show: false,
        product: null,
        foundProduct: false,
    }),
    props: ['ingragient', 'count_ingradient', 'type_measuring'],
    mounted() {
        this.findProduct(this.$props.ingragient);

    },
    methods: {
        handleClick() {
            this.show = !this.show;
        },

        findProduct(ingragient) {
            axios.get('/findProduct?product=' + ingragient)
                .then(res => {
                   if(res.data.result !== null) {
                       this.foundProduct = true;
                       this.product = res.data.result;
                   }
                    else {
                       this.foundProduct = false;
                   }

                    console.log(typeof res.data.result);


                })
                .catch(err => {
                    this.foundProduct = false;
                })
        }

    }
}
</script>
