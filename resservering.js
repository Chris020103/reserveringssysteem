    const nextYear = new Date().getFullYear() + 1;
    const myCalender = new CalendarPicker('#myCalendarWrapper', {
    // If max < min or min > max then the only available day will be today.
    min: new Date(),
    max: new Date(nextYear, 10), // NOTE: new Date(nextYear, 10) is "Nov 01 <nextYear>"
    locale: 'en-US', // Can be any locale or language code supported by Intl.DateTimeFormat, defaults to 'en-US'
    showShortWeekdays: true // Can be used to fit calendar onto smaller (mobile) screens, defaults to false
});

    const currentToDateString = document.getElementById('current-datestring');

    $.ajax({
    url: "/reserveringssysteem/controllers/getDateOptions.php",
    type: "get", //send it through get method
    data: {
    date: myCalender.value.toLocaleDateString()
},
    success: function(data) {
    currentToDateString.innerHTML = "";

    data = JSON.parse(data);
    data.forEach((item, index)=>{
    if(!Array.isArray(item)){
    let newdiv = document.createElement("button");
    newdiv.setAttribute("class", "btn btn-primary");
    newdiv.setAttribute("type", "button");
    newdiv.setAttribute('id', item.id)
    newdiv.setAttribute("style", "margin-left: 5px;");
    newdiv.setAttribute('onclick','makeReservation();'); // for FF
    newdiv.onclick = function() {makeReservation(item.id, myCalender.value.toLocaleDateString());}; // for IE
    newdiv.innerHTML = item.TimeStamp;
    currentToDateString.appendChild(newdiv)
}
})
},
    error: function(xhr) {
    //Do Something to handle error
}
});
    myCalender.onValueChange((currentValue) => {
    $.ajax({
        url: "/reserveringssysteem/controllers/getDateOptions.php",
        type: "get", //send it through get method
        data: {
            date: myCalender.value.toLocaleDateString()
        },
        success: function(data) {
            currentToDateString.innerHTML = "";
            document.getElementById('fault').innerHTML = "";
            data = JSON.parse(data);
            data.forEach((item, index)=>{
                if(!Array.isArray(item)){
                    let newdiv = document.createElement("button");
                    newdiv.setAttribute("class", "btn btn-primary");
                    newdiv.setAttribute("type", "button");
                    newdiv.setAttribute('id', item.id)
                    newdiv.setAttribute("style", "margin-left: 5px;");
                    newdiv.setAttribute('onclick','makeReservation();'); // for FF
                    newdiv.onclick = function() {makeReservation(item.id, myCalender.value.toLocaleDateString());}; // for IE
                    newdiv.innerHTML = item.TimeStamp;
                    currentToDateString.appendChild(newdiv)
                }
            })

        },
        error: function(xhr) {
            //Do Something to handle error
        }
    });

});

    function makeReservation(id, date) {
    $.ajax({
        url: "/reserveringssysteem/controllers/userController.php",
        type: "get", //send it through get method
        data: {
            data: "getSessionInfo"
        }

    }).done(function (data){
        document.getElementById('fault').innerHTML = "";
        document.getElementById('logout').innerHTML = "";

        data = JSON.parse(data);
        if(data.loggedIn){
            let newdiv = document.createElement("div");
            newdiv.setAttribute("class", "alert alert-success");
            newdiv.setAttribute("id", "alert-div");
            newdiv.innerHTML = "U bent al ingelogd, wilt u dit tijdsvak reserveren?";
            newdiv.innerHTML += "</br>";
            let ahref = document.createElement('a');
            ahref.setAttribute('href', "/reserveringssysteem/reservation/?id=" + id + "&date=" + date);
            ahref.setAttribute('class', "a-button");
            ahref.innerHTML = "Dit tijdsvak reserveren"
            document.getElementById('fault').appendChild(newdiv);
            document.getElementById('alert-div').appendChild(ahref);

            let LogoutButton = document.createElement("button");
            LogoutButton.setAttribute('class', 'btn');
            LogoutButton.setAttribute('type', 'button');
            LogoutButton.setAttribute('onclick','logOut();'); // for FF
            LogoutButton.onclick = function() {logOut()}; // for IE
            LogoutButton.innerHTML = ('Uitloggen');
            document.getElementById('logout').appendChild(LogoutButton);
            data.loggedIn = false;

        }else{
            let newdiv = document.createElement("div");
            newdiv.setAttribute("class", "alert alert-danger");
            newdiv.innerHTML = "U bent nog niet ingelogd, wilt u inloggen?";
            newdiv.setAttribute("id", "alert-div");
            newdiv.innerHTML += "</br>";
            let ahref = document.createElement('a');
            ahref.setAttribute('href', "/reserveringssysteem/login");
            ahref.setAttribute('class', "a-button");
            ahref.innerHTML = "Inloggen"
            document.getElementById('fault').appendChild(newdiv)
            document.getElementById('alert-div').appendChild(ahref);
        }
    });
}

    function logOut () {
    $.ajax({
        url: '/reserveringssysteem/controllers/userController.php',
        type: 'get',
        data: {
            data: 'logOut'
        }
    }).done(function (data){

        data = JSON.parse(data);
        document.getElementById('fault').innerHTML = "";
        document.getElementById('fault').innerHTML = "";

        if(data.success){
            let newdiv = document.createElement("div");
            newdiv.setAttribute("class", "alert alert-danger");
            newdiv.innerHTML = "U bent nog niet ingelogd, wilt u inloggen?";
            newdiv.setAttribute("id", "alert-div");
            newdiv.innerHTML += "</br>";
            let ahref = document.createElement('a');
            ahref.setAttribute('href', "/reserveringssysteem/login");
            ahref.setAttribute('class', "a-button");
            ahref.innerHTML = "Inloggen"
            document.getElementById('fault').appendChild(newdiv)
            document.getElementById('alert-div').appendChild(ahref);
        }else{
            let newdiv = document.createElement("div");
            newdiv.setAttribute("class", "alert alert-danger");
            newdiv.innerHTML = "Er is wat fout gegaan tijdens het uitloggen";
            newdiv.setAttribute("id", "alert-div");
            document.getElementById('fault').appendChild(newdiv)
        }
    })
}
