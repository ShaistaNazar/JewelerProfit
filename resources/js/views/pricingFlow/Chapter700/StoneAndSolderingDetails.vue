<template>
    <div class="" >
    <div class="text-center" :set="state=$store.state.dataStore">
      <!-- <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/>   
        <h3 class="pb-4 pt-5 text-uppercase">
          <span v-for="(extra_work_object,index) in $store.state.dataStore.extra_work_details" :key="index">
            <span v-if="extra_work_object['is_captured'] == false">
              {{extra_work_object['specification']}}
            </span>
          </span>

          <span>{{detailHeading}}</span> -->
          <!-- {{Object.keys($store.state.dataStore.extra_work_details)}}
          {{Object.keys($store.state.dataStore.extra_work_details).includes($store.state.dataStore.stone_chapter[0].toString())}} -->
        <!-- </h3> -->
           <div class="" :set="extra_work_details_temp = $store.state.dataStore.extra_work_details">
            <div class="" :set="stone_flow = extra_work_details_temp['700']['flow_details']['procedure_details_1']">
              <div class="col-lg-12">
                <div class="sett_stone_detail text-left">
                  <div class="p-4 p-lg-5">
                      <div class="my_collapse_bg round-border mb-3 p-5"> 
                        <!-- <div class="form-group_box"> 
                            <input type='checkbox' :id="'lower_value_colored_stone_'+stone_flow.id" :checked="stone_flow['lower_value_colored_stone']" 
                              @click="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])" 
                              :name="'lower_value_colored_stone'"
                              class="no-pointer-events mr-2">
                              <label class=""  :for="'lower_value_colored_stone'+stone_flow.id">
                                Lower Value Colored Stone
                              </label>
                          </div> -->

                          <!-- testig start -->
                                        
                            <!-- <div class="checkbox_group"> 
                              <b-form-group>
                                <b-form-checkbox
                                :value="true"
                                :unchecked-value="false"
                                :id="'lower_value_colored_stone'+stone_flow_index"
                                :name="'lower_value_colored_stone'+stone_flow_index"
                                @change ="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])"
                                :checked="stone_flow.lower_value_colored_stone"
                                :aria-checked="stone_flow.lower_value_colored_stone"
                              >
                              Lower Value Colored Stone
                              </b-form-checkbox>
                              </b-form-group>
                            </div> -->
                             
                             <b-form-checkbox
                              :value="true"
                              :unchecked-value="false"
                              :name="'lower_value_colored_stone'+stone_flow.id"
                              :id="'lower_value_colored_stone_'+stone_flow.id" :checked="stone_flow['lower_value_colored_stone']" 
                              @change="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])" 
                              class="no-pointer-events mr-2"
                            >
                            Lower Value Colored Stone
                            </b-form-checkbox> 
                            <!-- <div class="form-group_box"> 
                              <input type='checkbox' :id="'lower_value_colored_stone'+stone_flow.id" :checked="stone_flow['lower_value_colored_stone']" 
                                @click="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])" 
                                :name="'lower_value_colored_stone_'+specification"
                                class="no-pointer-events mr-2">
                                <label class=""  :for="'lower_value_colored_stone'+stone_flow.id">
                                  Lower Value Colored Stone
                                </label>
                            </div> -->
                          <div class="number_field mt-4"> 

                            <strong class="d-block pb-3">
                              Number Of Stones
                            </strong>
                            <b-form-input :id="'no_of_stones'" type="number" min="0" 
                              :name="'no_of_stones'" :value="stone_flow['no_of_items']"
                              @change="updateStoneDetailsPerIndex([$event,'no_of_items',stone_flow.id])"
                              class="my_collapse_bg round-border d-block m-0"
                              v-model.trim="$v.StonDetails.no_of_stones.$model" 
                            ></b-form-input>

                            <div v-if="('major_item' in state.selections[$route.query.chapter]['procedure_details_1']['options']
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('check')
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('tighten'))||
                               $store.state.dataStore.enable_check_and_tighten">
                          
                              <div class="text-danger" v-if="error_exists_in_no_of_stones">
                                {{$t('form.validation.minValue', {num: $v.StonDetails.no_of_stones.$params.minValue.min})}}
                              </div>
                            </div>
                              
                            <!-- <b-form-input
                            :name="'total_no_of_items_'+specification"
                            type="number" min="0"
                            :value="extra_work_object['total_no_of_items']"
                            @keyup.enter="updateStoneDetailsPerIndex([$event,'total_no_of_items'])"
                            ></b-form-input> -->

                          </div> 
                         </div>
                      </div>
                    </div>
                  </div> 
                </div>
              
               <div class="main_button pt-5" v-if="((('major_item' in state.selections[$route.query.chapter]['procedure_details_1']['options']
                    && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('check')
                    && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('tighten')) && 
                    (stone_flow['no_of_items'] >= 5)) || state.enable_check_and_tighten)">
                  
                  <button v-if="error_exists_in_no_of_stones" @click="discardCheckAndTightenCharges()"
                  class="btn round-border shadow-lg btn-warning mb-2">Discard Check and Tighten Charges Either</button>
                  <button @click="addStoneWorkDetails()" :disabled="error_exists_in_no_of_stones"
                  class="btn round-border shadow-lg btn-success">Submit</button>
                </div>
                
                </div>
                
                <!-- <span class="text-warning mt-2 mb-2 d-block" v-if="(('major_item' in state.selections[$route.query.chapter]['procedure_details_1']['options']
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('check')
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('tighten')) && 
                            (stone_flow['no_of_items'] >= 5))"> OR </span> -->
                <div v-if="(('major_item' in state.selections[$route.query.chapter]['procedure_details_1']['options']
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('check')
                            && state.selections[$route.query.chapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('tighten')) && 
                            (stone_flow['no_of_items'] < 5))" class="main_button">
                  <button @click="ChangeMajorItemEither()" class="btn round-border shadow-lg btn-warning">Change Major Item Either</button>
                </div>
              </div>


          <!-- <div class="container p-0" :set="extra_work_details_temp = $store.state.dataStore.extra_work_details">
            <div class="row" >
              <div class="col-lg-12">
                <div class="sett_stone_detail text-left">
                  <div class="p-4 p-lg-5">
                    <div>
                      <div class="my_collapse_bg round-border mb-3" v-for="(extra_work_object_key_value,index) in Object.entries(extra_work_details_temp)" :key="index">
                        <div :set="extra_work_object = extra_work_object_key_value[1]" v-if="extra_work_object_key_value[1]['is_captured'] == false">
                        <!-- {{specification}} -->

                        <!-- <b-form-radio
                          :class="visible ? null : 'collapsed'"
                          :aria-expanded="visible ? 'true' : 'false'"
                          aria-controls="collapse-4"
                          @change="visible = true"gellersbluebook.com
                          v-model="stone_work"
                          value="require_stone_work"
                        >
                        </b-form-radio> -->


                        <!-- <b-form-checkbox
                          :id="'checkbox_require_'+specification+'_work'"
                          :name="'checkbox_require_'+specification+'_work'"
                          @change="extraWorkisRequiredOrNot($event)"
                          :checked="((state[specification+'_work']) == ('require_'+specification+'_work'))"
                          class="no-pointer-events"
                          :value="$event"
                          >{{specification}} work is required
                        </b-form-checkbox> -->
                        <!-- checkbox 

                        
                        
                  
                      <div class="" :set="specification = extra_work_object['specification'].toLowerCase()">
                          <div class="number_field m-0"> 
                          <label class="round-border pointer my_collapse"
                            v-b-toggle="'collapse-'+index">
                            <span class="flex-grow-1">
                              <span v-if="index">
                                <!-- {{
                                index.split('_')
                                .map((word) => word[0].toUpperCase() + word.slice(1).toLowerCase())
                                .join(' ')
                                }} 
                              </span>
                              <b-icon icon="check2-circle" class="circle_icon" aria-hidden="true"></b-icon>
                              {{specification}} work details
                            </span>
                            <a class="text-warning mr-3 text-lowercase" href="#" 
                            v-if="$store.state.dataStore.selections[$route.query.chapter] && 
                            $store.state.dataStore.selections[$route.query.chapter][index]">
                            {{$store.state.dataStore.selections[$route.query.chapter][index]}}</a>
                           <button style="background:none; border:0px ;color:#fff" :name="specification" @click="setThisItemAsActiveItem($event.target.name)"> <b-icon icon="chevron-down" aria-hidden="true" >
                            </b-icon></button>
                          
                          
                            
                           
                          </label>   
                          </div>
                      </div>

                    <b-collapse id="collapse-4" :visible="active_collapse == specification">
                      <div class="px-4"> 

                        <!-- <div class="py-3">
                          <div class="form-group_box"> 
                            <input :id="'require_'+specification+'_work'"  type='checkbox' 
                            :checked="state[specification+'_work'] == 'require_'+specification+'_work'" 
                            @click="extraWorkisRequiredOrNot($event)"
                            :name="'require_'+specification+'_work'">
                            <label class=""  :for="'require_'+specification+'_work'">
                              {{specification}} work is required
                            </label>
                          </div>
                        </div> -->
