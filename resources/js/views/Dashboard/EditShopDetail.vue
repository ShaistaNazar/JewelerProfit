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
                            <h5 class="m-0 p-0 ml-3">Edit Shop Details</h5>
                        </div>
                    </div> 
                </div>
                    <div class="row pt-3">
                        <div class="col-lg-4 col-md-6">
                            <div class="editShopDetails">
                                <em  v-on:click="isshow=true"><b-icon icon="pencil-square" aria-hidden="true"></b-icon> </em>
                                <a href="#">
                                    <!-- <custom-image :src="base_path+'/assets/img_icon.png'" alt="logo" class_to_pass=" mx-auto d-block"/> -->
                                    <b v-if="!isshow" class="overlyEdits"></b>
                                </a>

                                <div class=""  v-if="!isshow">
                                    <strong>{{shop.shop_name}}</strong>
                                    <small> {{shop.zip_code}}</small>
                                    <small> {{shop.city}}</small>
                                    <small> {{shop.apartment}}</small>
                                    <small> {{shop.contact_no}}</small>
                                    <small> {{shop.owner_id}}</small>
                                    <small> {{shop.is_branch}}</small>
                                    <small> {{shop.trademark_url}}</small>
                                </div>

                                <div class="editshop_fileds"  v-if="isshow">
                                    <label for="shop_name">Shop Name</label>
                                    <input type="text" name="shop_name"
                                    :class="{ 'is-invalid': $v.shop.shop_name.$error }" 
                                    v-model.trim="$v.shop.shop_name.$model" @blur="$v.shop.shop_name.$touch"
                                    class="round-border" value="" />

                                    <label for="zip_code">Zip Code</label>
                                    <input type="text" name="zip_code" v-model ="shop.zip_code"  
                                    
                                    class="round-border" value="" />

                                    <label for="city">City</label>
                                    <input type="text" name="city" v-model ="shop.city"  
                                    
                                    class="round-border" value="" />

                                    <label for="apartment">Apartment</label>
                                    <input type="text" name="apartment" v-model ="shop.apartment"  
                                    
                                    class="round-border" value="" />

                                    <label for="contact_no">Contact No.</label>
                                    <input type="text" name="contact_no" v-model ="shop.contact_no"  
                                    
                                    class="round-border" value="" />

                                    
                                    <label for="fullname">Owner Name</label>
                                    <input type="text"  name="fullname" v-model ="shop.shop_owner.fullname"  readonly class="round-border" value="" />

                                    <button class="round-border btn mt-2 btn-success"   @click="saveShop()">Save</button>
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
        numeric
    } from "vuelidate/lib/validators"; 

import Input from '../../components/Global/Input.vue';
import Button from '../../components/Global/Button.vue';

    export default {

        components: {
        'loading':Loading,
                Input,
                Button
        },

        mounted() {
            this.getShop();
        },
        
        data(){
            return {
                isshow: false,
                showDismissibleAlert:false,
                shop:{
                    shop_name:'',
                    street_address: '',
                    apartment:'',
                    city:'',
                    zip_code:'',
                    contact_no:'',
                },
                alertMsg:"",
                variant:'',
            }
        },
        computed: {
            base_path: {
                get () {
                    // console.log(location.origin)
                    // if(location.origin.includes('dashboard'))
                    // {
                    //     const myArray = location.origin.split("/");
                    //     console.log('myArray',myArray);
                    // }
                    // else{
                        return location.origin;
                    // }
                },
               
            },
        },
        validations: {
        shop:{
            shop_name: {
                required,
            },
           
        }, 
    },
        methods:{ 
            getShop()
            {
                //check if user details are filled.
                var shop =  null;
                var context = this;

                axios.get('/api/get-shop',{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}})
                .then(response=>{
                shop = response.data.data;    
                this.shop = shop   
                }).catch(error=>{
                console.log('error in getting shop');
                });
            },  
            saveShop()
            {
                this.$v.$touch();
                console.log(this.$v.shop);
                if (this.$v.$invalid) {
                let errorMsg = '';

                    if(this.$v.shop.shop_name.$error){
                        errorMsg = 'Owner Shop Name';
                    }

                    if (errorMsg !== '') {
                        this.showAlert([this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger']);
                        return;
                    }

                }

                var token = localStorage.getItem('token')
                axios.post(`/api/update-shop`,{
                    id: this.shop.id,
                    shop_name:this.shop.shop_name,
                    zip_code:this.shop.zip_code,
                    city:this.shop.city,
                    apartment:this.shop.apartment,
                    contact_no:this.shop.contact_no,
                    trademark_url:this.shop.trademark_url,
                },{
                headers: {
                'Authorization': 'Bearer ' + token
                }
                }).then((response) => {
                this.setLoader(false);
                this.isshow = false;
                this.getShop();
                }).catch((error) => 
                {
                });
            },
            showAlert($event) 
            {
                this.alertMsg = $event[0];
                this.variant = $event[1];
                this.showDismissibleAlert =  true;
            },    
          },
        }
    
    
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
