<?php
$menus = [
    [
        'level' => USER_LEVEL,
        'uri' => 'dashboard',
        'title' => 'หน้าหลัก',
        'children' => []
    ],

    [
        'level' => USER_LEVEL,
        'uri' => '',
        'title' => 'จัดการสมาชิก',
        'children' => [
            [
                'level' => USER_LEVEL,
                'uri' => 'Members',
                'title' => 'จัดการ Members',
                'children' => []
            ],
            [
                'level' => ADMIN_LEVEL,
                'uri' => 'Users',
                'title' => 'จัดการ Users',
                'children' => []
            ],
            [
                'level' => ADMIN_LEVEL,
                'uri' => 'Admin',
                'title' => 'จัดการ Admin',
                'children' => []
            ],
        ]
    ],

    [
        'level' => USER_LEVEL,
        'uri' => '',
        'title' => 'จัดการสินค้า',
        'children' => [
            [
                'level' => USER_LEVEL,
                'uri' => 'ProductType',
                'title' => 'จัดการชนิดสินค้า',
                'children' => []
            ],
            [
                'level' => USER_LEVEL,
                'uri' => 'Product',
                'title' => 'จัดการสินค้า',
                'children' => []
            ],
        ]
    ],

    [
        'level' => USER_LEVEL,
        'uri' => '',
        'title' => 'รายการสั่งซื้อสินค้า',
        'children' => [
            [
                'level' => USER_LEVEL,
                'uri' => 'PendingProduct',
                'title' => 'รายการสั้งซื้อทั้งหมด',
                'children' => []
            ],
            [
                'level' => USER_LEVEL,
                'uri' => 'ProductStatus',
                'title' => 'รายการพร้อมจัดส่ง',
                'children' => []
            ],
            [
                'level' => USER_LEVEL,
                'uri' => 'shipments',
                'title' => 'สถานะการจัดส่ง',
                'children' => []
            ],

        ]
    ],

    [
        'level' => USER_LEVEL,
        'uri' => 'banner',
        'title' => 'จัดการแบบเนอร์',
        'children' => []
    ],

    [
        'level' => USER_LEVEL,
        'uri' => 'bank',
        'title' => 'จัดการบัญชีธนาคาร',
        'children' => []
    ],

    [
        'level' => USER_LEVEL,
        'uri' => 'shipping',
        'title' => 'จัดการค่าจัดส่ง',
        'children' => []
    ],

    [
        'level' => USER_LEVEL,
        'uri' => 'history',
        'title' => 'ดูประวัติการซื้อขาย',
        'children' => []
    ],
    [
        'level' => USER_LEVEL,
        'uri' => 'settings',
        'title' => 'ตั้งค่าเว็บไซต์',
        'children' => []
    ],
];
