<template>
  <div class="">
    <!-- Page Loader -->
   <div class="vld-parent"  v-show="$store.state.dataStore.isLoading">
      <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
  </div>

    

     <div class="container">
      <div class="text-center  mb-5 mt-5">
        <div class=" p-0 p-lg-5 pt-lg-0">
          <div class="">
          <!-- <div class="row breadCrumb_sett mb-3"> -->
            <!-- <nav aria-label="breadcrumb"> -->
              <!-- {{$store.state.dataStore.selections}}== {{$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]}} -->
              <!-- <ol class="breadcrumb" v-if="Object.keys(
                    $store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]).length > 0">
                <li
                  class="breadcrumb-item"
                  v-for="(crumb, index) in Object.keys(
                    $store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]
                  )"
                  :key="index"
                > -->
                  <!-- <router-link :to="crumb == 'major_item' ? '/main-menu' : '/choose-next/'+crumb" class="text-success">
                  {{ 
                  crumb.split('_')
                  .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                  .join(' ') 
                  }}
                  </router-link> -->
                  <!-- 
                  test
                </li>
              </ol> -->
            <!-- </nav> -->
          <!-- </div> -->
          <div class="row pb-5 pb-lg-0">
            <div class="col-lg-6 ">
              <div>
                <ul class="list-unstyled priceDescriptio">
                  <li class="">
                    <div class="add_photo settPrice_img">
                      <h5 v-if="$store.state.dataStore.descriptionOfItem.photo" class="text-left pb-2">Photos</h5>
                      <div class=" d-flex">
                        <ul>
                          <li>
                            <div class="profileInfo_pic">
                              <span v-if="$store.state.dataStore.descriptionOfItem.photo"
                                ><custom-image
                                  :src="base_path+'/storage/'+$store.state.dataStore.descriptionOfItem.photo"
                                  alt="Jewelry Image"
                                  class_to_pass="img-fluid" /></span>
                            </div>
                          </li>
                        </ul>

                        <div class="text-left pl-3">
                        <p class=""><b>Price:</b> <span v-if="pricingDetails.grand_total">$</span>{{ pricingDetails.grand_total }}</p>
                        <p class=""> 
                          <b>Geller SKU:</b> {{actual_item.geller_sku}}
                        </p>
                        <p class=""><b>Envelope#: </b>{{$store.state.dataStore.envelope_numbers[$store.state.dataStore.selected_envelope_number]}}</p>
                      </div> 

                        </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="">
                <ul class="list-unstyled text-right priceDescriptio m-0"> 
                  <li class="pb-3" v-if="$store.state.dataStore.descriptionOfItem">
                      <span class="icon is-small is-right sku_icons" @click="togglefill()">
                        <!-- <b-icon :icon='heartIcon' aria-hidden="true"></b-icon>  -->
                      </span> 
                      <!-- <strong class="text-white evnlop_badge">Customer Repairs <span class="badge" 
                      v-if="state.no_of_generated_envelopes in state.items_price_detail && state.items_price_detail[state.no_of_generated_envelopes][state.envelope_numbers[state.selected_envelope_number]][state.main_chapter]
                      ">{{$store.state.dataStore.no_of_items_in_envelope}}</span></strong>  -->
                  </li>
                </ul>
              </div>

              <div class="text-right" v-if="$store.state.dataStore.if_history_added">
                <default-button
                  variant="success"
                  text="Add Other Items To envelope"
                  class="active_btn" 
                  @onSubmit="ContinueToAddEnvelopeItem()"
                />
                <default-button variant="success" text="Checkout" @onSubmit="CheckoutTheEnvelope()"/>
              </div>
              <div class="text-right" v-else>
                  <default-button variant="success" text="Add to Envelope" @onSubmit="addToEnvelope()"/>
              </div>
            </div>
          </div>



          <div class="vue_tabs pt-md-3 mt-md-3">
            <b-tabs content-class=" bg-lightblue" align="left">

              

              <b-tab title="Calculation" active v-if="(!set_estimate_only) && !(go_with_estimation)">
                <div class="row">
                  <div class="col-lg-12 d-none" v-if="1 == 0">
                    <h4 class="pb-2 text-capitalize text-center">{{ subHeading }}</h4>
                    <div class="calculation_table pb-3">
                      <table class="table">
                        <thead class="">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Total Retail</th>
                            <th scope="col">Sales Tax</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>${{ pricingDetails.grand_total }}</td>
                            <td>${{ pricingDetails.sales_tax }}</td>
                            <td>${{ pricingDetails.total_with_sales_tax}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div >
                      <h4 class="text-capitalize pt-3">{{ subHeading4 }}</h4>
                      <div class="row pt-4 pb-md-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                          <div class="myForn">
                            <ul class="list-unstyled">
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="number"
                                  class="round-border p-3"
                                  placeholder="Other Cost"
                                  v-model="other_cost"
                                  name="text"
                                ></b-form-input>
                                </div>
                              </li>
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="number"
                                  class="round-border p-3"
                                  placeholder="Other Retail"
                                  name="text"
                                  v-model="other_retail"
                                ></b-form-input>
                                </div>
                              </li>
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="text"
                                  class="round-border p-3"
                                  placeholder="Note (optional)"
                                  name="text"
                                  v-model="other_note"
                                ></b-form-input>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="text-center pb-4">
                            <default-button
                              variant="warning"
                              text="Adjust Amount"
                              @onSubmit="addOtherAmount()"
                            />
                          </div>
                        </div>
                        <div class="col-lg-2">
                        </div>
                      </div>
                    </div>

                  </div>
                   

                  <div class="col-lg-12" >
                    
                       <!-- <div class="text-right">
                        
                        <b-icon icon="arrow-repeat" class="text-warning" font-scale="2" aria-hidden="true" @click="reviewFlowOptions()"></b-icon>
                        
                      </div>  -->
                    <div class="tableName ">
                      

                      <div class="aa " v-for="(specs1,index) in $store.state.dataStore.selections" :key="index">
                        <strong class="text-left pb-3" v-if="index == $store.state.dataStore.main_chapter">
                          Chapter {{index}}
                        </strong>
                        <strong class="text-left pb-3" v-if="index !== $store.state.dataStore.main_chapter">
                          Part Specifications
                        </strong>
                        <div class="item_info specs_list2  mb-4">
                            <div v-for="(specs_item1,index_specs) in specs1" :key="index_specs">
                              <div style="display:block"
                                class="
                                  item_info_detail p-0 pt-3
                                "
                              >
                        
                              <div class="maincalc">
                                  <div class="" v-for="(specification,spec_item_index) in specs_item1['options']" :key="spec_item_index">
                                    <div class="innerData_text" v-if="spec_item_index !== 'popup' && spec_item_index !== 'complication_surcharge_selected'">
                                      <label 
                                      v-if="$store.state.dataStore.enable_check_and_tighten && 
                                      '700' in $store.state.dataStore.extra_work_details && 
                                      'flow_details' in $store.state.dataStore.extra_work_details['700'] && 
                                      $store.state.dataStore.extra_work_details['700']
                                      ['flow_details']['procedure_details_1']['no_of_items']">
                                       <em>
                                        No. of stones - {{$store.state.dataStore.extra_work_details['700']['flow_details']['procedure_details_1']['no_of_items']}}
                                       </em>
                                        </label>  
                                        <label v-else>
                                           <em v-if="spec_item_index !== 'no_of_price_criteria_item' && spec_item_index !== 'require_weight_popup'
                                           ">
                                           {{
                                              spec_item_index.split('_')
                                              .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                              .join(' ')
                                            }}
                                          </em>

                                         <em v-if="spec_item_index == 'require_weight_popup'">
                                            Weight (DWT)
                                        </em>

                                        <em v-if="spec_item_index == 'no_of_price_criteria_item' && 
                                        typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== '' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== 'N/A'">
                                        No of {{$store.state.dataStore.price_criteria_item_name[0]}}s
                                        </em> 
                                        
                                        <span v-if="spec_item_index == 'no_of_price_criteria_item' && 
                                        typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== '' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== 'N/A'"> - {{specification}},
                                        </span>
                                        <span v-else-if="spec_item_index !== 'no_of_price_criteria_item'">
                                           - {{specification}}
                                        </span>
                                        </label>
                                    </div>  
                                    <div  class=" text-left" v-else-if="spec_item_index == 'complication_surcharge_selected'">
                                      <label>
                                        with following services
                                        <ul>
                                          <li v-for="(extra_charges_index,extra_charge) in $store.state.dataStore.complication_surcharges" :key="extra_charge">
                                            <span v-if="extra_charges_index">{{extra_charge}}</span>
                                          </li>
                                        </ul>
                                      </label>
                                    </div>  
                                  </div>
                                </div>

                                <div class="maincalc">
                                  <div class="" >
                                    <div class="innerData_text" v-if="$store.state.dataStore.enable_check_and_tighten && 
                                      '700' in $store.state.dataStore.extra_work_details && 
                                      'flow_details' in $store.state.dataStore.extra_work_details['700'] && 
                                      $store.state.dataStore.extra_work_details['700']
                                      ['flow_details']['procedure_details_1']['no_of_items']">
                                      <label>
                                        <em>
                                          Check and Tighten - enabled
                                        </em>
                                        <em>
                                          No. of stones - {{$store.state.dataStore.extra_work_details['700']['flow_details']['procedure_details_1']['no_of_items']}}
                                        </em>
                                      </label>
                                    </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                        </div>  
                      </div> 
                    </div>
                </div>
                      <div class="tableName_list">
                        <ul>
                          <li v-for="(val,index) in pricingDetails.price_chart" :key="index">
                            <div class="tableName_list_info row_settingPricwe">
                              <div class="tableName_list_text">
                                <strong>{{val.major_item}}</strong>
                              </div>
                                <div class="shank_tittle_head fieldIcon text-right" v-if="enable_edit">
                                  <input type="text" class="round-border form-control mr-2" v-model="updated_total_per_index"/>
                                  <b-icon icon="server" class="text-danger" aria-hidden="true" font-scale="1" @click="updateItemHistoryDetails(val.id,val.is_actual)"></b-icon>
                                </div>
                                <div class="tableName_textFr">
                                  <small v-if="val && !enable_edit">${{val.total}}</small>
                                  <small v-if="(val == undefined || val == null)">No</small>
                                  <div class="editDelete">
                                    <span class="table_arrow p-0 m-0">
                                      <!-- <b-icon v-if="val.is_actual" icon="arrow-clockwise" class="text-danger" aria-hidden="true"></b-icon> -->
                                      <!-- <b-icon  icon="bookmark-check-fill" class="text-danger" aria-hidden="true" font-scale="1"></b-icon> -->
                                      <b-icon v-b-toggle="'collapse-pricechart-'+index" icon="eye-fill" class="text-warning" aria-hidden="true" @click="seen = !seen;"></b-icon>
                                      <!-- <b-icon icon="pencil-square" aria-hidden="true" class="mr-3"  
                                      @click="setNewTotal(val);" ></b-icon>  -->
                                      <b-icon icon="trash-fill" class="text-danger" aria-hidden="true" v-if="!(val.is_actual)"></b-icon>
                                    </span>
                                  </div>
                                </div>
                          </div>
                          <div class="showCollapseDate">
                            <b-collapse :id="'collapse-pricechart-'+index" class="mt-2 showCollapseDateList pickList_outer"> 
                              <div class="pickList_info">
                                    <!-- <div class="col_list" v-for="(detail_val,detail_index) in val" :key="detail_index"> --->
                                      <table class="table">
                                      <thead>
                                        <tr class="text-warning">
                                          <th scope="col">#</th>
                                          <th scope="col">Geller SKU</th>
                                          <th scope="col">Non-Rush/Rush</th>
                                          <th v-if="val.vendor_cost" scope="col">Vendor Cost</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr class="text-white">
                                          <th scope="row">1</th>
                                          <td><b>{{val.geller_sku}}</b></td>
                                          <td v-if="val.is_rush"><b>Rush Service</b></td>
                                          <td v-else><b>Non-Rush</b></td>
                                          <td v-if="val.vendor_cost">{{val.vendor_cost}}</td>
                                        </tr>
                                        
                                      </tbody>
                                    </table><!-- </div>  -->
                              </div>
                                </b-collapse>
                                <!-- <h4 style="text-align:right"><b-icon icon="arrow-clockwise" class="text-danger mt-3" aria-hidden="true" font-scale="1.5" @click="resetDetails(val.id)"></b-icon></h4> -->
                          </div>
                           
                            
                          </li>
                        </ul>
                        
                      </div>

                    </div>
                 
              </b-tab>

              <!-- <b-tab title="Specification">
                <div class="row"> 
                  <div class="col-lg-12 text-left">
                    <div  v-for="(specs,index) in $store.state.dataStore.selections" :key="index">
                      <h4 class="text-success">Chapter {{
                          index.split('_')
                          .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                          .join(' ') 
                        }} Selections
                      </h4>

                    <div class="item_info specs_list2">
                      <ul >
                        <li v-for="(specs_item,index_specs) in specs" :key="index_specs">
                          <div style="display:block"
                            class="
                              item_info_detail
                            "
                          >
                            <h6>{{
                                index_specs.split('_')
                                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ') 
                              }}
                            </h6>                   
                            <ul>
                              <li v-for="(specification,spec_item_index) in specs_item['options']" :key="spec_item_index">
                                 <div class="innerData_text">
                                  <span>
                                  {{spec_item_index.split('_')
                                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ') }}
                                </span>
                                  <strong>{{specification}}</strong>
                                </div>  
                              </li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>                       
                    </div>
                  </div>
                   
                </div>
              </b-tab> -->
              <b-tab title="Estimation Details" active v-if="(set_estimate_only) && $store.state.dataStore.is_estimated_set">
                <div class="row">
                  <div class="col-lg-12 d-none" v-if="1 == 0">
                    <h4 class="pb-2 text-capitalize text-center">{{ subHeading }}</h4>
                    <div class="calculation_table pb-3">
                      <table class="table">
                        <thead class="">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Total Retail</th>
                            <th scope="col">Sales Tax</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>${{ pricingDetails.grand_total }}</td>
                            <td>${{ pricingDetails.sales_tax }}</td>
                            <td>${{ pricingDetails.total_with_sales_tax}}</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div >
                      <h4 class="text-capitalize pt-3">{{ subHeading4 }}</h4>
                      <div class="row pt-4 pb-md-4">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                          <div class="myForn">
                            <ul class="list-unstyled">
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="number"
                                  class="round-border p-3"
                                  placeholder="Other Cost"
                                  v-model="other_cost"
                                  name="text"
                                ></b-form-input>
                                </div>
                              </li>
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="number"
                                  class="round-border p-3"
                                  placeholder="Other Retail"
                                  name="text"
                                  v-model="other_retail"
                                ></b-form-input>
                                </div>
                              </li>
                              <li class="pb-3">
                                <div class="form-group">
                                <b-form-input
                                  type="text"
                                  class="round-border p-3"
                                  placeholder="Note (optional)"
                                  name="text"
                                  v-model="other_note"
                                ></b-form-input>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="text-center pb-4">
                            <default-button
                              variant="warning"
                              text="Adjust Amount"
                              @onSubmit="addOtherAmount()"
                            />
                          </div>
                        </div>
                        <div class="col-lg-2">
                        </div>
                      </div>
                    </div>

                  </div>
                   

                  <div class="col-lg-12" >
                       <!-- <div class="text-right">
                        <b-icon icon="arrow-repeat" class="text-warning" font-scale="2" aria-hidden="true" @click="reviewFlowOptions()"></b-icon>
                      </div>  -->
                    <div class="tableName ">
                      <div class="aa " v-for="(specs1,index) in $store.state.dataStore.selections" :key="index">
                        <strong class="text-left pb-3" v-if="index == $store.state.dataStore.main_chapter">
                          Chapter {{index}}
                        </strong>
                        <div class="item_info specs_list2 mb-4">
                            <div v-for="(specs_item1,index_specs) in specs1" :key="index_specs">
                              <div style="display:block"
                                class="
                                  item_info_detail p-0 pt-3
                                "
                              >
                              <div class="maincalc">
                                  <div class="" v-for="(specification,spec_item_index) in specs_item1['options']" :key="spec_item_index">
                                    <div class="innerData_text" v-if="spec_item_index !== 'popup' && spec_item_index !== 'complication_surcharge_selected'">
                                      <label v-if="spec_item_index == 'no_of_price_criteria_item' && 
                                      typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== '' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== 'N/A' &&
                                      '700' in $store.state.dataStore.extra_work_details && 
                                      'flow_details' in $store.state.dataStore.extra_work_details['700'] && 
                                      $store.state.dataStore.extra_work_details['700']['flow_details']['procedure_details_1']['no_of_items']">
                                       <em>
                                        No. of stones - {{$store.state.dataStore.extra_work_details['700']['flow_details']['procedure_details_1']['no_of_items']}}
                                       </em>
                                        </label>  
                                        <label v-else>
                                           <em v-if="spec_item_index !== 'no_of_price_criteria_item' && spec_item_index !== 'require_weight_popup'
                                           ">
                                          {{
                                              spec_item_index.split('_')
                                              .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                              .join(' ')
                                            }}
                                          </em>

                                         <em v-if="spec_item_index == 'require_weight_popup'">
                                            Weight (DWT)
                                        </em>

                                        <em v-if="spec_item_index == 'no_of_price_criteria_item' && 
                                        typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== '' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== 'N/A'">
                                        No of {{$store.state.dataStore.price_criteria_item_name[0]}}s
                                        </em> 
                                        
                                        <span v-if="spec_item_index == 'no_of_price_criteria_item' && 
                                        typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== '' && 
                                        $store.state.dataStore.price_criteria_item_name[0] !== 'N/A'"> - {{specification}},
                                        </span>
                                        <span v-else-if="spec_item_index !== 'no_of_price_criteria_item'">
                                           - {{specification}}
                                        </span>
                                        </label>
                                    </div>  
                                    <div  class=" text-left" v-else-if="spec_item_index == 'complication_surcharge_selected'">
                                      <label>
                                        with following services
                                        <ul>
                                          <li v-for="(extra_charges_index,extra_charge) in $store.state.dataStore.complication_surcharges" :key="extra_charge">
                                            <span v-if="extra_charges_index">{{extra_charge}}</span>
                                          </li>
                                        </ul>
                                      </label>
                                    </div>  
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>  
                      </div>   

                        <div class="item_info specs_list2 my_specs mb-4">
                            <div v-for="(specs_item1,index_specs) in $store.state.dataStore.estimateTheProduct" :key="index_specs">
                            <span class="text-warning">
                              {{index_specs}}
                            </span>   : {{specs_item1}}
                            </div>
                        </div>  

                    </div>
                </div>
                      <div class="tableName_list">
                        <ul>
                          <li v-for="(val,index) in pricingDetails.price_chart" :key="index">
                            <div class="tableName_list_info row_settingPricwe">
                              <div class="tableName_list_text">
                                <strong>{{val.major_item}}</strong>
                              </div>
                                <div class="shank_tittle_head fieldIcon text-right" v-if="enable_edit">
                                  <input type="text" class="round-border form-control mr-2" v-model="updated_total_per_index"/>
                                  <b-icon icon="server" class="text-danger" aria-hidden="true" font-scale="1" @click="updateItemHistoryDetails(val.id,val.is_actual)"></b-icon>
                                </div>
                                <div class="tableName_textFr">
                                  <small v-if="val && !enable_edit">${{val.total}}</small>
                                  <small v-if="(val == undefined || val == null)">No</small>
                                  <div class="editDelete">
                                    <span class="table_arrow p-0 m-0">
                                      <!-- <b-icon v-if="val.is_actual" icon="arrow-clockwise" class="text-danger" aria-hidden="true"></b-icon> -->
                                      <!-- <b-icon  icon="bookmark-check-fill" class="text-danger" aria-hidden="true" font-scale="1"></b-icon> -->
                                      <b-icon v-b-toggle="'collapse-pricechart-'+index" icon="eye-fill" class="text-warning" aria-hidden="true" @click="seen = !seen;"></b-icon>
                                      <!-- <b-icon icon="pencil-square" aria-hidden="true" class="mr-3"  
                                      @click="setNewTotal(val);" ></b-icon>  -->
                                      <b-icon icon="trash-fill" class="text-danger" aria-hidden="true" v-if="!(val.is_actual)"></b-icon>
                                    </span>
                                  </div>
                                </div>
                          </div>
                          <div class="showCollapseDate">
                            <b-collapse :id="'collapse-pricechart-'+index" class="mt-2 showCollapseDateList pickList_outer"> 
                              <div class="pickList_info">
                                    <!-- <div class="col_list" v-for="(detail_val,detail_index) in val" :key="detail_index"> --->
                                      <table class="table">
                                      <thead>
                                        <tr class="text-warning">
                                          <th scope="col">#</th>
                                          <th scope="col">Geller SKU</th>
                                          <th scope="col">Non-Rush/Rush</th>
                                          <th v-if="val.vendor_cost" scope="col">Vendor Cost</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr class="text-white">
                                          <th scope="row">1</th>
                                          <td><b>{{val.geller_sku}}</b></td>
                                          <td v-if="val.is_rush"><b>Rush Service</b></td>
                                          <td v-else><b>Non-Rush</b></td>
                                          <td v-if="val.vendor_cost">{{val.vendor_cost}}</td>
                                        </tr>
                                        
                                      </tbody>
                                    </table><!-- </div>  -->
                              </div>
                                </b-collapse>
                                <!-- <h4 style="text-align:right"><b-icon icon="arrow-clockwise" class="text-danger mt-3" aria-hidden="true" font-scale="1.5" @click="resetDetails(val.id)"></b-icon></h4> -->
                          </div>
                           
                            
                          </li>
                        </ul>
                        
                      </div>

                    </div>
                 
              </b-tab>

              <b-tab title="Description ">
                <div class="row">
                  <!-- <div class="col-lg-2"></div> -->

                  <!-- <div class="col-lg-12 text-left"  v-if="description.item_description"> -->
                  <div class="col-lg-12 text-left" >
                   <div class="">
                      <!-- <ul class="list-unstyled d-flex"> -->
                        <!--                     
                          <span style="margin-right: 10px;" v-if="description.item_description && description.item_description !== 'null'">
                            <span class="text-warning">{{description.item_description}} </span>
                          </span>
                          <span style="margin-right: 10px;" class="ml-1" v-if="description.stones_quality_description && description.stones_quality_description !== 'null'">
                            ,<span class="ml-1">{{description.stones_quality_description}} </span>
                          </span>
                          <span style="margin-right: 10px;" class="ml-2" v-if="description.stones_guarrantee_description && description.stones_guarrantee_description !== 'null'">
                            ,<span class="ml-1 text-warning">{{description.stones_guarrantee_description}} </span>
                          </span>
                             
                           <span style="margin-right: 10px;" class="d-flex ml-2 mr-2 align-items-center" v-if="description.customer_stated_value && description.customer_stated_value !== 'null'">
                           having value 
                            <span class="ml-1 text-warning">${{description.customer_stated_value}}</span>
                          </span> where promise date is {{description.promise_date.slice(0, 10)}} -->
                      <ul class="list-unstyled">
                        
                        <li class="item_info" v-if="description.item_description && description.item_description !== 'null'">
                          <h6 class="upper-case text-warning">Item Description</h6>
                          <p>
                            {{description.item_description}}
                          </p>
                        </li>
                         <li class="item_info" v-if="description.customer_stated_value && description.customer_stated_value !== 'null'">
                          <h6 class="upper-case text-warning">Customer Stated Value</h6>
                          <p>
                            <span class="text-white">$ </span>{{description.customer_stated_value}}
                          </p>
                        </li>
                        <li class="item_info" v-if="description.stones_quality_description && description.stones_quality_description !== 'null'">
                          <h6 class=" text-warning"
                          >Are any stones broken, chipped, cracked or flawed? If so describe.
                            </h6>
                          <p>{{description.stones_quality_description}}</p>
                        </li> 
                        <li class="item_info" v-if="description.stones_guarrantee_description && description.stones_guarrantee_description !== 'null'">
                          <h6 class=" text-warning"
                          >Are any of these items not guranteed? please describe.
                            </h6>
                          <p>{{description.stones_guarrantee_description}}</p>
                        </li>
                        <li class="item_info round-border purpose_radios" v-if="description.is_guarranteed && description.is_guarranteed !== 'null'"> 
                          <h6 class="pb-3 pt-4 text-capitalize"> Are any of these items Not Guaranteed? </h6>
                            <div class=" text-left"> 
                                <div class=""> 
                                  <b-form-group v-slot="{ ariaDescribedby }">
                                  <b-form-radio-group v-model="description.is_guarranteed" 
                                  :options="radio_options" :aria-describedby="ariaDescribedby" 
                                  name="radio-stacked" stacked ></b-form-radio-group>
                                  </b-form-group>
                              </div> 
                            </div> 
                          </li> 
                          <li class="pb-5 sett_calender" v-if="description.promise_date && description.promise_date !== 'null'">
                            <h6 class="text-left pb-2">
                                Promise Date
                            </h6>
                            <b-form-datepicker
                              id="example-datepicker"
                              v-model="description.promise_date"
                              :readonly="true"
                            ></b-form-datepicker>
                        </li>
                        </ul>
                      </div>
                    </div>
                  <!-- <div class="col-lg-12" v-else>
                    <div class=" info-div ">
                        <div>
                        <div  class="my-auto">
                            <b-icon icon="info-circle-fill" variant="light"></b-icon>
                        </div>
                        <small>
                            <b>No description exists for this item.</b>
                        </small>
                        </div>
                    </div>
                  </div> -->
                  
                  <!-- <div class="col-lg-2"></div> -->
                </div>
              </b-tab>

              <b-tab title="PickList Items">
                <div class="row mb-5" v-if="'price_chart' in pricingDetails && 0 in pricingDetails['price_chart']">
                  <div class="col-lg-12">
                    <div class="calculation_table pb-3 " v-if="pricingDetails.price_chart[0].pick_list && pricingDetails.price_chart[0].pick_list.name">
                      <table class="table" :set="picklist = pricingDetails.price_chart[0].pick_list">
                        <thead class="">
                          <tr>
                            <th class = "text-warning" scope="col">#</th>
                            <th class = "text-warning" scope="col">Name</th>
                            <th class = "text-warning" scope="col">Stuller SKU</th>
                            <th class = "text-warning" scope="col">Quantity</th>
                            <th class = "text-warning" scope="col">Price</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr
                          >
                            <td>{{ 1 }}</td>
                            <td>{{ picklist.name }}</td>
                            <td>{{ picklist.stuller_sku }}</td>
                            <td>{{ picklist.quantity }}</td>
                            <td>$ {{ picklist.total }}</td>
                          </tr>
                          <!-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td><strong>{{picklist.total}}</strong></td>
                          </tr> -->
                        </tbody>
                      </table>
                    </div>
                    <div class="container info-div mt-5" :class="$mq" v-else>
                        <div>
                        <div  class="my-auto mr-3">
                            <b-icon icon="info-circle-fill" variant="light"></b-icon>
                        </div>
                        <small>
                            <b>No Picklist Exists for this item</b>
                        </small>
                        </div>
                    </div>
                  </div>
                </div>
              </b-tab>



            </b-tabs>
          </div>
        </div>
      </div>
    </div>




<!-- adjust amout popup  -->
<div class="myModel">
      <div>
        <b-modal id="" header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"   header-bg-variant="primary"   footer-bg-variant="primary" centered title="Want Respective Item" >
        <p>Want respective  along with it</p>
          <template >
            <!-- Emulate built in modal footer ok and cancel button actions -->
            <b-button class="btn round-border btn-success " size="sm" variant="success"  >
              Yes
            </b-button>
            <b-button class="btn round-border btn-success active_btn" size="sm" variant="success"  >
              No
            </b-button>
          </template>
        </b-modal>
      </div>
    </div>


    <!-- adjust amout popup  -->
    <div class="myModel">
      <div>
        <b-modal id="" header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary" 
          header-bg-variant="primary"   footer-bg-variant="primary" centered title="Vendors Not Available" >
        <p>Shop Does not have any record of Vendors, Please Add vendor record first.</p>
          <template>
            <!-- Emulate built in modal footer ok and cancel button actions -->
            <b-button class="btn round-border btn-success " size="sm" variant="warning" @click="AddVendor()">
              Add Vendor
            </b-button>
          </template>
        </b-modal>
      </div>
    </div>



    <div class="myModel">
      <div>
        <b-modal id="modal-center" header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"   header-bg-variant="primary"   footer-bg-variant="primary" :visible="$store.state.dataStore.ask_furthur_modal" centered title="Want Respective Item"  @hide="$store.commit('dataStore/askForFurthurSKUs', false)">
        <p>Want respective {{$store.state.dataStore.furthur_item}} along with it</p>
          <template #modal-footer>
            <!-- Emulate built in modal footer ok and cancel button actions -->
            <b-button class="btn round-border btn-success " size="sm" variant="success" @click="PermittedFurthurSKU()">
              Yes
            </b-button>
            <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="DeniedFurthurSKU()">
              No
            </b-button>
          </template>
        </b-modal>
      </div>
    </div>
  
    <div class="myModel ">
      <div class="modelsetting">
        <b-modal size="lg" id="estimated-modal" header-border-variant="secondary" 
         footer-border-variant="secondary" 
         body-bg-variant="secondary" header-bg-variant="secondary"
         footer-bg-variant="secondary" hide-footer 
         no-close-on-esc no-close-on-backdrop hide-header-close
         centered hide-header>
        <div class="estmateModel">
          <custom-alert
          :showDismissibleAlert="showDismissibleAlert"
          :msg="alertMsg"
          :variant="variant"
          />
          <h3 v-if="$store.state.dataStore.selectedChapter in $store.state.dataStore.selections && 'procedure_details_1' in $store.state.dataStore.selections[$store.state.dataStore.selectedChapter]">
          {{$store.state.dataStore.selections[$store.state.dataStore.selectedChapter]['procedure_details_1']['options']['major_item']}}</h3>
          <p v-if="set_estimate_only">The Product is Estimate Only</p>
          <p v-else>Estimate the Product</p>
          <div class="p-0 p-lg-8"> 
                      <!-- {{estimateTheProduct}} -->

              <div class="myForn">
                <ul class="list-unstyled">
                  <li class="pb-2 ">
                    <label class="round-border pointer text-left">Choose Outside Vendor <i class="text-danger">*</i></label>
                    <div class="form-group">
                      <b-dropdown id="dropdown-1" text="Choose Outside Vendor" class="">
                        <b-dropdown-item  @click="selectVendor(vendor_person)"
                        v-for="vendor_person in vendors" :key="vendor_person.id">
                        <span>{{vendor_person.text}}</span></b-dropdown-item>
                      </b-dropdown>
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.estimateTheProduct.vendor_id.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                  </li>
                  <li class="pb-2">
                    <label class="round-border pointer my_collapse">Date Sent</label> 
                    <div class="form-group">
                    <b-form-datepicker
                      id="date-picker-label"
                      v-model="$v.estimateTheProduct.date_sent.$model"
                    ></b-form-datepicker>
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.estimateTheProduct.date_sent.required"
                    >{{ $t("form.validation.required") }}
                    </div>
                  </li>

                  <li class="pb-2">
                    <label class="round-border pointer my_collapse">Date to be received</label>
                    <div class="form-group">
                      <b-form-datepicker
                      id="date-picker-label_RECEIVED"
                      v-model="$v.estimateTheProduct.date_received.$model"
                    ></b-form-datepicker>
                    </div>
                  </li>

                  <li class="pb-2">
                    <label class="round-border pointer">Estimated Price<i class="text-danger">*</i></label>
                    <div class="form-group my_date">

                      <div class="row">
                        <div class="col-lg-6 col-md-6">
                          <label for="" class="pb-1 pl-3">From:</label>
                          <div class="my_input">
                            <b>$</b>
                            <b-form-input
                            type="text"
                            class="round-border p-4"
                            placeholder="Estimated Price From"
                            name="estimated_cost_from"
                            :class="{
                              'is-invalid': $v.estimateTheProduct.estimated_cost_from.$error,
                            }"
                            v-model.trim="$v.estimateTheProduct.estimated_cost_from.$model"
                            @blur="$v.estimateTheProduct.estimated_cost_from.$touch"
                          ></b-form-input>
                          </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <label for="" class="pb-1 pl-3">To:</label>
                            <div class="my_input">
                              <b>$</b>
                              <b-form-input
                            type="text"
                            class="round-border p-4"
                            placeholder="Estimated Price To"
                            name="estimated_cost_to"
                            :class="{
                              'is-invalid': $v.estimateTheProduct.estimated_cost_to.$error
                            }"
                            v-model.trim="$v.estimateTheProduct.estimated_cost_to.$model"
                            @blur="$v.estimateTheProduct.estimated_cost_to.$touch"
                          ></b-form-input>
                            </div>
                        </div>
                      </div>                    
                    </div>
                    <div
                    class="text-danger ml-1"
                      v-if="!$v.estimateTheProduct.estimated_cost_from.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                  
                  </li>

                    <li class="pb-2">
                    <label class="round-border pointer">Work to be performed <i class="text-danger">*</i></label>
                    
                    <!-- {{$v.estimateTheProduct}} -->

                    <div class="form-group">
                      <b-form-textarea
                        class="sett_textarea round-border p-4"
                        placeholder="Add description of work to be performed"
                        name="work_to_be_performed"
                        :class="{
                          'is-invalid': $v.estimateTheProduct.work_to_be_performed.$error,
                        }"
                        v-model.trim="$v.estimateTheProduct.work_to_be_performed.$model"
                        @blur="$v.estimateTheProduct.work_to_be_performed.$touch"
                      ></b-form-textarea>
                    </div>
                    <div
                      class="text-danger ml-1"
                      v-if="!($v.estimateTheProduct.work_to_be_performed.required)"
                      >
                    <span>
                      Field is required  
                    </span>
                    </div>
                  </li>

                <li class="pb-2">
                  <label class="round-border pointer my_collapse">Has customer approved/declined</label>
                  <div class="my_collapse_bg round-border purpose_radios"> 
                    <div class="collaps_setting text-left"> 
                        <div class=""> 
                          <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio-group v-model="$v.estimateTheProduct.customer_approved_or_declined.$model" 
                            :options="approved_or_declined_options" :aria-describedby="ariaDescribedby" 
                            name="radio-stacked" stacked>
                            </b-form-radio-group>
                          </b-form-group>
                      </div> 
                    </div> 
                  </div> 
                </li>

                </ul>
              </div>
              <div class="w-100 text-center">
                <default-button
                variant="success"
                text="  Confirm  "
                class="d-inlie-block mx-auto pl-5 pt-2 pb-2 pr-5"
                @onSubmit="addEstimationDetails()"
              />   
              </div>  
          </div>
        </div>

        </b-modal>
      </div>
    </div>

  </div>
  </div>
