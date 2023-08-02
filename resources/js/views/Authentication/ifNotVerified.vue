<template>
    <div class="container pb-5">
    <span class="home_splash splashForm"><img src="assets/Jeweler_splash.png" class="" alt="..." /></span>

      <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

    <div class="envelop_container  pt-5 mt-5">
        <div class="container  mt-5"> 
            <div class="row">
              <div class="col-lg-1">
                 
              </div>
              <div class="col-lg-10">
                <div class="bg-lightblue  text-center text-white">
                  <h3 class="pb-4 text-uppercase">{{subHeading}}</h3>
                  <hr class="my-4">

                  <div class="row">
                    <div class="col-lg-3">
                 
                    </div>
                    <div class="col-lg-6">
                          <b-form-group>
                            <b-form-input type="text" id="emailField"  class="round-border p-4"
                                :class="{ 'is-invalid': $v.User.email.$error }" placeholder="Enter email"
                                v-model.trim="$v.User.email.$model" @blur="$v.User.email.$touch" name="email"></b-form-input>
                            <div class="invalid-feedback" v-if="!$v.User.email.required">
                                {{$t('form.validation.required')}}
                            </div>
                            
                        </b-form-group>
                      <b-form-group>
                        <div>
                            <custom-button variant="success" text="Verify Email" @onSubmit="onSubmit()"/>
                        </div>
                        </b-form-group>  
                    </div>
                    <div class="col-lg-3">
                 
                    </div>
                  </div>
                  <div class="pipe-separated-list-container"> 
                    <ul class="m-0"> 
                        <li><a href="#" class="text-success">Terms & Conditions</a></li> 
                        <li><a href="#" class="text-success">Privacy Policy</a></li>  
                    </ul> 
                  </div> 
                </div>
              </div>
              <div class="col-lg-1">
                 
              </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
     /**
     * Vuelidate items
     */
    import {
        required,
        email
    } from "vuelidate/lib/validators";
  export default {
    data() {
      return {
        selected: [], // Must be an array reference! 
        radio_options: [

                 
        ], 
        User: {
          email: null,
        },
        subHeading:"Please verify your Email first!" ,
        showDismissibleAlert: false,
        alertMsg:'',
        variant:null
      }
    },
    validations: {
        User: {
            email: {
                required,
                email,
            },
        },
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

      onSubmit(){

          this.$v.$touch();

          if (this.$v.$invalid) {

            let errorMsg = '';

            if(this.$v.User.email.$error){
                errorMsg = errorMsg? errorMsg+', Email': 'Email';
            }          

            if (errorMsg !== '') {
                    
                this.showAlert([this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger']);

                return;
            }

          }
          this.isLoading = true;
          axios.post('/api/resend-email',{

              email: this.User.email,

          }).then(response=>{
            if(response){

              this.isLoading = false;
              this.showAlert(['Congratulations Email sent successfully.','success']);

            }
              

          }).catch(error=>{

              this.isLoading = false;
              if(error.response.data.errors){
                
                  let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                  this.showAlert([msg,'danger']);

              }else if(error.response.data.response_header.response_message){

              this.showAlert([error.response.data.response_header.response_message,'danger']);

              }else{
              this.showAlert([error,'danger']);

              }
              
          });

      }
    }
  }
</script>  