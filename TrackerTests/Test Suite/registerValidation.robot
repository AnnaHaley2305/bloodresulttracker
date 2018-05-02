*** Settings ***
Library     Selenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Setup    Open Register Form         


*** Variables ****
${validUsername}    NewUser
${validPassword}    NewPassword
${validName}        Donald
${validSurname}     Trump
${validGender}      M
${validPostcode}    SW1A 1AA
${validDOB}         03101994

*** Keywords *** 
Open Register Form
    Go To Page    login.php
    Click Element    register-form-link
    Wait Until Element Is Visible    register-form   
    
Register Username
    [Arguments]    ${args}
    Input text    register-username    ${args}
Register Password
    [Arguments]    ${args}
    Input text    register-password    ${args}
Reigster Confirm Password
    [Arguments]    ${args}
    Input text    confirm-password    ${args}
Register Firstname
    [Arguments]    ${args}
    Input text    firstname    ${args}
Register Lastname
    [Arguments]    ${args}
    Input text    secondname    ${args}
Register DOB
    [Arguments]    ${args}
    Press Key    dob    ${args}
Register Gender
    [Arguments]    ${args}    
    Select From List By Label   gender    ${args} 
Register Postcode
    [Arguments]    ${args}
    Input text    postcode    ${args}
Submit Register
    Click Button    register-submit
    
*** Test Cases ***
All values empty should fail
    Register Username            ${empty}
	Register Password            ${empty}
	Reigster Confirm Password    ${empty}
	Register Firstname           ${empty}
	Register Lastname            ${empty}
	Register Postcode            ${empty}
	Register DOB                 ${empty}
	Submit Register
	Page ID Should Be    loginPage

Empty username with all other valid should fail
    Register Username            ${empty}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Empty password with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${empty}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
	Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Empty confirm password with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${empty}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage
	
Empty name with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${empty}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Empty surname with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${empty}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Empty postcode with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${empty}
	Submit Register
	Page ID Should Be    loginPage

Invalid postcode with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
    Register DOB                 ${validDOB}
	Register Postcode            1234 567
	Submit Register
	Page ID Should Be    loginPage
	Register Postcode            abcdefg
	Submit Register
	Page ID Should Be    loginPage
	
Mismatched password with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    invalid
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Mismatched confirm password with all other valid should fail
    Register Username            ${validUsername}
	Register Password            invalid
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Mismatched password should produce alert
    Register Username            ${validUsername}
    Element Should Not Be Visible    message    
	Register Password            invalid
	Reigster Confirm Password    ${validPassword}
	Element Should Be Visible    message
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage

Password too short with all other valid should fail
    Register Username            ${validUsername}
	Register Password            two
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage
	
Password too long with all other valid should fail
    Register Username            ${validUsername}
	Register Password            aaaaaaaaaaaaaaaaaaaaa
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage
	
Confirm password too short with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    two
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage
	
Confrim password too long with all other valid should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    aaaaaaaaaaaaaaaaaaaaa
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page ID Should Be    loginPage
	
Date under age 18 should fail
    Register Username            ${validUsername}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 01012008
	Submit Register
	Page ID Should Be    loginPage
	
Username already exists should create an alert
    Register Username            ${validUser}
	Register Password            ${validPassword}
	Reigster Confirm Password    ${validPassword}
	Register Firstname           ${validName}
	Register Lastname            ${validSurname}
	Register Gender              ${validGender}
	Register Postcode            ${validPostcode}
    Register DOB                 ${validDOB}
	Submit Register
	Page Should Contain          That Username already exists, Please try again