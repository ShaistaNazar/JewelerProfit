<template>
    <b-img :src="src" :alt="alt" :class="[class_to_pass,$mq]" @click="imageClicked()"></b-img>
</template>

<script>
export default {
    props: ['src','class_to_pass','alt'],
    methods:{
        imageClicked() {
            this.$emit('imageClicked');
        },
    }
}
</script>