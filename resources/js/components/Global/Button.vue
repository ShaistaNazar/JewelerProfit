<template>
    <b-button href="#" block :variant="variant" class="round-border shadow-lg" @click="onSubmit()">
        {{text}} 
    </b-button>
</template>

<script>
export default {
    props: {
    text:String,
    variant:String,
    },

    methods: {

        onSubmit() {
            this.$emit('onSubmit');
        }
        
    }

}
</script>
