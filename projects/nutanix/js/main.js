//initialize random like values to start off with
if(!sessionStorage.likeCount)
    sessionStorage.likeCount = JSON.stringify([20,35, 25, 12, 46, 29]);

//populating deals function
function populateDeals(deals){

    var likeCount = JSON.parse(sessionStorage.likeCount);

    $('.deal-grid').empty();

    //populate the deals
    deals.forEach(function (deal, i) {
        var likeOrUnlike = checkLikeStatus(deal.name);
        var htmlContent = '<div class="col-md-4 deal-box">\
                                    <div class="deal-info very-subtle-box-shadow">\
                                        <div class="deal-desc">\
                                            <h3 class="deal-heading">';
        htmlContent += deal.name + '</h3>';
        htmlContent += '<div class="row">\
                                <div class="col-md-6">\
                                    <h4 class="deal-provider">';
        htmlContent += deal.provider + '</h4>';
        htmlContent += '</div>\
                                <div class="col-md-6">\
                                    <fieldset class="rating">';
        var ratingRounded = Math.round(2*Number(deal.rating))/2;
        var notSelected = 5 - ratingRounded;
        for(var j=0; j<Math.floor(notSelected); j++){
            htmlContent += '<input type="radio" name="rating" /><label class = "full"></label>';
        }
        if(notSelected % 1 != 0){
            htmlContent += '<input type="radio" name="rating" /><label class = "full"></label>\
                                <input type="radio" name="rating" /><label class="half"></label>';
        }
        for(j=0; j<Math.floor(ratingRounded); j++){
            htmlContent += '<input type="radio" name="rating" /><label class = "full selected"></label>';
        }
        htmlContent += ' </fieldset>\
                                </div>\
                                </div>\
                                <div class="row extra-info">\
                                    <div class="col-md-4">\
                                        <img class="deal-image" src="';
        htmlContent += deal.image;
        htmlContent += '">\
                            </div>\
                            <div class="col-md-8">\
                                <h4 class="price-info">Actual Price : <span class="actual-price">';
        htmlContent += deal.actual_price;
        htmlContent += '</span></h4>\
                                <h4 class="price-info">Final Price : <span class="final-price">';
        var discount = deal.discount.replace(/%/g,"");
        discount = Number(discount);
        htmlContent += Math.floor(deal.actual_price - (deal.actual_price * discount) / 100);
        htmlContent += '</span></h4>\
                                <div class="offer-amount">\
                                <h4>';
        htmlContent += deal.discount;
        htmlContent += '</h4>\
                            </div>\
                            </div>\
                            </div>\
                            </div>\
                            <div class="row get-deal-block">\
                            <a href="';
        htmlContent += deal.link;
        htmlContent += '" target="_blank"><button class="get-deal">Get Deal</button></a>\
                            <button class="button-like-count" value="' + likeCount[i] + '" data-name="' + deal.name + '" data-position="' + i + '">' + likeCount[i] + ' likes</button>\
                            <button class="button-like" value="' + likeOrUnlike + '" data-name="' + deal.name + '" data-position="' + i + '"><i class="fa fa-thumbs-up"></i> ' + likeOrUnlike + '</button>\
                            </div>\
                            </div>\
                            </div>';

        $('.deal-grid').append(htmlContent);
    });
}

//fetch data via api
$.ajax({
    url: "https://nutanix.0x10.info/api/deals?type=json&query=list_deals",
    async: true,
    type: "get",
    success: function (data, textStatus, xhr) {
        //parse data
        var allData = JSON.parse(data);
        var deals = allData.deals;

        //save data in session storage
        sessionStorage.deals = JSON.stringify(deals);

        populateDeals(deals);

        //update like count
        updateTotalLikes();
    }
});

//get the api-hits and modify
$.ajax({
    url: "https://nutanix.0x10.info/api/deals?type=json&query=api_hits",
    async: true,
    type: "get",
    success: function (data, textStatus, xhr) {
        var hits = JSON.parse(data);
        $('.api-hit').html(hits.api_hits);
    }
});

//toggle like and unlike and store in session storage
$('body').on('click','.button-like',function(){
    if($(this).attr('value') == "Like"){

        //like button handlers
        $(this).html('<i class="fa fa-thumbs-up"></i> Unlike');
        $(this).css({'color' : '#20336B'});
        $(this).attr('value','Unlike');

        //increase like count
        addLikes($(this).attr('data-name'));

        //change like count in UI
        var likeCount = JSON.parse(sessionStorage.likeCount);
        var currentDeal = Number($(this).attr('data-position'));
        likeCount[currentDeal] = likeCount[currentDeal] + 1;
        var selector = '.button-like-count[data-position=' + String(currentDeal) + ']';
        $(selector).html(likeCount[currentDeal] + ' likes');

        //store the new like count in sessionStorage
        sessionStorage.likeCount = JSON.stringify(likeCount);

        //update total likes
        updateTotalLikes();
    }
    else{

        //like button handlers
        $(this).html('<i class="fa fa-thumbs-up"></i> Like');
        $(this).css({'color' : '#777'});
        $(this).attr('value','Like');
        removeLikes($(this).attr('data-name'));

        //change like count in UI
        var likeCount = JSON.parse(sessionStorage.likeCount);
        var currentDeal = Number($(this).attr('data-position'));
        likeCount[currentDeal] = likeCount[currentDeal] - 1;
        var selector = '.button-like-count[data-position=' + String(currentDeal) + ']';
        $(selector).html(likeCount[currentDeal] + ' likes');

        //store the new like count in sessionStorage
        sessionStorage.likeCount = JSON.stringify(likeCount);

        //update total likes
        updateTotalLikes();
    }
});

