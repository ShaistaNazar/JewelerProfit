<template>
    <b-form-group>
        <b-form-input 
            class="mb-3 round-border" 
            type="text" 
            :name="name" 
            :placeholder="placeholder"
            :size="size"
            :aria-describedby="id"
            v-model="inputVal"
            >
        </b-form-input>
        <b-form-invalid-feedback
            :id="id"
            >{{msg}}</b-form-invalid-feedback>
    </b-form-group>
</template>

<script>

export default {

    props: ['name','placeholder','size','id','msg'],
    mounted() {
    },
        
    data(){
        return {
            inputVal: "",
        }
    },

    computed: {
        inputVal: {
            get() {
                return this.inputVal;
            },
            set(val) {
                this.$emit('input', val);
            }
        }
    },
        
}
</script>
