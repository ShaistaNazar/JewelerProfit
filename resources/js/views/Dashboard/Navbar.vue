<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" :class="bg_warning_if_test_env">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto" v-if="bg_warning_if_test_env">
            <li class="nav-item">
                <span>
                    <b class="banner-text">TEST ENVIRONMENT</b>
                </span>
            </li>
        </ul>


        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link" @click.prevent="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    {{$t('button.logout')}}
                </a>
            </li>
        </ul>
    </nav>
</template>


<script>
    export default {
        mounted(){
        this.getConfig();

        },
        data(){
            return{
              bg_warning_if_test_env:null,
            }
        },
        methods: {
            logout() {
                localStorage.removeItem('token');
                this.$router.push("/login");
            },
            /**
             * Get configuration for app
             */
            getConfig() {
                let response = axios.get('/api/config');

                if (response.data) {
                    let config = response.data;
                    if (config.app_env=='test')
                    this.bg_warning_if_test_env='warningBG'
                }
            },
        }
    }

</script>
<style scoped>
.warningBG{
    background-color:#fad201 !important;
}
.banner-text{
    font-size: 18px;
}
</style>

