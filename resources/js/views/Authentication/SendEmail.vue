<template>
    <div class="container  pt-5 mx-auto">
    <span class="home_splash splashForm"><img src="assets/Jeweler_splash.png" class="" alt="..." /></span>

        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        <!-- Header Component -->
        <custom-header/>
<router-link to="/">
        <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/>
</router-link>
        <div class="row d-flex">
            <div class="col-md-3 ">
                <!-- <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/> -->
            </div> 
            <div class="col-md-6 text-center">
                <send-email-form @showAlert="showAlert($event)"/>
            </div>

            <div class="col-md-3 ">
                <!-- <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/> -->
            </div>
        </div>

    </div>
</template>

<script>
import SendEmailForm from './SendEmailForm.vue'
    export default {
        components:{
            'send-email-form': SendEmailForm
        },

        mounted() {
        },
        
        data(){
            return {
                termsOfService: "",
                to_signin_link_google:'',
                to_signin_link_fb:'',
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
<style scoped>

.socialImg{
    width: 20px !important;
}

</style>
