<template>
<div class="container pb-5"> 

    <div class="envelop_container text-center"> 
        <!-- <h3 class="pb-4 text-uppercase">{{subHeading}}</h3> -->
        <div class="container"> 
            <div class="row">
              <div class="col-lg-12 p-0"> 
                <div class="sett_stone_detail text-left">
                  <div class="p-0 p-lg-5 mt-5 mt-lg-0">
                    <div class="row pb-3">
  <div class="col-lg-12 text-left pb-2">
    <div class="d-flex align-items-center">
      <div class="mr-3">
        <b-button :variant="variant" class="round-border backBtn" @click="$router.go(-1)"> 
          <b-icon icon="chevron-left" aria-hidden="true"></b-icon>
        </b-button>
      </div>
      <h4 class="m-0">Number of envelopes</h4>
    </div>
  </div>
</div>

                    


                    <div class="my_collapse_bg round-border purpose_radios  mb-3">
                      <label class="round-border pointer my_collapse" v-b-toggle="'collapse-envelope'"> 
                        <small><b>Is this going to be One Envelope?</b></small> 
                          <b-icon icon="chevron-down" aria-hidden="true"></b-icon>
                      </label> 

                      <b-collapse id="collapse-envelope" v-model="visible_envelope" class="">
                      <div class="collaps_setting"> 
                           <div class=""> 
                            <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio-group v-model="is_selected_envelope_one" :options="envelope_options" :aria-describedby="ariaDescribedby" name="radio-stacked-envelopes" stacked ></b-form-radio-group>
                            </b-form-group>
                        </div> 
                      </div>
                     </b-collapse>
                    </div>

                    <div class="my_collapse_bg round-border purpose_radios  mb-5" v-if="show_no_of_envelopes_collapse">
                      <!-- <div class="collaps_setting"> -->
                      <label class="round-border pointer my_collapse" v-b-toggle="'collapse-no-of-envelope'"> 

                        <small><b>How Many Job Envelopes?</b>  
                        </small> 
                        <b-icon icon="chevron-down" aria-hidden="true"></b-icon>

                      </label> 

                      <b-collapse id="collapse-no-of-envelope" v-model="visible_no_of_envelope" class="">
                          <div class="mb-3 pl-3 bg-lightblue no-border text-left d-inline-flex align-items-center justify-content-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                {{envelope_note}}
                             </span>     
                         </div>

                       <div class="collaps_setting"> 
                        <div class="mb-4"> 
                            <b-form-group v-slot="{ ariaDescribedby }">
                            <b-form-radio-group v-model="requested_envelopes" :options="no_of_envelopes_options" :aria-describedby="ariaDescribedby" name="radio-stacked" stacked ></b-form-radio-group>
                            </b-form-group>
                        </div> 
                        <!-- <div class="mb-3">
                            <span><b>{{subHeadingEnvlop}}</b></span>
                        </div>
                        <div class="mb-3 bg-lightblue no-border text-left d-inline-flex align-items-center justify-content-center flex-nowrap">
                            <div  class="my-auto mr-3">
                                <h5><b-icon icon="info-circle" variant="warning"></b-icon></h5>
                            </div>
                             <span class="text-warning">
                                {{new_customer_note}}
                             </span>     
                         </div> -->
                        <!-- <div class=" mt-3 mb-3">
                          <div class="pb-6"> 
                              <b-form-group v-slot="{ ariaDescribedby }">
                              <b-form-radio-group v-model="$store.state.dataStore.shall_we_duplicate_customer" :options="duplicate_customer" :aria-describedby="ariaDescribedby" name="radio-inline" ></b-form-radio-group>
                              </b-form-group>
                          </div>
                         </div> -->
                         
                      </div>
                     </b-collapse> 
                    <!-- </div> -->
                    </div>
                     <div class="text-center w-100">
                       <button @click="submitJobInitialDetails()" class="btn round-border shadow-lg btn-warning">Submit</button>
                    </div>
                  </div> 
                </div>
              <!-- <div class="col-lg-1">   
              </div> -->
            </div>
          </div>
        </div> 
      </div>
    </div>

</template>
<style scoped>

</style>
<script>

