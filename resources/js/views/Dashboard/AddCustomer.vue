<template>
    <div class="container   mx-auto">

        <!-- <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/> -->

        <!-- Header Component -->
        <!-- <custom-header/> -->

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <!-- <man-with-heading heading="Chapters"/> -->

        <div class="main_dashboard">
             
            <div>
                    <!-- Page Loader -->
                <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
                    <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
                </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="vendor_form">
                                <div class="row myForn">
                                    <b-form @submit="onSubmit" @reset="$v.$reset()" class="">
                                        
                                            <div>
                                                <b-form-group>
                                                <h5 class="mb-3 pt-2 text-center">Customer Name</h5>

                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Customer ID</strong>   
                                                    <b-form-input type="text" id="customer_id"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Customer.CustomerID.$error }" placeholder=""
                                                        v-model.trim="$v.Customer.CustomerID.$model" @blur="$v.Customer.CustomerID.$touch" name="customer_id" disabled></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.CustomerID.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.CustomerID.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Customer.CustomerID.$params.maxLength.max})}}
                                                    </div>
                                                    </div>


                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">First name</strong>   
                                                    <b-form-input type="text" id="customer_firstname_field"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Customer.firstname.$error }" placeholder=""
                                                        v-model.trim="$v.Customer.firstname.$model" @blur="$v.Customer.firstname.$touch" name="firstname"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.firstname.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.firstname.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Customer.firstname.$params.maxLength.max})}}
                                                    </div>
                                                    </div>


                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Last name</strong>
                                                    <b-form-input type="text" id="customer_lastname_field"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Customer.lastname.$error }" placeholder=""
                                                        v-model.trim="$v.Customer.lastname.$model" @blur="$v.Customer.lastname.$touch" name="lastname"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.lastname.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.lastname.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Customer.lastname.$params.maxLength.max})}}
                                                    </div>
                                                    </div>


                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block ">Spouce first name</strong>
                                                        <b-form-input type="text" id="customer_spouce_f_name_field"  class="round-border"
                                                            :class="{ 'is-invalid': $v.Customer.spouce_f_name.$error }" placeholder=""
                                                            v-model.trim="$v.Customer.spouce_f_name.$model" @blur="$v.Customer.spouce_f_name.$touch" name="spouce_f_name"></b-form-input>
                                                        <div class="invalid-feedback" v-if="!$v.Customer.spouce_f_name.required">
                                                            {{$t('form.validation.required')}}
                                                        </div>
                                                        <div class="invalid-feedback" v-if="!$v.Customer.spouce_f_name.maxLength">
                                                            {{$t('form.validation.maxLength', {num: $v.Customer.spouce_f_name.$params.maxLength.max})}}
                                                        </div>
                                                    </div>


                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Spouce Last name</strong>
                                                    <b-form-input type="text" id="customer_spouce_l_name_field"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Customer.spouce_l_name.$error }" placeholder=""
                                                        v-model.trim="$v.Customer.spouce_l_name.$model" @blur="$v.Customer.spouce_l_name.$touch" name="spouce_l_name"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.spouce_l_name.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Customer.spouce_l_name.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Customer.spouce_l_name.$params.maxLength.max})}}
                                                    </div>
                                                    </div>


                                                    <div class=" text-center">
                                                        <div>
                                                            <b-form-group v-slot="{ ariaDescribedby }">
                                                            <b-form-radio-group
                                                            v-model="Customer.gender"
                                                            :options="gender_options"
                                                            :aria-describedby="ariaDescribedby"
                                                            name="gender"
                                                        ></b-form-radio-group>
                                                        </b-form-group>
                                                        </div>
                                                    </div>


                                                </b-form-group>

                                                <b-form-group>
                                                    <div class="col-md-10 mx-auto mb-3 p-0 addNewCustom">
                                                        <h5  class="mb-3  pt-3  text-center">Birth Details</h5>

                                                        <div class="form-group">
                                                            <b-form-datepicker
                                                            id="date-picker-label"
                                                            v-model="BirthDate.date"
                                                            class="round-border p-2 text-left"
                                                            ></b-form-datepicker>
                                                        </div>
                                                    </div>
                                                

                                                </b-form-group>



                                                <b-form-group>
                                                <h5  class="mb-3 pt-4 text-center">Phone</h5>
                                                    <h6 class=" text-center">(353xxxxxxxxx)</h6>

                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block ">Cell</strong>
                                                <b-form-input type="text" id="cellField"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Phone.cell.$error }" placeholder=""
                                                        v-model.trim="$v.Phone.cell.$model" @blur="$v.Phone.cell.$touch" name="cell"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Phone.cell.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Phone.cell.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Phone.cell.$params.maxLength.max})}}
                                                    </div>
                                                    </div>



                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Alternative</strong>
                                                <b-form-input type="text" id="alternativeField"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Phone.alternative.$error }" placeholder=""
                                                        v-model.trim="$v.Phone.alternative.$model" @blur="$v.Phone.alternative.$touch" name="alternative"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Phone.alternative.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Phone.alternative.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Phone.alternative.$params.maxLength.max})}}
                                                    </div>
                                                    </div>


                                                    <div class=" text-center">
                                                <h6>May we contact on this number as our primary contact method.</h6>

                                                    <b-form-group v-slot="{ ariaDescribedby }">
                                                        <b-form-radio-group
                                                        v-model="Phone.should_contact"
                                                        :options="contact_methods"
                                                        class="mb-3"
                                                        :aria-describedby="ariaDescribedby"
                                                        name="contact_method"
                                                    ></b-form-radio-group>
                                                    </b-form-group>
                                                    </div>


                                                

                                                </b-form-group>

                                                <b-form-group>
                                                <h5  class="mb-3 pt-3 text-center">Emails</h5>

                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Primary email</strong>
                                                    <b-form-input type="text" id="primaryField"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Emails.primary.$error }" placeholder=""
                                                        v-model.trim="$v.Emails.primary.$model" @blur="$v.Emails.primary.$touch" name="primary_email"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Emails.primary.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Emails.primary.email">
                                                        {{$t('form.validation.validEmail')}}
                                                    </div>
                                                    </div>

                                                </b-form-group>

                                                <b-form-group>
                                                <h5  class="mb-3  pt-3 text-center">Address</h5>

                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">Street</strong>
                                                    <b-form-input type="text" id="street_id"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Address.street.$error }" placeholder=""
                                                        v-model.trim="$v.Address.street.$model" @blur="$v.Address.street.$touch" name="street_id"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Address.street.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Address.street.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Address.street.$params.maxLength.max})}}
                                                    </div>
                                                    </div>



                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 ">Suit/Apt</strong>
                                                <b-form-input type="text" id="apartment_id"  class="round-border "
                                                        :class="{ 'is-invalid': $v.Address.apartment.$error }" placeholder=""
                                                        v-model.trim="$v.Address.apartment.$model" @blur="$v.Address.apartment.$touch" name="customer_id"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Address.apartment.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Address.apartment.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Address.apartment.$params.maxLength.max})}}
                                                    </div>
                                                    </div>



                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block ">City</strong>
                                                    <b-form-input type="text" id="city_id"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Address.city.$error }" placeholder=""
                                                        v-model.trim="$v.Address.city.$model" @blur="$v.Address.city.$touch" name="customer_id"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Address.city.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Address.city.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Address.city.$params.maxLength.max})}}
                                                    </div>
                                                    </div>



                                                    <div class=" col-md-10 mx-auto mb-3 p-0"> 
                                                        <strong class="text-left pb-2 d-block">State Zip</strong>
                                                    <b-form-input type="text" id="zip_id"  class="round-border"
                                                        :class="{ 'is-invalid': $v.Address.zip.$error }" placeholder=""
                                                        v-model.trim="$v.Address.zip.$model" @blur="$v.Address.zip.$touch" name="zip_id"></b-form-input>
                                                    <div class="invalid-feedback" v-if="!$v.Address.zip.required">
                                                        {{$t('form.validation.required')}}
                                                    </div>
                                                    <div class="invalid-feedback" v-if="!$v.Address.zip.maxLength">
                                                        {{$t('form.validation.maxLength', {num: $v.Address.zip.$params.maxLength.max})}}
                                                    </div>
                                                    </div>




                                                </b-form-group>

                                            </div>
                                            <div class="pt-4">
                                                <default-button variant="success" text="Add new Customer" @onSubmit="onSubmit()"/>
                                            </div>

                                    </b-form>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
 
                </div>
 

    </div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
