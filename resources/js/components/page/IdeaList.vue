<template>
    <div>
        <ul style="list-style: none; margin: 0; padding: 0;">
            <li v-for="record of ideas">
                <router-link :to="'/idea/' + record.id">
                    <item :idea="record"/>
                </router-link>

            </li>
        </ul>
    </div>
</template>

<script>
import Item from "./ItemIdea";
import Spin from "../Spin";

export default {
    components: {
        Spin,
        Item
    },
    props: {
        ideas: {
            required: true,
            type: Array
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
