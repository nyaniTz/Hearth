// SPDX-License-Identifier: MIT
pragma solidity 0.8.19;

contract HealthReports { 

    mapping(string => mapping(string => string)) public Reports;
    mapping(address => string[]) private ReportOwners;
    mapping(string => string[]) private ReportPermissions;
    mapping(string => string[]) private GroupedIdentifiers;

    event LogReportProgress(string reportID, string progress);

    function addReport( 
        string memory _reportID,
        string memory _reportName, 
        string[] memory _reportPermissions, 
        string memory _reportLink,
        string memory _reportOwnerName,
        string memory _doctorsEmail,
        string memory _ownersEmail,
        string memory _reportUploadDate
        ) public {   

        Reports[_reportID]["reportName"] = _reportName;
        Reports[_reportID]["reportLink"] = _reportLink;
        Reports[_reportID]["reportOwnerName"] = _reportOwnerName;
        Reports[_reportID]["reportUploadDate"] = _reportUploadDate;
        Reports[_reportID]["doctorsEmail"] = _doctorsEmail;
        Reports[_reportID]["ownersEmail"] = _ownersEmail;

        ReportOwners[msg.sender].push(_reportID);
        GroupedIdentifiers[_doctorsEmail].push(_reportID);
        
        for(uint i = 0; i < _reportPermissions.length; i++){
            ReportPermissions[_reportID].push(_reportPermissions[i]);
        }

        emit LogReportProgress(_reportID,"report added");

    }

    function getReports(address _address) public view 
    returns(string[] memory, string[] memory, string[] memory, string[] memory){

        string[] memory myReportIDs = ReportOwners[_address];
        string[] memory myReportNames = new string[](myReportIDs.length);
        string[] memory myReportLinks = new string[](myReportIDs.length);
        string[] memory myReportDates = new string[](myReportIDs.length);

        if( myReportIDs.length > 0 ){
            for(uint i = 0; i < myReportIDs.length; i++){
                myReportNames[i] = Reports[myReportIDs[i]]["reportName"];
                myReportLinks[i] = Reports[myReportIDs[i]]["reportLink"];
                myReportDates[i] = Reports[myReportIDs[i]]["reportUploadDate"];
            }
        }

        return (myReportIDs, myReportNames, myReportLinks, myReportDates);
    }

    modifier isReportOwner(address _address, string memory _reportID) {
        bool result = false;

        for(uint i = 0; i < ReportOwners[_address].length; i++){
            if( keccak256(bytes(ReportOwners[_address][i])) == keccak256(bytes(_reportID))){
                result = true;
                break;
            }
        }

        require( result == true );
        _;
    }

    function isPermitted(string memory _reportID, string memory _email) 
    public view returns(bool){
        bool result = false;

        for(uint i = 0; i < ReportPermissions[_reportID].length; i++){
            if( keccak256(bytes(ReportPermissions[_reportID][i])) == keccak256(bytes(_email))){
                result = true;
                break;
            }
        }
        
        return result;
    }

    function getReportByPermissions( string memory _reportID, string memory _email )
    public view returns(string memory, string memory, string memory){     
        if( isPermitted(_reportID, _email)){
            return (
                Reports[_reportID]["reportName"], 
                Reports[_reportID]["reportLink"], 
                Reports[_reportID]["reportOwnerName"]
            );
        }

        return ("Error","Error","Error");
    }

    // --> $@$@ <--
    function getReport( string memory _reportID )
    public view returns(string memory, string memory, string memory){     
        return (
            Reports[_reportID]["reportName"], 
            Reports[_reportID]["reportLink"], 
            Reports[_reportID]["reportOwnerName"]
        );
    }

    function getReportsByGroupedIdentifiers( string memory _email ) public view 
    returns(string[] memory, string[] memory, string[] memory, string[] memory){

        string[] memory _reportIDs = GroupedIdentifiers[_email];

        string[] memory myReportNames = new string[](_reportIDs.length);
        string[] memory myReportOwnerNames = new string[](_reportIDs.length);
        string[] memory myReportLinks = new string[](_reportIDs.length);
        string[] memory myReportDates = new string[](_reportIDs.length);

        if( _reportIDs.length > 0 ){
            for(uint i = 0; i < _reportIDs.length; i++){
                myReportNames[i] = Reports[_reportIDs[i]]["reportName"];
                myReportLinks[i] = Reports[_reportIDs[i]]["reportLink"];
                myReportDates[i] = Reports[_reportIDs[i]]["reportUploadDate"];
                myReportOwnerNames[i] = Reports[_reportIDs[i]]["reportOwnerName"];
            }
        }

        return (myReportNames, myReportOwnerNames, myReportLinks, myReportDates);
    }

    function getReportPermissions( string memory _reportID ) public view returns(string[] memory, string[] memory){     
        // the first return is the immutablePermissionsList ["owner","doctor"]
        // the second return is the mutablePermissionsList [...""]
        string[] memory immutablePermissionsList = new string[](2);
        immutablePermissionsList[0] = Reports[_reportID]["ownersEmail"];
        immutablePermissionsList[1] = Reports[_reportID]["doctorsEmail"];
        
        return (immutablePermissionsList,ReportPermissions[_reportID]);
    }

    function addPermissions ( string memory _reportID, string[] memory _emails ) public {
        for(uint i = 0; i < _emails.length; i++){
            ReportPermissions[_reportID].push(_emails[i]);
        }
        emit LogReportProgress(_reportID,"permissions added");
    }

    function removePermissions ( string memory _reportID, string[] memory _emails ) public {
        for(uint i = 0; i < _emails.length; i++){
            delete ReportPermissions[_reportID][i];
        }
        emit LogReportProgress(_reportID,"permissions removed");
    }

    function editPermissions ( string memory _reportID, string[] memory _emailsToAdd, string[] memory _emailsToRemove )
    isReportOwner(msg.sender, _reportID) public {
        addPermissions(_reportID, _emailsToAdd);
        removePermissions(_reportID, _emailsToRemove);
    }

    function matchID( string memory _reportID ) public view returns (string memory) {
        if ( ReportPermissions[_reportID].length > 0 ) return _reportID;
        else return "error";
    }
}