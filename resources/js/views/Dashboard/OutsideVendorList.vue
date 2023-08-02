<template>
    <div class="container">
      <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
        <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
      </div>
        <div class="row  pb-4">  
            <div class="col-lg-6 col-md-6">
                <div class="shank_tittle">
                    <b-button :variant="variant" class="round-border backBtn"  @click="$router.go(-1)">
                        <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                    </b-button>
                    <h5 class="m-0 p-0 ml-3">Vendor Listing</h5>
                </div>
            </div>

            <div class="col-lg-2 col-md-6"></div>
               
                <div class="col-lg-4 col-md-4">
                    <div class="form-group has-search fa_search">
                        <input
                        type="text"
                        class="form-control round-border p-4"
                        placeholder="Search by name,email or contact no."
                        v-model="searchQuery"
                        @keyup="getVendors"
                        />
                        <b><b-icon icon="search"></b-icon></b>
                    </div>
                    <div class="customer_sortout text-right" v-if="resultQuery.data && resultQuery.data.length > 0">
                        <button class="addBTTn" @click="redirectToAddVendor()">
                            <strong>Add New</strong>
                            </button>
                    </div>
                </div>
                </div>

            <div class="row ">
            <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div>  -->
            <div class="col-lg-12" v-if="resultQuery.data && resultQuery.data.length > 0">
               <div class="retail_price_detail"  v-for="(item,index) in resultQuery.data" :key="index">
                   <div class="retail_price_inner" >
                    <div class="row pb-3 pt-3">
                        <span class="table_arrow p-0">
                            <b-icon icon="trash-fill" class="text-danger" aria-hidden="true"></b-icon>
                            <b-icon icon="pencil-square" aria-hidden="true"  @click="active_item = (active_item == item.email ? '':item.email)"></b-icon> 
                        </span>
                        <div class="col-md-4 pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <strong>Name:</strong>
                                    {{item.fullname}}
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-8 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <strong>Email:</strong>
                                    {{item.email}}
                                </div>  
                            </div>
                        </div>  
                         <!-- <div class="col-md-4 pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <strong>Email:</strong>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-8 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    {{item.email}}
                                </div>  
                            </div>
                        </div>  -->
                    </div>

                    <b-collapse id ='collapse-find-sku' class="" :visible="active_item == item.email">
                        <div class="pending_watches_list pendingField">
                            <ul class="m-0 p-0">
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Name</b></p> 
                                            </div>
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <input type="text" v-model="item.fullname">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Email</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <input type="text" v-model="item.email">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Contact No.</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <input type="text" v-model="item.contact_no">
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Address</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <input type="text" v-model="item.address">
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="pt-4">
                                <div class="text-center">
                                    <default-button class="" variant="warning" text="Save"  @onSubmit="updateVendor(item)" />
                                    <default-button class="" variant="warning" text="Cancel"  />
                                </div>
                            </div>
                        </div>
                    </b-collapse> 
                   </div>
                   <div class="">
                       <div class="text-center sett_pagintation pb-3">
                        <pagination
                            class="justify-content-center"
                            :data="resultQuery"
                            @pagination-change-page="getVendors"
                        ></pagination>
                        </div>
                   </div>
               </div>
            </div>
            <div class="col-lg-12" v-else>
                <div class="container customer_id_detail  mt-3 p-3">
                    <div class="container info-div" :class="$mq">
                        <div
                            class="
                            bg-lightblue
                            no-border
                            text-center
                            d-flex
                            flex-nowrap
                            "
                        >
                            <div class="my-auto mr-3">
                            <b-icon icon="info-circle-fill" variant="light"></b-icon>
                            </div>
                            <span>
                            No <strong>vendor</strong> exists for this shop, please 
                            <router-link :to="{name:'add-vendor'}" class="text-warning"
                                :class="$store.state.dataStore.sale_person_id ? '' : 'disable_div'"> 
                            <strong>Create First</strong>
                            </router-link>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div> -->
        </div>

    </div>
</template>

<script> 
import { mapActions } from "vuex";
import Button from '../../components/Global/Button.vue';
import Loading from 'vue-loading-overlay';

    export default {
        components:{
                Button,
                 'loading':Loading
        },

        mounted() {
            this.getVendors();
        },

        computed: {
            resultQuery() {
                return this.vendors;
            },
        },
        data(){
            return {
                visible_find_sku:false,
                showDismissibleAlert:false,
                variant:null,
                searchQuery: "",
                active_item:'',
                vendors:{}
            }
        },
        methods:{
            ...mapActions("dataStore", ["removeTheItem",'setLoader']),

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

            clearAlert() 
            {
                this.alertMsg = '';
                this.variant = '';
                this.showDismissibleAlert = false;
            },

            redirectToAddVendor()
            {
               this.$router.push({
                   name:'add-vendor'
               });
            },

            
            updateVendor(item)
            {
              this.setLoader(true);
                let token = localStorage.getItem("token");
                axios.post('/api/update-vendor-of-shop',
                {
                    vendor : item
                },
                {
                    headers: 
                    {
                        Authorization: "Bearer " + token,
                    },
                }
                ).then(response=>{  
                if(response)
                {
                    this.setLoader(false);
                    this.$emit('showAlert',[response.data.response_header.response_message,'success'])
                    this.getEstimatedItems();
                }
                }).catch((error) => {
                    this.setLoader(false);
                        if (error.response) 
                        {
                            if (error.response.data.errors) {
                            let msg =
                                error.response.data.errors[
                                Object.keys(error.response.data.errors)[0]
                                ][0];
                            this.$emit("showAlert", [msg, "danger"]);
                            } else if (error.response.data.response_header.response_message) {
                            this.$emit("showAlert", [
                                error.response.data.response_header.response_message,
                                "danger",
                            ]);
                            }
                        } 
                        else 
                        {
                            this.$emit("showAlert", [error, "danger"]);
                        }
                });
            },


            getVendors(value) 
            {
            this.setLoader(true);
            axios.get("/api/get-outside-vendors-of-shop").then(response=>{
                // this.isLoading = false;
                console.log(response.data);
                var vendors = response.data.data;   
                this.vendors = vendors;
                this.setLoader(false);
                console.log(this.vendors);
            });
            },
        }
        
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}
.table_arrow { position: absolute; right: 20px; top: 20px; z-index: 2;}
.retail_price_inner .retail_price_col_head { padding: 10px 0px; border: 0px;}
.retail_price_col  { padding: 0px 10px;}
.retail_price_col_info p {
    padding: 0px  
}
.retail_field { text-align: left;}
.pending_watches_list ul li { border-bottom: 1px solid #fff;}
.pending_watches_list ul li:first-child { border-top: 1px solid #fff;}

.pending_watches_list .retail_price_col_info { padding: 10px 10px;}

.pending_watches_list { padding-bottom: 20px;}

.retail_field input { text-align: left;}

.retail_price_col_head strong b { font-weight: normal;}
</style>
