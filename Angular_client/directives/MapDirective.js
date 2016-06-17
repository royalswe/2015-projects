app.controller('mapController', function($scope, NgMap) {

    NgMap.getMap().then(function(map) {
        $scope.map = map;
    });

    // Show popup info window
    $scope.showStory = function(event, place) {
        $scope.selectedPlace = place;
        $scope.map.showInfoWindow('InfoWindow', this);
    };

})
.directive('storyMap', function() {
    return {
        templateUrl: 'templates/map.html',
        restrict: 'E'
    }
});