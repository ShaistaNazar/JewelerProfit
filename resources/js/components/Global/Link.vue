<template>
        
    <router-link
        class="text-success pointer"
            :to="{name:name}"
        >
        {{link_text}}
    </router-link>

</template>

<script>
export default {
    props:['link_text','name']
}
</script> 

<style scoped>

</style>