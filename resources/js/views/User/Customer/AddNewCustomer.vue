<template>
    <div class="container px-0 px-sm-1 px-md-2 px-lg-3 px-xl-5 mx-auto pt-4">
        <custom-alert :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <div class="container">
            <man-with-heading class="" heading="Add New Customer"/>
        <div class="row">
            <div class="col-lg-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </div> 
            <div class="text-center mt-4 mb-5">
                <customer-form @showAlert="showAlert($event)" />
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

