<template>
    <div class="container">
        <!-- 
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
        <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <man-with-heading heading="Pending Watches"/>

        <div class="row pt-3 align-items-center">
            <div class=" col-md-3 col-lg-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
            <div class=" col-md-3 col-lg-5 text-left">
            </div>
            <div class=" col-md-6 col-lg-4 text-left">
                <div class="mySelect_outer d-flex justify-content-between align-items-center">
                <label>Sort by:</label>
                <div class="form-group has-search fa_search m-0">
                    <input
                    type="text"
                    class="form-control round-border p-4"
                    placeholder="Search by service id" 
                    v-model="searchQuery"
                    @keyup="getEstimatedItems"
                    />
                    <b><b-icon icon="search"></b-icon></b>
                </div>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div>  -->
            <div class="col-lg-12">
               <div class="retail_price_detail" v-for="item in resultQuery.data" :key="item.id">
                   <div class="retail_price_inner">
                        <div class="row pb-3 pt-3">
                            <span class="table_arrow" @click="active_item = (active_item == item.service_id ? '':item.service_id)">
                                <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
                            </span>
                            <div class="col-md-3 pr-0">
                                <div class="retail_price_col">
                                    <div class="retail_price_col_head">
                                        <strong>Service ID: <b class="pl-2">{{item.service_id}}</b></strong>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-2 pr-0  pl-0">
                                <div class="retail_price_col">
                                    <div class="retail_price_col_head">
                                        <strong>Geller SKU <b class="pl-2">{{item.geller_sku}}</b></strong>
                                    </div>  
                                </div>
                            </div> 
                            <div class="col-md-3 pr-0  pl-0">
                                <div class="retail_price_col">
                                    <div class="retail_price_col_head">
                                        <strong>Vendor <b class="pl-2">{{item.vendor.fullname}}</b></strong>
                                    </div>  
                                </div>
                            </div> 
                        </div>

                        <b-collapse id ='collapse-find-sku' class="" :visible="active_item == item.service_id">
                            <div class="pending_watches_list">
                                <ul class="m-0 p-0">
                                    <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>Date Sent</b></p> 
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0"> 
                                                <div class="retail_price_col_info pl-0 "> 
                                                    <div class="retail_field">
                                                        <b-form-datepicker
                                                            id="date-picker-label"
                                                            v-model="item.date_sent"
                                                            class="round-border p-2 text-left"
                                                        ></b-form-datepicker>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </li> 
                                    <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>date_received_back_into_store</b></p> 
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0"> 
                                                <div class="retail_price_col_info pl-0 "> 
                                                    <div class="retail_field">
                                                        <b-form-datepicker
                                                            id="date-picker-label"
                                                            v-model="item.date_received_back_into_store"
                                                            class="round-border p-2 text-left"
                                                        ></b-form-datepicker>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </li> 
                                    <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>Estimated cost</b></p> 
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0">
                                                <div class="retail_price_col_info pl-0 ">
                                                    <div class="retail_field">
                                                        <input type="number" v-model="item.estimated_cost_finalized">
                                                        <span class="text-warning">where estimation is: {{item.estimated_cost_from +' to '+item.estimated_cost_to}}</span>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>Retail Price</b></p> 
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0"> 
                                                <div class="retail_price_col_info pl-0 "> 
                                                    <div class="retail_field">
                                                        <input type="text" v-model="item.retail_price">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </li>
                                    
                                     <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>Work to be Performed</b></p> 
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0"> 
                                                <div class="retail_price_col_info pl-0 "> 
                                                    <div class="retail_field">
                                                        <input type="text" v-model="item.work_to_be_performed" >
                                                    </div>
                                                </div> 
                                            </div>
    
                                        </div>
                                    </li> 


                                    <li class="list-unstyled">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 pr-0"> 
                                                <div class="retail_price_col_info">
                                                    <p class=""><b>Customer Feedback</b></p> 
                                                </div> 
                                            </div>
                                            <div class="col-md-6 pl-0 pr-0"> 
                                                <div class="retail_price_col_info pl-0 "> 
                                                    <div class="retail_field">
                                                       <b-form-group>
                                                            <b-form-radio v-model="item.customer_approved_or_declined" :aria-describedby="ariaDescribedby" name="some-radios" >Customer Approved</b-form-radio>
                                                            <b-form-radio v-model="item.customer_approved_or_declined" :aria-describedby="ariaDescribedby" name="some-radios" >Customer Rejected</b-form-radio>
                                                        </b-form-group>
                                                    </div>
                                                </div> 
                                            </div>    
                                        </div>
                                    </li> 


                                    <li>
                                        <b-form-checkbox id='is_rush'
                                            v-model="item.is_rush"
                                            name="is_rush"
                                            :value="true"
                                            :unchecked-value="false"
                                        >It was a Express Job</b-form-checkbox>
                                    </li>
                                </ul>

                                <div class="pt-4">
                                    <div class="text-center">
                                        <default-button class="" variant="warning" text="Save"  @onSubmit="updateEstimate(item)" />
                                        <default-button class="" variant="warning" text="Cancel" @onSubmit="getEstimatedItems()" />
                                    </div>
                                </div>
                            </div>
                            
                        </b-collapse> 
                   </div>
                   
               </div>
            </div>

          <div class="">
            <div class="text-center sett_pagintation pb-3">
            <pagination
                class="justify-content-center"
                :data="resultQuery"
                @pagination-change-page="getEstimatedItems"
            ></pagination>
            </div>
        </div>
        </div>

    </div>
</template>

<script> 
import { mapGetters, mapActions } from "vuex";
    export default {
        components:{ 
        },

        mounted() {
            this.getEstimatedItems();
        },
        computed: {
            resultQuery() {
                return this.estimated_items;
            },
        },
        data(){
            return {
                visible_find_sku:false,
                showDismissibleAlert:false,
                variant:null,
                estimated_items:{},
                searchQuery: "",
                active_item:'',
                radio_options: [
                // radio    
                { text: 'Yes', value: 1 },
                { text: 'No', value: 0 },       
            ], 
            selectedRadio: 0,
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

            getEstimatedItems(page = 1) 
            {
                this.setLoader(true);
                let token = localStorage.getItem("token");
                axios
                    .get(`/api/get-estimated-items?filter=${this.searchQuery}&page=` + page, {
                    headers: {
                        Authorization: "Bearer " + token,
                    },
                    })
                    .then((response) => {
                    this.setLoader(false);
                    this.estimated_items = response.data.data;
                    console.log(response.data.data);
                    })
                    .catch((error) => {
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

            updateEstimate(item)
            {
              this.setLoader(true);
                let token = localStorage.getItem("token");
                axios.post('/api/update-estimate',
                {
                    estimated_item: item
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
            }
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
