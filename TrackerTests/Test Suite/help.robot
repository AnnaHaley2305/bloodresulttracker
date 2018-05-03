*** Settings ***
Library    ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    help.php

*** Keyword ***
Help Point Should Toggle
    [Arguments]    ${helpPoint}    ${div}
    Page Should Not Contain Element   ${div}.panel-body
    Click Link    ${helpPoint}
    Page Should Not Contain Element   ${div}.panel-body
    Click Link    ${helpPoint}   
    Page Should Not Contain Element   ${div}.panel-body
    
*** Test Cases ***
Help Point 1
   Help Point Should Toggle    \#collapse1    collapse1
Help Point 2
   Help Point Should Toggle    \#collapse2    collapse2
Help Point 3
   Help Point Should Toggle    \#collapse3    collapse3
Help Point 4
   Help Point Should Toggle    \#collapse4    collapse4
Help Point 5
   Help Point Should Toggle    \#collapse5    collapse5
Help Point 6
   Help Point Should Toggle    \#collapse6    collapse6
Help Point 7
   Help Point Should Toggle    \#collapse7    collapse7
Help Point 8
   Help Point Should Toggle    \#collapse8    collapse8
Help Point 9
   Help Point Should Toggle    \#collapse9    collapse9
Help Point 10
   Help Point Should Toggle    \#collapse10    collapse10
Help Point 11
   Help Point Should Toggle    \#collapse11    collapse11
Help Point 12
   Help Point Should Toggle    \#collapse12    collapse12
     
