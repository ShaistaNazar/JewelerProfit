<template>
    <div class="container pb-5">
<!-- 
    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-4 text-uppercase">{{subHeading}}</h3>

        <div class="container"> 
            <div class="row">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">

                  <li><button disabled class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" @click="getChapterFlow(100, 'jewelery-repair-100','option')">100 -<small> Sizing/Shanks/Adjustable shanks/sizing assistants/Solitaires</small></button></li>
                  <li><button  class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" @click="getChapterFlow(200, '/flow-option','option')">200 -<small> Tips/Prongs/Channel repair</small></button></li>
                  <li><button  class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" @click="getChapterFlow(300, '/main-menu')">300 -<small> Clasps/Figure 8's</small></button></li>
                 
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
              </div>
            </div>
        </div>
    </div> -->
    </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'; 
  export default {
    
    data() {
      return {
        selected: [], // Must be an array reference! 
        radio_options: [], 
        subHeading:"Jewelry Repair" 
      }
    },
    mounted(){

    },
    methods:{

      ...mapActions('dataStore', ['fetchFlow','setSelectedChapter',
                                  'getEnvelopeNumbers','getFlowOptions']), 

      /**
      * Fetch 300 menu clasps
      */

      getChapterFlow(chapter,link,redirected_to) {
        
        this.setSelectedChapter(chapter);
        // it should only call if cycle is not been reset.
        if(this.$store.state.dataStore.current_cycle == 1){
          this.getEnvelopeNumbers(chapter);
        }

        // if not main menu with images
        if(redirected_to == 'option'){

          this.$store.dispatch("dataStore/fetchFlow", {
          chapter:chapter
          }).then(response => {
            this.getFlowOptions();
          },error =>{

          });

        }
        this.$router.push(link);
        
      },
    }
  }
</script>  