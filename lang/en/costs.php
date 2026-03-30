<?php

return [
    // General
    'costs' => 'Costs',
    'cost' => 'Cost',
    'cost_management' => 'Cost Management',
    'cost_list' => 'Cost List',
    'cost_details' => 'Cost Details',
    'add_cost' => 'Add Cost',
    'edit_cost' => 'Edit Cost',
    'create_cost' => 'Create Cost',
    'update_cost' => 'Update Cost',
    'delete_cost' => 'Delete Cost',
    'view_cost' => 'View Cost',
    'cost_information' => 'Cost Information',
    'cost_history' => 'Cost History',
    'cost_statistics' => 'Cost Statistics',
    
    'create_new_cost' => 'Create New Cost',

    // Fields
    'name' => 'Cost Name',
    'description' => 'Description',
    'amount' => 'Amount',
    'cost_type' => 'Cost Type',
    'category' => 'Category',
    'date' => 'Date',
    'due_date' => 'Due Date',
    'payment_date' => 'Payment Date',
    'payment_method' => 'Payment Method',
    'payment_status' => 'Payment Status',
    'supplier' => 'Supplier',
    'project' => 'Project',
    'department' => 'Department',
    'employee' => 'Employee',
    'notes' => 'Notes',
    'receipt' => 'Receipt',
    'invoice_number' => 'Invoice Number',
    'reference' => 'Reference',
    'tax_amount' => 'Tax Amount',
    'total_amount' => 'Total Amount',
    'currency' => 'Currency',

    // Cost Types
    'cost_types' => [
        'operational' => 'Operational',
        'administrative' => 'Administrative',
        'marketing' => 'Marketing',
        'equipment' => 'Equipment',
        'maintenance' => 'Maintenance',
        'utilities' => 'Utilities',
        'rent' => 'Rent',
        'salaries' => 'Salaries',
        'travel' => 'Travel',
        'supplies' => 'Supplies',
        'other' => 'Other',
    ],

    // Payment Methods
    'payment_methods' => [
        'cash' => 'Cash',
        'credit_card' => 'Credit Card',
        'debit_card' => 'Debit Card',
        'bank_transfer' => 'Bank Transfer',
        'check' => 'Check',
        'online' => 'Online Payment',
    ],

    // Payment Status
    'payment_statuses' => [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
        'partial' => 'Partially Paid',
        'overdue' => 'Overdue',
        'cancelled' => 'Cancelled',
    ],

    // Actions
    'add_new_cost' => 'Add New Cost',
    'edit_cost_info' => 'Edit Cost Information',
    'delete_cost_confirm' => 'Are you sure you want to delete this cost?',
    'view_cost_details' => 'View Cost Details',
    'export_costs' => 'Export Costs',
    'import_costs' => 'Import Costs',
    'mark_as_paid' => 'Mark as Paid',
    'upload_receipt' => 'Upload Receipt',
    'download_receipt' => 'Download Receipt',

    // Messages
    'cost_created' => 'Cost has been created successfully.',
    'cost_updated' => 'Cost has been updated successfully.',
    'cost_deleted' => 'Cost has been deleted successfully.',
    'cost_not_found' => 'Cost not found.',
    'no_costs_found' => 'No costs found.',
    'costs_exported' => 'Costs have been exported successfully.',
    'costs_imported' => 'Costs have been imported successfully.',
    'payment_recorded' => 'Payment has been recorded successfully.',
    'receipt_uploaded' => 'Receipt has been uploaded successfully.',

    // Validation
    'name_required' => 'Cost name is required.',
    'amount_required' => 'Cost amount is required.',
    'amount_numeric' => 'Cost amount must be a number.',
    'date_required' => 'Cost date is required.',
    'cost_type_required' => 'Cost type is required.',
    'payment_method_required' => 'Payment method is required.',

    // Statistics
    'total_costs' => 'Total Costs',
    'monthly_costs' => 'Monthly Costs',
    'yearly_costs' => 'Yearly Costs',
    'average_cost' => 'Average Cost',
    'costs_this_month' => 'Costs This Month',
    'costs_this_year' => 'Costs This Year',
    'costs_by_category' => 'Costs by Category',
    'costs_by_department' => 'Costs by Department',
    'pending_payments' => 'Pending Payments',
    'overdue_payments' => 'Overdue Payments',

    // Filters
    'filter_by_type' => 'Filter by Type',
    'filter_by_category' => 'Filter by Category',
    'filter_by_date_range' => 'Filter by Date Range',
    'filter_by_payment_status' => 'Filter by Payment Status',
    'filter_by_department' => 'Filter by Department',
    'search_costs' => 'Search Costs',
    'search_by_name' => 'Search by name or description',

    // Table Headers
    'table' => [
        'id' => 'ID',
        'name' => 'Name',
        'amount' => 'Amount',
        'type' => 'Type',
        'category' => 'Category',
        'date' => 'Date',
        'payment_status' => 'Payment Status',
        'employee' => 'Employee',
        'actions' => 'Actions',
        'created_at' => 'Created Date',
    ],

    // Form Labels
    'form' => [
        'cost_information' => 'Cost Information',
        'payment_information' => 'Payment Information',
        'additional_information' => 'Additional Information',
        'receipt_attachment' => 'Receipt Attachment',
        'select_type' => 'Select Type',
        'select_category' => 'Select Category',
        'select_department' => 'Select Department',
        'select_employee' => 'Select Employee',
    ],

    // Reports
    'reports' => [
        'cost_report' => 'Cost Report',
        'expense_report' => 'Expense Report',
        'department_cost_report' => 'Department Cost Report',
        'monthly_cost_report' => 'Monthly Cost Report',
        'cost_analysis' => 'Cost Analysis',
    ],

    // Placeholders
    'placeholders' => [
        'enter_cost_name' => 'Enter cost name',
        'enter_description' => 'Enter description',
        'enter_amount' => 'Enter amount',
        'select_date' => 'Select date',
        'enter_notes' => 'Enter notes',
        'search_costs' => 'Search costs...',
    ],
];
