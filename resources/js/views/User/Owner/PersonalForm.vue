<template>
    <div>
        <!-- Page Loader -->
        <div class="vld-parent"  v-show="$store.state.dataStore.isLoading">
            <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
        </div>
        <b-form @submit="onSubmit" @reset="$v.$reset()" class="personal-form  mt-3 p-4 p-lg-5">
            <h6>Does your store own a laser? if not did any laser work out?</h6>
            <b-form-group class="mb-4" v-slot="{ ariaDescribedby }">
                <b-form-radio-group
                    v-model="selected"
                    :options="options"
                    :aria-describedby="ariaDescribedby"
                    name="radio-inline"
                ></b-form-radio-group>
            </b-form-group>
            <div class="myForn">
            <b-form-group>
                <h5 class="pb-4">OWNER/ADMIN DETAILS</h5>
                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name <em class="text-danger">*</em></strong>
                <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.fullname.$error }" 
                    v-model.trim="$v.Admin.fullname.$model" @blur="$v.Admin.fullname.$touch" name="fullname"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.fullname.required">
                    {{$t('form.validation.required')}}
                </div>
                <div class="invalid-feedback" v-if="!$v.Admin.fullname.maxLength">
                    {{$t('form.validation.maxLength', {num: $v.Admin.fullname.$params.maxLength.max})}}
                </div>
                </div>

                <div class=""> 
                <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                <b-form-input type="text" id="owner_email"  class="round-border col-md-10 mx-auto mb-3" disabled
                    :class="{ 'is-invalid': $v.Admin.email.$error }" 
                    v-model.trim="$v.Admin.email.$model" @blur="$v.Admin.email.$touch" name="email"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.email.required">
                    {{$t('form.validation.required')}}
                </div>
                <div class="invalid-feedback" v-if="!$v.Admin.email.maxLength">
                    {{$t('form.validation.maxLength', {num: $v.Admin.email.$params.maxLength.max})}}
                </div>
                </div>

                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter contact number</strong>
                <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.contact.$error }" 
                    v-model.trim="$v.Admin.contact.$model" @blur="$v.Admin.contact.$touch" name="contact"></b-form-input>
                <div class="invalid-feedback" v-if="!$v.Admin.contact.required">
                    {{$t('form.validation.required')}}
                </div>
                </div>

                <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter Address</strong>
                <b-form-input type="text" id="addressField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Admin.address.$error }" 
                    v-model.trim="$v.Admin.address.$model" @blur="$v.Admin.address.$touch" name="contact"></b-form-input>
                <!-- <div class="invalid-feedback" v-if="!$v.Admin.address.required">
                    {{$t('form.validation.required')}}
                </div> -->
                </div>


            </b-form-group>


            <b-form-group>
                <h5 class="pt-4">SALE STAFF DETAILS</h5>
                <div v-for="(v, index) in $v.SaleStaff.$each.$iter" class="mt-5" >
                    <h4>Sale Staff {{parseInt(index)+1}} <span class="text-danger ml-3" v-if="index != 0"><b-icon icon="trash-fill" aria-hidden="true" @click="deleteSaleStaff(index)"></b-icon></span></h4>
                        <div class="">
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name <em class="text-danger">*</em></strong>
                        <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.fullname.$error }" 
                        v-model.trim="v.fullname.$model" @blur="v.fullname.$touch" name="fullname" :key="'sale'+index"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.fullname.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.fullname.maxLength">
                        {{$t('form.validation.maxLength', {num: v.fullname.$params.maxLength.max})}}
                    </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                    <b-form-input type="text" :id="'sale_staff_person_email'+index"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.email.$error }" 
                      v-model.trim="v.email.$model"  @blur="v.email.$touch" :name="'email'+index"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.email.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!v.email.email">
                        {{$t('form.validation.validEmail')}}
                    </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter contact number</strong>
                    <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': v.contact_no.$error }" 
                        v-model.trim="v.contact_no.$model" @blur="v.contact_no.$touch" name="contact"></b-form-input>
                    <div class="invalid-feedback" v-if="!v.contact_no.required">
                        {{$t('form.validation.required')}}
                    </div>
                    </div>

                </div>
                <div class="text-right w-100 pr-4">
                    <b-button variant="link" class="text-success " @click="addMore('sale')">Add More+</b-button>
                </div>

            </b-form-group>

            <!-- <b-form-group>

                <h5 class="pt-4">STORE JEWELER NAMES</h5>

                <div  v-for="(v, index) in $v.Jeweler.$each.$iter" class="mt-5">
                    <h4>Jeweler {{parseInt(index)+1}} <span v-if="index != 0" class="text-danger ml-3"><b-icon icon="trash-fill" aria-hidden="true" @click="deleteJeweler(index)"></b-icon></span></h4>
                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter full name <em class="text-danger">*</em></strong>
                        <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                            :class="{ 'is-invalid': v.fullname.$error }" 
                            v-model.trim="v.fullname.$model" @blur="v.fullname.$touch" name="fullname" :key="'jeweler'+index">
                        </b-form-input>
                        <div class="invalid-feedback" v-if="!v.fullname.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!v.fullname.maxLength">
                            {{$t('form.validation.maxLength', {num: v.fullname.$params.maxLength.max})}}
                        </div>
                    </div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter email</strong>
                        <b-form-input type="text" :id="'jeweler_email_'+index"  class="round-border col-md-10 mx-auto mb-3"
                            :class="{ 'is-invalid': v.email.$error }" 
                            v-model.trim="v.email.$model" @blur="v.email.$touch" name="email"></b-form-input>
                        <div class="invalid-feedback" v-if="!v.email.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!v.email.email">
                            {{$t('form.validation.validEmail')}}
                        </div>
                    </div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter contact number</strong>
                        <b-form-input type="text" id="contactField"  class="round-border col-md-10 mx-auto mb-3"
                            :class="{ 'is-invalid': v.contact_no.$error }" 
                            v-model.trim="v.contact_no.$model" @blur="v.contact_no.$touch" name="contact"></b-form-input>
                        <div class="invalid-feedback" v-if="!v.contact_no.required">
                            {{$t('form.validation.required')}}
                        </div>
                    </div>

                     


                </div>
                <div class="text-right w-100 pr-4">
                        <b-button variant="link" class="text-success " @click="addMore('jeweler')">Add More+</b-button>
                    </div>
                
            </b-form-group> -->

            <b-form-group>

                <h5 class="pt-4">TRADE SHOP DETAILS</h5>                   
                <div>
                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter shop trade name <em class="text-danger">*</em></strong>
                    <b-form-input type="text" id="fullNameField"  class="round-border col-md-10 mx-auto mb-3"
                    :class="{ 'is-invalid': $v.Shop.trade_name.$error }" 
                    v-model.trim="$v.Shop.trade_name.$model" @blur="$v.Shop.trade_name.$touch" name="tradename"></b-form-input>
                    <div class="invalid-feedback" v-if="!$v.Shop.trade_name.required">
                        {{$t('form.validation.required')}}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.Shop.trade_name.maxLength">
                        {{$t('form.validation.maxLength', {num: $v.Shop.trade_name.$params.maxLength.max})}}
                    </div>
                    </div>
                </div>

                <div>
                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter street address</strong>
                        <b-form-input type="text" id="shop_street_addressField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': $v.Shop.address.street_address.$error }" 
                        v-model.trim="$v.Shop.address.street_address.$model" @blur="$v.Shop.address.street_address.$touch" name="shop_street_address"></b-form-input>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.street_address.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.street_address.maxLength">
                            {{$t('form.validation.maxLength', {num: $v.Shop.address.street_address.$params.maxLength.max})}}
                        </div>
                    </div>


                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter city</strong>
                        <b-form-input type="text" id="shop_cityField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': $v.Shop.address.city.$error }" 
                        v-model.trim="$v.Shop.address.city.$model" @blur="$v.Shop.address.city.$touch" name="shop_city"></b-form-input>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.city.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.city.maxLength">
                            {{$t('form.validation.maxLength', {num: $v.Shop.address.city.$params.maxLength.max})}}
                        </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter apartment no.</strong>
                        <b-form-input type="text" id="shop_apartmentField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': $v.Shop.address.apartment.$error }" 
                        v-model.trim="$v.Shop.address.apartment.$model" @blur="$v.Shop.address.apartment.$touch" name="shop_apartment"></b-form-input>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.apartment.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.apartment.maxLength">
                            {{$t('form.validation.maxLength', {num: $v.Shop.address.apartment.$params.maxLength.max})}}
                        </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter zip</strong>
                        <b-form-input type="text" id="shop_zipField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': $v.Shop.address.zip.$error }" 
                        v-model.trim="$v.Shop.address.zip.$model" @blur="$v.Shop.address.zip.$touch" name="shop_zip"></b-form-input>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.zip.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.Shop.address.zip.maxLength">
                            {{$t('form.validation.maxLength', {num: $v.Shop.address.zip.$params.maxLength.max})}}
                        </div>
                    </div>

                    <div class=""> 
                        <strong class="text-left pb-2 d-block col-md-10 mx-auto">Enter contact number</strong>
                        <b-form-input type="text" id="shop_contact_noField"  class="round-border col-md-10 mx-auto mb-3"
                        :class="{ 'is-invalid': $v.Shop.contact_no.$error }" 
                        v-model.trim="$v.Shop.contact_no.$model" @blur="$v.Shop.contact_no.$touch" name="shop_address"></b-form-input>
                        <div class="invalid-feedback" v-if="!$v.Shop.contact_no.required">
                            {{$t('form.validation.required')}}
                        </div>
                        <div class="invalid-feedback" v-if="!$v.Shop.contact_no.maxLength">
                            {{$t('form.validation.maxLength', {num: $v.Shop.contact_no.$params.maxLength.max})}}
                        </div>
                    </div>
                </div>

                <div class="add_photo  col-md-10 mx-auto pt-2 ">
                    <h5 class="text-left pb-0 m-0">Add photo</h5>
                    <ul>  
                        <li>
                            <div class="">
                                <div class="profile_img">
                                    <form>
                                        <div class="form-group"> 
                                            <span>
                                                <b>
                                                <input type="file" accept="/*" @change="previewImage" class="form-control-file" id="my-file">
                                                </b>
                                                <img :src="preview" class="img-fluid" />
                                            </span>
                                        </div>
                                    </form>
                                </div> 
                            </div> 
                        </li> 
       
                    </ul>
                </div>
                
                
            </b-form-group>

            <b-form-group>

                <default-button variant="success" text="  Next  " class="d-inlie-block pl-5 pr-5 mt-4" @onSubmit="onSubmit()"/>

            </b-form-group>

            </div>
        </b-form>
    </div>
