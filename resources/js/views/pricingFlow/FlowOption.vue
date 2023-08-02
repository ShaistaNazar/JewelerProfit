<template>
  <div class="container pb-5 " :set="current_chapter = $route.query.chapter"> 
  <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>
    <div class="envelop_container text-center">
        <div class="container">
          <!-- <h4 class="text-uppercase tittle_highlight">Chapter {{$route.query.chapter}}</h4> -->
          <h5 v-if="$store.state.dataStore.selectedChapter !== $store.state.dataStore.main_chapter">Part Information</h5> 
          <div class="row">
            <div class="col-lg-12 p-0">
              <div class="  text-left">
                <div class="p-0 p-lg-5 mt-lg-4 m-0">

                  <div class="row pb-3">
                    <div class="col-lg-3 text-left">
                      <b-button class="round-border backBtn" @click="$router.go(-1)">
                          <b-icon icon='chevron-left' aria-hidden="true"></b-icon>
                      </b-button>
                    </div>
                  </div>
                  
                  <div v-for="(option,index) in selections" :key="index">
                    <!-- {{option}} -->
                    <div class="my_collapse_bg round-border mb-3" v-if="option && index != 'price_criteria_item' && index != 'require_weight_popup'
                      && index != 'interlinked_option' && index != 'question' && index != 'dependent_chapter'  && index != 'ring_size'">
                      <div class="custom-collapse">
                        <label class="round-border pointer my_collapse"
                            v-b-toggle="'collapse-'+index">
                            <span class="flex-grow-1">
                              <span v-if="index">
                                {{
                                index.split('_')
                                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ')
                                }}
                              </span>
                              <!-- <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon> -->
                            </span>
                            
                            <a class="text-warning mr-3 text-lowercase" href="#" 
                            v-if="$store.state.dataStore.selections[$route.query.chapter] && 
                            $store.state.dataStore.selections[$route.query.chapter]['procedure_details_'+$route.query.procedure] &&
                            $store.state.dataStore.selections[$route.query.chapter]['procedure_details_'+$route.query.procedure]['options'] &&
                            !(current_chapter == '100' && 
                              $store.state.dataStore.selections[current_chapter] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'].toLowerCase().includes(('two tone')) && index == 'karats')
                            
                            ">
                            {{$store.state.dataStore.selections[$route.query.chapter]['procedure_details_'+$route.query.procedure]['options'][index]}}</a>
                            
                            <a class="text-warning mr-3 text-lowercase" href="#" 
                            v-if="current_chapter == '100' && 
                              $store.state.dataStore.selections[current_chapter] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'].toLowerCase().includes(('two tone')) && index == 'karats'">
                            <span v-for="(karat,karat_ind) in Object.keys(two_tone_karats)" :key="karat">{{karat}} <span class="text-white" 
                            v-if="(karat_ind + 1) < Object.keys(two_tone_karats).length">/</span></span></a>

                            <a class="text-warning mr-3 text-lowercase" href="#" 
                            v-if="current_chapter == '1100' && 
                              $store.state.dataStore.selections[current_chapter] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['complication_surcharge_selected'] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['complication_surcharge_selected'] == true
                              && index == 'complication_surcharge'">
                            
                            <span v-for="(complication_surcharge_index,complication_surcharge) in Object.keys(complication_surcharges)" :key="complication_surcharge">
                              <span v-if="complication_surcharges[complication_surcharge_index]">
                                <span v-if="complication_surcharge !== 0">
                                /
                              </span>
                              <span>
                                {{complication_surcharge_index}}
                              </span>
                            </span>
                            </span>
                            </a>
                            
                            <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                          </label>

                          <b-collapse :id ="'collapse-'+index" class="" 
                          :visible="($store.state.dataStore.main_chapter == $store.state.dataStore.selectedChapter) ? 
                          ($store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] ==  index) : 
                          ($store.state.dataStore.secondaryChapterFlow[$store.state.dataStore.secondarySelectedFlow] ==  index)">
                          <div class="vld-parent" v-show="checkIfNotSelected(index)">
                            <loading :active.sync="$store.state.dataStore.isLoading" background-color="#202962" :is-full-page="false" loader="dots" color="#36a142"></loading>
                          </div>
                          <div v-if="index == 'welding_technology' && current_chapter == '900' && current_chapter in $store.state.dataStore.enable_welding_technology && $store.state.dataStore.enable_welding_technology[current_chapter] && 
                                     $store.state.dataStore.enable_welding_technology[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]">
                                 
                                 
                                    <div class="mb-3 bg-lightblue no-border text-left d-inline-flex align-items-center 
                                    justify-content-center flex-nowrap px-4">
                                          <div  class="my-auto mr-3 pt-1">
                                              <h5><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                                          </div>
                                          <span class="text-warning">
                                              {{weldingNote}}
                                          </span>     
                                      </div>
                                      <div class="item_select">
                                        <ul>
                                            <li>
                                              <button class="btn"
                                                :class="$store.state.dataStore.selections[current_chapter]['procedure_details_'+$route.query.procedure]['options']['welding_technology'] !== 'laser' ? 'btn-success': 'btn-primary'"
                                                @click="chooseTechnology('torch')">
                                                Torch
                                              </button>
                                            </li>
                                            <li>
                                              <button class="btn" :disabled="$store.state.dataStore.shop.have_laser == 0"
                                                :class="$store.state.dataStore.selections[current_chapter]['procedure_details_'+$route.query.procedure]['options']['welding_technology'] == 'laser' ? 'btn-success': 'btn-primary'"
                                                @click="chooseTechnology('laser')">
                                                Laser
                                              </button>
                                            </li>
                                        </ul>  
                                      </div>
                                    </div>


                          <div class="collaps_setting">
                            <div class="item_select">
                              <div v-if="option" :class="index != 'extra_work_per_appraisal' ? 'shrinkable': 'row'"> 
                               
                                <div v-for="(to_select,flow_option_key) in option" :key="flow_option_key" :class="index != 'extra_work_per_appraisal' ? 'flow_with_img': 'col-lg-6'" class=" d-contents">
                                  <div v-if="flow_option_key || to_select">
                                    <div class="">
                                      <!-- {{flow_option_key}} -- {{to_select}} -->
                                      <!-- <div class="text-center mb-1" 
                                         v-if="current_chapter == '1200' && index == 'add_ons'">
                                        <b-form-checkbox :id="'checkbox_'+to_select" v-model="interlink_quantities" :label="`check-box-${to_select}`" :value="to_select"></b-form-checkbox>
                                      </div>  -->
                             <div class="item_select" v-if="current_chapter == '1200' && index == 'extra_work_per_appraisal'"> 
                              <div class="row">
                                <div>
                                     <strong v-if="index" class="text-success">
                                      {{
                                      flow_option_key.split('_')
                                      .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                      .join(' ')
                                      }} Add Ons
                                    </strong>

                                    <div class="item_select_inner" v-for="(single_add_on,charm_index) in to_select" :key="charm_index">
                                      <div class="item_choose pt-4 ">
                                        <div>
                                          <b-form-checkbox :id="'checkbox_'+flow_option_key+'_'+charm_index" 
                                            v-if="$store.state.dataStore.interlink_quantities[flow_option_key]"
                                            @change ="putQuantityAgainstInterlinkItems([$event,flow_option_key,charm_index])"
                                            :checked="interlink_quantities[flow_option_key][charm_index] != false"
                                            class="no-pointer-events"
                                            >{{charm_index}}

                                          </b-form-checkbox>
                                          <div class="myForn" v-if="checkIfShouldComes(flow_option_key,charm_index)">
                                            <div class="form-group">
                                              <input type="number" class="form-control" placeholder="Specify Quantity" :value="interlink_quantities[flow_option_key][charm_index]" 
                                              @input="putQuantityAgainstInterlinkItems([Number($event.target.value),flow_option_key,charm_index])"> 
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div> 
                              </div>
                              </div>
                                <!-- 1100 with complication surcharge -->
                                <div v-else-if="index == 'complication_surcharge'">
                                  <div>

                                    <b-form-checkbox :id="'checkbox_'+flow_option_key"
                                    @change ="setComplicationSurcharge([$event,flow_option_key])"
                                    :checked="complication_surcharges[flow_option_key]"
                                    class="no-pointer-events"
                                    >{{flow_option_key}}
                                    </b-form-checkbox>
                                  
                                  </div>                                  
                                </div>
                                <!-- two tone band -->
                                <div class="my_select" v-else-if="current_chapter == '100' && 
                                  $store.state.dataStore.selections[current_chapter] && 
                                  $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] && 
                                  $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                                  $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'] && 
                                  $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'].toLowerCase().includes(('two tone')) && index == 'karats'">
                                  
                                  <b-form-checkbox :id="'checkbox_two_tone'+flow_option_key"
                                  @change ="setTwoToneKarats([$event,flow_option_key])"
                                  :checked="two_tone_karats[flow_option_key]"
                                  class="no-pointer-events"
                                  >{{flow_option_key}}
                                  </b-form-checkbox>
                                   
                                </div>
                                <!---  </div>
                                </div> -->
                                

                                <div v-else>

                                    <!-- sizing 100 -->
                                      <div v-if="index !== 'welding_technology'">
                                      <span v-if="checkIfImageExists(index)">
                                        <b-img @error="hideImage($event)" :src="'images_'+current_chapter+'/'+to_select+'.png'" alt="Jewelry Image" class="img-fluid"
                                        @click="moveToNextOption([{[index]:to_select}]);"
                                        ></b-img>
                                      </span>
                                      <button class="btn" :class="checkIfExists(to_select,index) ? 'btn-success': 'btn-primary'" @click="moveToNextOption([{[index]:to_select}]);" v-if="to_select != ''">
                                        {{to_select}}
                                      </button>
                                      </div>
                                    
                                </div>

                              </div>
                            </div>
                          </div>
                          </div>
                          <div class="text-right mr-2 mb-1">
                            <!-- as this is being captured by two_tone_karats but need to call this function to get next options -->
                              <!-- <b-icon  v-if="current_chapter == '100' && 
                                $store.state.dataStore.selections[current_chapter] && 
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] &&
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'] && 
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['type'].toLowerCase().includes(('two tone')) 
                                && index == 'karats'" @click="moveToNextOption([{'karats':undefined}]);" size="lg" class="text-success"  scale="2.75" icon="check-circle-fill" aria-label="Help" variant="warning"></b-icon> -->

                              <b-icon  v-if="current_chapter == '1100' && 
                                $store.state.dataStore.selections[current_chapter] && 
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] &&
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options'] &&
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['major_item'] && 
                                $store.state.dataStore.selections[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]['options']['major_item'].toLowerCase().includes(('battery')) 
                                && index == 'complication_surcharge'" @click="moveToNextOption([{'complication_surcharge_selected':undefined}]);" size="lg" class="text-success text-right"  scale="2.75" icon="check-circle-fill" aria-label="Help" variant="warning"></b-icon>

                          </div>
                           
                          </div>
                          <div class="w-100 text-right">
                            <button v-if="current_chapter == '1200' && $store.state.dataStore.selections[current_chapter] &&
                              $store.state.dataStore.selections[current_chapter]['procedure_details_1']['options']['major_item'] && 
                              $store.state.dataStore.selections[current_chapter]['procedure_details_1']['options']['major_item'] == 'Appraisals'
                              && index == 'extra_work_per_appraisal'" style="margin-top:2rem;" class="btn btn-primary text-right" @click="moveToNextOption([{'extra_work_per_appraisal':'Charms Listed Separately'}]);">
                              Submit Appraisals
                            </button>
                          </div>
                        </div>
                      </b-collapse>
                    </div>
                    </div>
                  <div v-if="index == 'price_criteria_item' && option[0] !== 'N/A'  && $route.query.chapter !== '700' && $route.query.chapter !== 700">
                      <div class="number_field mb-3">
                        <label class="ml-3">
                           <!-- adjust number of stones here for this chapter not related to stoe work that has its own no. of stones -->
                          <span>Choose no. of {{option[0]}}s</span>
                        </label>
                        <div class="my_collapse_bg round-border d-block m-0">
                          <b-form-input id="type_number" type="number" min="0" v-model="no_of_price_criteria_item"></b-form-input>
                        </div>
                      </div>
                  </div>
                  <!-- sizing collapses -->
                  <div class="my_collapse_bg round-border mb-3"   v-if="current_chapter == '100' && index == 'ring_size'">
                    <div class="custom-collapse" >
                        <label class="round-border pointer my_collapse"
                            v-b-toggle="'collapse-'+index">
                            <span class="flex-grow-1">
                              <span v-if="index">
                                {{
                                index.split('_')
                                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ')
                                }}
                              </span>
                              <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon>
                            </span>
                            <a class="text-warning mr-3 text-lowercase" href="#"  
                            v-if="size_now && size_to">{{size_now}} to {{size_to}}</a>
                            <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                          </label>
                          <b-collapse :id ="'collapse-'+index" class="" :visible="$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] ==  index">
                           
                          <div class="collaps_setting">
                          <div class="my_select my_collapse_bg round-border mb-3">
                            <div class="number_field mb-3">
                              <label>
                                <!-- adjust number of stones here for this chapter not related to stoe work that has its own no. of stones -->
                                <span>Choose Sizes</span>      
                              </label>
                              <div class="my_collapse_bg p-3 round-border d-block m-0">
                                <span style="font-weight:normal" class="d-block pb-2">
                                  Size Now
                                </span>
                                <b-form-select   v-model="size_now"   :options="option" class="round-border mb-2"></b-form-select>
                                <span style="font-weight:normal" class="d-block pb-2">
                                  Size To
                                </span>
                                <b-form-select   v-model="size_to"    :options="option" class="round-border"></b-form-select>
                              </div>
                            </div>
                          </div>
                    </div>
                    </b-collapse>
                    </div>
                  </div>
                  <!-- interlink -->
                  <div v-if="index == 'interlinked_option'">
                      <div class="number_field mb-3">
                        <label class="ml-3">
                          <span>Choose no. of {{option[0]}}s</span>      
                        </label>
                        <div class="my_collapse_bg round-border d-block m-0">
                          <b-form-input id="type_number" type="number" min="0" v-model="interlinked_option"
                          @blur="setInterlinkedAsPriceCriterianItem(option[0]);"
                          ></b-form-input>
                        </div>
                      </div>
                  </div>
                  <!-- interlink -->

                  <!-- interlink checkbox handling -->
                  <!-- <div class="my_collapse_bg round-border mb-3" v-if="option && index == 'add_ons'">
                    <div class="custom-collapse">
                      <label class="round-border pointer my_collapse"
                          v-b-toggle="'collapse-'+index">
                          <span class="flex-grow-1">
                            <span v-if="index">
                              {{
                              index.split('_')
                              .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                              .join(' ')
                              }}
                            </span>
                            <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon>
                          </span> -->
                          <!-- <a class="text-warning mr-3 text-lowercase" href="#" v-if="$store.state.dataStore.selections[$route.query.chapter] && 
                          $store.state.dataStore.selections[$route.query.chapter][index]">
                          {{$store.state.dataStore.selections[$route.query.chapter][index]}}</a> -->
                          <!-- <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                        </label>
                        <b-collapse :id ="'collapse-'+index" class="" :visible="$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] ==  index"> -->
                        <!-- <div class="vld-parent" v-if="checkIfNotSelected(index)"> 
                          <loading :active.sync="$store.state.dataStore.isLoading" background-color="#202962" :is-full-page="false" loader="dots" color="#36a142"></loading>
                        </div> -->
                        <!-- <div class="collaps_setting"> index:{{index}} to_select:{{to_select}}
                        <button class="btn"
                        @click="moveToNextOption
                        (index,to_select);" v-if="to_select != ''">
                          {{to_select}}
                        </button>
                        <div class="myForn" v-if="checkIfShouldComes(to_select)">
                          <div class="form-group">
                            <input type="number" class="form-control" placeholder="Specify Quantity"  @blur="putQuantityAgainstValue($event,to_select)" @keyup.enter="putQuantityAgainstValue($event,to_select)" @keyup.esc="cancelQuantityAgainstValue(to_select)"> 
                          </div>
                        </div> -->


                          <!-- <div class="item_select"> 
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="item_select_inner">
                                    <strong>CHAPTER 1000</strong>
                                    <div class="item_choose pt-4 ">
                                      <div class="checkbox_group"> 
                                       <b-form-group label="Using options array:" v-slot="{ ariaDescribedby }">
                                        <b-form-checkbox-group
                                          id="checkbox-group-1"
                                          v-model="selected"
                                          :options="options"
                                          :aria-describedby="ariaDescribedby"
                                          name="flavour-1"
                                        ></b-form-checkbox-group>
                                      </b-form-group>
                                      </div>
                                    </div>
                                  </div>
                                  <ul>
                                    <li>
                                      <button class="btn btn-success">ADD abc</button>
                                    </li> 
                                  </ul>
                              </div>
                            </div> 
                          </div> -->


                          <!-- <button v-if="current_chapter == '1200' && $store.state.dataStore.selections[current_chapter] &&
                          $store.state.dataStore.selections[current_chapter]['major_item'] && 
                          $store.state.dataStore.selections[current_chapter]['major_item'] == 'Appraisals' && index == 'type'" class="btn btn-warning" @click="moveToNextOption('type','Charms Listed Separately');">NEXT
                          </button> -->
                        <!-- </div> -->

                    <!-- </b-collapse>
                  </div>
                  </div> -->
                  <!-- interlink checkbox handling -->
                  <div v-if="index == 'question'">
                    <div class="number_field mb-3">
                      <label class="ml-3">
                        <!-- adjust number of stones here for this chapter not related to stoe work that has its own no. of stones -->
                        <span class="text-capitalize">{{option[0]}}</span>      
                      </label>
                      <div class="my_collapse_bg p-3 round-border d-block m-0">
                        <b-form-group v-slot="{ ariaDescribedby }">
                          <b-form-radio-group v-model="question" :options="radio_options" :aria-describedby="ariaDescribedby" name="radio-stacked" stacked >
                          </b-form-radio-group>
                        </b-form-group>
                      </div>
                    </div>
                  </div>
                  </div>

                  <div v-if="current_chapter in $store.state.dataStore.enable_the_quantity && $store.state.dataStore.enable_the_quantity[current_chapter]">
                    <div class="number_field mb-3">
                      <label class="ml-3"> 
                        <!-- adjust number of stones here for this chapter not related to stone work that has its own no. of stones -->
                        <span>Quantity</span>
                      </label>
                      <div class="my_collapse_bg round-border d-block m-0">
                        <b-form-input id="type_number" type="number" min="0" v-model="quantity"></b-form-input>
                      </div>
                    </div>
                  </div>
                  <!-- {{current_chapter !== '900'}} ,,
                  {{$store.state.dataStore.enable_welding_technology[current_chapter]}}..
                  {{$store.state.dataStore.enable_welding_technology[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure]}}
                  {{$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] == 'welding_technology'}}
                  {{$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] == undefined}}
                  {{$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow - 1] == 'welding_technology'}} -->
                  <!-- welding technology -->
                <div v-if=" current_chapter !== '900' && current_chapter in $store.state.dataStore.enable_welding_technology && 
                            $store.state.dataStore.enable_welding_technology[current_chapter]['procedure_details_'+$store.state.dataStore.selectedProcedure] && 
                            ((($store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] == 'welding_technology' || 
                            ($store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow] == undefined && 
                            $store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow - 1] == 'welding_technology'))))">
                <hr>
                  <div class="my_collapse_bg round-border mt-3" >
                  <div>
                    <label class="round-border pointer my_collapse"
                        v-b-toggle="'collapse-welding'"> 
                      <span>Choose welding Technology
                        <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon>
                      </span>
                        <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                    </label>
                    <b-collapse :visible="true"
                    :id ="'collapse-welding'" class="" >
                    <div class="collaps_setting pt-0">
                      <div class="mb-3 bg-lightblue no-border text-left d-inline-flex align-items-center justify-content-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                {{weldingNote}}
                             </span>     
                         </div>
                        <div class="item_select">
                          <ul>
                              <li>
                                <button class="btn"
                                  :class="$store.state.dataStore.selections[current_chapter]['procedure_details_'+$route.query.procedure]['options']['welding_technology'] !== 'laser' ? 'btn-success': 'btn-primary'"
                                  @click="chooseTechnology('torch')">
                                  Torch
                                </button>
                              </li>
                              <li>
                                <button class="btn" :disabled="$store.state.dataStore.shop.have_laser == 0"
                                  :class="$store.state.dataStore.selections[current_chapter]['procedure_details_'+$route.query.procedure]['options']['welding_technology'] == 'laser' ? 'btn-success': 'btn-primary'"
                                  @click="chooseTechnology('laser')">
                                  Laser
                                </button>
                              </li>
                          </ul>  
                        </div>
                    </div>
                  </b-collapse>
                  </div>
                  </div>

                
                </div>
                <div v-if="typeof $store.state.dataStore.price_criteria_item_name == 'object' && 
                                  $store.state.dataStore.price_criteria_item_name[0] !== '' &&
                                  $store.state.dataStore.price_criteria_item_name[0] !== 'N/A' &&
                                  $store.state.dataStore.stone_stringing_soldering_handled && 700 in $store.state.dataStore.extra_work_details ">
                  <hr>
                  <div class="my_collapse_bg round-border mt-3" >
                   <div>

                    <label class="round-border pointer my_collapse"
                        v-b-toggle="'collapse-welding'"> 
                        <span>
                          Stone Details overview
                          <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon>
                        </span>
                        <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                    </label>
                    
                    <b-collapse
                    :id ="'collapse-welding'" class="" :visible="$store.state.dataStore.stone_stringing_soldering_handled">
                    <div class="collaps_setting pt-0">
                        <div class="w-100 mb-3 ml-3 bg-lightblue no-border text-left d-inline-flex align-items-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5 class="mb-0"><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                Number of stones : 
                                <strong>
                                  {{$store.state.dataStore.extra_work_details[$store.state.dataStore.stone_chapter[0]].flow_details['procedure_details_1']['no_of_items']}}
                                </strong>
                             </span>
                             <div class="ml-4" @click="$store.commit('dataStore/enableAskStoneDetailsPopup', true);$store.commit('dataStore/stoneStringingSolderingHandled',false)">
                                <b-icon icon="pencil-fill" aria-hidden="true" ></b-icon>
                             </div>
                        </div>

                        <div class="w-100 mb-3 ml-3 bg-lightblue no-border text-left d-inline-flex align-items-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5 class="mb-0"><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                discount on lower value colored stones is : 
                                <strong v-if="$store.state.dataStore.extra_work_details[$store.state.dataStore.stone_chapter[0]].flow_details['procedure_details_1']['lower_value_colored_stone']">
                                  Enabled
                                </strong>
                                <strong v-else>
                                  Not enabled
                                </strong>
                             </span>     
                        </div>

                    </div>
                  </b-collapse>
                  </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
          <b-form-group v-if="show_check_and_tighten_option && $store.state.dataStore.selectedFlow >= Object.keys($store.state.dataStore.chapterFlow).length">
            <b-form-checkbox v-model="enable_check_and_tighten">Include charges for Check & Tighten the stones </b-form-checkbox>
          </b-form-group>

          <div class="main_button">
            <button v-if="$store.state.dataStore.chapterFlow[$store.state.dataStore.selectedFlow + 1] == undefined"
              @click="moveToNextOption()" class="btn round-border shadow-lg btn-warning">
              Confirm 
            </button>
          </div>
      </div>
    </div> 
    <!-- picklist -->
    <div class="myModel">
        <div>
          <b-modal id="modal-center" header-border-variant="primary" footer-border-variant="primary" 
          body-bg-variant="primary"  header-bg-variant="primary" footer-bg-variant="primary" no-close-on-esc no-close-on-backdrop hide-header-close
          :visible="showModal" centered title="Order Picklist" @hide="$store.commit('dataStore/setpicklistmodal', false)">
          <p>Do you want to add this to stuller order picklist?</p>
            <template #modal-footer>
              <!-- Emulate built in modal footer ok and cancel button actions -->
              <b-button class="btn round-border btn-success" size="sm" variant="success" @click="ok()">
                Yes
              </b-button>
              <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="cancel()">
                No
              </b-button>
            </template>
          </b-modal>
        </div>
    </div>    

    <!-- require metal popup -->
    <div class="myModel" v-if="$store.state.dataStore.enable_require_metal_popup">
      <div>
        <b-modal id="modal-center" header-border-variant="primary" footer-border-variant="primary" 
        body-bg-variant="primary" header-bg-variant="primary" footer-bg-variant="primary" no-close-on-esc no-close-on-backdrop hide-header-close
        :visible="$store.state.dataStore.enable_require_metal_popup" centered title="Charge for Metal">
        <p>Labor does not include metal, would you like to charge for metal now? (store will know weight)?</p>
          <template #modal-footer>
            <!-- Emulate built in modal footer ok and cancel button actions -->
            <b-button class="btn round-border btn-success" size="sm" variant="success" @click="moveToNextOption(([{'popup':true}]))">
              Yes
            </b-button>
            <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="moveToNextOption(([{'popup':false}]))">
              No
            </b-button>
          </template>
        </b-modal>
      </div>
    </div>
 
    <!-- require weight popup -->
      <div class="myModel" v-if="$store.state.dataStore.enable_require_weight_popup">
      <div class="modelsetting">
        <b-modal size="lg" id="estimated-modal" header-border-variant="primary" 
         footer-border-variant="primary" 
         body-bg-variant="primary" header-bg-variant="primary"
         footer-bg-variant="primary" hide-footer 
         no-close-on-esc no-close-on-backdrop hide-header-close
         :visible="$store.state.dataStore.enable_require_weight_popup" centered title="Weight for Metal"
         hide-header>
        <div class="estmateModel p-3 text-center">
          <h3>{{$store.state.dataStore.selections[$store.state.dataStore.selectedChapter]
          ['procedure_details_1']['options']['major_item']}}</h3>
         
          <p>Please provide information about weight</p>
          <div class="p-0 p-lg-8">
              <div class="myForn">
                <ul class="list-unstyled">
                  <li class="pb-2">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-lg-12">
                          <h4></h4>
                          <div class="shrinkable newPopup">
                            <button class="btn btn-primary" v-for="(metal_karat,index) in $store.state.dataStore.metals" :key="index" @click="chooseMetal(metal_karat)">
                              {{metal_karat}}
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="row" v-if="chapter1000Item.show_weight_input">
                        <div class="col-lg-3 col-md-3"></div>
                        <div class="col-lg-6 col-md-6">
                          <b-form-input
                          type="number"
                          class="round-border p-4"
                          placeholder="Weight (grams)"
                          name="weight"
                          :class="{
                            'is-invalid': $v.chapter1000Item.weight,
                          }"
                          v-model.trim="$v.chapter1000Item.weight.$model"
                          @blur="$v.chapter1000Item.weight.$touch"
                        ></b-form-input>
                        </div>
                        <div class="col-lg-3 col-md-3"></div>
                      </div>
                    </div>
                    <div
                      class="invalid-feedback"
                      v-if="!$v.chapter1000Item.weight.required"
                    >
                      {{ $t("form.validation.required") }}
                    </div>
                  </li>
                </ul>
              </div>
              <default-button
                variant="success"
                text="  Confirm  "
                class="d-inlie-block pl-5 pt-2 pb-2 pr-5"
                @onSubmit="addWeightDetails"
              />   
          </div>
        </div>
        </b-modal>
      </div>
    </div>

    <!-- stone details -->
     <div class="myModel" v-if="this.$store.state.dataStore.enable_ask_stone_details_popup && !(this.$store.state.dataStore.stone_stringing_soldering_handled)">
        <div>
          <b-modal id="modal-center" header-border-variant="primary" footer-border-variant="primary"  hide-footer
          body-bg-variant="primary" header-bg-variant="primary" footer-bg-variant="primary" no-close-on-esc no-close-on-backdrop hide-header-close
          :visible="this.$store.state.dataStore.enable_ask_stone_details_popup && !(this.$store.state.dataStore.stone_stringing_soldering_handled)" centered title="Stone Details">
            <stone-and-soldering-details/>
          </b-modal>
        </div>
    </div>
  <div class="myModel" v-if="showModalRhodiumPlating">
    <div>
      <b-modal id="modal-center" no-close-on-esc no-close-on-backdrop hide-header-close  
          header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"
          header-bg-variant="primary" footer-bg-variant="primary" :visible="showModalRhodiumPlating" centered title="Rhodiuum Plate"
          @hide="$store.commit('dataStore/setpicklistmodal', false)">
          <p>White gold items after being polished are typically get Rhodium plated. Shall we Rhodium plate the item?</p>
        <template #modal-footer>
          <div class="text-center">
            <!-- Emulate built in modal footer ok and cancel button actions -->
            <b-button class="btn round-border btn-success " size="sm" variant="success" @click="rhodiumPlate1()">
              Yes
            </b-button>
            <b-button class="btn round-border btn-primary active_btn" size="sm" variant="success" @click="cancelRhodiumPlate1()">
              No
            </b-button>
          </div>
        </template>
      </b-modal>
    </div>
  </div>
  <div class="myModel">
  <div>
  <b-modal
    id="does-not-have-laser"
    size="lg"
    hide-footer
    hide-header
    body-bg-variant="primary"
  >
    <div class="">
      <div class="add_model_bg">
        <div class="row p-3">
          <div class="col-lg-2"></div>
          <div class="col-lg-8 p3">
            <div class="text-center py-3">
              <h4 class="pb-5">Your store doesnt have Laser , do you want to exit job?</h4>
              <div class="pt-2">
                <b-button class="btn round-border btn-success mx-1" size="" variant="success">
                  Yes
                </b-button>
                <b-button class="btn round-border btn-success mx-1" size="" variant="success">
                  No
                </b-button>
              </div>
            </div>
          </div>
          <div class="col-lg-2"></div>
        </div>
      </div>
    </div>
  </b-modal>
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