</template>

<script>
/**
 * Vuelidate items
 */
import {
  required,
  maxLength,
  minLength,
  email,
  sameAs,
} from "vuelidate/lib/validators";
import { mapGetters, mapActions } from 'vuex';
import Loading from 'vue-loading-overlay';
export default {
   components: { 
  'loading':Loading
   },
  data() {
    return {
      selected: [], // Must be an array reference!
      subHeading: "Calculation",
      subHeading2: "All Specification",
      subHeading3: "Description of jewelry",
      subHeading4: "Adjust Amount",
      subHeading5: "PickList Items ",
      itemsText: "Are any of these items not guranteed?",
      showDismissibleAlert: false,
      variant: null,
      image: null,
      value: "",
      preview: "assets/img_icon.png",
      image: null,
      preview_list: [],
      base_path:location.origin,
      image_list: [],
      alertMsg:'',
      isLoading: false,
      fullPage: true,
      sales_tax:6.65,
      radio_options: [
      // radio    
      { text: 'Yes', value: 1 },
      { text: 'No', value: 0 },       
      ],
      approved_or_declined_options: [
        // radio
        { text: 'Approved', value: 1 },
        { text: 'Declined', value: 0 },
      ],
      estimateTheProduct:{
        id:this.$store.state.dataStore.estimateTheProduct.id,
        vendor_id:this.$store.state.dataStore.estimateTheProduct.vendor_id,
        date_sent:this.$store.state.dataStore.estimateTheProduct.date_sent,
        date_received:this.$store.state.dataStore.estimateTheProduct.date_received,
        estimated_cost_to:this.$store.state.dataStore.estimateTheProduct.estimated_cost_to,
        estimated_cost_from:this.$store.state.dataStore.estimateTheProduct.estimated_cost_from,
        retail_price:this.$store.state.dataStore.estimateTheProduct.retail_price,
        work_to_be_performed:this.$store.state.dataStore.estimateTheProduct.work_to_be_performed,
        customer_approved_or_declined:this.$store.state.dataStore.estimateTheProduct.customer_approved_or_declined,
      },      
      description:{
        item_description:this.$store.state.dataStore.descriptionOfItem.item_description,
        customer_stated_value:this.$store.state.dataStore.descriptionOfItem.customer_stated_value,
        photo:this.$store.state.dataStore.descriptionOfItem.photo,
        stones_quality_description:this.$store.state.dataStore.descriptionOfItem.stones_quality_description,
        stones_guarrantee_description:this.$store.state.dataStore.descriptionOfItem.stones_guarrantee_description,
        is_guarranteed:this.$store.state.dataStore.descriptionOfItem.is_guarranteed,
        envelope_id:this.$store.state.dataStore.descriptionOfItem.envelope_id,
        promise_date:this.$store.state.dataStore.descriptionOfItem.promise_date
      },
      preview2: "assets/img_icon.png",
      preview3: "assets/img_icon.png",
      pricingDetails:{},
      other_retail:0,
      other_cost:0,
      other_note:'',
      is_other_added:false,
      heartIcon:'suit-heart',
      vendors: [],
      set_estimate_only:false,
      price_chart:{},
      seen: false,         
      updated_total_per_index: null,
      enable_edit:false,
      actual_item:{},
      go_with_estimation:false,

    };
  },
  
  mounted() {
    this.getPrice();
  },
  validations: {
    estimateTheProduct:{
      vendor_id: {
        required,
      },
      date_sent: {
        required,
        maxLength: maxLength(100),
      },
      date_received: {
        required,
        maxLength: maxLength(100),
      },
      estimated_cost_to: {
      },
      estimated_cost_from: {
        required,
      },
      // retail_price: {
      //   maxLength: maxLength(255),
      // },
      work_to_be_performed: {
        required,
        maxLength: maxLength(250),
      },
      customer_approved_or_declined: {
        maxLength: maxLength(100),
      },
    },
  },
  methods: {
      ...mapActions('dataStore', [ 'setServiceId','confirmJob','resetCycle','setCycle',
    'incrementEnvelopeItem','addPricingDetails','askForFurthurSKUs','setEstimatedProduct',
    'setFurthurItem','addToSelections','getFlowOptions','addDescriptionDetails','setLoader'
    ]),
    AddVendor()
    {
      this.$router.push({
        name:'add-vendor'
      }).catch(()=>{});
    },
    reviewFlowOptions()
    {
      var state = this.$store.state.dataStore;
      localStorage.setItem('review_options_enabled',true);
      this.$router.push({name:"flow-option",
      query: { chapter: state.selectedChapter,procedure:state.selectedProcedure }}).catch(()=>{});
    },
    selectVendor(vendor)
    {
      this.estimateTheProduct.vendor_id = vendor.value
    },
    addEstimationDetails()
    {
      this.$v.$touch();

      if (this.$v.$invalid) 
      {

      let errorMsg = '';

      // Customer
      if(this.$v.estimateTheProduct.vendor_id.$error){
          errorMsg = 'Vendor ID';
      }
      
      if(this.$v.estimateTheProduct.date_sent.$error){
          errorMsg = errorMsg? errorMsg+', Date sent': 'Date sent';
      }
      console.log('this.$v.estimateTheProduct',this.$v.estimateTheProduct);

      if(this.$v.estimateTheProduct.date_received.$error){
          errorMsg = errorMsg? errorMsg+', Date received': 'Date received';
      } 

      if(this.$v.estimateTheProduct.estimated_cost_from.$error){
          errorMsg = errorMsg? errorMsg+', Estimated Cost From': 'Estimated Cost From';
      }

      if(this.$v.estimateTheProduct.estimated_cost_to.$error){
          errorMsg = errorMsg? errorMsg+', Estimated Cost to': 'Estimated Cost to';
      } 
 
      if(this.$v.estimateTheProduct.work_to_be_performed.$error){
          errorMsg = errorMsg? errorMsg+', Work to be performed': 'Work to be performed';
      } 

      if(this.$v.estimateTheProduct.customer_approved_or_declined.$error){
          errorMsg = errorMsg? errorMsg+', Customer Approved or not': 'Customer Approved or not';
      }

      if (errorMsg !== '') {
        this.showAlert([this.$t('form.validation.mandatoryFieldsError', {errors:errorMsg}),'danger']);
        return;
      }

      }

      axios.post
      (
      "/api/estimate-the-product",
      {


        id:this.estimateTheProduct.id,
        vendor_id:this.estimateTheProduct.vendor_id,
        service_id:this.pricingDetails.service_id,
        envelope_id:this.$store.state.dataStore.envelope_numbers[this.$store.state.dataStore.selected_envelope_number],
        date_sent:this.estimateTheProduct.date_sent,
        date_received_back_into_store:this.estimateTheProduct.date_received,
        estimated_cost_from:this.estimateTheProduct.estimated_cost_from,
        estimated_cost_to:this.estimateTheProduct.estimated_cost_to,
        retail_price:this.estimateTheProduct.retail_price,
        work_to_be_performed:this.estimateTheProduct.work_to_be_performed,
        customer_approved_or_declined:this.estimateTheProduct.customer_approved_or_declined,
        customer_number:this.$store.state.dataStore.customer_details['customer_id'],
        is_rush: this.$store.state.dataStore.is_rush,
        geller_sku:this.pricingDetails.price_chart[0].geller_sku

      },
      {}
      )
      .then(
      (response) => 
      {
        this.setLoader(false);
        if(response.data.response_header.response_code == 200 ||
            response.data.response_header.response_code == 202)
          {
            this.go_with_estimation = true;
            // response.data.data;
            this.$store.commit('dataStore/setEstimatedProduct',response.data.data);
            this.$store.commit('dataStore/setIsEstimated',true);
            // this.$store.commit('dataStore/setIsEstimated',true);
            var price =  0 ;
            price = this.estimateTheProduct.estimated_cost_from
            this.$bvModal.hide('estimated-modal');
            if(this.estimateTheProduct.estimated_cost_to)
            {
              price += this.estimateTheProduct.estimated_cost_to ;
            }
            this.pricingDetails.grand_total = price;
            this.pricingDetails.price_chart[0].total = price;
            if(response.data.response_header.response_code == 202)
            {
              this.set_estimate_only = true;
            }
          }
      })
      .catch((error) => {
        this.setLoader(false);
      });
    },
    setNewTotal(val)
    {
      this.updated_total_per_index = val.total;
      this.enable_edit = true;
    },
    togglefill()
    {
      if(this.heartIcon == "suit-heart")
      {
        axios.post
        (
        "/api/favorite-the-sku",
        {
          sku:this.pricingDetails.geller_sku
        },
        {}
        )
        .then(
        (response) => 
        {
          this.setLoader(false);
          // setting 'if_history_added' to true;
          this.heartIcon = this.heartIcon == "suit-heart-fill" ? "suit-heart" : "suit-heart-fill";
        })
        .catch((error) => {
          this.setLoader(false);
        });
      }
    },

     /**
     * alert generator
     */

    showAlert($event) {
      this.alertMsg = $event[0];
      this.variant = $event[1];
      this.showDismissibleAlert = true;
    },

    /**
     * Clear alert
     */

    clearAlert() {
      this.alertMsg = "";
      this.variant = "";
      this.showDismissibleAlert = false;
    },
    
    // PermittedFurthurSKU(){

    //   var obj = {};
    //   var current = "major_item";
    //   obj[current] = this.pricingDetails.ask_furthur;
    //   this.addToSelections(obj);
    //   this.getFlowOptions(current);
    //   this.setFurthurItem(null)
    //   this.askForFurthurSKUs(false);
    //   this.resetCycle(true);

    // },
    // DeniedFurthurSKU(){

    //   this.setFurthurItem(null)
    //   this.askForFurthurSKUs(false);

    // },
    CheckoutTheEnvelope(){
      this.$router.push({name:"receipt",
          query: { serviceId: this.pricingDetails.service_id }}).catch(()=>{});
    
      // this.$router.push({name:"receipt",
      //   query: {'service-id': this.pricingDetails.service_id}
      // }).catch(()=>{});

    },
    ContinueToAddEnvelopeItem()
    {
      this.setCycle(this.$store.state.dataStore.current_cycle + 1);
      this.resetCycle(true);
    },

      /**
       * Fetch vendors
       */

    getVendors(value) 
    {
      this.setLoader(true);
      axios.get("/api/get-vendors-of-shop").then(response=>{
        // this.isLoading = false;
        console.log(response.data);
        var vendors = response.data.data.data;  
        if(Object.keys(vendors).length >0)
        {
          for (const person of vendors)
          {
            this.vendors.push({'value': person.id, "text": person.fullname});
          }
        }
        else
        {

        }
        
        this.setLoader(false);
        console.log(this.vendors);
      });
    },

    addToEnvelope()
    {
      console.log(this.pricingDetails)
      if(this.pricingDetails.is_estimated == 1)
      {
       if(this.$store.state.dataStore.main_chapter == '1100')
       {
        this.getVendors();
       }
      //  this.$bvModal.show('estimated-modal');
      }
      else
      {
        if(!this.pricingDetails.grand_total)
        {
          this.pricingDetails.grand_total = 0;
        }
        if(!this.pricingDetails.total_with_sales_tax)
        {
          this.pricingDetails.total_with_sales_tax = 0;
        }
        axios.post(
          "/api/confirm-the-job",
          {
            
            details:this.pricingDetails,
            chapter:this.$store.state.dataStore.main_chapter,
            envelope_id:this.$store.state.dataStore.envelope_numbers[this.$store.state.dataStore.selected_envelope_number],
            customer_number:this.$store.state.dataStore.customer_details['customer_id'],

          },
          {}
        )
        .then((response) => {
          console.log('confirm job called')
          this.setLoader(false);
          var response_data = response.data.data;
          this.pricingDetails = response_data;
          this.incrementEnvelopeItem();
          var grand_total = '';
          var substringAfterTo = 0;
          var estimation = 0
          // setting 'if_history_added' to true
          if(this.$store.state.dataStore.is_estimated_set)
          {
            if(typeof this.pricingDetails.grand_total == 'string' && this.pricingDetails.grand_total.includes('to'))
            {
              const string = this.pricingDetails.grand_total;
              const regex = /^(.*?)\sto\b/;
              const match = string.match(regex);
              const regexafterto = /\bto\b\s(.*?)$/;
              const matchafterto = string.match(regexafterto);
              console.log('afterrrr to',matchafterto);
              if (matchafterto) {
                substringAfterTo = matchafterto[1];
                console.log(parseFloat(substringAfterTo.substring(1))); // Output: "B"
                
              }
              if (match) {
                const substringBeforeTo = match[1];
                grand_total = Number(substringBeforeTo) // Output: "Go from A"

              } 
              estimation = substringAfterTo - grand_total;
            }
            else {
                grand_total = Number(this.pricingDetails.grand_total);
                if(grand_total == 0)
                {
                   var price = this.$store.state.dataStore.estimateTheProduct.estimated_cost_from
                  // this.$bvModal.hide('estimated-modal');
                  if(this.$store.state.dataStore.estimateTheProduct.estimated_cost_to)
                  {
                    price += this.$store.state.dataStore.estimateTheProduct.estimated_cost_to ;
                  }
                  grand_total = price;
                  this.pricingDetails.grand_total = price;
                  
                }
            }
          }else{
            grand_total = this.pricingDetails.grand_total;
          }
         

          var temp_obj = {};
          temp_obj['geller_sku']                    = this.pricingDetails.price_chart[0].geller_sku;
          temp_obj['major_item']                    = this.pricingDetails.price_chart[0].major_item;
          temp_obj['service_id']                    = this.pricingDetails.service_id;
          temp_obj['total']                         = grand_total;
          temp_obj['customer_stated_value']         = this.description.customer_stated_value;
          temp_obj['is_guarranteed']                = this.description.is_guarranteed;
          temp_obj['item_description']              = this.description.item_description;
          temp_obj['photos']                        = this.description.photos;
          temp_obj['promise_date']                  = this.description.promise_date;
          temp_obj['stones_guarrantee_description'] = this.description.stones_guarrantee_description;
          temp_obj['stones_quality_description']    = this.description.stones_quality_description;
          temp_obj['estimation_to_add']             = estimation;
          // temp_obj['quantity']                   = this.pricingDetails.no_of_price_criteria_item;

          console.log('confirm the job');
          this.confirmJob(true);
          this.addPricingDetails(temp_obj);
          // this will be used in managing description of each item in envelope 
          this.addDescriptionDetails();
          this.is_other_added = true;

          // if(this.pricingDetails.ask_furthur){
          //   this.setFurthurItem(this.pricingDetails.ask_furthur)
          //   this.askForFurthurSKUs(true);
          // }

        }).catch((error) => {
          this.setLoader(false);
        });

      }
    },
    resetDetails(id)
    {
      this.getPrice();
    },
    updateItemHistoryDetails(id,is_actual)
    {
      // console.log('item',Object.values(this.pricingDetails.price_chart)[0]);
      // var item_exists = Object.values(this.pricingDetails.price_chart).find(object_detail => object_detail['id'] == id); 
      //Find index of specific object using findIndex method.  
      // if(is_actual)
      // {

      // }
      // else
      // {
        //Update object's name property.
        var objIndex = this.pricingDetails.price_chart.findIndex((obj => obj.id == id));
        console.log('objIndex',objIndex,this.pricingDetails,this.updated_total_per_index,);
        this.pricingDetails.price_chart[objIndex].total = this.updated_total_per_index;
        this.pricingDetails.grand_total = this.updated_total_per_index;
        this.pricingDetails.total_with_sales_tax = Number(this.updated_total_per_index) + Number(this.pricingDetails.sales_tax);

      // } 

    },
    // updateActualItemHistoryDetails()
    // {
    //   this.pricingDetails.actual_item.total = this.updated_total_per_index
    // },
    addOtherAmount(){

      this.setLoader(true);
      this.pricingDetails.other_cost   = Number(this.other_cost?(parseFloat(this.other_cost)):0);
      this.pricingDetails.other_retail = Number(this.other_retail?(parseFloat(this.other_retail)):0);
      this.pricingDetails.grand_total  = Number(this.pricingDetails.grand_total) + (this.pricingDetails.other_cost) + (this.pricingDetails.other_retail);
      this.pricingDetails.total_with_sales_tax += this.pricingDetails.other_cost + this.pricingDetails.other_retail;
      this.pricingDetails.other_note = this.other_note;
      this.other_cost = 0;
      this.other_retail = 0;
      this.is_other_added = true;
      this.setLoader(false);

      // axios.post(
      //     "/api/add-other-amount",
      //     {
      //       sku: this.pricingDetails.geller_sku,
      //       jeweler_id: this.pricingDetails.jeweler_id,
      //       service_id: this.pricingDetails.service_id,
      //       other_cost: this.other_cost,
      //       other_retail: this.other_retail,
      //       note: this.other_note
      //     },
      //     {}
      //   )
      //   .then((response) => {

      //     this.setLoader(false);
      //     console.log(response.data);
      //     var response_data = response.data.data;

      //   }).catch((error) => {
      //     this.setLoader(false);
      //   });    
    },
    getPrice() {

      console.log('get price should be called');
      var token = localStorage.getItem('token');
      if(this.$store.state.dataStore.selectedChapter in this.$store.state.dataStore.selections && 
      Object.keys(this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]).length > 0 
      && !this.$store.state.dataStore.if_history_added
      )
      {
      this.setLoader(true);
      axios.post(
          `/api/get-${this.$store.state.dataStore.main_chapter}-price`,
          {
            values: this.$store.state.dataStore.selections,
            is_rush: this.$store.state.dataStore.is_rush,
            jeweler_id: this.$store.state.dataStore.jewelerId,
            welding_technology: (this.$store.state.dataStore.selectedChapter == "1200" && 
            'major_item' in this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter] && 
            this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase() === 'broken peg in a pearl ring') ||
            this.$store.state.dataStore.selectedChapter !== "1200" ? this.$store.state.dataStore.welding_technology : null,
            complication_surcharge: this.$store.state.dataStore.selectedChapter == "1100" && 
            this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase() === 'battery'?
            this.$store.state.dataStore.complication_surcharges : null,
            is_rhodium: this.$store.state.dataStore.rhodium_plating,
            picklist:this.$store.state.dataStore.picklist,
            stone_details: this.$store.state.dataStore.stone_details,
            stone_work:this.$store.state.dataStore.stone_work,
            solder_work:this.$store.state.dataStore.solder_work,
            finishing_work:this.$store.state.dataStore.finishing_work,
            stringing_work:this.$store.state.dataStore.stringing_work,
            question:this.$store.state.dataStore.question,
            quantity:this.$store.state.dataStore.quantity,
            // performed_job_description:this.$store.state.dataStore.performed_job_description,
            // price_criteria_item:this.$store.state.dataStore.next_options[this.$store.state.dataStore]price_criteria_item
            interlink_quantities:this.$store.state.dataStore.interlink_quantities,
            two_tone_karats: this.$store.state.dataStore.main_chapter == "100" ? this.$store.state.dataStore.two_tone_karats : null,
            main_chapter:this.$store.state.dataStore.main_chapter,
            sale_person_id:this.$store.state.dataStore.sale_person_id,
            extra_work_details:this.$store.state.dataStore.extra_work_details,
            part_only:this.$store.state.dataStore.part_only,
            selected_metal:this.$store.state.dataStore.chapter_1000_metal,
            check_and_tighten_enabled:this.$store.state.dataStore.enable_check_and_tighten

          },
          {
            headers: {
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => {
          this.setLoader(false);
            if(response.data.response_header.response_code == 202)
            {
              if(this.$store.state.dataStore.main_chapter == '1100')
              {
                this.getVendors();
              }
              this.set_estimate_only = true;
              if(!(this.$store.state.dataStore.is_estimated_set))
              {
                this.$bvModal.show('estimated-modal');
              }
            }
            console.log(response.data);
            var response_data = response.data.data;
            this.pricingDetails = response_data;
            this.price_chart = this.pricingDetails.price_chart;
            console.log('this.pricingDetails');
            this.actual_item = Object.values(this.pricingDetails.price_chart).find(object_detail => object_detail['is_actual'] == true); 
            console.log(this.pricingDetails,this.price_chart,this.pricingDetails.price_chart.length);
            Object.values(this.price_chart);
            if(this.pricingDetails.price_chart[0].is_estimated == '1')
            {
              console.log('estimated_from');
              let estimated_from = this.pricingDetails.grand_total;
              console.log(estimated_from);
              if(estimated_from.includes(' '))
              {
                this.estimateTheProduct.estimated_cost_from = estimated_from.split(' ')[0];
              }
              else
              {
                this.estimateTheProduct.estimated_cost_from = estimated_from;
              }
            }
            this.pricingDetails.grand_total = this.pricingDetails.grand_total.toFixed(2);
            this.pricingDetails.total_with_sales_tax = this.pricingDetails.total_with_sales_tax.toFixed(2);
            this.pricingDetails.sale_person_performed_job = this.$store.state.dataStore.performed_job_description
            this.pricingDetails.sale_person_id = this.$store.state.dataStore.sale_person_id
            this.setServiceId(this.pricingDetails.service_id);
            this.total = this.pricingDetails.total_retail + this.sales_tax;
        }).catch((error) => {
          this.setLoader(false);
        });
      } 
    },

    previewImage(event) {

      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
  },
};
</script> 

<style scoped>  
.profileInfo_pic { width: 100%;}
.profileInfo_pic span { max-width: 100px ; margin: auto; display: block; margin: 0px;}
.profileInfo_pic span img { width: 100% ; margin: auto; display: block;}


.priceDescriptio p { font-size: larger; margin-bottom: 0px;}


.specs_list ul li  { border-bottom: 1px solid #fff; padding:0px 5px 5px; margin-bottom: 12px;}

.specs_list ul li strong { text-transform: uppercase;}

.customer_id_detail hr { border-top: 1px solid #ccc;}

.calculation_info ul li { padding-bottom: 12px; text-align: left;}

.calculation_info ul li strong { text-transform: uppercase; padding-bottom: 0px; font-size: 16px; display: block;}
.calculation_info ul li b { font-weight: normal; display: block;  }

.calculation_table table tbody th , .calculation_table table tbody td  { color: #fff !important;}


.sku_icons { background: none; border: none; margin: 0px; padding: 0px; color: #ffc107 !important; font-size: 18px;}

.priceDescriptio p { font-size: medium;}

.addEnv  {color: #28a745 !important;}

.sett_textarea { min-height: 200px; resize: none;}

.evnlop_badge span { background: #28a745; color: #000;}

.calculation_table  { overflow: auto;}

 #estimated-modal___BV_modal_outer_ {
  z-index: 1000001 !important;
}
.table_arrow svg:focus{
  outline: none;
  box-shadow: none;
}

</style>

