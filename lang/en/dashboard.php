<?php

return [
        'common' => [
            'dashboard' => 'Dashboard',
            'save' => 'Save',
            'update' => 'Update',
            'cancel' => 'Cancel',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view' => 'View',
            'actions' => 'Actions',
            'yes' => 'Yes',
            'no' => 'No',
            'select' => 'Select',
            'number' => 'Index',
            'back' => 'Back',
            'id' => 'id',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at',
            'information' => 'Information',
            'name' => 'Name',
            'password_confirmation' => 'Confirm Password',
            'link' => 'Link',
            'filters' => 'Filters',
            'filter' => 'Filter',
            'reset' => 'Reset',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'active_filters' => 'Active Filters',
            'import' => 'Import',
            'export' => 'Export',
            'download_template' => 'Download Template',
            'import_instructions' => 'Import Instructions',
            'download_template_first' => 'Download the template file first',
            'fill_data_exactly' => 'Fill the data exactly as shown in the headers',
            'phone_must_be_unique' => 'Phone numbers must be unique',
            'branch_city_district_must_exist' => 'Branch, City, and District names must exist in the system',
            'select_file' => 'Select Excel File',
            'import_errors' => 'Import Errors',
            'row' => 'Row',
            'errors' => 'Errors',
            'import_error_note' => 'The rows above had errors and were not imported. Other valid rows were imported successfully.',
            'roles' => 'Roles',
            'permissions' => 'Permissions',
            'type' => 'Type',
            'individual' => 'Individual',
            'company' => 'Company',
        ],
        'company' => [
            'title' => 'Company',
            'title_plural' => 'Companies',
            'management' => 'Companies Management',
            'list' => 'Companies List',
            'create' => 'Create Company',
            'edit' => 'Edit Company',
            'view' => 'View Company',
            'delete' => 'Delete Company',
            'add_new' => 'Add New Company',
            'create_new' => 'Create New Company',
            'update' => 'Update Company',
            'show' => 'Show Company',
            'actions' => 'Actions',
            'no_records' => 'No Companies found.',
            'fill_required' => 'Please fill in all required fields to create a new Company.',
            'update_info' => 'Update the information for this Company.',
            'delete_confirm' => 'Are you sure you want to delete this Company?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'is_active' => 'Is Active',
            ],
        ],
        'team' => [
            'title' => 'Team',
            'title_plural' => 'Teams',
            'management' => 'Teams Management',
            'list' => 'Teams List',
            'create' => 'Create Team',
            'edit' => 'Edit Team',
            'view' => 'View Team',
            'delete' => 'Delete Team',
            'add_new' => 'Add New Team',
            'create_new' => 'Create New Team',
            'update' => 'Update Team',
            'show' => 'Show Team',
            'actions' => 'Actions',
            'no_records' => 'No Teams found.',
            'fill_required' => 'Please fill in all required fields to create a new Team.',
            'update_info' => 'Update the information for this Team.',
            'delete_confirm' => 'Are you sure you want to delete this Team?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'company_id' => 'Company Id',
                'is_active' => 'Is Active',
            ],
        ],
        'user' => [
            'title' => 'User',
            'title_plural' => 'Users',
            'management' => 'Users Management',
            'list' => 'Users List',
            'create' => 'Create User',
            'edit' => 'Edit User',
            'view' => 'View User',
            'delete' => 'Delete User',
            'add_new' => 'Add New User',
            'create_new' => 'Create New User',
            'update' => 'Update User',
            'show' => 'Show User',
            'actions' => 'Actions',
            'no_records' => 'No Users found.',
            'fill_required' => 'Please fill in all required fields to create a new User.',
            'update_info' => 'Update the information for this User.',
            'delete_confirm' => 'Are you sure you want to delete this User?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'company_id' => 'Company Id',
                'team_id' => 'Team Id',
                'is_active' => 'Is Active',
                'image' => 'Image',
                'email' => 'Email',
                'password' => 'Password',
                'phone' => 'Phone',
                'role' => 'Role',
            ],
            'select_role' => 'Select Role',
            'role_required' => 'Please select a role for the user.',
            'role_invalid' => 'The selected role is invalid.',
        ],
        'category' => [
            'title' => 'Category',
            'title_plural' => 'Categories',
            'management' => 'Categories Management',
            'list' => 'Categories List',
            'create' => 'Create Category',
            'edit' => 'Edit Category',
            'view' => 'View Category',
            'delete' => 'Delete Category',
            'add_new' => 'Add New Category',
            'create_new' => 'Create New Category',
            'update' => 'Update Category',
            'show' => 'Show Category',
            'actions' => 'Actions',
            'no_records' => 'No Categories found.',
            'fill_required' => 'Please fill in all required fields to create a new Category.',
            'update_info' => 'Update the information for this Category.',
            'delete_confirm' => 'Are you sure you want to delete this Category?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'company_id' => 'Company Id',
                'is_active' => 'Is Active',
            ],
        ],
        'district' => [
            'title' => 'District',
            'title_plural' => 'Districts',
            'management' => 'Districts Management',
            'list' => 'Districts List',
            'create' => 'Create District',
            'edit' => 'Edit District',
            'view' => 'View District',
            'delete' => 'Delete District',
            'add_new' => 'Add New District',
            'create_new' => 'Create New District',
            'update' => 'Update District',
            'show' => 'Show District',
            'actions' => 'Actions',
            'no_records' => 'No Districts found.',
            'fill_required' => 'Please fill in all required fields to create a new District.',
            'update_info' => 'Update the information for this District.',
            'delete_confirm' => 'Are you sure you want to delete this District?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'city_id' => 'City Id',
                'is_active' => 'Is Active',
            ],
        ],
        'branch' => [
            'title' => 'Branch',
            'title_plural' => 'Branches',
            'management' => 'Branches Management',
            'list' => 'Branches List',
            'create' => 'Create Branch',
            'edit' => 'Edit Branch',
            'view' => 'View Branch',
            'delete' => 'Delete Branch',
            'add_new' => 'Add New Branch',
            'create_new' => 'Create New Branch',
            'update' => 'Update Branch',
            'show' => 'Show Branch',
            'actions' => 'Actions',
            'no_records' => 'No Branches found.',
            'fill_required' => 'Please fill in all required fields to create a new Branch.',
            'update_info' => 'Update the information for this Branch.',
            'delete_confirm' => 'Are you sure you want to delete this Branch?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'city_id' => 'City Id',
                'is_active' => 'Is Active',
            ],
        ],
        'city' => [
            'title' => 'City',
            'title_plural' => 'Cities',
            'management' => 'Cities Management',
            'list' => 'Cities List',
            'create' => 'Create City',
            'edit' => 'Edit City',
            'view' => 'View City',
            'delete' => 'Delete City',
            'add_new' => 'Add New City',
            'create_new' => 'Create New City',
            'update' => 'Update City',
            'show' => 'Show City',
            'actions' => 'Actions',
            'no_records' => 'No Cities found.',
            'fill_required' => 'Please fill in all required fields to create a new City.',
            'update_info' => 'Update the information for this City.',
            'delete_confirm' => 'Are you sure you want to delete this City?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'is_active' => 'Is Active',
            ],
        ],
        'lead' => [
            'title' => 'Lead',
            'title_plural' => 'Leads',
            'management' => 'Leads Management',
            'list' => 'Leads List',
            'create' => 'Create Lead',
            'edit' => 'Edit Lead',
            'view' => 'View Lead',
            'delete' => 'Delete Lead',
            'add_new' => 'Add New Lead',
            'create_new' => 'Create New Lead',
            'update' => 'Update Lead',
            'show' => 'Show Lead',
            'actions' => 'Actions',
            'no_records' => 'No Leads found.',
            'fill_required' => 'Please fill in all required fields to create a new Lead.',
            'update_info' => 'Update the information for this Lead.',
            'delete_confirm' => 'Are you sure you want to delete this Lead?',
            'fields' => [
                'name' => 'Name',
                'phone' => 'Phone',
                'whatsapp_number' => 'Whatsapp Number',
                'email' => 'Email',
                'national_id' => 'National Id',
                'branch_id' => 'Branch Id',
                'city_id' => 'City Id',
                'district_id' => 'District Id',
                'location_link' => 'Location Link',
            ],
            'notes' => 'Notes',
            'first_meeting' => 'First Meeting',
            'field_visit' => 'Field Visit',
            'presentation_meeting' => 'Presentation Meeting',
            'signing_contract' => 'Signing The Contract',
            'import' => 'Import Leads',
            'import_success' => ':count leads imported successfully.',
            'import_partial_success' => ':count leads imported successfully. Some rows had errors.',
            'import_error' => 'Import failed',
        ],
        'source' => [
            'title' => 'Source',
            'title_plural' => 'Sources',
            'management' => 'Sources Management',
            'list' => 'Sources List',
            'create' => 'Create Source',
            'edit' => 'Edit Source',
            'view' => 'View Source',
            'delete' => 'Delete Source',
            'add_new' => 'Add New Source',
            'create_new' => 'Create New Source',
            'update' => 'Update Source',
            'show' => 'Show Source',
            'actions' => 'Actions',
            'no_records' => 'No Sources found.',
            'fill_required' => 'Please fill in all required fields to create a new Source.',
            'update_info' => 'Update the information for this Source.',
            'delete_confirm' => 'Are you sure you want to delete this Source?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'is_active' => 'Is Active',
            ],
        ],
        'product' => [
            'title' => 'Product',
            'title_plural' => 'Products',
            'management' => 'Products Management',
            'list' => 'Products List',
            'create' => 'Create Product',
            'edit' => 'Edit Product',
            'view' => 'View Product',
            'delete' => 'Delete Product',
            'add_new' => 'Add New Product',
            'create_new' => 'Create New Product',
            'update' => 'Update Product',
            'show' => 'Show Product',
            'actions' => 'Actions',
            'no_records' => 'No Products found.',
            'fill_required' => 'Please fill in all required fields to create a new Product.',
            'update_info' => 'Update the information for this Product.',
            'delete_confirm' => 'Are you sure you want to delete this Product?',
            'fields' => [
                'name_en' => 'Name En',
                'name_ar' => 'Name Ar',
                'desc_en' => 'Desc En',
                'desc_ar' => 'Desc Ar',
                'code' => 'Code',
                'image' => 'Image',
                'price' => 'Price',
            ],
        ],
    ];