<template>
  <div>

      <div v-if="receipts.length > 0">
          <carousel class="my-carousel" :items='1' :nav="false" :autoplay="true" :loop="true" :mouseDrag="true" :touchDrag="true" :slot="true">
              <div class="carousel__item__container" v-for="item in receipts">
                  <router-link :to="'/receipt/' + item.id">
                      <img class="carousel__image" :src="'../storage/images/'+ item.image">
                      <div class="carousel__content__container">
                            <div class="carousel__content__categories__container">
                                <div class="carousel__content__categories">
                                    {{ item.category }} •
                                </div>
                                <div class="carousel__content__categories">
                                    {{ item.kitchen }}
                                </div>
                            </div>
                            <h2 class="carousel__content__name">{{ item.name }}</h2>
                            <p class="carousel__content__author">Автор рецепту: {{ item.username }} {{ item.surname  }}</p>
                      </div>
                  </router-link>
              </div>

<!--              <template slot="prev"><span class="prev my-carousel__left-nav"><span uk-icon="arrow-left"></span></span></template>-->
<!--              <template slot="next"><span class="next"><span uk-icon="arrow-right"></span></span></template>-->
          </carousel>
      </div>
      <div class="home__items__container">
          <div class="home__receipts">
              <item
                  :receipts="receipts"
                  :ingradients="receipts"
              />
          </div>
          <div class="home__receipts">
              <itemIdea
                  :ideas="ideas"
              />
          </div>
      </div>
  </div>
</template>

<script>
import axios from "axios";
import carousel from 'vue-owl-carousel'
import Item from '../components/page/ReceiptList';
import ItemIdea from '../components/page/IdeaList';


export default {
    components: {
        carousel,
        Item,
        ItemIdea
    },
    data: () => ({
        receipts: [],
        ideas: [],
        loading: true,
    }),
    mounted() {
        this.loadData()
    },
    methods: {
        loadData() {
            axios.get('/getTopReceipts')
                .then(res => {
                    // console.log(res.data);
                    this.receipts = res.data;
                    // this.setupPagination(res.data.receipts);


                    setTimeout(() => {
                        this.loading = false;
                    }, 500)

                })

            axios.get('/getTopIdeas')
                .then(res => {
                    if(res.data.status) {
                        console.log(res.data.ideas);
                        this.ideas = res.data.ideas;
                    }


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
