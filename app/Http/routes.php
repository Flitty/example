<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'IndexController@index');
    Route::get('/user/{id}', 'IndexController@user');
    Route::get('/community/{url}/wall', 'IndexController@group');
    Route::get('/test/support/form', 'Api\SupportController@index');
    Route::post('/test/support/form/send', 'Api\SupportController@sendMail');

    Route::get('redirect', 'SocialAuthController@redirect');
    Route::get('callback', 'SocialAuthController@callback');

    Route::get('redirect_twitter', 'SocialAuthController@redirect_twitter');
    Route::get('callback_twitter', 'SocialAuthController@callback_twitter');

    Route::get('redirect_google', 'SocialAuthController@redirect_google');
    Route::get('callback_google', 'SocialAuthController@callback_google');

    Route::get('redirect_steam', 'SocialAuthController@redirect_steam');
    Route::group(['prefix' => 'api/yandex'], function() {
        Route::get('redirect', 'YandexDiskController@initialization');
        Route::get('callback', 'YandexDiskController@yandexCallback');
        Route::get('test', 'YandexDiskController@test');

    });

    Route::group(['prefix' => 'admin', 'middleware' => ['admin', 'auth']], function () {
        Route::get('/', 'Admin\IndexController@index');
        Route::group(['prefix' => 'bot'], function () {
            Route::get('/', 'Admin\BotController@index');
            Route::get('crefate', 'Admin\BotController@create');
            Route::post('store', 'Admin\BotController@store');
            Route::get('delete/{id}', 'Admin\BotController@delete');
            Route::get('edit/{id}', 'Admin\BotController@edit');
            Route::get('start/{id}', 'Admin\BotController@start');
            Route::get('stop/{id}', 'Admin\BotController@stop');
            Route::get('restart/{id}', 'Admin\BotController@restart');
            Route::post('update/{id}', 'Admin\BotController@update');
            Route::get('show/{id}', 'Admin\BotController@show');
        });
        Route::group(['prefix' => 'base'], function () {
            Route::get('/', 'Admin\CountryController@index');
            Route::post('create_сountry', 'Admin\CountryController@createCountry');
            Route::get('edit_сountry/{id}', 'Admin\CountryController@editCountry');
            Route::post('edit_country_save', 'Admin\CountryController@editCountrySave');
            Route::get('region', 'Admin\CountryController@region');
            Route::post('create_region', 'Admin\CountryController@createRegion');
            Route::get('edit_region/{id}/{country_id}', 'Admin\CountryController@editRegion');
            Route::post('edit_region_save', 'Admin\CountryController@editRegionSave');
            Route::get('district', 'Admin\CountryController@district');
            Route::post('create_district', 'Admin\CountryController@createDistrict');
            Route::get('edit_district/{id}', 'Admin\CountryController@editDistrict');
            Route::post('edit_district_save', 'Admin\CountryController@editDistrictSave');
            Route::get('settlement', 'Admin\CountryController@settlement');
            Route::post('create_settlement', 'Admin\CountryController@createSettlement');
            Route::get('edit_settlement/{id}', 'Admin\CountryController@editSettlement');
            Route::post('edit_settlement_save', 'Admin\CountryController@editSettlementSave');
            Route::get('get_region/{id}', 'Admin\CountryController@getRegion');
            Route::get('get_area/{id}', 'Admin\CountryController@getArea');
            Route::get('get_city', 'Admin\CountryController@getCity');

        });
        Route::group(['prefix' => 'finance'], function () {
            Route::get('/', 'Admin\FinanceController@index');
            Route::post('/update', 'Admin\FinanceController@update');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'Admin\UsersController@index');
            Route::get('/search', 'Admin\UsersController@search');
            Route::get('/sort/{sort}', 'Admin\UsersController@sortBy');
            Route::post('/create_mail', 'Admin\UsersController@createMail');
            Route::post('/send_mail', 'Admin\UsersController@sendMail');
            Route::post('/counter', 'Admin\UsersController@counter');
            Route::get('/user_statistic/{id}', 'Admin\UsersController@statistic');
            Route::post('/get_statistic_data', 'Admin\UsersController@getStatistic');
        });
        Route::group(['prefix' => 'partner'], function () {
            Route::get('/', 'Admin\PartnerController@index');
            Route::get('/search', 'Admin\PartnerController@search');
            Route::get('/sort/{sort}', 'Admin\PartnerController@sortBy');
            Route::post('/counter', 'Admin\PartnerController@counter');
            Route::get('/change/{id}', 'Admin\PartnerController@change');
//            Route::post('/delete/{id}', 'Admin\PartnerController@change');
            Route::post('/save_changes', 'Admin\PartnerController@saveChanges');

        });
        Route::group(['prefix' => 'sticker'], function () {
            Route::get('/', 'Admin\StickerController@index');
            Route::get('/approval', 'Admin\StickerController@approval');
            Route::get('/createGroup', 'Admin\StickerController@createGroup');
            Route::post('/storeGroup', 'Admin\StickerController@storeGroup');
            Route::get('/editGroup/{id}', 'Admin\StickerController@editGroup');
            Route::get('/deleteGroup/{id}', 'Admin\StickerController@deleteGroup');
            Route::get('/showGroup/{id}', 'Admin\StickerController@showGroup');
            Route::post('/updateGroup/{id}', 'Admin\StickerController@updateGroup');
            Route::get('/createSticker/{id}', 'Admin\StickerController@createSticker');
            Route::post('/storeSticker', 'Admin\StickerController@storeSticker');
            Route::get('/editSticker/{id}', 'Admin\StickerController@editSticker');
            Route::get('/deleteSticker/{id}', 'Admin\StickerController@deleteSticker');
            Route::post('/updateSticker/{id}', 'Admin\StickerController@updateSticker');
        });
        Route::group(['prefix' => 'sticker_category'], function () {
            Route::get('/index/', 'Admin\StickerCategoryController@index');
            Route::get('/create/', 'Admin\StickerCategoryController@create');
            Route::get('/edit/{id}', 'Admin\StickerCategoryController@edit');
            Route::get('/destroy/{id}', 'Admin\StickerCategoryController@destroy');
            Route::post('/update/{id}', 'Admin\StickerCategoryController@update');
            Route::post('/store/', 'Admin\StickerCategoryController@store');
        });
        Route::group(['prefix' => 'call_back'], function () {
            Route::get('/', 'Admin\CallBackController@index');
            Route::get('/delay', 'Admin\CallBackController@delay');
            Route::get('/history', 'Admin\CallBackController@history');
            Route::get('/search/{type}', 'Admin\CallBackController@search');
            Route::get('/addToDelay/{id}', 'Admin\CallBackController@addToDelay');
            Route::get('/sort_new_letters/{sort}', 'Admin\CallBackController@sortNewLetters');
            Route::get('/sort_delay_letters/{sort}', 'Admin\CallBackController@sortDelayLetters');
            Route::get('/sort_history_letters/{sort}', 'Admin\CallBackController@sortHistoryLetters');

            Route::post('/counter', 'Admin\CallBackController@counter');
            Route::get('/delete/{id}', 'Admin\CallBackController@delete');
            Route::post('/action', 'Admin\CallBackController@action');
            Route::get('/create_reply/{id}', 'Admin\CallBackController@createReply');
            Route::post('/reply', 'Admin\CallBackController@replay');
        });
        Route::group(['prefix' => 'help'], function () {
            Route::get('/', 'Admin\HelpController@index');
            Route::get('/delete_section/{id}', 'Admin\HelpController@deleteSection');
            Route::get('/change_section/{id}', 'Admin\HelpController@changeSection');
            Route::post('/save_changes', 'Admin\HelpController@saveSectionChanges');
            Route::post('/create_section', 'Admin\HelpController@createSection');
            Route::get('/create_new_post/{id}', 'Admin\HelpController@createNewPost');
            Route::post('/save_new_post', 'Admin\HelpController@saveNewPost');
            Route::get('/view_post/{id}', 'Admin\HelpController@viewPosts');
            Route::get('/delete_post/{id}', 'Admin\HelpController@deletePost');
            Route::get('/view_single_post/{id}', 'Admin\HelpController@viewSinglePost');
            Route::get('/change_post/{id}', 'Admin\HelpController@changePost');
            Route::post('/save_change_post', 'Admin\HelpController@saveChangePost');
        });
        Route::group(['prefix' => 'group'], function () {
            Route::get('/', 'Admin\GroupController@index');
            Route::get('/search', 'Admin\GroupController@search');
            Route::get('/sort/{sort}', 'Admin\GroupController@sortBy');
//            Route::post('/create_mail', 'Admin\GroupController@createMail');
//            Route::post('/send_mail', 'Admin\GroupController@sendMail');
            Route::post('/counter', 'Admin\GroupController@counter');
            Route::post('/get_group_statistic_data', 'Admin\GroupController@getGroupStatistic');
        });
        Route::group(['prefix' => 'referral'], function () {
            Route::get('/', 'Admin\ReferralStatisticController@index');
            Route::get('/search', 'Admin\ReferralStatisticController@search');
            Route::get('/sort/{sort}', 'Admin\ReferralStatisticController@sortBy');
            Route::get('/sort/{sort}/{id}', 'Admin\ReferralStatisticController@sortReferalList');
            Route::post('/counter', 'Admin\ReferralStatisticController@counter');
            Route::post('/get_group_statistic_data', 'Admin\ReferralStatisticController@getGroupStatistic');
            Route::get('/single_referor/{id}', 'Admin\ReferralStatisticController@singleReferal');
            Route::post('/change_percent', 'Admin\ReferralStatisticController@percent');
        });
        Route::group(['prefix' => 'video'], function () {
            Route::resource('/categories', 'Admin\VideoCategorieController');
            Route::get('/complaint/{id}', 'Admin\VideoController@show');
            Route::get('/complaint/delete/{id}', 'Admin\VideoController@complaintDelete');
        });

    });
    Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'Api'], function () {
        Route::group(['prefix' => 'bot'], function () {
            Route::any('get_started', 'BotController@getStarted');
            Route::any('set_status/{steamId}', 'BotController@setBotStatus');
        });
        Route::any('trade/change_status', 'TradeController@changeStatus');
        Route::any('trade/new_trade', 'TradeController@newTrade');
    });


    Route::group(['prefix' => 'api'], function () {

        Route::post('login', 'AuthController@login');
        Route::post('registration', 'AuthController@registration');
        Route::get('logout', 'AuthController@logout');

        Route::group(['prefix' => 'shop', 'middleware' => 'auth'], function () {
            Route::get('/', 'ShopController@index');
            Route::post('/check_out', 'ShopController@checkOut');
        });

        Route::group(['prefix' => 'sticker', 'middleware' => 'auth'], function () {
            Route::get('/', 'StickerController@index');
            Route::get('/categories', 'StickerController@categories');
            Route::get('/userStickers', 'StickerController@userStickers');
            Route::get('/availableStickers', 'StickerController@availableStickers');
            Route::get('/activeUserStickers', 'StickerController@activeUserStickers');
            Route::get('/show/{id}', 'StickerController@show');
            Route::get('/buy/{id}', 'StickerController@buy');
            Route::post('/offer', 'StickerController@offer');
            Route::get('/activate/{id}', 'StickerController@activate');
        });

        Route::group(['prefix' => 'trade', 'middleware' => 'auth'], function () {
            Route::get('/getSteamInventory/{appId?}', 'TradeController@getSteamInventory');
            Route::get('/getVirtualInventory', 'TradeController@getVirtualInventory');
            Route::post('/addVirtualItems', 'TradeController@addVirtualItems');
            Route::post('/getBackItems', 'TradeController@getBackItems');
        });



        Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
            Route::post('update', 'UserController@update');
            Route::get('social_link', 'UserController@getSocialBinding');
            Route::get('broke_link/{id}', 'UserController@deleteSocialBinding');
            Route::get('show/{id?}', 'UserController@show');
            Route::get('videos/{id?}', 'UserController@videos');
            Route::get('add_friend/{id}', 'FriendController@store');
            Route::get('accept_as_friend/{id}', 'FriendController@accept_as_friend');
            Route::get('reject_from_friends/{id}', 'FriendController@reject_from_friends');
            Route::get('unsubscribe/{id}', 'FriendController@unsubscribe');
            Route::get('get_friends/{id?}', 'FriendController@get_friends');
            Route::get('get_subscribers/{id?}', 'FriendController@get_subscribers');
            Route::get('get_interesting_pages/{id?}', 'FriendController@get_interesting_pages');
            Route::get('get_invitees/{id?}', 'FriendController@get_invitees');
            Route::post('search', 'FriendController@search');
            Route::post('search_users', 'FriendController@searchUsers');
            Route::get('search_friends', 'FriendController@searchFriends');
            Route::get('friends_birthday', 'FriendController@friendsBirthday');
            Route::resource('post', 'PostController');
            Route::get('wall/{id?}', 'PostController@wall');
            Route::get('post_top/{id}', 'PostController@postTop');
            Route::get('post/restore/{id}', 'PostController@restore');
            Route::post('post_like', 'PostController@like');
            Route::post('repost', 'PostController@repost');
            Route::post('group_repost', 'PostController@groupRepost');
            Route::post('ref/{type}/action', 'UserController@newRef');
            Route::get('answer/{id}', 'PostController@answer');
            Route::get('get_user_post_likes/{id}', 'PostController@userLikes');
            Route::get('get_user_post_dislikes/{id}', 'PostController@userDislikes');
            Route::resource('comment', 'CommentController');
            Route::get('comment_user_week/{id}/{group_id}', 'CommentController@destroy_week_user');
            Route::post('comment_like', 'CommentController@like');
            Route::get('get_user_comment_likes/{id}', 'CommentController@userLikes');
            Route::get('user_activity_month/{id}', 'ActivityController@user_activity_month');
            Route::get('user_visitor/{id}/{date}', 'ActivityController@user_visitor');
            Route::get('user_unique_visitor/{id}/{date}', 'ActivityController@user_unique_visitor');
            Route::get('user_visitor_gender_age/{id}/{date}', 'ActivityController@user_visitor_gender_age');
            Route::get('user_visitor_gender_age_all/{id}', 'ActivityController@user_visitor_gender_age_all');
            Route::get('user_activity/{id}/{date}', 'ActivityController@user_activity');
            Route::get('user_activity_all/{id}', 'ActivityController@user_activity_all');
            Route::get('get_user_comment_dislikes/{id}', 'CommentController@userDislikes');
            Route::get('ranking_month/{id}', 'RankingController@user_month');
            Route::get('ranking_day/{id}', 'RankingController@user_day');
            Route::get('user_ranking/{id}', 'RankingController@user_ranking');
            Route::get('user_ranking_month/{id}', 'RankingController@user_ranking_month');
            Route::resource('counter', 'CounterController');
            Route::resource('device', 'DeviceController');
            Route::resource('additionalService', 'AdditionalServiceController');
            Route::resource('upload_image', 'ImageController');
            Route::resource('blocked', 'BlockedUserController', ['only' => [
                'index', 'store', 'destroy'
            ]]);

            //Connection to social accounts
            Route::group(['prefix' => 'social'], function () {
                Route::get('/test', 'SocialAuthController@test');
                Route::get('/callback/{provider}', 'SocialAuthController@callBackSocialAccount');
                Route::get('/redirect/{id}', 'SocialAuthController@redirectSocialAccount');
            });
            //End connection to social accounts

        });
        Route::group(['prefix' => 'news_list', 'middleware' => 'auth'], function () {
            Route::get('/test', 'NewsListController@test');
            Route::get('/all_group_news', 'NewsListController@getAllGroupNews');
            Route::post('/search_all_news', 'NewsListController@searchAllNews');
            Route::get('/news_feed', 'NewsListController@newsFeed');
            Route::get('/news_group', 'NewsListController@newsGroups');
            Route::get('/news_friend', 'NewsListController@newsFriends');

            Route::get('/add_bookmark/user_id/{id}', 'NewsListController@addUserBookmark');
            Route::get('/add_bookmark/post_id/{id}', 'NewsListController@addPostBookmark');
            Route::get('/delete_bookmark/{id}', 'NewsListController@deleteBookmark');
            Route::get('/bookmarks', 'NewsListController@bookmarks');
            Route::get('/bookmarks/{type}', 'NewsListController@sortBookmarksBy');

            Route::get('/delete_from_history/{id}', 'NewsListController@deleteFromHistory');
            Route::get('/history_feed', 'NewsListController@historyFeed');
            Route::post('/sort_history_by', 'NewsListController@sortHistoryBy');

        });
        Route::group(['prefix' => 'group', 'middleware' => 'auth'], function () {
            Route::get('my_groups', 'GroupController@getMyGroups');
            Route::get('offerPosts/{groupId}', 'GroupController@offerPosts');
            Route::get('confirmOfferPost/{groupId}/{postId}', 'GroupController@confirmOfferPost');
            Route::get('post_top/{id}', 'PostController@postGroupTop');
            Route::get('users/{url}', 'GroupController@users');
            Route::get('videos/{id}', 'GroupController@videos');
            Route::get('admin_groups', 'GroupController@getAdminGroups');
            Route::get('deferred_posts/{id}', 'GroupController@deferredPosts');
            Route::get('wall/{id}', 'GroupController@wall');
            Route::get('themes', 'GroupController@themes');
            Route::resource('link', 'LinkGroupController', ['only' => [
                'store','destroy','update','show'
            ]]);
            Route::get('add_user/{group_id}', 'GroupUsersController@addUser');
            Route::get('delete_user/{url}/{id}', 'GroupUsersController@deleteUser');
            Route::get('user_confirmed/{url}/{id}', 'GroupUsersController@userGroupConfirmed');
            Route::get('create_admin/{group_id}/{id}', 'GroupUsersController@createAdmin');
            Route::get('create_editor/{group_id}/{id}', 'GroupUsersController@createEditor');
            Route::post('invit_group', 'GroupUsersController@invitGroup');
            Route::get('confirm_invit/{id}/{confirm}', 'GroupUsersController@confirmInvitGroup');
            Route::get('group_invits', 'GroupUsersController@userGroupInvits');
            Route::get('group_subscribers/{id}', 'GroupUsersController@groupSubscriberUsers');
            Route::get('users_friends_group/{id}', 'GroupUsersController@usersFriendsGroup');
            Route::get('group_activity_month/{id}', 'ActivityGroupController@group_activity_month');
            Route::get('group_visitor/{id}/{date}', 'ActivityGroupController@group_visitor');
            Route::get('group_unique_visitor/{id}/{date}', 'ActivityGroupController@group_unique_visitor');
            Route::get('group_visitor_gender_age/{id}/{date}', 'ActivityGroupController@group_visitor_gender_age');
            Route::get('group_visitor_gender_age_all/{id}', 'ActivityGroupController@group_visitor_gender_age_all');
            Route::get('group_activity_all/{id}', 'ActivityGroupController@group_activity_all');
            Route::get('group_activity/{id}/{date}', 'ActivityGroupController@group_activity');
            Route::get('ranking_month/{id}', 'RankingController@group_month');
            Route::get('ranking_day/{id}', 'RankingController@group_day');
            Route::get('ranking_all/{id}', 'RankingController@group_all');
            Route::get('group_ranking/{id}', 'RankingController@group_ranking');
            Route::get('group_ranking_month/{id}', 'RankingController@group_ranking_month');
            Route::get('block/get_categories', 'GroupBlockUserController@getBlockCategories');
            Route::resource('block', 'GroupBlockUserController',['only' => [
                'store','destroy','update','show'
            ]]);

        });
        Route::group(['prefix' => 'chat', 'middleware' => 'auth'], function () {
            Route::get('addMember/{id}/{userId}', 'ChatController@addMember');
            Route::get('updateImage/{id}/{image}', 'ChatController@updateImage');
            Route::get('getFriends/{id}', 'ChatController@getFriends');
            Route::get('removeImage/{id}', 'ChatController@removeImage');
            Route::get('getMessages/{id}/{page}', 'ChatController@getMessages');
            Route::get('removeMember/{id}/{userId}', 'ChatController@removeMember');
            Route::get('start/{id}', 'ChatController@startMessage');
            Route::get('stop/{id}', 'ChatController@stopMessage');
            Route::get('clearChat/{id}', 'ChatController@clearChat');
            Route::post('search/{page}', 'ChatController@search');
            Route::post('search/{chatId}/{page}', 'ChatController@searchInChat');
            Route::get('removeMember/{id}/{userId}', 'ChatController@removeMember');
            Route::group(['prefix' => 'message'],function (){
                Route::post('view', 'ChatController@viewMessage');
                Route::post('check', 'ChatController@checkMessage');
                Route::post('unCheck', 'ChatController@unCheckMessage');
                Route::post('star', 'ChatController@starMessage');
                Route::post('unStar', 'ChatController@unStarMessage');
                Route::post('spam', 'ChatController@spam');
                Route::post('unSpam', 'ChatController@unSpam');
                Route::get('favorite', 'ChatController@favoriteMessages');
                Route::get('getSpam', 'ChatController@getSpam');
                Route::post('/{id}', 'ChatController@addMessage');
            });
        });
        Route::resource('video', 'VideoController');
        Route::group(['prefix' => 'video'], function () {
            Route::post('parser', 'VideoController@parser');
            Route::post('like', 'VideoController@like');
            Route::get('view/{id}', 'VideoController@videoView');
            Route::get('searchUser/{title}/{filter}', 'VideoController@searchUserVideos');
            Route::get('searchGroupVideos/{id}/{title}/{filter}', 'VideoController@searchGroupVideos');
            Route::get('all/top', 'VideoController@topVideos');
            Route::get('categorie/videos/{title}', 'VideoController@categorieVideos');
            Route::get('all/categories', 'VideoController@getCategories');
            Route::get('filter/{filter}', 'VideoController@filterVideos');
            Route::get('popular/videos', 'VideoController@popularVideos');
            Route::get('popular/categorie/videos/{title}', 'VideoController@popularCategorieVideos');
            Route::get('complaint/{video_id}/{id}', 'VideoComplaintController@complaint');
            Route::get('complaint/categories', 'VideoComplaintController@complaintCategories');
        });
        Route::resource('albums', 'AlbumController',['only' => [
            'index','store','destroy','update','show'
        ]]);
        Route::group(['prefix' => 'albums'], function () {
            Route::post('/{id}/add_photo', 'AlbumController@addImage');
            Route::post('/wall_album', 'AlbumController@wallAlbum');
            Route::group(['prefix' => 'group'], function () {
                Route::post('store', 'AlbumController@addGroupAlbum');
                Route::get('/{id}', 'AlbumController@getGroupAlbums');
                Route::get('/delete/{id}', 'AlbumController@deleteGroupAlbums');
                Route::put('/update/{id}', 'AlbumController@updateGroupAlbum');
//            Route::post('update_user_album', 'PhotoController@updateUserAlbums');
            });
        });
        Route::resource('photo', 'PhotoController',
            ['only' => ['show']]);
        Route::group(['prefix' => 'photo'], function () {
            Route::get('/add_like/{id}', 'PhotoController@like');
            Route::get('/add_dislike/{id}', 'PhotoController@disLike');
            Route::post('add_comment', 'PhotoController@addComment');
            Route::post('update_comment', 'PhotoController@updateComment');
            Route::post('delete_comment', 'PhotoController@deleteComment');
            Route::get('/add_group_like/{id}', 'PhotoController@groupImgLike');
            Route::get('/add_group_dislike/{id}', 'PhotoController@groupImgDislike');
        });
        Route::get('/photo/test', 'PhotoController@test');

            Route::resource('chat', 'ChatController');
        Route::resource('group', 'GroupController', ['only' => [
            'index', 'store', 'destroy', 'show' ,'update'
        ]]);
        Route::group(['prefix' => 'country', 'middleware' => 'auth'], function () {
            Route::get('/', 'CityController@getCountries');
            Route::get('regions/{id}', 'CityController@getRegions');
            Route::post('cities', 'CityController@getCities');
            Route::get('cities_in_country/{id}', 'CityController@getCitiesInCountry');
            Route::get('cities_by_name/{search}', 'CityController@getCitiesByName');
            Route::get('cities_by_country_name/{id}/{search}', 'CityController@getCitiesByCountryName');
        });
        Route::resource('link', 'LinkController');

        Route::get('test', function () {
            return view('test');
        });
    });
  Route::any('{angularjs}', function () {
      if (Auth::check()) {
          return view('index', ['id' => Auth::id()]);
      } else {
          if(strpos($_SERVER['REQUEST_URI'], 'community')){
              return view('index', ['id' => Auth::id()]);
          }else{
              return view('login');
          }

      }
  })->where('angularjs', '(.*)');
});