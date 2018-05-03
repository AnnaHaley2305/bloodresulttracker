*** Settings ***
Library     ExtendedSelenium2Library
Resource    resource.robot
Suite Setup    Open browser to login page and login
Suite Teardown    Close browser
Test Setup    Go To Page    archive.php

*** Test Cases ***
Undo archive button should create alert
    Page ID Should Be    archivePage