app.controller('StoryController', StoryController);

StoryController.$inject = ['StoryService', '$scope', 'Flash']; // Flash is for flash messages

function StoryController(storyService, $scope, Flash){

    var vm = this;
    var storyPromise = storyService.get();

    storyPromise
        .then(function(data){
            if(!data) // if no data from api is fetched
            {
                var message = '<strong> Oh no!</strong> Could not get data from server.';
                Flash.create('danger', message, 0, true);
            }
            vm.storyList = data; // Return complete list off stories
        })


    vm.searchStories = function(data) {
        storyService.searchStories(data)
            .then(function(newData){
                vm.storyList = newData; // Return list with searched stories
            })
            .catch(function(){
                var message = '<strong> Ohps!</strong> Could not do the search.';
                Flash.create('danger', message, 5000, true);
            });
    };

    vm.createStory = function(data) {
        storyService.saveStory(data)
            .then(function(newData){
                vm.storyList.unshift(newData.config.data.story); // Add new story to list
                var message = '<strong> Well done!</strong> You successfully created this important story.';
                Flash.create('success', message, 5000, true);
            })
            .catch(function(){
                var message = '<strong> Ohps!</strong> Your story did not create.';
                Flash.create('danger', message, 5000, true);
            });
    };

    $scope.paginate = function(data) { // Pagination with api´s HATEOAS
        storyService.paginate(data)
            .then(function(newData){
                vm.storyList = newData.data;
            })
    };

      /////////////////////////////////////////
     /// Functions for profile page bellow ///
    /////////////////////////////////////////

    $scope.removeStory = function(id, index) {
        if (confirm("Are you sure to delete this story?")) {
            storyService.removeStory(id.id)
                .then(function(){
                    $scope.creatorList.stories.splice(index, 1); // Remove story from list
                    var message = '<strong> Well done!</strong> You will never see that story anymore.';
                    Flash.create('success', message, 5000, true);
                })
                .catch(function(){
                    var message = '<strong> Ohps!</strong> Story did not delete.';
                    Flash.create('danger', message, 5000, true);
                });
         }
    };

    $scope.enableEditor = function() { // Enable editing mode in lists
        $scope.editorEnabled = true;
    };

    $scope.disableEditor = function() { // Disable editing mode in lists
        $scope.editorEnabled = false;
    };

    $scope.save = function(data) {
        storyService.updateStory(data)
            .then(function(){
                var message = '<strong> Awesome!</strong> Story is updated.';
                Flash.create('success', message, 5000, true);
            })
            .catch(function(){
                var message = '<strong> Ohps!</strong> Story did not update.';
                Flash.create('danger', message, 5000, true);
            });

        $scope.disableEditor();
    };

}



