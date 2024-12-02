var fs = require('fs');

function writeFile(objectData,filename){
    let json = JSON.stringify(objectData);
    fs.writeFile(filename, json, 'utf8', () => {});
}

function updateFile(objectData,filename){
    fs.readFile(filename, 'utf8', function readFileCallback(err, data){
        if (err) {
            console.log(err);
            throw new Error("Error Reading File"); 
        }
        else {
        let parsedObject = JSON.parse(data);
        parsedObject.push(objectData);
        writeFile(parsedObject,filename);
    }});
}

exports.writeFile = writeFile;
exports.updateFile = updateFile;