<template>
  <div>
      <h1>Blog page</h1>
      <spin v-if="loading"></spin>
      <div v-else>
          <item
              v-for="item in kitchens"
              :kitchen="item.kitchen"
              :date="item.created_at"/>
      </div>
  </div>
</template>

<script>
import Spin from "../components/Spin";
import axios from 'axios';
import Item from '../components/page/Item';

export default {
    components: {
        Spin,
        Item
    },

    data: () => ({
        loading: true,
        kitchens: []
    }),
    mounted() {
        this.loadKitchen()
    },
    methods: {
        loadKitchen() {
            axios.get('/api/kitchens')
                .then(res => {

                    this.kitchens = res.data;

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
