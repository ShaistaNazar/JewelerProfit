<template>
    <li><button class="btn btn-light round-border  mb-4 btn-lg btn-block pointer" @click="startChapterFlow(300, 'main-menu')">300 -<small> Clasps/Figure 8's</small></button></li>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'; 
export default {
    methods:{
        ...mapActions('pricingFlow', [ 'setNextOption' ]), 
        /**
         * show options of next selection
         */
        showNextOption(){
            //
        }
    },
    computed:{
        ...mapGetters('pricingFlow', [
      'getSelectedFlow',
      'anotherGetter',
      // ...
    ])
    }
}
</script>