<!-- {{extra_work_object}} 
                        <div class=" round-border d-block mb-4 number_field " 
                          v-if="!(state[specification+'_work'].includes('do_not'))"> 
                          <b-form-input
                          :name="'total_no_of_items_'+specification"
                          type="number" min="0"
                          :value="extra_work_object['total_no_of_items']"
                          @keyup.enter="updateStoneDetailsPerIndex([$event,'total_no_of_items'])"
                          ></b-form-input>
                        </div>

                        <div class="number_field mb-5" v-if="extra_work_object['enable_ask_each_flow']">
                          <b-form-group>
                            
                            <!-- <b-form-radio-group
                              :value="extra_work_object['enable_ask_each_flow']"
                              :options="same_flow_for_each_options"
                              stacked
                              :name="'same_flow_for_each_'+specification"
                              @change="updateStoneDetailsPerIndex([$event,'enable_ask_each_flow',null])"
                            ></b-form-radio-group> -->
     
                          <!-- <div class="text-left">
                            <div class="my_collapse_bg my_collapse_inner round-border" style="background-color:transparent !important">
                              <b-nav-form class="mb-5">
                                  <div class="newRadions">
                                    <ul>
                                      <li>
                                        <input id="test1" class="mr-2" type="radio" @click="$event.target.value = true;  updateStoneDetailsPerIndex([$event,'same_flow_for_each',null])" 
                                        :checked="extra_work_object['same_flow_for_each'] ==  true" :name="'same_flow_for_each_'+specification"/>
                                        <label for="test1">Same flow for each stone</label> 
                                      </li>
                                      <li>
                                        <input id="test2" class="mr-2" type="radio" @click="$event.target.value = false; updateStoneDetailsPerIndex([$event,'same_flow_for_each',null])" 
                                        :checked="extra_work_object['same_flow_for_each'] == false" :name="'same_flow_for_each_'+specification"/>
                                        <label for="test2">Different Procedures for different number of stone</label> 
                                      </li>
                                    </ul>
                                  </div>
                              </b-nav-form>
                            </div>
                          </div> -->

                            <!-- <input type="radio" :id="'same_flow_for_each_'+specification" 
                            :value="extra_work_object['enable_ask_each_flow']"  
                            @blur="updateStoneDetailsPerIndex([$event,'enable_ask_each_flow',null])"/>

                            <input type="radio" :id="'same_flow_for_each_'+specification" 
                            :value="extra_work_object['enable_ask_each_flow']"  
                            @blur="updateStoneDetailsPerIndex([$event,'enable_ask_each_flow',null])"/> -->

                            <!-- <input type="radio" id="two" value="Two" v-model="picked" />
                            <label for="two">Two</label> -->

                            <!-- <b-form-radio v-model="other_stone_type" :aria-describedby="ariaDescribedby" 
                            name="some-radios">Other</b-form-radio>

                          </b-form-group>
                        </div>
                          
                        <!-- <div class="number_field mb-5" v-if="extra_work_object['same_flow_for_each'] == false">
                          <strong class="d-block pb-3">Number Of {{specification}} Procedures</strong>
                          <label class="my_collapse_bg round-border d-block m-0">
                            <b-form-input id="stone_type_number_procedure" type="number" min="0" :name="'no_of_flow_procedures_'+specification"
                            :value="extra_work_object['no_of_flow_procedures']" @keyup.enter="updateStoneDetailsPerIndex([$event,'no_of_flow_procedures',null])"
                            ></b-form-input>
                          </label>
                        </div> 

                        <div v-if="'flow_details' in extra_work_object">
                        <div v-for="(stone_flow,stone_flow_index) in Object.values(extra_work_object['flow_details'])" :key="stone_flow_index">
                          <div v-if="typeof stone_flow == 'object'">

                          <div class="col-lg-12 text-left pb-4 px-0">
                            <div class="my_collapse_bg round-border  mb-3" style="background-color:transparent !important">
                              <!-- <label class="round-border pointer my_collapse">
                                Procedure {{stone_flow_index + 1}}
                                <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                              </label> -->
                              <!-- <b-collapse id="collapse-4" :visible="true" class=""> 
                                <div class="collaps_setting"> 
                                    <div class="my_collapse_bg my_collapse_inner mb-5" style="background-color:transparent !important">
                                      <b-nav-form class="mb-3">
                                        <div class="form-group has-search fa_search"
                                         <!-- v-if="extra_work_object['specification'] == 'stone'" -->
                                         
                                        <!-- <strong class="d-block pb-3">Select Stone Type</strong> -->

                                          <!-- <b-nav-form class="mb-5">
                                              <div class="newRadions">
                                                <ul>

                                                  <li>
                                                    <input :id="'stone_type_diamond'+stone_flow_index + 1" class="mr-2" type="radio" @click="$event.target.value = 'diamond';  updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])" 
                                                    :checked="stone_flow['stone_type'] ==  'diamond'" :name="'stone_type_'+specification"/>
                                                    <label :for="'stone_type_diamond'+stone_flow_index + 1">Diamond</label> 
                                                  </li>

                                                  <li>
                                                    <input :id="'stone_type_sapphire'+stone_flow_index + 1" class="mr-2" type="radio" @click="$event.target.value = 'faceted_blue_sapphire';  updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])" 
                                                    :checked="stone_flow['stone_type'] ==  'faceted_blue_sapphire'" :name="'stone_type_'+specification"/>
                                                      <label :for="'stone_type_sapphire'+stone_flow_index + 1">Faceted Blue Sapphire</label> 
                                                  </li>

                                                  <li>
                                                    <input :id="'stone_type_ruby'+stone_flow_index + 1" class="mr-2" type="radio" @click="$event.target.value = 'faceted_ruby'; updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])" 
                                                    :checked="stone_flow['stone_type'] == 'faceted_ruby'" :name="'stone_type_'+specification"/>
                                                      <label :for="'stone_type_ruby'+stone_flow_index + 1">Faceted Ruby</label> 
                                                  </li>

                                                  <li>
                                                    <input :id="'stone_type_others'+stone_flow_index + 1" class="mr-2" type="radio" @click="$event.target.value = ''; updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])" 
                                                    :checked="stone_flow['stone_type'] !== 'faceted_ruby' && stone_flow['stone_type'] !== 'faceted_blue_sapphire' && 
                                                    stone_flow['stone_type'] !== 'diamond'" :name="'stone_type_'+specification"/>
                                                    <label :for="'stone_type_others'+stone_flow_index + 1">Others</label>
                                                  </li>

                                                </ul>
                                              </div>
                                          </b-nav-form> -->

                                          <!-- <b-form-group >

                                            <div class="mb-2">
                                            
                                            </div> -->


              
                                              <!-- <b-form-radio v-model="other_stone_type" :aria-describedby="ariaDescribedby" 
                                              name="some-radios">Other</b-form-radio> -->
                                              <!-- </b-form-group> -->
                                              <!-- <div class="myForn" v-if="stone_flow.stone_type !== 'faceted_blue_sapphire'
                                                && stone_flow.stone_type !== 'faceted_ruby'
                                                && stone_flow.stone_type !== 'diamond'">
                                                  <div class="form-group">
                                                    <b-form-input :id="'stone_type_other_'+specification" type="text" 
                                                      :name="'stone_type_other_'+specification" :value="stone_flow['stone_type']"
                                                      @blur="updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])"
                                                    ></b-form-input>
                                                  </div>
                                              </div> 
                                              <div class="checkbox_group mb-5"> 

                                                <!-- <b-form-checkbox
                                                :value="true"
                                                :unchecked-value="false"
                                                :id="'lower_value_colored_stone'+stone_flow_index"
                                                :name="'lower_value_colored_stone'+stone_flow_index"
                                                @change ="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])"
                                                :checked="stone_flow.lower_value_colored_stone"
                                                :aria-checked="stone_flow.lower_value_colored_stone"
                                              >
                                              Lower Value Colored Stone
                                              </b-form-checkbox> 
                                              <div class="form-group_box"> 
                                                <input type='checkbox' :id="'lower_value_colored_stone'+stone_flow.id" :checked="stone_flow['lower_value_colored_stone']" 
                                                  @click="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])" 
                                                  :name="'lower_value_colored_stone_'+specification"
                                                  class="no-pointer-events mr-2">
                                                  <label class=""  :for="'lower_value_colored_stone'+stone_flow.id">
                                                    Lower Value Colored Stone
                                                  </label>
                                              </div>
                                            </div>
                                        </div>
                                        
                                        <div class="number_field mb-5"> 
                                          <strong class="d-block pb-3">Number Of {{specification}}s</strong>

                                              <b-form-input :id="'no_of_items_'+specification" type="number" min="0" 
                                                :name="'no_of_items_'+specification" :value="stone_flow['no_of_items']"
                                                @blur="updateStoneDetailsPerIndex([$event,'no_of_items',stone_flow.id])"
                                                class="my_collapse_bg round-border d-block m-0"
                                              ></b-form-input>

                                            <!-- <b-form-input id="type_number" type="number" min="0"
                                            @blur="updateStoneDetailsPerIndex([$event,'no_of_stones',stone_flow.id])"
                                            :value="stone_flow.no_of_stones"
                                            ></b-form-input> 
                                        </div> 


                                        <!-- <div class=" info-div"   v-if="specification == 'stone' && Number(stone_flow.no_of_items) < 5">
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
                                              This procedure don't supports <strong class="text-warning">CHECK and TIGHTEN</strong>    
                                            </span>
                                          </div>
                                        </div> 




                                          <!-- </b-nav-form>
                                          </div>                      
                                      </div> -->
                                      <!-- </b-collapse> 
                                     </div> 
                          </div>  

                          <!-- <strong class="d-block pb-3">Select Stone Name</strong>
                          <b-nav-form class="mb-5">
                            <div class="form-group has-search fa_search">
                              <b-form-group v-slot="{ ariaDescribedby }">
                              <b-form-radio-group
                                :options="stone_types"
                                stacked
                                :aria-describedby="ariaDescribedby"
                                :id="'stone_type'+stone_flow_index"
                                :name="'stone_type'+stone_flow_index"
                                @change ="updateStoneDetailsPerIndex([$event,'stone_type',stone_flow.id])"
                                :checked="((stone_flow.stone_type !== 'faceted_blue_sapphire'
                                && stone_flow.stone_type !== 'faceted_ruby'
                                && stone_flow.stone_type !== 'diamond') || (stone_flow.stone_type))"
                                :aria-checked="((stone_flow.stone_type !== 'faceted_blue_sapphire'
                                && stone_flow.stone_type !== 'faceted_ruby'
                                && stone_flow.stone_type !== 'diamond') || (stone_flow.stone_type))"
                                class="no-pointer-events"
                              ></b-form-radio-group> -->
                              <!-- <b-form-radio v-model="other_stone_type" :aria-describedby="ariaDescribedby" 
                              name="some-radios">Other</b-form-radio>-->
                            <!-- </b-form-group>  

                            <div class="myForn" v-if="stone_flow.stone_type !== 'faceted_blue_sapphire'
                            && stone_flow.stone_type !== 'faceted_ruby'
                            && stone_flow.stone_type !== 'diamond'
                            ">
                              <div class="form-group">
                                <input type="text" class="form-control" id="other stone type"
                                aria-describedby="emailHelp" placeholder="Specify Stone Name"
                                @blur="updateStoneDetailsPerIndex([$event.target.value,'stone_type',stone_flow.id])"
                                :value="stone_flow.stone_type">
                              </div>
                            </div>

                            </div>
                            <div class="checkbox_group"> 
                              <b-form-group>
                                <b-form-checkbox
                                :value="true"
                                :unchecked-value="false"
                                :id="'lower_value_colored_stone'+stone_flow_index"
                                :name="'lower_value_colored_stone'+stone_flow_index"
                                @change ="updateStoneDetailsPerIndex([$event,'lower_value_colored_stone',stone_flow.id])"
                                :checked="stone_flow.lower_value_colored_stone"
                                :aria-checked="stone_flow.lower_value_colored_stone"
                              >
                              Lower Value Colored Stone
                              </b-form-checkbox>
                              </b-form-group>
                            </div>
                            
  
                            <div>
                              <div class="number_field mb-5"> 
                                <strong class="d-block pb-3">Number Of Stones</strong>
                                <label class="my_collapse_bg round-border d-block m-0">
                                  <b-form-input id="type_number" type="number" min="0"
                                  @blur="updateStoneDetailsPerIndex([$event,'no_of_stones',stone_flow.id])"
                                  :value="stone_flow.no_of_stones"
                                  ></b-form-input>
                                </label>
                              </div>
                            </div>

                          </div>
                        </div> 
                        </div>

                      </div>
                     </b-collapse>
                    </div>    
                    </div>                   
                    </div>
                   
                  </div>
                </div> 
              </div>
              <!-- <div class="col-lg-1">   
              </div> 
            </div>
            <div class="main_button pt-5">
              <button @click="addStoneWorkDetails()" class="btn round-border shadow-lg btn-warning">Submit</button>
            </div>
            <div>
            </div>
        </div> 
    </div> -->
      <div class="myModel">
          <div>
            <b-modal id="diamond-with-laser-warning" no-close-on-esc no-close-on-backdrop hide-header-close header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"   header-bg-variant="primary"   footer-bg-variant="primary" centered title="Diamonds with Platinum Repair">
            <p>Diamonds cannot take the heat of TORCH in Platinum repair. 
              The stones must be removed first, unless we can use a laser.</p>
              Are you okay with Laser Repair? if yes your previous selected Welding Technology will change to <b>Laser</b> from <b>Torch</b>
              <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button class="btn round-border btn-success" size="sm" variant="success" @click="okLaserWithPlatinum()">
                  Yes
                </b-button>
                <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="cancelLaserWithPlatinum()">
                  No
                </b-button>
             </template>
            </b-modal>
          </div>
      </div>

      <div class="myModel">
        <div>
            <b-modal id="chapter700-warning" no-close-on-esc no-close-on-backdrop 
            hide-header-close header-border-variant="primary" footer-border-variant="primary" 
            body-bg-variant="primary" header-bg-variant="primary"   footer-bg-variant="primary" 
            centered title="It may include 700 charges">
            <p>There is an additional charge to remove & reset the stones.</p>
              <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button class="btn round-border btn-success" size="sm" variant="success" @click="OKWith700('chapter700-warning')">
                  OK
                </b-button>
                <!-- <b-button class="btn round-border btn-success" size="sm" variant="success" @click="NotOKWith700()">
                  Cancel
                </b-button> -->
             </template>
            </b-modal>
        </div>
      </div>

      <div class="myModel">
        <div>
            <b-modal id="chapter700-or-laser" no-close-on-esc no-close-on-backdrop 
            hide-header-close header-border-variant="primary" footer-border-variant="primary" 
            body-bg-variant="primary" header-bg-variant="primary"   footer-bg-variant="primary" 
            centered title="It may include 700 charges">
            <p>one of following action is required to go ahead</p>
              <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button class="btn round-border btn-success" size="sm" variant="success" @click="ChangeWeldingToLaser()">
                  Change welding options to Laser
                </b-button>
                <b-button class="btn round-border btn-success" size="sm" variant="success" @click="OKWith700('chapter700-or-laser')">
                  OK with remove and reset charges
                </b-button>
             </template>
            </b-modal>
        </div>
      </div>
     </div>
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'; 
import Checkbox from '../../../components/Global/Checkbox.vue';
/**
     * Vuelidate items
     */
    
    import {
        required,
        maxLength,
        minLength,
        email,
        containsNumber,
        minValue
    } from "vuelidate/lib/validators";

  export default {
  components: { Checkbox },
    data() {
      return {
        selected: [], // Must be an array reference! 
        radio_options: [], 
        disabledLink:true,
        subHeading:"Add Stone " ,
        solderHeading:"and Solder ",
        detailHeading:"Details",
        finishingHeading:"Finishing ",
        heads_and_bezelsHeading:'Heads And Bezels ',
        stringingHeading:"Stringing ",
        gemstonesHeading:'Gemstones ',
        isShow: true,
        other_stone_type:false,
        stone_types: [
          { text: 'Diamond', value: 'diamond' },
          { text: 'Faceted Rubies', value: 'faceted_ruby' },
          { text: 'Faceted Blue Sapphire', value: 'faceted_blue_sapphire' },
          { text: 'Others', value: '' },
        ],
        same_flow_for_each_options: [
          { text: 'Same flow for each stone', value: true },
          { text: 'Different Flows for different stones', value: false },
        ],
        showCollapse:true,
        value:false,
        visible_stone: false,
        visible_finishing: false,
        visible_stringing: false,
        visible_soldering: false,
        visible_gemstones: false,
        visible_heads_and_bezels: false,
        justOKwith700Popup: true,
        showDismissibleAlert: false,
        alertMsg:'',
        variant:null,
        warning:false,
        active_collapse:null,
        StonDetails: 
        {
          no_of_stones:this.$store.state.dataStore.extra_work_details['700']['flow_details']['procedure_details_1']['no_of_items'],
        },
        error_exists_in_no_of_stones:true,
      }
    },
    validations: {
        StonDetails: {
          no_of_stones: {
                required,
                minValue: minValue(5)
            },
        }
    },
    mounted()
    {
      // this['dataStore/enableAskStoneDetailsPopup'](false);
    },
    watch: {
      //
      // '$store.state.dataStore.flow_details.stone_type': function() {
      //   console.log('in watcher');
      //   console.log(this.$store.state.dataStore.flow_details.stone_type);
      //   // show if stones are removeable and previously not selected laser option 
      //   if(this.$store.state.dataStore.flow_details.stone_type !== 'faceted_blue_sapphire'
      //   && this.$store.state.dataStore.flow_details.stone_type !== 'faceted_ruby'
      //   && this.$store.state.dataStore.flow_details.stone_type !== 'diamond'
      //   && this.$store.state.dataStore.flow_details.stone_type !== ''){
      //   var laser_exists = Object.values(this.$store.state.dataStore.welding_technology).
      //   find(welding_technology_chapter_wise => welding_technology_chapter_wise == 'laser');
      //     if(!laser_exists){
      //       // customer is chosen torch whether store have laser or not , 
      //       console.log('have laser');
      //       console.log(this.$store.state.dataStore.shop.have_laser);
      //       // if store is not having laser then show popup to pay remove and reset stones with OK button.
      //       if(this.$store.state.dataStore.shop.have_laser == 0)
      //       {
      //       this.$bvModal.show('chapter700-warning');
      //       }else{
      //       // if store is having laser show popup to ask to change to laser oor pay remove and reset stones buttons are 
      //       // 1. change previous to laser and 2. pay remove and reset button.
      //       this.$bvModal.show('chapter700-or-laser');
      //       }
      //     }else{
      //       // store is having laser and there is note to tell customer that its costs 50% higher 
      //       // means no need to remove and reset stone thats why no charges  
      //     }
      //   }
      //   if(_.isEmpty(this.$store.state.dataStore.selections))
      //   {
 
      //   }
      //   else
      //   {
      //   if( 'karats' in this.$store.state.dataStore.selections[this.$store.state.dataStore.main_chapter]
      //       && this.$store.state.dataStore.selections[this.$store.state.dataStore.main_chapter]['karats']
      //       .toLowerCase() == 'platinum' && 
      //       // and not having laser already
      //       this.$store.state.dataStore.welding_technology[this.$store.state.dataStore.main_chapter] !== 'laser'
      //       && this.$store.state.dataStore.flow_details.stone_type == 'diamond' 
      //       )
      //       {
      //         this.$bvModal.show('diamond-with-laser-warning');
      //       }
      //   }
      //   // console.log(this.selections);
      // },
      // '$store.state.dataStore.flow_details.total_no_of_items': function() {
      //   console.log(this.$store.state.dataStore.flow_details.total_no_of_items);
      //   let number_of_stones = this.$store.state.dataStore.flow_details.total_no_of_items;
      //   if(number_of_stones > 1)
      //   {
      //     this.$store.commit('dataStore/enableAskEachStoneFlow', true);
      //     // this.enable_ask_each_item_flow = true;
      //   }
      //   else
      //   {
      //     this.$store.commit('dataStore/enableAskEachStoneFlow', false);
      //     // this.enable_ask_each_item_flow = false;
      //   }
      // },
      // '$store.state.dataStore.flow_details.enable_ask_each_item_flow': function() 
      // {
        
      // },
    },
    computed: {
      stone_work: {
        get () {
          console.log('getter called');
          return this.$store.state.dataStore.stone_work
        },
        set (value) {
          this.$store.commit('dataStore/addStoneWorkStatus', value)
        }
      },
      finishing_work: {
        get () {
          return this.$store.state.dataStore.finishing_work
        },
        set (value) {
          this.$store.commit('dataStore/addFinishingWorkStatus', value)
        }
      },
      stringing_work: {
        get () {
          return this.$store.state.dataStore.stringing_work
        },
        set (value) {
          this.$store.commit('dataStore/addStringingWorkStatus', value)
        }
      },
      soldering_work: {
        get () {
          return this.$store.state.dataStore.soldering_work
        },
        set (value) {
          this.$store.commit('dataStore/addSolderingWorkStatus', value)
        }
      },
      gemstones_work: {
        get () {
          return this.$store.state.dataStore.gemstones_work
        },
        set (value) {
          this.$store.commit('dataStore/addGemStonesWorkStatus', value)
        }
      },
      // total_no_of_items: {
      //   get () 
      //   {
      //     // console.log(this.$store.state.dataStore.extra_work_details,700 in this.$store.state.dataStore.extra_work_details,'this.$store.state.dataStore.extra_work_details')
      //     if(700 in this.$store.state.dataStore.extra_work_details && this.$store.state.dataStore.extra_work_details[700]['flow_details'])
      //     {
      //       // console.log('in getter',this.$store.state.dataStore.extra_work_details[700]['flow_details'].total_no_of_items);
      //       return this.$store.state.dataStore.extra_work_details[700]['flow_details'].total_no_of_items;
      //     }
      //     else
      //     {
      //       return 1;
      //     }
      //   },
      //   set (value) 
      //   {
      //     this.$store.commit('dataStore/addTotalNoOfStonesToStoneDetails', value)
      //   }
      // },
      // stone_type: {
      //   get () {
      //     return this.$store.state.dataStore.flow_details.stone_type
      //   },
      //   set (value) {
      //     this.$store.commit('dataStore/addStoneTypeToStoneDetails', value)
      //   }
      // },
      // same_flow_for_each: {
      //   get () {
      //     if(700 in this.$store.state.dataStore.extra_work_details && this.$store.state.dataStore.extra_work_details[700]['flow_details'])
      //     {
      //       return this.$store.state.dataStore.extra_work_details[700]['flow_details'].same_flow_for_each;
      //     }
      //   },
      //   set (value) {
      //     this.$store.commit('dataStore/addSameFlowForEachStoneValue', value)
      //   }
      // },
      // no_of_flow_details: {
      //   get () 
      //   {
      //     if(700 in this.$store.state.dataStore.extra_work_details)
      //     {
      //       return this.$store.state.dataStore.extra_work_details[700]['flow_details'].no_of_flow_details;
      //     }
      //   },
      //   set (value) 
      //   {
      //     this.$store.commit('dataStore/setNoOfStoneFlows', value)
      //   }
      // },
      // enable_ask_each_item_flow: {
      //   get () 
      //   {
      //     if(this.$store.state.dataStore.extra_work_details[700] && this.$store.state.dataStore.extra_work_details[700]['flow_details'])
      //     {
      //       return this.$store.state.dataStore.extra_work_details[700]['flow_details'].enable_ask_each_item_flow
      //     }
      //   },
      //   set (value) 
      //   {
      //     this.$store.commit('dataStore/enableAskEachStoneFlow', value)
      //   }
      // },
      // lower_value_colored_stone: {
      //   get () {
      //     return this.$store.state.dataStore.flow_details.lower_value_colored_stone
      //   },
      //   set (value) {
      //     this.$store.commit('dataStore/addLowerValueColoredStoneToStoneDetails', value)
      //   }
      // },
    },
    methods:{

      ...mapActions(['dataStore/addStoneDetails','dataStore/setSelectedChapter','dataStore/OKWith700',
        'dataStore/addToSelections','dataStore/fetchFlow','dataStore/setWeldingTechnology',
        'dataStore/ChangeWeldingToLaser','dataStore/setSelectedFlow','dataStore/getFlowOptions','dataStore/enableAskStoneDetailsPopup',
        'dataStore/enableWeldingTechnology','dataStore/addSameFlowForEachStoneValue','dataStore/setDiscardedCategory',
        'dataStore/setExtraWorkFlowBasicObjectStructure','dataStore/addStringingWorkStatus',
        'dataStore/addStoneWorkStatus','dataStore/addSolderingWorkStatus','dataStore/addFinishingWorkStatus',
        'dataStore/addGemStonesWorkStatus','dataStore/addStringingWorkStatus','dataStore/addProcedureDetailsToSelections',
        'dataStore/stoneStringingSolderingHandled','dataStore/addTotalNoOfStonesToStoneDetails',
        'dataStore/updateStoneDetailsPerIndex','dataStore/setNoOfStoneFlows','dataStore/setSelectedProcedure']),
      
      
      
      discardCheckAndTightenCharges()
      {
        this.$store.commit('dataStore/resetExtraWorkDetailsStructure','stone');
        this.$store.commit('dataStore/enableAskStoneDetailsPopup', false);
        this.$store.commit('dataStore/stoneStringingSolderingHandled',true);
        this.$store.commit('dataStore/enableCheckAndTighten', false);
        this.$store.commit('dataStore/removeExtraLabor');
      },
      okLaserWithPlatinum()
      {
        this.$bvModal.hide('diamond-with-laser-warning');
        this['dataStore/setWeldingTechnology']([this.$store.state.dataStore.main_chapter,'laser']);
      },
      cancelLaserWithPlatinum(){
        this.$bvModal.hide('diamond-with-laser-warning')
        this.$router.push('/');
      },
      OKWith700(modal_id){
        this['dataStore/OKWith700'](true);
        this.$bvModal.hide(modal_id)
      },
      ChangeWeldingToLaser(){
        this['dataStore/ChangeWeldingToLaser'](true);
      },
      NotOKWith700()
      {
        // customer is not ok with 700
        this.$bvModal.hide('chapter700-warning');
      },
      // handleTotalNoOfItemsAndDependencies(total_no_of_items)
      // {
      // if(total_no_of_items > 1)
      //   {
      //     this.$store.commit('dataStore/enableAskEachStoneFlow', true);
      //   }
      //   else
      //   {
      //     this.$store.commit('dataStore/enableAskEachStoneFlow', false);
      //   }
      // },
      setStoneDetails()
      {
        // console.log('same_flow_for_each',this.same_flow_for_each);
        if(this.no_of_flow_details > this.total_no_of_items)
        {
          // console.log('alert should be called');
          this.showAlert(['Number of stone procedures should be less than total number of stones.','danger']);
          this['dataStore/addTotalNoOfStonesToStoneDetails'](1);
          this['dataStore/addSameFlowForEachStoneValue'](true);
          this['dataStore/setNoOfStoneFlows'](1);

          return;
        }
        if(!this.same_flow_for_each)
        {
          // console.log()
          this['dataStore/setNoOfStoneFlows']();
        }
      },

      ChangeMajorItemEither()
      {
        var event_array = ['1','no_of_items','1'];
        this['dataStore/updateStoneDetailsPerIndex'](event_array);
        this['dataStore/enableAskStoneDetailsPopup'](false);
      },
      setThisItemAsActiveItem(specification)
      {
        this.active_collapse = this.active_collapse == specification ? '' : specification;
      },
     
      updateStoneDetailsPerIndex(event_array)
      {
        // console.log('update called');
        // var context = this;
        // new Promise(function(resolve, reject) {
          
          if(Object.values(event_array).includes('no_of_items'))
          {
            console.log(this.$v);
            this.$v.$touch();
            if (this.$v.$invalid) {
               let errorMsg = '';
                // Customer
                if(this.$v.StonDetails.no_of_stones.$error){
                    this.error_exists_in_no_of_stones = true;
                    // event_array[0] = '1'; 
                    // this.StonDetails.no_of_stones = 1;
                    this['dataStore/updateStoneDetailsPerIndex'](event_array);
                    return;
                }    
            }else{
               this.error_exists_in_no_of_stones = false;
              this['dataStore/updateStoneDetailsPerIndex'](event_array);
            }
          }else{
              this['dataStore/updateStoneDetailsPerIndex'](event_array);
          }
          
        // resolve(true);
        // }).then(function(result) {
        //   console.log('in then');
        // checking number of stones are valid
        // context.checkNoOfStones();
        // });                
      } ,

      goToFinishingFlow(event_array)
      {
        // this.$router.push({
        //   name:'flow-options'
        // })
      },
      extraWorkisRequiredOrNot($event)
      {
        console.log('event',$event)
        let event = ($event.target.checked == true ?  $event.target.name : 'do_not_'+$event.target.name)
        let specification = event.split('_');
        specification = specification[specification.length - 2];

        // if(event == 'require_stone_work')
        // {
          // this.visible = event == 'require_stone_work' ? true : false;
          // this.visible_finishing = event == 'require_finishing_work' ? true : false;
          // this.visible_stringing = event == 'require_stringing_work' ? true : false;
          // this.visible_soldering = event == 'require_soldering_work' ? true : false;
          // this.visible_gemstones = event == 'require_gemstones_work' ? true : false;
          // this.visible_heads_and_bezels = event == 'require_heads_and_bezels_work' ? true : false;

          var visible_specification = 'visible_'+specification;
          this[visible_specification] = (event == 'require_'+specification+'_work' ? true : false);
          console.log(this[visible_specification]);

          // addStoneWorkStatus
          // addStringWorkStatus
          // addFinishingWorkStatus
          // addGemStoneWorkStatus etc.,

          var specification_with_first_capital = specification.charAt(0).toUpperCase() + specification.slice(1)
          let method_name = 'dataStore/add'+specification_with_first_capital+'WorkStatus'
          this[method_name](event);
          this['dataStore/setExtraWorkFlowBasicObjectStructure'](specification);

        // }
      },
      checkNoOfStones()
      {
        var state = this.$store.state.dataStore;
        var no_of_items = 0;
        console.log(state.extra_work_details[state.stone_chapter[0]]);
        if(state.extra_work_details[state.stone_chapter[0]] && state.extra_work_details[state.stone_chapter[0]].flow_details)
        {
        Object.entries(state.extra_work_details[state.stone_chapter[0]].flow_details).forEach(
          ([key, stone_flow]) => {
          console.log(stone_flow,'stone_flow');
          if(typeof stone_flow ==  'object')
          {
            // console.log('loop number of stones',stone_flow,stone_flow.no_of_stones)
            no_of_items += Number(stone_flow.no_of_items)
            console.log('no_of_items',typeof no_of_items);
          }
        });
        }
        console.log('no_of_items in flows',typeof state.extra_work_details[state.stone_chapter[0]].total_no_of_items);
        if(no_of_items !== Number(state.extra_work_details[state.stone_chapter[0]].total_no_of_items))
        {
          this.showAlert(['no of total stones must relate number of stones collectively from procedures','danger']);
          this.warning = true;
          return false;
        }
        else
        {
          return true;
        }
       },
       addStoneWorkDetails()
       {
        // var state = this.$store.state.dataStore;
    //     // var continue_next = this.checkNoOfStones();
    //     // console.log('continue_or_not',continue_next)
    //     // if(continue_next)
    //     // {
      console.log('add stone work details');
          var context = this;
          new Promise(function(resolve, reject) {
              // console.log('updateStoneDetailsPerIndex being called');
                    // Create a new event object

              const event = new Event('change');
              const target = {
                name: 'dummy_stone',
                value: true
              };
              Object.defineProperty(event, 'target', {
                value: target,
                writable: false
              });

              window.dispatchEvent(event);

              context['dataStore/updateStoneDetailsPerIndex']([event,'is_captured',null]);
              resolve(true);
              return  true;
          }).then(function(result) {
              context['dataStore/stoneStringingSolderingHandled'](true);
          });
    //       if(Object.keys(this.$store.state.dataStore.extra_work_details).length > 0)
    //       {
    //         Object.entries(this.$store.state.dataStore.extra_work_details).forEach(
    //         ([key, extra_labor]) => 
    //         {
    //           console.log('extra_labor',extra_labor,'key',key);
    //           // console.log('checking equivalence',this.$store.state.dataStore[extra_labor['specification']+'_work'],'require_'+extra_labor['specification']+'_work');
    //           if((this.$store.state.dataStore[extra_labor['specification']+'_work'] == 'require_'+extra_labor['specification']+'_work'))
    //           {
    //             // setTimeout(doSomething, 10);
    //             console.log('extra_labor',this.$store.state.dataStore[extra_labor['specification']+'_chapter']);

    //         var context = this;
    //         new Promise(function(resolve, reject) {
    //           // then set the key e.g., 700 as next flow
    //                 // THIS WILL REQUIRE 700 and will set that
    //                 // console.log('start setSelectedChapter *',key,extra_labor);
    //                 context['dataStore/setSelectedChapter']([context.$store.state.dataStore[extra_labor['specification']+'_chapter'][0],extra_labor['specification']]);
    //                 // console.log('setSelectedChapter *');
    //                 // console.log('selections after setSelectedChapter------');
    //                 // console.log(state.selections);
    //                 // alert('hey shaosta');

    //           resolve(true);
    //           return true;
    //         }).then(function(result) {
    //                           // context.setSelectedChapter(context.$store.state.dataStore.stone_chapter);
    //                 // it should only call if cycle is not been reset.
    //                 console.log('start setSelectedFlow *');
    //                 context['dataStore/setSelectedFlow'](context.$store.state.dataStore.chapterFlow[0]);
    //                 //                 console.log('setSelectedFlow *');
    //                 // console.log('selections after setSelectedFlow------');
    //                 //   console.log(state.selections);
    //                 //                 alert('hey shaosta');
    //           return true;
    //         }).then(function(result) {
    //                 // if dependent chapters exist 
    //                 // context.$store.state.dataStore.selectedProcedure is set to 1 thats default
    //                 // console.log('start setSelectedProcedure *');
    //                 context['dataStore/setSelectedProcedure'](context.$store.state.dataStore.selectedProcedure);
    //                 //                 console.log('setSelectedProcedure *');
    //                 // console.log('selections after setSelectedProcedure------');
    //                 //   console.log(state.selections);
    //                 //                 alert('hey shaosta');

    //                 // context['dataStore/setSelectedDependentInProgressChapter'](context.$store.state.dataStore.selectedProcedure);
    //         return true;
    //         }).then(function(result) {
    //                 // context.setSelectedFlow('settings');
    //                 // console.log('start setDiscardedCategory *');

    //                 if('flow_details' in extra_labor && extra_labor['flow_details'] && 
    //                 extra_labor['flow_details']['procedure_details_'+context.$store.state.dataStore.selectedProcedure] && 
    //                 Number(extra_labor['flow_details']['procedure_details_'+context.$store.state.dataStore.selectedProcedure]) < 5)
    //                 {
    //                   context['dataStore/setDiscardedCategory']([state.selectedChapter,state.selectedProcedure,'Check & Tighten Stones']);
    //                 }
    // //                 console.log('setDiscardedCategory *');
    // // console.log('selections after setDiscardedCategory------');
    // //   console.log(state.selections);
    //                 // alert('hey shaosta');
    //                 return true;
    //         }).then(function(result) {
    //                 context.$store.dispatch("dataStore/fetchFlow", {
    //                   chapter:context.$store.state.dataStore[extra_labor['specification']+'_chapter'][0]
    //                 })
    //   //               console.log('selections after fetchFlow------');
    //   // console.log(state.selections);
    //   //               alert('hey shaosta');
    //                 return true;
    //         }).then(function(result) {
    //                 // context will reset all options against chapter 700 as no argument is being passed
    //                   // context.$store.dispatch('addToSelection', null, {root:true});
    //                   // context.addToSelection();
    //                   // console.log('start setWeldingTechnology *');
    //                   context['dataStore/setWeldingTechnology']();
    // //                   console.log('setWeldingTechnology *');
    // // console.log('selections after setWeldingTechnology------');
    // //   console.log(state.selections);
    // //                 alert('hey shaosta');
    //                   return true;
    //         }).then(function(result) {
    //                 // context['dataStore/enableWeldingTechnology'](true);
    //                   // console.log('start addToSelections *');
    //                   // context.$store.commit('dataStore/addToSelections');
    //                   // console.log('addToSelections *');
    //                   // console.log('selections after addToSelections------');
    //                   // console.log(state.selections);
    //                   //               alert('hey shaosta');
    //                   // return true;
    //         }).then(function(result) {

    //                 // console.log('start addProcedureDetailsToSelections *');
    //                 context['dataStore/addProcedureDetailsToSelections'](state[extra_labor['specification']+'_chapter'][0]);
    //                 // console.log('addProcedureDetailsToSelections *');
    //                 // console.log('selections ------');
    //                 // console.log(state.selections);
    //                 return true;
    //         }).then(function(result) {
    //                 // alert('hey shaosta before getFlowOptions');

    //                 //   console.log('start getFlowOptions *');
    //                 context['dataStore/getFlowOptions']();
    //   //                 console.log('getFlowOptions *');
    //   // console.log('selections after getFlowOptions------');
    //   // console.log(state.selections);
    //   //               alert('hey shaosta after getFlowOptions');
    //                 return true;
    //         })
    //         context.$router.push({name:"flow-option",query: { chapter: state.selectedChapter,procedure:state.selectedProcedure }}).catch(()=>{});
    //           }});
    //           }
              // else{ 
                // this.$router.push('/description-of-item');
              this['dataStore/enableAskStoneDetailsPopup'](false);
              // }
        // }
      },
      findSKu(){

        this.$router.push({
          name: 'list-of-job'
        });

      },
      toggleCollapse(event){

        // console.log(event);
        this.showCollapse =  this.value;
        // console.log(this.showCollapse);
        
      }
    }
  }
</script>  
<style scoped> 

.myForn .form-control { height: auto !important;padding: 12px 20px !important; border-radius: 100px !important;  }
.myForn .form-group {  margin: 0px !important;}
.sett_stone_detail .card { background-color: transparent !important; border: 0px !important;}
.sett_stone_detail  {background: #333c73 !important; border-radius: 10px; /*border: 1px solid #a1a1a1;*/ } 
.my_collapse { margin: 0px !important; width: 100%; padding: 15px 20px !important; border: 1px solid #ffff !important; border-radius: 10px; border: 0px !important; display: flex; align-items: center; justify-content: space-between;}
.my_collapse .custom-control {}
.my_collapse_inner {
padding: 20px 20px !important; 
border-radius: 10px;
}
.collaps_setting {padding: 20px 20px !important}
.my_collapse_inner .form-inline { display: block !important; margin-bottom: 0px !important;}
.my_collapse_inner .custom-radio { display: block !important;}
.my_collapse_inner .form-inline .form-group{ display: block !important;}
.my_collapse_inner .form-inline label { display: block !important;}

</style>