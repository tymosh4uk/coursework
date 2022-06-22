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
                <div class="content__idea-info__container">
                    <div class="comments__header__container">
                        <span class="comments__header">Поділитися</span>
                    </div>

                    <button class="share-btn" style="background-color: #179cde">
                        <ShareNetwork
                            network="telegram"
                            v-bind:url="getLink()"
                            title="Awesome Article"
                            description="This is an awesome article for awesome readers"
                            hashtags="Frontend, Programming">
                        <span style="color: #fff">
                            <i class="fa-solid fa-paper-plane"></i>
                            <!--                            <i class="fa-brands fa-telegram"></i>-->
                            <!--                          <font-awesome-icon icon="fa-brands fa-facebook-f" style="color: #fff; width: 20px"/>-->
                        </span>
                        </ShareNetwork>
                    </button>

                    <button class="share-btn" style="background-color: #25d366">
                        <ShareNetwork
                            network="whatsApp"
                            v-bind:url="getLink()"
                            title="Awesome Article"
                            description="This is an awesome article for awesome readers"
                            hashtags="Frontend, Programming">
                        <span style="color: #fff">
                            <i class="fa-brands fa-whatsapp"></i>
                        </span>
                        </ShareNetwork>
                    </button>

                    <button class="share-btn" style="background-color: #e60019">
                        <ShareNetwork
                            network="pinterest"
                            v-bind:url="getLink()"
                            title="Awesome Article"
                            description="This is an awesome article for awesome readers"
                            hashtags="Frontend, Programming">
                        <span style="color: #fff">
                            <i class="fa-brands fa-pinterest"></i>
                        </span>
                        </ShareNetwork>
                    </button>

                    <button class="share-btn" style="background-color: #1da1f2">
                        <ShareNetwork
                            network="twitter"
                            v-bind:url="getLink()"
                            title="Awesome Article"
                            description="This is an awesome article for awesome readers"
                            hashtags="Frontend, Programming">
                        <span style="color: #fff">
                            <i class="fa-brands fa-twitter"></i>
                        </span>
                        </ShareNetwork>
                    </button>

                    <button class="share-btn" style="background-color: #315efb">
                        <ShareNetwork
                            network="email"
                            v-bind:url="getLink()"
                            title="Awesome Article"
                            description="This is an awesome article for awesome readers"
                            hashtags="Frontend, Programming">
                        <span style="color: #fff">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        </ShareNetwork>
                    </button>
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
        let recaptchaScript = document.createElement('script')
        recaptchaScript.setAttribute('src', 'https://kit.fontawesome.com/fba0085d4d.js')
        document.head.appendChild(recaptchaScript)
        this.getIdea(this.$route.params.id);
    },
    methods: {
        getLink() {
            this.currentURL = window.location.origin + this.$route.path;
            return window.location.origin + this.$route.path;
        },
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
