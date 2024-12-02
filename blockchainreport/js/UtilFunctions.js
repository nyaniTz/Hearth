function uniqueID(){
    const date = Date.now();
    const dateReversed = parseInt(String(date).split("").reverse().join(""));

    const base36 = number => (number).toString(36);

    return base36(dateReversed) + base36(date);
}

function formattedDate(){
    const date = new Date();
    const day = String(date.getDate());
    const month = String(date.getMonth() + 1);
    const year = date.getFullYear();
    return `${day.padStart(2,"0")} / ${month.padStart(2,"0")} / ${year}`;
}

function unformattedDate(){
    const date = new Date();
    const day = String(date.getDate());
    const month = String(date.getMonth() + 1);
    const year = date.getFullYear();
    return `${year}-${month.padStart(2,"0")}-${day.padStart(2,"0")}`;
}

function formattedTime(){
    let date = new Date();
    var time = String(date.getHours()).padStart(2,"0") + ":" + String(date.getMinutes()).padStart(2,"0");
    return time;
}

function strip(arrayOfObjects,field) {

    let unstructuredArray = [];

    for(let i = 0; i < arrayOfObjects.length; i++){
        unstructuredArray.push(arrayOfObjects[i][field]);
    }

    return unstructuredArray;
}

function trim(text){ return text.split(" ").join(""); }

function filterOut(baseArray, indexArray){

    let result = [];

    baseArray.forEach( item => {
        if( !indexArray.includes(item) ){
          result.push(item);
        }
    });

    return result;
}

function existsInArray(array, string){
    for( let i = 0; i < array.length; i++ )
      if ( array[i] == string ) return { value: true, index: i };
    return { value: false, index: -1 };
}

function exposeEventListeners (...functionArrayList){
    functionArrayList.forEach( _function => {
        window[_function.name] = _function;
    });
}

function createObjectByMatchingArrays(baseArray,objectOfArrays){

    let structuredObject = {};
  
    let filteredArray = [...new Set([ ...baseArray ].sort())];
  
    filteredArray.forEach( element => {
        Object.keys(objectOfArrays).forEach( key => {
            structuredObject[element] = { [key] : [], ...structuredObject[element] };
        })
    });
  
    baseArray.forEach((element,index) => {
        Object.keys(objectOfArrays).forEach( key => {
            structuredObject[element][String(key)].push(objectOfArrays[String(key)][index]);
        });
    });
  
    return structuredObject;
  
}

function PascalCase(text){
    return text.replace(/(\w)(\w*)/g,
    function(g0,g1,g2){return g1.toUpperCase() + g2.toLowerCase();});
}

function getBrowserName(){
                 
    let userAgent = navigator.userAgent;
    let browserName;
    
    if(userAgent.match(/chrome|chromium|crios/i)){
        browserName = "Chrome";
      }else if(userAgent.match(/firefox|fxios/i)){
        browserName = "Firefox";
      }  else if(userAgent.match(/safari/i)){
        browserName = "Safari";
      }else if(userAgent.match(/opr\//i)){
        browserName = "Opera";
      } else if(userAgent.match(/edg/i)){
        browserName = "Edge";
      }else{
        browserName="No browser detection";
      }
    return browserName;
}

function isEmail( text ){
    let emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    return emailRegex.test( text );
}

function hide(element){ element.style.display = "none"; }
function show(element){ element.style.display = "block"; }
function gridShow(element){ element.style.display = "grid"; }
function find(element){ return document.querySelector(element) };
function findAll(element){ return document.querySelectorAll(element) };

export {    exposeEventListeners,
            uniqueID, formattedDate, unformattedDate, isEmail,
            trim, strip, filterOut, createObjectByMatchingArrays, existsInArray,
            PascalCase, getBrowserName,
            hide, show, gridShow, find, findAll, formattedTime
        };
        