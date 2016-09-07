//alignment tweaks
function setImageContainerHeight(){
    //set the image block height equal to the dynamic neighbouring info block
    var infoHeight = $('.parcel-text-details').height();
    $('.image-container').height(infoHeight);
}

//data stores
var currentItem = "";

//fetch data via api
$.ajax({
    url: "https://zoomcar-ui.0x10.info/api/courier?type=json&query=list_parcel",
    async: true,
    type: "get",
    success: function (data, textStatus, xhr) {
        var parcels = JSON.parse(data).parcels;
        console.log(parcels);
        $('.parcel-list').empty();

        //save data in session storage
        sessionStorage.parcels = JSON.stringify(parcels);

        //insert the search bar
        insertSearchBar();

        //populate the parcels
        parcels.forEach(function (parcel, i) {
            var returnMsg = '<div class="parcel">\
                                <h3 class="parcel-short-data parcel-name"><span class="parcel-id" hidden>' + i + '</span>';
            returnMsg += parcel.name;
            returnMsg += '</h3>\
                            <p class="parcel-short-data  parcel-price">\
                            <span class="rupee-symbol">$</span>';
            returnMsg += parcel.price;
            returnMsg += '</p></div><hr>';
            $('.parcel-list').append(returnMsg);
        });

        //change product count
        $('.product-count').html(parcels.length);
    }
});

//get the api-hits and modify
$.ajax({
    url: "http://zoomcar-ui.0x10.info/api/courier?type=json&query=api_hits",
    async: true,
    type: "get",
    success: function (data, textStatus, xhr) {
        var hits = JSON.parse(data);
        $('.api-hit').html(hits.api_hits);
    }
});

//fetch info listener
$('body').on('click', '.parcel', function () {

    //get the data from session storage
    var parcels = JSON.parse(sessionStorage.parcels);

    //get selected product ID
    var parcelID = $(this).find('.parcel-id').html();
    var parcel = parcels[parcelID];

    //set global current parcel
    currentItem = parcel;

    //check and get the Like/Unlike status of product
    var LikeOrUnlike = checkLikeStatus(parcel.name);

    //populate the info
    var returnMsg = '<div class="col-xs-3 image-container very-subtle-box-shadow">\
                        <div id="share-buttons">\
                            <!-- Facebook -->\
                            <a href="http://www.facebook.com/sharer.php?u=http://aravindbharathy.me/ztrackr" target="_blank">\
                                <img src="img/facebook.png" alt="Facebook" />\
                            </a>\
                            <!-- Google+ -->\
                            <a href="https://plus.google.com/share?url=http://aravindbharathy.me/ztrackr" target="_blank">\
                                <img src="img/google.png" alt="Google" />\
                            </a>\
                            <!-- Twitter -->\
                            <a href="https://twitter.com/share?url=http://aravindbharathy.me/ztrackr&amp;text=Simple%20Parcel%20Tracker&amp;hashtags=ztrackr" target="_blank">\
                                <img src="img/twitter.png" alt="Twitter" />\
                            </a>\
                        </div>\
                        <img src="' + parcel.image + '" class="parcel-image" alt="parcel image" class="very-subtle-box-shadow">\
                    </div>\
                    <div class="col-xs-9 parcel-text-details very-subtle-box-shadow">\
                        <h2 class="parcel-name">' + parcel.name + '</h2>\
                        <p class="parcel-secondary-details"><i class="fa fa-shopping-cart"></i> ' + parcel.type +'</p>\
                        <p class="parcel-secondary-details"><i class="fa fa-database"></i> ' + parcel.weight + '</p>\
                        <p class="parcel-secondary-details"><i class="fa fa-money"></i> $' + parcel.price + '</p>\
                        <p class="parcel-secondary-details"><strong>Qty. </strong>' + parcel.quantity + '</p>\
                        <p class="parcel-secondary-details parcel-date"><i class="fa fa-calendar"></i> <input type="date" value="' + formatDate(parcel.date) + '" disabled></p>\
                        <p class="parcel-secondary-details">Color : <span class="color-display" style="background-color:' + parcel.color + ';"></span></p>\
                        <p class="parcel-secondary-details parcel-phone-number"><i class="fa fa-phone"></i> ' + parcel.phone + '</p>\
                        <button class="button-like" value="' + LikeOrUnlike + '" data-name="' + parcel.name + '"><i class="fa fa-thumbs-up"></i> ' + LikeOrUnlike + '</button>\
                    </div>';
    $('.parcel-container').empty();
    $('.parcel-container').append(returnMsg);

    //set image block height from the generated info block content
    setImageContainerHeight();

    //render the map
    returnMsg = '<div class="col-xs-12 very-subtle-box-shadow map-container">\
                    <button class="map-refresh"><i class="fa fa-refresh"></i></button>\
                    <div id="map_canvas" style="height: 350px;width: 100%;"></div>\
                </div>';
    $('.parcel-map').empty();
    $('.parcel-map').append(returnMsg);

    //set the location for map and initialize the map
    var latitude = parcel.live_location.latitude;
    var longitude = parcel.live_location.longitude;
    mapInitialize(latitude,longitude);
});

