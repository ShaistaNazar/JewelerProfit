<template>
    <div class="container mx-auto">
    <div class="main_dashboard">
        <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
        <div class="container px-0 ">
        <div class="row pt-2">
        <div class="col-lg-3 text-left">

          <b-button
            variant="success"
            class="round-border backBtn"
            @click="$router.go(-1)">
            <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
            <!-- <h5 class="m-0 p-0 ml-3 text-white">Chapter {{$route.query.chapter}} Details</h5> -->

          </b-button>
        </div>
      </div>
      <div class="row text-center mt-3 mb-4" >
        <div class="bg-lightblue p-4 p-lg-5 customer_id_detail w-100">
          <div class="col-lg-12 col-md-12 p-0 pb-4 align-items-center">
              <!-- Actual search box -->
              <div class="form-group has-search fa_search col-lg-12 col-md-12 justify-content-center">
                <input
                  type="text"
                  class="form-control round-border p-4"
                  placeholder="Search by geller sku or major title"
                  v-model="searchQuery"
                  @keyup="getChapterDetails"
                />
                <b><b-icon icon="search"></b-icon></b>
              </div>
              <div class="col-lg-12 d-flex col-md-12 justify-content-center" v-if="enbale_editing">

                <div class="shank_tittle_head justify-content-center" v-if="$route.query.chapter !== 700 && master_price && master_price.torch_value  && master_price.laser_value">
                    <p class="pr-3 text-warning">Master Price</p>
                    <input type="text" style="width:auto" class="round-border form-control" v-model="master_price.torch_value"/>
                    <input type="text" style="width:auto" class="round-border form-control ml-2" v-model="master_price.laser_value"/>
                    <button data-v-2b2e44a2="" class="btn round-border ml-2  shadow-lg btn-success" @click="updateMasterPrice($route.query.chapter)">
                      Save
                    </button>
                </div>

                <div class="shank_tittle_head" v-if="$route.query.chapter !== 700 && master_price && master_price.torch_value  && !master_price.laser_value">
                    <p class="pr-3 text-warning">{{master_price.major_item}}</p>
                    <input type="text" style="width:auto" class="round-border form-control" v-model="master_price.torch_value"/>
                    <button data-v-2b2e44a2="" class="btn round-border ml-2  shadow-lg btn-success" @click="updateMasterPrice($route.query.chapter)">
                      Save
                    </button>
                </div>

                 <div class="shank_tittle_head" v-if="$route.query.chapter == 700 && master_price">
                      <div v-for="(price,price_index) in master_price" :key="price_index">
                        <label class="ml-3">
                          <span>{{price['major_item']}}</span>
                        </label>
                          <b-form-input id="type_number" v-model="price['setting_labor_without_discount']"></b-form-input>
                      </div>
                    <button data-v-2b2e44a2="" class="btn round-border ml-2  shadow-lg btn-success" @click="updateMasterPrice($route.query.chapter)">
                      Save
                    </button>
                </div>

                 <div class="shank_tittle_head" v-if="$route.query.chapter == 900 && master_price">
                      <div v-for="(price,price_index) in master_price" :key="price_index">
                        <label class="ml-3">
                          <span>{{price['major_item']}}</span>
                        </label>
                          <b-form-input id="type_number" v-model="price['master_price']"></b-form-input>
                      </div>
                    <button data-v-2b2e44a2="" class="btn round-border ml-2  shadow-lg btn-success" @click="updateMasterPrice($route.query.chapter)">
                      Save
                    </button>
                </div>

              </div>
            </div>
          
          <div class="row m-0" style="overflow-x: auto">
            <table class="table id_table">
              <thead>

                <tr v-if="this.$route.query.chapter == '100'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">JLRC</th>
                  <th scope="col">First Size Larger JLRC</th>
                  <th scope="col">Each Additional JLRC</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">Type</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Size</th>
                  <th scope="col">Width</th>
                  <th scope="col">Shape</th>
                </tr>
                <tr v-if="this.$route.query.chapter == '200'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">JLRC Labor Torch</th>
                  <th scope="col">JLRC Labor Laser</th>
                </tr>
                <tr v-if="this.$route.query.chapter == '300'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Size</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">JLRC Labor Torch</th>
                  <th scope="col">JLRC Labor Laser</th>
                </tr>

                 <tr v-if="this.$route.query.chapter == '400'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Type</th>
                  <th scope="col">Stone Shape</th>
                  <th scope="col">Stone Size</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">Setting Charges</th>
                  <th scope="col">Soldering Charges</th>
                </tr>
  
                <tr v-if="this.$route.query.chapter == '500'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Engraving Type</th>
                  <th scope="col">Item Type</th>
                  <th scope="col">Description</th>
                  <th scope="col">Width</th>
                  <th scope="col">Minimum no. of Letters/Lines</th>
                  <th scope="col">Retail Price</th>
                  <th scope="col">Vendor Cost for retail price</th>
                  <th scope="col">Additional Letters Over 03</th>
                  <th scope="col">Additional Letters Over 08</th>
                  <th scope="col">Additional Letters Over 15</th>
                  <th scope="col">Additional Line</th>
                  <th scope="col">Vendor cost for additional Line</th>
                </tr>
                
                <tr v-if="this.$route.query.chapter == '600'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Setting Type</th>
                  <th scope="col">Description</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Shape</th>
                  <th scope="col">Size</th>
                  <th scope="col">No. of Prongs</th>
                </tr>


              <tr v-if="this.$route.query.chapter == '700'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Setting Type</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Item Type</th>
                  <th scope="col">Carats</th>
                  <th scope="col">Stone Size</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">Setting Labor Without Discount</th>
                  <th scope="col">Setting Labor With Discount</th>
                  <th scope="col">JLRC Without Discount</th>
                  <th scope="col">JLRC with Discount</th>
                  <th scope="col">Stone Range</th>
                </tr>

              
              <tr v-if="this.$route.query.chapter == '800'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Type</th>
                  <th scope="col">Inside Diameter</th>
                  <th scope="col">Size</th>
                  <th scope="col">Description</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Shape</th>
                  <th scope="col">Color</th>
                  <th scope="col">Stuller Amount</th>
                  <th scope="col">Setting Charges</th>
                  <th scope="col">Soldering Charges</th>
                </tr>
               <tr v-if="this.$route.query.chapter == '900'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Complexity</th>
                  <th scope="col">Description</th>
                  <th scope="col">Welding Technology</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">Soldering Labor Without Discount</th>
                  <th scope="col">Soldering Labor With Discount</th>
                  <th scope="col">JLRC Without Discount</th>
                  <th scope="col">JLRC With Discount</th>
                </tr>
                <tr v-if="this.$route.query.chapter == '1000'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Type</th>
                  <th scope="col">Part Retail</th>
                  <th scope="col">Labor Retail</th>
                  <th scope="col">Cast Into</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Description</th>
                  <th scope="col">Way around </th>
                  <th scope="col">Length Of Chain</th>
                  <th scope="col">Stone Details</th>
                  <th scope="col">Who Keeps Mold</th>
                </tr>
                 
                <tr v-if="this.$route.query.chapter == '1100'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Description</th>
                  <th scope="col">Each Additional</th>
                  <th scope="col">Thickness</th>
                  <th scope="col">Note</th>
                </tr>

                <tr v-if="this.$route.query.chapter == '1200'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Retail Price</th>
                  <th scope="col">Type</th>
                  <th scope="col">Each Additional</th>
                  <th scope="col">Description</th>
                  <th scope="col">Vendor Cost</th>
                  <th scope="col">Size</th>
                  <th scope="col">Karats</th>
                  <th scope="col">Color</th>
                  <th scope="col">Setting Charges</th>
                  <th scope="col">Soldering Charges</th>
                  <th scope="col">Sizing Amount</th>
                  <th scope="col">Handmade Piece Weight 14kt</th>
                  <th scope="col">Handmade Piece Weight 18kt</th>
                  <th scope="col">Note</th>
                </tr>
                <tr v-if="this.$route.query.chapter == '1300'">
                  <th scope="col">Geller SKU</th>
                  <th scope="col">Major Item</th>
                  <th scope="col">Retail Price</th>
                  <th scope="col">Type</th>
                  <th scope="col">Shape</th>
                  <th scope="col">Description</th>
                  <th scope="col">Vendor Cost</th>
                  <th scope="col">Color</th>
                  <th scope="col">Carats</th>
                  <th scope="col">Diamond Grade</th>
                  <th scope="col">Size</th>
                  <th scope="col">Cut</th>
                  <th scope="col">Quality</th>
                </tr>

              </thead>
              <tbody  v-if="$route.query.chapter == '100' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.JLRC }}</td>
                  <td class="txt" >{{ record.first_size_larger }}</td>
                  <td class="txt" >{{ record.each_additional_size_JLRC }}</td>
                  <td class="txt" >{{record.stuller_amount}}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.width }}</td>
                  <td class="txt" >{{ record.shape }}</td>
                  
                </tr>
              </tbody>
              <tbody  v-if="$route.query.chapter == '200' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                > 
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{record.stuller_amount}}</td>
                  <td class="txt" >{{ record.JLRC_labor_torch }}</td>
                  <td class="txt" >{{ record.JLRC_labor_laser }}</td>
                  
                </tr>
              </tbody>
              <tbody  v-if="$route.query.chapter == '300' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                > 
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.JLRC_labor_torch }}</td>
                  <td class="txt" >{{ record.JLRC_labor_laser }}</td>
                  
                </tr>
              </tbody>

               <tbody  v-if="$route.query.chapter == '400' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                > 
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.stone_shape }}</td>
                  <td class="txt" >{{ record.stone_size }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.setting_charges }}</td>
                  <td class="txt" >{{ record.soldering_charges }}</td>
                  
                </tr>
              </tbody>

              <tbody  v-if="$route.query.chapter == '500' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.engraving_type }}</td>
                  <td class="txt" >{{ record.item_type }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.width }}</td>
                   <!-- <td class="txt" > 
                    <span v-if="record.price_criteria_item.toLowerCase().includes('letter')">{{ record.no_of_price_criteria_item }}</span> 
                    <span v-else-if="record.price_criteria_item.toLowerCase().includes('line')">{{ record.no_of_price_criteria_item }}</span> 
                   </td>  -->
                  <td class="txt" >{{ record.no_of_price_criteria_item }}</td>
                  <td class="txt" >{{ record.retail_price }}</td>
                  <td class="txt" >{{ record.vendor_cost_retail_price }}</td>
                  <td class="txt" >{{ record.additional_letters_over_03 }}</td>
                  <td class="txt" >{{ record.additional_letters_over_08 }}</td>
                  <td class="txt" >{{ record.additional_letters_over_15 }}</td>
                  <td class="txt" >{{ record.additional_lines_engraving_retail }}</td>
                  <td class="txt" >{{ record.vendor_cost_additional_lines_engraving_retail }}</td>

                </tr>
              </tbody>
                              
              <tbody  v-if="$route.query.chapter == '600' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                > 
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.setting_type }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.shape }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.no_of_prongs }}</td>
                </tr>
              </tbody>
            <tbody  v-if="$route.query.chapter == '700' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                > 
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.setting_type }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.item_type }}</td>
                  <td class="txt" >{{ record.carats }}</td>
                  <td class="txt" >{{ record.stone_size }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.setting_labor_without_discount }}</td>
                  <td class="txt" >{{ record.setting_labor_with_discount }}</td>
                  <td class="txt" >{{ record.JLRC_without_discount }}</td>
                  <td class="txt" >{{ record.JLRC_with_discount }}</td>
                  <td class="txt" >{{ record.no_of_price_criteria_item }}</td>
                </tr>
              </tbody>

               <tbody  v-if="$route.query.chapter == '800' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.inside_diameter }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.shape }}</td>
                  <td class="txt" >{{ record.color }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.setting_charges }}</td>
                  <td class="txt" >{{ record.soldering_charges }}</td>

                </tr> 
              </tbody>
              
              <tbody  v-if="$route.query.chapter == '900' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.complexity }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.welding_technology }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.soldering_labor_without_discount }}</td>
                  <td class="txt" >{{ record.soldering_labor_with_discount }}</td>
                  <td class="txt" >{{ record.JLRC_without_discount }}</td>
                  <td class="txt" >{{ record.JLRC_with_discount }}</td>
                </tr>
              </tbody>

              <tbody  v-if="$route.query.chapter == '1000' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.stuller_amount }}</td>
                  <td class="txt" >{{ record.retail_labor }}</td>
                  <td class="txt" >{{ record.cast_into }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.way_around }}</td>
                  <td class="txt" >{{ record.length_of_chain }}</td>
                  <td class="txt" >{{ record.stone_details }}</td>
                  <td class="txt" >{{ record.who_keeps_mold }}</td>
                </tr>
              </tbody>
              <tbody  v-if="$route.query.chapter == '1100' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.each_additional }}</td>
                  <td class="txt" >{{ record.thickness }}</td>
                  <td class="txt" >{{ record.note }}</td>
                </tr>
              </tbody>

              

              <tbody  v-if="$route.query.chapter == '1200' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.retail_price }}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.each_additional }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.vendor_cost }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.karats }}</td>
                  <td class="txt" >{{ record.color }}</td>
                  <td class="txt" >{{ record.setting_charges }}</td>
                  <td class="txt" >{{ record.soldering_charges }}</td>
                  <td class="txt" >{{ record.sizing_stock_amount }}</td>
                  <td class="txt" >{{ record.handmade_piece_weight_14kt }}</td>
                  <td class="txt" >{{ record.handmade_piece_weight_18kt }}</td>
                  <td class="txt" >{{ record.info_popup }}</td>
                </tr>
              </tbody>

              <tbody  v-if="$route.query.chapter == '1300' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  v-for="record in resultQuery.data"
                  :key="record.geller_sku"
                >
                  <td scope="row" class="txt" >{{ record.geller_sku }}</td>
                  <td class="txt" >{{ record.major_item }}</td>
                  <td class="txt" >{{ record.retail_price }}</td>
                  <td class="txt" >{{ record.type }}</td>
                  <td class="txt" >{{ record.shape }}</td>
                  <td class="txt" >{{ record.description }}</td>
                  <td class="txt" >{{ record.vendor_cost }}</td>
                  <td class="txt" >{{ record.color }}</td>
                  <td class="txt" >{{ record.carats }}</td>
                  <td class="txt" >{{ record.diamond_grade }}</td>
                  <td class="txt" >{{ record.size }}</td>
                  <td class="txt" >{{ record.cut }}</td>
                  <td class="txt" >{{ record.quality }}</td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center sett_pagintation pb-3 m-5">
      <pagination
        class="justify-content-center"
        :data="resultQuery"
        @pagination-change-page="getChapterDetails"
      ></pagination>
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
    } from "vuelidate/lib/validators";
