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
        'routeName' => 'speaker.dashboard',
        'permissionKey' => [],
        'icon' => 'fa fa-dashboard'
    ],
    /*'tags' => [
        'text' => 'Tags',
        'routeName' => 'tags',
        'permissionKey' => [],
        'icon' => 'fa fa-table'
    ],*/
    'webinars' => [
        'text' => 'Live Webinars',
        'routeName' => 'speaker.webinar',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
    ],
    'self_study_webinars' => [
        'text' => 'Self Study Webinars',
        'routeName' => 'speaker.self_study_webinars',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
    ],
	'archived-webinar' => [
        'text' => 'Archived Webinars',
        'routeName' => 'speaker.archived-webinar',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
    ],
	
	/*'webinar-questions' => [
        'text' => 'Webinar Questions',
        'routeName' => 'speaker.webinar-questions',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
    ],*/
	'webinar-invitation' => [
        'text' => 'Webinar Invitation',
        'routeName' => 'speaker.webinar-invitation',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
    ],
	'webinar-user-register' => [
        'text' => 'Attendies',
        'routeName' => 'speaker.webinar-user-register',
        'permissionKey' => [],
        'icon' => 'fa fa-users'
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
            ],
        ]
    ],
    /*'subscription' => [
        'text' => 'messages.subscription_plan',
        'routeName' => 'subscriptions',
        'permissionKey' => ['manage-subscription'],
        'icon' => 'icon-puzzle'
    ],
    'settings' => [
        'text' => 'Settings',
        'permissionKey' => ['manage-email-templates', 'manage-language-translation', 'manage-industry', 'manage-cancelation-reason'],
        'icon' => 'icon-gear',
        'subMenu' => [
        	'roles' => [
	           'text' => 'Roles',
	           'routeName' => 'roles',
	           'menuName' => 'roles',
	           'permissionKey' => ['role-listing'],
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
            ]
        ]
    ],/*
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
    foreach ($sidebarMenus as $key => $menu) {
        ?>
        <?php if (empty($menu['permissionKey']) || \App\Helpers\PermissionHelper::hasAccess($menu['permissionKey'])) { ?>
            <li class="<?php echo ($key == $activeSidebarMenu) ? 'active' : ''; ?> <?php echo (!empty($menu['subMenu'])) ? 'treeview' : ''; ?> <?php echo ($key == $activeSidebarSubMenu) ? "menu-open" : ""; ?>">
                <a href="<?php echo (!empty($menu['routeName'])) ? route($menu['routeName']) : 'javascript:void(0);'; ?>">
                    <i class="<?= $menu['icon']; ?>"></i> <span>{{__($menu['text']) }}</span>
                    <?php if (!empty($menu['subMenu'])) { ?>
	                    <span class="pull-right-container">
	                      <i class="fa fa-angle-left pull-right"></i>
	                    </span>
	                <?php } ?>
                </a>
                <?php if (!empty($menu['subMenu'])) { ?>
                    <ul class="treeview-menu">
                        <?php foreach ($menu['subMenu'] as $subMenukey => $subMenu) { ?>
                        <li class="<?php echo ($subMenukey == $activeSidebarSubMenu) ? 'active' : ''; ?>">
                            <a href="<?php echo (!empty($subMenu['routeName'])) ? route($subMenu['routeName']) : 'javascript:void(0);'; ?>">
                                <i class="<?= $subMenu['icon']; ?>"></i> {{__($subMenu['text']) }}
                            </a>
                        </li>
                    </ul>
                <?php }
                } ?>
            </li>
        <?php }
    } ?>
  </ul>
</section>