//function to add new like
function addLikes(dealName){
    //check if 'likes' session storage initialised
    if(sessionStorage.likes){
        //get current likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check for duplicate entries
        if($.inArray(dealName,currentLikes) != -1)
            return;

        //add the product if no duplicate found
        currentLikes.push(dealName);

        //store it back
        sessionStorage.likes = JSON.stringify(currentLikes);
    }
    else{
        sessionStorage.likes = JSON.stringify([dealName]);
    }
}

//function to remove likes
function removeLikes(dealName){
    //check if 'likes' session storage initialised
    if(sessionStorage.likes){
        //get current likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check for existence of entry
        if($.inArray(dealName,currentLikes) == -1)
            return;

        //remove the liked product
        var index = currentLikes.indexOf(dealName);
        currentLikes.splice(index,1);

        //store it back
        sessionStorage.likes = JSON.stringify(currentLikes);
    }
    else{
        return;
    }
}

//status checker
function checkLikeStatus(dealName){
    if(sessionStorage.likes) {
        //get likes
        var currentLikes = JSON.parse(sessionStorage.likes);

        //check presence
        if($.inArray(dealName,currentLikes) == -1)
            return "Like"; //yet to like
        else return "Unlike"; //already liked
    }
    else return "Like"; //Yet to Like
}

//total Likes
function updateTotalLikes(){
    var currentLikes = JSON.parse(sessionStorage.likeCount);
    var total = 0;
    currentLikes.forEach(function (val, i) {
        total = total + val;
    });
    $('.product-count').html(total);
}


//sorting

//listener for sort params
$('body').on('click', '.sort-param', function () {

    //get data from session storage
    var deals = JSON.parse(sessionStorage.deals);

    //empty the current list and populate sorted list
    var type = $(this).attr('id');

    //change css - colors
    $('.sort-param').css({'color' : '#ccc'});
    $(this).css({'color' : '#20336B'});

    //identify the sort param and call relevant sorters
    switch(type){
        case "sort-name":
            deals = sortByAlpha(deals);
            break;
        case "sort-price":
            deals = sortByPrice(deals);
            break;
        case "sort-discount":
            deals = sortByDiscount(deals);
            break;
    }

    populateDeals(deals);

    //store the sorted list in session storage
    sessionStorage.deals = JSON.stringify(deals);
});

//alpha sort function
function sortByAlpha(deals){
    var likeCount = JSON.parse(sessionStorage.likeCount);
    for(var i=0; i<deals.length; i++){
        for(var j=i; j<deals.length; j++){
            if(deals[i].name.localeCompare(deals[j].name) != -1){
                var temp = deals[i];
                deals[i] = deals[j];
                deals[j] = temp;

                //sort likes
                temp = likeCount[i];
                likeCount[i] = likeCount[j];
                likeCount[j] = temp;
            }
        }
    }
    sessionStorage.likeCount = JSON.stringify(likeCount);
    return deals;
}

//sort by number(price)
function sortByPrice(deals){
    var likeCount = JSON.parse(sessionStorage.likeCount);
    for(var i=0; i<deals.length; i++){
        for(var j=i; j<deals.length; j++){

            var discount1 = deals[i].discount.replace(/%/g,"");
            var discount2 = deals[j].discount.replace(/%/g,"");
            var price1 = Math.floor(deals[i].actual_price - (deals[i].actual_price * discount1) / 100);
            var price2 = Math.floor(deals[j].actual_price - (deals[j].actual_price * discount2) / 100);
            if(price1 > price2){
                var temp = deals[i];
                deals[i] = deals[j];
                deals[j] = temp;

                //sort likes
                temp = likeCount[i];
                likeCount[i] = likeCount[j];
                likeCount[j] = temp;
            }
        }
    }
    sessionStorage.likeCount = JSON.stringify(likeCount);
    return deals;
}

//sort by discount
function sortByDiscount(deals){
    var likeCount = JSON.parse(sessionStorage.likeCount);
    for(var i=0; i<deals.length; i++){
        for(var j=i; j<deals.length; j++){

            var discount1 = deals[i].discount.replace(/%/g,"");
            var discount2 = deals[j].discount.replace(/%/g,"");

            if(discount1 < discount2){
                var temp = deals[i];
                deals[i] = deals[j];
                deals[j] = temp;

                //sort likes
                temp = likeCount[i];
                likeCount[i] = likeCount[j];
                likeCount[j] = temp;
            }
        }
    }
    sessionStorage.likeCount = JSON.stringify(likeCount);
    return deals;
}

//search box listener
$("body").on('keyup','.search-box',function (e) {
    //listen to 'Enter' key press
    if (e.keyCode == 13) {
        //get search term
        var searchTerm = $(this).val();

        //initialise final deals array
        var newDeals = [];

        //get data from session storage
        var deals = JSON.parse(sessionStorage.deals);

        //loop through to find matches
        deals.forEach(function(deal){
            //get and format all the param values
            var name = deal.name.toLowerCase();
            var discount = deal.discount.replace(/%/g,"");
            searchTerm = searchTerm.toLowerCase();

            //check for sub-string matches in name. Look for exact match in discount
            if(name.search(searchTerm)>= 0 || discount == searchTerm ){
                //select if match found
                newDeals.push(deal);
            }
        });

        populateDeals(newDeals);
    }
});