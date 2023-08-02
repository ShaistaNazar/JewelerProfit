<template>
    <div class="container  pt-5 mx-auto">

        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>

        <!-- Header Component -->
        <custom-header/>

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->

            <man-with-heading heading="Engraving"/>

        <div class="row pt-3 align-items-center">
            <div class="col-md-3 text-left">
                <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
                    <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                </b-button>
            </div>
         
            <div class="col-md-5 text-left"></div>
            <div class="col-md-4 text-left">
                <div class="mySelect_outer d-flex justify-content-between align-items-center">
                <label>Sort by:</label>
                <div class="mySelect"><b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                </div>
            </div>
        </div> 

        <div class="row pt-3">
            <!-- <div class="col-lg-3 ">
                <custom-image src="assets/Jeweler_splash.png" alt="Jewelry Image" class_to_pass="img-fluid"/>
            </div>  -->
            <div class="col-lg-12">
               <div class="retail_price_detail">
                   <div class="retail_price_inner">
                        <span class="table_arrow" @click="visible_find_sku = !visible_find_sku;"><b-icon icon="pencil-square" aria-hidden="true"></b-icon></span>
                    <div class="row pb-4 pt-4">
                        <div class="col-md-3 pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Geller Sku:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Sku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Engraving type:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Machine</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pr-0  pl-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Description:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Small flat items-charms</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0  pr-0">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pl-0 ">
                            <div class="retail_price_col">
                                <div class="retail_price_col_head">
                                    <h5>Width:</h5>
                                </div> 
                                <div class="retail_price_col_info">
                                    <p>Add width</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <b-collapse id ='collapse-find-sku' class="" v-model="visible_find_sku">
                        <div class="retail_table_form text-center">
                            <div class="row" style="overflow-x: auto">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th scope="col">vendor cost </th>
                                    <th scope="col">retail price</th>
                                    <th scope="col">additional lines</th>
                                    <th scope="col">vendor cost</th>
                                    <th scope="col">engraving retail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td scope="row">
                                        <div class="retail_field">
                                            <input type="text" value="" placeholder="$5.00" >
                                        </div>
                                    </td>
                                    <td class="txt">
                                        <div class="retail_field">
                                            <input type="text" value="" placeholder="$5.00" >
                                        </div>
                                    </td>
                                    <td class="txt">
                                        <div class="retail_field">
                                            <input type="text" value="" placeholder="$5.00" >
                                        </div>
                                    </td>
                                    <td class="txt">
                                        <div class="retail_field">
                                            <input type="text" value="" placeholder="$5.00" >
                                        </div>
                                    </td>

                                    <td class="txt">
                                        <div class="retail_field">
                                            <input type="text" value="" placeholder="$5.00" >
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </b-collapse> 
                   </div>

                   <div class="pb-5">
                       <div class="text-center mt-5">
                        <default-button class="" variant="success" text="Save"  />
                        <default-button class="" variant="success" text="Cancel"  />
                        </div>
                   </div>


                   <div class="">
                       <div class="text-center sett_pagintation pb-3">
                        <pagination
                            class="justify-content-center"
                            :data="resultQuery"
                            @pagination-change-page="getChapterData"
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
    export default {
        components:{ 
        },

        mounted() {
        },
        
        data(){
            return { 
                visible_find_sku:false,
            }
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
        }
        
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}
.table_arrow { position: absolute; right: 20px; top: 20px; z-index: 2;}

</style>
