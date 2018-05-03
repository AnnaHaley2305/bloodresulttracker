*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    myAccount.php

*** Test Cases ***
Invalid postcode should fail
    Page ID Should Be    myAccountPage
Empty firstname should fail
    Page ID Should Be    myAccountPage
Empty password should fail
    Page ID Should Be    myAccountPage
Reset Password button should direct
    Page ID Should Be     myAccountPage
