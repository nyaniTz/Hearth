function getAlchemyKey() {
    const alchemyKey = "wss://eth-sepolia.g.alchemy.com/v2/y-jUXCAnXOuLpB7uDAhHLcdyW43vPZNl";
    return alchemyKey;
}

function getContractAddress(){
    const contractAddress = "0xa1A5702faB7cA4415Dba42c7aE9CD15Dda13d04C";
    return contractAddress;
}

async function loadContract() {

    const response = await fetch("contracts/health-report-abi.json");
    const contractABI = await response.json();
    
    const web3 = new Web3(getAlchemyKey());
    return new web3.eth.Contract(
        contractABI,
        getContractAddress()
    );

}

export { loadContract, getContractAddress };