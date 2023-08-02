<template>
    <div class="container pb-5">

    <div class="envelop_container text-center">
        <h3 class="pb-3">{{heading}}</h3>

        <div class="pb-5">
          <b-form-group  v-slot="{ ariaDescribedby }" >
              <b-form-checkbox-group v-model="$store.state.dataStore.requested_envelopes" :options="no_of_envelopes" :aria-describedby="ariaDescribedby" name="flavour-1a" ></b-form-checkbox-group>
          </b-form-group>
        </div>

        <h3 class="pb-4 text-uppercase">{{subHeading}}</h3>

        <div class="pb-6"> 
            <b-form-group v-slot="{ ariaDescribedby }">
            <b-form-radio-group v-model="$store.state.dataStore.shall_we_duplicate_customer" :options="duplicate_customer" :aria-describedby="ariaDescribedby" name="radio-inline" ></b-form-radio-group>
            </b-form-group>
        </div>

        <div class=" mt-5 mb-5" :class="$mq">
            <div class="bg-lightblue no-border text-small text-left d-inline-flex align-items-center justify-content-center flex-nowrap">
            <div  class="my-auto mr-3">
                <b-icon icon="info-circle-fill" variant="light"></b-icon>
            </div>
            <small>
                {{infoNote}}
            </small>
            </div>
        </div>

        <default-button variant="success" text="  Next  " class="d-inlie-block pl-5 pr-5" @onSubmit="onSubmit()"/>

      </div>
    </div>
</template>

<script>

  import {mapActions} from 'vuex';
  export default {
    data() {
      return {
        no_of_envelopes: [

          { text: 'TWO',   value: 2},
          { text: 'THREE', value: 3},
          { text: 'FOUR',  value: 4},
          { text: 'FIVE',  value: 5},

        ],

        duplicate_customer: [
          // radio
          { text: 'Yes', value: true },
          { text: 'No', value: false },
        ],
        heading:"How Many Job Envelopes?",
        subHeading:"Shall we duplicate the same customer on each?",
        infoNote:"For a new customer please start a new job then",
      }
    },
    
    methods:{
      ...mapActions('dataStore', [ 'shallWeDuplicateTheCustomer','allowEnvelopes' ]), 
      onSubmit(){

        this.shallWeDuplicateTheCustomer(this.$store.state.dataStore.shall_we_duplicate_customer);
        this.allowEnvelopes(this.$store.state.dataStore.requested_envelopes);

        this.$router.push({
          name:'rush-job'
        });
        
      }
    }
  }
</script>  