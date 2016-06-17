var app = angular.module('app', ['ngRoute', 'ngMap', 'ngFlash']);

app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/',
            {
                controller: 'StoryController',
                templateUrl: 'partials/stories.html',
                controllerAs: 'stories'
            })
        .when('/profile',
            {
                controller: 'CreatorController',
                templateUrl: 'partials/creator-profile.html',
                controllerAs: 'creator'
            })
        .when('/users/:id',
            {
                template: '<show-creator></show-creator>',
            })
        .otherwise({redirectTo: '/'});

    $locationProvider.html5Mode(true);

})
.constant('API', { // key on client not good but ok for now
    'key'   : "tgofbvP1bJbzy0/heJArka+LtkQ/4J3PtcPK+/VAJaHi7OZqJ7S7FC2pBO4ewx4uHY/u5UZgtm2/iRhNlD4kPw==",
    'url'   : "https://ancient-savannah-60021.herokuapp.com/api/", // base url
    'format': 'application/json' // Default format
});

