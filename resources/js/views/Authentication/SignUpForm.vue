<template>
    <div>
        <!-- Page Loader -->
      <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
        <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
      </div>
       <b-form @reset="$v.$reset()">
            <custom-heading heading="Sign up to JewelerProfit" />

                <!-- <div class="row px-3" v-for="element in User" v-bind:key="element">
                    {{element}}
                    <custom-input :name="element" :placeholder="element" size="sm" :id="'signup_'+element+'_field'" msg="" @input="setValue($event)"/>
                </div> -->
                
                <b-form-group>
                    <b-form-input type="text" id="fullNameField"  class="round-border"
                        :class="{ 'is-invalid': $v.User.fullname.$error }" placeholder="Enter full name"
                        v-model.trim="$v.User.fullname.$model" @blur="$v.User.fullname.$touch" name="fullname"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.User.fullname.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.fullname.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.User.fullname.$params.maxLength.max})}}
                    </div> 
                </b-form-group>

                <b-form-group>
                    <b-form-input type="text" id="userNameField"  class="round-border"
                        :class="{ 'is-invalid': $v.User.username.$error }" placeholder="Enter user name"
                        v-model.trim="$v.User.username.$model" @blur="$v.User.username.$touch" name="username"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.User.username.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.username.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.User.username.$params.maxLength.max})}}
                    </div>
                </b-form-group>

                <b-form-group>
                    <b-form-input type="text" id="emailField"  class="round-border"
                        :class="{ 'is-invalid': $v.User.email.$error }" placeholder="Enter email"
                        v-model.trim="$v.User.email.$model" @blur="$v.User.email.$touch" name="email"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.User.email.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.email.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.User.email.$params.maxLength.max})}}
                    </div>
                </b-form-group>

                <b-form-group class="eye_pass">   
                    <b-form-input  v-if="showPassword" type="text" id="passwordField"  class="round-border"
                        :class="{ 'is-invalid': $v.User.password.$error }" placeholder="Enter password"
                        v-model.trim="$v.User.password.$model" @blur="$v.User.password.$touch" name="password"></b-form-input>

                        <b-form-input  v-else type="password" id="passwordField"  class="round-border"
                        :class="{ 'is-invalid': $v.User.password.$error }" placeholder="Enter password"
                        v-model.trim="$v.User.password.$model" @blur="$v.User.password.$touch" name="password"></b-form-input>

                             
                                <span class="icon is-small is-right eyePassw" @click="toggleShow">
                                    <b-icon v-if="showPassword" icon='eye-slash' aria-hidden="true"></b-icon>
                                    <b-icon v-else icon='eye' aria-hidden="true"></b-icon> 
                                    
                                </span> 
                    <div class="invalid-feedback" v-if="!$v.User.password.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.User.password.$params.maxLength.max})}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.minLength">
                        {{$t('form.validation.minLength', {num: $v.User.password.$params.minLength.min})}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.containsUppercase">
                        {{$t('form.validation.containsUppercase')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.containsLowercase">
                        {{$t('form.validation.containsLowercase')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.containsNumber">
                        {{$t('form.validation.containsNumber')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.User.password.containsSpecial">
                        {{$t('form.validation.containsSpecial')}}
                    </div>
                </b-form-group>

                <custom-checkbox @valueToggled="User.ok_with_policy = $event">

                    <small class="text-sm">Creating an account means you're okay with our services with our 
                    <span class="text-success">Terms of Service, Privacy Policy</span>, 
                    and our default <span class="text-success">Notification Settings.</span></small> 

                </custom-checkbox>

            <!-- mq conditional layouts -->

            <mq-layout :mq="['phone', 'large_phone']">
                <!-- <h1>hehhehe</h1> -->
                <div class="mb-3 px-3" > 
                    <!-- div 1 -->
                    <div class="d-flex">
                        <custom-button variant="success" text="Sign up" @onSubmit="onSubmit()"/>
                    </div>
                    <!-- <div class="col-md-3 col-lg-5"> -->
                    <!-- div 2 -->
                    <div class="d-none row text-center d-block   mt-3">
                                    <small class="my-auto ml-2 mr-2 pb-3 d-block">Or Sign in with Social </small>

                        <div class="justify-content-around">

                            <custom-image src="assets/google.png" alt="Google Login" class="social-login"/>
                            <custom-image src="assets/facebook.png" alt="Facebook Login"  class="social-login"/>

                        </div>
                    </div>
                </div>
            </mq-layout>

            <mq-layout mq="portrait_tablet+">
                <!-- tablets and large screens i.e., laptops and desktops -->
                <div class=" d-block "> 
                    
                    <!-- div 1 -->
                    <div class="mb-2">

                        <custom-button variant="success" text="Sign up" @onSubmit="onSubmit()"/>

                    </div>
                     <div class="d-none row text-center d-block  pt-5 pb-5">
                                    <small class="my-auto ml-2 mr-2 pb-3 d-block">Or Sign in with Social </small>


                    <!-- div 2 -->
                    <div :class="`${($mq == 'portrait_tablet' || $mq == 'landscape_tablet') ?  'justify-content-around': 'justify-content-between'}`" class="row text-center col-lg-5 d-block m-auto">
                       
                        <a href="/login/google"><custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" /></a>
                        <a href="/login/facebook"><custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer" /></a>
                        </div>
                    </div>
                </div>
            </mq-layout>
        </b-form>
    </div>
</template>

<script>
import Checkbox from '../../components/Global/Checkbox.vue'
// Import component
import Loading from 'vue-loading-overlay';
import {mapActions} from 'vuex'
    /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email,
    } from "vuelidate/lib/validators";

export default {
  components: { 'custom-checkbox':Checkbox,
  'loading':Loading
   },
    data(){
        return {
            User: 
            {
                fullname: '', 
                username: '', 
                email: '', 
                password: '',
                ok_with_policy:true
            },
            alertMsg:'',
            fullPage: true,
            showPassword: false,

        }
    },
 
    validations: {
        User: {
            fullname: {
                required,
                maxLength: maxLength(30)
            },
            username: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            password: {
                required,
                minLength:minLength(8),
                maxLength:maxLength(12),
                containsUppercase: function(value) {
                    return /[A-Z]/.test(value)
                },
                containsLowercase: function(value) {
                    return /[a-z]/.test(value)
                },
                containsNumber: function(value) {
                    return /[0-9]/.test(value)
                },
                containsSpecial: function(value) {
                    return /[#?!@$%^&*-]/.test(value)
                }
            },
            ok_with_policy: {
                required,
            },
        },
    },

    methods:{
      ...mapActions('dataStore', ['setLoader']), 

        toggleShow() 
        {
            this.showPassword = !this.showPassword;
        },
        /***
         * call to Signup API
         */
        onSubmit(){
            
            this.$v.$touch();

            if (this.$v.$invalid) {

                let errorMsg = '';
                if(this.$v.User.fullname.$error){
                    errorMsg = 'FullName';
                }
                
                if(this.$v.User.username.$error){
                    errorMsg = errorMsg? errorMsg+', UserName': 'UserName';
                }

                if(this.$v.User.email.$error){
                    errorMsg = errorMsg? errorMsg+', Email': 'Email';
                }

                if(this.$v.User.password.$error){
                    errorMsg = errorMsg ? errorMsg +", Password": "Password";
                };            

                if (errorMsg !== '') {
                    this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])
                    return;
                }

            }
            this.setLoader(true);
            axios.post('/api/signup',{

                fullname: this.User.fullname,
                username: this.User.username,
                email: this.User.email,
                password: this.User.password,
                ok_with_policy: this.User.ok_with_policy

            }).then(response=>{
                
                if(response){
                   this.setLoader(false);
                    this.$emit('showAlert',[response.data.response_header.response_message,'success'])
                }

            }).catch(error=>{

                this.setLoader(false);

                // this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])

                if(error.response){

                    if(error.response.data.errors){
                        let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                            this.$emit('showAlert',[msg,'danger'])
                    }else if(error.response.response_header){
                        if(error.response.response_header.response_message){
                            this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                    }
                    }else if(error.response.data){
                        if(error.response.data.response_header.response_message){
                            this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                        }
                    }

                }else{
                    this.$emit('showAlert',[error,'danger'])
                }

            });

        }
        },
}
</script>
