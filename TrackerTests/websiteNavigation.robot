*** Settings ***
Library     Selenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Setup    Go To Page    homepage.php

*** Test Cases ***
Navigate to archive once logged in as user
    Login
    Go to page    archive.php
    Page ID Should Be    archivePage

Navigate to archive once logged in as user using buttons
    Login
    Click Link    My Results
    Click Link    archive
    Page ID Should Be    archivePage
   
Navigate to graphs once logged in as user 
    Login
    Go to page    graphs.php
    Page ID Should Be    graphPage

Navigate to graphs once logged in as user using buttons 
    Login
    Click Link    graphs.php
    Page ID Should Be    graphPage
      
Navigate to help once logged in as user
    Login
    Go to page    help.php
    Page ID Should Be    helpPage

Navigate to help once logged in as user using buttons
    Login
    Click Link    More
    Click Link    help
    Page ID Should Be    helpPage

Navigate to inputResults once logged in as user 
    Login
    Go to page    inputResults.php
    Page ID Should Be    inputResultsPage
    
Navigate to inputResults once logged in as user using buttons
    Login
    Click Link   My Results
    Click Link   inputResults
    Page ID Should Be    inputResultsPage
    
Navigate to logout once logged in as user 
    Login
    Go to page    logout.php
    Page ID Should Be    loginPage

Navigate to logout once logged in as user using buttons
    Login
    Click Link    More
    Click Link    logout
    Page ID Should Be    loginPage

Navigate to myAccount once logged in as user 
    Login
    Go to page    myAccount.php
    Page ID Should Be    myAccountPage
    
Navigate to myAccount once logged in as user using buttons
    Login
    Click Link   More
    Click Link   myAccount
    Page ID Should Be    myAccountPage
    
Navigate to notes once logged in as user 
    Login
    Go to page    notes.php
    Page ID Should Be    notesPage

Navigate to notes once logged in as user using buttons
    Login
    Click Link    notes.php
    Page ID Should Be    notesPage

Navigate to results once logged in as user 
    Login
    Go to page    results.php
    Page ID Should Be    resultsPage
    
Navigate to results once logged in as user using buttons
    Login
    Click Link    My Results
    Click Link    results
    Page ID Should Be    resultsPage
    
