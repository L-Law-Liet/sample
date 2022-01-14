<?php
// Aside menu
return [

    'admin_items' => [
        [
            'title' => 'Dashboard',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'root' => true,
            'page' => '/',
        ],
        [
            'title' => 'Products for repair',
            'icon' => 'media/svg/icons/Tools/Hummer.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Add product for repair',
                    'page' => 'products/create',
                ],
                [
                    'title' => 'List of products for repair',
                    'page' => 'products',
                ],
            ]
        ],
        [
            'title' => 'Management',
            'icon' => 'media/svg/icons/Design/Arrows.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Technicians',
                    'page' => 'admin/users',
                ],
                [
                    'title' => 'Clients',
                    'page' => 'clients',
                ],
                [
                    'title' => 'Statuses',
                    'page' => 'admin/statuses',
                ],
                [
                    'title' => 'Type of problems',
                    'page' => 'problems',
                ],
                [
                    'title' => 'Categories',
                    'page' => 'admin/categories',
                ],
            ]
        ],
        [
            'title' => 'Archive',
            'icon' => 'media/svg/icons/Files/Deleted-folder.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Technicians',
                    'page' => 'admin/users-deleted',
                ],
                [
                    'title' => 'Clients',
                    'page' => 'clients-deleted',
                ],
                [
                    'title' => 'Products for repair',
                    'page' => 'products-deleted',
                ],
                [
                    'title' => 'Statuses',
                    'page' => 'admin/statuses-deleted',
                ],
                [
                    'title' => 'Type of problems',
                    'page' => 'problems-deleted',
                ],
                [
                    'title' => 'Categories',
                    'page' => 'admin/categories-deleted',
                ],
            ]
        ],
        [
            'title' => 'Reports',
            'icon' => 'media/svg/icons/Files/File.svg',
            'root' => true,
            'page' => 'admin/reports',
        ],
        [
            'title' => 'Settings',
            'icon' => 'media/svg/icons/General/Settings-2.svg',
            'bullet' => 'line',
            'root' => true,
            'page' => '/user/profile',
        ],
    ],
    'technician_items' => [
        [
            'title' => 'Dashboard',
            'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
            'bullet' => 'line',
            'root' => true,
            'page' => '/',
        ],
        [
            'title' => 'Products for repair',
            'icon' => 'media/svg/icons/Tools/Hummer.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Add product for repair',
                    'page' => 'products/create',
                ],
                [
                    'title' => 'List of products for repair',
                    'page' => 'products',
                ],
                [
                    'title' => 'Claimed products for repair',
                    'page' => 'technician/products',
                ],
            ]
        ],
        [
            'title' => 'Management',
            'icon' => 'media/svg/icons/Design/Arrows.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Clients',
                    'page' => 'clients',
                ],
                [
                    'title' => 'Type of problems',
                    'page' => 'problems',
                ],
            ]
        ],
        [
            'title' => 'Archive',
            'icon' => 'media/svg/icons/Files/Deleted-folder.svg',
            'bullet' => 'line',
            'root' => true,
            'submenu' => [
                [
                    'title' => 'Clients',
                    'page' => 'clients-deleted',
                ],
                [
                    'title' => 'Products for repair',
                    'page' => 'products-deleted',
                ],
                [
                    'title' => 'Type of problems',
                    'page' => 'problems-deleted',
                ],
            ]
        ],
        [
            'title' => 'Reports',
            'icon' => 'media/svg/icons/Files/File.svg',
            'root' => true,
            'page' => 'technician/reports',
        ],
        [
            'title' => 'Settings',
            'icon' => 'media/svg/icons/General/Settings-2.svg',
            'bullet' => 'line',
            'root' => true,
            'page' => '/user/profile',
        ],
    ]

];
