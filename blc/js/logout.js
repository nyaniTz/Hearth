let isDropDown = false;

function dropdown(){
    let dropdownItem = document.querySelector(".logout");
    
    if(isDropDown){
        dropdownItem.style.display = "none";
        isDropDown = false;
    }
    else{
        dropdownItem.style.display = "block";
        isDropDown = true;
    }
}