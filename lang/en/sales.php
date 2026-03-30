<?php

return [
    // General
    'sales' => 'Sales',
    'sale' => 'Sale',
    'sales_management' => 'Sales Management',
    'sales_list' => 'Sales List',
    'sale_details' => 'Sale Details',
    'add_sale' => 'Add Sale',
    'edit_sale' => 'Edit Sale',
    'create_sale' => 'Create Sale',
    'update_sale' => 'Update Sale',
    'delete_sale' => 'Delete Sale',
    'view_sale' => 'View Sale',
    'select_payment_method' => 'Select Payment Method',
    'select_status' => 'Select Status',
    'sale_information' => 'Sale Information',
    'sale_history' => 'Sale History',
    'sales_statistics' => 'Sales Statistics',


    'sales_overview' => 'Sales Overview',
    'monthly_growth' => 'Monthly Growth',
    'revenue_distribution' => 'Revenue Distribution',
    'monthly_sales' => 'Monthyly Sales',
    'sales_vs_costs' => 'Sales Vs Costs',
    'sales_funnel' => 'Sales Funnel' ,
    

    // Fields
    'invoice_number' => 'Invoice Number',
    'sale_date' => 'Sale Date',
    'client' => 'Client',
    'client_name' => 'Client Name',
    'products' => 'Products',
    'quantity' => 'Quantity',
    'unit_price' => 'Unit Price',
    'total_amount' => 'Total Amount',
    'subtotal' => 'Subtotal',
    'tax' => 'Tax',
    'discount' => 'Discount',
    'grand_total' => 'Grand Total',
    'payment_method' => 'Payment Method',
    'payment_status' => 'Payment Status',
    'payment_date' => 'Payment Date',
    'due_date' => 'Due Date',
    'notes' => 'Notes',
    'salesperson' => 'Salesperson',
    'commission' => 'Commission',
    'profit' => 'Profit',
    'cost' => 'Cost',
    'margin' => 'Margin',

    // Payment Methods
    'payment_methods' => [
        'cash' => 'Cash',
        'credit_card' => 'Credit Card',
        'debit_card' => 'Debit Card',
        'bank_transfer' => 'Bank Transfer',
        'check' => 'Check',
        'online' => 'Online Payment',
        'installment' => 'Installment',
    ],

    // Payment Status
    'payment_statuses' => [
        'paid' => 'Paid',
        'unpaid' => 'Unpaid',
        'partial' => 'Partially Paid',
        'overdue' => 'Overdue',
        'refunded' => 'Refunded',
        'cancelled' => 'Cancelled',
    ],

    // Sale Status
    'sale_statuses' => [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'returned' => 'Returned',
    ],

    // Actions
    'add_new_sale' => 'Add New Sale',
    'edit_sale_info' => 'Edit Sale Information',
    'delete_sale_confirm' => 'Are you sure you want to delete this sale?',
    'view_sale_details' => 'View Sale Details',
    'print_invoice' => 'Print Invoice',
    'send_invoice' => 'Send Invoice',
    'export_sales' => 'Export Sales',
    'import_sales' => 'Import Sales',
    'mark_as_paid' => 'Mark as Paid',
    'mark_as_delivered' => 'Mark as Delivered',
    'process_refund' => 'Process Refund',
    'add_product' => 'Add Product',
    'remove_product' => 'Remove Product',

    // Messages
    'sale_created' => 'Sale has been created successfully.',
    'sale_updated' => 'Sale has been updated successfully.',
    'sale_deleted' => 'Sale has been deleted successfully.',
    'sale_not_found' => 'Sale not found.',
    'no_sales_found' => 'No sales found.',
    'sales_exported' => 'Sales have been exported successfully.',
    'sales_imported' => 'Sales have been imported successfully.',
    'invoice_sent' => 'Invoice has been sent successfully.',
    'payment_recorded' => 'Payment has been recorded successfully.',
    'refund_processed' => 'Refund has been processed successfully.',

    // Validation
    'client_required' => 'Client is required.',
    'products_required' => 'At least one product is required.',
    'quantity_required' => 'Product quantity is required.',
    'quantity_numeric' => 'Product quantity must be a number.',
    'price_required' => 'Product price is required.',
    'price_numeric' => 'Product price must be a number.',
    'payment_method_required' => 'Payment method is required.',
    'sale_date_required' => 'Sale date is required.',

    // Statistics
    'total_sales' => 'Total Sales',
    'total_revenue' => 'Total Revenue',
    'total_profit' => 'Total Profit',
    'average_sale_value' => 'Average Sale Value',
    'sales_this_month' => 'Sales This Month',
    'sales_this_year' => 'Sales This Year',
    'top_selling_products' => 'Top Selling Products',
    'top_clients' => 'Top Clients',
    'sales_by_payment_method' => 'Sales by Payment Method',
    'monthly_sales_trend' => 'Monthly Sales Trend',
    'daily_sales' => 'Daily Sales',
    'pending_payments' => 'Pending Payments',

    // Filters
    'filter_by_client' => 'Filter by Client',
    'filter_by_date_range' => 'Filter by Date Range',
    'filter_by_payment_status' => 'Filter by Payment Status',
    'filter_by_sale_status' => 'Filter by Sale Status',
    'filter_by_payment_method' => 'Filter by Payment Method',
    'filter_by_salesperson' => 'Filter by Salesperson',
    'search_sales' => 'Search Sales',
    'search_by_invoice' => 'Search by invoice number',

    // Table Headers
    'table' => [
        'id' => 'ID',
        'invoice_number' => 'Invoice #',
        'client' => 'Client',
        'sale_date' => 'Sale Date',
        'total_amount' => 'Total Amount',
        'payment_status' => 'Payment Status',
        'sale_status' => 'Sale Status',
        'salesperson' => 'Salesperson',
        'actions' => 'Actions',
    ],

    // Form Labels
    'form' => [
        'sale_information' => 'Sale Information',
        'client_information' => 'Client Information',
        'products_services' => 'Products & Services',
        'payment_information' => 'Payment Information',
        'additional_information' => 'Additional Information',
        'select_client' => 'Select Client',
        'select_product' => 'Select Product',
        'add_new_client' => 'Add New Client',
    ],

    // Invoice
    'invoice' => [
        'invoice' => 'Invoice',
        'invoice_number' => 'Invoice Number',
        'invoice_date' => 'Invoice Date',
        'due_date' => 'Due Date',
        'bill_to' => 'Bill To',
        'ship_to' => 'Ship To',
        'item' => 'Item',
        'description' => 'Description',
        'qty' => 'Qty',
        'rate' => 'Rate',
        'amount' => 'Amount',
        'subtotal' => 'Subtotal',
        'tax' => 'Tax',
        'discount' => 'Discount',
        'total' => 'Total',
        'payment_terms' => 'Payment Terms',
        'notes' => 'Notes',
        'thank_you' => 'Thank you for your business!',
    ],

    // Reports
    'reports' => [
        'sales_report' => 'Sales Report',
        'revenue_report' => 'Revenue Report',
        'profit_report' => 'Profit Report',
        'client_sales_report' => 'Client Sales Report',
        'product_sales_report' => 'Product Sales Report',
        'salesperson_report' => 'Salesperson Report',
        'payment_report' => 'Payment Report',
    ],

    // Additional
    'sale_items' => 'Sale Items',
    'total_price' => 'Total Price',
    'create_bill' => 'Create Bill',
    'back_to_sales_list' => 'Back to Sales List',

    // Placeholders
    'placeholders' => [
        'select_client' => 'Select a client',
        'select_product' => 'Select a product',
        'enter_quantity' => 'Enter quantity',
        'enter_price' => 'Enter price',
        'enter_notes' => 'Enter notes',
        'search_sales' => 'Search sales...',
    ],
];
