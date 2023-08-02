<template>
    <div class="container sigin_div pt-5  mx-auto">
    <span class="home_splash"><img src="assets/Jeweler_splash.png" class="" alt="..." /></span>
        
        <!-- Alert component -->
        <custom-alert :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
        <!-- Header Component -->
        
<router-link to="/">
        <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto mt-3 mb-3 d-block"/>
</router-link>
        <div class="row ">
            <div class="col-md-3 ">
                <!-- <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/> -->
            </div>
            <div class="col-md-6 text-center">
                <signin-form @showAlert="showAlert($event)" />
                <div>
                    <strong>New user? </strong> &nbsp; <custom-link link_text="Sign Up" name="signup"/>
                </div>
            </div>
            <div class="col-md-3 "> 
            </div>
        </div>

    </div>

</template>

<script>
import useVuelidate from '@vuelidate/core'
import { required, email } from '@vuelidate/validators'

    export default {
        
        setup () {
            return { v$: useVuelidate() }
        },
        mounted() {
        },
        
        data(){
            return {
                termsOfService: "",
                to_signin_link_google:'',
                to_signin_link_fb:'',
                User:{
                    email:'',
                    password:''
                },
                alertMsg:'',
                showDismissibleAlert: false,
                alertMsg:'',
                variant:null,

            }
        },
        mounted(){
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
            
        //     }
        //     else{

        //         next('/signup')

        //     }
            
        // }
    }
</script>

