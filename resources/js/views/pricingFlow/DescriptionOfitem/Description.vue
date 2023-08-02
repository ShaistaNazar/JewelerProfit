<template>
    <div class="">
      <div class="envelop_container text-center"> 
          <div class="container ">
            <custom-alert
              :showDismissibleAlert="showDismissibleAlert"
              :msg="alertMsg"
              :variant="variant"
            />
            <div class="myForn descriptionCollapse  px-lg-5 py-lg-3">
                <div class="row align-items-center p2-4 ">  
                    <div class="col-lg-6 col-md-6">
                         <div class="shank_tittle">
                            <b-button :variant="variant" class="round-border backBtn"  @click="$router.go(-1)">
                                <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
                            </b-button>
                        </div>
                    </div> 
                </div>
              </div>
              <div class="myForn descriptionCollapse px-lg-5"> 
                <div class="text-left p-2">
                  <h5 class="m-0 pb-2 ml-3">Express Service</h5>
                </div>  
                <div class="row align-items-center">  
                  <div class="col-lg-12 col-md-12">
                    <div class="my_collapse_bg round-border purpose_radios  mb-3">
                      <label class="round-border pointer my_collapse"
                            v-b-toggle="'collapse-rush'"> 

                        <small><b>Is this a Express Service for this envelope?</b></small> 
                        <b-icon icon="chevron-down" aria-hidden="true"></b-icon>

                      </label>

                      <b-collapse  class="" id="collapse-rush" v-model="visible_rush">
                          <div class="w-100 mb-3 pl-3 bg-lightblue no-border text-left d-inline-flex align-items-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                {{rushNote}}
                             </span>     
                         </div>

                         

                      <div class="collaps_setting"> 
                           <div class=""> 
                            <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio-group v-model="selected_rush" :options="rush_options" :aria-describedby="ariaDescribedby" name="radio-stacked-rush" stacked ></b-form-radio-group>
                            </b-form-group>
                        </div> 
                      </div>                  
                     </b-collapse> 
                    </div>
                </div>
               </div>
              </div>
              <hr>
            <div class="myForn descriptionCollapse  p-lg-5">  
              <div class="text-left p-2 pb-3">
                <h5 class="m-0 p-0 ml-3">Description of <span v-if="$store.state.dataStore.main_chapter !== '600' && 'major_item' in $store.state.dataStore.selections[$store.state.dataStore.main_chapter]['procedure_details_1']
                ['options']">{{$store.state.dataStore.selections[$store.state.dataStore.main_chapter]['procedure_details_1']
                ['options']['major_item']}}</span>
                <span v-else-if="$store.state.dataStore.main_chapter == '600' && 'setting_type' in $store.state.dataStore.selections[$store.state.dataStore.main_chapter]['procedure_details_1']
                ['options']">

                {{$store.state.dataStore.selections[$store.state.dataStore.main_chapter]['procedure_details_1']
                ['options']['setting_type']}}

                </span>
                </h5>
              </div>   
            
                <div class="row p-0">  
                    <div class="col-lg-12">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                        <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush'"> 
                          <small><b>Description of item <strong class="text-danger ml-1">*</strong></b></small> 
                          <span v-if="!visible_item_description" class="text-warning">
                            {{item_description}}
                          </span>
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                        </label>

                            <b-collapse  class="" id="collapse-rush" v-model="visible_item_description">
                              <div class="form-group description_area">
                                <b-form-textarea
                                  class="sett_textarea round-border p-4"
                                  placeholder="Add Description"
                                  name="generic_description"
                                  :class="{
                                    'is-invalid': $v.item_description.$error,
                                  }"
                                  v-model.trim="$v.item_description.$model"
                                  @blur="$v.item_description.$touch"
                                ></b-form-textarea>

                                <!-- <b-form-textarea
                                  class="sett_textarea round-border p-4"
                                  placeholder="Add Description"
                                  name="generic_description"
                                  :class="{
                                    'is-invalid': $v.item_description.$error,
                                  }"
                                  v-model.trim="$v.item_description.$model"
                                  @blur="$v.item_description.$touch"
                                ></b-form-textarea>


                                <b-form-textarea
                                  class="sett_textarea round-border p-4"
                                  placeholder="Add Description"
                                  name="generic_description"
                                  :class="{
                                    'is-invalid': $v.item_description.$error,
                                  }"
                                  v-model.trim="$v.item_description.$model"
                                  @blur="$v.item_description.$touch"
                                ></b-form-textarea> -->
                            </div>                
                      </b-collapse> 
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                            <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush2'"> 

                              <small><b>Customer's stated value</b></small> 
                               <span v-if="!visible_customer_stated_value" class="text-warning">
                                {{customer_stated_value}}
                              </span>
                              <b-icon icon="chevron-down" aria-hidden="true"></b-icon>

                            </label>

                            <b-collapse  class="" id="collapse-rush2" v-model="visible_customer_stated_value">
                                  <div class="form-group addCurrency_icon">
                                    <b>$</b>
                                      <b-form-input
                                        type="text"
                                        class="round-border p-4"
                                        placeholder="Add value"
                                        name="customer_stated_value"
                                        :class="{
                                          'is-invalid': $v.customer_stated_value.$error,
                                        }"
                                        v-model.trim="$v.customer_stated_value.$model"
                                        @blur="$v.customer_stated_value.$touch"
                                      ></b-form-input>
                                      </div>
                                      <div
                                        class="invalid-feedback"
                                        v-if="!$v.customer_stated_value.required"
                                      >
                                        {{ $t("form.validation.required") }}
                                      </div>
                                      <div
                                        class="invalid-feedback"
                                        v-if="!$v.customer_stated_value.maxLength"
                                      >
                                        {{
                                          $t("form.validation.maxLength", {
                                            num: $v.customer_stated_value.$params.maxLength.max,
                                          })
                                        }}
                                    </div>                
                            </b-collapse> 
                          </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                        <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush3'"> 
                          <small><b>Photos</b></small> 
                          
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                        </label>
                        <b-collapse  class="" id="collapse-rush3" v-model="visible_image">
                          <div class="add_photo">

                            <vue-upload-multiple-image
                              @upload-success="uploadImageSuccess"
                              @data-change="dataChange"
                              @before-remove="beforeRemove"                                                                                                                                                                                                                                                                                                                          
                              @edit-image="editImage"
                              @limit-exceeded="limitExceeded"
                              :max-image=3
                              :placeholder="placeholder_text"
                            >
                            </vue-upload-multiple-image>

                          </div> 
                          <!-- <div id="my-strictly-unique-vue-upload-multiple-image" style="display: flex; justify-content: center;">
                            <vue-upload-multiple-image
                              @upload-success="uploadImageSuccess"
                              @before-remove="beforeRemove"
                              @edit-image="editImage"
                              @data-change="dataChange"
                              @limit-exceeded="limitExceeded"
                              ></vue-upload-multiple-image>
                          </div>              -->
                        </b-collapse> 
                      </div>
                    </div>

                    <div class="col-lg-6" v-if="!($store.state.dataStore.main_chapter == '1200' && 
                    $store.state.dataStore.selections[$store.state.dataStore.selectedChapter]['procedure_details_1']['options']['major_item'].toLowerCase().includes('appraisals'))">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                            <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush4                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      sh4'"> 
                              <small><b>Are any of these items not guranteed?</b></small>
                               <span v-if="!visible_is_guarranteed" class="text-warning">
                                <span v-if="is_guarranteed == 0">
                                  false
                                </span>
                                <span v-if="is_guarranteed == 1">
                                  true
                                </span>
                              </span>
                              <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                            </label>

                            <b-collapse  class="" id="collapse-rush4" v-model="visible_is_guarranteed">
                                  <!-- radios bttns  -->
                                <div class="my_collapse_bg round-border purpose_radios"> 
                                  <div class=" text-left"> 
                                    <div class=""> 
                                      <b-form-group v-slot="{ ariaDescribedby }">
                                          <b-form-radio-group v-model="is_guarranteed" :options="radio_options" :aria-describedby="ariaDescribedby" name="is_guarranteed" stacked ></b-form-radio-group>
                                      </b-form-group>
                                    </div> 
                                  </div> 
                                </div> 

                                <br>

                                <div class="form-group" v-if="is_guarranteed">
                                    <b-form-textarea
                                      class="sett_textarea round-border p-4"
                                      placeholder="Add Guarantee description"
                                      name="stones_guarrantee_description"
                                      :class="{
                                        'is-invalid': $v.stones_guarrantee_description.$error,
                                      }"
                                      v-model.trim="$v.stones_guarrantee_description.$model"
                                      @blur="$v.stones_guarrantee_description.$touch"
                                    ></b-form-textarea>
                                  </div>

                                  <div
                                    class="invalid-feedback"
                                    v-if="!$v.stones_guarrantee_description.required"
                                  >
                                    {{ $t("form.validation.required") }}
                                  </div>
                                  <div
                                    class="invalid-feedback"
                                    v-if="!$v.stones_guarrantee_description.maxLength"
                                  >
                                    {{
                                      $t("form.validation.maxLength", {
                                        num: $v.stones_guarrantee_description.$params.maxLength
                                          .max,
                                      })
                                    }}
                                  </div>
                            </b-collapse> 
                          </div>
                        </div>



                    <div class="col-lg-6">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                            <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush5'"> 

                              <small><b>Completion date</b></small> 
                               <span v-if="!visible_promise_date && promise_date" class="text-warning">
                                {{new Date(promise_date).toLocaleString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}}
                              </span>
                              <b-icon icon="chevron-down" aria-hidden="true"></b-icon>

                            </label>

                            <b-collapse  class="sett_calender" id="collapse-rush5" v-model="visible_promise_date">

                              
                              <div class="form-group">
                              <b-form-datepicker
                                id="date-picker-label"
                                v-model="promise_date"
                                class="round-border p-2 text-left"
                              ></b-form-datepicker>
                              </div>


                            </b-collapse> 
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="my_collapse_bg my_description round-border  mb-3">
                            <label class="round-border pointer my_collapse" v-b-toggle="'collapse-rush6'"> 
                              <small><b>Are any stones broken, chiped cracked flawed.</b></small> 
                              <span v-if="!visible_stones_quality_description" class="text-warning">
                                <span v-if="is_qualiteed == 0">
                                  false
                                </span>
                                <span v-if="is_qualiteed == 1">
                                  true
                                </span>
                              </span>
                              <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                            </label>

                            <b-collapse  class="sett_calender" id="collapse-rush6" v-model="visible_stones_quality_description">
                               <div class="my_collapse_bg round-border purpose_radios"> 
                                  <div class=" text-left"> 
                                    <div class="">
                                      <b-form-group v-slot="{ ariaDescribedby }">
                                        <b-form-radio-group v-model="is_qualiteed" :options="radio_options" :aria-describedby="ariaDescribedby" name="is_qualiteed" stacked ></b-form-radio-group>
                                      </b-form-group>
                                    </div> 
                                  </div> 
                                </div> 
                                <br>
                              <div class="form-group" v-if="is_qualiteed">
                                <b-form-textarea
                                  class="sett_textarea round-border p-4"
                                  placeholder="Add stone quality description"
                                  name="stones_quality_description"
                                  :class="{
                                    'is-invalid': $v.stones_quality_description.$error,
                                  }"
                                  v-model.trim="$v.stones_quality_description.$model"
                                  @blur="$v.stones_quality_description.$touch"
                                ></b-form-textarea>
                              </div>

                              <div
                                class="invalid-feedback"
                                v-if="!$v.stones_quality_description.maxLength"
                              >
                                {{
                                  $t("form.validation.maxLength", {
                                    num: $v.stones_quality_description.$params.maxLength
                                      .max,
                                  })
                                }}
                              </div>


                            </b-collapse> 
                      </div>
                    </div>



                    <div class="col-lg-12 pt-5">
                        <default-button
                      variant="warning"
                      text="  Confirm  "
                      class="d-inlie-block pl-5 pt-2 pb-2 pr-5"
                      @onSubmit="onSubmit()"
                    /> 
                    </div>
              </div>
         </div>
              <div class="col-md-12 d-none">
                <div class="text-center sett_stone_detail"> 
                  <div class="p-0 p-lg-5"> 
                    <div class="myForn">
                      <ul class="list-unstyled row">


                        <li class="pb-2 col-lg-6  col-md-6">
                          <label class="round-border pointer my_collapse">Description of item</label>
                          <div class="form-group">
                            <b-form-input
                              type="text"
                              class="round-border p-4"
                              placeholder="Add Description"
                              name="item_description"
                              :class="{ 'is-invalid': $v.item_description.$error }"
                              v-model.trim="$v.item_description.$model"
                              @blur="$v.item_description.$touch"
                            ></b-form-input>
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.item_description.required"
                          >
                            {{ $t("form.validation.required") }}
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.item_description.maxLength"
                          >
                            {{
                              $t("form.validation.maxLength", {
                                num: $v.item_description.$params.maxLength.max,
                              })
                            }}
                          </div>
                        </li>


                        <li class="pb-2  col-lg-6  col-md-6">
                          <label class="round-border pointer my_collapse">Customer's stated value</label>
                          <div class="form-group">
                          <b-form-input
                            type="text"
                            class="round-border p-4"
                            placeholder="Add value"
                            name="customer_stated_value"
                            :class="{
                              'is-invalid': $v.customer_stated_value.$error,
                            }"
                            v-model.trim="$v.customer_stated_value.$model"
                            @blur="$v.customer_stated_value.$touch"
                          ></b-form-input>
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.customer_stated_value.required"
                          >
                            {{ $t("form.validation.required") }}
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.customer_stated_value.maxLength"
                          >
                            {{
                              $t("form.validation.maxLength", {
                                num: $v.customer_stated_value.$params.maxLength.max,
                              })
                            }}
                          </div>
                        </li>

                        <li class="pb-2">
                          <label class="round-border pointer my_collapse">Are any stones broken, chiped cracked flawed.</label>

                          <div class="form-group">
                            <b-form-textarea
                              class="sett_textarea round-border p-4"
                              placeholder="Add Guarrantee description"
                              name="stones_quality_description"
                              :class="{
                                'is-invalid': $v.stones_quality_description.$error,
                              }"
                              v-model.trim="$v.stones_quality_description.$model"
                              @blur="$v.stones_quality_description.$touch"
                            ></b-form-textarea>
                          </div>

                          <div
                            class="invalid-feedback"
                            v-if="!$v.stones_quality_description.required"
                          >
                            {{ $t("form.validation.required") }}
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.stones_quality_description.maxLength"
                          >
                            {{
                              $t("form.validation.maxLength", {
                                num: $v.stones_quality_description.$params.maxLength
                                  .max,
                              })
                            }}
                          </div>
                        </li>

                        <li class="pb-2  col-lg-6  col-md-6">
                        <label class="round-border pointer my_collapse"> Are any of these items not guranteed? </label>
                        <div class="my_collapse_bg round-border purpose_radios"> 
                          <div class=" text-left"> 

                              <div class=""> 
                                <b-form-group v-slot="{ ariaDescribedby }">
                                <b-form-radio-group v-model="is_guarranteed" :options="radio_options" :aria-describedby="ariaDescribedby" name="radio-stacked" stacked ></b-form-radio-group>
                                </b-form-group>
                            </div> 
                          </div> 
                        </div> 
                        </li>
 
                        <li class="pb-2 sett_calender  col-lg-6  col-md-6">
                          <label class="round-border pointer my_collapse">Completion date</label> 
                          <div class="form-group">
                          <strong class="text-danger ml-1">*</strong>
  
                          <b-form-datepicker
                            id="date-picker-label"
                            v-model="promise_date"
                            class="round-border p-2 text-left"
                          ></b-form-datepicker>
                          </div>
                        </li>

                        <li class="pb-2 col-lg-12  col-md-12">
                          <label class="round-border pointer my_collapse">Are any stones broken, chiped cracked flawed? if so describe.</label>
                          <div class="form-group">
                            <b-form-textarea
                              class="sett_textarea round-border p-4"
                              placeholder="Add Guarrantee description"
                              name="stones_quality_description"
                              :class="{
                                'is-invalid': $v.stones_quality_description.$error,
                              }"
                              v-model.trim="$v.stones_quality_description.$model"
                              @blur="$v.stones_quality_description.$touch"
                            ></b-form-textarea>
                          </div>

                          <div
                            class="invalid-feedback"
                            v-if="!$v.stones_quality_description.required"
                          >
                            {{ $t("form.validation.required") }}
                          </div>
                          <div
                            class="invalid-feedback"
                            v-if="!$v.stones_quality_description.maxLength"
                          >
                            {{
                              $t("form.validation.maxLength", {
                                num: $v.stones_quality_description.$params.maxLength
                                  .max,
                              })
                            }}
                          </div>
                        </li>
                        <li>
                          
                        </li>
                        
                        
                      </ul>
                    </div>
                    
                    <default-button
                      variant="warning"
                      text="  Confirm  "
                      class="d-inlie-block pl-5 pt-2 pb-2 pr-5"
                      @onSubmit="onSubmit()"
                    />   
                  </div>
                </div>

               

              </div> 
            </div> 
      </div>


      <div class="myModel">
        <div>
          <b-modal id="what_task_to_perform" no-close-on-esc no-close-on-backdrop hide-header-close  
          header-border-variant="primary" footer-border-variant="primary" header-bg-variant="primary" footer-bg-variant="primary" body-bg-variant="primary" centered title="Job Description" >
          <p>Please mention what tasks to be performed in this repair</p>
              <!-- Emulate built in modal footer ok and cancel button actions -->
              <ul class="list-unstyled">
               <li class="pb-2 ">
                <div class="form-group">
                  <b-form-textarea
                    type="text"
                    class="round-border p-4"
                    placeholder="What task to perform for the job"
                    name="performed-job-description"
                    :class="{ 'is-invalid': $v.what_task_to_perform.$error }"
                    v-model.trim="$v.what_task_to_perform.$model"
                    @blur="$v.what_task_to_perform.$touch"
                  ></b-form-textarea>
                </div>
                <div
                  class="invalid-feedback"
                  v-if="!$v.what_task_to_perform.required"
                >
                  {{ $t("form.validation.required") }}
                </div>
                <div
                  class="invalid-feedback"
                  v-if="!$v.what_task_to_perform.maxLength"
                >
                  {{
                    $t("form.validation.maxLength", {
                      num: $v.what_task_to_perform.$params.maxLength.max,
                    })
                  }}
                </div>
              </li>
              </ul>
              <template #modal-footer>
                <div class="w-100">
                <default-button
                  variant="warning"
                  text="  Calculate Price  "
                  class="btn float-right round-border shadow-lg btn-success  mb-3"
                  @onSubmit="saveStaffGivenDescription()"
                    />  
                </div>
              </template>
          </b-modal>
        </div>
      </div>
    </div>
