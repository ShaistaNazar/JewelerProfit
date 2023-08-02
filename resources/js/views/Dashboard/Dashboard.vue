<template>
    <div class="container   mx-auto">

        <!-- <custom-alert v-if="showDismissibleAlert" :showDismissibleAlert="showDismissibleAlert" :msg="alertMsg" :variant="variant"/> -->

        <!-- Header Component -->
        <!-- <custom-header/> -->

        <!-- <custom-image src="assets/logo.png" alt="logo" class_to_pass="responsive-logo mx-auto my-4 d-block"/> -->


        <div class="main_dashboard">
            <div class="row">  
                <div class="col-lg-12">
                    <router-view></router-view>
                </div>
            </div>
        </div>
 

    </div>
</template>

<script>
    // import Navbar from './Navbar'
    import Sidebar from './Sidebar_db.vue'
    // import AppFooter from './Footer'

    export default {
        components: {
            // Navbar,
            Sidebar,
            // AppFooter
        },

        data() {
            return {
                permissions: [],
                user: {},
                dateFormat: 'DD.MM.YYYY',
                datetimeFormat: 'DD.MM.YYYY HH:mm:ss',
                decimalDigits: 2,
                decimalPoint: '.',
                thousandSeparator: "'",
                showPage: false,
                isLoading: true,
            };
        },

        created() {
            this.init();
        },

        methods: {
            /**
             * Initialize Dashboard
             */
            init() {
                this.setHeaders();
            },

            /**
             * Set general headers for each axios request
             */
            setHeaders() 
            {
                let token = localStorage.getItem('token');
                axios.defaults.headers.common['Content-Type'] = 'application/json';
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            },

            /**
             * Fetch Permissions
             */
            fetchPermission(value) 
            {
                axios.get("/api/get-all-permissions").then(({
                    data
                }) => this.permissions = data);
            },

            /**
             * Get configuration for app
             */
            getConfig() {
                let response = axios.get('/api/config');

                if (response.data) {
                    let config = response.data;

                    if (config.date_format) this.dateFormat               = config.date_format;
                    if (config.datetime_format) this.datetimeFormat       = config.datetime_format;
                    if (config.decimal_digits) this.decimalDigits         = config.decimal_digits;
                    if (config.decimal_point) this.decimalPoint           = config.decimal_point;
                    if (config.thousand_separator) this.thousandSeparator = config.thousand_separator;
                }
            },

        },
    };

</script>


<style scoped>

.db_container {width: calc(100% - 350px);
    margin-left: 350px;}

.db_container .navbar  { background: #333c73; position: fixed; left: 0px; top: 0px; width: 100%;}

.db_container .navbar-brand { margin-left: 350px;}


.db_container_detail {padding: 60px 50px 60px 50px;}


.db_container_detail .container { width: 100%;  max-width: 100% !important;}
.db_container_detail .container .container { width: 100%;  max-width: 100% !important;}

.db_container_detail .desktop { display: none !important;}


</style>