import { mapGetters, mapActions } from 'vuex'; 
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
    data(){
        return {
            Customer: 
            {
                CustomerID: '1-'+(Math.floor(Math.random() * 90000 ) + 10000), 
                firstname: '', 
                lastname: '', 
                gender: 'f', 
                spouce_f_name:'',
                spouce_l_name:''
            },
            BirthDate: 
            {
                date:new Date()
            },
            Phone: 
            {
                cell: '', 
                alternative: '', 
                should_contact:1
            },
            Emails: 
            {
                primary: '', 
            },
            Address: 
            {
                street: '', 
                apartment: '', 
                city:'',
                zip:'',
                state:''

            },
            alertMsg:'',
            isLoading: false,
            fullPage: true,
            gender_options: [
            { text: 'Female', value: 'f' },
            { text: 'Male', value: 'm' },
            ],
            contact_methods:[
            { text: 'Yes', value: 1 },
            { text: 'No', value: 0 },
            ]
        }
    },
 
    validations: {
        Customer: {
            CustomerID: {
                required,
                maxLength: maxLength(30)
            },
            firstname: {
                required,
                maxLength: maxLength(30)
            },
            lastname: {
                required,
                maxLength: maxLength(30)
            },
            gender: {
                required,
            },
            spouce_f_name: {
                maxLength: maxLength(30)
            },
            spouce_l_name: {
                maxLength: maxLength(30)
            }
        },
        Phone: {
            cell: {
                required,
                maxLength: maxLength(13)
            },
            alternative: {
                required,
                maxLength:maxLength(13),
            },
            should_contact: {
                required,
            },
        },
        BirthDate: {
            date: {
                
            },
        },
        Emails: {
            primary: {
                required,
                email,
                maxLength: maxLength(30)
            },
        },
        Address: {
            street: {
                required,
                maxLength: maxLength(50)
            },
            apartment: {
                maxLength: maxLength(50)
            },
            city: {
                required,
                maxLength: maxLength(45)
            },
            zip: {
                required,
                maxLength: maxLength(100)
            },
        }
    },

    methods:{
        ...mapActions('dataStore', ['setTheCustomer','setPreviousPageOnCustomerChange','setLoader']),
        
            /***
             * call to add customer API
             */
            onSubmit(){

                this.$v.$touch();

                if (this.$v.$invalid) {

                let errorMsg = '';

                // Customer
                if(this.$v.Customer.CustomerID.$error){
                    errorMsg = 'CustomerID';
                }
                
                if(this.$v.Customer.firstname.$error){
                    errorMsg = errorMsg? errorMsg+', firstname': 'firstname';
                }

                if(this.$v.Customer.lastname.$error){
                    errorMsg = errorMsg? errorMsg+', lastname': 'lastname';
                } 

                if(this.$v.Customer.spouce_f_name.$error){
                    errorMsg = errorMsg? errorMsg+', spouce_f_name': 'spouce_f_name';
                }

                if(this.$v.Customer.spouce_l_name.$error){
                    errorMsg = errorMsg? errorMsg+', spouce_l_name': 'spouce_l_name';
                } 

                if(this.$v.Customer.gender.$error){
                    errorMsg = errorMsg? errorMsg+', gender': 'gender';
                } 

                // Birthdate
                if(this.$v.BirthDate.date.$error){
                    errorMsg = errorMsg? errorMsg+', birthdate': 'birthdate';
                } 

                // Phone
                if(this.$v.Phone.cell.$error)
                {
                    errorMsg = errorMsg? errorMsg+', cell': 'cell';
                }

                if(this.$v.Phone.alternative.$error)
                {
                    errorMsg = errorMsg ? errorMsg +", alternative": "alternative";
                }  

                if(this.$v.Phone.should_contact.$error)
                {
                    errorMsg = errorMsg ? errorMsg +",  should contact": "should contact";
                } 

                // Emails
                if(this.$v.Emails.primary.$error)
                {
                    errorMsg = errorMsg ? errorMsg +",  email": 'email';
                }

                // Address
                if(this.$v.Address.street.$error)
                {
                    errorMsg = errorMsg ? errorMsg +",  street": 'street';
                }
                
                if(this.$v.Address.apartment.$error){
                    errorMsg = errorMsg? errorMsg+', apartment': 'apartment';
                }

                if(this.$v.Address.city.$error){
                    errorMsg = errorMsg? errorMsg+', city': 'city';
                }

                if(this.$v.Address.zip.$error){
                    errorMsg = errorMsg ? errorMsg +", zip": "zip";
                } 
                
                if (errorMsg !== '') {
                    this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger']);
                    return;
                }

                }
                this.setLoader(true);
                

                let token = localStorage.getItem('token');

                axios.post('/api/add-customer',{
                    
                // customer
                customer_id: this.Customer.CustomerID,
                firstname: this.Customer.firstname,
                lastname: this.Customer.lastname,
                spouce_f_name: this.Customer.spouce_f_name,
                spouce_l_name: this.Customer.spouce_l_name,
                gender: this.Customer.gender,

                // Birthdate
                birth_date:this.BirthDate.date,

                //phone
                cell_phone: this.Phone.cell,
                alternative: this.Phone.alternative,
                should_contact: this.Phone.should_contact,

                //Email
                email: this.Emails.primary,

                //Address
                street_address: this.Address.street,
                apartment: this.Address.apartment,
                city: this.Address.city,
                zip: this.Address.zip,

                },{
                headers: {
                'Authorization': 'Bearer ' + token
                }
                }).then(response=>{
                    this.setLoader(false);
                    this.$emit('showAlert',['Customer added successfully.','success']);
                    var customer = response.data.data;
                    this.setTheCustomer(customer);
                    if(this.$store.state.dataStore.previous_page_on_customer_change != ""){
                        this.$router.push(this.$store.state.dataStore.previous_page_on_customer_change).catch(()=>{});
                        this.setPreviousPageOnCustomerChange("");
                    }else{
                        this.$router.push('/find-sku').catch(()=>{});
                    }
                }).catch(error=>{

                    this.setLoader(false);
                    if(error.response){

                        if(error.response.data.errors){
                            let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                            this.$emit('showAlert',[msg,'danger'])
                        }else if(error.response.response_header){
                            if(error.response.response_header.response_message){
                                this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                        }
                        }else if(error.response.data){
                            if(error.response.data.response_header){
                            if(error.response.data.response_header.response_message){
                                this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                            }
                            }else{
                                this.$emit('showAlert',[error.response.data,'danger'])

                            }
                            
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
.personal-form{
    background-color: #333c73
}
</style>
