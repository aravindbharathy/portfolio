(function(){
    //the base module
    var app = angular.module('taco', ['ngDragDrop']);

    //directive for lists and tasks
    app.directive('taskList',function(){
        return {
            restrict : 'E',
            templateUrl : 'directives/task-list.html',
            controller : function(){
                //local parameters
                this.lists = getLocalStorage();
                this.list = {};
                this.card = {};
                this.editorEnabled = false;
                this.commentShown = false;
                this.commentContent = "";
                this.currentList = -1;
                this.currentCardList = -1;
                this.currentCard = -1;
                this.recentActivity = {};

                //adding to list and task
                //add card(task)
                this.addCard = function(list){
                    //create the card
                    this.card.createdAt = Date.now();
                    this.card.isDone = false;
                    this.card.priority = "0";
                    this.card.comments = [];

                    //add the card
                    list.cards.push(this.card);

                    //post adding operations
                    this.card = {};
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Added New Task");
                };
                //add list
                this.addList = function(){
                    //create the list
                    this.list.createdAt = Date.now();
                    this.list.cards = [];

                    //add the list
                    this.lists.push(this.list);

                    //post adding operations
                    this.list = {};
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Added New List");
                };

                //deleting lists and cards
                //delete card
                this.deleteCard = function(list,card){
                    //match timestamp and delete card
                    for(var i = list.cards.length - 1; i >= 0; i--) {
                        var createdAt = card.createdAt;
                        if(list.cards[i].createdAt === createdAt) {
                            list.cards.splice(i, 1);
                            break;
                        }
                    }

                    //post deletion
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Deleted Task : " + card.title + ".");
                };
                //delete list
                this.deleteList = function(list){
                    //match timestamp and delete list
                    for(var i = this.lists.length - 1; i >= 0; i--) {
                        var createdAt = list.createdAt;
                        if(this.lists[i].createdAt === createdAt) {
                            this.lists.splice(i, 1);
                            break;
                        }
                    }

                    //post deletion
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Deleted List : " + list.name + ".");
                };

                //updating of list and cards
                //titles of list
                //editor enable/disable/save
                this.enableListEditor = function(list,key) {
                    this.editorEnabled = true;
                    this.list.name = list.name;
                    this.currentList = key;
                };
                this.disableListEditor = function() {
                    this.editorEnabled = false;
                    this.currentList = -1;
                    setLocalStorage(this.lists);
                };
                this.saveListTitle = function(list) {
                    list.name = this.list.name;
                    this.addRecentActivity("Updated List : " + list.name + ".");
                    this.disableListEditor();
                };

                //titles of card
                //editor enable/disable/save
                this.enableCardEditor = function(card,key,count){
                    this.editorEnabled = true;
                    this.card.title = card.title;
                    this.currentCardList = key;
                    this.currentCard = count;
                };
                this.disableCardEditor = function() {
                    this.editorEnabled = false;
                    this.currentCard = -1;
                    setLocalStorage(this.lists);
                };
                this.saveCardTitle = function(card) {
                    card.title = this.card.title;
                    this.addRecentActivity("Updated Task : " + card.title + ".");
                    this.disableCardEditor();
                };

                //done/undone of tasks
                //state saver
                this.saveStateOfTask = function(card,type){
                    if(type === "state")
                        this.addRecentActivity("Marked "+ (card.isDone ? "Done" : "Undone") +" - Task : " + card.title + ".");
                    else
                        this.addRecentActivity("Changed Priority to "+ this.whatPriority(card.priority) +" - Task : " + card.title + ".");
                    setLocalStorage(this.lists);
                };

                //priority number to words converter
                this.whatPriority = function(val){
                    switch(val){
                        case "0":
                            return "Very Low";
                        case "1":
                            return "Low";
                        case "2":
                            return "Medium";
                        case "3":
                            return "High";
                    }
                };

                //controls for checking current list and cards
                this.isCurrentList = function(key){
                    return key === this.currentList;
                };
                this.isCurrentCard = function(count){
                    return count === this.currentCard;
                };
                this.isCurrentCardList = function(key){
                    return key === this.currentCardList;
                };

                //global recent activity adder
                this.addRecentActivity = function(activity){
                    //create activity details
                    this.recentActivity.desc = activity;
                    this.recentActivity.doneAt = Date.now();
                    var recents = getRecentActivity();

                    //add and if greater than 10, delete the old one.
                    recents.unshift(this.recentActivity);
                    if(recents.length > 10){
                        recents.splice(10,1);
                    }
                    setRecentActivity(recents);
                };

                //state saver
                this.saveState = function(){
                    setLocalStorage(this.lists);
                };

                //comment
                //show / hide comment
                this.showHideComment = function(key,count){
                    this.currentCard = count;
                    this.currentCardList = key;
                    this.commentShown = !this.commentShown;
                };

                //add comment
                this.addComment = function(card){
                    var comment = {};
                    comment.content = this.commentContent;
                    comment.writtenAt = Date.now();
                    card.comments.push(comment);
                    this.commentContent = "";
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Comment \"" + comment.content + "\" added to task \"" + card.title + "\"");
                };

                //delete comment
                this.deleteComment = function(card,comment){
                    //match timestamp and delete comment
                    for(var i = card.comments.length - 1; i >= 0; i--) {
                        var writtenAt = card.comments[i].writtenAt;
                        if(comment.writtenAt === writtenAt) {
                            card.comments.splice(i, 1);
                            break;
                        }
                    }
                    setLocalStorage(this.lists);
                    this.addRecentActivity("Comment \"" + comment.content + "\" deleted from task \"" + card.title + "\"");
                };
            },
            controllerAs : 'listCtrl'
        };
    });

    //directive for sidebar operations
    app.directive('taskSidebar',function(){
       return{
           restrict : 'E',
           templateUrl : 'directives/task-sidebar.html',
           controller : ['$interval',function($interval){
               //local properties
               var store = this;
               this.counter = 0;
               this.searchTerm = "";
               this.searchList = [];
               this.resultSet = [];
               this.recents = getRecentActivity();
               this.recentActivity = {};

               //match content and search across all tasks
               this.searchTask = function(){
                   this.searchList = getLocalStorage();
                   this.resultSet = [];
                   this.searchList.forEach(function(list) {
                       list.cards.forEach(function(card){
                           if(store.searchTerm.length != 0 && card.title.toLowerCase().indexOf(store.searchTerm.toLowerCase()) > -1){
                               store.resultSet.push(card);
                           }
                       })
                   });
               };

               //get relative time
               this.timeDiff = function(previous){
                    var current = Date.now();
                    var store = this;
                    if(this.counter === 0){
                        store.counter = 1;
                        //handle javascript's turn based updation
                        $interval(function(){
                            store.recents = getRecentActivity();
                        },3000);
                    }
                    return timeDifference(current,previous);
               };
           }],
           controllerAs : 'sidebarCtrl'
       };
    });

    //directive for handling all dynamic object initializations
    app.directive('name', function() {
        return {
            link: function($scope, element, attrs) {
                //trigger when number of children changes
                var watch = $scope.$watch(function() {
                    return element.children().length;
                }, function() {
                    //wait for templates to render
                    $scope.$evalAsync(function() {
                        //rating bar plugin initialization
                        $('.task-priority').barrating({
                            theme: 'bars-movie'
                        });
                        $('.search-results .task-priority').barrating('readonly', true);
                        $(".card").droppable({
                            accept: function(d) {
                                if(d.attr("data-curlist") == $(this).attr("data-curlist")){
                                    return true;
                                }
                            }
                        });
                    });
                });
            }
        };
    });
})();