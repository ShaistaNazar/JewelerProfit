<template>
    <div class="d-flex flex-column justify-content-center text-center">
        <!-- <custom-image src="/assets/icon.png" alt="Man Image" class_to_pass="text-center mx-auto man-icon mb-3"/> -->
        <h4 class="tittle_highlight">{{heading}}</h4>
    </div>
</template>

<script>
export default {
    props: ['heading'],
    methods:{
    }
}
</script>
<style scoped>
.man-icon { max-width: 90px;}
</style>