<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Front-end application translations
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for the front-end application.
    |
    */

    'users' => [
        'status' => [
            'verified' => 'Verified',
            'not_verified' => 'Not verified',
            'ask_verify' => 'Verify email address',
        ],
        'roles' => [
            'regular' => 'Regular',
            'admin' => 'Administrator',
        ],
        'labels' => [
            'id' => 'ID',
            'id_pound' => '#',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'title' => 'Title',
            'middle_name' => 'Middle Name',
            'name' => 'Full Name',
            'avatar' => 'Avatar',
            'email' => 'Email',
            'role' => 'Role',
            'roles' => 'Roles',
            'status' => 'Status',
            'description' => 'Description',
            'address' => 'Address',
            'phone' => 'Phone',
            'locale' => 'Language',
            'timezone' => 'Timezone',
            'state' => 'Region',
            'city' => 'City',
            'country' => 'Country',
            'currency' => 'Currency',
            'current_password' => 'Current Password',
            'password' => 'Password',
            'new_password' => 'New Password',
            'confirm_password' => 'Confirm Password',
            'ask_upload_avatar' => 'Upload Avatar',
            'new_record' => 'New User',
            'edit_record' => 'Edit User',
            'general_settings' => 'General Settings',
            'password_settings' => 'Password Settings',
            'avatar_settings' => 'Avatar Settings',
        ],
    ],
    'messages' => [
        'name' => 'Message',
    ],
    'global' => [
        'menu' => [
            'setting' => 'Settings'
        ],
        'pages' => [
            'home' => 'Dashboard',

            'users' => 'Users',
            'users_create' => 'New User',
            'users_edit' => 'Edit User',

            'abilities' => 'Roles and Permissions',
            
            'roles' => 'Roles',
            'roles_create' => 'New Role',
            'roles_edit' => 'Edit Role',

            'permission' => 'Permissions',
            'permission_create' => 'New Permission',
            'permission_edit' => 'Edit Permission',
            'permission_asigned' => 'Assigned Permissions',

            'settings' => 'Settings',
            'general_info' => 'General Information',
            'settings_edit' => 'Edit Settings',

            'name_company' => 'Company Name',
            'profile' => 'Profile',
            'register' => 'Register',
            'login' => 'Login',
            'logout' => 'Logout',
            'forgot_password' => 'Forgot my password',
            'reset_password' => 'Reset Password',
            'lowercase'   => 'Lowercase',
            'uppercase'   => 'Uppercase'
        ],
        'phrases' => [
            'clear_filters' => 'Clear all',
            'loading' => 'Loading...',
            'sign_out' => 'Sign out',
            'all_records' => 'All records',
            'argh' => 'Argh!',
            'success' => 'Success!',
            'fix_errors' => 'Please fix the following errors:',
            'no_records' => 'No records found.',
            'login_desc' => 'If you are already a member, log in easily.',
            'login_not_verified' => 'Please verify your email to log in.',
            'register_desc' => 'If you do not have an account, register.',
            'reset_password_desc' => 'Fill out the form to reset your password.',
            'login_ask' => 'Do you already have an account?',
            'register_ask' => 'Don’t have an account?',
            'forgot_password_desc' => 'If you forgot your password, reset it below.',
            'forgot_password_ask' => 'Forgot your password?',
            'forgot_password_login' => 'Recovered your password? Log in.',
            'already_registered_login' => 'All done? Log in.',
            'inspire' => 'Let’s build something fun!',
            'copyright' => sprintf('Copyright &copy; %s. %s. All rights reserved.', date('Y'), env('APP_NAME')),
            'record_created' => 'Record created successfully.',
            'record_not_created' => 'Could not create the record.',
            'record_updated' => 'Record updated successfully.',
            'record_not_updated' => 'Could not update the record.',
            'record_deleted' => 'Record deleted successfully.',
            'record_not_deleted' => 'Could not delete the record.',
            'file_uploaded' => 'File uploaded successfully',
            'file_not_uploaded' => 'Could not upload the file',
            'password_updated' => 'Password updated successfully',
            'password_not_updated' => 'Could not update the password',
            'profile_updated' => 'Profile updated successfully',
            'profile_not_updated' => 'Could not update the profile',
            'not_found_title' => '404',
            'not_found_text' => 'The page you are looking for is not here.',
            'not_found_back' => 'Go back',
            'input_files_select' => 'Drop files here or click to upload | Drop the file here or click to upload',
            'input_files_selected' => '{count} file selected | {count} files selected',
            'email_verified' => 'Email verified successfully',
            'member_since' => 'Member since: {date}',
            'verification_sent' => 'Verification email sent.',
        ],
        'buttons' => [
            'add_new' => 'Add New',
            'filters' => 'Filters',
            'save' => 'Save',
            'send' => 'Send',
            'submit' => 'Submit',
            'login' => 'Login',
            'register' => 'Register',
            'search' => 'Search',
            'new_record' => 'New Record',
            'documentation' => 'Documentation',
            'back' => 'Go back',
            'upload' => 'Upload',
            'update' => 'Update',
            'change_avatar' => 'Change Avatar',
            'add' => 'Add',
            'remove' => 'Remove'
        ],
        'actions' => [
            'name' => 'Actions',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'filterbytitle' => 'Filter by title'
        ],
        'alerts' => [
            'success' => 'Success!',
            'warning' => 'Warning!',
            'danger' => 'Error!',
            'confirm' => 'Confirm!',
            'confirm_action_message' => 'Are you sure you want to perform this action?',
        ],
    ],
];
