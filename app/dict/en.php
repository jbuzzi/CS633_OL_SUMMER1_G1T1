<?php
return array(
    'messages' => array(
        'INVALID_EMAIL' => 'Enter a valid email address.',
        'INVALID_FIRST_NAME' => 'Enter a valid first name.',
        'INVALID_LAST_NAME' => 'Enter a valid last name.',
        'EMPTY_PASSWORD' => 'Enter a password.',
        'INVALID_PASSWORD' => 'Password must be a minimum of 6 characters with one uppercase letter, one lowercase letter, and one numeral. Beginning and trailing whitespaces will be trimmed.',
        'PASSWORD_MISMATCH' => 'The passwords you entered did not match.',
        'CORRECT_ERRORS_BELOW' => 'Please correct the errors below.',
        'REGISTERED' => 'You have been successsfully registered.',
        'INVALID_CREDENTIALS' => 'Your email or password was invalid. Please try again.',
        'USER_NOT_FOUND' => 'You do not have an account in our system. <a href="' . BASE::instance()->get('ALIASES')['register'] . '">Sign Up</a> now.',
        'ACCOUNT_EXISTS' => 'You already have an account. Why don\'t <a href="' . BASE::instance()->get('ALIASES')['login'] . '">Sign In</a> instead?',
        'DUPLICATE_ACCOUNT' => 'There is another account with this email address. Please try again.',
        'STUDY_SESSION_NOT_FOUND' => 'Study Session not found.',
        'EMPTY_START_TIME' => 'Enter a start time.',
        'INVALID_START_TIME' => 'Please select a valid start time from the calendar.',
        'EMPTY_END_TIME' => 'Enter an end time.',
        'INVALID_END_TIME' => 'Please select a valid end time from the calendar.',
        'EMPTY_LOCATION' => 'Select a location.',
        'EMPTY_DESCRIPTION' => 'Enter a description.',
        'STUDY_SESSION_ADDED' => 'Study session has been successfully created.',
        'PROFILE_UPDATED' => 'Your profile has been successfully updated.'
    )
);