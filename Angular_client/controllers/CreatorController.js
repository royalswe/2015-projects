app.controller('CreatorController', CreatorController);

CreatorController.$inject = ['CreatorService', '$scope', 'Flash'];

function CreatorController(creatorService, $scope, Flash){

    var userPromise = creatorService.getCreator(sessionStorage.user);

    userPromise
        .then(function(data){
            if(!data) // if no data from api is fetched
            {
                var message = '<strong> Oh no!</strong> Could not get data from server.';
                Flash.create('danger', message, 0, true);
            }
            $scope.creatorList = data.data; // Return list of creator and their stories.
        });

}



