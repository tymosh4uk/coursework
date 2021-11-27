<template>
    <div>


        <div style="margin-bottom: 100px">
            <h3 class="uk-heading-small uk-text-center">Статистика по кухням</h3>
            <div>
                <canvas ref="canvas"></canvas>
            </div>
        </div>
        <p style="color: #fff">vrgt</p>
    </div>
</template>

<script>

import Spin from "../components/Spin";
import {Pie} from 'vue-chartjs'
import axios from "axios";


export default {
    components: {
        Spin
    },
    extends: Pie,
    data: () => ({
        categories: [],
        dataLength: Number,
        backgroundColors: [],
        borderColors: [],
        loading: true,
        error: false
    }),
    mounted() {
        this.loadData()

        this.loading = false
    },
    methods: {
        setup() {
            this.renderChart({
                labels: this.categories.map(c => c.kitchen),
                datasets: [{
                    label: '# of Votes',
                    data: this.categories.map(c => c.total),
                    backgroundColor: this.backgroundColors,
                    borderColor: this.borderColors,
                    borderWidth: 1
                }]
            })
        },
        randomBackgroundColors() {
            for(var i = 0; i < this.dataLength; i++) {
                this.backgroundColors.push('rgb(' + (Math.floor((256-229)*Math.random()) + 230) + ',' +
                    (Math.floor((256-229)*Math.random()) + 230) + ',' +
                    (Math.floor((256-229)*Math.random()) + 230) + ')')
            }
        },
        randomBorderColors() {
            for(var i = 0; i < this.dataLength; i++) {
                this.borderColors.push('#'+(Math.random()*0xFFFFFF<<0).toString(16))
            }
        },
        loadData() {
            axios.get('/getChartInfoKitchens')
                .then(res => {
                    this.categories = res.data;
                    this.dataLength = this.categories.length;
                    this.randomBackgroundColors()
                    this.randomBorderColors()
                    console.log(this.backgroundColors)
                    this.setup();
                    // console.log(this.categories);
                    // this.setupPagination(res.data.receipts);


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
