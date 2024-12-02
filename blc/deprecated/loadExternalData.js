let listOfUsersContainer = document.querySelector(".list-of-users");
    listOfUsersContainer.style.display = 'none';

function fetchUsers(inputElement) {

    if(inputElement.value != ""){
        let searchSequence = "" + inputElement.value;
        let params = `Name=${searchSequence}`;
        let xhr = new XMLHttpRequest();

        xhr.open("POST", "../include/patient_name.fetch.php", true);

        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xhr.onload = function(){
            let users;
            if( this.status == 200 ){
                users = JSON.parse(this.responseText);

                if(users.length != 0) listAvailableUsers(users);
                else listOfUsersContainer.style.display = 'none';
            }
        } 
        xhr.send(params);
    }
    else{ listOfUsersContainer.style.display = 'none'; }

}

function fetchUser(id) {

    let params = `id=${id}`;
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../include/patient_details.fetch.php", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function(){
        if( this.status == 200 ){
            let userDetails = JSON.parse(this.responseText);

            if(userDetails.length == 0) throw new Error('userDetails Came Empty');
            else console.log(userDetails);

            return userDetails;
        }
    } 

    xhr.send(params);
}

function listAvailableUsers(array){
    let usersHTML = ``;
    array.forEach( object => usersHTML += `<div class="user-item" onclick="setName(this)" data-name="${object['Name']}" data-id=${object['ID']}>${object['Name']}</div>` );
    listOfUsersContainer.innerHTML = usersHTML;
    listOfUsersContainer.style.display = 'block';
}

function setName(e){

    let person = {
        id: e.getAttribute('data-id'),
        name: e.getAttribute('data-name'),
    }

    let userSearch = document.querySelector(".user-search");
    userSearch.value = person.name;
    listOfUsersContainer.style.display = "none";

    // fetch user details

    let selectedPatient = fetchUser(person.id);

}
