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
             <div class="col-lg-8 col-md-8">
                <div class="shank_tittle">
                      <b-button class="round-border backBtn"  @click="$router.go(-1)">
                          <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                      </b-button>
                      <h5 class="m-0 p-0 ml-3">Envelopes</h5>
                  </div>
              </div>

              <div class="col-lg-4 col-md-4">
                  <div class="mySelect_outer d-flex justify-content-between align-items-center">
                      <b-button class="btn-warning" v-b-modal.location-modal>Move Locations</b-button>
                  </div>
              </div>
            </div>
          
          <div class="row m-0" style="overflow-x: auto">
            <table class="table id_table table-hover">
              <thead>

                <tr>
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
              
              </thead>
              <tbody  v-if="$route.query.chapter == '100' && resultQuery.data && resultQuery.data.length > 0">
                <tr
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
                  style="cursor:pointer"
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
        @pagination-change-page="getSortBox"
      ></pagination>
    </div>
    </div>
    </div>
</template>

 <script>
// import {mapActions} from 'vuex';
// import Loading from 'vue-loading-overlay';

//     /**
//      * Vuelidate items
//      */
    
//     import { 
//     } from "vuelidate/lib/validators";
// import Input from '../../components/Global/Input.vue';
// import Button from '../../components/Global/Button.vue';

//     export default {

//         components: {
//         'loading':Loading,
//                 Input,
//                 Button
//         },

//         mounted() {
//             this.getSortBox();
//         },
//         computed: {
//           resultQuery() {
//             // if (this.searchQuery && this.searchQuery != "") {
//             //   console.log(typeof this.customers);
//             //   return this.customers.filter((customer) => {
//             //     console.log(this.customers.data);
//             //     console.log(customer);
//             //     return this.searchQuery
//             //       .toLowerCase()
//             //       .split(" ")
//             //       .every(
//             //         (v) =>
//             //           customer.customer_id.toLowerCase().includes(v) ||
//             //           customer.firstname.toLowerCase().includes(v) ||
//             //           customer.lastname.toLowerCase().includes(v)
//             //       );
//             //   });
//             // } else {
//               return this.chapter_details;
//             // }
//           },
//         },
//         data(){
//             return {
              
//                 searchQuery: "",
//                 showDismissibleAlert: false,
//                 chapter_details:{},
//                 master_price:{},
//                 seen:false,
//                 new_master_price:[],
//                 sort_box:[],
              
//             }
//         },
//         validations: {
           
//         },
//         methods:{ 
//       ...mapActions("dataStore", ['setLoader']),

//       updateMasterPrice(chapter)
//       {
        
//       },
//       getSortBox(page = 1) {

//         this.setLoader(true);
//         var token = localStorage.getItem("token");
//         axios
//             .get(`/api/get-sort-box?filter=${this.searchQuery}&page=` + page, {
//             headers: {
//                 Authorization: "Bearer " + token,
//             },
//             })
//             .then((response) => {
//             this.setLoader(false);
//             this.sort_box = response.data.data;
//             console.log(response.data.data);
//             })
//         .catch((error) => {
//          this.setLoader(false);
//           if (error.response) {
//             if (error.response.data.errors) {
//               let msg =
//                 error.response.data.errors[
//                   Object.keys(error.response.data.errors)[0]
//                 ][0];
//               this.$emit("showAlert", [msg, "danger"]);
//             } else if (error.response.data.response_header.response_message) {
//               this.$emit("showAlert", [
//                 error.response.data.response_header.response_message,
//                 "danger",
//               ]);
//             }
//           } else {
//             this.$emit("showAlert", [error, "danger"]);
//           }
//         });
//         }, 
//     },
// }
    
    
// </script>
 <style scoped>

.socialImg{
    width: 20px !important;
}


</style>
