<template>
    <div class="container sigin_div pt-5 mx-auto">
    <span class="home_splash splashForm"><img src="assets/Jeweler_splash.png" class="" alt="..." /></span>

        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
        <!-- Header Component -->
        
<router-link to="/">
        <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto mx-auto mt-3 mb-3 d-block"/>
</router-link>
        <div class="row d-flex">
            <div class="col-md-3 ">
                <!-- <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/> -->
            </div>
            
            <div class="col-md-6 text-center">
                <signup-form @showAlert="showAlert($event)" @alertDismissed="clearAlert()"/>
            </div>
 
            <div class="col-md-3">
            </div>
        </div>

        <div class="text-center">
            <strong>Already a member? </strong> &nbsp; <custom-link link_text="Sign In" name="signin"/>
        </div>

    </div>
</template>

<script>

import Header from '../../components/Global/Header.vue'
export default {
  components: { 'custom-header':Header },

        mounted() {
            
            },
        
        data(){
            return {
                termsOfService: "",
                to_signin_link_google:'',
                to_signin_link_fb:'',
                showDismissibleAlert: false,
                alertMsg:'',
                variant:null
            }
        },
        methods:{

            
            /**
             * alert generator
             */

            showAlert($event) {

                this.alertMsg = $event[0];
                this.variant = $event[1];
                this.showDismissibleAlert =  true;

            },

            /**
             * Clear alert
             */

            clearAlert() {
                this.alertMsg = '';
                this.variant = '';
                this.showDismissibleAlert = false;
            },

        },
        // beforeRouteEnter(to, from, next) {
        //     //check if user is verified
        //     var token = localStorage.getItem('token');
        
        //     if(token){

        //         next('/');

        //     }
        //     else{

        //         next();

        //     }
            
        // }
        
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}
</style>
