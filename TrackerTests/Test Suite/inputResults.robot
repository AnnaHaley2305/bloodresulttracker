*** Settings ***
Library     Selenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    inputResults.php

*** Variables ***
${validCategory}    Liver Function Test
${validTest}    Albumin    
${validRange}    35.00 - 50.00

*** Test Cases ***
Result date input with future date should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    35
   Input Text    results-decimal    00  
   Press Key    date    12122022
   Click Button    submit   
   Page ID Should Be    inputResultsPage
  
Result input with a minus number should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    -1
   Input Text    results-decimal    00  
   Press Key    date    12122017
   Click Button    submit   
   Page ID Should Be    inputResultsPage

Result input with value 1000 should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    1000
   Input Text    results-decimal    00  
   Press Key    date    12122017
   Click Button    submit   
   Page ID Should Be    inputResultsPage

Result decimal input with value 100 should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    10
   Input Text    results-decimal    100
   Press Key    date    12122017
   Click Button    submit   
   Page ID Should Be    inputResultsPage

Result input with value aa should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    aa
   Input Text    results-decimal    10
   Press Key    date    12122017
   Click Button    submit   
   Page ID Should Be    inputResultsPage
   
Result decimal input with value aa should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Select From List By Label    test    ${validTest}
   Sleep    0.5
   Select From List By Label    range    ${validRange}
   Input Text    results    10
   Input Text    results-decimal    aa
   Press Key    date    12122017
   Click Button    submit   
   Page ID Should Be    inputResultsPage
   
Empty category input should fail
   Input Text    results    35
   Input Text    results-decimal    00  
   Press Key    date    12122022
   Click Button    submit   
   Page ID Should Be    inputResultsPage
   
Empty test input should fail
   Select From List By Label    category    ${validCategory}
   Sleep    0.5
   Input Text    results    35
   Input Text    results-decimal    00  
   Press Key    date    12122022
   Click Button    submit   
   Page ID Should Be    inputResultsPage