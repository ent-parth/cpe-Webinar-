<?php
if (empty($activeSidebarMenu)) {
    $activeSidebarMenu = "";
}
if (empty($activeSidebarSubMenu)) {
    $activeSidebarSubMenu = "";
}
$sidebarMenus = [
    'dashboard' => [
        'text' => 'Dashboard',
        'routeName' => 'administrator.dashboard',
        'permissionKey' => [],
        'icon' => 'fa fa-dashboard'
    ],
	 'users' => [
        'text' => 'Users',
        'routeName' => 'users',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
  /*  'administrators' => [
        'text' => 'Administrators',
        'icon' => 'icon-sub-admins',
        'routeName' => 'administrators',
        'menuName' => 'administrators',
        'permissionKey' => [],
    ],  */
	 
	'access_management' => [
        'text' => 'Access Management',
        'permissionKey' => [],
        'icon' => 'icon-add',
        'subMenu' => [ 
        	'user_management' => [
                'icon' => 'icon-user',
                'text' => 'User Management',
                'routeName' => 'user_management',
                'menuName' => 'user_management',
                'permissionKey' => [],
            ],
			'role_management' => [
                'icon' => 'icon-earth',
                'text' => 'Role Management', 
                'routeName' => 'role_management', 
                'menuName' => 'role_management',
                'permissionKey' => ['permission_role-'], 
            ],
			'permission_management' => [
                'icon' => 'icon-pencil',
                'text' => 'Permission Management',
                'routeName' => 'permission_management', 
                'menuName' => 'permission_management', 
                'permissionKey' => [], 
            ],
        ],
    ],
	
    /*
    'users' => [
        'text' => 'messages.users',
        'permissionKey' => ['manage-sub-admin', 'manage-companies', 'manage-drivers', 'manage-customers'],
        'icon' => 'icon-users',
        'subMenu' => [
            'administrators' => [
//                'text' => 'messages.administrators',
                'icon' => 'icon-sub-admins',
                'text' => 'messages.administrators',
                'routeName' => 'administrators',
                'menuName' => 'administrators',
                'permissionKey' => ['manage-sub-admin'],
            ],
            'companies' => [
                'icon' => 'icon-companies',
                'text' => 'messages.companies',
                'routeName' => 'companies',
                'menuName' => 'companies',
                'permissionKey' => ['manage-companies'],
            ],
            'drivers' => [
                'icon' => 'icon-drivers',
                'text' => 'messages.drivers',
                'routeName' => 'drivers',
                'menuName' => 'drivers',
                'permissionKey' => ['manage-drivers'],
            ],
            'customers' => [
                'icon' => 'icon-customers',
                'text' => 'messages.customers',
                'routeName' => 'customers',
                'menuName' => 'customers',
                'permissionKey' => ['manage-customers'],
            ],
        ]
    ],*/
    'companies' => [
        'text' => 'Companies',
        'routeName' => 'companies',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
   	'speakers' => [
        'text' => 'Speakers',
        'routeName' => 'speakers',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'categories' => [
        'text' => 'Categories',
        'routeName' => 'categories',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'courseLevel' => [
        'text' => 'Course Level',
        'routeName' => 'course-level',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'course' => [
        'text' => 'Courses',
        'routeName' => 'course-list',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
	'series' => [
        'text' => 'Series',
        'routeName' => 'series',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'tags' => [
        'text' => 'Topic of interest',
        'routeName' => 'tags',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'team' => [
        'text' => 'Team',
        'routeName' => 'team',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'courseLevel' => [
        'text' => 'Course Level',
        'routeName' => 'course-level',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'userType' => [
        'text' => 'User Types',
        'routeName' => 'user-types',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'subjects' => [
        'text' => 'Subjects',
        'routeName' => 'subjects',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],
    'webinars' => [
        'text' => 'Webinars',
        //'routeName' => 'webinar',
        'permissionKey' => [],
        'icon' => 'fa fa-users',
		'subMenu' => [
            'live' => [
                'icon' => 'icon-earth',
                'text' => 'Live Webinar',
                'routeName' => 'live-webinar',
                'menuName' => 'live-webinar',
                'permissionKey' => [''],
            ],
        	'self-study' => [
                'icon' => 'icon-city',
                'text' => 'Seft Study Webinar',
                'routeName' => 'selfstudy-webinar',
                'menuName' => 'selfstudy',
                'permissionKey' => [],
            ],
			'archive' => [
                'icon' => 'icon-archive',
                'text' => 'Archive Webinar',
                'routeName' => 'archive-webinar',
                'menuName' => 'archive-webinar',
                'permissionKey' => [''],
            ]
			
        ]
    ],
	'webinar-user-register' => [
		'icon' => 'icon-archive',
		'text' => 'Attendies',
		'routeName' => 'webinar-user-register',
		'menuName' => 'archive-webinar',
		'permissionKey' => [''],
	],
	'webinar-payment-history' => [
		'icon' => 'icon-archive',
		'text' => 'Attendies Payment History ',
		'routeName' => 'webinar-payment-history',
		'menuName' => '',
		'permissionKey' => [''],
	],
    'locations' => [
        'text' => 'Locations',
        'permissionKey' => ['manage-countries', 'manage-cities', 'manage-areas'],
        'icon' => 'icon-location4',
        'subMenu' => [
        	'country' => [
                'icon' => 'icon-earth',
                'text' => 'Countries',
                'routeName' => 'countries',
                'menuName' => 'country',
                'permissionKey' => ['manage-countries'],
            ],
        	'state' => [
                'icon' => 'icon-city',
                'text' => 'State',
                'routeName' => 'states',
                'menuName' => 'states',
                'permissionKey' => ['manage-states'],
            ],
            'city' => [
                'icon' => 'icon-city',
                'text' => 'Cities',
                'routeName' => 'cities',
                'menuName' => 'city',
                'permissionKey' => ['manage-cities'],
            ]
            /*'city' => [
                'icon' => 'icon-city',
                'text' => 'Cities',
                'routeName' => 'cities',
                'menuName' => 'city',
                'permissionKey' => ['manage-cities'],
            ],
            'area' => [
                'icon' => 'icon-area',
                'text' => 'Areas',
                'routeName' => 'areas',
                'menuName' => 'area',
                'permissionKey' => ['manage-areas'],
            ],*/
        ]
    ],
    /*'subscription' => [
        'text' => 'messages.subscription_plan',
        'routeName' => 'subscriptions',
        'permissionKey' => ['manage-subscription'],
        'icon' => 'icon-puzzle'
    ],*/
    'settings' => [
        'text' => 'Settings',
        'permissionKey' => ['manage-email-templates', 'manage-language-translation', 'manage-industry', 'manage-cancelation-reason'],
        'icon' => 'icon-gear',
        'subMenu' => [
			'permission' => [
	           'text' => 'Permissions',
	           'routeName' => 'permission',
	           'menuName' => 'permission',
	           'permissionKey' => ['permission-listing'],
	           'icon' => 'icon-gear'
		    ],
            /*'emailTemplates' => [
                'icon' => 'icon-email-templates',
                'text' => 'messages.email_templates',
                'routeName' => 'emailtemplates',
                'menuName' => 'emailTemplates',
                'permissionKey' => ['manage-email-templates'],
            ],
            'language_translation' => [
                'icon' => 'icon-translations',
                'text' => 'messages.translations',
                'routeName' => 'languagetranslations',
                'menuName' => 'language_translation',
                'permissionKey' => ['manage-language-translation'],
            ],
            'cancelation_reason' => [
                'icon' => 'icon-alarm-cancel',
                'text' => 'messages.cancellation_reasons',
                'routeName' => 'cancelation_reasons',
                'menuName' => 'cancelation_reason',
                'permissionKey' => ['manage-cancelation-reason'],
            ],
            'industries' => [
                'icon' => 'icon-office',
                'text' => 'messages.industries',
                'routeName' => 'industries',
                'menuName' => 'industries',
                'permissionKey' => ['manage-industry'],
            ]*/
        ]
    ],
	/*
    'complain' => [
        'icon' => 'icon-printer4',
        'text' => 'messages.complains',
        'routeName' => 'complains',
        'permissionKey' => ['manage-complains']
    ]*/
];
?>

<section class="sidebar">
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <!-- <li class="header">MAIN NAVIGATION</li> -->
    <!-- Main -->
    <?php
    foreach ($sidebarMenus as $key => $menu) {   ?>
        <?php if (empty($menu['permissionKey']) || \App\Helpers\PermissionHelper::hasAccess($menu['permissionKey'])){ ?> 
            <li class="<?php echo ($key == $activeSidebarMenu) ? 'active' : ''; ?> <?php echo (!empty($menu['subMenu'])) ? 'treeview' : ''; ?> <?php echo ($key == $activeSidebarSubMenu) ? "menu-open" : ""; ?>">
                <a href="<?php echo (!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:void(0);'; ?>">
                    <i class="<?= $menu['icon']; ?>"></i> <span>{{__($menu['text']) }}</span>
                    <?php if (!empty($menu['subMenu'])) { ?>
	                    <span class="pull-right-container">
	                      <i class="fa fa-angle-left pull-right"></i>
	                    </span>
	                <?php }  ?>
                </a>
                <?php  if (!empty($menu['subMenu'])) {  ?>
                    <ul class="treeview-menu">
                        <?php foreach ($menu['subMenu'] as $subMenukey => $subMenu) {  ?>
                        <li class="<?php echo ($subMenukey == $activeSidebarSubMenu) ? 'active' : ''; ?>">
                            <?php if($subMenu['routeName'] != "user_management" && $subMenu['routeName'] != "role_management" && $subMenu['routeName'] != "permission_management"){ ?>
                            <a href="<?php echo (!empty($subMenu['routeName'])) ? route($subMenu['routeName']) : 'javascript:void(0);'; ?>"> 
                                <i class="<?= $subMenu['icon']; ?>"></i> {{__($subMenu['text']) }}
                            </a>
                        <?php }else{ ?>
                            <a href="<?php echo (!empty($subMenu['routeName'])) ? URL::to($subMenu['routeName']) : 'javascript:void(0);'; ?>">  
                                <i class="<?= $subMenu['icon']; ?>"></i> {{__($subMenu['text']) }}
                            </a>
                        <?php } ?>
                        </li>
                    <?php }  ?> 
                	</ul>
                <?php }  ?>   
            </li>
        <?php  } 
    } ?>
  </ul>
</section>