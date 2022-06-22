<template>
    <div>
        <div class="receipt__container" style="height: 184px">
            <div class="idea--container">
                <div class="idea__img--wrapper">
                    <img :src="'../storage/ideas/'+ idea.image" />
                </div>
                <div class="idea__info--wrapper">
                    <div class="idea__title--wrapper">
                        <h5 class="idea__title">{{idea.name}}</h5>
                    </div>
<!--                    <div class="idea__line&#45;&#45;wrapper">-->
<!--                        <span class="idea__line"></span>-->
<!--                        <span class="idea__line"></span>-->
<!--                        <span class="idea__line"></span>-->
<!--                    </div>-->
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data: () => ({
        mobile: null,
        windowWidth: null,
        likesCount: 0,
        dislikesCount: 0,
        savedsCount: 0,
    }),
    props: {
        idea: {
            required: true
        }
    }
}
</script>
