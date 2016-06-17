app.factory('ResourceService', ResourceService);

ResourceService.$inject = ['$http', 'API'];

function ResourceService($http, API){

    return function (collectionName){

        var Resource = function(data){
            angular.extend(this, data);
        };

        Resource.getCollection = function(data){
            // if there is no data present set it to null instead of undifined
            data = typeof data !== 'undefined' ? data : '';

            var request = {
                method: 'GET',
                url: API.url + collectionName,
                headers: {
                    'Api-Key': API.key
                },
                params: {
                    'search': data.searches,
                    'limit':  data.limit,
                    'offset': data.offset,
                    'tag':    data.tag,
                    'location': data.location
                }
            };

            return $http(request).then(function(response) {
                var result = [];

                angular.forEach(response.data, function(value, key) {
                    result[key] = new Resource(value);
                });

                return result;
            })
            .catch(function(data, status) {});


        };

        Resource.getSingle = function(useriID) {
            var request = {
                method: 'GET',
                url: API.url + collectionName + useriID,
                headers: {
                    'Api-Key': API.key
                }
            };
            return $http(request).then(function(response) {
                return response;
            })
            .catch(function(data, status) {});
        };

        Resource.save = function(data, authToken){
            var request = {
                method: 'POST',
                url: API.url + collectionName,
                headers: {
                    'Api-Key': API.key,
                    'Authorization': authToken,
                    'Accept': API.format,
                },
                data: data
            };
            return $http(request).then(function(response) {
                return new Resource(response);
            })
            .catch(function(data, status) {});

        };

        Resource.update = function(data, id, authToken){
            var request = {
                method: 'PUT',
                url: API.url + collectionName + id,
                headers: {
                    'Api-Key': API.key,
                    'Authorization': authToken,
                    'Accept': API.format,
                },
                data: data
            };
            return $http(request).then(function(response) {
                return new Resource(response);
            })
            .catch(function(data, status) {});

        };

        Resource.remove = function(id, authToken){
            var request = {
                method: 'DELETE',
                url: API.url + collectionName + id,
                headers: {
                    'Api-Key': API.key,
                    'Authorization': authToken,
                    'Accept': API.format,
                },

            };
            return $http(request).then(function(response) {
                return new Resource(response);
            })
            .catch(function() {});

        };

        Resource.paginate = function(url) {
            var request = {
                method: 'GET',
                url: url,
                headers: {
                    'Api-Key': API.key
                }
            };
            return $http(request).then(function(response) {
                return response;
            })
            .catch(function(data, status) {});
        };

        return Resource;
    }
}