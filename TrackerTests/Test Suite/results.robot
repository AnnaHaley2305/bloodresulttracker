*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    results.php

*** Test Cases ***
Search box invalid search should return no results
    Page ID Should Be    resultsPage
Alert should show when archiving
    Page ID Should Be    resultsPage
Alert should show when deleting
    Page ID Should Be    resultsPage

