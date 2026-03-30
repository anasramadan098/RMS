<?php

return [
    // General
    'suppliers' => 'Suppliers',
    'supplier' => 'Supplier',
    'supplier_management' => 'Supplier Management',
    'supplier_list' => 'Supplier List',
    'supplier_details' => 'Supplier Details',
    'add_supplier' => 'Add Supplier',
    'edit_supplier' => 'Edit Supplier',
    'create_supplier' => 'Create Supplier',
    'update_supplier' => 'Update Supplier',
    'delete_supplier' => 'Delete Supplier',
    'view_supplier' => 'View Supplier',
    'supplier_information' => 'Supplier Information',
    'supplier_history' => 'Supplier History',
    'supplier_statistics' => 'Supplier Statistics',

    // Fields
    'supplier_name' => 'Supplier Name',
    'company_name' => 'Company Name',
    'contact_person' => 'Contact Number',
    'email' => 'Email',
    'phone' => 'Phone',
    'mobile' => 'Mobile',
    'fax' => 'Fax',
    'website' => 'Website',
    'address' => 'Address',
    'city' => 'City',
    'state' => 'State',
    'country' => 'Country',
    'postal_code' => 'Postal Code',
    'tax_number' => 'Tax Number',
    'registration_number' => 'Registration Number',
    'bank_name' => 'Bank Name',
    'bank_account' => 'Bank Account',
    'payment_terms' => 'Payment Terms',
    'credit_limit' => 'Credit Limit',
    'discount_rate' => 'Discount Rate',
    'category' => 'Category',
    'status' => 'Status',
    'is_active' => 'Is Active',
    'notes' => 'Notes',
    'logo' => 'Logo',
    'rating' => 'Rating',
    'established_date' => 'Established Date',

    // Categories
    'categories' => [
        'raw_materials' => 'Raw Materials',
        'equipment' => 'Equipment',
        'services' => 'Services',
        'technology' => 'Technology',
        'logistics' => 'Logistics',
        'maintenance' => 'Maintenance',
        'consulting' => 'Consulting',
        'other' => 'Other',
    ],

    // Status
    'statuses' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
        'suspended' => 'Suspended',
        'blacklisted' => 'Blacklisted',
    ],

    // Payment Terms
    'payment_terms_options' => [
        'net_30' => 'Net 30 Days',
        'net_60' => 'Net 60 Days',
        'net_90' => 'Net 90 Days',
        'cash_on_delivery' => 'Cash on Delivery',
        'advance_payment' => 'Advance Payment',
        'credit' => 'Credit',
    ],

    // Actions
    'add_new_supplier' => 'Add New Supplier',
    'edit_supplier_info' => 'Edit Supplier Information',
    'delete_supplier_confirm' => 'Are you sure you want to delete this supplier?',
    'view_supplier_details' => 'View Supplier Details',
    'export_suppliers' => 'Export Suppliers',
    'import_suppliers' => 'Import Suppliers',
    'contact_supplier' => 'Contact Supplier',
    'view_products' => 'View Products',
    'view_orders' => 'View Orders',
    'view_invoices' => 'View Invoices',
    'rate_supplier' => 'Rate Supplier',

    // Messages
    'supplier_created' => 'Supplier has been created successfully.',
    'supplier_updated' => 'Supplier has been updated successfully.',
    'supplier_deleted' => 'Supplier has been deleted successfully.',
    'cannot_delete_supplier_has_ingredients' => 'Cannot delete this supplier because it has :count ingredient(s) associated. Please delete the ingredients first.',
    'error_deleting_supplier' => 'An error occurred while deleting the supplier. Please try again.',
    'supplier_not_found' => 'Supplier not found.',
    'no_suppliers_found' => 'No suppliers found.',
    'suppliers_exported' => 'Suppliers have been exported successfully.',
    'suppliers_imported' => 'Suppliers have been imported successfully.',
    'contact_sent' => 'Contact message has been sent successfully.',

    // Validation
    'supplier_name_required' => 'Supplier name is required.',
    'company_name_required' => 'Company name is required.',
    'email_required' => 'Email address is required.',
    'email_valid' => 'Please enter a valid email address.',
    'email_unique' => 'This email address is already registered.',
    'phone_required' => 'Phone number is required.',
    'phone_valid' => 'Please enter a valid phone number.',
    'address_required' => 'Address is required.',

    // Statistics
    'total_suppliers' => 'Total Suppliers',
    'active_suppliers' => 'Active Suppliers',
    'new_suppliers_this_month' => 'New Suppliers This Month',
    'top_suppliers' => 'Top Suppliers',
    'supplier_performance' => 'Supplier Performance',
    'average_rating' => 'Average Rating',
    'total_orders' => 'Total Orders',
    'total_amount' => 'Total Amount',

    // Filters
    'filter_by_status' => 'Filter by Status',
    'filter_by_category' => 'Filter by Category',
    'filter_by_city' => 'Filter by City',
    'filter_by_country' => 'Filter by Country',
    'filter_by_rating' => 'Filter by Rating',
    'search_suppliers' => 'Search Suppliers',
    'search_by_name_company' => 'Search by name or company',

    // Table Headers
    'table' => [
        'id' => 'ID',
        'logo' => 'Logo',
        'supplier_name' => 'Supplier Name',
        'company_name' => 'Company Name',
        'contact_person' => 'Contact Person',
        'email' => 'Email',
        'phone' => 'Phone',
        'city' => 'City',
        'status' => 'Status',
        'rating' => 'Rating',
        'created_at' => 'Created Date',
        'update_supplier' => 'Update Supplier',
        'actions' => 'Actions',
    ],

    // Form Labels
    'form' => [
        'basic_information' => 'Basic Information',
        'contact_information' => 'Contact Information',
        'address_information' => 'Address Information',
        'business_information' => 'Business Information',
        'financial_information' => 'Financial Information',
        'additional_information' => 'Additional Information',
        'upload_logo' => 'Upload Logo',
        'change_logo' => 'Change Logo',
        'remove_logo' => 'Remove Logo',
        'select_supplier' => 'Select Supplier',
    ],

    // Performance
    'performance' => [
        'delivery_time' => 'Delivery Time',
        'quality_rating' => 'Quality Rating',
        'service_rating' => 'Service Rating',
        'price_competitiveness' => 'Price Competitiveness',
        'reliability' => 'Reliability',
        'communication' => 'Communication',
        'overall_rating' => 'Overall Rating',
    ],

    // Reports
    'reports' => [
        'supplier_report' => 'Supplier Report',
        'performance_report' => 'Performance Report',
        'order_history_report' => 'Order History Report',
        'payment_report' => 'Payment Report',
        'supplier_analysis' => 'Supplier Analysis',
    ],

    // Placeholders
    'placeholders' => [
        'enter_supplier_name' => 'Enter supplier name',
        'enter_company_name' => 'Enter company name',
        'enter_contact_person' => 'Enter contact person name',
        'enter_email' => 'Enter email address',
        'enter_phone' => 'Enter phone number',
        'enter_address' => 'Enter address',
        'enter_city' => 'Enter city',
        'enter_notes' => 'Enter notes about the supplier',
        'search_suppliers' => 'Search suppliers...',
    ],
];
