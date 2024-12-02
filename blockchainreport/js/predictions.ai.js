function closePricePredictionPopup(){
    hide(find(".view-price-predictions-overlay"));
}

function openPredictionsPopup(){
    show(find(".view-price-predictions-overlay"));
}

let currentDate = new Date();
let timestamps = [];
let finalPrices = [];
let days = 7;
let ethPrice = 1800;

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
  
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
  
    return [year, month, day].join('-');
}

for( let i = 0; i < days; i++){
    let nextDate = formatDate(currentDate.toString());
    currentDate.setDate(currentDate.getDate() + 1);
    timestamps.push(nextDate);
}

function mergeObjects( ArrayOfObjects ){
    let result = {};
    ArrayOfObjects.forEach(element => {
        result = { ...result, ...element }
    });
    return result;
}

( async () => {

    let container = document.querySelector(".predictions-inner-container");
    let pricesPromise = await fetch("pricepredictions/predictedPrices.json");
    let prices = await pricesPromise.json();
    prices = mergeObjects(prices);

    timestamps.forEach( date => finalPrices.push(prices[date]) )

     // set widget

     let currentPriceContainer = find(".current-price-container");
     let priceInETHNowPlaceholder = currentPriceContainer.querySelector(".price-eth");
     let priceInDollarsNowPlaceholder = currentPriceContainer.querySelector(".price-dollars");
 
     let priceInETHNow = (Number(finalPrices[0])).toFixed(5);
     priceInETHNowPlaceholder.innerHTML = `${priceInETHNow} ETH`;
 
     let priceInDollarsNow = (ethPrice * priceInETHNow).toFixed(2);
     priceInDollarsNowPlaceholder.innerHTML = `$${priceInDollarsNow}`;
 
     let bestPriceContainer = find(".best-predicted-price-container");
     let bestPriceInETHNowPlaceholder = bestPriceContainer.querySelector(".price-eth");
     let bestPriceInDollarsNowPlaceholder = bestPriceContainer.querySelector(".price-dollars");
     let bestPriceDatePlaceholder = bestPriceContainer.querySelector(".time-indicator-date");
 
     let bestPriceETH = finalPrices[0];
     let correspondingBestPriceDate = "";
     let indexForBestPrice = 0;
 
     for( let i = 0; i < finalPrices.length; i++ ){
         if( bestPriceETH > finalPrices[i] ){
             bestPriceETH = finalPrices[i];
             indexForBestPrice = i;
             correspondingBestPriceDate = timestamps[i];
         }
     }
 
     bestPriceDatePlaceholder.innerHTML = correspondingBestPriceDate;
 
 
     bestPriceInETHNowPlaceholder.innerHTML = `${(Number(bestPriceETH)).toFixed(5)} ETH`;
 
     let bestPriceInDollarsNow = (ethPrice * bestPriceETH).toFixed(2);
     bestPriceInDollarsNowPlaceholder.innerHTML = `$${bestPriceInDollarsNow}`;
     // end of setting widget

    let finalUI = `
    <div class="date-price-item">
        <div class="date-wrapper-container">
            <span class="date-label-name title-label">Day</span>
        </div>
        <span class="price-label-eth title-label">ETH Price</span>
        <span class="price-label-dollars title-label">Price in Dollars</span>
    </div>`;

    timestamps.forEach( (date,index) => {

        let datePriceItemClass = "date-price-item";
        index == indexForBestPrice ? datePriceItemClass = "date-price-item green-background" : datePriceItemClass = "date-price-item";

        let htmlUI = `
        <div class="${datePriceItemClass}">
            <div class="date-wrapper-container">
                <span class="date-label-name">${getDay(date)}</span>
                <span class="date-label-raw">${date}</span>
            </div>
            <span class="price-label-eth">${prices[date]}</span>
            <span class="price-label-dollars">$${(ethPrice*prices[date]).toFixed(2)}</span>
        </div>`;

        finalUI += htmlUI;

    });

    container.innerHTML = finalUI;

    const ctx = document.getElementById('myChart');

    const config = {
        type: 'line',
        data: {
            labels: timestamps,
            datasets: [{
            label: 'Price Predictions',
            title: "Transaction Price",
            data: finalPrices,
            fill: false,
            borderColor: 'orange',
            backgroundColor: "orange",
            tension: 0.1
            }]
        },
    };

    new Chart(ctx, config);


})();



function getDay(date){
    let dayNames = ["Sunday","Monday","Tuesday",
    "Wednesday","Thursday","Friday", "Saturday"];

    return dayNames[new Date(date).getDay()];
}