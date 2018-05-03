*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Setup    Go To Page    homepage.php

*** Keywords ***
Check all links from page  
    [Arguments]   ${page}
    Login
    Go To Page    ${page}
    Click Link    My Results
    Click Link    archive
    Page ID Should Be    archivePage
    Go To Page    ${page}
    Click Link    More
    Click Link    help
    Page ID Should Be    helpPage
    Go To Page    ${page}
    Click Link    graphs.php
    Page ID Should Be    graphPage
    Go To Page    ${Page}
    Click Link   My Results
    Click Link   inputResults
    Page ID Should Be    inputResultsPage
    Go To Page    ${page}
    Click Link   More
    Click Link   myAccount
    Page ID Should Be    myAccountPage
    Click Link    notes.php
    Page ID Should Be    notesPage
    Go To Page    ${page}
    Click Link    My Results
    Click Link    results
    Page ID Should Be    resultsPage
    Go To Page    ${page}
    Click Link    My Dashboard
    Page ID Should Be    homepagePage
    Go To Page    ${page}
    Click Image    img/Logo3
    Page ID Should Be    homepagePage
    
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
 
Archive Check
    Check all links from page    archive.php  
Graphs
    Check all links from page    graphs.php
Homepage
    Check all links from page    homepage.php
Input Results
    Check all links from page    inputResults.php
Help 
    Check all links from page    help.php
My Account
    Check all links from page    myAccount.php
Notes
    Check all links from page    notes.php
Results   
    Check all links from page    results.php    