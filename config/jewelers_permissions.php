<?php

return [
    # Admin

    # shop owner
    // Jewel Job
    [
        'name'        => 'view_job',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'create_job',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'update_job',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'delete_job',
        'guard'       => 'shop_owner_api'
    ],
     // Single Store
     [
        'name'        => 'view_store',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'create_store',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'update_store',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'delete_store',
        'guard'       => 'shop_owner_api'
    ],

    // Customer
    [
        'name'        => 'view_customer',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'create_customer',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'update_customer',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'delete_customer',
        'guard'       => 'shop_owner_api'
    ],
    // Jeweler
    [
        'name'        => 'view_jeweler',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'create_jeweler',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'update_jeweler',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'delete_jeweler',
        'guard'       => 'shop_owner_api'
    ],

    // SaleStaff
    [
        'name'        => 'view_salestaff',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'create_salestaff',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'update_salestaff',
        'guard'       => 'shop_owner_api'
    ],
    [
        'name'        => 'delete_salestaff',
        'guard'       => 'shop_owner_api'
    ],
];
