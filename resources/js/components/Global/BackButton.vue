<template>
    <b-button :variant="variant" class="round-border shadow-lg" @click="$router.go(-1)"> 
        <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
    </b-button>
</template>

<script>
export default {
    props: {
    text:String,
    variant:String,
    },

    

}
</script>