import { mapGetters, mapActions } from 'vuex'; 
export default {

    data() {
      return {
        jewelers: [{ value: null, text: 'Select Jeweler' }],
        envelope_note:'Contents of each envelope go to single station, location or craftsperson.if customer has items to be fixed/repair and will go to different locations/people.make a new envelop of each.Many repair can be placed in the same envelop if one jeweler will repair all. Sizing a ring and repairing a watch will go to different locations and require same envelops. ',
        is_selected_envelope_one: true,
        selected_rush:this.$store.state.dataStore.is_rush,
        showDismissibleAlert: false,
        alertMsg: "",
        variant: null,
        // radio switch
        selected: [],
        options: [
          { text: '', value: '' }
        ],
        envelope_options: [
    
            { text: 'Yes', value: true },
            { text: 'No', value: false },  

        ],
        rush_options: [
    
            { text: 'Yes', value: true },
            { text: 'No', value: false },       
        ],

        selected_to: null, 
        jewelers: [{ value: null, text: 'Select Jeweler' }],
        note:'Contents of each envelope go to single station, location or craftsperson.if customer has items to be fixed/repair and will go to different locations/people.make a new envelop of each.Many repair can be placed in the same envelop if one jeweler will repair all. Sizing a ring and repairing a watch will go to different locations and require same envelops. ',
        selected: [], // Must be an array reference! 
        disabledLink:true,
        subHeading:"Purpose of Job" ,
        isShow: true,  
        showCollapse:true,
        value:false,
        visible_envelope:true,
        visible_no_of_envelope:true,
        visible_rush:true,
        no_of_stones:null,
        new_customer_note:"For a new customer please start a new job then",
        no_of_envelopes_options: [
          { text: 'Two',   value: 2},
          { text: 'Three', value: 3},
          { text: 'Four',  value: 4},
          { text: 'Five',  value: 5},
        ],
        duplicate_customer: [
          // radio
          { text: 'Yes', value: true },
          { text: 'No', value: false },
        ],
        heading:"How Many Job Envelopes?",
        subHeadingEnvlop:"Shall we duplicate the same customer on each?",
        rushNote:"If YES, all charges are 50% higher - excluding any stones sold-chapter 1300",
        show_no_of_envelopes_collapse:false,
      }
    },

    mounted(){

      // session is being cleared as flow is being started from very start to start service.
      // this.checkForDevices();
      // this.getJewelers();

    },
    computed: {
        jeweler_id: function() 
        {
            return this.$store.state.dataStore.jewelerId;
        },
        customer_email: function() 
        {
            return this.$store.state.dataStore.customer_details['email'];
        },
        requested_envelopes: {
        get () {
            return this.$store.state.dataStore.requested_envelopes
        },
        set (value) {
          this.$store.commit('dataStore/setNoOfRequestedEnvelopes', value)
        }
      },
    },
    // watch: {
    //     '$store.state.dataStore.requested_envelopes': function() {
    //        console.log(this.$store.state.dataStore.requested_envelopes);
    //     },
    // },
  watch: {
    // whenever question changes, this function will run
    is_selected_envelope_one: function (newValue, oldValue) {
      if(newValue == false){
          // meanse there are multiple envelopes.
          this.show_no_of_envelopes_collapse = true;
      }else{
          this.show_no_of_envelopes_collapse = false;
      }
    }
    },
    methods:{
      ...mapActions('dataStore', [ 'selectTheJeweler','resetState','setIsRush','addProcedureDetailsToSelections',
                                   'getEnvelopeNumbers','shallWeDuplicateTheCustomer','allowEnvelopes',
                                   'addProcedureDetailsToNextOptions','fetchFlow','getFlowOptions','resetExtraWorkDetailsStructure']),

      /**
       * Fetch Permissions
       */

      getJewelers(value) {
        axios.get("/api/get-jewelers-of-shop").then(response=>{
          // this.isLoading = false;
          var jewelers = response.data.data;   
          for (const jeweler of jewelers) {
            this.jewelers.push({'value': jeweler.id, "text": jeweler.fullname});          
          }  
        });
      },
      selectJeweler(){
        
        this.disabledLink = false; 
        this.selectTheJeweler(this.selected_to); 

      },

      submitJobInitialDetails(){ 
        var state = this.$store.state.dataStore;
        console.log(this.customer_email)
           if( this.customer_email){
            
              if(!this.is_selected_envelope_one)
              {
                this.shallWeDuplicateTheCustomer(this.$store.state.dataStore.shall_we_duplicate_customer);
                this.allowEnvelopes(this.$store.state.dataStore.requested_envelopes);
              }
              if(state.current_cycle == 1)
              {
                this.getEnvelopeNumbers();
              }

            this.$router.push(
              {
                name:'find-sku'
              }
            );
        }else{
            this.showAlert(['Please select the customer first.', "danger"]);
            this.$emit('showAlert',['Please select the customer first.','danger']);
        }
        
      },

    
        // checkForDevices(){
        //     navigator.mediaDevices.enumerateDevices()
        //     .then(function(devices) {
        //         devices.forEach(function(device) {
        //         var user_media = navigator.mediaDevices.getDisplayMedia();
        //         });
        //     });
        // },


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
    },
    
    
}
</script>
 