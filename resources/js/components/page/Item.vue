<template>
    <div style="display: flex">
        <div class="uk-card uk-card-default uk-card-body uk-width-1-2@m">
            <h3 class="uk-card-title">{{ kitchen }}</h3>
            <p>{{ date }} <a href="#">dolor</a> sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        kitchen: {
            type: String,
            default: "NULL"
        },
        date: {
            type: String,
            default: "NULL"
        }
    }
}
</script>

<style scoped>

</style>
