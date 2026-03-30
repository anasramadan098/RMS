<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Messages - Success & Error Notifications
    |--------------------------------------------------------------------------
    */

    // Success Messages
    'success' => 'Success',
    'created' => ':item created successfully!',
    'updated' => ':item updated successfully!',
    'deleted' => ':item deleted successfully!',
    'saved' => ':item saved successfully!',
    'submitted' => ':item submitted successfully!',
    'published' => ':item published successfully!',
    'archived' => ':item archived successfully!',
    'restored' => ':item restored successfully!',
    
    // Specific Resource Messages
    'competitor_created' => 'Competitor created successfully!',
    'competitor_updated' => 'Competitor updated successfully!',
    'competitor_deleted' => 'Competitor deleted successfully!',
    
    'category_created' => 'Category created successfully!',
    'category_updated' => 'Category updated successfully!',
    'category_deleted' => 'Category deleted successfully!',
    
    'meal_created' => 'Meal created successfully!',
    'meal_updated' => 'Meal updated successfully!',
    'meal_deleted' => 'Meal deleted successfully!',
    
    'ingredient_created' => 'Ingredient created successfully!',
    'ingredient_updated' => 'Ingredient updated successfully!',
    'ingredient_deleted' => 'Ingredient deleted successfully!',
    
    'order_created' => 'Order created successfully!',
    'order_updated' => 'Order updated successfully!',
    'order_deleted' => 'Order deleted successfully!',
    'order_completed' => 'Order completed successfully!',
    
    'client_created' => 'Client created successfully!',
    'client_updated' => 'Client updated successfully!',
    'client_deleted' => 'Client deleted successfully!',
    
    'employee_created' => 'Employee created successfully!',
    'employee_updated' => 'Employee updated successfully!',
    'employee_deleted' => 'Employee deleted successfully!',
    
    'user_created' => 'User created successfully!',
    'user_updated' => 'User updated successfully!',
    'user_deleted' => 'User deleted successfully!',
    
    'project_created' => 'Project created successfully!',
    'project_updated' => 'Project updated successfully!',
    'project_deleted' => 'Project deleted successfully!',
    
    'booking_created' => 'Booking created successfully!',
    'booking_updated' => 'Booking updated successfully!',
    'booking_deleted' => 'Booking deleted successfully!',
    'booking_confirmed' => 'Booking confirmed successfully!',
    
    'supplier_created' => 'Supplier created successfully!',
    'supplier_updated' => 'Supplier updated successfully!',
    'supplier_deleted' => 'Supplier deleted successfully!',
    
    'cost_created' => 'Cost created successfully!',
    'cost_updated' => 'Cost updated successfully!',
    'cost_deleted' => 'Cost deleted successfully!',
    
    'task_created' => 'Task created successfully!',
    'task_updated' => 'Task updated successfully!',
    'task_deleted' => 'Task deleted successfully!',
    'task_completed' => 'Task completed successfully!',
    
    'feedback_submitted' => 'Feedback submitted successfully!',
    'feedback_updated' => 'Feedback updated successfully!',
    'feedback_deleted' => 'Feedback deleted successfully!',
    
    'ad_created' => 'Advertisement created successfully!',
    'ad_updated' => 'Advertisement updated successfully!',
    'ad_deleted' => 'Advertisement deleted successfully!',
    
    'bill_created' => 'Bill created successfully!',
    'bill_updated' => 'Bill updated successfully!',
    'bill_deleted' => 'Bill deleted successfully!',
    
    'attendance_marked' => 'Attendance marked successfully!',
    'salary_report_generated' => 'Salary report generated successfully!',
    
    'settings_saved' => 'Settings saved successfully!',
    'profile_updated' => 'Profile updated successfully!',
    'password_changed' => 'Password changed successfully!',
    
    // Error Messages
    'error' => 'Error',
    'not_found' => ':item not found.',
    'already_exists' => ':item already exists.',
    'invalid_data' => 'Invalid data provided.',
    'permission_denied' => 'Permission denied.',
    'unauthorized' => 'Unauthorized access.',
    'forbidden' => 'Access forbidden.',
    
    'create_failed' => 'Failed to create :item. Please try again.',
    'update_failed' => 'Failed to update :item. Please try again.',
    'delete_failed' => 'Failed to delete :item. Please try again.',
    'save_failed' => 'Failed to save :item. Please try again.',
    
    'validation_error' => 'Please check the form for errors.',
    'server_error' => 'An error occurred. Please try again later.',
    'network_error' => 'Network error. Please check your connection.',
    'timeout_error' => 'Request timeout. Please try again.',
    
    // Confirmation Messages
    'confirm_delete' => 'Are you sure you want to delete this :item?',
    'confirm_action' => 'Are you sure you want to perform this action?',
    'confirm_cancel' => 'Are you sure you want to cancel?',
    'confirm_discard' => 'Are you sure you want to discard changes?',
    
    // Warning Messages
    'warning' => 'Warning',
    'low_stock' => 'Low stock alert for :item.',
    'out_of_stock' => ':item is out of stock.',
    'expiring_soon' => ':item will expire soon.',
    'overdue' => ':item is overdue.',
    
    // Info Messages
    'info' => 'Information',
    'no_results' => 'No results found.',
    'no_data_available' => 'No data available.',
    'maintenance_mode' => 'System is under maintenance. Please try again later.',
    'demo_mode' => 'This feature is disabled in demo mode.',
    
    // Authentication Messages
    'login_success' => 'Logged in successfully!',
    'logout_success' => 'Logged out successfully!',
    'registration_success' => 'Registration successful!',
    'password_reset_sent' => 'Password reset link sent to your email.',
    'password_reset_success' => 'Password reset successfully!',
    'email_verified' => 'Email verified successfully!',
    'account_activated' => 'Account activated successfully!',
    'account_deactivated' => 'Account deactivated.',
    
    // File Upload Messages
    'file_uploaded' => 'File uploaded successfully!',
    'file_too_large' => 'File is too large. Maximum size is :max MB.',
    'invalid_file_type' => 'Invalid file type. Allowed types: :types.',
    'upload_failed' => 'File upload failed. Please try again.',
    'file_deleted' => 'File deleted successfully!',
    
    // Payment Messages
    'payment_success' => 'Payment processed successfully!',
    'payment_failed' => 'Payment failed. Please try again.',
    'refund_processed' => 'Refund processed successfully!',
    'invoice_generated' => 'Invoice generated successfully!',
    
    // Notification Messages
    'notification_sent' => 'Notification sent successfully!',
    'email_sent' => 'Email sent successfully!',
    'sms_sent' => 'SMS sent successfully!',
    'whatsapp_sent' => 'WhatsApp message sent successfully!',
    
    // Import/Export Messages
    'import_success' => 'Data imported successfully!',
    'export_success' => 'Data exported successfully!',
    'import_failed' => 'Import failed. Please check your file.',
    'export_failed' => 'Export failed. Please try again.',
    
    // Cache Messages
    'cache_cleared' => 'Cache cleared successfully!',
    'cache_refreshed' => 'Cache refreshed successfully!',
    
];
