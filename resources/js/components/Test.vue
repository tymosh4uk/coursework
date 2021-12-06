<template>
    <nav class="uk-navbar-container" style="height: 80px" uk-navbar>
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
                    title: "Статистика",
                    href: "/admin"
                },
                {
                    title: "Рецепти",
                    href: "/adminRecepty"
                },
                {
                    title: "Додання",
                    href: "/adminCreate"
                },
                {
                    title: "Створити рецепт",
                    href: "/createReceipt"
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>
