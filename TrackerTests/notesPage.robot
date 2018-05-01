*** Settings ***
Library     Selenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    notes.php

*** Test Cases ***
Validate note date input with future date 
   Input text    note    Sample Note
   Press Key    startDate    23012018    
   Press Key    endDate    12122022
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note
   
Validate note date input with start date after end date
   Input text    note    Sample Note
   Press Key    startDate    23012018    
   Press Key    endDate    12122017
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note

Validate Empty Note Name
   Input text    note    ${EMPTY}
   Press Key    startDate    23012018    
   Press Key    endDate    31012018
   Page ID Should Be    notesPage
   Page Should Not Contain    2018-01-23
   
Validate start date not chosen
   Input text    note    Sample Note 
   Press Key    endDate    31012018
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note

Validate end date not chosen
   Input text    note    Sample Note 
   Press Key    startDate    31012018
   Page ID Should Be    notesPage
   Page Should Not Contain    Sample Note