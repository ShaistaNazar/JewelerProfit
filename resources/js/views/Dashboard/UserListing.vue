<template>
    <div class="container">
        <!-- 
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        <!-- Header Component -->
        <!-- <custom-header/> -->

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

        <!-- <man-with-heading heading="Listing"/> -->

        <div class="row align-items-center pb-4">  
                    <div class="col-lg-6 col-md-6">
                        <div class="shank_tittle">
                            <b-button :variant="variant" class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                            <h5 class="m-0 p-0 ml-3">Customer Listing</h5>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="customer_sortout text-right">
                            <div class="dropdown myDropdown mr-3">
                                <b-dropdown id="dropdown-1" text="Sort By" class="">
                                <b-dropdown-item  @click="selectSalePerson(sale_person)" 
                                v-for="sale_person in sale_staff" :key="sale_person.id">
                                <span>{{sale_person.text}}</span></b-dropdown-item>
                                </b-dropdown>
                            </div>
                             <button class="addBTTn">Add New</button>
                        </div>
                    </div>
                </div>

        <div class="row ">
            <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div>  -->
            <div class="col-lg-12">
               <div class="retail_price_detail"  v-for="item in resultQuery.data" :key="item.id">
                   <div class="retail_price_inner" >
                    <div class="row pb-3 pt-3">
                        <span class="table_arrow">
                            <b-icon icon="trash-fill" class="text-danger" aria-hidden="true"></b-icon>
                            <b-icon icon="pencil-square" aria-hidden="true"  @click="active_item = (active_item == item.service_id ? '':item.service_id)"></b-icon> 
                        </span>
                        <div class="col-md-4 pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <strong>Customer Name:</strong>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-8 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                </div>  
                            </div>
                        </div>  
                    </div>

                    <b-collapse id ='collapse-find-sku' class="" :visible="active_item == item.service_id">
                        <div class="pending_watches_list">
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
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Primary Email</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Secondry Email</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Home Number</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li>
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Cell Number</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li> 
                                <li class="list-unstyled">
                                    <div class="row align-items-center">
                                        <div class="col-md-4 pr-0"> 
                                            <div class="retail_price_col_info">
                                                <p class=""><b>Cell Number</b></p> 
                                            </div> 
                                        </div>
                                        <div class="col-md-8 pl-0 pr-0"> 
                                            <div class="retail_price_col_info pl-0 "> 
                                                <div class="retail_price_col_info">
                                                    <p>John Smith</p>
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
                                                    <p>John Smith</p>
                                                </div>
                                            </div> 
                                        </div>
  
                                    </div>
                                </li> 
                            </ul>

                            <div class="pt-4">
                                <div class="text-center">
                                    <default-button class="" variant="warning" text="Save"  @onSubmit="updateEstimate(item)" />
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
                            @pagination-change-page="getEstimatedItems"
                        ></pagination>
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
import { mapGetters, mapActions } from "vuex";
import Button from '../../components/Global/Button.vue';
    export default {
        components:{
                Button 
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
                active_item:''
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
                axios
                    .get(`/api/update-estimated-item`, {
                    headers: {
                        Authorization: "Bearer " + token,
                    },
                    })
                    .then((response) => {
                        this.setLoader(false);
                        this.getEstimatedItems();
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
