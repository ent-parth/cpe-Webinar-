<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/welcome', function () {
   return view('welcome');
});


Route::group(['middleware' => 'disablepreventback'],function(){
    function commonRoutes()
    {

    }
    Route::pattern('id', '\d+');
    Route::domain(env('APP_ADMIN_URL'))->group(function () {
        Route::group(['middleware' => ['admin_guest']], function () {
            Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('show-admin-login-form');
            Route::post('/', 'AdminAuth\LoginController@login')->name('administrator-login-form');
            Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('show.administrator.login');
            Route::post('/login', 'AdminAuth\LoginController@login')->name('administrator.login');

            Route::get('/forgot-password','AdminAuth\AdminForgotPasswordController@showLinkRequestForm')->name('administrator.email.reset.form');
            Route::post('/forgot-password/', 'AdminAuth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.reset');
            Route::post('/forgot-password/check-email', 'AdminAuth\AdminForgotPasswordController@checkEmail')->name('forgot.password.checkEmail');
            Route::post('/reset/check-email', 'AdminAuth\ResetPasswordController@checkEmail')->name('reset.checkEmail');
            Route::get('/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('administrator.reset.form');
            Route::post('/password/reset/', 'AdminAuth\ResetPasswordController@reset')->name('administrator.reset.password');
        });
        Route::group(['middleware' => ['admin']], function () {
			//Route::group(array('middleware'=>['auth'],'namespace'=>'Admin', 'prefix' => 'admin'), function(){
            // Accounts
            Route::get('/dashboard', 'AccountsController@dashboard')->name('administrator.dashboard');
            Route::get('/edit-profile', 'AccountsController@showEditForm')->name('administrator.edit.form');
            Route::post('/edit-profile', 'AccountsController@editProfile')->name('administrator.edit.profile');
            Route::post('/account/check_email', 'AccountsController@checkEmail')->name('administrator.checkemail');
            Route::post('/account/check-password', 'AccountsController@checkPassword')->name('administrator.checkpassword');
            Route::get('/logout', 'AdminAuth\LoginController@logout')->name('administrator.logout');
            //notification
            Route::get('/admin_notification', 'AdminNotificationController@admin_notification')->name('administrator.admin_notification');

            
			// Roles
            Route::get('/roles', 'RoleController@index')->name('roles');
            Route::post('/roles/get-list', 'RoleController@getList')->name('roles-list');
            Route::get('/roles/add', 'RoleController@add')->name('add-role')->middleware('check-permission:manage-roles|add-role');
            Route::post('/roles/add', 'RoleController@store')->name('add-role')->middleware('check-permission:manage-roles|add-role');
            Route::get('/role/edit/{id}', 'RoleController@edit')->name('edit-role')->middleware('check-permission:manage-roles|edit-role');
            Route::post('/role/edit/{id}', 'RoleController@update')->name('edit-role')->middleware('check-permission:manage-roles|edit-role');
            Route::get('/roles/delete/{id}', 'RoleController@destroy')->name('roles-delete')->middleware('check-permission:manage-roles|delete-role');
            Route::get('/roles/manage-role-permissions/{id}', 'RoleController@createPermissions')->name('create.role.permission')->middleware('check-permission:manage-roles|manage-role-permission');
            Route::post('/roles/manage-role-permissions/{id}', 'RoleController@storePermission')->name('store.role.permission')->middleware('check-permission:manage-roles|manage-role-permission');
            
			// Administratore
            Route::get('/administrators', 'AdministratorController@index')->name('administrators')->middleware('permission:admin_view');
            Route::post('/administrators/get-list', 'AdministratorController@getList')->name('administrators-list')->middleware('permission:admin_view');
            Route::get('/administrators/add', 'AdministratorController@create')->name('add-administrators')->middleware('permission:admin_add');
            Route::post('/administrators/add', 'AdministratorController@store')->name('add-administrators')->middleware('permission:admin_add');
            Route::get('/administrators/edit/{id}', 'AdministratorController@edit')->name('administrators-edit')->middleware('permission:admin_edit');
            Route::post('/administrators/edit/{id}', 'AdministratorController@update')->name('administrators-edit')->middleware('permission:admin_edit');
            Route::get('/administrators/view/{id}', 'AdministratorController@show')->name('administrators-view')->middleware('permission:admin_view');
            Route::post('/administrators/status/{id}', 'AdministratorController@statusupdate')->middleware('permission:admin_edit');
            Route::get('/administrators/delete/{id}', 'AdministratorController@destroy')->name('administrators-delete')->middleware('permission:admin_delete');
            Route::get('/administrators/status-update/{id}', 'AdministratorController@statusUpdate')->name('status-update.administrators')->middleware('permission:admin_edit');
            Route::post('/administrators/delete-all', 'AdministratorController@destroyAll')->name('delete-all.administrators')->middleware('permission:admin_delete');
           
		    // Country
            Route::get('/countries', 'CountryController@index')->name('countries')->middleware('permission:country_view');
            Route::post('/countries/get-list', 'CountryController@getList')->name('countries.list')->middleware('permission:country_view');
            Route::get('/countries/add', 'CountryController@create')->name('create.country')->middleware('permission:country_add');
            Route::post('/countries/add', 'CountryController@store')->name('store.country')->middleware('permission:country_add');
            Route::get('/countries/edit/{id}', 'CountryController@edit')->name('edit.country')->middleware('permission:country_edit');
            Route::post('/countries/edit/{id}', 'CountryController@update')->name('update.country')->middleware('permission:country_edit');
            Route::get('/countries/delete/{id}', 'CountryController@destroy')->name('delete.country')->middleware('permission:country_delete');
            Route::post('/countries/delete-all', 'CountryController@destroyAll')->name('delete-all.countries')->middleware('permission:country_delete');
            Route::get('/countries/status-update/{id}', 'CountryController@statusUpdate')->name('status-update.country')->middleware('permission:country_edit');
            Route::post('/countries/check-country', 'CountryController@checkCountry')->name('checkCountry.country')->middleware('permission:country_view');
            
			// State
            Route::get('/states', 'StateController@index')->name('states')->middleware('permission:state_view');
            Route::post('/states/get-list', 'StateController@getList')->name('states.list')->middleware('permission:state_view');
            Route::get('/states/add', 'StateController@create')->name('create.state')->middleware('permission:state_add');
            Route::post('/states/add', 'StateController@store')->name('store.state')->middleware('permission:state_add');
            Route::get('/states/edit/{id}', 'StateController@edit')->name('edit.state')->middleware('permission:state_edit');
            Route::post('/states/edit/{id}', 'StateController@update')->name('update.state')->middleware('permission:state_edit');
            Route::get('/states/delete/{id}', 'StateController@destroy')->name('delete.state')->middleware('permission:state_delete');
            Route::post('/states/delete-all', 'StateController@destroyAll')->name('delete-all.states')->middleware('permission:state_delete');
            Route::get('/states/status-update/{id}', 'StateController@statusUpdate')->name('status-update.state')->middleware('permission:state_edit');
            Route::get('/states/import', 'StateController@import')->name('import.states')->middleware('permission:state_add');
            Route::post('/states/import', 'StateController@import')->name('import.states')->middleware('permission:state_add');
            Route::post('/states/check-state', 'StateController@checkState')->name('checkState.state')->middleware('permission:state_add');
            
			// City
            Route::get('/cities', 'CityController@index')->name('cities')->middleware('permission:city_view');
            Route::post('/cities/get-list', 'CityController@getList')->name('cities.list')->middleware('permission:city_view');
            Route::get('/cities/add', 'CityController@create')->name('create.city')->middleware('permission:city_add');
            Route::post('/cities/add', 'CityController@store')->name('store.city')->middleware('permission:city_add');
            Route::get('/cities/edit/{id}', 'CityController@edit')->name('edit.city')->middleware('permission:city_edit');
            Route::post('/cities/edit/{id}', 'CityController@update')->name('update.city')->middleware('permission:city_edit');
            Route::get('/cities/delete/{id}', 'CityController@destroy')->name('delete.cities')->middleware('check-permission:manage-cities')->middleware('permission:city_delete');
            Route::post('/cities/delete-all', 'CityController@destroyAll')->name('delete-all.cities')->middleware('permission:city_delete');
            Route::get('/cities/status-update/{id}', 'CityController@statusUpdate')->name('status-update.city')->middleware('permission:city_edit');
            Route::get('/cities/import', 'CityController@import')->name('import.city')->middleware('permission:city_add');
            Route::post('/cities/import', 'CityController@import')->name('import.city')->middleware('permission:city_add');
            Route::post('/cities/check-city', 'CityController@checkCity')->name('checkCity.city')->middleware('permission:city_add');
            //Route::get('/speakers/delete/{id}', 'SpeakerController@destroy')->name('delete.city')->middleware('check-permission:manage-speakers')->middleware('permission:speaker_view');
            
			// Speaker
            Route::get('/speakers', 'SpeakerController@index')->name('speakers')->middleware('permission:speaker_view');
            Route::post('/speakers/get-list', 'SpeakerController@getList')->name('speakers-list')->middleware('permission:speaker_view');
            // Route::get('/speakers/add', 'SpeakerController@create')->name('create.speaker')->middleware('check-permission:manage-speakers')->middleware('permission:speaker_view');
            // Route::post('/speakers/add', 'SpeakerController@store')->name('store.speaker')->middleware('check-permission:manage-speakers')->middleware('permission:speaker_view');
            Route::get('/speakers/edit', 'SpeakerController@edit')->name('edit.speaker')->middleware('permission:speaker_edit');
            Route::post('/speakers/edit', 'SpeakerController@update')->name('update.speaker')->middleware('permission:speaker_edit');
            Route::get('/speakers/view/{id}', 'SpeakerController@show')->name('show.speaker')->middleware('permission:speaker_view');
            Route::get('/speakers/delete/{id}', 'SpeakerController@destroy')->name('delete.speaker')->middleware('permission:speaker_delete');
            Route::post('/speakers/delete-all', 'SpeakerController@destroyAll')->name('delete-all.speaker')->middleware('permission:speaker_delete');
            Route::post('/speakers/check_email', 'SpeakerController@checkEmail')->name('checkemail.speaker')->middleware('permission:speaker_add');
            Route::get('/speakers/status-update/{id}', 'SpeakerController@statusUpdate')->name('status-update.speaker')->middleware('permission:speaker_edit');
            
			// Category
            Route::get('/categories', 'CategoryController@index')->name('categories')->middleware('permission:category_view');
            Route::post('/categories/get-list', 'CategoryController@getList')->name('categories.list')->middleware('permission:category_view');
            Route::get('/categories/add', 'CategoryController@create')->name('create.category')->middleware('permission:category_add');
            Route::post('/categories/add', 'CategoryController@store')->name('store.category')->middleware('permission:category_add');
            Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('edit.category')->middleware('permission:category_edit');
            Route::post('/categories/edit/{id}', 'CategoryController@update')->name('update.category')->middleware('permission:category_edit');
            Route::get('/categories/delete/{id}', 'CategoryController@destroy')->name('delete.category')->middleware('permission:category_delete');
            Route::post('/categories/delete-all', 'CategoryController@destroyAll')->name('delete-all.categories')->middleware('permission:category_delete');
            Route::post('/categories/check-category', 'CategoryController@checkCategory')->name('checkCategory.category')->middleware('permission:category_add');
            Route::get('/categories/status-update/{id}', 'CategoryController@statusUpdate')->name('status-update.category')->middleware('permission:category_edit');
           
		    // course-level
            Route::get('/course-level', 'CourseLevelController@index')->name('course-level')->middleware('permission:course_level_view');
            Route::post('/course-level/get-list', 'CourseLevelController@getList')->name('course_level.list')->middleware('permission:course_level_view');
            Route::get('/course-level/add', 'CourseLevelController@create')->name('create.course_level')->middleware('permission:course_level_add');
            Route::post('/course-level/add', 'CourseLevelController@store')->name('store.course_level')->middleware('permission:course_level_add');
            Route::get('/course-level/edit/{id}', 'CourseLevelController@edit')->name('edit.course_level')->middleware('permission:course_level_edit');
            Route::post('/course-level/edit/{id}', 'CourseLevelController@update')->name('update.course_level')->middleware('permission:course_level_edit');
            Route::get('/course-level/delete/{id}', 'CourseLevelController@destroy')->name('delete.course_level')->middleware('permission:course_level_delete');
            Route::post('/course-level/delete-all', 'CourseLevelController@destroyAll')->name('delete-all.course_level')->middleware('permission:course_level_delete');
            Route::get('/course-level/status-update/{id}', 'CourseLevelController@statusUpdate')->name('status-update.course_level')->middleware('permission:course_level_edit');
            Route::post('/course-level/check-course-level', 'CourseLevelController@checkCourseLevel')->name('checkCourseLevel.course_level')->middleware('permission:course_level_add');
            Route::get('/course-level/status-update/{id}', 'CourseLevelController@statusUpdate')->middleware('check-permission:manage-course-level')->name('status-update.course_level')->middleware('permission:course_level_edit');
            
			// courses
            Route::get('/course', 'CourseController@index')->name('course-list')->middleware('permission:course_view');
            Route::post('/course/get-list', 'CourseController@getList')->name('course.list')->middleware('permission:course_view');
            Route::get('/course/add', 'CourseController@create')->name('create.course')->middleware('permission:course_add');
            Route::post('/course/add', 'CourseController@store')->name('store.course')->middleware('permission:course_add');
            Route::get('/course/edit/{id}', 'CourseController@edit')->name('edit.course')->middleware('permission:course_edit');
            Route::post('/course/edit/{id}', 'CourseController@update')->name('update.course')->middleware('permission:course_edit');
            Route::get('/course/delete/{id}', 'CourseController@destroy')->name('delete.course')->middleware('permission:course_delete');
            Route::post('/course/delete-all', 'CourseController@destroyAll')->name('delete-all.course')->middleware('permission:course_delete');
            Route::post('/course/check-course', 'CourseController@checkCourse')->name('checkCourse.course')->middleware('permission:course_add');
            Route::get('/course/status-update/{id}', 'CourseController@statusUpdate')->name('status-update.course')->middleware('permission:course_edit');
            
			// User Type
            Route::get('/user-types', 'UserTypeController@index')->name('user-types')->middleware('permission:user_type_view');
            Route::post('/user-types/get-list', 'UserTypeController@getList')->name('user-types.list')->middleware('permission:user_type_view');
            Route::get('/user-types/add', 'UserTypeController@create')->name('create.user-type')->middleware('permission:user_type_add');
            Route::post('/user-types/add', 'UserTypeController@store')->name('store.user-type')->middleware('permission:user_type_add');
            Route::get('/user-types/edit/{id}', 'UserTypeController@edit')->name('edit.user-type')->middleware('permission:user_type_edit');
            Route::post('/user-types/edit/{id}', 'UserTypeController@update')->name('update.user-type')->middleware('permission:user_type_edit');
            Route::get('/user-types/delete/{id}', 'UserTypeController@destroy')->name('delete.user-type')->middleware('permission:user_type_delete');
            Route::post('/user-types/delete-all', 'UserTypeController@destroyAll')->name('delete-all.user-types')->middleware('permission:user_type_delete');
            Route::post('/user-types/check-user-type', 'UserTypeController@checkUserType')->name('checkUserType.user-type')->middleware('permission:user_type_add');
            Route::get('/user-types/status-update/{id}', 'UserTypeController@statusUpdate')->name('status-update.user-type')->middleware('permission:user_type_edit');
			
			// Category
            Route::get('/subjects', 'SubjectController@index')->middleware('permission:subject_view')->name('subjects');
            Route::post('/subjects/get-list', 'SubjectController@getList')->middleware('permission:subject_view')->name('subjects.list');
            Route::get('/subjects/add', 'SubjectController@create')->middleware('permission:subject_add')->name('create.subject');
            Route::post('/subjects/add', 'SubjectController@store')->middleware('permission:subject_add')->name('store.subject');
            Route::get('/subjects/edit/{id}', 'SubjectController@edit')->middleware('permission:subject_edit')->name('edit.subject');
            Route::post('/subjects/edit/{id}', 'SubjectController@update')->middleware('permission:subject_edit')->name('update.subject');
            Route::get('/subjects/delete/{id}', 'SubjectController@destroy')->middleware('permission:subject_delete')->name('delete.subject');
            Route::post('/subjects/delete-all', 'SubjectController@destroyAll')->middleware('permission:subject_delete')->name('delete-all.subjects');
            Route::post('/subjects/check-subject', 'SubjectController@checkSubject')->middleware('permission:subject_view')->name('checkSubject.subject');
            Route::get('/subjects/status-update/{id}', 'SubjectController@statusUpdate')->middleware('permission:subject_edit')->name('status-update.subject');
           
		    // Tags
			Route::get('/tags', 'TagController@index')->middleware('permission:tag_view')->name('tags');
			Route::post('/tags/get-list', 'TagController@getList')->middleware('permission:tag_view')->name('tags.list');
			Route::get('/tags/add', 'TagController@create')->middleware('permission:tag_add')->name('create.tag');
			Route::post('/tags/add', 'TagController@store')->middleware('permission:tag_add')->name('store.tag');
			Route::get('/tags/edit/{id}', 'TagController@edit')->middleware('permission:tag_edit')->name('edit.tag');
			Route::post('/tags/edit/{id}', 'TagController@update')->middleware('permission:tag_edit')->name('update.tag');
			Route::get('/tags/delete/{id}', 'TagController@destroy')->middleware('permission:tag_delete')->name('delete.tag');
			Route::post('/tags/delete-all', 'TagController@destroyAll')->middleware('permission:tag_delete')->name('delete-all.tags');
			Route::post('/tags/check-tag', 'TagController@checkTag')->middleware('permission:tag_view')->name('checkTag.tag');
			Route::get('/tags/status-update/{id}', 'TagController@statusUpdate')->middleware('permission:tag_edit')->name('status-update.tags');
			
            // Team
            Route::get('/team', 'TeamController@index')->middleware('permission:team_view')->name('team');
            Route::post('/team/get-list', 'TeamController@getList')->middleware('permission:team_view')->name('team.list');
            Route::get('/team/add', 'TeamController@create')->middleware('permission:team_add')->name('create.team');
            Route::post('/team/add', 'TeamController@store')->middleware('permission:team_add')->name('store.team');
            Route::get('/team/edit/{id}', 'TeamController@edit')->middleware('permission:team_edit')->name('edit.team');
            Route::post('/team/edit/{id}', 'TeamController@update')->middleware('permission:team_edit')->name('update.team');
            Route::get('/team/delete/{id}', 'TeamController@destroy')->middleware('permission:team_delete')->name('delete.team');
            Route::post('/team/delete-all', 'TeamController@destroyAll')->middleware('permission:team_delete')->name('delete-all.team');
            Route::get('/team/status-update/{id}', 'TeamController@statusUpdate')->middleware('permission:team_edit')->name('status-update.team');
            Route::post('/team/check-email', 'TeamController@checkEmail')->middleware('permission:team_view')->name('checkEmail.team');

            // Webinars
			Route::get('/webinars', 'WebinarController@index')->middleware('permission:webinar_view')->name('webinar');
            Route::post('/webinars/get-list', 'WebinarController@getList')->middleware('permission:webinar_view')->name('webinar.list');
            Route::get('/webinars/edit/{id}', 'WebinarController@edit')->middleware('permission:webinar_edit')->name('edit.webinar');
            Route::post('/webinars/edit/{id}', 'WebinarController@update')->middleware('permission:webinar_edit')->name('update.webinar');
            Route::get('/webinars/edit-status/{id}', 'WebinarController@editStatus')->middleware('permission:webinar_edit')->name('edit.webinar_status');
            Route::get('/webinars/{id}/status/{status}', 'WebinarController@updateStatus')->middleware('permission:webinar_edit')->name('update.webinar_status');
			
			
			// Live Webinar
			//Route::get('fintech',['as'=>'fintech.index','uses'=>'FintechController@index', 'middleware' => ['permission:fintech_add|fintech_edit|fintech_delete|fintech_view|fintech_status']]);
            Route::get('/live-webinar', 'LiveWebinarController@index')->name('live-webinar')->middleware('permission:live_webinar_view');
			Route::get('/live-webinar/create', 'LiveWebinarController@create')->name('live-webinar.create')->middleware('permission:live_webinar_add');
			Route::post('/live-webinar/store', 'LiveWebinarController@store')->name('live-webinar.store')->middleware('permission:live_webinar_add');
			Route::get('/live-webinar/edit/{id}', 'LiveWebinarController@edit')->name('live-webinar.edit')->middleware('permission:live_webinar_edit');
			Route::post('/live-webinar/update', 'LiveWebinarController@update')->name('live-webinar.update')->middleware('permission:live_webinar_edit');
			Route::get('/live-webinar/delete/{id}', 'LiveWebinarController@destroy')->name('live-webinar.delete')->middleware('permission:live_webinar_delete');
			Route::get('/live-webinar/view/{id}', 'LiveWebinarController@show')->name('live-webinar.view')->middleware('permission:live_webinar_view');
			Route::post('/live-webinar/check-availability', 'LiveWebinarController@checkAvailability')->name('live-webinar.check-availability')->middleware('permission:live_webinar_view');
			Route::post('/live-webinar/check-availability-final', 'LiveWebinarController@checkAvailabilityFinal')->name('live-webinar.check-availability-final')->middleware('permission:live_webinar_view');
			Route::post('/live-webinar/delete-all', 'LiveWebinarController@destroyAll')->name('live-webinar.delete-all')->middleware('permission:live_webinar_delete');
            Route::get('/live-webinar/webinars/create/{id}', 'LiveWebinarController@createWebinar')->name('live-webinar.webinars.create')->middleware('permission:live_webinar_add');
			Route::get('/live-webinar/view/{id}', 'LiveWebinarController@view')->name('live-webinar.view')->middleware('permission:live_webinar_view');
			Route::any('/live-webinar/update-status', 'LiveWebinarController@statusUpdate')->name('live-webinar.updateStatus')->middleware('permission:live_webinar_edit');
			Route::post('/live-webinar/update-series', 'LiveWebinarController@updateSeries')->name('updateSeries')->middleware('permission:live_webinar_edit');
        
		
		    
            //Archive Webinar
            Route::get('/archive-webinar', 'ArchiveWebinarController@index')->middleware('permission:archive_webinar_view')->name('archive-webinar');
            Route::get('/archive-webinar/view/{id}', 'ArchiveWebinarController@view')->middleware('permission:archive_webinar_view')->name('archive-webinar.view');
            Route::get('/archive-webinar/delete/{id}', 'ArchiveWebinarController@destroy')->middleware('permission:archive_webinar_delete')->name('archive-webinar.delete');
             
            Route::get('/archive-webinar/update-status/{id}/{status}', 'ArchiveWebinarController@statusUpdate')->middleware('permission:archive_webinar_view')->name('archive-webinar.updateStatus');
            
			Route::any('/archive-webinar/update-video-status', 'ArchiveWebinarController@videoStatusUpdate')->middleware('permission:selfstudy_webinar_edit')->name('archive-webinar.updateVideoStatus');
            
			Route::get('/archive-webinar/edit/{id}', 'ArchiveWebinarController@edit')->middleware('permission:archive_webinar_edit')->name('archive-webinar.edit');
            Route::post('/archive-webinar/update', 'ArchiveWebinarController@update')->middleware('permission:archive_webinar_edit')->name('archive-webinar.update');
            Route::post('/archive-webinar/store_video', 'ArchiveWebinarController@store_video')->middleware('permission:archive_webinar_add')->name('archive-webinar.store_video');
            

			// Companies
            Route::get('/companies', 'CompanyController@index')->name('companies')->middleware('permission:company_view');
            Route::post('/companies/get-list', 'CompanyController@getList')->name('companies-list')->middleware('permission:company_view');
            Route::get('/companies/add', 'CompanyController@create')->middleware('permission:company_add')->name('create.company');
            Route::post('/companies/add', 'CompanyController@store')->middleware('permission:company_add')->name('store.company');
            Route::get('/companies/edit/{id}', 'CompanyController@edit')->middleware('permission:company_edit')->name('edit.company');
            Route::post('/companies/edit/{id}', 'CompanyController@update')->middleware('permission:company_edit')->name('update.company');
            Route::get('/companies/status-update/{id}', 'CompanyController@statusUpdate')->name('status-update.companies')->middleware('permission:company_edit');
            Route::get('/companies/delete/{id}', 'CompanyController@destroy')->middleware('permission:company_delete')->name('delete.company');
            Route::post('/companies/delete-all', 'CompanyController@destroyAll')->name('delete-all.companies')->middleware('permission:company_delete');
            Route::post('/companies/check-email', 'CompanyController@checkEmail')->name('checkEmail.company')->middleware('permission:company_view');
            Route::post('/companies/check-company-name', 'CompanyController@checkCompanyName')->name('checkCompanyName.company')->middleware('permission:company_view');
			
			//self study webinar
			Route::get('/selfstudy-webinar', 'SelfStudyWebinarController@index')->middleware('permission:selfstudy_webinar_view')->name('selfstudy-webinar');
			 Route::get('/selfstudy-webinar/edit/{id}', 'SelfStudyWebinarController@edit')->middleware('permission:selfstudy_webinar_edit')->name('selfstudy-webinar.edit');
			 Route::post('/selfstudy-webinar/update', 'SelfStudyWebinarController@update')->middleware('permission:selfstudy_webinar_edit')->name('selfstudy-webinar.update');
			 Route::get('/selfstudy-webinar/delete/{id}', 'SelfStudyWebinarController@destroy')->middleware('permission:selfstudy_webinar_delete')->name('selfstudy-webinar.delete');
			 Route::post('/selfstudy-webinar/store', 'SelfStudyWebinarController@store')->middleware('permission:selfstudy_webinar_add')->name('selfstudy-webinar.store');
			 Route::get('/selfstudy-webinar/create', 'SelfStudyWebinarController@create')->middleware('permission:selfstudy_webinar_add')->name('selfstudy-webinar.create');
			 Route::get('/selfstudy-webinar/view/{id}', 'SelfStudyWebinarController@view')->middleware('permission:selfstudy_webinar_view')->name('selfstudy-webinar.view');
			 Route::any('/selfstudy-webinar/update-status', 'SelfStudyWebinarController@statusUpdate')->middleware('permission:selfstudy_webinar_edit')->name('selfstudy-webinar.updateStatus');
             Route::any('/selfstudy-webinar/update-series', 'SelfStudyWebinarController@updateSeries')->middleware('permission:selfstudy_webinar_edit')->name('updateSeries');
			 Route::get('/selfstudy-webinar/{id}/video', 'SelfStudyWebinarController@video')->middleware('permission:selfstudy_webinar_view')->name('selfystudy-webinar.video');
             Route::post('/selfstudy-webinar/store_video', 'SelfStudyWebinarController@store_video')->middleware('permission:selfstudy_webinar_add')->name('selfystudy-webinar.store_video');
			
			//new route for add question at create webinar
			Route::get('/selfstudy-webinars/{enc_id}/add-webinar-question', 'SelfStudyWebinarController@addQuestion')->middleware('permission:selfstudy_webinar_add')->name('selfystudy.add_webinar_question');
			Route::post('/selfstudy-webinars/store-webinar-question', 'SelfStudyWebinarController@storeQuestion')->middleware('permission:selfstudy_webinar_add')->name('selfystudy.store_webinar_question');
			Route::get('/selfstudy-webinars/edit-webinar-question/{qus_id}', 'SelfStudyWebinarController@editQuestion')->middleware('permission:selfstudy_webinar_edit')->name('selfystudy.edit_webinar_question');
			Route::post('/selfstudy-webinars/update-webinar-question', 'SelfStudyWebinarController@updateQuestion')->middleware('permission:selfstudy_webinar_edit')->name('selfystudy.update_webinar_question');
			Route::get('/selfstudy-webinars/delete-question/{qus_id}', 'SelfStudyWebinarController@destroyQuestion')->middleware('permission:selfstudy_webinar_delete')->name('selfystudy.webinar_questions_delete-question');
				  
			
			//* Series listing
			 Route::get('/series', 'SeriesController@index')->middleware('permission:series_view')->name('series');
			 Route::get('/series/edit/{id}', 'SeriesController@edit')->middleware('permission:series_edit')->name('series.edit');
			 Route::post('/series/update', 'SeriesController@update')->middleware('permission:series_edit')->name('series.update');
			 Route::get('/series/delete/{id}', 'SeriesController@destroy')->middleware('permission:series_delete')->name('series.delete');
			 Route::post('/series/store', 'SeriesController@store')->middleware('permission:series_add')->name('series.store');
			 Route::get('/series/create', 'SeriesController@create')->middleware('permission:series_add')->name('series.create');
			 Route::get('/series/view/{id}', 'SeriesController@view')->middleware('permission:series_view')->name('series.view');
			 Route::get('/series/update-status/{id}/{status}', 'SeriesController@statusUpdate')->middleware('permission:series_view')->name('series.updateStatus');
			 
			Route::get('/webinar-payment-history', 'WebinarPaymentHistoryController@index')->middleware('permission:payment_history_view')->name('webinar-payment-history');

			 //* PermissionController
			 Route::get('/permission', 'PermissionController@index')->name('permission')->middleware('permission:permission_view');
			 Route::get('/permission/edit/{id}', 'PermissionController@edit')->name('permission.edit')->middleware('permission:permission_edit');
			 Route::get('/permission/create', 'PermissionController@create')->name('permission.create')->middleware('permission:permission_add');
			 Route::post('/permission/store', 'PermissionController@store')->name('permission.store')->middleware('permission:permission_add');
			 Route::post('/permission/update', 'PermissionController@update')->name('permission.update')->middleware('permission:permission_edit');
			 Route::get('/permission/delete/{id}', 'PermissionController@destroy')->name('permission.delete')->middleware('permission:permission_delete');
			 Route::get('/permission/update-status/{id}/{status}', 'PermissionController@statusUpdate')->name('permission.updateStatus')->middleware('permission:permission_edit');
			 
			 //* UsersController
			  Route::get('/users', 'UsersController@index')->name('users')->middleware('permission:front_user_view');
			  Route::get('/users/delete/{enc_id}', 'UsersController@destroy')->name('users.delete')->middleware('permission:front_user_delete');
			  Route::get('/users/update-status/{id}/{status}', 'UsersController@statusUpdate')->name('users.updateStatus')->middleware('permission:front_user_edit');
			  Route::get('/users/view/{enc_id}', 'UsersController@view')->middleware('check-permission:manage-users')->name('users.view')->middleware('permission:front_user_view');
			  
			//AttendiesController
			Route::get('/webinar-user-register', 'WebinarUserRegisterController@index')->name('webinar-user-register')->middleware('permission:attendee_view');
			Route::get('/add-webinar-attendees/{id}', 'WebinarUserRegisterController@addAttendees')->name('add-webinar-attendees')->middleware('permission:attendee_add');
			Route::get('webinar-user-register-attendees/{id}', 'WebinarUserRegisterController@CreateAttendees')->name('webinar-user-register-attendees')->middleware('permission:attendee_add');
			 
			 
            if (Request::getHost() === env('APP_ADMIN_URL')) {
                commonRoutes();
            }
        });
    });
    

    //Common Route Fiels For DropZone
    Route::delete('/dropzone-files', 'DropZoneController@deleteFiles')->name('delete.temp_dropzone_files');

    Route::post('/dropzone-files', 'DropZoneController@uploadFiles')->name('upload.temp_dropzone_files');

    
    
    Route::domain(env('SPEAKER_URL'))->group(function () {
        
        Route::group(['namespace' => 'FrontEnd', 'middleware' => []], function () {
            Route::get('/signup', 'SpeakerController@signup')->name('frontend.speaker.signup');
            Route::post('/signup', 'SpeakerController@signup')->name('frontend.speaker.signup_submit');

            Route::get('/compnay-signup', 'CompanyController@signup')->name('frontend.company.signup');
            Route::post('/compnay-signup', 'CompanyController@signup')->name('frontend.company.signup_submit');

        });

        Route::group(['middleware' => ['speaker-guest']], function () {
            Route::get('/', 'SpeakerAuth\LoginController@showLoginForm')->name('show-speaker-login-form');
            Route::post('/', 'SpeakerAuth\LoginController@login')->name('speaker-login-form');
            Route::get('/login', 'SpeakerAuth\LoginController@showLoginForm')->name('show.speaker.login');
            Route::post('/login', 'SpeakerAuth\LoginController@login')->name('speaker.login');
            Route::get('/forgot-password', 'SpeakerAuth\ForgotPasswordController@showLinkRequestForm')->name('speaker.email.reset.form');
            Route::post('/forgot-password/', 'SpeakerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
            Route::post('/forgot-password/check-email', 'SpeakerAuth\ForgotPasswordController@checkEmail')->name('forgot.password.checkEmail');
            Route::post('/reset/check-email', 'SpeakerAuth\ResetPasswordController@checkEmail')->name('reset.checkEmail');
            Route::get('/reset/{token}', 'SpeakerAuth\ResetPasswordController@showResetForm')->name('speaker.reset.form');
            Route::post('/password/reset/', 'SpeakerAuth\ResetPasswordController@reset')->name('speaker.reset.password');
        });
        Route::group(['middleware' => ['speaker']], function () {
            // Accounts
            Route::group(['namespace' => 'Speaker'], function() {
                Route::get('/dashboard', 'AccountsController@dashboard')->name('speaker.dashboard');

                Route::get('/edit-profile', 'AccountsController@showEditForm')->name('speaker.edit.form');
                Route::post('/edit-profile', 'AccountsController@editProfile')->name('speaker.edit.profile');
                Route::post('/account/check_email', 'AccountsController@checkEmail')->name('speaker.checkemail');
                Route::post('/account/check-password', 'AccountsController@checkPassword')->name('speaker.checkpassword');



                Route::get('/speaker_notification', 'SpeakerNotificationController@speaker_notification')->name('speaker.speaker_notification');





                // Webinar
                Route::get('/webinar', 'WebinarController@index')->middleware('check-permission:manage-webinar')->name('speaker.webinar');
                Route::get('/webinar/create', 'WebinarController@create')->middleware('check-permission:manage-webinar')->name('speaker.webinar.create');
                Route::post('/webinar/store', 'WebinarController@store')->middleware('check-permission:manage-webinar')->name('speaker.webinar.store');
                Route::get('/webinar/edit/{enc_id}', 'WebinarController@edit')->middleware('check-permission:manage-webinar')->name('speaker.webinar.edit');
                Route::post('/webinar/update', 'WebinarController@update')->middleware('check-permission:manage-webinar')->name('speaker.webinar.update');
                Route::get('/webinar/delete/{enc_id}', 'WebinarController@destroy')->middleware('check-permission:manage-webinar')->name('speaker.webinar.delete');
                Route::get('/webinar/view/{enc_id}', 'WebinarController@show')->middleware('check-permission:manage-webinar')->name('speaker.webinar.view');
				Route::post('/webinar/check-availability', 'WebinarController@checkAvailability')->middleware('check-permission:manage-webinar')->name('speaker.webinar.check-availability');
				Route::post('/webinar/check-availability-final', 'WebinarController@checkAvailabilityFinal')->middleware('check-permission:manage-webinar')->name('speaker.webinar.check-availability-final');
				Route::get('/webinar/view/{enc_id}', 'WebinarController@view')->middleware('check-permission:manage-webinar')->name('speaker.webinar.view');
                Route::get('/webinar/speaker_invitation/{sid}', 'WebinarController@speaker_invitation')->middleware('check-permission:manage-webinar')->name('speaker.webinar.speaker_invitation');
                Route::post('/webinar/speaker_invitation_update', 'WebinarController@speaker_invitation_update')->middleware('check-permission:manage-webinar')->name('speaker.webinar.speaker_invitation_update');
				
				
 				// SelfStudyWebinarController
                Route::get('/selfstudy-webinars', 'SelfStudyWebinarController@index')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars');
                Route::get('/selfstudy-webinars/create', 'SelfStudyWebinarController@create')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.create');
                Route::post('/selfstudy-webinars/store', 'SelfStudyWebinarController@store')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.store');
                Route::get('/selfstudy-webinars/edit/{enc_id}', 'SelfStudyWebinarController@edit')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.edit');
                Route::post('/selfstudy-webinars/update', 'SelfStudyWebinarController@update')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.update');
                Route::get('/selfstudy-webinars/delete/{enc_id}', 'SelfStudyWebinarController@destroy')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.delete');
                Route::get('/selfstudy-webinars/view/{enc_id}', 'SelfStudyWebinarController@show')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.view');
                Route::get('/selfstudy-webinars/view/{enc_id}', 'SelfStudyWebinarController@view')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.view');
                
                Route::post('/selfstudy-webinars/check-availability', 'SelfStudyWebinarController@checkAvailability')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.check-availability');
                Route::post('/selfstudy-webinars/check-availability-final', 'SelfStudyWebinarController@checkAvailabilityFinal')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.check-availability-final');
                Route::get('/selfstudy-webinars/{enc_id}/video', 'SelfStudyWebinarController@video')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.video');
                Route::post('/selfstudy-webinars/store_video', 'SelfStudyWebinarController@store_video')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.self_study_webinars.store_video');
				
				//new route for add question at create webinar
				Route::get('/selfstudy-webinars/{enc_id}/add-webinar-question', 'SelfStudyWebinarController@addQuestion')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.add_webinar_question');
				Route::post('/selfstudy-webinars/store-webinar-question', 'SelfStudyWebinarController@storeQuestion')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.store_webinar_question');
				Route::get('/selfstudy-webinars/edit-webinar-question/{qus_id}', 'SelfStudyWebinarController@editQuestion')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.edit_webinar_question');
				Route::post('/selfstudy-webinars/update-webinar-question', 'SelfStudyWebinarController@updateQuestion')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.update_webinar_question');
                Route::get('/selfstudy-webinars/delete-question/{qus_id}', 'SelfStudyWebinarController@destroyQuestion')->middleware('check-permission:manage-webinar')->name('speaker.webinar_questions_delete-question');
				 
				   
				      
				//Archived webinar
				 Route::get('/archived-webinar', 'ArchivedWebinarController@index')->middleware('check-permission:manage-webinar')->name('speaker.archived-webinar');
				 Route::get('/archived-webinar/view/{enc_id}', 'ArchivedWebinarController@view')->middleware('check-permission:manage-selfystudy-webinar')->name('speaker.archived-webinar.view');
                
				 //SelfStudyQuestionsController 
 				Route::get('/webinar-questions', 'WebinarQuestionsController@index')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions');
				Route::get('/webinar-questions/create', 'WebinarQuestionsController@create')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions.create');
				Route::post('/webinar-questions/store', 'WebinarQuestionsController@store')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions.store');
				Route::get('/webinar-questions/edit/{enc_id}', 'WebinarQuestionsController@edit')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions.edit');
				Route::post('/webinar-questions/update', 'WebinarQuestionsController@update')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions.update');
				Route::get('/webinar-questions/delete/{enc_id}', 'WebinarQuestionsController@destroy')->middleware('check-permission:manage-webinar')->name('speaker.webinar-questions.delete');
				
				
				//Webinar Invitation Controller 
 				Route::get('/webinar-invitation', 'WebinarInvitationController@index')->name('speaker.webinar-invitation');
				Route::get('/webinar-invitation/view/{enc_id}', 'WebinarInvitationController@view')->name('speaker.webinar-invitation.view');
				Route::any('/webinar-invitation/update-status', 'WebinarInvitationController@updateStatus')->name('speaker.webinar-invitation.updateStatus');
            	Route::get('/webinar-invitation/create-co-organizer/{id}', 'WebinarInvitationController@CreateCoOrganizer')->name('speaker.speaker_invitation.create-co-organizer');
				
				//WebinarUserRegisterController
				Route::get('/webinar-user-register', 'WebinarUserRegisterController@index')->name('speaker.webinar-user-register');
               
            });
            Route::get('/logout', 'SpeakerAuth\LoginController@logout')->name('speaker.logout');
            if (Request::getHost() === env('APP_URL')) {
                commonRoutes();
            }
        });
    });
	
	
	
	Route::domain(env('COMPANY_URL'))->group(function () {
        Route::group(['middleware' => ['company-guest']], function () {
            Route::get('/', 'CompanyAuth\LoginController@showLoginForm')->name('show-company-login-form');
            Route::post('/', 'CompanyAuth\LoginController@login')->name('company-login-form');
            Route::get('/login', 'CompanyAuth\LoginController@showLoginForm')->name('show.company.login');
            Route::post('/login', 'CompanyAuth\LoginController@login')->name('company.login');
			
            Route::get('/forgot-password', 'CompanyAuth\ForgotPasswordController@showLinkRequestForm')->name('company.email.reset.form');
            Route::post('/forgot-password/', 'CompanyAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.reset');
            Route::post('/forgot-password/check-email', 'CompanyAuth\ForgotPasswordController@checkEmail')->name('forgot.password.checkEmail');
            Route::post('/reset/check-email', 'CompanyAuth\ResetPasswordController@checkEmail')->name('reset.checkEmail');
            Route::get('/reset/{token}', 'CompanyAuth\ResetPasswordController@showResetForm')->name('company.reset.form');
            Route::post('/password/reset/', 'CompanyAuth\ResetPasswordController@reset')->name('company.reset.password');
			
			//for update password
			Route::get('company-change-password/{url_link}', 'CompanyAuth\ForgotPasswordController@userPasswordReset')->name('company-change-password');
			Route::post('company-update-password', 'CompanyAuth\ForgotPasswordController@updateUserPassword')->name('company-update-password');
        });
		
        Route::group(['middleware' => ['company']], function () {
            // Accounts
            Route::group(['namespace' => 'Company'], function() {
                Route::get('/dashboard', 'AccountsController@dashboard')->name('company.dashboard');
                Route::get('/edit-profile/{id}', 'AccountsController@edit')->name('company-edit');
                Route::post('/edit-profile/{id}', 'AccountsController@update')->name('company-edit-profile');
            });
			
            Route::get('/logout', 'CompanyAuth\LoginController@logout')->name('company.logout');
			if (Request::getHost() === env('COMINGSOON_URL')) {
				commonRoutes();
			}
        });
    });
	
	
	
	
});

	//USERside  routes//////////////////////////////////////////////////////////////////////////////
 
    Route::domain(env('APP_URL'))->group(function () {
    	Route::group(['namespace' => 'User'], function () {
            
			Route::get('/', 'IndexController@index')->name('user.index');
			Route::get('team', 'TeamController@index')->name('team.index');
			
			// Route::get('confirm/{id}', ['as'=>'confirm','uses'=>'ClientController@confirm']);
			Route::get('confirm/{user_data}', 'ClientController@confirm')->name('confirm');
			Route::post('client/check', 'ClientController@check')->name('client.check');
			Route::get('client-logout', 'ClientController@logout')->name('client-logout');
			Route::post('client/forgot-password', 'ClientController@resetpassword')->name('client.resetpassword');
			Route::post('client/store', 'ClientController@store')->name('client.store');
			
			//for update password
			Route::get('change-password/{url_link}', 'ClientController@userPasswordReset')->name('change-password');
			Route::post('update-password', 'ClientController@updateUserPassword')->name('update-password');
			//Route::post('client/check',['as'=>'client.check','uses'=>'ClientController@check']);
			
			
			//Contact us Controller
			Route::get('contact-us', 'ContactUsController@index')->name('contact-us');
			Route::post('contact-us/store', 'ContactUsController@store')->name('contact-us-store');
			
			//Error Controller
			Route::get('error', 'ErrorController@index')->name('error');
			
			//FAQ Controller
			Route::get('faq', 'FaqController@index')->name('faq');
			
			//Course Controller
			Route::get('course', 'CourseController@index')->name('course');
			Route::get('course-detail/{string?}', 'CourseController@detail')->name('course-detail');
			Route::post('course-question', 'CourseController@storeQuestion')->name('course-question');
			Route::get('course-change-timezone', 'CourseController@changeTimezone')->name('course-change-timezone');
			Route::post('course-calculate-video-time', 'CourseController@calculateVideoTime')->name('course-calculate-video-time');
			Route::post('course-update-selfstudy-video', 'CourseController@updateVideoTimeDuration')->name('course-update-selfstudy-video-duration');
			Route::get('course-register/{webinar_id}', 'CourseController@webinarRegister')->name('course-register');
			Route::get('course-register-payment/{webinar_id}', 'CourseController@webinarRegisterPayment')->name('course-register-payment');
			Route::post('course-payment', 'CourseController@makePayment')->name('course-payment');
			//Route::get('course-create-webinar-attendees/{id}', 'CourseController@CreateAttendees')->name('course-create-webinar-attendees');
			
			// Pdf controller
			Route::get('generate-pdf','PdfController@generatePDF');
			
			/////////////////////////j page ma login required hoy ae aama mukava ----- START
			Route::group(array('middleware'=>'checkClient'), function() {
				Route::get('register', 'ClientController@register')->name('client.register');
				Route::get('forgot-password', 'ClientController@forgotpassword')->name('client.forgotpassword');
				
				//Course Controller
				Route::get('course-like', 'CourseController@webinarLike')->name('course.like');
				//Speaker Controller
				Route::get('speaker-follow', 'SpeakerController@speakerFollow')->name('speaker.follow');
			});
			////////////////////////////////////j page ma login required hoy ae aama mukava--------- END
        });
	});



	
	/////////////////////////ComingSoon Front///////////////////////////////
	
	Route::domain(env('COMINGSOON_URL'))->group(function () {
    	Route::group(['namespace' => 'ComingSoon'], function () {
        	Route::get('/', 'IndexController@index')->name('comingsoon.index');
			
			//Course Controller
			Route::get('comingsoon-course', 'CourseController@index')->name('comingsoon-course');
			Route::get('comingsoon-course-detail/{string?}', 'CourseController@detail')->name('comingsoon-course-detail');
			Route::post('comingsoon-course-question', 'CourseController@storeQuestion')->name('comingsoon-course-question');
			Route::get('comingsoon-course-change-timezone', 'CourseController@changeTimezone')->name('comingsoon-course-change-timezone');
			Route::post('comingsoon-course-calculate-video-time', 'CourseController@calculateVideoTime')->name('comingsoon-course-calculate-video-time');
			Route::post('comingsoon-course-update-selfstudy-video', 'CourseController@updateVideoTimeDuration')->name('comingsoon-course-update-selfstudy-video-duration');
			Route::get('comingsoon-course-register/{webinar_id}', 'CourseController@webinarRegister')->name('comingsoon-course-register');
			Route::get('comingsoon-course-register-payment/{webinar_id}', 'CourseController@webinarRegisterPayment')->name('comingsoon-course-register-payment');
			Route::post('comingsoon-course-payment', 'CourseController@makePayment')->name('comingsoon-course-payment');
			
			//register process
			Route::get('comingsoon-confirm/{string}', 'ClientController@confirm')->name('comingsoon-confirm');
			Route::get('comingsoon-register', 'ClientController@register')->name('comingsoon-client-register');
			Route::post('comingsoon-client-store', 'ClientController@store')->name('comingsoon-client-store');
			
			////////////////////////////////////j page ma login required hoy ae aama mukava--------- END
        });
	}); 


Route::get('/speakers/add', 'SpeakerController@create')->name('create.speaker');
Route::post('/speakers/add', 'SpeakerController@store')->name('store.speaker');
Route::post('/states/get-state', 'StateController@getState')->name('get_state.state');
Route::post('/cities/get-city', 'CityController@getCity')->name('delete.city');
Route::post('/speakers/check_email', 'SpeakerController@checkEmail')->name('checkemail.speaker');


