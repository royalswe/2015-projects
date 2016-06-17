app.factory('StoryService', StoryService);

StoryService.$inject = ['ResourceService', '$q'];

function StoryService(ResourceService, $q) {

    var story = ResourceService('stories/');

    return {
        get: function () {
            var deferred = $q.defer();
            story.getCollection().then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        searchStories: function (data) {
            var deferred = $q.defer();
            story.getCollection(data).then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        saveStory: function (data) {
            var deferred = $q.defer();
            // Get auth token from session storage
            var authToken = 'Token token=' + sessionStorage.token;

            data = {
                "story": {
                    "title": data.title,
                    "description": data.description,
                    "address":data.address,
                    "longitude": data.longitude,
                    "latitude": data.latitude,
                    "tags": this.tags(data.tags)
                }
            };

            story.save(data, authToken).then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        removeStory: function (data) {
            var deferred = $q.defer();
            // Get auth token from session storage
            var authToken = 'Token token=' + sessionStorage.token;

            story.remove(data, authToken).then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        updateStory: function (data) {
            var deferred = $q.defer();
            // Get auth token from session storage
            var authToken = 'Token token=' + sessionStorage.token;
            var storyID = data.id

            data = {
                "story": {
                    "title": data.title,
                    "description": data.description,
                    "address":data.address,
                    "longitude": data.longitude,
                    "latitude": data.latitude,
                    "tags": this.tags(data.name)
                }
            };

            story.update(data, storyID, authToken).then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        paginate: function (data) {
            var deferred = $q.defer();
            story.paginate(data).then(function (data) {
                deferred.resolve(data);
            });

            return deferred.promise;
        },

        // Give tags correct format in an array
        tags: function (data) {
            if(!data) {
                return null;
            }
            var cleanTags = data.replace(/\s+/g, ''); // Remove whitespace from tags
            var tags = cleanTags.split(",");

            var tagsArr = [];

            tags.forEach(function(entry) {
                tagsArr.push({"name": entry});
            });

            return tagsArr
        },

    };
}