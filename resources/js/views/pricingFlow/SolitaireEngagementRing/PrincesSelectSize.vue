<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 

        <!-- <h3 class="pb-5 text-uppercase">{{subHeading}}</h3> -->

        
        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-4">
                 
              </div>
              <div class="col-lg-4">
                <div class="">
                  <ul class="list-unstyled">
                    <li class="mb-5 pb-5">

                      <b-form-select v-model="selected_form"  :options="options_from" class="round-border"></b-form-select>

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
        //subHeading:"Repair fingermate"  ,
        selected_form: null, 

        options_from: [
          { value: null, text: 'Size' },
          { value: '5', text: '5' },
          { value: '5 1/4', text: '5 1/4' },
          { value: '5 1/3', text: '5 3/4' },
          { value: '5 1/2', text: '5 1/2' },
          { value: '6', text: '6' },
          { value: '6 1/2', text: '6 1/2' }, 
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