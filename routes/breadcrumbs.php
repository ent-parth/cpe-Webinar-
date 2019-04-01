<?php

// Home Route based on URL
if (Request::getHost() === env('APP_URL')) {
    Breadcrumbs::register('home', function($breadcrumbs) {
        $breadcrumbs->push('messages.home', route('company.user.dashboard'));
    });
} else {
    Breadcrumbs::register('home', function($breadcrumbs) {
        $breadcrumbs->push('messages.home', route('administrator.dashboard'));
    });
}
?>
