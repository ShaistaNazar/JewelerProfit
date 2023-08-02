<template>
    <div>
        <b-form @submit="onSubmit()" @reset="$v.$reset()">
            <b-form-group>
                <div class="row px-3 py-3 mb-3 justify-content-center">
                <h4>{{heading}}</h4>
                <p class="text-sm">Create new password so that yo can access your account</p>
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
        <b-form-group>   
            <b-form-input type="text" id="confirm_passwordField"  class="round-border"
                :class="{ 'is-invalid': $v.User.confirm_password.$error }" placeholder="Confirm password"
                v-model.trim="$v.User.confirm_password.$model" @blur="$v.User.confirm_password.$touch" name="confirm_password">
            </b-form-input>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.required">
                {{$t('form.validation.required')}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.maxLength">
                {{$t('form.validation.maxLength', {num: $v.User.confirm_password.$params.maxLength.max})}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.minLength">
                {{$t('form.validation.minLength', {num: $v.User.confirm_password.$params.minLength.min})}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.containsUppercase">
                {{$t('form.validation.containsUppercase')}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.containsLowercase">
                {{$t('form.validation.containsLowercase')}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.containsNumber">
                {{$t('form.validation.containsNumber')}}
            </div>
            <div class="invalid-feedback" v-if="!$v.User.confirm_password.containsSpecial">
                {{$t('form.validation.containsSpecial')}}
            </div>
        </b-form-group>
        <!-- <input hidden name="token" id="hiddenTokenField" :value="request()->get('token')"> -->
        <custom-button  variant="success" text="Save" @onSubmit="resetPassword()"/>
       </b-form>
    </div>
</template>
<script>
     /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email,
        sameAs
    } from "vuelidate/lib/validators";
export default {

    mounted() {
        
    },

    data(){
        return {
            User: 
            {
                email: '', 
                password: '',
                confirm_password:'',
                token:null,
            },
            heading:'Create new Password'
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
            confirm_password: {
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
                },
                sameAsPassword:sameAs('password')
            },
        },
    },
    methods:{

        /***
         * call to forgot password API
         */
        resetPassword(){
            // var token = document.getElementById("hiddenTokenField").value;
            
            this.$v.$touch();
            if (this.$v.$invalid) {

                let errorMsg = '';

                if(this.$v.User.email.$error){
                    errorMsg = errorMsg? errorMsg+', Email': 'Email';
                }

                if(this.$v.User.password.$error){
                    errorMsg = errorMsg ? errorMsg +", Password": "Password";
                };  
                
                if(this.$v.User.confirm_password.$error){
                    errorMsg = errorMsg ? errorMsg +", Confirm Password": "Confirm Password";
                };  

                if (errorMsg !== '') {
                        
                    this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

                    return;
                }

            }
            axios.post('/api/password/reset',{

                email: this.User.email,
                password: this.User.password,
                password_confirmation: this.User.confirm_password,
                token:this.$route.query.token

            }).then(response=>{

                if(response){

                }
                this.$router.push({
                    name: 'signin',
                });

            }).catch(error=>{
                
                if(error.response){
                if(error.response.data.errors){
                    let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                    this.$emit('showAlert',[msg,'danger'])
                }else if(error.response.data.data.response_header){
                    if(error.response.data.data.response_header.response_message)
                    this.$emit('showAlert',[error.response.data.data.response_header.response_message,'danger'])
                }
                }else{
                    this.$emit('showAlert',[error,'danger'])
                }

            });

        },
    },  
}
</script>
