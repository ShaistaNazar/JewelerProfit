<template>
    <div class="pt-3">
        
        
        <b-form @submit="sendResetPasswordLink()" @reset="$v.$reset()">

            <div class="px-3 py-3 mb-3 justify-content-center">
                <h4>{{heading}}</h4>
                <p class="text-sm">please enter your email below</p>
            </div> 
            <b-form-group>

                <b-form-input type="email" id="emailField"  class="round-border"
                    placeholder="enter email"
                    v-model.trim="$v.User.email.$model" @blur="$v.User.email.$touch" name="forgot_password">
                </b-form-input>

                <div class="invalid-feedback" v-if="!$v.User.email.required">
                    {{$t('form.validation.required')}}
                </div>

                <div class="invalid-feedback" v-if="!$v.User.email.maxLength">
                    {{$t('form.validation.maxLength', {num: $v.User.email.$params.maxLength.max})}}
                </div>

            </b-form-group>

            <custom-button  variant="success" text="Send" @onSubmit="sendResetPasswordLink()"/>
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
        email
    } from "vuelidate/lib/validators";

export default {
    data(){
        return{
            heading:'Forgot Password?',
            User: 
            {
            email: '', 
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
        },
    },
methods:{// 
    /***
     * call to Signup API
     */
    sendResetPasswordLink (){

        this.$v.$touch();



        if (this.$v.$invalid) {
           
            let errorMsg = '';

            if(this.$v.User.email.$error){
                errorMsg = errorMsg? errorMsg+', Email': 'Email';
            }          

            if (errorMsg !== '') {
                    
                this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

                return;
            }

        }

        axios.post('/api/forgot/email',{

            email: this.User.email,

        }).then(response=>{

            // let token = response.data.data.token;
            // let user = response.data.data;
            let msg = response.data.response_header.response_message;
            this.$emit('showAlert',[msg,'success']);

        }).catch(error=>{
            
            if(error.response){
            if(error.response.data.errors){
                let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                this.$emit('showAlert',[msg,'danger'])
            }else if(error.response.data.response_header.response_message){
                this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
            }
            }else{
                this.$emit('showAlert',[error,'danger'])
            }

        });

    },
}

}
</script>