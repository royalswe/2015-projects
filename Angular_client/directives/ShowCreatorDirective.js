app.controller('ShowCreatorController', ['CreatorService', '$routeParams', '$scope', 'Flash',
    function(creatorService, $routeParams, $scope, Flash) {

        var userPromise = creatorService.getCreator($routeParams.id);

        userPromise
            .then(function(data){
                $scope.creatorDetails = data.data; // List with information about the chosen creator
            })
            .catch(function(){
                var message = '<strong> Ohps!</strong> Could not find user.';
                Flash.create('danger', message, 5000, true);
            });
    }])
    .directive('showCreator', function() {
        return {
            templateUrl: 'templates/show-creator.html',
            restrict: 'E'
        }
    });