<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center"> 

        <div class="row">
            <div class="col-lg-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
        </div> 

        <h3 class="pb-5 text-uppercase pt-3 mt-5">{{subHeading}}</h3>

        
        <div class="container tabs_setting"> 
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Jewelers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sale Staff</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="shop-tab" data-toggle="tab" href="#shop" role="tab" aria-controls="shop" aria-selected="false">Shop Details</a>
                </li>
            </ul> 
                <div class="row  bg-lightblue p-5 mb-5">
                  <div class="col-lg-1">
                     
                  </div>
                   <div class="col-lg-10">
                     <div class="pt-3 pb-3">
                       
                      <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          <div class="tabs_detail">

                            <div class="row">
                              <div class="col-lg-2"></div>
                              <div class="col-lg-8">
                                <h6>Does your store own a laser? if not did any laser work out?</h6>
                                    <b-form-group class="mb-4" v-slot="{ ariaDescribedby }">
                                          <b-form-radio-group
                                              v-model="selected"
                                              :options="options"
                                              :aria-describedby="ariaDescribedby"
                                              name="radio-inline"
                                          ></b-form-radio-group>
                                      </b-form-group>
                                      <div>
                                      <b-form-group>
                                        <h5 class="pb-4">OWNER/ADMIN DETAILS</h5>

                                          <b-form-input type="text" id="fullNameField"  class="round-border  mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.fullname.$error }" placeholder="Enter full name"
                                              v-model.trim="$v.Admin.fullname.$model" @blur="$v.Admin.fullname.$touch" name="fullname" ></b-form-input>
                                          <div class="invalid-feedback" v-if="!$v.Admin.fullname.required">
                                              {{$t('form.validation.required')}}
                                          </div>
                                          <div class="invalid-feedback" v-if="!$v.Admin.fullname.maxLength">
                                              {{$t('form.validation.maxLength', {num: $v.Admin.fullname.$params.maxLength.max})}}
                                          </div>

                                        <b-form-input type="text" id="emailField"  class="round-border mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.email.$error }" placeholder="Enter email"
                                              v-model.trim="$v.Admin.email.$model" @blur="$v.Admin.email.$touch" name="email"  disabled></b-form-input>
                                          <div class="invalid-feedback" v-if="!$v.Admin.email.required">
                                              {{$t('form.validation.required')}}
                                          </div>
                                          <div class="invalid-feedback" v-if="!$v.Admin.email.maxLength">
                                              {{$t('form.validation.maxLength', {num: $v.Admin.email.$params.maxLength.max})}}
                                          </div>

                                          <b-form-input type="text" id="contactField"  class="round-border  mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.contact.$error }" placeholder="Enter Contact"
                                              v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                                          <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                                              {{$t('form.validation.required')}}
                                          </div>

                                          <b-form-input type="text" id="addressField"  class="round-border mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.address.$error }" placeholder="Enter Address"
                                              v-model.trim="$v.Admin.address.$model" @blur="$v.Admin.address.$touch" name="contact"></b-form-input>
                                          <!-- <div class="invalid-feedback" v-if="!$v.Admin.address.required">
                                              {{$t('form.validation.required')}}
                                          </div> -->

                                      </b-form-group>



                                      <h5 class="pb-4">Password</h5>

                                      <b-form-group>
                                          <b-form-input type="text" id="contactField"  class="round-border  mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.contact.$error }" placeholder="New Password"
                                              v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                                              <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                                              {{$t('form.validation.required')}}
                                          </div>

                                          <b-form-input type="text" id="contactField"  class="round-border  mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.contact.$error }" placeholder="Confirm  Password"
                                              v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                                              <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                                              {{$t('form.validation.required')}}
                                          </div>
                                      </b-form-group>
                              </div>
                              <div class="col-lg-2"></div>
                            </div>

                            </div> 

                          </div>
                        </div>  
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                           <div class="tabs_detail">

                           <div class="row"> 
                              <div class="col-lg-12">  
                                    <table class="table id_table table-hover">
                                        <thead>
                                            <tr> 
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="jeweler in jewelers" :key="jeweler.id">
 
                                                <td>{{jeweler.fullname}}</td>
                                                <td>{{jeweler.email}}</td>
                                                <td>{{jeweler.contact_no}}</td>

                                                <td>
                                                    <div class="addEdit">

                                                        <button type="button" class="text-success" data-toggle="modal" data-target=".bd-example-modal-lg" @click="updateJeweler(jeweler.id)">
                                                            <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                                                        </button> 
                                                        <button class="text-danger" @click="deleteJeweler(jeweler.id)">
                                                            <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                                                        </button> 
                                                    </div>
                                                </td>
                                            </tr>                                 
                                        </tbody>

                                    </table> 

                              </div> 
                            </div>

                          </div> 


                          </div>
                           
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                          <div class="tabs_detail">

                           <div class="row"> 
                              <div class="col-lg-12">  
                                    <table class="table id_table table-hover">
                                        <thead>
                                            <tr> 
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="staff_person in sale_staff" :key="staff_person.id">
 
                                                <td>{{staff_person.fullname}}</td>
                                                <td>{{staff_person.email}}</td>
                                                <td>{{staff_person.contact_no}}</td>

                                                <td>
                                                    <div class="addEdit">

                                                        <button type="button" class="text-success" data-toggle="modal" data-target=".bd-example-modal-lg" @click="updateStaff(staff_person.id)">
                                                            <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                                                        </button> 
                                                        <button class="text-danger" @click="updateStaff(staff_person.id)">
                                                            <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                                                        </button> 
                                                    </div>
                                                </td>
                                            </tr>                                 
                                        </tbody> -->

                                    </table> 

                              </div> 
                            </div>

                          </div> 

                      </div>

                      <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="shop-tab">
                          <div class="tabs_detail">

                           <div class="row">
                              <div class="col-lg-2"></div>
                              <div class="col-lg-8"> 
                                 <div>
                                      <b-form-group>
                                        <h5 class="pb-4">OWNER/ADMIN DETAILS</h5>

                                          <b-form-input type="text" id="fullNameField"  class="round-border  mx-auto mb-3"
                                              :class="{ 'is-invalid': $v.Admin.fullname.$error }" placeholder="Enter full name"
                                              v-model.trim="$v.Admin.fullname.$model" @blur="$v.Admin.fullname.$touch" name="fullname" ></b-form-input>
                                          <div class="invalid-feedback" v-if="!$v.Admin.fullname.required">
                                              {{$t('form.validation.required')}}
                                          </div>
                                          <div class="invalid-feedback" v-if="!$v.Admin.fullname.maxLength">
                                              {{$t('form.validation.maxLength', {num: $v.Admin.fullname.$params.maxLength.max})}}
                                          </div> 

                                      </b-form-group>

                                      <div class="profileInfo_pic col-lg-3">
                                            <span><custom-image src="assets/img_icon.png" alt="Jewelry Image" class_to_pass="img-fluid"/></span>
                                        </div>
                                </div> 
                              <div class="col-lg-2"></div>
                            </div>

                            </div> 

                          </div> 

                      </div>
                     </div>
                  </div>
                  <div class="col-lg-1">
                     
                  </div>
                </div>   

            </div>
 
        </div>

     </div>

  </div>

    <!-- </div> -->
