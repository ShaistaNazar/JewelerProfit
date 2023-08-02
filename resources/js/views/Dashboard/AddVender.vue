<template>
    <div class="container mx-auto">
    <div class="main_dashboard">
        <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
            <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
        </div>
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
             <div class="container">
                <div class="row pb-4">  
                    <div class="col-lg-6 col-md-6">
                        <div class="shank_tittle">
                            <b-button class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                            <h5 class="m-0 p-0 ml-3">Add Vendor</h5>
                        </div>
                    </div> 
                </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="vendor_form">
                                <div class="row myForn">
                                    <b-form-group>

                                        <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                            <strong class="text-left pb-2 d-block ">Full name</strong>   
                                            <b-form-input type="text" id="vendor_fullname"  class="round-border"
                                                :class="{ 'is-invalid': $v.Vendor.fullname.$error }"
                                                v-model.trim="$v.Vendor.fullname.$model" @blur="$v.Vendor.fullname.$touch" name="fullname"></b-form-input>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.fullname.required">
                                                {{$t('form.validation.required')}}
                                            </div>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.fullname.maxLength">
                                                {{$t('form.validation.maxLength', {num: $v.Vendor.fullname.$params.maxLength.max})}}
                                            </div>
                                        </div>

                                        <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                            <strong class="text-left pb-2 d-block">Email</strong>   
                                            <b-form-input type="text" id="vendor_email"  class="round-border"
                                                :class="{ 'is-invalid': $v.Vendor.email.$error }"
                                                v-model.trim="$v.Vendor.email.$model" @blur="$v.Vendor.email.$touch" name="email"></b-form-input>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.email.required">
                                                {{$t('form.validation.required')}}
                                            </div>
                                             <div class="invalid-feedback" v-if="!$v.Vendor.email.email">
                                                {{$t('form.validation.validEmail')}}
                                            </div>
                                        </div>

                                        <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                            <strong class="text-left pb-2 d-block">Cell Number  (353xxxxxxxxx)</strong>   
                                            <b-form-input type="text" id="vendor_cell"  class="round-border"
                                                :class="{ 'is-invalid': $v.Vendor.cell.$error }"
                                                v-model.trim="$v.Vendor.cell.$model" @blur="$v.Vendor.cell.$touch" name="cell"></b-form-input>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.cell.required">
                                                {{$t('form.validation.required')}}
                                            </div>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.cell.maxLength">
                                                {{$t('form.validation.maxLength', {num: $v.Vendor.cell.$params.maxLength.max})}}
                                            </div>
                                        </div>


                                        <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                            <strong class="text-left pb-2 d-block">Address</strong>   
                                            
                                                <b-form-textarea
                                                    class="round-border sett_textarea" 
                                                    name="vendor_address"
                                                    :class="{'is-invalid':  $v.Vendor.address.$error }"
                                                    v-model.trim="$v.Vendor.address.$model"
                                                    @blur="$v.Vendor.address.$touch"
                                                    id="vendor_address"
                                                ></b-form-textarea>

                                            <div class="invalid-feedback" v-if="!$v.Vendor.address.required">
                                                {{$t('form.validation.required')}}
                                            </div>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.address.maxLength">
                                                {{$t('form.validation.maxLength', {num: $v.Vendor.address.$params.maxLength.max})}}
                                            </div>

                                        </div>

                                        <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                            <strong class="text-left pb-2 d-block">Gender</strong>   
                                                <b-form-group v-slot="{ ariaDescribedby }">
                                                <b-form-radio-group
                                                v-model="Vendor.gender"
                                                :options="gender_options"
                                                :aria-describedby="ariaDescribedby"
                                                name="vendor_gender"
                                                class="round-border"
                                                ></b-form-radio-group>
                                                </b-form-group>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.address.required">
                                                {{$t('form.validation.required')}}
                                            </div>
                                            <div class="invalid-feedback" v-if="!$v.Vendor.address.maxLength">
                                                {{$t('form.validation.maxLength', {num: $v.Vendor.address.$params.maxLength.max})}}
                                            </div>
                                        </div> 
                                    </b-form-group>
                                </div>
                                    <div class="pt-4 pb-3 text-center">
                                        <default-button variant="success" text="Save" @onSubmit="onSubmit()"/>
                                    </div> 
                                </div>
                            </div>
                    </div>
             </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import Loading from 'vue-loading-overlay';

    /**
     * Vuelidate items
     */
    
    import {
        required,
        maxLength,
        minLength,
        email,
        containsNumber,
        minValue
    } from "vuelidate/lib/validators";

    export default {

        components: {
        'loading':Loading
        },

        mounted() {
            
        },
        
        data(){
            return {
                visible_find_sku:false,
                showDismissibleAlert:false,
                gender_options: 
                [
                    { text: 'Female', value: 'f' },
                    { text: 'Male', value: 'm' },
                ],
                Vendor: 
                {
                    fullname: '', 
                    email: '', 
                    gender: 'm', 
                    cell:'',
                    address:''
                },
            }
        },
        validations: {
            Vendor: {
                fullname: {
                    required,
                    maxLength: maxLength(30)
                },
                email: {
                    required,
                    email,
                    maxLength: maxLength(30)
                },
                gender: {
                    required,
                },
                cell: {
                    required,
                    maxLength:maxLength(13),
                },
                address: {
                    required,
                    maxLength: maxLength(150)
                }
            },
        },
        methods:{
        ...mapActions('dataStore', ['setLoader']), 

            /**
             * alert generator
             */

            showAlert($event) 
            {

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

            /***
             * call to add customer API
             */
            onSubmit(){

                this.$v.$touch();

                if (this.$v.$invalid) {

                let errorMsg = '';

                //# Vendor                
                if(this.$v.Vendor.fullname.$error){
                    errorMsg = errorMsg? errorMsg+', fullname': 'fullname';
                }

                // Phone
                if(this.$v.Vendor.cell.$error)
                {
                    errorMsg = errorMsg? errorMsg+', cell': 'cell';
                }

                // Emails
                if(this.$v.Vendor.email.$error)
                {
                    errorMsg = errorMsg ? errorMsg +",  email": 'email';
                }

                // Address
                if(this.$v.Vendor.address.$error)
                {
                    errorMsg = errorMsg ? errorMsg +",  address": 'address';
                }
 
                // gender
                if(this.$v.Vendor.gender.$error){
                    errorMsg = errorMsg? errorMsg+', gender': 'gender';
                } 
                
                if (errorMsg !== '') {

                    this.showAlert([this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger']);
                    return;

                }

                }
                this.setLoader(true);

                let token = localStorage.getItem('token');

                axios.post('/api/add-vendor',{
                    
                // vendor
                fullname: this.Vendor.fullname,
                email: this.Vendor.email,
                gender: this.Vendor.gender,
                contact_no: this.Vendor.cell,
                address: this.Vendor.address,

                },{
                headers: {
                'Authorization': 'Bearer ' + token
                }
                }).then(response=>{
                    this.setLoader(false);
                    this.showAlert(['Vendor added successfully.','success']);
                    this.$router.push({name:'vendor-listing'});
                }).catch(error=>{
                    this.setLoader(false);
                    if(error.response){
                        if(error.response.data.errors){
                            let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                            this.showAlert([msg,'danger']);
                        }else if(error.response.response_header){
                            if(error.response.response_header.response_message){
                            this.showAlert([error.response.data.response_header.response_message,'danger']);
                        }
                        }else if(error.response.data){
                            if(error.response.data.response_header){
                            if(error.response.data.response_header.response_message){
                                this.showAlert([error.response.data.response_header.response_message,'danger']);
                            }
                            }else{
                            this.showAlert([error.response.data,'danger']);
                            }
                        }
                    }else{
                        this.showAlert([error,'danger']);
                    }
                });  
            },
        }
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
