<template>
    <div class="container pb-5"> 

    <div class="envelop_container text-center pt-5 mt-5"> 

        <h3 class="pb-5 text-uppercase">{{subHeading}}</h3>

        <div class="container"> 
            <div class="row mb-5">
              <div class="col-lg-3">
                 
              </div>
              <div class="col-lg-6">
                <div class="">
                  <ul class="list-unstyled">
                    <li><button class="btn btn-light round-border  mb-4 btn-lg btn-block pointer"  @click="chooseTechnology('torch')" >Torch</button></li>  
                    <li><button class="btn btn-light round-border  mb-4 btn-lg btn-block pointer"  @click="chooseTechnology('laser')" >Laser</button></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-3">
                 
              </div>
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
 
        </div>

    </div>
        <div class="myModel">
          <div>
            <b-modal id="modal-center"   header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"   header-bg-variant="primary"   footer-bg-variant="primary" :visible="showModal" centered title="Order Picklist"  @hide="$store.commit('dataStore/setpicklistmodal', false)">
            <p>Do you want to add this to stuller order picklist?</p>
              
              <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button class="btn round-border btn-success " size="sm" variant="success" @click="ok()">
                  Yes
                </b-button>
                <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="cancel()">
                  No
                </b-button>
             </template>

            </b-modal>
          </div>
        </div>

        <div class="myModel">
          <div>
            <b-modal id="modal-center"   header-border-variant="primary" footer-border-variant="primary" body-bg-variant="primary"   header-bg-variant="primary"   footer-bg-variant="primary" :visible="showModalRhodiumPlating" centered title="Order Picklist"  @hide="$store.commit('dataStore/setpicklistmodal', false)">
            <p>White gold items after being polished are typically get Rhodium plated. Shall we Rhodium plate the item?</p>
              <template #modal-footer>
                <!-- Emulate built in modal footer ok and cancel button actions -->
                <b-button class="btn round-border btn-success " size="sm" variant="success" @click="rhodiumPlate()">
                  Yes
                </b-button>
                <b-button class="btn round-border btn-success active_btn" size="sm" variant="success" @click="cancelRhodiumPlate()">
                  No
                </b-button>
             </template>
            </b-modal>
          </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from 'vuex'; 
  export default {
    data() {
      return {
        selected: [], // Must be an array reference!  
        subHeading:"Sizing using a laser or torch?" ,
        infoNote:"Laser charges are 50% higher"
      }
    },
    computed: {

        // mix the getters into computed with object spread operator
        showModal() {
          return this.$store.state.dataStore.show_modal;
        },
        showModalRhodiumPlating() {
          return this.$store.state.dataStore.show_modal_rhodium;
        }
        
    },
    methods:{
      ...mapActions('dataStore',['setrhodiumplatingmodal','setpicklistmodal','setWeldingTechnology','setpicklistItem','setRhodiumPlate']),

      chooseTechnology(technology){

        this.setWeldingTechnology([null,technology]);
        if(this.$store.state.dataStore.picklist_exists)
          this.setpicklistmodal(true);
        else{
        
          // check if stone work requires
          
        // check if stone work required
          axios.get('/api/get-labor-requiring-chapters').then(response=>{
            if(response.data){
              var stone_requiring_chapters = response.data.data.stone_chapters;     
              var solder_requiring_chapters = response.data.data.solder_chapters;     
              if((Object.values(stone_requiring_chapters)).includes(Number(this.$store.state.dataStore.selectedChapter)) || 
              (Object.values(solder_requiring_chapters)).includes(Number(this.$store.state.dataStore.selectedChapter))){
                this.$router.push("/stone-soldering-details").catch(()=>{});  
              }else{
                this.$router.push("/description-of-item").catch(()=>{});  
              }
            }
          }).catch(error=>{
          }); 
        }
      },
      ok(){
 
        this.setpicklistmodal(false);
        this.setpicklistItem(true);                  
      },
      cancel(){

        this.setpicklistmodal(false);
        this.setpicklistItem(false);        
                  
      },
      rhodiumPlate(){

        this.setRhodiumPlate(true); 
        this.setrhodiumplatingmodal(false);
                  
      },
      cancelRhodiumPlate(){

        this.setrhodiumplatingmodal(false);

      }
    }
  }
</script>    