</template>

<script>
import VueUploadMultipleImage from 'vue-upload-multiple-image' 
import { mapGetters, mapActions } from "vuex";

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
import { WebCam } from "vue-web-cam";
import Input from "../../../components/Global/Input.vue";
export default {
  components: { Input, "vue-web-cam": WebCam , VueUploadMultipleImage },
  data() {
    return {
        selected_rush:this.$store.state.dataStore.is_rush,
      heading: "Take Photo",
      isCameraOpen: false,
      isPhotoTaken: false,
      isShotPhoto: false,
      isLoading: false,
      link: "#",
      selected: [], // Must be an array reference!
      subHeading: "Description of jewelry",
      alertMsg: "",
      showDismissibleAlert: false,
      alertMsg: "",
      variant: null,
      image: null,
      value: "",   
      preview: "assets/img_icon.png",
      image: null,
      preview_list: [],
      image_list: [],
      what_task_to_perform: this.$store.state.dataStore.what_task_to_perform,
      item_description: this.$store.state.dataStore.descriptionOfItem.item_description,
      customer_stated_value: this.$store.state.dataStore.descriptionOfItem.customer_stated_value,
      stones_quality_description: this.$store.state.dataStore.descriptionOfItem.stones_quality_description,
      stones_guarrantee_description:this.$store.state.dataStore.descriptionOfItem.stones_guarrantee_description,
      is_guarranteed: this.$store.state.dataStore.descriptionOfItem.is_guarranteed,
      is_qualiteed:this.$store.state.dataStore.descriptionOfItem.is_qualiteed,
      promise_date:  this.$store.state.dataStore.descriptionOfItem.promise_date,
      description_images:typeof this.$store.state.dataStore.descriptionOfItem.photos == 'object' ?  this.$store.state.dataStore.descriptionOfItem.photos : [],
      preview2: "assets/img_icon.png",
      preview3: "assets/img_icon.png",
      radio_options: [
        // radio
        { text: "Yes", value: 1 },
        { text: "No", value: 0 },
      ],
      visible_promise_date:false,
      visible_stones_quality_description:false,
      visible_image:false,
      visible_customer_stated_value:false,
      visible_item_description:false,
      visible_is_guarranteed:false,
      disabledImageUploading:false,
      placeholder_text:'Please Select 3 images',
      visible_rush:true,
      rushNote:"If YES, all charges are 50% higher - excluding any stones sold-chapter 1300",
      rush_options: [
          { text: 'Yes', value: true },
          { text: 'No', value: false },       
        ],
    };
  },
  mounted()
  {
    this.getDescriptionImages();
  },
  watch: 
  {
    // whenever question changes, this function will run
    is_guarranteed: function (newValue, oldValue) {
      if(newValue == 0)
      {
          this.stones_guarrantee_description = null;
      }
    },
    is_qualiteed: function (newValue, oldValue) {
      if(newValue == 0)
      {
          this.stones_quality_description = null;
      }
    },
  },
  validations: {
    item_description: {
      required,
      maxLength: maxLength(250),
    },
    what_task_to_perform: {
      required,
      maxLength: maxLength(250),
    },
    customer_stated_value: {
      maxLength: maxLength(100),
    },
    stones_quality_description: {
      maxLength: maxLength(500),
    },
    stones_guarrantee_description: {
      maxLength: maxLength(500),
    },
    promise_date:{
      required,
    }
  },
  methods: {
    ...mapActions("dataStore", ["setDescriptionOfItem",'setStaffGivenDescriptionOfItem','setPhotosOfDescription',
    'setIsRush']),

    getDescriptionImages()
    {
      // var images = []
      // var default_added = false;
      // this.$store.state.dataStore.descriptionOfItem.photos.forEach(function (val) {
      // if(!(typeof val == 'object'))
      // {
      // let obj = 
      // {
      // 'path':val,
      // 'default':!default_added ? 1 : 0,
      // 'highlight':0,
      // 'name':'default_name'
      // };
      // images.push(obj);
      // }
      
      // });
      // console.log('images',images);
      // this.description_images = images;
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
 
    /**
     * multiple image handling methods
     */
    uploadImageSuccess(formData, index, fileList) {
      console.log(formData, index, fileList);

      // Object.values(fileList).forEach(
      //   ([key, value]) => {
      //   console.log('key and value',key, value);
      //   if(key ==  'path')
      //   {
      //     var file = this.dataURLtoFile('data:text/plain;base64,aGVsbG8gd29ybGQ=','hello.txt');
      //     this.description_images.unshift(file);
      //   }
      // });

      Object.values(fileList).forEach(val => {
        console.log(val);
        Object.keys(val).forEach(property => {
          if(property ==  'path')
          {
            // let image = new Image();
            // image.src = val[property];
            // // document.body.appendChild(image);
            // var aFileParts = [image];
            // var blob = new Blob(aFileParts, {type : 'image/png'});
            // var file = this.dataURLtoFile(val[property]);
            // const byteCharacters = decodeURIComponent(escape(window.atob
            // const byteCharacters = atob(decodeURIComponent(val[property]));
            // const byteNumbers = new Array(byteCharacters.length);
            // for (let i = 0; i < byteCharacters.length; i++) {
            //     byteNumbers[i] = byteCharacters.charCodeAt(i);
            // }
            // const byteArray = new Uint8Array(byteNumbers);
            // const blob = new Blob([byteArray], {type: contentType});
            this.description_images.unshift(val[property]);
          }
        });
      });
    },
    beforeRemove (index, done, fileList) 
    {
      console.log('index', index, fileList)
      var r = confirm("remove image")
      if (r == true) 
      {
        done()
      } 
      else 
      {
      }
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    dataChange (data) {
      console.log(data)
    },
    limitExceeded(amount){
      console.log(amount)
    },
    dataURLtoFile(dataurl, filename)
    {
      // var arr = dataurl.split(','),
      // mime = arr[0].match(/:(.*?);/)[1],
      // bstr = atob(arr[1]), 
      // n = bstr.length, 
      // u8arr = new Uint8Array(n);
      // while(n--)
      // {
      //   u8arr[n] = bstr.charCodeAt(n);
      // }
      // return new File([u8arr], filename, {type:mime});

      // var image = new Image();
      // image.src = dataurl;
      // return image;
    },
    editImage (formData, index, fileList) {
      console.log('edit data', formData, index, fileList)
    },
    limitExceeded(amount){
      if(amount == 3) {
      disabledImageUploading = true;
      }
    },
    previewImages(e)
    {

      if (window.File && window.FileList && window.FileReader) {
            var files = e.target.files,
              filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
              var f = files[i]
              var fileReader = new FileReader();
              fileReader.onload = (function(e) {
                var file = e.target;
                // $("<span class=\"pip\">" +
                //   "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                //   "<br/><span class=\"remove\">Remove image</span>" +
                //   "</span>").insertAfter("#files");
                // $(".remove").click(function(){
                //   $(this).parent(".pip").remove();
                // });
              });
              fileReader.readAsDataURL(f);
            }
            console.log(files);

        } else {
          alert("Your browser doesn't support to File API")
        }
    },

    downloadImage(event) {
      var download = document.getElementById("downloadPhoto");
      const canvas = document
        .getElementById("photoTaken")
        .toDataURL("image/jpeg");
      download.setAttribute("href", canvas);
    },

    saveImage() {
      const canvas = document
        .getElementById("photoTaken")
        .toDataURL("image/jpeg");
      var reader = new FileReader();
      reader.onload = (e) => {
        this.preview = e.target.result;
      };
      // conversion base64 to blob
      var byteString = window.atob(canvas.split(",")[1]);
      var ab = new ArrayBuffer(byteString.length);
      var ia = new Uint8Array(ab);
      for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
      }
      this.image = new Blob([ab], { type: "image/jpeg" });
      // reading image so that it can be previewed.
      reader.readAsDataURL(this.image);
    },
    saveStaffGivenDescription()
    {
      this.$v.$touch();
      if (this.$v.$invalid) {
        let errorMsg = "";
        if (this.$v.what_task_to_perform.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Task to be performed "
            : "Staff given Item Description";
        }
        if (errorMsg !== "") {
          this.showAlert([
            this.$t("form.validation.mandatoryFieldsError", {
              errors: errorMsg,
            }),
            "danger",
          ]);
          return;
        }
      }
      this.isLoading = true;
      this.setStaffGivenDescriptionOfItem(this.what_task_to_perform);
      this.$router.push('/show-price').catch();
    },
    onSubmit() {
      var token = localStorage.getItem('token')

      if(this.selected_rush)
      this.setIsRush(this.selected_rush);

      console.log(this.$v);
      this.$v.$touch();
      if (this.$v.$invalid) {
        let errorMsg = "";

        if (this.$v.item_description.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Item Description"
            : "Item Description";
        }
        if (this.$v.promise_date.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Promise Date"
            : "Promise Date";
        }
        if (this.$v.customer_stated_value.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Customer Stated Value"
            : " Customer Stated Value";
        }
        if (this.$v.stones_quality_description.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Stone Quality Description"
            : "Stone Quality Description";
            if(!this.is_qualiteed)
            {
              errorMsg = errorMsg
            ? errorMsg + ", Is Qualiteed Radio Input"
            : "Is Qualiteed Radio Input";
            }
        }
        if (this.$v.stones_guarrantee_description.$error) {
          errorMsg = errorMsg
            ? errorMsg + ", Stone Guarrantee Description"
            : "Stone Guarrantee Description";
            if(!this.is_guarranteed)
            {
              errorMsg = errorMsg
            ? errorMsg + ", Is Guarranteed Radio Input"
            : "Is Guarranteed Radio Input";
            }
        }
        if (errorMsg !== "") {
          this.showAlert([
            this.$t("form.validation.mandatoryFieldsError", {
              errors: errorMsg,
            }),
            "danger",
          ]);
          return;
        }
      }
      this.isLoading = true;
      let data = new FormData();
      // data.append("repair_id", this.is_guarranteed);
      data.append("is_guarranteed", this.is_guarranteed);
      
      data.append(
        "stones_quality_description",
        this.stones_quality_description
      );
      data.append("customer_stated_value", this.customer_stated_value);
      data.append("item_description", this.item_description);
      data.append(
        "customer_email",
        this.$store.state.dataStore.customer_details['email']
      );
      data.append("envelope_id", this.$store.state.dataStore.envelope_numbers[this.$store.state.dataStore.selected_envelope_number]);
      data.append("photos", this.description_images);
      data.append("promise_date", this.promise_date);
      axios  
        .post("/api/store-item-in-care", {
          is_guarranteed:this.is_guarranteed,
          is_qualiteed:this.is_qualiteed,
          stones_quality_description:this.stones_quality_description,
          customer_stated_value:this.customer_stated_value,
          item_description:this.item_description,
          customer_email:this.$store.state.dataStore.customer_details['email'],
          envelope_id:this.$store.state.dataStore.envelope_numbers[this.$store.state.dataStore.selected_envelope_number],
          photos:this.description_images,
          promise_date:this.promise_date,
          stones_guarrantee_description:this.stones_guarrantee_description,
        },
        {
          headers: {
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => {
          var description = response.data.data;
          this.setDescriptionOfItem(description);
          // this.setPhotosOfDescription(this.description_images); 
          this.isLoading = false;
          this.showAlert(["Description added successfully.", "success"]);
          // this.$bvModal.show('what_task_to_perform');
          this.$router.push('/show-price').catch();
        })
        .catch((error) => {
          this.isLoading = false;
          if (error.response) 
          {
            if (error.response.data.errors) {
              let msg =
                error.response.data.errors[
                  Object.keys(error.response.data.errors)[0]
                ][0];
              this.showAlert([msg, "danger"]);
            }
          } else if (error.response.data.response_header.response_message) {
            this.showAlert([
              error.response.data.response_header.response_message,
              "danger",
            ]);
          } else {
            this.showAlert([error, "danger"]);
          }
        });
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
    previewImage2(event) {
      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview2 = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
    previewImage3(event) {
      var input = event.target;
      if (input.files) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview3 = e.target.result;
        };
        this.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
      }
    },
  },
};
</script>    
<style scoped lang="scss">

hr {
    border-color: rgb(138, 138, 158); /* Change to your desired color */
  }

.pictureForm {
  background-color: #333c73;
  // min-height: 200px;
}
.showImg {
  height: 110px;
  object-fit: cover; display: block;
}

.web-camera-container { 
  border-radius: 4px;
  width: 100%;

  .camera-button { 
  }

  .import_btn {
    position: relative;
    cursor: pointer;
  }
  .import_btn input {
    position: absolute;
    left: 0px;
    top: 0px;
    z-index: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
  }

  .camera-box {
    .camera-shutter {
      opacity: 0;
      width: 450px;
      height: 337.5px;
      background-color: #fff;
      position: absolute;

      &.flash {
        opacity: 1;
      }
    }
  }

  .camera-shoot {
    margin: 1rem 0;

    button {
      height: 60px;
      width: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 100%;

      img {
        height: 35px;
        object-fit: cover;
      }
    }
  }

  .camera-loading {
    overflow: hidden;
    height: 100%;
    position: absolute;
    width: 100%;
    min-height: 150px;
    margin: 3rem 0 0 -1.2rem;

    ul {
      height: 100%;
      position: absolute;
      width: 100%;
      z-index: 999999;
      margin: 0;
    }

    .loader-circle {
      display: block;
      height: 14px;
      margin: 0 auto;
      top: 50%;
      left: 100%;
      transform: translateY(-50%);
      transform: translateX(-50%);
      position: absolute;
      width: 100%;
      padding: 0;

      li {
        display: block;
        float: left;
        width: 10px;
        height: 10px;
        line-height: 10px;
        padding: 0;
        position: relative;
        margin: 0 0 0 4px;
        background: #999;
        animation: preload 1s infinite;
        top: -50%;
        border-radius: 100%;

        &:nth-child(2) {
          animation-delay: 0.2s;
        }

        &:nth-child(3) {
          animation-delay: 0.4s;
        }
      }
    }
  }

  @keyframes preload {
    0% {
      opacity: 1;
    }
    50% {
      opacity: 0.4;
    }
    100% {
      opacity: 1;
    }
  }
}
</style>


