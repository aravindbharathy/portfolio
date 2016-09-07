//localstorage setter and getters for persistence

function setLocalStorage(lists){
    localStorage.lists = angular.toJson(lists);
    return true;
}

function getLocalStorage(){
    return JSON.parse(localStorage.lists);
}

function setRecentActivity(activity){
    localStorage.recents = angular.toJson(activity);
    return true;
}

function getRecentActivity(){
    return JSON.parse(localStorage.recents);
}

//sample data

var Lists = [
    {
        name : "Getting Started",
        cards : [
            {
                title : "Taco  has some sample data",
                createdAt : 1452161581516,
                priority : "2",
                isDone : false,
                drag : true,
                comments : [
                    {
                        content : "Play around and reset data whenever required.",
                        writtenAt : 1452111581416
                    }
                ]
            },
            {
                title : "Here on, what you do will persist!",
                createdAt : 1452161541416,
                priority : "3",
                isDone : false,
                drag : true,
                comments : []
            },
            {
                title : "This is a completed task. Cheers!",
                createdAt : 1452161521416,
                priority : "0",
                isDone : true,
                drag : true,
                comments : []
            },
            {
                title : "Add comments to track progress and to add quick notes.",
                createdAt : 1452165581416,
                priority : "0",
                isDone : false,
                drag : true,
                comments : []
            }
        ],
        createdAt : 1452165581416,
        drag : true
    },
    {
        name : "Priorities",
        cards : [
            {
                title : "Sleep at least for 8 hours tomorrow.",
                createdAt : 1452130581416,
                priority : "1",
                isDone : false,
                drag : true,
                comments : [
                    {
                        content : "Plan dinner 8pm.",
                        writtenAt : 1452121581416
                    },
                    {
                        content : "Get to bed by 10pm sharp.",
                        writtenAt : 1452121591416
                    }
                ]
            },
            {
                title : "Learn to add priorities to the tasks by using the bar below.",
                createdAt : 1452121581416,
                priority : "3",
                isDone : true,
                drag : true,
                comments : []
            },
            {
                title : "Watch Star Wars.",
                createdAt : 1452121581416,
                priority : "2",
                isDone : false,
                drag : true,
                comments : [
                    {
                        content : "Book tickets for this weekend ASAP.",
                        writtenAt : 1452121581416
                    },
                    {
                        content : "Book for an evening show.",
                        writtenAt : 1452121581416
                    }
                ]
            }
        ],
        createdAt : 1452121581416,
        drag : true
    },
    {
        name : "Know more",
        cards : [
            {
                title : "Drag and drop to rearrange lists",
                createdAt : 1422161581416,
                priority : "2",
                isDone : false,
                drag : true,
                comments : []
            },
            {
                title : "Drag and drop to rearrange cards within lists",
                createdAt : 1252161581416,
                priority : "3",
                isDone : false,
                drag : true,
                comments : []
            },
            {
                title : "Mark the tasks complete once done. Just click on the check box below.",
                createdAt : 1152161581416,
                priority : "1",
                isDone : false,
                drag : true,
                comments : []
            },
            {
                title : "Search for tasks if it gets dizzy looking around the screen.",
                createdAt : 1152161581416,
                priority : "2",
                isDone : false,
                drag : true,
                comments : []
            }
        ],
        createdAt : 1152161581416,
        drag : true
    }
];

var recent = [
    {
        desc : "Changed Priority to Very Low - Task : Apple is red",
        doneAt : 1452254754296
    },
    {
        desc : "Marked Done - Task : Show recent activities in Taco",
        doneAt : 1452249792296
    },
    {
        desc : "Added new task",
        doneAt : 1452154784296
    }
];

//sample data initializers

if(!localStorage.lists)
    setLocalStorage(Lists);

if(!localStorage.recents)
    setRecentActivity(recent);

$('body').on('click','.reset-to-sample',function(){
    setLocalStorage(Lists);
    setRecentActivity(recent);
    location.reload();
});


//external functions

//calculate relative time
function timeDifference(current, previous) {

    var msPerMinute = 60 * 1000;
    var msPerHour = msPerMinute * 60;
    var msPerDay = msPerHour * 24;
    var msPerMonth = msPerDay * 30;
    var msPerYear = msPerDay * 365;

    var elapsed = current - previous;

    if (elapsed < msPerMinute) {
        return Math.round(elapsed/1000) + ' seconds ago';
    }

    else if (elapsed < msPerHour) {
        return Math.round(elapsed/msPerMinute) + ' minutes ago';
    }

    else if (elapsed < msPerDay ) {
        return Math.round(elapsed/msPerHour ) + ' hours ago';
    }

    else if (elapsed < msPerMonth) {
        return 'approximately ' + Math.round(elapsed/msPerDay) + ' days ago';
    }

    else if (elapsed < msPerYear) {
        return 'approximately ' + Math.round(elapsed/msPerMonth) + ' months ago';
    }

    else {
        return 'approximately ' + Math.round(elapsed/msPerYear ) + ' years ago';
    }
}

