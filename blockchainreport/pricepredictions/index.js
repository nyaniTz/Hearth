let { trainModel, makePredictions } = require("./localModel.js");
let { updateFile } = require("./jsonCreator.js");
const fs = require('fs');
var cron = require('node-cron');

let windowSize = 4;
let trainingSize = 98;
let numberOfEpochs = 10; // change to 50 or 100
let learningRate = 0.001;
let numberOfHiddenLayers = 10;

// var http = require('http');

// var server = http.createServer(function(req, res) {
//     res.writeHead(200, {'Content-Type': 'text/plain'});
//     var message = 'Running Predictions in Background...\n',
//         version = 'NodeJS ' + process.versions.node + '\n',
//         response = [message, version].join('\n');
//     res.end(response);
// });
// server.listen();

cron.schedule('*/5 * * * *', async() => {

    let { rawData, SMAVector } = await handleData();
    let result = await handleTrainModel(SMAVector);
    handlePredict(rawData, SMAVector, result);

});


async function handleData(){
    let response = fs.readFileSync('ethereum-transaction-prices.json');
    let rawData = JSON.parse(response);
    let SMAVector = ComputeSMA(rawData, windowSize);
    return { rawData, SMAVector };
}

async function handleTrainModel(SMAVector){

  let inputs = SMAVector.map(function(inp_f){
    return inp_f['set'].map(function(val) { return val['price']; })
  });
  let outputs = SMAVector.map(function(outp_f) { return outp_f['avg']; });

  inputs = inputs.slice(0, Math.floor(trainingSize / 100 * inputs.length));
  outputs = outputs.slice(0, Math.floor(trainingSize / 100 * outputs.length));

  let callback = function(epoch, log) {
    console.log(`Epoch #${(epoch + 1)} of #${numberOfEpochs} -- loss: ${(log.loss).toFixed(11)}`);
  };

  let result = await trainModel(inputs, outputs, windowSize, numberOfEpochs, learningRate, numberOfHiddenLayers, callback);
  // await result.model.save('file://output/model');

  return result;
}

async function handlePredict(rawData, SMAVector, result) {

  let inputs = SMAVector.map(function(inp_f) {
   return inp_f['set'].map(function (val) { return val['price']; });
  });
  
  let slidingWindow = [inputs[inputs.length-1]];
  slidingWindow = slidingWindow.slice(Math.floor(trainingSize / 100 * slidingWindow.length), slidingWindow.length);
  console.log("slidingWindow:", slidingWindow);
  let ethereumPricePrediction = makePredictions(slidingWindow, result['model'], result['normalize']);
  console.log("ethereumPricePrediction:", ethereumPricePrediction);

  let timestamps_d = rawData.map(function (val) {
    return val['timestamp'];
  }).splice((rawData.length - windowSize), rawData.length);

  let last_date = new Date(timestamps_d[timestamps_d.length-1]);
  let add_days = 1;

  last_date.setDate(last_date.getDate() + add_days);
  let next_date = await formatDate(last_date.toString());

  let finalObjectA = { "timestamp" : next_date, "price" : Number((ethereumPricePrediction[0]).toFixed(9))};
  let finalObjectB = { [next_date] : Number((ethereumPricePrediction[0]).toFixed(9))};

  updateFile(finalObjectA,"ethereum-transaction-prices.json");
  updateFile(finalObjectB,"predictedPrices.json");

}

function ComputeSMA(data, window_size)
{
  let r_avgs = [], avg_prev = 0;
  for (let i = 0; i <= data.length - window_size; i++){
    let curr_avg = 0.00, t = i + window_size;
    for (let k = i; k < t && k <= data.length; k++){
      curr_avg += data[k]['price'] / window_size;
    }
    r_avgs.push({ set: data.slice(i, i + window_size), avg: curr_avg });
    avg_prev = curr_avg;
  }
  return r_avgs;
}

function formatDate(date) {
  var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

  if (month.length < 2) month = '0' + month;
  if (day.length < 2) day = '0' + day;

  return [year, month, day].join('-');
}