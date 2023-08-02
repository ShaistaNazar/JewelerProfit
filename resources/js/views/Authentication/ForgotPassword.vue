<template>
    <div class="container pt-5 mx-auto">
    <span class="home_splash splashForm"><img src="assets/Jeweler_splash.png" class="" alt="..." /></span>

        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
<router-link to="/">
        <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/>
</router-link>
        <div class="row d-flex">
            <div class="col-lg-3 "> 
            </div>

            <div class="col-lg-6 text-center">
                <forgot-password-form @showAlert="showAlert"/>
            </div>
            <div class="col-lg-3 "> 
            </div>
        </div> 

        <div>
            <custom-footer/>
        </div>

    </div>
</template>

<script>

import ForgotPasswordForm from './ForgotPasswordForm.vue'

export default {

    components: { 'forgot-password-form':ForgotPasswordForm },

        mounted() {
        },
        
        data(){
            return {
                email:'',
                password:'',
                confirmPassword:'',
                showDismissibleAlert:false,
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

        }
    
    }
</script>