</template>
  
<script>
// Import component
import Loading from 'vue-loading-overlay';
    /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email,
        containsNumber
    } from "vuelidate/lib/validators";

export default {
  components: {
        'loading':Loading
   },
   
    data(){
        return {
            Admin: {
                fullname: null,
                email: null,
                contact: null,
                address: null,
            },
            SaleStaff: {
                fullname: null,
                email: null,
                contact: null,
                },
            Jeweler: {
                fullname: null,
                email: null,
                contact: null,
            },
            alertMsg:'',
            isLoading: false,
            fullPage: true,
            selected: 'yes',
            selected: [], // Must be an array reference!  
            subHeading:"Edit Owner Details",
            options: [
            { text: 'Yes', value: 'yes' },
            { text: 'No', value: 'no' },
            ],
            jewelers:[
                {
                    id:1,
                    fullname:'azzem ikram',
                    email:'azzemikream@gmail.com',
                    contact_no:'03210000000'
                },
                {
                    id:2,
                    fullname:'istaa',
                    email:'istaa@gmail.com',
                    contact_no:'03129999999999'
                }
            ],

            sale_staff:[
                {
                    id:3,
                    fullname:'azzem ikram',
                    email:'azzemikream@gmail.com',
                    contact_no:'03210000000'
                    
                },
                {
                    id:4,
                    fullname:'istaa',
                    email:'istaa@gmail.com',
                    contact_no:'03129999999999'
                    
                }
            ],
            

        }
    },
 
    validations: {
        Admin: {
            fullname: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            contact: {
                required,
                maxLength:maxLength(12),
            },
            address: {
                required,
            },
            },
        SaleStaff: {
            fullname: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            contact: {
                required,
                maxLength:maxLength(12),
            },
            },
        Jeweler: {
            fullname: {
                required,
                maxLength: maxLength(30)
            },
            email: {
                required,
                email,
                maxLength: maxLength(45)
            },
            contact: {
                required,
                maxLength:maxLength(12),
            },
        },
    },

    methods:{

            /**
             *  here we are upddeleting jeweler
             */
            deleteJeweler(id){
            
            
            },

            /**'
             *  here we are updating jeweler
             */
            editJeweler(id){
            
            
            },


            /***
             * call to Signup API
             */
            onSubmit(){

                this.$v.$touch();

                if (this.$v.$invalid) {

                    let errorMsg = '';
                    if(this.$v.Admin.fullname.$error){
                        errorMsg = 'FullName';
                    }
                    
                    if(this.$v.Admin.contact.$error){
                        errorMsg = errorMsg? errorMsg+', Contact': 'Contact';
                    }

                    if(this.$v.Admin.address.$error){
                        errorMsg = errorMsg ? errorMsg +", Address": "Address";
                    };            

                    if (errorMsg !== '') {
                            
                        this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

                        return;
                    }

                }
                this.isLoading = true;
                axios.post('/api/update-owner-details',{

                // admin/shop owner details

                //     owner_fullname: this.Admin.fullname,
                //     owner_contact: this.Admin.contact,
                //     owner_email: this.Admin.email,
                //     owner_address: this.Admin.address,
                //     owner_shop: this.Shop,
 
                //     // SaleStaff

                //     sale_staff[0]['full_name']: this.SaleStaff.fullname,
                //     contact: this.SaleStaff.contact,
                //     email: this.SaleStaff.email,

                //     // Jeweler

                //     fullname: this.Jeweler.fullname,
                //     contact: this.Jeweler.contact,
                //     email: this.Jeweler.email,


                }).then(response=>{
                    this.isLoading = false;
                    this.$emit('showAlert',['Congratulations you have registered successfully.','success'])

                }).catch(error=>{

                    this.isLoading = false;
                    if(error.response.data.errors){
                        let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                        this.$emit('showAlert',[msg,'danger'])
                    }else if(error.response.data.response_header.response_message){
                        this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                    }else{
                        this.$emit('showAlert',[error,'danger'])
                    }
                    
                });

                if(this.Admin.fullname){

                    this.$emit('showAlert',['Congratulations! you  can proceed  furthur.','success']);
                    localStorage.setItem('personal_information_added',this.Admin.email);

                }
                else{

                    localStorage.setItem('personal_information_added',null);
                    this.$emit('showAlert',['Please complete fields first.','danger']);

                }

                this.$router.push({
                    name:'home'
                });

            }
        },
}
</script>  
<style scoped>

/* .nav-item  .nav-link { color: #fff;} */
.tabs_setting .nav-tabs { border: 0px;justify-content: center;}
.tabs_setting .nav-tabs .nav-link {
    margin-bottom: -1px;
    border: 0px; padding: 1.2rem 1.8rem;color: #fff;
} 
.tabs_setting .nav-tabs .nav-link.active { background-color: #333c73; color: #fff;}
.tabs_setting .id_table thead th { border-top: 0px;}
</style>