//function to pad '0' to day and month if single digit
function convertToTwo(n){
    return n>9? n : '0'+n;
}

//date formater for UTC to 'yyyy-mm-dd'
function formatDate(UTC){
    var date = new Date(UTC * 1000);
    var year = date.getUTCFullYear();
    var month = date.getUTCMonth() + 1;
    var day = date.getUTCDate();
    return year + '-' + convertToTwo(month) + '-' + convertToTwo(day);
}

//sorting functionalities to follow

//listener for sort params
$('body').on('click', '.sort-param', function () {

    //get data from session storage
    var parcels = JSON.parse(sessionStorage.parcels);

    //empty the current list and populate sorted list
    $('.parcel-list').empty();
    var type = $(this).attr('id');

    //change css - colors
    $('.sort-param').css({'color' : '#ccc'});
    $(this).css({'color' : '#20336B'});

    //identify the sort param and call relevant sorters
    switch(type){
        case "sort-name":
            parcels = sortByAlpha(parcels);
            break;
        case "sort-price":
            parcels = sortByPrice(parcels);
            break;
        case "sort-weight":
            parcels = sortByWeight(parcels);
            break;
    }

    //repopulate parcel list
    repopulateParcels(parcels);

    //store the sorted list in session storage
    sessionStorage.parcels = JSON.stringify(parcels);
});

//alpha sort function
function sortByAlpha(parcels){
    for(var i=0; i<parcels.length; i++){
        for(var j=i; j<parcels.length; j++){
            if(parcels[i].name.localeCompare(parcels[j].name) != -1){
                var temp = parcels[i];
                parcels[i] = parcels[j];
                parcels[j] = temp;
            }
        }
    }
    return parcels;
}

//sort by number(price)
function sortByPrice(parcels){
    for(var i=0; i<parcels.length; i++){
        for(var j=i; j<parcels.length; j++){

            //remove any formater(comma) if any
            var price1 = parcels[i].price.replace(/,/g,"");
            var price2 = parcels[j].price.replace(/,/g,"");

            if(Number(price1) > Number(price2)){
                var temp = parcels[i];
                parcels[i] = parcels[j];
                parcels[j] = temp;
            }
        }
    }
    return parcels;
}

//sort by weight
function sortByWeight(parcels){
    for(var i=0; i<parcels.length; i++){
        for(var j=i; j<parcels.length; j++){

            //remove kg from weight value
            var weight1 = parcels[i].weight.replace(/kg/g,"");
            var weight2 = parcels[j].weight.replace(/kg/g,"");
            if(weight1 > weight2){
                var temp = parcels[i];
                parcels[i] = parcels[j];
                parcels[j] = temp;
            }
        }
    }
    return parcels;
}

//parcel repopulating function
function repopulateParcels(parcels){
    insertSearchBar();
    parcels.forEach(function (parcel, i) {
        var returnMsg = '<div class="parcel">\
                <h3 class="parcel-short-data parcel-name"><span class="parcel-id" hidden>' + i + '</span>';
        returnMsg += parcel.name;
        returnMsg += '</h3>\
                            <p class="parcel-short-data  parcel-price">\
                            <span class="rupee-symbol">$</span>';
        returnMsg += parcel.price;
        returnMsg += '</p></div><hr>';
        $('.parcel-list').append(returnMsg);
    });
}

