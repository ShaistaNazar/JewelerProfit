<template>
    <div class="container pb-5">

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-4 text-uppercase">{{subHeading}}</h3>

        <div class="pb-6"> 
            <b-form-group v-slot="{ ariaDescribedby }">
            <b-form-radio-group v-model="selectedRadio" :options="radio_options" :aria-describedby="ariaDescribedby" name="radio-inline" ></b-form-radio-group>
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
import { mapGetters, mapActions } from 'vuex'; 
  export default {
    data() {
      return {
        selected: [], // Must be an array reference! 
        radio_options: [
            // radio    
            { text: 'Yes', value: 1 },
            { text: 'No', value: 0 },       
        ], 
        subHeading:"Is this a Rush Job?",
        selectedRadio: 0,
        infoNote:"If YES, all charges are 50% higher - excluding any stones sold-chapter 1300"
      }
    },
    methods:{
      ...mapActions('dataStore', [ 'setIsRush']), 
      onSubmit(){
        this.setIsRush(this.selectedRadio);
        this.$router.push({
        name:'find-sku'
        })
      }
    }
  }
</script>  