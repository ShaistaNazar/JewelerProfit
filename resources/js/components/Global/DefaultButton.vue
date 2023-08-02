<template>
    <b-button :variant="variant" class="round-border shadow-lg" :disabled="disabled" @click="onSubmit()">
        {{text}}
    </b-button>
</template>

<script>
export default {

    props: [
        'text',
        'variant',
        'disabled'
    ],

    methods: {
        onSubmit() {
            this.$emit('onSubmit');
        }
    }

}
</script>
