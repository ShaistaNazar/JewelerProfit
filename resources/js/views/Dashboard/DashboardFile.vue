<template>
    <div class="container   mx-auto">
        <man-with-heading heading="Chapters"/>

        <div class="main_dashboard">
            <div class="row pt-3 pb-5">  
                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('100')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 100</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('200')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 200</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('300')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 300</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('400')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 400</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('500')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 500</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('600')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 600</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('700')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 700</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning" @click="goToChapter('800')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 800</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning"  @click="goToChapter('900')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 900</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning"  @click="goToChapter('1000')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 1000</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning"  @click="goToChapter('1100')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 1100</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning"  @click="goToChapter('1200')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 1200</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning"  @click="goToChapter('1300')">  
                        <span><img src="assets/settings.png" alt="1" /></span> 
                        <strong>Chapter 1300</strong>
                    </div>
                </div>

                <!-- <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning">  
                        <span><img src="assets/settings.png" alt="1" /></span>
                        <strong>Chapter 100</strong>
                    </div>
                </div>

                <div class="col-md-3 col-lg-3">
                    <div class="chaptersFiles text-warning">  
                        <span><img src="assets/settings.png" alt="1" /></span> 

                        <strong>Chapter 100</strong>
                    </div>
                </div> -->
                
            </div> 
 
        </div>
 

    </div>
</template>

<script> 
    export default {
        components:{ 
        },

        mounted() {
        },
        
        data(){
            return { 
                visible_find_sku:false,
                showDismissibleAlert:false,
            }
        },
        methods:{
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

            clearAlert() 
            {
                this.alertMsg = '';
                this.variant = '';
                this.showDismissibleAlert = false;
            },

            /**
             * goToChapter
             */
            goToChapter(chapter) 
            {
                this.$router.push({
                    name:'chapter-data',query: { chapter: chapter }
                });
            }
        }
        
    }
</script>
<style scoped>

.socialImg{
    width: 20px !important;
}


</style>
