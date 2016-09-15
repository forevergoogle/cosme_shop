/**
 * Created by mith on 7/8/2016.
 */
var app = angular.module('cosmeApp', []);

app.controller('frmController', function($scope, $http) {
    // GET THE FILE INFORMATION.
    $scope.getFileDetails = function (e) {

        $scope.files = [];
        $scope.$apply(function () {

            // STORE THE FILE OBJECT IN AN ARRAY.
            for (var i = 0; i < e.files.length; i++) {
                $scope.files.push(e.files[i])
            }

        });
    };
    //var postData = new FormData();
    //postData.append('file', $('#file')[0].files[0]);
    //postData.append('creative', JSON.stringify(data));
    //$.ajax({
    //    url: 'creative/save/display-banner',
    //    type: "POST",
    //    data: postData,
    //    contentType: false, // config multiform data
    //    processData:false, // config multiform data
    //    timeout: 60000, //60s
    //    beforeSend: function(){
    //        $('#wrapper').append('<div class="loader"></div>');
    //    },
    //    success: function(data){
    //        window.location = 'https://monitor.adsplay.net/creative/'+data;
    //    }
    //});
// NOW UPLOAD THE FILES.
    $scope.uploadFiles = function () {

        //FILL FormData WITH FILE DETAILS.
        var data = new FormData();
        console.log($scope.files);
        for (var i in $scope.files) {
            data.append("uploadedFile", $scope.files[i]);
        }
        $scope.url = 'index.php/admin/products/addAjaxProduct';
        $http.post($scope.url, data ,{
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            "name": $scope.name,
            "content": $scope.content,
            "price": $scope.price,
            "img": data

        }).
            success(function (data, status) {
                console.log(data);
            });

    };
    $scope.formsubmit = function () {
        $scope.url = 'index.php/admin/products/addAjaxProduct'
        $http.post($scope.url, {
            "name": $scope.name,
            "content": $scope.content,
            "price": $scope.price,
            "img": formdata
        }).
            success(function (data, status) {
                console.log(data);
            });
    };
});