import Input from '../../components/Global/Input.vue';
import Button from '../../components/Global/Button.vue';

    export default {

        components: {
        'loading':Loading,
                Input,
                Button
        },
        beforeMount()
        {
          this.fetchUser();
        },
        mounted() {
            this.getChapterDetails();
        },
        computed: {
          resultQuery() {
            // if (this.searchQuery && this.searchQuery != "") {
            //   console.log(typeof this.customers);
            //   return this.customers.filter((customer) => {
            //     console.log(this.customers.data);
            //     console.log(customer);
            //     return this.searchQuery
            //       .toLowerCase()
            //       .split(" ")
            //       .every(
            //         (v) =>
            //           customer.customer_id.toLowerCase().includes(v) ||
            //           customer.firstname.toLowerCase().includes(v) ||
            //           customer.lastname.toLowerCase().includes(v)
            //       );
            //   });
            // } else {
              return this.chapter_details;
            // }
          },
        },
        data(){
            return {
              
                searchQuery: "",
                showDismissibleAlert: false,
                chapter_details:{},
                master_price:{},
                seen:false,
                new_master_price:[],
                enbale_editing:false, 

            }
        },
        validations: {
           
        },
        methods:{ 
      ...mapActions("dataStore", ['setLoader']),
        fetchUser() {

        var user = null;
        setTimeout(() => {
          axios.post('/api/user',{},{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}})
          .then(response=>{
            user = response.data;
            console.log(user.roles[0]);
            if(user && user.roles && user.roles[0].guard_name == 'super_admin_api' && 
               user.roles[0].name == 'super_admin')
               {
                this.enbale_editing = true
               }

          }).catch(error=>{
            
          });
        }, 1000);
      },
    updateMasterPrice(chapter)
      {
        console.log('chapter',chapter);
        this.setLoader(true);
        let token = localStorage.getItem("token");
        var r = confirm("Are you sure to Change Master Price, It may effect all other calculations");
        console.log('this.master_price',this.master_price);
        if (r == true)
        {
          console.log(this.$route.query.chapter,typeof this.$route.query.chapter)
          if(!(this.$route.query.chapter == '700' ) && !(this.$route.query.chapter == '900' ))
          {
            console.log('not 700');
            axios.post(`/api/change-master-price-${chapter}`,{
            laser_value: this.master_price.laser_value,
            torch_value:this.master_price.torch_value,
            geller_sku:this.master_price.geller_sku
            },{
            headers: {
            'Authorization': 'Bearer ' + token
            }
            }).then((response) => {
            this.setLoader(false);
            this.getChapterDetails();
          }).catch((error) => 
          {
          });
          }
          else if(this.$route.query.chapter == '700' || this.$route.query.chapter == '900')
          {
            console.log('should be in cas')
            axios.post(`/api/change-master-price-${chapter}`,{
            data: this.master_price
            },{
            headers: {
            'Authorization': 'Bearer ' + token
            }
            }).then((response) => {
            this.setLoader(false);
            this.getChapterDetails();
          }).catch((error) => 
          {
          });
          }
        }
        else 
        {
          return;
        }
      },
      getChapterDetails(page = 1) {
 
      this.setLoader(true);
      var token = localStorage.getItem("token");
        axios.get(`/api/get-chapter-data?chapter=${this.$route.query.chapter}&filter=${this.searchQuery}&page=` + page, {
          headers: {
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => {
          this.setLoader(false);
          this.chapter_details = response.data.data.details;
          this.master_price = response.data.data.master_prices;
          this.chapter_columns = response.data.data.chapter_columns[0];
          this.new_master_price = this.master_price.JLRC.trim();
          console.log('chapter_details',response.data.data.data);
        })
        .catch((error) => {
         this.setLoader(false);
          if (error.response) {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.$emit("showAlert", [msg, "danger"]);
            } else if (error.response.data.response_header.response_message) 
            {
              this.$emit("showAlert", [
                error.response.data.response_header.response_message,
                "danger",
              ]);
            }
          } else {
            this.$emit("showAlert", [error, "danger"]);
          }
        });
    }, 
            },
        }
    
    
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
