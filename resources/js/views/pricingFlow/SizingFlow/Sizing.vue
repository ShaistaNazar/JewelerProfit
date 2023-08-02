<template>
    <span>
        <page-not-found />
        <!-- <button @click="movetoSignin()"></button> -->
        <router-link to='/signin'>signin</router-link>
    </span>
</template>
<script>
import PageNotFound from '../../../layout/PageNotFound.vue'
export default {
    components:{
     'page-not-found':PageNotFound   
    },
    data(){

    },
    methods:{
        movetoSignin(){
            this.$router.push(
                {
                    name:'signin'
                }
            )
        }
    }
}
</script>