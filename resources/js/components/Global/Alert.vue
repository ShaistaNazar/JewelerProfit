<template>
    <div
    id="customAlert" 
    ref="customAlert" >
        <b-alert
            
            :variant="variant"
            dismissible
            :show="showDismissibleAlert"
            @dismissed="alertDismissed('alertDismissed')"
        >
        {{msg}}
        </b-alert>
    </div>
</template>
<script>
export default {
    props:['msg','showDismissibleAlert','variant'],
    data(){
        return{

        }
    },
    mounted(){

    setTimeout(() => {
        this.goto('customAlert')
        });

    },
    watch: {
        // showDismissibleAlert: function() {
        //     window.scrollTop(0)
        // }
    },
    methods:{
        alertDismissed(){
           this.$emit('alertDismissed')
        },
        goto(refName) {
            var element = this.$refs[refName];
            var top = element.offsetTop;
            window.scrollTo(0, top);
       }
    }
}
</script>
<style scoped>

</style>