//insert search bar whenever parcel list is repopulated
function insertSearchBar(){
    var searchBlock = '<div class="search-block">\
                            <input type="text" class="search-box" placeholder="Enter Name, Weight or Type to search">\
                        </div>';
    $('.parcel-list').append(searchBlock);
    return;
}


//like and unlike functionalities to follow

//toggle like and unlike and store in session storage
$('body').on('click','.button-like',function(){
    if($(this).attr('value') == "Like"){
        $(this).html('<i class="fa fa-thumbs-up"></i> Unlike');
        $(this).css({'color' : '#20336B'});
        $(this).attr('value','Unlike');
        addLikes($(this).attr('data-name'));
    }
    else{
        $(this).html('<i class="fa fa-thumbs-up"></i> Like');
        $(this).css({'color' : '#777'});
        $(this).attr('value','Like');
        removeLikes($(this).attr('data-name'));
    }
});

//function to add new like
function addLikes(productName){
    //check if 'likes' session storage initialised
    if(sessionStorage.likes){
        //get current likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check for duplicate entries
        if($.inArray(productName,currentLikes) != -1)
            return;

        //add the product if no duplicate found
        currentLikes.push(productName);

        //store it back
        sessionStorage.likes = JSON.stringify(currentLikes);
    }
    else{
        sessionStorage.likes = JSON.stringify([productName]);
    }
}

//function to remove likes
function removeLikes(productName){
    //check if 'likes' session storage initialised
    if(sessionStorage.likes){
        //get current likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check for existence of entry
        if($.inArray(productName,currentLikes) == -1)
            return;

        //remove the liked product
        var index = currentLikes.indexOf(productName);
        currentLikes.splice(index,1);

        //store it back
        sessionStorage.likes = JSON.stringify(currentLikes);
    }
    else{
        return;
    }
}

//status checker
function checkLikeStatus(productName){
    if(sessionStorage.likes) {
        //get likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check presence
        if($.inArray(productName,currentLikes) == -1)
            return "Like"; //yet to like
        else return "Unlike"; //already liked
    }
    else return "Like"; //Yet to Like
}

//map controls to follow

//map creator and initializer
function mapInitialize(latitude,longitude) {
    //set lat and long
    var lat = latitude,
        lng = longitude,
        latlng = new google.maps.LatLng(lat, lng),
        image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';

    //set properties
    var mapProp = {
        center:new google.maps.LatLng(lat, lng),
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    //set the target markup
    var map=new google.maps.Map(document.getElementById("map_canvas"),mapProp);

    //set the marker position
    marker = new google.maps.Marker({
        position: latlng,
        map: map,
        icon: image
    });
}

//map refresh listener
$('body').on('click','.map-refresh',function(){
    //get new coordinates
    $.ajax({
        url: "https://zoomcar-ui.0x10.info/api/courier?type=json&query=list_parcel",
        async: true,
        type: "get",
        success: function (data, textStatus, xhr) {

            //store latest data in session storage
            var parcels = JSON.parse(data).parcels;
            sessionStorage.parcels = JSON.stringify(parcels);

            //identify the parcel and change the marker position
            parcels.forEach(function (parcel, i) {
                if(currentItem.name == parcel.name){
                    mapInitialize(parcel.live_location.latitude,parcel.live_location.longitude);
                    return;
                }
            });
        }
    });
});

//search functionalities to follow

//search box listener
$("body").on('keyup','.search-box',function (e) {
    //listen to 'Enter' key press
    if (e.keyCode == 13) {
        //get search term
        var searchTerm = $(this).val();

        //initialise final parcels array
        var newParcels = [];

        //get data from session storage
        var parcels = JSON.parse(sessionStorage.parcels);

        //loop through to find matches
        parcels.forEach(function(parcel){
            //get and format all the param values
            var name = parcel.name.toLowerCase();
            var weight = parcel.weight.replace(/kg/g,"");
            var type = parcel.type.toLowerCase();
            searchTerm = searchTerm.toLowerCase();

            //check for sub-string matches in name and type. Look for exact match in weight
            if(name.search(searchTerm)>= 0 || weight == searchTerm || type.search(searchTerm)>= 0){
                //select if match found
                newParcels.push(parcel);
            }
        });

        //repopulate the parcel list
        $('.parcel-list').empty();
        repopulateParcels(newParcels);
    }
});












