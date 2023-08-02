<template>
  <div class="container pb-5"> 
    <span class="home_splash"><img src="assets/jewelry.png" class="" alt="..." /></span>
    <div class="pt-5">
      <div class="row">
      <div class="vld-parent" v-show="$store.state.dataStore.isLoading">
        <loading :active.sync="$store.state.dataStore.isLoading" :is-full-page="true" loader="dots" color="#36a142"></loading>
      </div>
        <!-- <div class="col-md-3"></div> -->
        <div class="col-md-12">
            <div class="">
              <!-- <div class="text-center mb-5">
                  <h3>Choose First</h3>
              </div> -->
              <div class="row">
                <div class="col-lg-2 col-md-2">
                </div>
                <div class="col-lg-8 col-md-8">
                  <div class="p-5 text-center my_collapse_bg collapse_setting_customer camSetting d-flex flex-column customer-buttons">
                    <div class="dropdown myDropdown">
                      <!-- {{selected_sale_person}}
                      <b-dropdown v-model="selected_sale_person" id="dropdown-1" text="Choose Sale Person" class="">
                        <b-dropdown-item  @click="selectSalePerson(sale_person)" 
                        v-for="sale_person in sale_staff" :key="sale_person.id">
                        <span>{{sale_person.text}}</span></b-dropdown-item>
                      </b-dropdown>
{{sale_staff}} -->
<b-form-select class="custom-select" v-model="selected_sale_person" :options="sale_staff"></b-form-select>
<!-- <b-form-select v-model="selected_sale_person" @change="selectSalePerson">
  <template v-slot:first>
    <option value="">Choose Sale Person</option>
  </template>
  <option style="background-color:black;" v-for="sale_person in sale_staff" :value="sale_person">{{ sale_person.text }}</option>
</b-form-select> -->

                    </div>
                  </div>
                  <div class="pb-4"></div>
                  <div class="pt-5 text-center my_collapse_bg collaps_setting_customer camSetting d-flex flex-column customer-buttons"
                        :class="$store.state.dataStore.sale_person_id ? '' : 'disable_div'" v-if="$store.state.dataStore.sale_person_id">
                    <router-link :to="{name:'add-new-customer'}" class="btn round-border shadow-lg btn-success  mb-3"
                    :class="$store.state.dataStore.sale_person_id ? '' : 'disable_div'"> 
                      Add new customer 
                    </router-link>
                    <router-link :to="{name:'customer-list'}" class="btn round-border shadow-lg btn-success"
                    :class="$store.state.dataStore.sale_person_id ? '' : 'disable_btn'"> Choose from database </router-link>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2">
                </div>
              </div>
            </div>
        </div>
        <!-- <div class="col-md-3"></div> -->
      </div>
    </div>
  </div>
</template>


<style scoped>

</style>


<script>
import { mapGetters, mapActions } from 'vuex'; 
import Loading from 'vue-loading-overlay';
export default {
  components: { 
  'loading':Loading },
    data() {
      return {
        jewelers: [{ value: null, text: 'Select Jeweler' }],
        showDismissibleAlert: false,
        alertMsg: "",
        variant: null,
        sale_staff: [{ id: 0, text: 'Select Sale Person' }], // Default option],
        selected_sale_person:null
      }
    },
    beforeMount() {
    this.checkIfSopExist();
  },

    mounted(){

        // session is being cleared as flow is being started from very start to start service.
        // this.checkForDevices();
        // this.getJewelers();
        this.getSaleStaff();
    },
    computed: {
        jeweler_id: function() {
            return this.$store.state.dataStore.jewelerId;
        },
    },
  watch: {
    
    selected_sale_person: {
        handler(newVal) {
          if(newVal)
          {
            console.log(newVal,'newV')
            this['dataStore/bindSalePerson'](newVal);

          }else if(newVal == null){
            this['dataStore/bindSalePerson'](newVal);
          }
        },
        deep: true,
      },
  },
    methods:{
      ...mapActions(['dataStore/selectTheJeweler','dataStore/setShop','dataStore/bindSalePerson','dataStore/setLoader']), 

      selectSalePerson(sale_person)
      {
        this.selected_sale_person = sale_person.value;
        this['dataStore/bindSalePerson'](sale_person.value);
      },


      /**
       * Fetch Jewelers
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

      /**
       * Fetch salestaff
       */

      getSaleStaff(value) 
      {
        this['dataStore/setLoader'](true);
        axios.get('/api/get-sale-staff-of-shop',{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}}).then(response=>{
          // this.isLoading = false;
          console.log(response.data);
          var sale_staff = response.data.data.data;  
          console.log(sale_staff); 
          for (const person of sale_staff) 
          {
            this.sale_staff.push({'value': person.id, "text": person.fullname});          
          }  
        this['dataStore/setLoader'](false);
          console.log(this.sale_staff);
        });

        

      },
      selectJeweler(){
        
        this.disabledLink = false; 
        this['dataStore/selectTheJeweler'](this.selected_to);

      },

      addNewCustomer(){
        this.$router.push({
        name:'add-new-customer'
        });
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

        checkIfSopExist() 
        {
        //check if user details are filled.
        var shop =  null;
        var context = this;

        axios.get('/api/get-shop',{headers: {'Authorization': 'Bearer ' + localStorage.getItem('token')}})
        .then(response=>{
        shop = response.data.data;
        console.log('shop');
        console.log(shop);
        setTimeout(function() {
          if(!shop){
            context.$router.push('/personal-information')
          }else{
            context.$store.dispatch('dataStore/setShop', shop);
            // this['dataStore/setShop'](shop);
          }
        }, 300);        
        }).catch(error=>{
        context.$router.push('/personal-information')
        });
        },
    },   
 
}
</script>
<style scoped>
.custom-select .dropdown-item {
  background-color: black !important;
  color: white !important;
}
</style>
 