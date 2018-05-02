*** Settings ***
Documentation     A resource file with reusable keywords and variables.
...
...               The system specific keywords created here form our own
...               domain specific language. They utilize keywords provided
...               by the imported Selenium2Library.
Library           Selenium2Library

*** Variables ***
${website}    http://mybloodresulttracker.co.uk/
${browser}    chrome
${validUser}    jsmith
${validPassword}    password1
${validUserPostcode}    BT56 1FD
${validUserDOB}         03101994

*** Keywords ***
Open Browser To Login Page
    Open Browser    ${website}    ${browser}
    Maximize Browser Window
    Page ID Should Be   loginPage

Open Browser To Login Page and Login
    Open Browser To Login Page
    Login

Page ID Should Be
    [Arguments]    ${contains}
    Page Should Contain Element    ${contains}

Go To Page
    [Arguments]    ${page}
    Go To    ${website}/${page}

Input Username
    [Arguments]    ${username}
    Input text    login-username    ${username}
    
Input Password
    [Arguments]    ${password}
    Input text    login-password    ${password}
    
Submit Login
    Click Button    login-submit

Login
    Go To Page     login.php
    Input Username    ${validUser}
    Input Password    ${validPassword}
    Submit Login
    Page ID Should Be    homepagePage