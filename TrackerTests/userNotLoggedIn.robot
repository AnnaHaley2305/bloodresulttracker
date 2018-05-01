*** Settings ***
Library     Selenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page
Suite Teardown    Close browser
Test Template    Test login page is shown if user is not logged in

*** Keywords ***     

Test login page is shown if user is not logged in
    [Arguments]    ${page}
    Go to page     ${page}
    Page ID Should Be    loginPage
    
*** Test Cases ***
Archive              archive.php
EditTests            editTests.php    
Graphs               graphs.php
Help                 help.php
Homepage             homepage.php
Input Results        inputResults.php
Logout               logout.php
My Account           myAccount.php
Notes                notes.php
Reset Password       resetPassword.php
Results              results.php            