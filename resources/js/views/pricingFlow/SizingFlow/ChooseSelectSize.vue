<template>
    <div class="container pb-5">

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-5 text-uppercase">{{subHeading}}</h3>

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-4">
                 
              </div>
              <div class="col-lg-4">
                <div class="">
                  <ul class="list-unstyled">
                    <li class="mb-4">

                      <b-form-select v-model="selected_form"  :options="options_from" class="round-border"></b-form-select>

                    </li>
                    <li class="mb-5">

                      <b-form-select v-model="selected_to" :options="options_to" class="round-border"></b-form-select>

                    </li>
                     
                  </ul>

                  <default-button variant="success" text="  Continue  " class="d-inlie-block pl-5 pr-5" @onSubmit="onSubmit()"/>
                </div>
              </div>
              <div class="col-lg-4">
                 
              </div>
            </div>
        </div>
    </div>

    </div>
</template>
<script>
  export default {
    data() {
      return {
        subHeading:"Select Size"  ,
        selected_form: null,
        selected_to: null,

        options_from: [
          { value: null, text: 'Size Now' },
          { value: '5', text: '5' },
          { value: '5 1/4', text: '5 1/4' },
          { value: '5 1/3', text: '5 3/4' },
          { value: '5 1/2', text: '5 1/2' },
          { value: '6', text: '6' },
          { value: '6 1/2', text: '6 1/2' },
          { value: '7', text: '7' },
          { value: '7 1/2', text: '7 1/2' },
          { value: '8', text: '8' },
          { value: '8 1/2', text: '8 1/2' },
          { value: '9', text: '9' },
          { value: '9 1/2', text: '9 1/2' },
          { value: '10', text: '10' },
          { value: '10 1/2', text: '10 1/2' },
          { value: '11', text: '11' },
          { value: '11 1/2', text: '11 1/2' },
          { value: '12', text: '12' },
          { value: '12 1/2', text: '12 1/2' },
          { value: '13', text: '13' },
          { value: '13 1/2', text: '13 1/2' }, 
          { value: '14', text: '14' },
          { value: '14 1/2', text: '14 1/2' },
          { value: '15', text: '15' } 
        ],
        options_to: [
          { value: null, text: 'Size To' },
          { value: '5 1/4', text: '5 1/4' },
          { value: '5 1/3', text: '5 3/4' },
          { value: '5 1/2', text: '5 1/2' },
          { value: '6', text: '6' },
          { value: '6 1/2', text: '6 1/2' },
          { value: '7', text: '7' },
          { value: '7 1/2', text: '7 1/2' },
          { value: '8', text: '8' },
          { value: '8 1/2', text: '8 1/2' },
          { value: '9', text: '9' },
          { value: '9 1/2', text: '9 1/2' },
          { value: '10', text: '10' },
          { value: '10 1/2', text: '10 1/2' },
          { value: '11', text: '11' },
          { value: '11 1/2', text: '11 1/2' },
          { value: '12', text: '12' },
          { value: '12 1/2', text: '12 1/2' },
          { value: '13', text: '13' },
          { value: '13 1/2', text: '13 1/2' }, 
          { value: '14', text: '14' },
          { value: '14 1/2', text: '14 1/2' },
          { value: '15', text: '15' } 
        ],
      }
    },
    methods:{
      onSubmit(){
        
      }
    }
  }
</script>    