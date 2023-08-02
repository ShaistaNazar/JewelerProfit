<template>
    <div class="container pb-5"> 
      <div class="envelop_container text-center pt-5 mt-5"> 
          <h3 class="pb-5 text-uppercase">Choose {{Object.keys($store.state.dataStore.next_options)[$route.params.option]}}</h3>
          <div class="container"> 
              <div class="row mb-5">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                  <div class="">
                    <ul class="list-unstyled">
                      {{Object.values($store.state.dataStore.next_options[$route.params.option])}}
                      <li
                        v-for="(option,index) in Object.values($store.state.dataStore.next_options[$route.params.option])"
                        :key="index" @click="moveToNextOption(option)">
                        <button class="btn btn-light round-border mb-4 btn-lg btn-block pointer" v-if="option">
                          {{option}}
                        </button>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-lg-3">
                </div>
              </div>
          </div>
      </div>
    </div>
</template>
<script>
import { mapState } from 'vuex'
import { mapGetters, mapActions } from 'vuex'; 

  export default {
    data() {
      return {
        selected: [], // Must be an array reference!  
         // subHeading:"Choose Karats",
        // options:this.$store.state.dataStore.next_options
      }
    },
    // watch: {
    // "$route.params.id"(val) {
    //   // call the method which loads your initial state
    //   this.getFlowOptions(this.$route.params.option);
    // },
    // },
    computed: {

    // mix the getters into computed with object spread operator
    ...mapState('dataStore',['getNextOptions']),

      showModal() {
        return this.$store.state.dataStore.show_modal;
      },
      options(){
        $new_options = Object.values(this.$store.state.dataStore.next_options)[0] 
      }
         
    },
    mounted(){
    },
    methods:{
      ...mapActions('dataStore', [ 'getFlowOptions','addtoSelection','setpicklistItem' ]),
      moveToNextOption(option){

        // 1st Approach
        // showing selections 
        var obj = {};
        var column = this.$store.state.dataStore.chapterFlow[this.$store.state.dataStore.selectedFlow];
        var val = option;
        obj[column] = val;
        this.addtoSelection(obj);
        var option = this.$route.params.option;
        this.getFlowOptions(option);

      },
    }
  }
</script>   
<style scoped>
.myModel .modal-title { color: #000;}
</style> 