</template>

<script>
// Import component
import Loading from 'vue-loading-overlay';
import {mapActions} from 'vuex';
    /**
     * Vuelidate items
     */
    import {
        required,
        maxLength,
        minLength,
        email,
        containsNumber,
        numeric
    } from "vuelidate/lib/validators";

export default {
  components: {
        'loading':Loading
   },
   mounted()
   {
       this.setLoader(false);
   },
    data(){
        return {

        
        preview: 'assets/img_icon.png', 
        image: null,
        preview_list: [],
        image_list: [],
        
            Admin: {
                // id:1,
                fullname: localStorage.getItem('owner_fullname'),
                email: localStorage.getItem('shop_email'),
                contact: null,
                address: null,
            },
            SaleStaff: [{
                // id:1,j/=-
                fullname: null,
                email: null,
                contact_no: null,
                }],
            Jeweler: [{
                // id:1,
                fullname: null,
                email: null,
                contact_no: null,
            }],
            Shop: {
                trade_name:null,
                address:{
                    street_address:null,
                    apartment:null,
                    city:null,
                    zip:null,
                },
                contact_no:''
            },
            alertMsg:'',
            isLoading: false,
            fullPage: true,
            selected: 'yes',
            options: [
                { text: 'Yes', value: 'yes' },
                { text: 'No', value: 'no' },
            ],
        }
    },
 
    validations: {
        Admin: {
            // id: {
            //     required,
            //     maxLength: maxLength(30)
            // },
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
                maxLength:maxLength(12),
            },
            address: {
                maxLength:maxLength(150),
            },
            },
        Shop:{
            trade_name: {
                required,
                maxLength: maxLength(45)
            },    
            address: {
                street_address: {
                    maxLength: maxLength(50)
                },
                apartment: {
                    maxLength: maxLength(50)
                },
                city: {
                    maxLength: maxLength(45)
                },
                zip: {
                    numeric,
                    maxLength: maxLength(5)
                },
            },
            contact_no: {
                maxLength: maxLength(13)
            }
        },    
        
        SaleStaff: {
             $each: {
                // id: {
                //     required,
                //     maxLength: maxLength(30)
                // },
                fullname: {
                    required,
                    maxLength: maxLength(30)
                },
                email: {
                    // required,
                    email,
                    maxLength: maxLength(45)
                },
                contact_no: {
                    // required,
                    maxLength:maxLength(12),
                },
            }
            
            },
        Jeweler: {
             $each: {
                // id:{
                //     required,
                //     maxLength: maxLength(30)
                // },
                fullname: {
                    // required,
                    maxLength: maxLength(30)
                },
                email: {
                    // required,
                    email,
                    maxLength: maxLength(45)
                },
                contact_no: {
                    // required,
                    maxLength:maxLength(12),
                },
            }
        },
    },

    methods:{
        ...mapActions('dataStore', [ 'setLoader' ]),
        previewImage(event) 
        {
            var input = event.target;
            if (input.files) {
                var reader = new FileReader();
                reader.onload = (e) => {
                this.preview = e.target.result;
                }
                this.image=input.files[0];
                reader.readAsDataURL(input.files[0]);
            }
        },
        /**
         * adding jeweler and sale staff dynamically
         */
        addMore(entity){

            if(entity == 'sale'){
                this.SaleStaff.push({
                    // id: staff_array.length+1,
                    fullname: null,
                    email: null,
                    contact_no:null,
                });
            }else if(entity == 'jeweler')
            {
                this.Jeweler.push({
                    // id: jeweler_array.length+1,
                    fullname: null,
                    email: null,
                    contact_no:null,
                });
            }

        },
        deleteSaleStaff(key)
        {
            console.log('deleteSaleStaff called',this.SaleStaff.splice(key,1));
            if(this.SaleStaff[key])
            {
                this.SaleStaff.splice(key,1);
            }
        },
        deleteJeweler(key)
        {
            if(this.Jeweler[key])
            {
                this.Jeweler.splice(key,1);
            }
        },
        /***
         * call to Signup API
         */
        onSubmit(){

            this.$v.$touch();
            if (this.$v.$invalid) {

                let errorMsg = '';
                if(this.$v.Admin.fullname.$error){
                    errorMsg = 'Owner FullName';
                }
                
                if(this.$v.Admin.contact.$error){
                    errorMsg = errorMsg? errorMsg+',Owner Contact': 'Owner Contact';
                }

                if(this.$v.Admin.email.$error){
                    errorMsg = errorMsg? errorMsg+',Owner Email': 'Owner Email';
                }

                if(this.$v.Admin.address.$error){
                    errorMsg = errorMsg ? errorMsg +",Owner Address": "Owner Address";
                };            

                if (this.$v.SaleStaff.$each.$error) {
                    errorMsg = errorMsg
                    ? errorMsg + ", " + 'Please complete sale staff details'
                    : 'Please complete sale staff details';
                }

                if(this.$v.Shop.$error){
                    errorMsg = 'Owner Shop Name';
                }

                if (errorMsg !== '') {
                        
                    this.$emit('showAlert',[this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger'])

                    return;
                }

            }
                this.setLoader(true);
                var sale_staff = this.SaleStaff;
                var jeweler    = this.Jeweler;
                var image      = this.image;
                let data       = new FormData();
                data.append('owner_fullname', JSON.stringify(this.Admin.fullname));
                data.append('owner_contact', JSON.stringify(this.Admin.contact));
                data.append('owner_email', JSON.stringify(this.Admin.email));
                data.append('owner_address', JSON.stringify(this.Admin.address));
                data.append('owner_shop_name', JSON.stringify(this.Shop.trade_name));
                data.append('owner_shop_street_address', JSON.stringify(this.Shop.address.street_address));
                data.append('owner_shop_zip', JSON.stringify(this.Shop.address.zip));
                data.append('owner_shop_apartment', JSON.stringify(this.Shop.address.apartment));
                data.append('owner_shop_city', JSON.stringify(this.Shop.address.city));
                data.append('owner_shop_contact_no', JSON.stringify(this.Shop.contact_no));

                data.append('image', ((this.image && this.image.length > 0) ? this.image : null));
                data.append('sale_staff', JSON.stringify(this.SaleStaff));
                data.append('jeweler', JSON.stringify(jeweler));
                data.append('have_laser', this.selected);

                axios.post('/api/personal-information',data,{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}}).then(response=>{
                // this.isLoading = false;
                this.$emit('showAlert',[response.data.response_header.response_message,'success']);
                // localStorage.setItem('personal_information_added',true)
                var context = this;
                // setTimeout(function(){
                this.setLoader(false);
                context.$router.push({
                    name:'home'
                });

                // }, 3000);  
                

            }).catch(error=>{

                    this.setLoader(false);
                if(error.response.data.errors){
                    let msg = error.response.data.errors[Object.keys(error.response.data.errors)[0]][0];
                    this.$emit('showAlert',[msg,'danger'])
                }else if(error.response.data.response_header.response_message){
                    this.$emit('showAlert',[error.response.data.response_header.response_message,'danger'])
                }else{
                    this.$emit('showAlert',[error,'danger'])
                }
                
            });

        }
    },
}
</script>
<style scoped>
.personal-form{
    background-color: #333c73
}
</style>
