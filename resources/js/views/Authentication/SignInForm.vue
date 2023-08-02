<template>
    <div>
    <b-form @submit="onSubmit" @reset="$v.$reset()">
        <custom-heading class="m-0 p-0" heading="Sign in to JewelerProfit" />
         <!-- <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
            <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
          </div> -->
        
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
  
       <div class="d-flex flex-nowrap ">

            <custom-checkbox v-model="User.remember_me">
                <span>Remember me</span> 
            </custom-checkbox> 
       </div>


        <div class="pb-2">
            <custom-button variant="success" text="Sign in" @onSubmit="onSubmit()"/>
        </div>

            <custom-link link_text="Forgot Password?" name="send-email" ></custom-link>

        <div class="row text-center d-block my-3 mx-3 p-3 p-lg-5 ">
            <small class="my-auto ml-2 mr-2 pb-3 d-block">Or Sign in with Social </small>

            <!-- <custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" @imageClicked="socialSignin('google')" /> -->
            <!-- <custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer"  @imageClicked="socialSignin('facebook')"/> -->
            <a href="/login/google" class="ml-1 mr-1"><custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" /></a>
            <a href="/login/facebook" class="ml-1 mr-1"><custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer" /></a>
        </div>


        </b-form>
    </div>
</template>

<script>
import Checkbox from '../../components/Global/Checkbox.vue'
import Loading from 'vue-loading-overlay';
import {mapActions} from 'vuex'

     /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email
    } from "vuelidate/lib/validators";
export default {
  components: { Checkbox,
  'loading':Loading},
  mounted(){
      
  },
    data(){
        return {
            User: 
            {
            email: '', 
            password: '',
            remember_me:false
            },
            showPassword: false,
        }
    },
    validations: {
        User: {
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
        },
    },
    methods:{
      ...mapActions('dataStore', ['setLoader']), 
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        /***
         * call to Signin API
         */
        onSubmit(){

            this.setLoader(true);
            this.$v.$touch();
            if (this.$v.$invalid) {
                let errorMsg = '';
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

            // this.isLoading = true;

            axios.post('/api/login',{

                email: this.User.email,
                password: this.User.password,
                remember_me: this.User.remember_me

            }).then(response=>{

                this.setLoader(false);

                localStorage.clear();
                let token = response.data.data.token;
                let msg = response.data.response_header.response_message;
                this.$emit('showAlert',[msg,'success']);
                localStorage.setItem('token', token);

                this.$router.push({
                    name: 'home',
                });
            }).catch(error=>{

                this.setLoader(false);
                if(error.response){
                    if(error.response.data.response_header){

                        if(error.response.data.response_header.response_message){
                            let msg = error.response.data.response_header.response_message;
                            this.$emit('showAlert',[msg,'danger'])
                        }
                }}else{
                    this.$emit('showAlert',[error,'danger'])
                }

            });

        },
    },
}
</script>
<style scoped>

.line{

    width: 2em;
    border-bottom: 1px solid white;
    display: block;
    margin-top: 1em;
    margin-bottom: 1em;
    margin-right: auto;
    margin-left: auto;

}

</style>