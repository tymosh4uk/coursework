<template>
    <div>
            <div class="uk-alert-danger" uk-alert v-if="error">
                <a class="uk-alert-close" uk-close></a>
                <p>Проверьте правильность введенный полей</p>
            </div>
            <form style="margin-bottom: 20px;">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend">Опубликовать пост</legend>

                    <div class="uk-margin">
                        <input class="uk-input" v-model="form.kitchen" type="text" placeholder="Заголовок">
                    </div>



                    <button class="uk-button uk-button-primary" @click.prevent="store">
                        <div uk-spinner v-if="loading"></div>
                        <span v-else>Опубликовать</span>
                    </button>
                </fieldset>

            </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    components: {

    },
    data: () => ({
        form: {
            kitchen: ""
        },
        loading: false,
        error: false
    }),
    methods: {
        store() {
            this.loading = true;
            axios.post('/api/kitchens', this.form, {
                headers: {
                    "Content-type": "application/json"
                }
            })
            .then(res => {
                if (res.data.status) {
                    this.$router.push('/receipt/' + res.data.kitchen.id);
                } else {
                    setTimeout(() => {
                        this.loading = false;
                    }, 300);
                    this.error = true;
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
