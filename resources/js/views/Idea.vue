<template>
    <div>
        <spin v-if="loading"></spin>
        <div v-else>
            <div uk-alert v-if="idea.not_found">
                <a class="uk-alert-close" uk-close></a>
                <h3>Не знайдено!!!</h3>
            </div>
            <div v-else>
                <div class="content__container">
                    <div class="content__header">
                        <div class="content__header__title__wrapper">
                            <span class="content__header__title__inner">
                                <h1 class="content__header__title" style="ma">{{ idea.name }}</h1>
                            </span>
                        </div>
                    </div>

                    <div class="content__receipt__main-img__container">
                        <img class="content__receipt__main-img" :src="'../storage/ideas/'+ idea.image" alt=""/>
                    </div>
                </div>

                <div class="idea--container" v-html="idea.description">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Spin from "../components/Spin";
import axios from 'axios';

export default {
    components: {
        Spin
    },

    data: () => ({
        loading: true,
        idea: {
            not_found: false,
            name: "",
            image: "",
            description: "",
        }
    }),
    mounted() {
        this.getIdea(this.$route.params.id);
    },
    methods: {
        getIdea(id) {
            axios.get('/getIdea/' + id)
                .then(res => {
                    if(!res.data.status) {
                        this.idea.not_found = true;
                    }
                    else {
                        console.log(res.data.idea);
                        this.idea.name = res.data.idea.name;
                        this.idea.image = res.data.idea.image;
                        this.idea.description = JSON.parse(res.data.idea.description);
                    }


                    // console.log(this.steps);
                    this.loading = false;
                })
                .catch(err => {
                    this.not_found = true;
                    this.loading = false;
                })
        },
    }
}
</script>

<style scoped>

</style>
