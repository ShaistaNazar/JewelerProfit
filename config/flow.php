<?php

return [

    '300' => [

        1 => 'major_item',
        2 => 'dependent_parts_if_needed',
        3 => 'size',
        4 => 'karats',
        5 => 'picklist_item_if_needed',
        6 => 'price_criteria_item', // multiplication factor as price changes ascper no. of items
        7 => 'welding_technology',
        
    ],

    '200' => [

        1 => 'major_item',
        2 => 'type',
        3 => 'karats',
        4 => 'price_criteria_item', //multiplication factor as price changes asper no. of items
        // quantity is being removed as this is being handled 
        // in price criteria item as both cpnsidered different
        5 => 'welding_technology',
        // 6 => 'picklist_item_if_needed'
        // after laser and torch
        // stone type is required as Threbaguette stones count as onlye  1 round stone for pricing.
        
    ],

    '700' => [

        1 => 'major_item',
        2 => 'setting_type',
        3 => 'item_type',
        4 => 'item_description',
        5 => 'size',
        6 => 'price_criteria_item', // multiplication factor as price changes asper no. of items

    ],

    '400' => [

        1 => 'major_item',
        2 => 'type',
        3 => 'stone_shape',
        4 => 'stone_size',
        5 => 'karats',
        6 => 'picklist_item_if_needed',
        // 7 => 'price_criteria_item', //multiplication factor as price changes asper no. of items
        7 => 'welding_technology'

    ],

    '900' => [

        1 => 'major_item',
        2 => 'complexity',
        3 => 'welding_technology',
        4 => 'karats',
        5 => 'description',
        6 => 'price_criteria_item', // multiplication factor as price changes as per no. of items

    ],

    '600' => [
        
        1 => 'setting_type',
        2 => 'no_of_prongs',
        3 => 'karats',
        4 => 'shape',
        5 => 'size', // multiplication factor as price changes as per no. of items

    ],

    '500' => [

        //  no quantity please
        1 => 'major_item',
        2 => 'engraving_type',
        3 => 'item_type',
        4 => 'description',
        5 => 'width',
        6 => 'question',
        7 => 'price_criteria_item', // multiplication factor as price changes as per no. of items
        8 => 'welding_technology'

    ],
    
    '1200' => [
        
        1 => 'major_item',
        // 2 => 'main_quantity', // multiplication factor as price changes as per no. of items
        2 => 'type',
        3 => 'interlinked_option',
        4 => 'extra_work_per_appraisal',
        5 => 'description',
        6 => 'size',
        7 => 'karats',
        8 => 'color',
        9 => 'picklist_item_if_needed',
        10 => 'price_criteria_item',
        11 => 'welding_technology',
        

        // 1 => 'major_item',
        // 2 => 'main_quantity', // multiplication factor as price changes as per no. of items
        // 2 => 'add_ons',
        // 3 => 'type',
        // 4 => 'description',
        // 5 => 'size',
        // 6 => 'karats',
        // 7 => 'color',
        // 8 => 'picklist_item_if_needed',
        // 9 => 'price_criteria_item',
        // 10 => 'welding_technology',
        
    ],

    '800' => [

        1 => 'major_item',
        2 => 'type',
        3 => 'size',
        4 => 'inside_diameter',
        5 => 'description',
        6 => 'shape',
        7 => 'karats',
        8 => 'color',

    ],

    '1100' => [

        1 => 'major_item',
        2 => 'description',
        3 => 'thickness',
        4 => 'complication_surcharge',
        5 => 'price_criteria_item'
        
    ],

    '100'  =>  [

        1 => 'major_item',
        2 => 'type',
        3 => 'description',
        4 => 'shape',
        5 => 'karats',
        6 => 'size',
        7 => 'color', 
        8 => 'width',
        9 => 'silver_stone_specification',
        10 => 'ring_size', 
        11 => 'welding_technology',  

    ],

    '1000'  =>  [

        1 => 'major_item',
        2 => 'type',
        3 => 'way_around',
        4 => 'stone_details',
        5 => 'who_keeps_mold',
        6 => 'description',
        7 => 'length_of_chain',
        8 => 'cast_into',
        9 => 'karats',
        10 => 'popup',
        11 => 'require_weight_popup',
        12 => 'dependent_chapter',
        13 => 'part_specifications',
        14 => 'welding_technology',

    ],

    '1300'  =>  [

        1  => 'major_item',
        2  => 'type',
        3  => 'shape',
        4  => 'description',
        5  => 'color',
        6  => 'diamond_grade',  
        7  => 'size',
        8  => 'cut',
        9 => 'quality',

    ],
];