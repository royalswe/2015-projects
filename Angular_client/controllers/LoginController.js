app.controller('LoginController', LoginController);

LoginController.$inject = ['AuthenticationService', '$scope', 'Flash'];

function LoginController(authService, $scope, Flash){

    $scope.login = function(credentials) {
        authService.auth(credentials).then(function() {
            var message = "<strong> Welcome!</strong> it's nice to have you here.";
            Flash.create('success', message, 5000, true);
        });
    };

    $scope.logout = function() {
        delete sessionStorage.clear();
        var message = "<strong> Goodbye!</strong> come back soon.";
        Flash.create('success', message, 5000, true);
    };

    $scope.isUserLoggedIn = function() {
        if(sessionStorage.user){
            return true
        }
        return false;
    };

}


