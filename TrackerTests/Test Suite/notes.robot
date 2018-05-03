*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    notes.php

*** Test Cases ***
Note date input with future date should fail
   Input text    note    Sample Note
   Press Key    startDate    23012018    
   Press Key    endDate    12122022
   Click Element    submit    True
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note
   
Note date input with start date after end date should fail
   Input text    note    Sample Note
   Press Key    startDate    23012018    
   Press Key    endDate    12122017
   Click Element    submit   True
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note

Empty Note Name Should Fail
   Input text    note    ${EMPTY}
   Press Key    startDate    23012018    
   Press Key    endDate    31012018
   Click Element    submit   True
   Page ID Should Be    notesPage
   Page Should Not Contain    2018-01-23
   
Start date not chosen should fail
   Input text    note    Sample Note 
   Press Key    endDate    31012018
   Click Element    submit   True
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note

End date not chosen should fail
   Input text    note    Sample Note 
   Press Key    startDate    31012018
   Click Element    submit   True
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note