import SideBar from '../../layout/SideBar.vue';
import StoneAndSolderingDetails from '../pricingFlow/Chapter700/StoneAndSolderingDetails.vue';
import { mapGetters, mapActions } from 'vuex'; 
import Loading from 'vue-loading-overlay';
import Button from '../../components/Global/Button.vue';

export default {
  components: {
    'side-bar': SideBar,
    'loading':Loading,
    'stone-and-soldering-details':StoneAndSolderingDetails,
    Button,
   }, 
    data() {
      return {
        
        selected: [], // Must be an array reference!   
        disabledLink:true,
        subHeading:"Item Name",
        isShow: true,  
        showCollapse:true,
        value:false,
        visible: true,
        status: 'not_accepted',
        selections:(this.$route.query.chapter in this.$store.state.dataStore.next_options) ? this.$store.state.dataStore.next_options[this.$route.query.chapter]['procedure_details_'+this.$route.query.procedure] : null,
        chapter1000Item:{ 
          weight:'procedure_details_1' in this.$store.state.dataStore.selections && 'require_weight_popup' in this.$store.state.dataStore.selections['procedure_details_1']['options'] && 
          this.$store.state.dataStore.selections['procedure_details_1']['options']['require_weight_popup'] ? 
          this.$store.state.dataStore.selections['procedure_details_1']['options']['require_weight_popup'] : 1,
          show_weight_input:false,
        },
        weldingNote:"Laser charges are 50% higher",
        radio_options: [
          { text: "Yes", value: 1 },
          { text: "No", value: 0 },
        ],
        selected: [], // Must be an array reference!
        image_requiring_chapters:[],
        appraisal_details:{},
        selected_to:null,
        show_check_and_tighten_option:false,
        selected_from:null,
        showDismissibleAlert: false,
        alertMsg:'',
        showCheckAndTightenModalVisible:false,
        showCheckAndTightenModal:this.$store.state.dataStore.enable_check_and_tighten,
        showModalMetalPopup:this.$store.state.dataStore.enable_require_metal_popup,
        showModalStoneDetails:(this.$store.state.dataStore.enable_ask_stone_details_popup) && (!this.$store.state.dataStore.stone_stringing_soldering_handled)
      
      }
    },
    computed: {
      // mix the getters into computed with object spread operator
      enable_check_and_tighten :
      {
        get () {
          return this.$store.state.dataStore.enable_check_and_tighten
        },
        set (value) {
          this.$store.commit('dataStore/enableCheckAndTighten', value)
        }
      },
      showModal() 
      {
        return this.$store.state.dataStore.show_modal;
      },
      showModalRhodiumPlating() {
        console.log('this.$store.state.dataStore.show_modal_rhodium',this.$store.state.dataStore.show_modal_rhodium);
        if(!(this.$route.query.chapter == '100'))
         return this.$store.state.dataStore.show_modal_rhodium;
        else
         return false;
      },
      no_of_price_criteria_item: {
        get () {
          return this.$store.state.dataStore.no_of_price_criteria_item
        },
        set (value) {
          this.$store.commit('dataStore/setNoOfItems', value)
        }
      },
      interlinked_option: {
        get () {
          // this.$store.commit('dataStore/setInterlinkedOption', value)

          return this.$store.state.dataStore.interlinked_option;
        },
        set (value) {
          this.$store.commit('dataStore/setInterlinkedOption', value)
        }
      },
      interlink_quantity_for_individual_items: {
        get () {
          return this.$store.state.dataStore.interlink_quantity_for_individual_items
        },
        set (value) {
          this.$store.commit('dataStore/setInterlinkedQuantityForIndividualItems', value)
          console.log(this.$store.state.dataStore.interlink_quantity_for_individual_items)
        }
      },
      interlink_quantity_values: {
        get () {
          return this.$store.state.dataStore.interlink_quantity_values
        },
        set (value) {
          this.$store.commit('dataStore/setInterlinkedQuantityValues', value)
        }
      },
      interlink_quantities: {
        get () {
          return this.$store.state.dataStore.interlink_quantities
        },
        set (value) {
          this.$store.commit('dataStore/putQuantityAgainstInterlinkItems', value)
        }
      },
      complication_surcharges: {
        get () {
          return this.$store.state.dataStore.complication_surcharges
        },
        set (value) {
          console.log('setter value',value)
          this.$store.commit('dataStore/setComplicationSurcharge', value)
        }
      },
      two_tone_karats: {
        get () {
          return this.$store.state.dataStore.two_tone_karats
        },
        set (value) {
          console.log('setter value',value)
          this.$store.commit('dataStore/setTwoToneKarats', value)
        }
      },
      
      quantity:{
        get () {
          return this.$store.state.dataStore.quantity[this.$store.state.dataStore.selectedChapter]
        },
        set (value) {
          this.$store.commit('dataStore/setQuantity', value)
        }
      },
      question: {
        get () {
          return this.$store.state.dataStore.question
        },
        set (value) {
          this.$store.commit('dataStore/setQuestion', value)
        }
      },
      size_now: {
        get () {
          if(this.$route.query.chapter == '100')
          {
            return this.$store.state.dataStore.selections[this.$route.query.chapter]['procedure_details_'+this.$store.state.dataStore.selectedProcedure]['options']['size_now']
          }
        },
        set (value) {
          if(value != undefined)
          {
            this.$store.commit('dataStore/setSizeNow', value);
          }
        }
      },
      size_to: {
        get () {
          if(this.$route.query.chapter == '100')
          {
            return this.$store.state.dataStore.selections[this.$route.query.chapter]['procedure_details_'+this.$store.state.dataStore.selectedProcedure]['options']['size_to']
          }
        },
        set (value) {
          if(value != undefined)
          {
            this.$store.commit('dataStore/setSizeTo', value)
          }
        }
      },
    },

    watch: {
       '$route.query.chapter': {
        handler(newChapter, oldChapter) {
          if (newChapter !== oldChapter) {
            // Update the selections here based on the new chapter
            if ('procedure_details_'+this.$route.query.procedure in this.$store.state.dataStore.next_options[this.$route.query.chapter]) {
              this.selections = this.$store.state.dataStore.next_options[this.$route.query.chapter]['procedure_details_'+this.$route.query.procedure];
            }
          }
        },
        immediate: true
      },
      '$store.state.dataStore.next_options': {
        handler() {
          if('procedure_details_'+this.$route.query.procedure in this.$store.state.dataStore.next_options[this.$route.query.chapter]) {
            this.selections = this.$store.state.dataStore.next_options[this.$route.query.chapter]['procedure_details_'+this.$route.query.procedure];
            console.log('selection in watcher',this.selections);
          }
        },
        deep: true,
        immediate:true,
      },
      '$store.state.dataStore.enable_check_and_tighten'(value) 
      {
          var context = this;
          console.log('val is 1');
          if(this.$store.state.dataStore.enable_check_and_tighten)
          {
            new Promise(function(resolve, reject) {             
              context.handleStoneStringingAndSolderingWork();
              setTimeout(function() {
              resolve(true);
              return true;
              }, 500);
             
            }).then(function(result) { // (**)
              // context.showCheckAndTightenModalVisible = value;
              context.$store.commit('dataStore/enableAskStoneDetailsPopup', true);
              context.$store.commit('dataStore/stoneStringingSolderingHandled',false);
              return true;
            }).then(function(result) { // (**)
              context.$store.commit('dataStore/enableCheckAndTighten', true);
           });
        }
        else
        {
          context.$store.commit('dataStore/resetExtraWorkDetailsStructure','stone');
          context.$store.commit('dataStore/enableAskStoneDetailsPopup', false);
          context.$store.commit('dataStore/stoneStringingSolderingHandled',true);
          context.$store.commit('dataStore/enableCheckAndTighten', false);
          context.$store.commit('dataStore/removeExtraLabor');
        }
      },
      selections: {
        handler(newVal) {
          console.log(Object.keys(newVal).length);
          console.log(newVal);
          const latestSelection = Object.keys(newVal).pop();
          console.log('latestSelection',latestSelection);
          if ('interlinked_option' == latestSelection && 'interlinked_option' in newVal) {
            this.moveToNextOption([{'no_of_price_criteria_item':this.interlinked_option},{'interlinked_option':'Jewelry Piece'}]);
          }
          
          // if (interlinkedOptionExists) {

          //   this.moveToNextOption([{'no_of_price_criteria_item':this.interlinked_option},{'interlinked_option':'Jewelry Piece'}]);

          // } 
          else
          {
            
          }
          
        },
        deep: true,
      },
      // interlinked_option: function (newValue, oldValue) 
      // {
      //   console.log('interlinked_option called',newValue);
      //   if(newValue && newValue !== '')
      //   {
      //     if(Number(newValue) < Object.keys($store.state.daatStore.interlink_quantities).length)
      //     {
      //       1 < 3
            
      //     }
      //   }
      // },
      // '$store.state.dataStore.interlink_quantities': function() 
      // {
      //   // console.log(this.$store.state.dataStore.next_options);
      //   let vuex_has_property = this.$store.state.dataStore.interlink_quantities.hasOwnProperty('appraisal_1');
      //   let should_assign_to_local_variable = this.appraisal_details.hasOwnProperty('appraisal_1');
      //   console.log('should_assign_to_local_variable');
      //   console.log(should_assign_to_local_variable);
      //   if(vuex_has_property && !should_assign_to_local_variable)
      //   {
      //     this.appraisal_details = this.$store.state.dataStore.interlink_quantities;
      //   }
      //   // console.log(this.selections);
      // },
      '$store.state.dataStore.picklist_exists': function() 
      {
        console.log('hey store of picklist',this.$store.state.dataStore.picklist_exists);
        if(this.$store.state.dataStore.picklist_exists)
        {
          this['dataStore/setpicklistmodal'](true);
        }
        // this.$store.dispatch('dataStore/getFlowOptions',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow]);
      },
      // appraisal_details: function (newValue, oldValue) {
      //   console.log('new value , old value',newValue,oldValue);
      // },
      '$store.state.dataStore.does_not_have_laser_modal': function() 
      {
        // console.log(this.$store.state.dataStore.next_options);
        // if(this.$store.state.dataStore.does_not_have_laser_modal)
        // {
        //   this.$bvModal.show('does-not-have-laser');
        // }
        // console.log(this.selections);
      },
      '$store.state.dataStore.question': function() 
      {
        if(this.$store.state.dataStore.question == 1 || this.$store.state.dataStore.question == 0)
        {
           
          this.$store.dispatch('dataStore/getFlowOptions',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow]);
        }
      },
      size_now: function (newValue, oldValue) {
        console.log('size now called',newValue);
        if(newValue && newValue !== '')
        {
          if (this.size_now && this.size_to) 
          {
            if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow + 1])
            {
              this['dataStore/setSelectedFlow']().then(flow_response => {
              console.log('size_to',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow],this.$store.state.dataStore.selectedFlow);
              if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
              {
                this['dataStore/enableWeldingTechnology'](true);
              }
              });
            }
            else
            {
              if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
                this['dataStore/enableWeldingTechnology'](true);
            }
          }
        }
      },
      size_to: function (newValue, oldValue) {
        console.log('size to called',newValue);

        if(newValue && newValue !== '')
        {
          if (this.size_now && this.size_to) 
          {
            if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow + 1])
            {
              this['dataStore/setSelectedFlow']().then(flow_response => {
              console.log('size_to',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow],this.$store.state.dataStore.selectedFlow);
              if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
                this['dataStore/enableWeldingTechnology'](true);
              });
            }
            else
            {
              if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
                this['dataStore/enableWeldingTechnology'](true);
            }
          }
        }
      },
      // '$store.state.dataStore.size_now': function() 
      // {
      //   if(this.$store.state.dataStore.size_now && this.$store.state.dataStore.size_to)
      //   {
      //     if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow + 1])
      //     {
      //       this['dataStore/setSelectedFlow']().then(flow_response => {
      //       console.log('size_to',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow],this.$store.state.dataStore.selectedFlow);
      //       if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
      //         this['dataStore/enableWeldingTechnology'](true);
      //       });
      //     }
      //     else
      //     {
      //       if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
      //         this['dataStore/enableWeldingTechnology'](true);
      //     }
      //   }
      //   console.log('size_now',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow])
      // },

      // '$store.state.dataStore.size_to': function() 
      // {
      //   if(this.$store.state.dataStore.selections && this.$store.state.dataStore.size_to)
      //   {
      //     if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow + 1])
      //     {
      //       this['dataStore/setSelectedFlow']().then(flow_response => {
      //       console.log('size_to',this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow],this.$store.state.dataStore.selectedFlow);
      //       if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
      //         this['dataStore/enableWeldingTechnology'](true);
      //       });
      //     }
      //     else
      //     {
      //       // size now size to should be deleted as per 
      //       if(this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow] == 'welding_technology')
      //         this['dataStore/enableWeldingTechnology'](true);
      //     }
      // console.log('selection check',typeof this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter]);
      // if(!(this.$store.state.dataStore.selections[this.$store.state.dataStore.selectedChapter].hasOwnProperty('ring_sizing')))
      // {
      //   var objToAdd = {};
      //   var column = 'ring_sizing';
      //   var val = true;
      //   objToAdd[column] = val;
      //   this.$store.commit('dataStore/addToSelections',objToAdd);
      // }
      //   }
      // },
    },

    mounted()
    {
      // console.log('router query');
      // console.log(this.$route.query.chapter)
      // setting rhodo=ium plating to false so that we can  get rodium information of each and every dependent chapter separately
      this['dataStore/setrhodiumplatingmodal'](false);
      this.getImageRequiringChapters();
      this.getProcedureDetails();
      if(this.$store.state.dataStore.main_chapter == this.$route.query.chapter)
      {
        if(localStorage.getItem('review_options_enabled') == false)
        {
          this['dataStore/stoneStringingSolderingHandled'](false);
        }
        this['dataStore/updateStoneDetailsPerIndex']([false,'is_captured',null]);
        this['dataStore/addStoneWorkStatus']('do_not_require_stone_work');
        this['dataStore/addSolderingWorkStatus']('do_not_require_soldering_work');
        this['dataStore/addFinishingWorkStatus']('do_not_require_finishing_work');
        this['dataStore/addGemStonesWorkStatus']('do_not_require_gemstones_work');
        this['dataStore/addStringingWorkStatus']('do_not_require_stringing_work');
        this['dataStore/enableAskStoneDetailsPopup'](false);
      }
      if(this.$store.state.dataStore.selectedChapter ==  '1000')
      {
        this['dataStore/enableRequireWeightPopup'](false);
        this['dataStore/enableRequireMetalPopup'](false);
      } 
      this['dataStore/setpicklistmodal'](false);
      // if(this.$store.state.dataStore.selectedChapter == this.$store.state.dataStore.main_chapter &&
      // this.$store.state.dataStore.selectedChapter == this.$route.query.chapter )
      // {
      //   this['dataStore/stoneStringingSolderingHandled'](false);
      // }
      this.isCheckAndTightenNeeded();
    },
    validations: {
    chapter1000Item:{
      weight: {
        required,
      },
    },
  },
    methods:{

      ...mapActions(['dataStore/getFlowOptions','dataStore/addtoSelections','dataStore/setpicklistItem','dataStore/updateStoneDetailsPerIndex',
      'dataStore/enableWeldingTechnology','dataStore/setrhodiumplatingmodal','dataStore/setpicklistmodal','dataStore/removeTwoToneKarats',
      'dataStore/setSelectedFlow','dataStore/setInterlinkedQuantities','dataStore/setWeldingTechnology','dataStore/addToSelections',
      'dataStore/setIsRush','dataStore/addExtraLabor','dataStore/setSelectedProcedure','dataStore/addProcedureDetailsToRhodiumPlating',
      'dataStore/stoneStringingSolderingHandled','dataStore/setSelectedChapter','dataStore/addProcedureDetailsToSelections',
      'dataStore/setDiscardedCategory','dataStore/requireMetalAlongWithLabor','dataStore/enableRequireMetalPopup',
      'dataStore/setPercentage','dataStore/enableAskStoneDetailsPopup','dataStore/chooseMetal','dataStore/resetExtraWorkDetailsStructure',
      'dataStore/setExtraWorkFlowBasicObjectStructure','dataStore/addStoneWorkStatus','dataStore/addSolderingWorkStatus',
      'dataStore/addFinishingWorkStatus','dataStore/addGemStonesWorkStatus','dataStore/addStringingWorkStatus',
      'dataStore/enableRequireWeightPopup','dataStore/enableRequireMetalPopup','dataStore/setLoader']),
      isCheckAndTightenNeeded()
      {
        axios.get('/api/get-chapter-dependencies').then(response=>
        {
          if(response.data)
          {
            var current_chapter = this.$route.query.chapter;
            var chapters_dependencies = response.data.data;
            var stone_requiring_chapters = chapters_dependencies.stone_chapters; 
            var dependencies_itself = response.data.data.dependencies_itself;
            var stone_exists = (Object.keys(stone_requiring_chapters)).includes(current_chapter);
            var chapter_is_dependency_itself = dependencies_itself.includes(current_chapter);
            var context = this;
            if(stone_exists)
            {
              this.show_check_and_tighten_option = true;
            }
            }}
          );
      },
      // enbaleStoneProcedure()
      // {
      //   new Promise(function(resolve, reject) {
      //   this['dataStore/addExtraLabor']('stone');
      //   resolve(true);
      //       return true;
      //     }).then(function(result) { // (**)
      //   var chapter_index = 700;
      //   var state = this.$store.state.dataStore;
      //   // it should only call if cycle is not been reset.
      //   context['dataStore/setSelectedFlow'](state.chapterFlow[1]);
      //   context['dataStore/setSelectedProcedure'](1);
      //   context.$store.dispatch("dataStore/fetchFlow700", {
      //     chapter:chapter_index
      //   }).then(response => {
      //     context['dataStore/setWeldingTechnology']();
      //     context['dataStore/addProcedureDetailsToSelections'](chapter_index);
      //     context['dataStore/addProcedureDetailsToNextOptions'](chapter_index);
      //     context['dataStore/getFlowOptions']();
      //   });
      // });
      // },
      /**
       * alert generator
       */

      showAlert($event) 
      {
        this.alertMsg = $event[0];
        this.variant = $event[1];
        this.showDismissibleAlert =  true;
      },

      /**
       * setInterlinkedAsPriceCriterianItem
       */
      setInterlinkedAsPriceCriterianItem(item)
      {
        this.$store.commit('dataStore/setPriceCriteriaItem',{'price_criteria_item_name':[item]});
        this.moveToNextOption([{'no_of_price_criteria_item':this.interlinked_option},{'interlinked_option':item}]);
        this.no_of_price_criteria_item = this.interlinked_option;
      },
      /**
       * Clear alert
       */

      clearAlert() {
          this.alertMsg = '';
          this.variant = '';
          this.showDismissibleAlert = false;
      },

      hideImage(e)
      {
        e.target.src = '/assets/jewelry.png'
        // console.log(e.target'd-non.classList);
      },                      
      showPriceCriterianItemField(index)
      {
        console.log(this.$store.state.dataStore.selections);
      },
      chooseTechnology(technology)
      {
        var state = this.$store.state.dataStore;
        var context = this;
        if(state.selectedChapter == '900')
        {
          new Promise(function(resolve, reject) {
            // context['dataStore/setWeldingTechnology']([null,technology]);
            resolve(true);
            return true;
          }).then(function(result) { // (**)
            context.moveToNextOption([{'welding_technology':technology}]);
            return true;
          });
        }
        else
        {
            this['dataStore/setWeldingTechnology']([null,technology]);
        }
      },
      
      ok()
      {
        this['dataStore/setpicklistmodal'](false);
        this['dataStore/setpicklistItem'](true);
      },
      addBulkValues(to_select)
      {
        console.log(to_select);
      },
      cancel()
      {
        this['dataStore/setpicklistmodal'](false);
        this['dataStore/setpicklistItem'](false);
      },
      
      findSKu()
      {
        this.$router.push({
          name: 'list-of-job'
        });
      },
      putQuantityAgainstInterlinkItems(event_value,appraisal_no,single_add_on)
      {
        // console.log('before calling function');
        // console.log(single_add_on,event_value,appraisal_no);
        this.$store.commit('dataStore/putQuantityAgainstInterlinkItems',[event_value,appraisal_no,single_add_on]);
        // this['dataStore/setInterlinkedQuantities']([single_add_on,Number(event_value),appraisal_no])
        // $this.store.state.dataStore.interlink_quantities[appraisal_no] = Number(event_value.target.value);
      },
      setComplicationSurcharge(event_value,complication_surcharge)
      {
        // console.log('before calling function');
        // console.log(single_add_on,event_value,appraisal_no);
        // this['dataStore/setInterlinkedQuantities']([single_add_on,Number(event_value),appraisal_no])
        // $this.store.state.dataStore.interlink_quantities[appraisal_no] = Number(event_value.target.value);
        var context = this;
        new Promise(function(resolve, reject) {
          context.$store.commit('dataStore/setComplicationSurcharge',[event_value,complication_surcharge]);
          resolve(true);
          return true;
        }).then(function(result) { // (**)
        context.moveToNextOption([{'complication_surcharge_selected':true}]);
          return true;
        });

      },
      
      setTwoToneKarats(event_value,karat_detail)
      {
        // console.log('before calling function');
        // console.log(single_add_on,event_value,appraisal_no);
        this.$store.commit('dataStore/setTwoToneKarats',[event_value,karat_detail]);
        // this['dataStore/setInterlinkedQuantities']([single_add_on,Number(event_value),appraisal_no])
        // $this.store.state.dataStore.interlink_quantities[appraisal_no] = Number(event_value.target.value);
        var karat_quality = event_value[1].split(" ");
        if(Object.keys(this.two_tone_karats).length >= 2)
        {
          this.moveToNextOption([{'karats':karat_quality[0]}]);
        }
      },
      cancelQuantityAgainstValue(to_select)
      {
        this.interlink_quantity_values[to_select] = 0;
      },
      checkIfExists(option_to_select,index) 
      {
        var state = this.$store.state.dataStore;
        var keys = [];
        var entires = state.selections[this.$route.query.chapter]['procedure_details_'+this.$route.query.procedure]['options'];
        var interlinked = state.interlink_quantities;

        if(entires)
        {
          keys = Object.keys(entires);
          if((keys.includes(index) && entires[index] && entires[index] == option_to_select) // if selections contains value
            // || (current_chapter == '1200' && entires['major_item'] == 'Appraisals' && interlinked.includes(option_to_select)) // or appraisal
        )
        {
          // console.log('hi');
          return true;
        }
        else
        {
          // console.log('bye');
          return false;
        }
        }
      },
      addWeightDetails()
      {
        this.moveToNextOption(([{'require_weight_popup':this.chapter1000Item.weight}]));
        this['dataStore/setLoader'](true);
        this['dataStore/enableRequireWeightPopup'](false) ;
      }, 
      checkIfShouldComes(appraisal_no,option_to_select) 
      {
        var interlink_quantity_for_individual_items = this.$store.state.dataStore.interlink_quantity_for_individual_items;
        // console.log('check if should comes');
        // console.log(this.interlink_quantities[appraisal_no])
        if(interlink_quantity_for_individual_items.includes(option_to_select) && this.interlink_quantities[appraisal_no] && this.interlink_quantities[appraisal_no][option_to_select])
        {
          return true; 
        }
        else
        {
          return false;
        }
      },
      getImageRequiringChapters()
      {
        const response = axios.get('/api/get-image-requiring-chapters').then(response=>
        {
          if(response.data)
          {
            this.image_requiring_chapters = response.data.data.image_requiring_chapters; 
          }
        }).catch(error=>{
        }); 
      },
      checkIfImageExists(index)
      {
        var current_chapter = this.$route.query.chapter;
        var image_exists = ((Object.keys(this.image_requiring_chapters)).includes(current_chapter) && 
        (Object.values(this.image_requiring_chapters[current_chapter])).includes(index));
        if(image_exists)
        {
          return true;
        }
        else
        {
          return false;  
        } 
      },
      checkIfNotSelected(index) 
      {
        var keys = [];
        var entires = this.$store.state.dataStore.selections[this.$route.query.chapter];
        if(entires){
          keys = Object.keys(entires);
        }
        if(keys.includes(index)){
          return false; 
        }else{
          return true;
        }
      },
      rhodiumPlate1()
      {
        console.log('rhodium plate to be called');
        var state = this.$store.state.dataStore;
        this.$store.commit('dataStore/setRhodiumPlate',true);
        this['dataStore/setrhodiumplatingmodal'](false);
        // handle should only be called when labor andling screen not called already.
        if(!state.stone_stringing_soldering_handled)
        {
          console.log('state.stone_stringing_soldering_handled is true');
          // this.handleStoneStringingAndSolderingWork();
          // return;
        }
        // checking if you current chapter is captured or not
        this.handleExtraWorkDetails();
      },
      cancelRhodiumPlate1()
      {
        var state = this.$store.state.dataStore;
        this.$store.commit('dataStore/setRhodiumPlate',false);
        this['dataStore/setrhodiumplatingmodal'](false);
        if(!state.stone_stringing_soldering_handled)
        {
          // console.log('state.stone_stringing_soldering_handled is true');
          // this.handleStoneStringingAndSolderingWork();
          // return;
        }
        // checking if you current chapter is captured or not
        // this.handleExtraWorkDetails();
      },
      getProcedureDetails()
      {
        // var state = this.$store.state.dataStore;
        // var extra_work_details = state.extra_work_details[state.selectedChapter];
        // console.log('extra_work_details',extra_work_details);
      },
      handleStoneStringingAndSolderingWork()
      {
        
        console.log('landed in handleStoneStringingAndSolderingWork');
        var state = this.$store.state.dataStore;
        axios.get('/api/get-chapter-dependencies').then(response=>
        {
          if(response.data)
          {
            var current_chapter = this.$route.query.chapter;
            var stone_requiring_chapters = response.data.data.stone_chapters; 
            var stringing_requiring_chapters = response.data.data.stringing_chapters;     
            var solder_requiring_chapters = response.data.data.solder_chapters; 
            var finishing_requiring_chapters = response.data.data.finishing_chapters;
            // var heads_and_bezels_chapters = response.data.data.heads_and_bezels_chapters;
            var dependencies_itself = response.data.data.dependencies_itself;
            console.log(stone_requiring_chapters,solder_requiring_chapters,finishing_requiring_chapters); 
            console.log('stone requiring chsptes keys',Object.keys(stone_requiring_chapters));
            var stone_exists = (Object.keys(stone_requiring_chapters)).includes(current_chapter);
            var solder_exists    = Object.keys(solder_requiring_chapters).includes(current_chapter);
            var finishing_exists = Object.keys(finishing_requiring_chapters).includes(current_chapter);
            var stringing_exists = Object.keys(stringing_requiring_chapters).includes(current_chapter);
            console.log('exists or not',stone_exists,solder_exists,finishing_exists,stringing_exists);
            var chapter_is_dependency_itself = dependencies_itself.includes(current_chapter);
            var context = this;
            // stone_work:"do_not_require_stone_work"

            // there are two possibilities 1.chapter is itself dependency 
            // 2. chapter doesnt have any dependency nor is itself dependency 
            // if(chapter_is_dependency_itself)
            // {

            // }
            // else
            // {
            if(stone_exists || solder_exists || finishing_exists || stringing_exists || heads_and_bezels_exists)
            {
              if(solder_exists)
              {
                // this['dataStore/addExtraLabor']('soldering');
                // if(current_chapter == state.soldering_chapter[0])
                // {
                //   this['dataStore/stoneStringingSolderingHandled'](true);
                // }
              }
              if(stone_exists)
              {
                console.log('land in stone');
                new Promise(function(resolve, reject) {
                context['dataStore/addExtraLabor']('stone');
                  console.log('addExtraLabor handled');
                  resolve(true);
                  return true;
                }).then(function(result) { // (**)
                  context['dataStore/setExtraWorkFlowBasicObjectStructure']('stone');
                  return true;
                }).then(function(result) { // (**)
                  // this.$bvModal.show('require_stone_work_modal');
                  return true;
                });
              }
              if(finishing_exists)
              {
                // this['dataStore/addExtraLabor']('finishing');
              }
              if(stringing_exists && 'major_item' in state.selections[state.selectedChapter]['procedure_details_1']['options'] && 
              state.selections[state.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('pearl'))
              {
                console.log('land in stringing');
                new Promise(function(resolve, reject) {
                  // context['dataStore/addExtraLabor']('stringing');
                  console.log('addExtraLabor handled');
                  resolve(true);
                  return true;
                }).then(function(result) { // (**)
                  context['dataStore/setExtraWorkFlowBasicObjectStructure']('stringing');
                  return true;
                });
              }
              if(heads_and_bezels_exists)
              {
                // this['dataStore/addExtraLabor']('heads_and_bezels');
              }
              // setting default option for stone work as state.stone_work = 'do_not_require_stone_work';
              // this['dataStore/addExtraLabor']();
              // this['dataStore/stoneStringingSolderingHandled'](true);
              // this.$router.push("/stone-soldering-details").catch(()=>{});  
            }
            else
            {
              // this['dataStore/stoneStringingSolderingHandled'](true);
            }
          }
        }).catch(error=>{
               
        });
        return; 
      },
      chooseMetal(metal)
      {
        this.chapter1000Item.show_weight_input = true;
        this['dataStore/chooseMetal'](metal);
      },
      moveToNextOption(array_OF_OBJECTS)
      {
        var state = this.$store.state.dataStore;
        if(array_OF_OBJECTS)
        {
          for(var i = 0; i<array_OF_OBJECTS.length; i++) // chuss
            {
              var index = Object.keys(array_OF_OBJECTS[i])[0];
              var column = index;
              var option = Object.values(array_OF_OBJECTS[i])[0];
              if(option)
              {
                // console.log(option)
                var objToAdd = {};
                var val = option;
                objToAdd[column] = val;
                console.log('objToAdd');
                console.log(objToAdd);
                this['dataStore/addToSelections'](objToAdd).then(flow_response => {
                if(column == 'popup' && state.selectedChapter == '1000')
                { console.log('both conditions handled');
                  this['dataStore/enableRequireMetalPopup'](false);
                }
                this['dataStore/getFlowOptions'](column);
                });
                // this.$router.push({ path: `/flow-option?chapter=${state.selectedChapter}` }).catch(()=>{});
              }
              else
              {
                console.log('get flow options called');
                this['dataStore/getFlowOptions'](column);
              }
          }
        }
        else
        {
          this.$store.commit('dataStore/setPercentage',100);
          var context = this;
          console.log('in else part');
          // var next_options = state.next_options;
          // # may be first indepenedent chapter or first depenedent chapter or loop dependent middle chapter or loop dependent last chapter.
          var chapter = this.$route.query.chapter;
          // console.log(Object.keys(next_options[chapter]));
          // being commented as we require quantity in every scenerio its just putting if having price criteria item in flow.
          // if((Object.keys(next_options[chapter])).includes('price_criteria_item'))
          // {
          var objToAdd = {};
          // procedure details have been added both in find sku and stone and soleriung details 
          var selection_entries = state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options'];
          console.log(selection_entries,'selection_entries');
          if(state.selectedChapter == '900' && selection_entries['major_item'].toLowerCase().includes('glasses'))
          {
            if(selection_entries['welding_technology'].toLowerCase().includes('torch'))
            {
              this.showAlert(['eye glasses are requiring laser not torch.','danger']);
              return;
            }
          }
          console.log(state.price_criteria_item_name,
          'state.price_criteria_item_name',
          typeof state.price_criteria_item_name);
          if(typeof state.price_criteria_item_name == 'object' && state.price_criteria_item_name[0] !== "")
          {
            if(state.selectedChapter == '900' && selection_entries['complexity'].toLowerCase().includes('charm'))
            {
              if(typeof this.no_of_price_criteria_item == 'string')
              {
                this.no_of_price_criteria_item = Number(this.no_of_price_criteria_item);
              }
              console.log('this.no_of_price_criteria_item',this.no_of_price_criteria_item)
              if(this.no_of_price_criteria_item < 5)
              {
                this.showAlert(['Number of charms should be 5 or more.','danger']);
                return;                 
              }
            }
            objToAdd['no_of_price_criteria_item'] = this.no_of_price_criteria_item;
            console.log('selection object in no_of_price_criteria_item');
            console.log(objToAdd);
            this.$store.commit('dataStore/addToSelections',objToAdd);
          }
          else if(typeof state.price_criteria_item_name !== 'object' || (typeof state.price_criteria_item_name == 'object' && state.price_criteria_item_name[0] == ""))
          {
            objToAdd['no_of_price_criteria_item'] = "1";
            // console.log('selection object for price_criteria_item_name');
            // console.log(objToAdd);
            this.$store.commit('dataStore/addToSelections',objToAdd);

          }
          if(state.chapters_not_including_welding.includes(state.selectedChapter) && state.selectedChapter !== '900' && 'welding_technology' in selection_entries)
          {
            this.$store.commit('dataStore/removeWeldingTechnologyFromSelections');
          }
          // this.addtoSelections(obj);
          // }
          // if('karats' in state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options'])
          // {
            
          // }
          // check if stone work required
          // if 100 is having rhodium plating then its must be having rhodium charges , dont need to ask.
          // dd($labor_retail);
          if(!(this.$route.query.chapter == '1200' && 
          'major_item' in state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options'] && 
          state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options']['major_item'].toLowerCase().includes('refinish')))
          {

            if(('karats' in state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options'] && 
            state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options']['karats'].includes('wg')) || 
            ('color' in state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options'] && 
            state.selections[chapter]['procedure_details_'+state.selectedProcedure]['options']['color'].toLowerCase().includes('white')))
            {
              if(this.$route.query.chapter == '100')
              {
                new Promise(function(resolve, reject) {
                  context['dataStore/setWeldingTechnology'];
                  resolve(true);
                  return true;
                }).then(function(result) { // (**)
                    // console.log('fetchFlow *');
                  context.rhodiumPlate1();
                  return true;
                });
              }
              else
              {
                new Promise(function(resolve, reject) {
                  // console.log('setSelectedProcedure *');
                context['dataStore/setrhodiumplatingmodal'](true);
                  // console.log('selections ------');
                  // console.log(state.selections);
                  resolve(true);
                   return true;
                }).then(function(result) { // (**)
                    // console.log('fetchFlow *');
                  
                  context['dataStore/setWeldingTechnology'];
                  return true;
                });
                return;
              }
              }else{
                  this.cancelRhodiumPlate1();
              }

            }
            else
            {
              this.cancelRhodiumPlate1();
            }
// var con = this.$on
            new Promise(function(resolve, reject) {
              console.log('state.stone_stringing_soldering_handled .....',state.stone_stringing_soldering_handled);
              if(!state.stone_stringing_soldering_handled)
              {
                context.handleStoneStringingAndSolderingWork();
                // prohibit the 
                resolve(true);
                return;
              }
              resolve(true);
              return true;
            }).then(function(result) { // (**)
                console.log('handleExtraWorkDetails being called *');
                setTimeout(function() {
                context.handleExtraWorkDetails(); // being uncommented in 1000 case

                }, 500);
                
                return true;
            }).catch(e => {
                console.log('error in promise',e);
            });

          // handle should only be called when labor andling screen not called already.
          // checking if you current chapter is captured or not
          }
        },

      handleExtraWorkDetails()
      {
        var context = this;
        // console.log('type',typeof this.$route.query.chapter);
        var state = this.$store.state.dataStore;
        // var chapter = state.selectedChapter; 
        var continue_with_looping = false;
          new Promise(function(resolve, reject) {
              // console.log('updateStoneDetailsPerIndex being called');  
              if(state.selectedChapter !== state.main_chapter)
              {
                context['dataStore/updateStoneDetailsPerIndex']([true,'is_captured',null]);
              }
              resolve(true);
              return true;
          }).then(function(result) {
            setTimeout(function() {
              Object.entries(state.extra_work_details).forEach(
          ([key, extra_labor]) =>
          {
            console.log('extra_labor detail in loop.',extra_labor,state[extra_labor['specification']+'_work'],'require_'+extra_labor['specification']+'_work')
            console.log('checking equivalence',extra_labor,state[extra_labor['specification']+'_work'],'require_'+extra_labor['specification']+'_work');
            if((!(extra_labor.is_captured)) && extra_labor.is_capturable && (state[extra_labor['specification']+'_work'] == 'require_'+extra_labor['specification']+'_work'))
            {
              continue_with_looping = true; 
              console.log('extra_labor',state[extra_labor['specification']+'_chapter']);
              context['dataStore/setSelectedChapter']([state[extra_labor['specification']+'_chapter'][0],extra_labor['specification']]);
              // it should only call if cycle is not been reset.

              // if dependent chapters exist
              // state.selectedProcedure is set to 1 thats default
              context['dataStore/setSelectedProcedure'](1);
              context.$store.dispatch("dataStore/fetchFlow", {
                chapter:state[extra_labor['specification']+'_chapter'][0],
              }).then(response => {
                context['dataStore/setSelectedFlow'](state.secondaryChapterFlow[1]);
                context['dataStore/enableWeldingTechnology']();
                // context['dataStore/setWeldingTechnology']();
                context['dataStore/addProcedureDetailsToSelections'](state.selectedChapter);
                context['dataStore/getFlowOptions']();
                // window.location.reload();
              });
              }
            });
              return true;
              }, 1000);
          
          });
        var context = this;
        setTimeout(function() {
        if(continue_with_looping == false)
          {
            console.log('unexpected call to description of item');
            console.log('review_options_enabled',localStorage.getItem('review_options_enabled'));
            if(localStorage.getItem('review_options_enabled') == true)
            {
              localStorage.setItem('review_options_enabled',false);
              context.$router.push({name:"show-price"}).catch(()=>{});
            }
            else
            {
              context.$router.push({name:'description-of-item'}).catch(()=>{});
            }
          }

        }, 1500);          
      },
      toggleCollapse(event)
      {    

        // console.log(event);
        this.showCollapse =  this.value;
        // console.log(this.showCollapse);

      }
    }
}
  
</script>
<style scoped> 
.shrinkable{
  flex-wrap: wrap;
    justify-content: center; display: flex; gap:10px ; position:relative
}
.text-capitalize{
  text-transform: capitalize;
}

/* 
.myForn .form-control { height: auto !important;padding: 12px 20px !important; border-radius: 100px !important;  }
.myForn .form-group {  margin: 0px !important;}
.sett_stone_detail .card { background-color: transparent !important; border: 0px !important;}
.sett_stone_detail  {background: #333c73 !important; border-radius: 10px; /*border: 1px solid #a1a1a1;} 

.my_collapse { margin: 0px !important; width: 100%; padding: 15px 20px !important; border: 1px solid #ffff !important; border-radius: 10px; border: 0px !important; display: flex; align-items: center; justify-content: space-between;}

.my_collapse .custom-control {}

.my_collapse_bg {background: #333c73 !important;
border: 1px solid #ffffff57; 
 }

.my_collapse_inner {
padding: 20px 20px !important; 
border-radius: 10px;
}

.collaps_setting {padding: 20px 20px !important}

.my_collapse_inner .form-inline { display: block !important; margin-bottom: 0px !important;}

.my_collapse_inner .custom-radio { display: block !important;}

.my_collapse_inner .form-inline .form-group{ display: block !important;}

.my_collapse_inner .form-inline label { display: block !important;} 

.circle_icon { font-size: 16px; color: #28a745;}

.item_select ul { margin: 0px; padding: 0px; display: flex; margin: 0px -10px;}
.item_select ul li { margin: 0px;  list-style: none; padding: 5px 10px;  width: 50%; }

.item_select ul li  button { display: block; width: 100%; padding: 10px 0px; box-shadow: none !important; border: 0px; color: #fff;} 
.item_select ul li:last-child { padding-bottom: 0px;} */

/* .item_select ul li  button:hover { background:#28a745; } */



.myForn { padding-top: 10px;}

.myForn .form-control { height: auto !important;padding: 12px 15px !important; border-radius: 10px !important; font-size: 12px;  background: #202962a3 !important;  }
.myForn .form-group {  margin: 0px !important;}
/* .my_select{
  display: none;
} */
.my_select .custom-select option {
    color: #000!important;
}

.my_collapse_bg {
    border: 0px solid #ffffff57;
}
</style>