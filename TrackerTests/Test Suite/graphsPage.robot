*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    graphs.php

*** Test Cases ***
Graph drop-down list choice shows graph
    Page ID should be    graphPage
Graph drop-down changes graph    
    Page ID should be    graphPage