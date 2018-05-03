*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Setup    Go To Page     forgotPassword.php        

*** Variables ****
${validUsername}    crose
${validPassword}    password
${validPostcode}    BT1 5SE
${validDOB}         06031934

*** Test Cases *** 
Empty inputs should fail
    Input text    username    ${empty}
    Press Key   dob    ${empty}
    Input text    postcode    ${empty}
    Click Element    forgot-submit    True
    Page ID Should Be    forgotPasswordPage
    
Invalid username should fail
    Page ID Should Be    forgotPasswordPage
    
Invalid dob should fail
    Page ID Should Be    forgotPasswordPage
 
Invalid postcode should fail
    Page ID Should Be    forgotPasswordPage

Valid details should direct to reset password
    Input text    username    ${validUsername}
    Press Key    dob    ${validDOB}
    Input text    postcode    ${validPostcode}
    Click Element    forgot-submit    True
    Page ID Should Be    resetPasswordPage