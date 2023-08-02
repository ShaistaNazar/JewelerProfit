
<template>
    <div class="row px-3 mb-4">
        <b-form-checkbox size="sm" id="chk1" name="chk"  @change="toggleValue" v-model="value">
            <slot></slot>
        </b-form-checkbox>
    </div>
</template>
<script>
export default {
    props:['checked'],
    data(){
        return{
            value:this.checked
        }
    },
    methods:{
        toggleValue(checked){

            checked ? this.$emit('valueToggled',true) :this.$emit('valueToggled',false);

        }
    },
    mounted(){

        
    }
}
</script>
