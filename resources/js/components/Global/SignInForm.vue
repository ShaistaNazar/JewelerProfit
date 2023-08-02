<template>
    <div>
    <b-form @submit="onSubmit" @reset="$v.$reset()">
        <custom-heading heading="Sign in to JewelerProfit" />
        
       <div class="row text-center justify-content-between my-3 mx-3">
            <small class="my-auto"> Sign in using </small>
            <!-- <custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" @imageClicked="socialSignin('google')" /> -->
            <!-- <custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer"  @imageClicked="socialSignin('facebook')"/> -->
            <a href="/login/google"><custom-image src="assets/google.png" alt="Google Login" class="social-login pointer" /></a>
            <a href="/login/facebook"><custom-image src="assets/facebook.png" alt="Facebook Login" class="social-login pointer" /></a>
        </div>
        
        <div class="line my-4 mx-auto"></div>
        
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

        <b-form-group>   
            <b-form-input type="text" id="passwordField"  class="round-border"
                :class="{ 'is-invalid': $v.User.password.$error }" placeholder="Enter password"
                v-model.trim="$v.User.password.$model" @blur="$v.User.password.$touch" name="password">
            </b-form-input>
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
  
       <div class="d-flex flex-nowrap justify-content-around">

            

            <b-form-checkbox size="sm" id="chk1" name="chk"  v-model="User.remember_me">
                Button Checkbox <b>(Checked: {{ User.remember_me }})</b>
            </b-form-checkbox>

            
            <custom-link link_text="Forgot Password?" name="send-email" ></custom-link>

       </div>
 
        <div>
            <custom-button variant="success" text="Sign in" @onSubmit="onSubmit()"/>
        </div>

        </b-form>
    </div>
</template>

<script>
import Checkbox from './Checkbox.vue'

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
  components: { Checkbox },
  mounted(){

    console.log(localStorage.getItem('signup_user'));
    
  },
    data(){
        return {
            User: 
            {
            email: '', 
            password: '',
            remember_me:false
            },
            
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
            /***
             * call to Signup API
             */
            onSubmit(){

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
                localStorage.clear();
                axios.post('/api/login',{

                    email: this.User.email,
                    password: this.User.password,
                    remember_me: this.User.remember_me

                }).then(response=>{

                    // this.isLoading = false;
                    let token = response.data.data.token;
                    let user = response.data.data;
                    let msg = response.data.response_header.response_message;
                    this.$emit('showAlert',[msg,'success']);
                    
                    new Promise(function(resolve, reject) {
                    localStorage.setItem('authenticated_user', user.email)
                    localStorage.setItem('token', token)
                    resolve(true);
                    return true;
                    }).then(function(result) { // (**)
                    context.$router.push({
                        name: 'home',
                    });
                    return true;
                    });

                }).catch(error=>{

                    // this.isLoading = false;
                    console.log(error.response);
                    if(error.response){
                    if(error.response.data.errors){
                        let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                        this.$emit('showAlert',[msg,'danger'])
                    }else if(error.response.data.response_header){
                        if(error.response.data.response_header.response_message){
                            let msg = error.response.data.response_header.response_message;
                            this.$emit('showAlert',[msg,'danger'])
                        }
                    }if(error.response.data.message){
                        let msg = error.response.data.message;
                        this.$emit('showAlert',[msg,'danger'])
                    }
                    }else{
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