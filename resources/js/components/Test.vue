<template>
    <nav class="uk-navbar-container" uk-navbar>
        <div class="uk-navbar-left">

            <ul class="uk-navbar-nav">
                <li v-for="link in links">
                    <router-link :to="link.href">{{ link.title }}</router-link>
                </li>
            </ul>

        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            links: [
                {
                    title: "Головна",
                    href: "/"
                },
                {
                    title: "Блог",
                    href: "/blog"
                },
                {
                    title: "Создать кухню",
                    href: "/create"
                },
                {
                    title: "Создать рецепт",
                    href: "/createReceipt"
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>
