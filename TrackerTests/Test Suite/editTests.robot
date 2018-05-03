*** Settings ***
Library    ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login with admin
Suite Teardown    Close browser
Test Setup    Go To Page   editTest.php

*** Keyword ***
Category Form Validation
    Page ID Should Be    editTestsPage
Test Form Validation
    Page ID Should Be    editTestsPage
Range Form Validation
    Page ID Should Be    editTestsPage
    
   