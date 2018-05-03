*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Setup    Go To Page    login.php

*** Keywords ***     

Login with invalid credentials should fail
    [Arguments]    ${username}     ${password}
    Input Username    ${username}
    Input Password    ${password}
    Submit Login
    Page should contain    Incorrect Username or Password

Login with empty credentials should fail
    [Arguments]    ${username}     ${password}
    Input Username    ${username}
    Input Password    ${password}
    Submit Login
    Page ID Should Be    loginPage
 
Login with valid credentials should pass
    [Arguments]    ${username}     ${password}
    Input Username    ${username}
    Input Password    ${password}
    Submit Login
    Page ID Should Be    homepagePage 
    
*** Test Cases ***


Username Valid Password Invalid      
    Login with invalid credentials should fail    ${validUser}    invalid
Username Invalid Password Valid
    Login with invalid credentials should fail    invalid    ${validPassword}
Username Valid Password Empty        
    Login with empty credentials should fail    ${validUser}    ${empty}
Both fields empty    
    Login with empty credentials should fail       ${empty}    ${empty}
Username Invalid Password Empty
    Login with empty credentials should fail      invalid         ${empty}
Username Empty Password Valid
    Login with empty credentials should fail        ${empty}        ${validPassword}
Username Empty Password Invalid
    Login with empty credentials should fail      ${empty}        invalid
Both Username and Password Valid
    Login with valid credentials should pass    ${validUser}    ${validPassword} 