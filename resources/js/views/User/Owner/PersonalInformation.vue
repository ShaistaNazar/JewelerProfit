<template>
    <div class="container  mt-5 mx-auto">
        <custom-alert :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block mb-3"/> -->

        <div class="container mb-5 p-0">
            <man-with-heading class="" heading="Shop Details"/>

            <div class="row pt-2">
                <div class="col-lg-3 text-left">
                    <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                        <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                    </b-button>
                </div>
            </div>

            <div class="text-center">
                <personal-form @showAlert="showAlert($event)" />
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
        mounted(){
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

